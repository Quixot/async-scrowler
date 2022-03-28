<?php
/**
 * rbt.ru
 */
$itemsArray = array();
setlocale(LC_ALL, 'ru_RU.UTF-8');
unset($AC);

switch (EXTRA_PARAM) {
	case 'moscow': $domain = 'msk'; 	break;	//	Москва
	case 'yekaterinburg': $domain = 'ekat'; 	break;	//	Екатеринбург
	case 'krasnoyarsk': 	$domain = 'kras'; 	break;	//	Красноярск
	case 'novosibirsk': 	$domain = 'novosib'; 	break;	//	Новосибирск
	case 'omsk': 					$domain = 'omsk'; 	break;	//	Омск
	case 'ufa': 					$domain = 'ufa'; 	break;	//	Уфа
	case 'chelyabinsk': 	$domain = 'chelyabinsk'; 	break;	//	Челябинск
	case 'vladivostok': 	$domain = 'vladivostok'; 	break;	//	Челябинск
	case 'kazan': 				$domain = 'kazan'; 	break;	//	Челябинск
	case 'naberezhnye-chelny': 				$domain = 'naberezhnye-chelny.'; 	break;	//	Челябинск
 	default:
 		die("Unknown region\n"); 		
}


$reg1 = "~schema.org/Product(.+)itemprop=\"priceCurrency~isU";
$reg2 = "~itemprop=\"name\".*<a.*href=\"(.+)\".*>.*>(.+)<.*class=\"price__row price__row_current.*>(.+)<~isU";

regular_one();
unlink($cookfilepath);

file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';

/** 
 *              Callback Functions           
 */
function regular_one() {
	global $reg1;
	global $reg2;
	global $itemsArray;

	// Переделаем кукисы в правильный стандарт
	$cookfilepath = AC_DIR.'/engines/'.ENGINE_CURR.'/cookies/'.EXTRA_PARAM.'.txt';
	if (!file_exists($cookfilepath) || time() - filemtime($cookfilepath) > 3600) {
		//die('нет кукисов или старый файл '.$cookfilepath.PHP_EOL);
	}

	/**
	 * Блок выбора прокси
	 */
	$useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0';
		  
	$proxy_auth = file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/proxy/'.EXTRA_PARAM.'.txt');	  
	preg_match("~(.+):(.+):(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	if (!$matches_proxy) {
	 	preg_match("~(.+):(.+)$~isU", trim($proxy_auth), $matches_proxy);
	}
	/**
	 * Блок выбора прокси
	 */
	$glob = glob(AC_DIR.'/engines/'.ENGINE_CURR.'/content/*.txt');

	$baselinks = array(
		'https://www.rbt.ru/search/?q=polaris',
		'https://kazan.rbt.ru/search/?q=polaris',
		'https://kras.rbt.ru/search/?q=polaris',
		'https://msk.rbt.ru/search/?q=polaris',
		'https://naberezhnye-chelny.rbt.ru/search/?q=polaris',
		'https://novosib.rbt.ru/search/?q=polaris',
		'https://omsk.rbt.ru/search/?q=polaris',
		'https://ufa.rbt.ru/search/?q=polaris',
		'https://vladivostok.rbt.ru/search/?q=polaris',
		'https://ekat.rbt.ru/search/?q=polaris',
	);	

	$baselinksID = array();
	foreach ($baselinks as $bsurl) {
		$baselinksID[] = preg_replace('/[^a-zA-Z0-9]/', '', $bsurl);;
	}

	for ($i=0; $i < count($baselinks); $i++) { 
		//echo '/var/www/polaris/engines/rbt.ru/content/'.$i.'.txt'.PHP_EOL;
		if (!in_array('/var/www/polaris/engines/rbt.ru/content/'.$baselinksID[$i].'.txt', $glob)) {
			$links .= $baselinks[$i].',';
			//$linksid .= $baselinksID[$i].',';
		}
	}
	$links = substr($links, 0, -1);

	$cmd = 'timeout -k 800s 801s casperjs /var/www/polaris/engines/rbt.ru/casper.js --ignore-ssl-errors=true --ssl-protocol=any "'.$links.'" '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4].' '.EXTRA_PARAM;
	if ($links) {
		echo $cmd.PHP_EOL;die();

		$response = exec($cmd, $out, $err);
		$response = implode(" ", $out);
	}

	$glob = glob('/var/www/polaris/engines/rbt.ru/content/*.txt');	

	if ($glob) {
		$count_all_items = 0;
		foreach ($glob as $addr) {
			preg_match('~'.EXTRA_PARAM.'(.+).txt~isU', $addr, $mReqUrl);
			$request_url = $mReqUrl[1];
			
			$response = file_get_contents($addr);

			preg_match("~Interactions-open-visitorCityList.*>(.+)<~isU", $response, $region);
			AngryCurl::add_debug_msg('request  region: '.$city);
			AngryCurl::add_debug_msg('response region: '.trim($region[1])); 

			//file_put_contents('/var/www/polaris/engines/rbt.ru/content.txt', $response);

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
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent);
					echo $matches[1].' | '.$matches[2].' | '.$matches[3].PHP_EOL;
				}
			}
		}
		echo 'Позиций: '.$count_all_items.PHP_EOL;
		return 1;
	} else {
		return 0;
	}
	
}
