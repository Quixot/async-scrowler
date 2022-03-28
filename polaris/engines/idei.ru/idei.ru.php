<?php
/**
 * idei.ru
 */
sleep(10000);
switch (EXTRA_PARAM) {
 	case 'yekaterinburg': $region = '66'; $domain = ''; break;
 	case 'chelyabinsk': $region = '74'; $domain = ''; break;
	//case 'krasnoturinsk': $region = '66'; $domain = ''; break;
	case 'kurgan': $region = '45'; $domain = ''; break;
	//case 'lyantor': $region = '86'; $domain = ''; break;
	case 'magnitogorsk': $region = '74'; $domain = 'mgn.'; break;
	case 'miass': $region = '74'; $domain = 'miass.'; break;
	case 'nizhnij-tagil': $region = '66'; $domain = 'nt.'; break;
	case 'pervouralsk': $region = '66'; $domain = 'pervouralsk.'; break;
	case 'perm': $region = '59'; $domain = ''; break;
	//case //'revda': $region = '66'; $domain = ''; break;
	case 'surgut': $region = '86'; $domain = ''; break;
	case 'tobolsk': $region = '72'; $domain = 'tobolsk.'; break;
	case 'tyumen': $region = '72'; $domain = ''; break;
 	default:
 		die("Unknown region\n");  	 		
}
$urlStart 		= 'http://www.'.$domain.'idei' . $region . '.ru/search/page_num/';
$urlEnd 			= '/?stext='.ENGINE_TYPE;
$regexpP1 		= "~<ul class=\"cfilter fl clr mb20\">(.+)</ul>~isU";
$regexpP2 		= "~<li><a.*>(.+)<~isU";
$regexpPrices1 = "~<div class=\"c-div\"><a href=\"(.+)\".*class=\"cat02\">(.+)<~isU";
$regexpPrices2 = "~<div class=\"control c-div\">.*<big>(.+)<.*data-e-link-name=\"(.+)\"~isU";
$regexpReg = "~class=\"region\">(.+)<~isU";
/**
 * МЕГАЦИКЛ
 */
$options = array(
				CURLOPT_COOKIEJAR       => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
        CURLOPT_COOKIEFILE      => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
        CURLOPT_CONNECTTIMEOUT 	=> 120,
        CURLOPT_TIMEOUT        	=> 120,
        CURLOPT_REFERER         => 'http://www.'.$domain.'idei'.$region.'.ru/',
				CURLOPT_AUTOREFERER     => TRUE,
				CURLOPT_FOLLOWLOCATION  => TRUE,
				CURLOPT_HEADER 					=> false, 
        CURLOPT_SSL_VERIFYPEER 	=> 0,
        CURLOPT_SSL_VERIFYHOST 	=> 0        
    );

