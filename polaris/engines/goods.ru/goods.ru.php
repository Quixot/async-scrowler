<?php
/**
 * goods.ru
 */
switch (EXTRA_PARAM) {
 	case 'moscow': 				$region = '50'; $city = 'Москва и Московская область'; break;
 	case 'spb':						$region = '78'; $city = 'Санкт-Петербург'; break;
 	case 'novgorod':			$region = '52'; $city = 'Нижегородская область'; break;
 	case 'samara':				$region = '63'; $city = 'Самарская область'; break;
 	case 'kazan':					$region = '16'; $city = 'Республика Татарстан'; break;
 	case 'ekaterinburg':	$region = '66'; $city = 'Свердловская область'; break;
 	case 'krasnodar':			$region = '23'; $city = 'Краснодарский край'; break;
 	case 'rostov':				$region = '61'; $city = 'Ростовская область'; break;
 	case 'volgograd':			$region = '34'; $city = 'Волгоградская область'; break;
 	case 'chelyabinsk':		$region = '74'; $city = 'Челябинская область'; break;
 	case 'ufa':						$region = '02'; $city = 'Республика Башкортостан'; break;
 	case 'cheboksary':		$region = '21'; $city = 'Чувашская Республика'; break;
 	case 'voronezh':		$region = '36'; $city = 'Воронежская область'; break;

 	default:
 		die("Unknown region\n"); 		
}


	$urlStart = 'https://goods.ru/catalog/page-';
	$urlEnd = '/?q=polaris';
	$regexpP1	 = "~class=\"pagination\"(.+)</nav>~isU";
	$regexpP2  = "~<a.*>(.+)<~isU";
	$regexpPrices  = "~<article(.+)</article>~isU";
	$regexpPrices2 = "~itemprop=\"url\".*href=\"(.+)\".*>(.+)<.*content=\"RUB\">(.+)<~isU";
	$regexpPrices3 = "~itemprop=\"url\".*href=\"(.+)\".*>(.+)<~isU";
	$regexpRegion = "~class=\"SiteHeader_index__currentRegion_0\">(.+)<i~isU";
	$regexpMerchant = '~Продавец:.*<span>(.+)</span>~isU';

	$options = array(
       	//CURLOPT_COOKIEFILE      => '/var/www/polaris/engines/beru.ru/cookiessss_'.EXTRA_PARAM.'.txt',
       	CURLOPT_COOKIE => 'region_id='.$region,
       	CURLOPT_COOKIEJAR      	=> '/var/www/polaris/engines/xxx/cookies_'.EXTRA_PARAM.'.txt',
        CURLOPT_AUTOREFERER     => true,
        CURLOPT_FOLLOWLOCATION  => true,
				CURLOPT_CONNECTTIMEOUT => 60,
				CURLOPT_TIMEOUT        => 60, 
				CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => 0   
    );

	$merchant_array = unserialize(file_get_contents('/var/www/polaris/engines/'.ENGINE_CURR.'/merchant.data'));
	$merchant_new = array();	


	foreach ($itemsArray as $key => $value) {
		$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
		//echo (time() - $date->format('U')).PHP_EOL; 
		if (time() - $date->format('U') <= 7000) {
			$already_scanned[] = $value[5];
		}
		
	}
	if ($already_scanned) {
		$already_scanned = array_unique($already_scanned);
		$already_scanned = array_values($already_scanned);
		//print_r($already_scanned); 
	} else {
		$already_scanned = array();
	}
	$already_scanned = array();


