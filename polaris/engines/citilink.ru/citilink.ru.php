<?php
/**
 * citilink.ru
 */
switch (EXTRA_PARAM) {
	case 'abakan': $region = 'krasn_cl%3Akrasnabak'; $city = ''; break; // Абакан
	case 'almetevsk': $region = 'kzn_cl%3Akzmalm'; $city = ''; break; // Альметьевск
	case 'anapa': $region = 'krd_cl%3Akrdanapa'; $city = ''; break; // Анапа
	case 'arzamas': $region = 'nnov_cl%3Anmarzamas'; $city = ''; break; // Арзамас
	case 'astrakhan': $region = 'vlg_cl%3Avlgastrhan'; $city = ''; break; // Астрахань
	case 'achinsk': $region = 'krasn_cl%3Akrasnachi'; $city = ''; break; // Ачинск
	case 'balakovo': $region = 'srt_cl%3Asrtbaltrna'; $city = ''; break; // Балаково
	case 'belgorod': $region = 'vrzh_cl%3Avrnbel'; $city = ''; break; // Белгород
	case 'berezniki': $region = 'perm_cl%3Aprmberez2'; $city = ''; break; // Березники
	case 'borisoglebsk': $region = 'srt_cl%3Asrtborisog'; $city = ''; break; // Борисоглебск
	case 'velikijnovgorod': $region = 'spb_cl%3Aspmvnovg'; $city = ''; break; // Великий Новгород
	case 'vladikavkaz': $region = 'stav_cl%3Astavvlad'; $city = ''; break; // Владикавказ
	case 'vladimir': $region = 'msk_cl%3Acmkvlalmaz'; $city = ''; break; // Владимир
	case 'volgograd': $region = 'vlg_cl%3A'; $city = 'Волгоград'; break; // Волгоград
	case 'volgodonsk': $region = 'vlg_cl%3Avlgvlgd01'; $city = ''; break; // Волгодонск
	case 'volzhskij': $region = 'vlg_cl%3Avlgvollen'; $city = ''; break; // Волжский
	case 'vologda': $region = 'yar_cl%3Ayarvol'; $city = ''; break; // Вологда
	case 'voronezh': $region = 'vrzh_cl%3A'; $city = ''; break; // Воронеж
	case 'dimitrovgrad': $region = 'smr_cl%3Asmmdimit'; $city = ''; break; // Димитровград
	case 'yekaterinburg': $region = 'ekat_cl%3A'; $city = 'Екатеринбург'; break; // Екатеринбург
	case 'ivanovo': $region = 'nnov_cl%3Anmikvadrat'; $city = ''; break; // Иваново
	case 'joshkar-ola': $region = 'kzn_cl%3Akzmiosh'; $city = ''; break; // Йошкар-Ола
	case 'kazan': $region = 'kzn_cl%3A'; $city = 'Казань'; break; // Казань
	case 'kaluga': $region = 'msk_cl%3Acmkaluga'; $city = ''; break; // Калуга
	case 'kamyshin': $region = 'vlg_cl%3Avlgkamysh3'; $city = ''; break; // Камышин
	case 'kostroma': $region = 'yar_cl%3Ayarkost2'; $city = ''; break; // Кострома
	case 'krasnodar': $region = 'krd_cl%3A'; $city = 'Краснодар'; break; // Краснодар
	case 'krasnoyarsk': $region = 'krasn_cl%3A'; $city = 'Красноярск'; break; // Красноярск
	case 'kropotkin': $region = 'krd_cl%3Akrdkropot'; $city = ''; break; // Кропоткин
	case 'kurgan': $region = 'chlb_cl%3Achlbkur2'; $city = ''; break; // Курган
	case 'kursk': $region = 'vrzh_cl%3Avrnkursk'; $city = ''; break; // Курск
	case 'lipeck': $region = 'vrzh_cl%3Avrnlipobed'; $city = ''; break; // Липецк
	case 'magnitogorsk': $region = 'chlb_cl%3Achlmag3'; $city = ''; break; // Магнитогорск
	case 'majkop': $region = 'krd_cl%3Akrdmaykop'; $city = ''; break; // Майкоп
	case 'miass': $region = 'chlb_cl%3Achlbmiass'; $city = ''; break; // Миасс
	case 'mineralnye-vody': $region = 'stav_cl%3Astavminvod'; $city = ''; break; // Минеральные Воды
	case 'moscow': $region = 'msk_cl%3A'; $city = 'Москва'; break; // Москва
	case 'naberezhnye-chelny': $region = 'nch_cl%3A'; $city = 'Набережные Челны'; break; // Набережные Челны
	case 'nevinnomyssk': $region = 'stav_cl%3Astavnevin'; $city = ''; break; // Невинномысск
	case 'nizhnekamsk': $region = 'nch_cl%3Akzmniznek'; $city = ''; break; // Нижнекамск
	case 'novgorod': $region = 'nnov_cl%3A'; $city = 'Нижний Новгород'; break; // Нижний Новгород
	case 'nizhnij-tagil': $region = 'ekat_cl%3Aekattagil2'; $city = ''; break; // Нижний Тагил
	case 'novorossijsk': $region = 'krd_cl%3Akrdnovor'; $city = ''; break; // Новороссийск
	case 'novosibirsk': $region = 'nvs_cl%3A'; $city = ''; break; // Новосибирск
	case 'novocherkassk': $region = 'rnd_cl%3Arndnovoch'; $city = ''; break; // Новочеркасск
	case 'obninsk': $region = 'msk_cl%3Acmobninsk'; $city = ''; break; // Обнинск
	case 'pavlovo': $region = 'nnov_cl%3Anmvesna'; $city = ''; break; // Павлово
	case 'penza': $region = 'penza_cl%3A'; $city = ''; break; // Пенза
	case 'pervouralsk': $region = 'ekat_cl%3Aekatpervc'; $city = ''; break; // Первоуральск
	case 'perm': $region = 'perm_cl%3A'; $city = 'Пермь'; break; // Пермь
	case 'pskov': $region = 'spb_cl%3Aspmpskov'; $city = ''; break; // Псков
	case 'pyatigorsk': $region = 'ptg_cl%3A'; $city = 'Пятигорск'; break; // Пятигорск
	case 'rostov': $region = 'rnd_cl%3A'; $city = 'Ростов-на-Дону'; break; // Ростов-на-Дону
	case 'rybinsk': $region = 'yar_cl%3Ayarrib'; $city = ''; break; // Рыбинск
	case 'ryazan': $region = 'msk_cl%3Acmkryzbars'; $city = ''; break; // Рязань
	case 'salavat': $region = 'ufa_cl%3Aufasalavat'; $city = ''; break; // Салават
	case 'samara': $region = 'smr_cl%3A'; $city = 'Самара'; break; // Самара
	case 'spb': $region = 'spb_cl%3A'; $city = 'Санкт-Петербург'; break; // Санкт-Петербург
	case 'saransk': $region = 'penza_cl%3Apnzsaransk'; $city = ''; break; // Саранск
	case 'saratov': $region = 'srt_cl%3A'; $city = ''; break; // Саратов
	case 'sarov': $region = 'nnov_cl%3Anmsarov'; $city = ''; break; // Саров
	case 'sochi': $region = 'krd_cl%3Akrdsochi'; $city = ''; break; // Сочи
	case 'staryj-oskol': $region = 'vrzh_cl%3Avrzhstosk'; $city = ''; break; // Старый Оскол
	case 'sterlitamak': $region = 'ufa_cl%3Aufastr'; $city = ''; break; // Стерлитамак
	case 'taganrog': $region = 'rnd_cl%3Arndtagan'; $city = ''; break; // Таганрог
	case 'tambov': $region = 'vrzh_cl%3Avrntmkp'; $city = ''; break; // Тамбов
	case 'tver': $region = 'msk_cl%3Acmktver'; $city = ''; break; // Тверь
	case 'tolyatti': $region = 'smr_cl%3Asmrtol'; $city = ''; break; // Тольятти
	case 'tula': $region = 'tula_cl%3A'; $city = ''; break; // Тула
	case 'tyumen': $region = 'ekat_cl%3Aekattumen'; $city = ''; break; // Тюмень
	case 'ulyanovsk': $region = 'smr_cl%3Asmmboston'; $city = ''; break; // Ульяновск
	case 'ufa': $region = 'ufa_cl%3A'; $city = ''; break; // Уфа
	case 'cheboksary': $region = 'chb_cl%3A'; $city = 'Чебоксары'; break; // Чебоксары
	case 'chelyabinsk': $region = 'chlb_cl%3A'; $city = 'Челябинск'; break; // Челябинск
	case 'cherepovec': $region = 'yar_cl%3Ayarnas'; $city = ''; break; // Череповец
	case 'cherkessk': $region = 'stav_cl%3Astavcher'; $city = ''; break; // Черкесск
	case 'shahty': $region = 'rnd_cl%3Arndshachty'; $city = ''; break; // Шахты
	case 'ehngels': $region = 'srt_cl%3Asrtengstep'; $city = ''; break; // Энгельс
	case 'yaroslavl': $region = 'yar_cl%3A'; $city = ''; break; // Ярославль
  default:
    die("Unknown region\n");    
}

	$options = array(
       	//CURLOPT_COOKIEFILE      => '/var/www/polaris/engines/beru.ru/cookiessss_'.EXTRA_PARAM.'.txt',
       	CURLOPT_COOKIEJAR      	=> '/var/www/polaris/engines/xxx/cookies_'.EXTRA_PARAM.'.txt',
        CURLOPT_AUTOREFERER     => true,
        CURLOPT_FOLLOWLOCATION  => true,
				CURLOPT_CONNECTTIMEOUT => 60,
				CURLOPT_TIMEOUT        => 60, 
				CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => 0   
    );