for ($iGlobalLoop = 0; $iGlobalLoop < ENGINE_LOOP; $iGlobalLoop++) {
	if ($iGlobalLoop > 0) {
		$AC->flush_requests();
		$AC->__set('callback','callback_one');
	}	
	// Узнаем, сколько позиций в пагинации
	//$AC->get($urlStart . '1' . $urlEnd, null, $options);
	//$AC->get($urlStart . '2' . $urlEnd, null, $options);
	//$AC->get($urlStart . '3' . $urlEnd, null, $options);
	$AC->get('http://www.idei'.$region.'.ru/shop/OF006520/brand/Polaris/', null, $options);
	$AC->get('http://www.idei'.$region.'.ru/shop/OF006520/brand/Polaris/', null, $options);
	$AC->get('http://www.idei'.$region.'.ru/shop/00002558/brand/Polaris/', null, $options);
	$AC->get('http://www.idei'.$region.'.ru/shop/00001945/brand/Polaris/', null, $options); // Соковыжималки
	$AC->get('http://www.idei'.$region.'.ru/shop/00000448/brand/Polaris/', null, $options); // Блендеры
	$AC->get('http://www.idei'.$region.'.ru/shop/00002928/brand/Polaris/', null, $options); // Чайники
	$AC->get('http://www.idei'.$region.'.ru/shop/66862/brand/Polaris/', null, $options); // Утюги
	$AC->get('http://www.idei'.$region.'.ru/shop/00001059/brand/Polaris/', null, $options); // Машинки для стрижки
	$AC->get('http://www.idei'.$region.'.ru/shop/66292/brand/Polaris/', null, $options); // Парогенегаторы
	$AC->get('http://www.idei'.$region.'.ru/shop/OF006525/brand/Polaris/', null, $options); // 
	$AC->get('http://www.idei'.$region.'.ru/shop/00001231/brand/Polaris/', null, $options); // обогреватели
	$AC->get('http://www.idei'.$region.'.ru/shop/OF006525/brand/Polaris/', null, $options); // плойки



	//$AC->get($urlStart . '1' . $urlEnd, null, $options);
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
		  $AC->flush_requests(); // Чистим массив запросов
		  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
		    $AC->get($urls, null, $options); 
		  }
		  unset($urls);

		  $bad_urls = array();    // Чистим массив URL-ов для следующего (возможного) цикла    
		  $AC->execute(WINDOW_SIZE);       // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
	}
	unset($urls);

	// Костыль
	//if ($qOfPaginationPages < 1) {
		//$qOfPaginationPages = 8;
	//}

	if ($qOfPaginationPages > 1) {
		$AC->flush_requests();
		$AC->__set('callback','callback_two');		

		echo 'Количество страниц: ' . $qOfPaginationPages . "\n";

		for ($i = 1; $i <= $qOfPaginationPages; $i++) {
		  $AC->get($urlStart . $i . $urlEnd, null, $options);
		}
		$AC->execute(WINDOW_SIZE);

		while ($bad_urls) {
		  $AC->flush_requests();
		  foreach ($bad_urls as $urls) {
		    $AC->get($urls, null, $options); 
		  }
		  unset($urls);
		  $bad_urls = array();
		  $AC->execute(WINDOW_SIZE);
		}
		unset($urls);
	}
	// Сохраним массив в переменную
	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
}
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP1;
  global $regexpP2;
  global $qOfPaginationPages;
	global $regexpPrices1;
	global $regexpPrices2;	
	global $itemsArray;
	global $errorsArray;
	global $bad_urls;
	global $time_start;
	global $region;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {            
    $bad_urls[] = $request->url;
    if (round(microtime(1) - $time_start, 0) >= 1600) { $bad_urls = array(); }
  } else {
  	//file_put_contents('/var/www/polaris/engines/idei.ru/'.time(), $response);
 	
		preg_match($regexpP1, $response, $matches);
		//print_r($matches);
		preg_match_all($regexpP2, $matches[0], $matches2);
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

		preg_match_all($regexpPrices1, $response, $matches1, PREG_SET_ORDER); // Все карточки товара
		//print_r($matches1);
		preg_match_all($regexpPrices2, $response, $matches2, PREG_SET_ORDER); // Все карточки товара
		//print_r($matches2);

		$arrayOne = array();

		if ($matches1 && $matches2) {
			foreach ($matches1 as $key => $value) {
				$arrayOne[$value[2]] = array(
					'url' => $value[1],
					'price' => '0'
				);
			}

			foreach ($matches2 as $key => $value) {
				$arrayOne[$value[2]]['price'] = $value[1];
			}
		}
		//print_r($arrayOne);sleep(5);

		foreach ($arrayOne as $key => $value) {
			$value['url'] = trim($value['url']);
			$key = trim($key);
			$value['price'] = preg_replace('~[\D]+~', '' , $value['price']);

		  price_change_detect('http://www.idei' . $region . '.ru' . $value['url'], $key, $value['price'], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
		  $itemsArray['http://www.idei' . $region . '.ru' . $value['url']] = array($key, $value['price'], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url
			);			
			AngryCurl::add_debug_msg( $value['url'].' | '.$key.' | '.$value['price']);
		}
  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices1;
	global $regexpPrices2;	
	global $itemsArray;
	global $errorsArray;
	global $bad_urls;
	global $time_start;
	//global $regexpRegion;
	global $region;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {
		$bad_urls[] = $request->url;
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 1800) { $bad_urls = array(); }       
  } else {
		preg_match_all($regexpPrices1, $response, $matches1, PREG_SET_ORDER); // Все карточки товара
		//print_r($matches1);
		preg_match_all($regexpPrices2, $response, $matches2, PREG_SET_ORDER); // Все карточки товара
		//print_r($matches2);

		$arrayOne = array();

		if ($matches1 && $matches2) {
			foreach ($matches1 as $key => $value) {
				$arrayOne[$value[2]] = array(
					'url' => $value[1],
					'price' => '0'
				);
			}

			foreach ($matches2 as $key => $value) {
				$arrayOne[$value[2]]['price'] = $value[1];
			}
		}
		//print_r($arrayOne);sleep(5);

		foreach ($arrayOne as $key => $value) {
			$value['url'] = trim($value['url']);
			$key = trim($key);
			$value['price'] = preg_replace('~[\D]+~', '' , $value['price']);

		  price_change_detect('http://www.idei' . $region . '.ru' . $value['url'], $key, $value['price'], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
		  $itemsArray['http://www.idei' . $region . '.ru' . $value['url']] = array($key, $value['price'], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url
			);			
			AngryCurl::add_debug_msg( $value['url'].' | '.$key.' | '.$value['price']);
		}
	} 	
}