$AC->get('https://goods.ru/catalog/pogruzhnye-blendery/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/blendery-stacionarnye/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/miksery-ruchnye/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/miksery-s-chashey/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/multivarki/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/parovarki/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/chajniki-elektricheskie/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/termopoty/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/elektrogrili/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/myasorubki/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/hlebopechki/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/sokovyzhimalki-centrobezhnye/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/multipekar/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/tostery/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/mini-pechi/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/jogurtnicy/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/sushilki-dlya-ovoshey-i-fruktov/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/drugie-aksessuary-dlya-melkoj-kuhonnoj-tehniki/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/vesy-kuhonnye/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/frityurnicy/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/roboty-pylesosy/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/besprovodnye-pylesosy/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/vertikalnye-pylesosy/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/pylesosy-bez-meshka-dlya-sbora-pyli/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/pylesosy-s-pylesbornikom/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/utyugi/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/parogeneratory/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/filtry-dlya-pylesosv/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/meshki-dlya-pylesosov/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/nasadki-dlya-pylesosov/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/shetki-dlya-pylesosov/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/kofevarki-rozhkovogo-tipa/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/kofevarki-kapelnogo-tipa/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/kofemolki/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/feny/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/fen-shetki/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/elektroshipcy/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/vypryamiteli-volos/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/multistajlery/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/mashinki-dlya-strizhki-volos/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/trimmery/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/napolnye-vesy/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/vannochki-dlya-parafinoterapii/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/elektricheskaya-rolikovye-pilki/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/massazhery-dlya-tela-elektricheskie/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/manikyurnye-nabory-elektricheskie/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/konvektory-nastennye/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/konvektory-napolnye/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/radiatory/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/teploventilyatory/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/mikatermicheskie-obogrevateli/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/ventilyatory-napolnye/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/ventilyatory-nastolnye/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/vodonagrevateli-nakopitelnye/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/vodonagrevateli-protochnye/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/vozduhoochistiteli/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/vozduhouvlazhniteli/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/moyki-vozduha/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/klimaticheskie-kompleksy/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/aksessuary-dlya-vozduhouvlazhnitelej/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/aksessuary-dlya-vozduhoochistitelej/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/mashinki-dlya-udaleniya-katyshkov/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/elektromobili/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/nabory-nozhey/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/kuhonnaya-naveska/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/aksessuary-dlya-prigotovleniya-pishi/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/skovorody-gril/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/skovorody-vok/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/skovorody-iz-nerzhaveyushey-stali/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/sotejniki/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/kovshi/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/kastryuli-iz-nerzhaveyushey-stali/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/alyuminievye-kastryuli/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/formy-dlya-vypechki/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/kryshki-dlya-posudy/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/chajniki-dlya-plity/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/french-pressy/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/geyzernye-kofevarki/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/lampy-dlya-manikyura-i-pedikyura/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/manikyurnye-nabory-elektricheskie/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/sinteticheskie-motornye-masla/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/motornye-masla-dlya-dizelnyh-dvigateley/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/transmissionnye-masla/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/smazki-dlya-mashiny/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/vozdushnye-filtry-dvigatelya/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/filtry-maslyanye-dvigatelya/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/kaprolonovye-vtulki-dlya-kvadrociklov/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/kolodki-dlya-kvadrociklov/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/tormoznye-diski-dlya-kvadrociklov/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/remni-variatora-dlya-kvadrociklov/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/filtry-vozdushnye-dlya-kvadrocikla/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/infrakrasnye-obogrevateli/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/elektrosamokaty-2463684633781217/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/elektrosamokaty-2463684633781217/brand-polaris/', null, $options);
$AC->get('https://goods.ru/catalog/elektrovelosipedy/brand-polaris/', null, $options);
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {
	  $AC->flush_requests();
	  foreach ($bad_urls as $urls) {
	    $AC->get($urls, NULL, $options);  
	  }
	  unset($urls);

	  $bad_urls = array();
	  $AC->execute(WINDOW_SIZE);
	}
	unset($urls);

	if (1 > 1) {

		for ($i = 1; $i <= $qOfPaginationPages; $i++) {

			if (!in_array($urlStart.$i.$urlEnd, $already_scanned)) {
				echo 'сканирую адрес:'.PHP_EOL.$urlStart.$i.PHP_EOL;
				$AC->get($urlStart.$i.$urlEnd, null, $options);
				$is_any = 1;
			} else {
				echo 'уже сканировал:'.PHP_EOL.$urlStart.$i.$urlEnd.PHP_EOL;
			}

		}
		if ($is_any) {
			$AC->execute(WINDOW_SIZE);
		}

		while ($bad_urls) {
		  $AC->flush_requests();
		  foreach ($bad_urls as $urls) {
		    $AC->get($urls, NULL, $options);  
		  }
		  unset($urls);

		  $bad_urls = array();
		  $AC->execute(WINDOW_SIZE);
		}
		unset($urls);
	}