$options 			= array(CURLOPT_COOKIE => '_space=' . $region); 	// Подставляем coockie региона
$urlStart 		= 'http://www.citilink.ru/search/?text=' . ENGINE_TYPE;				// Первая часть адреса
$urlEnd				= '';							 				// Вторая часть адреа и поисковая строка
$regexpLinks = "~BrandCategories__go-to-subcategory.*href=\"(.+)\"~isU";
$regexpP1	= "~class=\"page_listing\"(.*)</div>~isU";
$regexpP2 = "~<a.*>(.+)<~isU";
$regexpPrices = "~<div class=\"product_data__gtm-js(.+)ProductCardHorizontal__vendor-code~isU";


$regexpPrices2 = "~&quot;price&quot;:(.+),.*shortName&quot;:&quot;(.+)&quot;,.*href=\"(.+)\"~isU";






// Загрузка отсканированных ссылок:
foreach ($itemsArray as $key => $value) {
	$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
	//echo (time() - $date->format('U')).PHP_EOL; 
	if (time() - $date->format('U') <= 10400) {
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
if ($_GET) {
	$already_scanned = array();
}





	if ($iGlobalLoop > 0) {
		$AC->flush_requests();
		$AC->__set('callback','callback_one');
	}
	// Соберём ссылки на разделы с карточками и сразу определим пагинацию
	$qOfPagesArray = array(); // Создадим массив и выберем больший элемент (он будет содержать более точные данные)
	//$AC->get('https://www.citilink.ru/catalog/miksery/POLARIS/', NULL, $options);
	$AC->get('https://www.citilink.ru/brands/POLARIS/', NULL, $options);
	$AC->get('https://www.citilink.ru/brands/POLARIS/', NULL, $options);
	$AC->execute(WINDOW_SIZE);


	while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
		  $AC->flush_requests(); // Чистим массив запросов
		  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
		    $AC->get($urls, NULL, $options);
		  }
		  unset($urls);
		  $bad_urls = array();       // Чистим массив URL-ов для следующего (возможного) цикла    
		  $AC->execute(WINDOW_SIZE); // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
		}	
	unset($urls);


	print_r($directLinks);

	$AC->flush_requests();
	$AC->__set('callback','callback_two');


	$is_any = 0;
	foreach ($directLinks as $link) {
		if (!in_array('https://www.citilink.ru'.$link, $already_scanned)) {
			echo 'сканирую адрес:'.PHP_EOL.'https://www.citilink.ru'.$link.PHP_EOL;
			if (strripos($link, 'polaris') !== false) {
				$AC->get('https://www.citilink.ru'.$link, NULL, $options);
				$is_any = 1;
			}
		} else {
			echo 'уже сканировал:'.PHP_EOL.'https://www.citilink.ru'.$link.PHP_EOL;
		}
	}
	if ($is_any) {
		$AC->execute(WINDOW_SIZE);
	}
	

	while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
		  $AC->flush_requests(); // Чистим массив запросов
		  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
		    $AC->get($urls, NULL, $options);
		  }
		  unset($urls);
		  $bad_urls = array();       // Чистим массив URL-ов для следующего (возможного) цикла    
		  $AC->execute(WINDOW_SIZE); // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
		}	
	unset($urls);

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';

