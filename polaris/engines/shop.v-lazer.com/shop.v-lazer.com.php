<?php
/**
 * shop.v-lazer.com
 */
switch (EXTRA_PARAM) {
	case 'vladivostok':
		$region = '';
		break;
	case 'habarovsk':
		$region = 'khb.';
		break;
	case 'blagoveschensk':
		$region = 'blg.';
		break;	
	default:
		die('Unknown region');
		break;
}

$bad_urls = array();
/*if (file_exists('/var/www/'.ENGINE_TYPE.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.data')) {
  $itemsArray = unserialize(file_get_contents('/var/www/'.ENGINE_TYPE.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.data'));
  echo "Today .data file\n";
} else {
	$itemsArray = array();	
	echo "New .data file\n";
//}
*/

switch (ENGINE_TYPE) {
	case 'polaris':
		$urlarray = array(
			'http://'.$region.'shop.v-lazer.com/catalog/~/search/?query=polaris',
			'http://'.$region.'shop.v-lazer.com/catalog/~/search/page-2/?query=polaris',
			'http://'.$region.'shop.v-lazer.com/catalog/~/search/page-3/?query=polaris',
			'http://'.$region.'shop.v-lazer.com/catalog/~/search/page-4/?query=polaris',
			);
		break;
	default:
		die('Unknown region');
		break;
}

foreach ($urlarray as $url) {
	$i = 1;
	while ( regular_one($url)<1 && $i<6 ) {
		$i++;
	}
}

file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';

function regular_one($url) {
	global $itemsArray;
	global $region;

	$proxy_array = glob('/var/www/lib/proxies/*.proxy');

	$alive_proxy_list = '';
	foreach ($proxy_array as $key) {
		$alive_proxy_list .= file_get_contents($key);
		$alive_proxy_list .= "\n";
	}
	$alive_proxy_list = trim($alive_proxy_list);
	$proxy_list 		= explode("\n", $alive_proxy_list);
	$useragent_list = explode("\n", file_get_contents( '/var/www/lib/useragents_short.txt' ));
	array_walk($proxy_list, 'trim_value');
	array_walk($useragent_list, 'trim_value');

	//$regPagin1 = "~pageline opensans(.+)</ul~isU";
	//$regPagin2 = "~<a.*>(.+)<~isU";
	$regexpPrices  = "~class=\"cell opensans(.+)class=\"availablelist\"~isU";
	$regexpPrices2 = "~class=\"name\".*href=\"(.+)\".*>(.+)<.*class=\"price.*<li.*>(.+)<~isU";	// Все товары на странице
	$regexpPrices3 = "~class=\"name\".*href=\"(.+)\".*>(.+)<~isU";	// Все товары на странице

	$regexpPricesNoA = "~class=\"cell opensans noavailable(.+)</ul~isU";

		$useragent_index = mt_rand(0, count($useragent_list)-1);
		$useragent = $useragent_list[$useragent_index];
	  $proxy_auth = $proxy_list[ mt_rand(0, count($proxy_list)-1) ];
	  preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	  if (!$matches_proxy) {
	   	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	  }
		$proxy = $matches_proxy[1].':'.$matches_proxy[2];	
		$auth  = $matches_proxy[3].':'.$matches_proxy[4]; 
		//$proxy = '92.63.99.89:443';
		//$auth  = 'WpSsZQwpb:xvAjhczlf';
	
		sleep(1);
		
		$cookie = '/var/www/js/engines/shop.v-lazer.com/cookies/'.$useragent_index.'_'.str_replace(':', '_', $proxy).'.cook'; // cookies
		echo "\n\n";
		echo "/*--------------------------------------*/\n";
		echo $proxy."\n";
		echo $url."\n";
		echo $auth."\n";
		//echo $cookie."\n";
		
		//$useragent = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:41.0) Gecko/20100101 Firefox/41.0';
		echo $useragent."\n";
		$proxyArr = explode(':', $proxy);
		$authArr = explode(':', $auth);  
		//$cmd = 'timeout -k 45s 50s /var/www/lib/phantomjs/bin/phantomjs --cookies-file='.$cookie.' --proxy='.$proxy.' --proxy-auth='.$auth.' /var/www/js/engines/shop.v-lazer.com/shop.v-lazer.com.js '.escapeshellarg($url).' '.escapeshellarg($useragent);
		$cmd = 'timeout -k 25s 26s casperjs /var/www/polaris/engines/shop.v-lazer.com/casper.js '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$proxyArr[0].' '.$proxyArr[1].' '.$authArr[0].' '.$authArr[1].' --cookies-file='.$cookie;

	/*
			$proxyArr = explode(':', $proxy);
			$authArr = explode(':', $auth);    
			$cmd = 'timeout -k 45s 50s casperjs /var/www/js/engines/shop.v-lazer.com/html.js '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$proxyArr[0].' '.$proxyArr[1].' '.$authArr[0].' '.$authArr[1].' --cookies-file='.$cookie;
	*/

		$phantomjs = exec("$cmd 2>&1", $out, $err);
		// Режем данные, сохраняем в массив
		$response = stripcslashes($phantomjs);
		//echo $response;
		if ($response) {
			preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER);
			foreach ($matches2 as $key) {		
				preg_match($regexpPrices2, $key[1], $matches); // Исследуем каждую карточку в отдельности
				//print_r($matches);
				if ($matches[3]) {
		 			$itemsArray['http://'.$region.'shop.v-lazer.com' . trim($matches[1])] = array($matches[2],  preg_replace('~[^\d.]+~', '' , $matches[3]), $proxy, $useragent, $url);
					echo trim($matches[2]).' | '.preg_replace('~[^\d.]+~', '' , $matches[3]).PHP_EOL;
				} else {
					preg_match($regexpPrices3, $key[1], $matches);
					if ($matches[1]) {					
						$matches[2] = str_replace(';', ' ', $matches[2]);
						$itemsArray['http://'.$region.'shop.v-lazer.com' . trim($matches[1])] = array($matches[2], '0', $proxy, $useragent, $url);
						echo trim($matches[2]).' | 0'.PHP_EOL;						
					}
				}
			} 

			preg_match_all($regexpPricesNoA, $response, $matches2, PREG_SET_ORDER);
			foreach ($matches2 as $key) {		
				preg_match($regexpPrices3, $key[1], $matches);
				if ($matches[1]) {					
					$matches[2] = str_replace(';', ' ', $matches[2]);
					$itemsArray['http://'.$region.'shop.v-lazer.com' . trim($matches[1])] = array($matches[2], '0', $proxy, $useragent, $url);
					echo trim($matches[2]).' | 0'.PHP_EOL;						
				}
			}			

			return 1;		
		} else {
	  	//mail('alexandr.volkoff@gmail.com', 'poiskhome.ru problem', 'Проблема с регионом: '.$zone.' не совпадает с тем, что на странице: '.trim($mregion[1]));
	  	echo 'bad response'.PHP_EOL;
	  	return 0;	
		}
}