/**/
	print_r($merchant_new);
	$merchant_new = array();

	if ($merchant_new) {
		$AC->flush_requests();
		$AC->__set('callback','callback_three');

		foreach ($merchant_new as $url) {
			$AC->get($url, NULL, $options);
		}
		$AC->execute(WINDOW_SIZE);

		while ($bad_urls) {
			$AC->flush_requests();
			foreach ($bad_urls as $urls) {
			  $AC->get($urls, NULL, $options);
			}
			unset($urls);
			$bad_urls = array();
			$AC->execute(WINDOW_SIZE);
		}
		unset($urls);

	}	


	// Сохраним массив в переменную
	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';
	file_put_contents('/var/www/polaris/engines/'.ENGINE_CURR.'/merchant.data', serialize($merchant_array));
/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
	global $regexpP1;
	global $regexpP2;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpRegion;
	global $city;
	global $qOfPaginationPages;
	global $itemsArray;
	global $bad_urls;
	global $time_start;
	global $merchant_array;
	global $merchant_new;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {
  	if ($info['http_code'] !== 404) {
	    $bad_urls[] = $request->url;
			if (round(microtime(1) - $time_start, 0) >= 300) { $bad_urls = array(); }  
		}  
  } else {

  	file_put_contents('/var/www/polaris/engines/goods.ru/content.txt', $response);

  	preg_match($regexpRegion, $response, $mReg);
  	$mReg[1] = trim(strip_tags($mReg[1]));
  	AngryCurl::add_debug_msg($mReg[1].' | '.$city);

		preg_match($regexpP1, $response, $matches);
		//print_r($matches);
		preg_match_all($regexpP2, $matches[1], $matches2);
		//print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			//echo "key: " . $key . "\n";
			$value = trim($value);
			//echo "value:" . $value . "\n";
			if (is_numeric($value)) {
				$temparrpage[] = $value;
			}
		}

		if (@max($temparrpage) > $qOfPaginationPages) {
			$qOfPaginationPages = @max($temparrpage);	    	
		}

  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER);
	  foreach ($matches2 as $key) {
			if (strripos($key[1], 'notAvailable') === false) {	
				preg_match($regexpPrices2, $key[1], $matches);
				if ($matches[1]) {

						$matches[1] = 'https://goods.ru'.trim($matches[1]);
						$matches[2] = trim(strip_tags($matches[2]));
						$matches[3] = preg_replace('~[^\d]+~', '', $matches[3]);

						if (@$merchant_array[$matches[1]]) {
							$merchant_name = $merchant_array[$matches[1]];
						} else {
							$merchant_new[] = $matches[1];
							$merchant_new = array_unique($merchant_new);
						}
						
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array(
							$matches[2], 
							$matches[3],
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url, 
							$merchant_name
						);
						AngryCurl::add_debug_msg($matches[2].' | '.$matches[3].' | '.$merchant_name);
				}
			} else {
				preg_match($regexpPrices3, $key[1], $matches);
				if ($matches[1]) {
						$matches[1] = 'https://goods.ru'.trim($matches[1]);
						$matches[2] = trim(strip_tags($matches[2]));
						$matches[3] = '0';
						
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array(
							$matches[2], 
							$matches[3],
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url
						);
						AngryCurl::add_debug_msg($matches[2].' | '.$matches[3]);					
				}
			}
		}
  }
}


function callback_three($response, $info, $request) {
/**
 * Добирает в массив недостающие ссылки по поставщикам
 */
  global $region;
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;
  global $bad_urls;
  global $time_start;
  global $regRegion;
  global $regionName;
  global $merchant_array;
  global $regexpMerchant;
  global $merchant_new;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);  


  if ($info['http_code'] !== 200) {   
  	if ($info['http_code'] !== 404) {
  		$bad_urls[] = $request->url;
  	} 	
		if (round(microtime(1) - $time_start, 0) >= 90) { $bad_urls = array(); }  	 	         
  } else {
  	preg_match($regexpMerchant, $response, $mmerch);
  	$mmerch[1] = trim($mmerch[1]);
  	if (!$mmerch[1]) {
	  	preg_match("~shopsName: '(.+),~isU", $response, $mmerch);

	  	$mmerch[1] = trim($mmerch[1]);
	  	$mmerch[1] = str_replace("'", "", $mmerch[1]);
  	}

  	if ($mmerch[1]) {
  		$merchant_array[$request->url] = $mmerch[1];
  		$itemsArray[$request->url][6] = $mmerch[1];
  		AngryCurl::add_debug_msg($request->url.' - '.$mmerch[1]);
  	}	else {
  		$bad_urls[] = $request->url;
  		if (round(microtime(1) - $time_start, 0) >= 90) { $bad_urls = array(); }
  	}
  }
}

