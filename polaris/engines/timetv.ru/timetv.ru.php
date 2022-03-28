<?php
/**
 * timetv.ru
 */
switch (EXTRA_PARAM) {
 	case 'chelyabinsk': 
 		$city = 'Челябинск';
		$region = 'chlb.';
 		break;
 	case 'moscow': 
 		$city = 'Москва';
		$region = '';
 		break;
 	case 'spb': 
 		$city = 'Санкт-Петербург';
		$region = 'spb.';
 		break;
 	case 'kazan': 
 		$city = 'Казань';
		$region = 'kazan.';
 		break;
 	case 'krasnodar': 
 		$city = 'Краснодар';
		$region = 'krs.';
 		break;
	case 'novgorod': 
		$city = 'Нижний Новгород';
		$region = 'nn.';
		break;
 	case 'samara': 
 		$city = 'Самара';
		$region = 'samara.';
 		break;
 	case 'ufa':
 		$city = 'Уфа';
		$region = 'ufa.';
 		break; 		
	case 'volgograd': 
		$city = 'Волгоград';
		$region = 'vlg.';
		break;
	case 'yekaterinburg': 
		$city = 'Екатеринбург';
		$region = 'ekb.';
		break;
	case 'rostov': 
		$city = 'Ростов-на-Дону';
		$region = 'rnd.';
		break;
 	default:
 		die("Unknown region\n");  	 		
}

	$options = array(
       	//CURLOPT_COOKIEFILE      => '/var/www/polaris/engines/beru.ru/cookiessss_'.EXTRA_PARAM.'.txt',
       	CURLOPT_COOKIEJAR      	=> '/var/www/polaris/engines/xxx/cookies_'.EXTRA_PARAM.'.txt',
        CURLOPT_AUTOREFERER     => true,
        CURLOPT_FOLLOWLOCATION  => true,
				CURLOPT_CONNECTTIMEOUT => 40,
				CURLOPT_TIMEOUT        => 40, 
				CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => 0   
    );
	//$options 			= array(CURLOPT_COOKIE => 'BITRIX_SM_CITY=' . $region); 	// Подставляем coockie региона

	$urls_arr = array(
'https://'.$region.'timetv.ru/catalog/?q=polaris&s=%D0%9F%D0%BE%D0%B8%D1%81%D0%BA',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/blendery/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/kofevarki/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/kofemashiny/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/kofemolki/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/kukhonnye_vesy/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/miksery/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/mini_pechi_rostery/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/multivarki/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/myasorubki/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/sokovyzhimalki/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/sendvichnitsy_i_pribory_dlya_vypechki/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/tostery/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/khlebopechi/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/elektrochayniki_i_termopoty/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/elektrosushilki_dlya_ovoshchey_fruktov_gribov/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/grili/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-kukhni/yogurtnitsy/?set_filter=y&NEXT_SMART_FILTER_23269=4196029093',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-doma/paroochistiteli_i_otparivateli/?set_filter=y&NEXT_SMART_FILTER_22948_4196029093=Y',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-doma/pylecocy/?set_filter=y&NEXT_SMART_FILTER_22948_4196029093=Y',
'https://'.$region.'timetv.ru/catalog/tekhnika-dlya-doma/utyugi/?set_filter=y&NEXT_SMART_FILTER_22948_4196029093=Y',
'https://'.$region.'timetv.ru/catalog/klimaticheskoe-oborudovanie/vodonagrevateli/?set_filter=y&NEXT_SMART_FILTER_17868_4196029093=Y',
'https://'.$region.'timetv.ru/catalog/klimaticheskoe-oborudovanie/uvlazhniteli_vozdukha/?set_filter=y&NEXT_SMART_FILTER_17868_4196029093=Y',
'https://'.$region.'timetv.ru/catalog/klimaticheskoe-oborudovanie/ochistiteli_vozdukha/?set_filter=y&NEXT_SMART_FILTER_17868_4196029093=Y',
'https://'.$region.'timetv.ru/catalog/klimaticheskoe-oborudovanie/obogrevateli_i_teploventilyatory/?set_filter=y&NEXT_SMART_FILTER_17868_4196029093=Y',
'https://'.$region.'timetv.ru/catalog/tovary-dlya-krasoty-i-zdorovya/gidromassazhery/?set_filter=y&NEXT_SMART_FILTER_23601_4196029093=Y',
'https://'.$region.'timetv.ru/catalog/tovary-dlya-krasoty-i-zdorovya/mashinki_dlya_strizhki/?set_filter=y&NEXT_SMART_FILTER_23601_4196029093=Y',
'https://'.$region.'timetv.ru/catalog/tovary-dlya-krasoty-i-zdorovya/napolnye_vesy/?set_filter=y&NEXT_SMART_FILTER_23601_4196029093=Y',
'https://'.$region.'timetv.ru/catalog/tovary-dlya-krasoty-i-zdorovya/feny/?set_filter=y&NEXT_SMART_FILTER_23601_4196029093=Y',
'https://'.$region.'timetv.ru/catalog/tovary-dlya-krasoty-i-zdorovya/shchiptsy_ployki_i_vypryamiteli/?set_filter=y&NEXT_SMART_FILTER_23601_4196029093=Y',
	);
	
	$reg_region = "~data-param-form_id=\"city_chooser\".*<span>(.+)<~isU";

	$regexpP1 = "~class=\"module-pagination\"(.+)</div>~isU";
	$regexpP2 = "~<a.*>(.+)<~isU";

	$regexpPrices = "~class=\"item_block(.+)class=\"button_block.*</div>~isU";
	$regexpPricesS2 = "~class=\"item-title.*href=\"(.+)\".*>(.+)</span.*class=\"price_value\">(.+)<~isU";
	$regexpPricesS3 = "~class=\"item-title.*href=\"(.+)\".*>(.+)</span~isU";


	// Загрузка отсканированных ссылок:
	foreach ($itemsArray as $key => $value) {
		$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
		//echo (time() - $date->format('U')).PHP_EOL; 
		if (time() - $date->format('U') <= 5400) {
			$already_scanned[] = trim($value[5]);
		}
	}
	if ($already_scanned) {
		$already_scanned = array_unique($already_scanned);
		$already_scanned = array_values($already_scanned);
		print_r($already_scanned); 
	} else {
		$already_scanned = array();
	}
	
	// Соберём ссылки на разделы с карточками и сразу определим пагинацию
	
	foreach ($urls_arr as $url) {
		$AC->flush_requests();
		$AC->__set('callback','callback_one');
		$qOfPaginationPages = 0;
		$is_scan = 0;

		if (!in_array($url, $already_scanned)) {
			echo 'сканирую адрес:'.PHP_EOL.$url.PHP_EOL;
			$AC->get($url, NULL, $options);
			$is_scan = 1;
		} else {
			echo 'уже сканировал:'.PHP_EOL.$url.PHP_EOL;
		}
		if ($is_scan) {
			$is_scan = 0;
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
			unset($urls);
		}
		

		if ($qOfPaginationPages > 1) {
			echo 'К-во страниц: '.$qOfPaginationPages.PHP_EOL;
			$is_scan = 0;

			for ($i=2; $i <= $qOfPaginationPages; $i++) { 
				if (!in_array($url.'&PAGEN_1='.$i, $already_scanned)) {
					echo 'сканирую адрес:'.PHP_EOL.$url.'&PAGEN_1='.$i.PHP_EOL;
					$AC->get($url.'&PAGEN_1='.$i, NULL, $options);
					$is_scan = 1;
				} else {
					echo 'уже сканировал:'.PHP_EOL.$url.'&PAGEN_1='.$i.PHP_EOL;
				}
			}
			if ($is_scan) {
				$is_scan = 0;
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
				unset($urls);
			}
						
		}
		//echo 'Записываю страницу '.$url.PHP_EOL;
		//sleep(5);
		file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
		$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';		
	}



