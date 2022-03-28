<?php
/**
 * positronica.ru
 */
switch (EXTRA_PARAM) {
	case 'arhangelsk': 					$city = 'АРХАНГЕЛЬСК'; break;
	case 'cheboksary': 					$city = 'ЧЕБОКСАРЫ'; break;
	case 'chelyabinsk': 				$city = 'ЧЕЛЯБИНСК'; break;
	case 'habarovsk': 					$city = 'ХАБАРОВСК'; break;
	case 'kazan': 							$city = 'КАЗАНЬ'; break;
	case 'krasnodar': 					$city = 'КРАСНОДАР'; break;
	case 'krasnoyarsk': 				$city = 'КРАСНОЯРСК'; break;
	case 'moscow': 							$city = 'МОСКВА'; break;
	case 'naberezhnye-chelny': 	$city = 'НАБЕРЕЖНЫЕ ЧЕЛНЫ'; break;
	case 'novgorod':						$city = 'НИЖНИЙ НОВГОРОД'; break; 
	case 'novosibirsk':					$city = 'НОВОСИБИРСК'; break;
	case 'omsk':								$city = 'ОМСК'; break;
	case 'perm':								$city = 'ПЕРМЬ';break; 
	case 'petrozavodsk':				$city = 'ПЕТРОЗАВОДСК'; break;
	case 'pyatigorsk':					$city = 'ПЯТИГОРСК'; break;
	case 'rostov':							$city = 'РОСТОВ-НА-ДОНУ'; break;
	case 'samara':							$city = 'САМАРА'; break;
	case 'spb':									$city = 'САНКТ-ПЕТЕРБУРГ'; break;
	case 'ufa':									$city = 'УФА'; break;
	case 'vladivostok':					$city = 'ВЛАДИВОСТОК'; break;
	case 'volgograd':						$city = 'ВОЛГОГРАД';break;
	case 'yekaterinburg':				$city = 'ЕКАТЕРИНБУРГ'; break;
 	default:
 		die("Unknown region\n");  	 		
}

	$regexpP1 = "~class=\"pagination\"(.+)</ul>~isU";
	$regexpP2 = "~<a.*>(.+)<~isU";
	$regexp1 = "~product card_one(.+)</li>~isU";
	$regexp2 = "~data-productid=\"(.+)\".*class=\"name\".*href=\"(.+)\".*>(.+)<.*class=\"status(.+)\"~isU";	

	$reg_region = "~id=\"city_change\".*>(.+)<~isU";

	$options = array(
     	CURLOPT_COOKIEFILE      => '/var/www/polaris/engines/positronica.ru/cookies/'.EXTRA_PARAM.'.txt',
     	//CURLOPT_COOKIEJAR      	=> '/var/www/polaris/engines/positronica.ru/cookies.txt',
      CURLOPT_AUTOREFERER     => true,
      CURLOPT_FOLLOWLOCATION  => true,
      CURLOPT_CONNECTTIMEOUT => 30,
      CURLOPT_TIMEOUT        => 30, 
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_SSL_VERIFYHOST => 0   
  );

	$proxy_array = glob('/var/www/polaris/engines/positronica.ru/proxy/'.EXTRA_PARAM.'.txt');
	$alive_proxy_list = '';
	foreach ($proxy_array as $key) {
		$alive_proxy_list .= file_get_contents($key);
		$alive_proxy_list .= "\n";
	}
	$alive_proxy_list = trim($alive_proxy_list);	
	if ($alive_proxy_list) {
		$alive_proxy_list = explode("\n", $alive_proxy_list);
		shuffle($alive_proxy_list);	
		$AC->__set('array_proxy', $alive_proxy_list);
		$AC->__set('n_proxy', count($alive_proxy_list));
		$AC->add_debug_msg("Ускоренная загрузка proxy:\n");	
	}

	
	$AC->get('https://positronica.ru/search/?n_count=90&q=polaris', null, $options);
	/*$AC->get('https://positronica.ru/catalog/blendery/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/utyugi/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/ventilytor/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/vesy/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/vodonagrevateli/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/rectifiers/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/acessdlyabritvy/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/acesspyl/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/konvektory/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/kofevarki/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/caps_coff/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/kofemolki/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/kitchen_m/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/kuhonvesi/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/maslyanyeradiatory/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/mashinki_dlya_strijki/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/miksery/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/multivarki/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/myasorubki/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/aksessuary_dlya_kuhonnyh_priborov/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/otparivateli/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/steam_station/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/manikyurnye/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/pylesosy/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/maslyanye_radiatory_u/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/hairdryer_brush/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/svchpechi/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/sokovyzhimalki/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/syshkiovosh/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/sandwiches_waffle/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/termopoty/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/tostery/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/uvlajniteli/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/feny/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/acc_vozdukhoochist/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/chajniki_el/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/shhipcy/polaris/', null, $options);
	$AC->get('https://positronica.ru/catalog/electrogrili/polaris/', null, $options);*/
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {
	  $AC->flush_requests();
	  foreach ($bad_urls as $urls) {
	    $AC->get($urls); 
	  }
	  unset($urls);
	  $bad_urls = array();
	  $AC->execute(WINDOW_SIZE);
	}
	unset($urls);

	//$qOfPaginationPages = 0;
	if ($qOfPaginationPages > 1) {
		for ($i=2; $i <= $qOfPaginationPages; $i++) { 
			$AC->get('https://positronica.ru/search/?n_count=90&q=polaris&PAGEN_3='.$i, null, $options);
		}
		$AC->execute(WINDOW_SIZE);

		for ($i=2; $i <= $qOfPaginationPages; $i++) { 
			$AC->get('https://positronica.ru/search/?n_count=90&q=polaris&PAGEN_2='.$i, null, $options);
		}
		$AC->execute(WINDOW_SIZE);

		while ($bad_urls) {
		  $AC->flush_requests();
		  foreach ($bad_urls as $urls) {
		    $AC->get($urls); 
		  }
		  unset($urls);
		  $bad_urls = array();
		  $AC->execute(WINDOW_SIZE);
		}
		unset($urls);		
	}

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';

	if (ENGINE_LOOP == 13) {
		$regions = array('cheboksary', 'chelyabinsk', 'habarovsk', 'kazan', 'krasnodar', 'krasnoyarsk', 'moscow', 'naberezhnye-chelny', 'novgorod', 'novosibirsk', 'omsk', 'rostov', 'spb', 'samara', 'ufa', 'volgograd', 'vladivostok', 'yekaterinburg');

		foreach ($regions as $region) {

			file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . $region . '.data', serialize($itemsArray));
			
		}
		//$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';
	}


