<?php
/**
 * rbt.ru
 */
/*
setlocale(LC_ALL, 'ru_RU.UTF-8');
unset($AC);
$bad_urls = array();
switch (EXTRA_PARAM) {
	case 'abakan': $region = '1'; 				$domain = 'www.'; 	break;	//	Абакан
	case 'achinsk': $region = '2'; 				$domain = 'www.'; 	break;	//	Ачинск
	case 'barnaul': $region = '67'; 			$domain = 'www.'; 	break;	//	Барнаул
	case 'biysk': $region = '108'; 				$domain = 'www.'; 	break;	//	Бийск
	case 'yekaterinburg': $region = '3'; 	$domain = 'www.'; 	break;	//	Екатеринбург
	case 'kemerovo': $region = '109';			$domain = 'www.'; 	break;	//	Кемерово
	case 'krasnoyarsk': $region = '6'; 		$domain = 'kras.'; 	break;	//	Красноярск
	case 'kurgan': $region = '39'; 				$domain = 'www.'; 	break;	//	Курган
	case 'magnitogorsk': $region = '7'; 	$domain = 'www.'; 	break;	//	Магнитогорск
	case 'miass': $region = '8'; 					$domain = 'www.'; 	break;	//	Миасс
	case 'neftekamsk': $region = '103'; 	$domain = 'www.'; 	break;	//	Нефтекамск
	case 'nefteyugansk': $region = '44'; 	$domain = 'www.'; 	break;	//	Нефтеюганск
	case 'nizhnevartovsk': $region = '51';$domain = 'www.'; 	break;	//	Нижневартовск
	case 'novokuzneck': $region = '9'; 		$domain = 'www.'; 	break;	//	Новокузнецк
	case 'novosibirsk': $region = '10'; 	$domain = 'www.'; 	break;	//	Новосибирск
	case 'noyabrsk': $region = '17'; 			$domain = 'www.'; 	break;	//	Ноябрьск
	case 'omsk': $region = '11'; 					$domain = 'www.'; 	break;	//	Омск
	case 'orenburg': $region = '12'; 			$domain = 'www.'; 	break;	//	Оренбург
	case 'orsk': $region = '179'; 				$domain = 'www.'; 	break;	//	Орск
	case 'sterlitamak': $region = '213'; 	$domain = 'www.'; 	break;	//	Стерлитамак
	case 'surgut': $region = '13'; 				$domain = 'www.'; 	break;	//	Сургут
	case 'tobolsk': $region = '60'; 			$domain = 'www.'; 	break;	//	Тобольск
	case 'tomsk': $region = '224'; 				$domain = 'www.'; 	break;	//	Томск
	case 'tyumen': $region = '14'; 				$domain = 'www.'; 	break;	//	Тюмень
	case 'ufa': $region = '16'; 					$domain = 'ufa.'; 	break;	//	Уфа
	case 'chelyabinsk': $region = '15'; 	$domain = 'www.'; 	break;	//	Челябинск
	case 'yugorsk': $region = '46'; 			$domain = 'www.'; 	break;	//	Югорск
 	default:
 		die("Unknown region\n"); 		
}

switch (ENGINE_TYPE) {
	case 'vitek': 	$pagin = '3'; break;
	case 'maxwell': $pagin = '1'; break;
	case 'rondell': $pagin = '2'; break;
	case 'polaris': $pagin = '2'; break;
 	default: $pagin = '1'; break;	
}

//$options 			 = array(CURLOPT_COOKIE => 'region=' . $region . ';ItemsOnPage=44'); 		// Подставляем coockie региона
$urlStart 		 = 'https://www.rbt.ru/search/index/page/';			// Первая часть адреса
$urlEnd				 = '/?q=' . ENGINE_TYPE;												// Вторая часть адреса
$regexpP1			 = "~<div.*class=\"paginator-pages\".*>(.+)</div>~isU";		// Пагинация
$regexpP2 		 = "~<a.*span.*>(.+)<~isU";								// Пагинация
$regexpPrices  = "~schema.org/Product(.+)itemprop=\"priceCurrency~isU";
$regexpPrices2 = "~itemprop=\"name\".*<a.*href=\"(.+)\".*>.*>(.+)<.*class=\"price__row price__row_current.*>(.+)<~isU";

$reg1 = "~schema.org/Product(.+)itemprop=\"priceCurrency~isU";
$reg2 = "~itemprop=\"name\".*<a.*href=\"(.+)\".*>.*>(.+)<.*class=\"price__row price__row_current.*>(.+)<~isU";



for ($iGlobalLoop = 0; $iGlobalLoop < ENGINE_LOOP; $iGlobalLoop++) {
if (ENGINE_LOOP == 1) {
		$i = 1;
		while ( regular_one()<1 && $i<6 ) {
			$i++;
		}
	}	else {
		$content = file_get_contents('/var/www/polaris/engines/rbt.ru/'.EXTRA_PARAM.'.txt');
		//echo $content;die();
		callback_two($content);
	}


	// Сохраним массив в переменную
	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));

} // МЕГАЦИКЛ

/**
 * Формируем CSV файл
 */