/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP1;
  global $regexpP2;

  global $regexpPrices;
  global $regexpPricesS2;
  global $regexpPricesS3;

  global $qOfPaginationPages;

  global $itemsArray;
  global $region;
	global $reg_region;
	global $city;
	global $time_start;


	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]); 

  if ($info['http_code'] !== 200) {            
    $bad_urls[] = $request->url;
    if (round(microtime(1) - $time_start, 0) >= 540) $bad_urls=array();
  } else {
  	//file_put_contents('/var/www/polaris/engines/azbuka-techniki.ru/content.txt', $response);

		preg_match($reg_region, $response, $region_name);
		$region_name[1] = trim($region_name[1]);
		//echo 'request  region: '.$city.PHP_EOL;
		//echo 'response region: '.$region_name[1].PHP_EOL;	
		$qOfPaginationPages = 0;
		if (stripos($region_name[1], $city) !== false) {

				preg_match($regexpP1, $response, $matches);
				//print_r($matches);
				preg_match_all($regexpP2, $matches[1], $matches2);
				//print_r($matches2);
				$temparrpage = array();
				foreach ($matches2[1] as $key => $value) {
					//echo "key: " . $key . "\n";
					//echo "value:" . $value . "\n";
					if (is_numeric($value)) {
						$temparrpage[] = $value;
					}
				}

				if (@max($temparrpage) > $qOfPaginationPages) {
					$qOfPaginationPages = @max($temparrpage);	    	
				}

	  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  	//print_r($matches2);

	  	foreach ($matches2 as $key) {
	  		if (strripos($key[0], 'Нет в наличии') === false) {
					preg_match($regexpPricesS2, $key[0], $matches);
					//print_r($matches);
					$matches[1] = 'https://'.$region.'timetv.ru'.trim($matches[1]);
		      $matches[2] = trim(strip_tags($matches[2]));
		      $matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
					if ($matches[1] && $matches[2]) {
						price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array(
							$matches[2], 
							$matches[3],
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url
						);
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
					}
	  		} else {
					preg_match($regexpPricesS3, $key[0], $matches);
					$matches[1] = 'https://'.$region.'timetv.ru'.trim($matches[1]);
		      $matches[2] = trim(strip_tags($matches[2]));
					if ($matches[1] && $matches[2]) {
						price_change_detect($matches[1], $matches[2], '0', date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[1]] = array(
							$matches[2], 
							'0',
							date("d.m.y-H:i:s"),
							$request->options[10004],
							$request->options[10018],
							$request->url
						);		
						AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | 0');
					}
	  		}
			}
		}	else {
			echo 'Неправильный регион '.$city.' '.$region_name[1].PHP_EOL;
			return;
		}
	}
}