/** 
 *              Callback Functions           
 */

function callback_one($response, $info, $request) {
	global $regexpP1;
	global $regexpP2;
	global $regexp1;
	global $regexp2;	
	global $city;
	global $itemsArray;
	global $qOfPaginationPages;
	global $bad_urls;
	global $time_start;
	global $reg_region;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {
    $bad_urls[] = $request->url;
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 120) { $bad_urls = array(); }         
  } else {
  	sleep(2);
  	preg_match($reg_region, $response, $mreg);
  	AngryCurl::add_debug_msg($city.' | '.$mreg[1]);

  	if (stripos(trim($mreg[1]), $city) !== false) {
			preg_match($regexpP1, $response, $matches);
			//print_r($matches);
			preg_match_all($regexpP2, $matches[1], $matches2);
			//print_r($matches2);
			$temparrpage = array();
			foreach ($matches2[1] as $key => $value) {
				//echo "key: " . $key . "\n";
				echo "value:" . $value . "\n";
				if (is_numeric($value)) {
					$temparrpage[] = $value;
				}
			}
			if (@max($temparrpage) > $qOfPaginationPages) {
				$qOfPaginationPages = @max($temparrpage);	    	
			}	

	// Находим коды и цены
	  	preg_match("~addPriceInDom(.+)pushEcom~isU", $response, $match_json);	
			preg_match_all("~'PRICE':'(.+)\..*'PRODUCT_ID':'(.+)'~isU", $match_json[1], $matches_codes, PREG_SET_ORDER);
			print_r($matches_codes);
			file_put_contents('/var/www/polaris/engines/positronica.ru/codes.txt', print_r($matches_codes, 1));

			foreach ($matches_codes as $key => $value) {
				if (!$codes_array[$value[2]]) {
					$codes_array[$value[2]] = $value[1];
				}	
			}
			print_r($codes_array);	
			file_put_contents('/var/www/polaris/engines/positronica.ru/codes_array.txt', print_r($codes_array, 1));

	  	preg_match_all($regexp1, $response, $matches2, PREG_SET_ORDER); //
	  	//print_r($matches2);
	  	foreach ($matches2 as $key) {  		
				preg_match($regexp2, $key[1], $matches);		
				//print_r($matches);
				if ($matches[1]) {
					$url = 'https://'.ENGINE_CURR.trim($matches[2]);
					$name = trim($matches[3]);
					
					if (trim($matches[4]) == 'stock') {
						$price = $codes_array[trim($matches[1])];
					} else {
						$price = '0';
					}
					

					price_change_detect($url, $name, $price, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$url] = array($name, $price,
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url);		
					AngryCurl::add_debug_msg($url.' | '.$name.' | '.$price);
				} 							  		
			}
		}
  }
}
