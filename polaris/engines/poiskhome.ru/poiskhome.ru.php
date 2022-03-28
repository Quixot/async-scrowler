<?php
switch (EXTRA_PARAM) {
	case 'anapa': 					$zone = 'Анапа'; 						$region_id = '21'; $domain = 'anapa.'; break;
	case 'armavir': 				$zone = 'Армавир'; 					$region_id = '14'; $domain = 'armavir.'; break;
	case 'vladikavkaz': 		$zone = 'Владикавказ'; 			$region_id = '15'; $domain = 'vladikavkaz.'; break;
	case 'volgodonsk': 			$zone = 'Волгодонск'; 			$region_id = '12'; $domain = 'volgodonsk.'; break;
	case 'essentuki': 			$zone = 'Ессентуки'; 				$region_id = '19'; $domain = 'essentuki.'; break;
	case 'krasnodar':				$zone = 'Краснодар'; 				$region_id = '5'; $domain = 'krasnodar.'; break;
	case 'majkop': 					$zone = 'Майкоп'; 					$region_id = '11'; $domain = 'maykop.'; break;
	case 'mineralnye-vody': $zone = 'Минеральные Воды'; $region_id = '16'; $domain = 'minvody.'; break;
	case 'nalchik': 				$zone = 'Нальчик'; 					$region_id = '13'; $domain = 'nalchik.'; break;
	case 'nevinnomyssk': 		$zone = 'Невинномысск'; 		$region_id = '17'; $domain = 'nevinnomyssk.'; break;
	case 'novorossijsk': 		$zone = 'Новороссийск'; 		$region_id = '9'; $domain = 'novorossiysk.'; break;
	case 'novocherkassk': 	$zone = 'Новочеркасск'; 		$region_id = '34'; $domain = 'novocherkassk.'; break;
	case 'pyatigorsk': 			$zone = 'Пятигорск'; 				$region_id = '8'; $domain = 'pyatigorsk.'; break;
	case 'rostov': 					$zone = 'Ростов-на-Дону';		$region_id = '1'; $domain = ''; break;
	case 'stavropol': 			$zone = 'Ставрополь'; 			$region_id = '6'; $domain = 'stavropol.'; break;
	case 'taganrog': 				$zone = 'Таганрог'; 				$region_id = '2'; $domain = 'taganrog.'; break;
	case 'cherkessk': 			$zone = 'Черкесск'; 				$region_id = '20'; $domain = 'cherkessk.'; break;
	case 'shahty': 					$zone = 'Шахты'; 						$region_id = '7'; $domain = 'shahty.'; break;
default:
	die("Unknown region\n"); 		
}

switch (ENGINE_TYPE) {
	case 'vitek':
		$kostil = 5;
		break;
	case 'maxwell':
		$kostil = 1;
		break;
	case 'rondell':
		$kostil = 5;
		break;	
	default:
		die('wrong brand'.PHP_EOL);
		break;
}

$bad_urls = array();

$urlStart = 'https://'.$domain.'poiskhome.ru/Home/SearchResult?CurrentPage=';
$urlEnd 	= '%20%20&SearchText='.ENGINE_TYPE;
$regexpP1 			= "~class=\"prod-list-nav\">(.+)</div~isU";
$regexpP2 		 	= "~href.*>(.+)</~isU";
$regexpPrices 	= "~product-item p-box(.+)</li~isU";
$regexpPrices2 	= "~href=.*href=\"(.+)\".*product-name.*>(.+)<.*class=\"price\">(.+)<~isU";
$region = "~store_location-link.*Ваш город(.+)<~isU";
/*
if (regular_one() < 1) {
	echo 'bad urls'.PHP_EOL;
	regular_one(); // bad_urls impl @TODO: change logic
}
*/
$i = 1;
while ( regular_one()<1 && $i<3 ) {
	$i++;
}



function regular_one() {
	global $domain;
	global $regexpPrices;
	global $regexpPrices2;
	global $zone;
	global $region;
	global $region_id;
	global $itemsArray;
	global $kostil;

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
	$cmd = 'timeout -k 115s 120s casperjs /var/www/engines/poiskhome.ru/poiskhome.js '.escapeshellarg(ENGINE_TYPE).' '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4].' '."'".$domain."'".' '.$kostil;
	echo 'request: '.$cmd.PHP_EOL;
	$response = exec($cmd, $out, $err);
	$response = stripcslashes($response);

	if ($response) {
		echo 'response ok'.PHP_EOL;
		//file_put_contents('/var/www/engines/poiskhome.ru/content.json', $response);

	  preg_match($region, $response, $mregion);
	  echo trim($mregion[1]).PHP_EOL;
	  echo $zone.PHP_EOL;

	  if (trim($mregion[1]) == $zone) {
	  	echo 'Текущий регион: '.$zone.PHP_EOL;
		  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER);
		  //print_r($matches2);
			foreach ($matches2 as $key) {
				preg_match($regexpPrices2, $key[1], $matches);
				//print_r($matches);
				if (strripos($key[1], 'add_to_cart') === false) $matches[3] = 0;
				$matches[1] = 'http://'.ENGINE_CURR.trim($matches[1]);
				$matches = clean_info($matches, array(1,2,3));
				if ($matches != false) {
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $matches_proxy[3].':'.$matches_proxy[4], $useragent, ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2]);
					echo $matches[2].' | '.$matches[3].PHP_EOL;
				}
			}  
			echo 'return 1';
			return 1;	
	  } else {
	  	//mail('alexandr.volkoff@gmail.com', 'poiskhome.ru problem', 'Проблема с регионом: '.$zone.' не совпадает с тем, что на странице: '.trim($mregion[1]));
	  	echo 'bad response 1'.PHP_EOL;
	  	return 0;	
	  }
	} else {
		echo 'bad response 2'.PHP_EOL;
		return 0;
	}
}