$itemsArray = array();
file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
/** 
 *              Callback Functions           
 */
function regular_one() {
	global $reg1;
	global $reg2;
	global $itemsArray;
	global $region;
	global $pagin;
	global $domain;

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
	//$cmd = 'timeout -k 90s 91s casperjs /var/www/engines/rbt.ru/casper.js '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4].' '."'".$region."'";
		$cmd = 'timeout -k 90s 91s casperjs /var/www/polaris/engines/rbt.ru/casper.js '.escapeshellarg($url).' '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4].' '.$region.' '.$pagin.' '.ENGINE_TYPE. ' '.$domain;
	echo PHP_EOL.$cmd.PHP_EOL;
	die();
	$response = exec($cmd, $out, $err);
	$response = stripcslashes($response);

	//file_put_contents('/var/www/engines/rbt.ru/content.txt', $response);
//die();
	if ($response) {
		echo 'response ok'.PHP_EOL;

		preg_match("~/region/regionSelectHtml/.*>.*>(.+)<~isU", $response, $region);
		echo 'request  region: '.EXTRA_PARAM.PHP_EOL;
		echo 'response region: '.$region[1].PHP_EOL;

	  preg_match_all($reg1, $response, $matches2, PREG_SET_ORDER); //
	  print_r($matches2);
	  foreach ($matches2 as $key => $value) {
			preg_match($reg2, $value[0], $matches);
			print_r($matches);
			if (@$matches[1] && $matches[2]) {
				$matches[1] = 'https://'.$domain.'rbt.ru'.trim($matches[1]);
				//$matches[3] = iconv('windows-1251', 'utf-8', $matches[3]);
				$matches[2] = strip_tags($matches[2]);
				$matches[2] = html_entity_decode(trim($matches[2]));
				$matches[3] = preg_replace('~[^\d.]+~', '' , $matches[3]);
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], $useragent, ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent, $url);
				echo $matches[1].' | '.$matches[2].' | '.$matches[3].PHP_EOL;
			}
		}
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}


function callback_two($response) {
	global $reg1;
	global $reg2;
	global $itemsArray;
	global $region;
	global $pagin;
	global $domain;

	//file_put_contents('/var/www/engines/rbt.ru/content.txt', $response);
//die();
	if ($response) {
		echo 'response ok'.PHP_EOL;

		preg_match("~/region/regionSelectHtml/.*>.*>(.+)<~isU", $response, $region);
		echo 'request  region: '.EXTRA_PARAM.PHP_EOL;
		echo 'response region: '.$region[1].PHP_EOL;

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
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent, $url);
				echo $matches[1].' | '.$matches[2].' | '.$matches[3].PHP_EOL;
			}
		}
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}