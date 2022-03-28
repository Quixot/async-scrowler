<?php
/**
 * rbt.ru
 */
setlocale(LC_ALL, 'ru_RU.UTF-8');
unset($AC);
$bad_urls = array();
switch (EXTRA_PARAM) {
	case 'chelyabinsk': $region = '15'; 				$domain = 'www.'; 								break;	//	Челябинск
	case 'kazan': $region = '1'; 								$domain = 'kazan.'; 							break;	//	Казань
	case 'krasnoyarsk': $region = '6'; 					$domain = 'kras.'; 								break;	//	Красноярск
	case 'moscow': $region = '2'; 							$domain = 'msk.'; 								break;	//	Москва
	case 'naberezhnye-chelny': $region = '67'; 	$domain = 'naberezhnye-chelny.'; 	break;	//	Набережные челны
	case 'novosibirsk': $region = '10'; 				$domain = 'novosib.'; 						break;	//	Новосибирск
	case 'omsk': $region = '11'; 								$domain = 'omsk.'; 								break;	//	Омск
	case 'ufa': $region = '16'; 								$domain = 'ufa.'; 								break;	//	Уфа
	case 'vladivostok': $region = '67'; 				$domain = 'vladivostok.'; 				break;	//	Владивосток
	case 'yekaterinburg': $region = '108'; 			$domain = 'ekat.'; 								break;	//	Екатеринбург
 	default:
 		die("Unknown region\n"); 		
}

$reg1 = "~schema.org/Product(.+)itemprop=\"priceCurrency~isU";
$reg2 = "~itemprop=\"name\".*<a.*href=\"(.+)\".*>.*>(.+)<.*class=\"price__row price__row_current.*>(.+)<~isU";

$i = 1;
while ( regular_one($url)<1 && $i<2 ) {
	echo 'Попытка '.$i.' из 2';
	$i++;
}



/** 
 *              Callback Functions           
 */
function regular_one($url) {
	global $reg1;
	global $reg2;
	global $itemsArray;
	global $region;
	global $pagin;
	global $domain;

	$proxy_array = glob('/var/www/lib/proxies/2.proxy');
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

	/**
	 * Блок выбора прокси
	 */
		$useragent_index = mt_rand(0, count($useragent_list)-1);
		$useragent = $useragent_list[$useragent_index];
	  $proxy_auth = $proxy_list[ mt_rand(0, count($proxy_list)-1) ];
	  preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	  if (!$matches_proxy) {
	   	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	  }
	/**
	 * Блок выбора прокси
	 */
	$url = 'https://'.$domain.'rbt.ru/search/?q='.ENGINE_TYPE;
	//$cmd = 'timeout -k 90s 91s casperjs /var/www/engines/rbt.ru/magic.js '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4].' '.$region.' '.$pagin.' '.ENGINE_TYPE. ' '.$domain;
	$cmd = 'timeout -k 300s 301s casperjs /var/www/polaris/engines/rbt.ru/magic.js  --ignore-ssl-errors=true --ssl-protocol=any '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4].' '."'".EXTRA_PARAM."'".' '."'".EXTRA_PARAM."'"; //timeout -k 150s 151s 
	echo 'request: '.$cmd.PHP_EOL;
	$response = exec($cmd, $out, $err);
	
	//echo substr($response, 0,500);
	//print_r($response);

	file_put_contents('/var/www/polaris/engines/rbt.ru/content/'.EXTRA_PARAM.'.txt', $response);
	//die();
	if (strlen($response) > 100) {
		echo PHP_EOL.'response ok'.PHP_EOL;
		$response = stripcslashes($response);

		preg_match("~/region/regionSelectHtml/.*>.*>(.+)<~isU", $response, $region);
		echo 'request  region: '.EXTRA_PARAM.PHP_EOL;
		echo 'response region: '.@$region[1].PHP_EOL;

	  preg_match_all($reg1, $response, $matches2, PREG_SET_ORDER); //
	  //print_r($matches2);
	  foreach ($matches2 as $key => $value) {
			preg_match($reg2, $value[0], $matches);
			//print_r($matches);
			if (@$matches[1] && $matches[2]) {
				$matches[1] = 'https://'.$domain.'rbt.ru'.trim($matches[1]);
				//$matches[3] = iconv('windows-1251', 'utf-8', $matches[3]);
				$matches[2] = strip_tags($matches[2]);
				$matches[2] = html_entity_decode(trim($matches[2]));
				$matches[3] = preg_replace('~[^\d.]+~', '' , $matches[3]);
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], $useragent, ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2]);
				echo $matches[1].' | '.$matches[2].' | '.$matches[3].PHP_EOL;
			}
		}
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}