/*
if (ENGINE_LOOP == 2) {
	$already_scanned = array();
	$proxy_array = glob('/var/www/polaris/engines/citilink.ru/proxy/moscow.txt');

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

	$options = array(
       	CURLOPT_COOKIEFILE      => '/var/www/polaris/engines/citilink.ru/cookies/moscow.txt',
       	//CURLOPT_COOKIEJAR      	=> '/var/www/polaris/engines/citilink.ru/cookies/moscow.txt',
        CURLOPT_AUTOREFERER     => true,
        CURLOPT_FOLLOWLOCATION  => true,
				CURLOPT_CONNECTTIMEOUT => 60,
				CURLOPT_TIMEOUT        => 90, 
				CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => 0   
    );

	if ($iGlobalLoop > 0) {
		$AC->flush_requests();
		$AC->__set('callback','callback_one');
	}
	// Соберём ссылки на разделы с карточками и сразу определим пагинацию
	$qOfPagesArray = array(); // Создадим массив и выберем больший элемент (он будет содержать более точные данные)
	$AC->get('http://www.citilink.ru/search/?text=' . ENGINE_TYPE, NULL, $options);
	$AC->get('http://www.citilink.ru/search/?text=' . ENGINE_TYPE, NULL, $options);
	$AC->get('http://www.citilink.ru/search/?text=' . ENGINE_TYPE, NULL, $options);
	$AC->get('http://www.citilink.ru/search/?text=' . ENGINE_TYPE, NULL, $options);
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
		  $AC->flush_requests(); // Чистим массив запросов
		  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
		    $AC->get($urls, NULL, $options);
		  }
		  unset($urls);
		  $bad_urls = array();       // Чистим массив URL-ов для следующего (возможного) цикла    
		  $AC->execute(1); // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
		}	
	unset($urls);
	//print_r($directLinks);

	$AC->flush_requests();
	$AC->__set('callback','callback_two');

	//$is_any = 0
	foreach ($directLinks as $link) {
		if (!in_array('https://www.citilink.ru'.$link, $already_scanned)) {
			echo 'сканирую адрес:'.PHP_EOL.'https://www.citilink.ru'.$link.PHP_EOL;
			$AC->get('https://www.citilink.ru'.$link, NULL, $options);
			//$is_any = 1;
		} else {
			echo 'уже сканировал:'.PHP_EOL.'https://www.citilink.ru'.$link.PHP_EOL;
		}
	}
	$AC->get('https://www.citilink.ru/catalog/large_and_small_appliances/small_appliances/kettles/POLARIS/?available=1&status=55395790&p=2', NULL, $options);
	//if ($is_any) {
	$AC->execute(WINDOW_SIZE);
	//}
	
	while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
		  $AC->flush_requests(); // Чистим массив запросов
		  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
		    $AC->get($urls, NULL, $options);
		  }
		  unset($urls);
		  $bad_urls = array();       // Чистим массив URL-ов для следующего (возможного) цикла    
		  $AC->execute(2); // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
		}	
	unset($urls);
	file_put_contents('/var/www/polaris/engines/citilink.ru/data_profile/'.date("d.m.y").'_citilink.ru.profile_polaris_moscow.data', serialize($itemsArray));
	$filename = '';

} else {
}
*/

/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
	global $regexpLinks;
	global $directLinks;
	global $regexpPrices;
	global $regexpPrices2;

	global $itemsArray;
	global $city;
	global $time_start;
	global $bad_urls;

	//if (ENGINE_LOOP == 2) {
		file_put_contents('/var/www/polaris/engines/citilink.ru/cont.txt', $response);
	//}

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]); 

  if ($info['http_code'] !== 200) {            
    // (stripos($info['url'], ENGINE_CURR)) {
    $bad_urls[] = $request->url;
    if (round(microtime(1) - $time_start, 0) >= 540) $bad_urls=array();
    //}
  } else {

		preg_match_all($regexpLinks, $response, $matches, PREG_SET_ORDER);
		//print_r($matches);
		if ($matches) {
			foreach ($matches as $key => $value) {
				if (!in_array($value[1], $directLinks)) {
					if (trim($value[1]) != 'https://www.facebook.com/citilink.ru') {
						$directLinks[] = trim($value[1]).'?view_type=list';
					}
				}
			}
		}

		$directLinks = array_unique($directLinks);

		preg_match("~class=\"MainHeader__city\">.*>(.+)<~isU", $response, $region);
		//print_r($region);
		echo 'request  region: '.$city.PHP_EOL;
		echo 'response region: '.trim($region[1]).PHP_EOL;	

		if (stripos(trim($region[1]), $city)  !== false) {

	  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  	
	  	//print_r($matches2);

	  	//file_put_contents('/var/www/polaris/engines/citilink.ru/match.txt', print_r($matches2, 1));

	  	foreach ($matches2 as $key) {
	  		
				preg_match($regexpPrices2, $key[0], $matches);
				
				//print_r($matches);

	      $matches[2] = trim($matches[2]);
				$vowels = array("\n", "\r", "\t", "\x0B", "&#8203;", "&nbsp;", "&emsp;", "&ensp;");
				$matches[2] = str_replace($vowels, ' ', $matches[2]);
				$matches[2] = str_replace(';', '', $matches[2]);

				$matches[1] = preg_replace('~[\D]+~', '' , $matches[1]);

				if (strripos($key[0], 'Нет в наличии') === false) {
					$matches[1] = preg_replace('~[\D]+~', '' , $matches[1]);
				} else {
					$matches[1] = '0';
				}

				$matches[3] = 'https://www.citilink.ru'.trim($matches[3]);

				if ($matches[3] && $matches[2]) {
					price_change_detect($matches[3], $matches[2], $matches[1], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[3])] = array(
						$matches[2], 
						preg_replace('~[\D]+~', '' , $matches[1]),
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url
					);
					AngryCurl::add_debug_msg($matches[3].' | '.$matches[2].' | '.$matches[1]);
				}
	  		
			}
			//file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
		}	
	}
}


function callback_two($response, $info, $request) {
  global $regexpP1;
  global $regexpP2;
  global $qOfPaginationPages;  
	global $regexpPrices;
	global $regexpPrices2;


	global $itemsArray;
	global $errorsArray;
  global $time_start;
  global $bad_urls;
  global $city;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]); 

  if ($info['http_code'] !== 200) {            
    // (stripos($info['url'], ENGINE_CURR)) {
    $bad_urls[] = $request->url;
    if (round(microtime(1) - $time_start, 0) >= 540) $bad_urls=array();
    //}
  } else {
  	sleep(1);

		preg_match("~class=\"MainHeader__city\">.*>(.+)<~isU", $response, $region);
		echo 'request  region: '.$city.PHP_EOL;
		echo 'response region: '.trim($region[1]).PHP_EOL;	

		if (stripos(trim($region[1]), $city)  !== false) {

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

	  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
 	
	  	//print_r($matches2);
	  	//file_put_contents('/var/www/polaris/engines/citilink.ru/1.txt', print_r($matches2,1));
	  	foreach ($matches2 as $key) {
	  		
				preg_match($regexpPrices2, $key[0], $matches);
				
				//print_r($matches);

	      $matches[2] = trim($matches[2]);
				$vowels = array("\n", "\r", "\t", "\x0B", "&#8203;", "&nbsp;", "&emsp;", "&ensp;");
				$matches[2] = str_replace($vowels, ' ', $matches[2]);
				$matches[2] = str_replace(';', '', $matches[2]);

				if (strripos($key[0], 'Нет в наличии') === false) {
					$matches[1] = preg_replace('~[\D]+~', '' , $matches[1]);
				} else {
					$matches[1] = '0';
				}
				
					$matches[3] = 'https://www.citilink.ru'.trim($matches[3]);
				

				if ($matches[3] && $matches[2]) {
					price_change_detect($matches[3], $matches[2], $matches[1], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[trim($matches[3])] = array(
						$matches[2], 
						preg_replace('~[\D]+~', '' , $matches[1]),
						date("d.m.y-H:i:s"),
						$request->options[10004],
						$request->options[10018],
						$request->url
					);
					AngryCurl::add_debug_msg($matches[3].' | '.$matches[2].' | '.$matches[1]);
				}
	  		
			} 
			//file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	  }
	}
}




function regular_one() {
	global $regexp1;
	global $regexp2;

	global $regexpName;
	global $regexpName2;

	global $itemsArray;
	global $city;
	global $cookfilepath;

	// Переделаем кукисы в правильный стандарт
	$cookfilepath = AC_DIR.'/engines/'.ENGINE_CURR.'/cookies/'.EXTRA_PARAM.'.txt';
	if (!file_exists($cookfilepath) /*|| time() - filemtime($cookfilepath) > 3600*/) {
		die('нет кукисов или старый файл '.$cookfilepath.PHP_EOL);
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
	$links = 'https://www.citilink.ru/brands/polaris/all,https://www.citilink.ru/brands/polaris/all?page=2,https://www.citilink.ru/brands/polaris/all?page=3';;
	$cmd = 'timeout -k 800s 801s casperjs /var/www/polaris/engines/citilink.ru/club_prices.js --ignore-ssl-errors=true --ssl-protocol=any "'.$links.'" '.escapeshellarg($useragent).' '.$matches_proxy[1].' '.$matches_proxy[2].' '.$matches_proxy[3].' '.$matches_proxy[4];
	//die();
	if ($links) {
		echo 'request: '.$cmd.PHP_EOL;
		$response = exec($cmd, $out, $err);
		$response = implode(" ", $out);
	}
	
	if ($response) {
  	preg_match_all($regexp1, $response, $matches2, PREG_SET_ORDER);
  	//print_r($matches2);
  	foreach ($matches2 as $key) {  		
			preg_match($regexp2, $key[0], $matches);
			//print_r($matches);
			$matches[1] = trim($matches[1]);

			if (stripos($matches[1], 'http') === false) {
				$matches[1] = 'https://www.citilink.ru'.trim($matches[1]);
			} else {
				$matches[1] = trim($matches[1]);
			}

			if (stripos($matches[1], '?') !== false) {
				$matches[1] = substr($matches[1], 0, stripos($matches[1], '?'));
			}

			$matches[3] = html_entity_decode($matches[3]);
			$matches = clean_info($matches, array(1,2,3));

			preg_match("/[\d]+/", $matches[2], $matchd);
			if (@$matchd[0] <= 0) {
				$pos_without_name[$matches[1]] = 1;
			}

			if ($matches != false) {
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], 'manual', $useragent, ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $matches_proxy[1].':'.$matches_proxy[2], $useragent);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			} 							  		
		}
	  //file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	  file_put_contents('/var/www/polaris/engines/citilink.ru/data_profile/'.date("d.m.y").'_citilink.ru.profile_polaris_moscow.data', serialize($itemsArray));
		
		// 
		//exec('php /var/www/polaris/engines/citilink.ru/citilink.ru.profile.php', $out, $err);

		return 1;
	} else {
		return 0;
	}
}
