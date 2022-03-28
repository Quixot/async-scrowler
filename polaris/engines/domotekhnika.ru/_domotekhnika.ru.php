<?php
/**
 * domotekhnika.ru
 */
switch (EXTRA_PARAM) {
	case 'blagoveschensk': $region = 'blagoveshhensk.'; break;
	case 'vladivostok': $region = 'vladivostok.'; break;
	case 'ulan-udeh': $region = 'ulan-ude.'; break;
	case 'habarovsk': $region = 'habarovsk.'; break;
 	default:
 		die("Unknown region\n");  	 		
}

$urlStart = 'http://'.$region.'domotekhnika.ru/search?search=' . ENGINE_TYPE;
$urlEnd   = '&page=';
$regexpP1 = "~class=\"pagination\">(.+)</ul>~isU";
$regexpP2 = "~<a.*>(.+)<~isU";
$regexp1  = "~class=\"b-product-plate\" data-id=(.+)class=\"b-href-compare_dashed\"~isU";
//$regexp2  = "~<a.*<a.*href=\"(.+)\".*>(.+)<.*price-big\">(.+)<~isU";
$regexp2  = "~.*class=\"i-clamp-plates__item.*href=\"(.+)\".*>(.+)<~isU";
$regexp3  = "~<div class=\"b-buy__now.*>(.+)<~isU";


	// Соберём ссылки на разделы с карточками и сразу определим пагинацию
	$qOfPagesArray = array(); // Создадим массив и выберем больший элемент (он будет содержать более точные данные)
	$AC->get($urlStart);
	$AC->get($urlStart);
	$AC->get($urlStart);
	$AC->get($urlStart);
	$AC->execute(4);

	$AC->flush_requests();
	$AC->__set('callback','callback_two');

	if ($qOfPaginationPages <= 0) { $qOfPaginationPages = 1; } // Если к-во страниц не определилось, сканируем хотя бы одну, иначе будет ошибка Window size
	//echo 'Количество страниц: ' . $qOfPaginationPages . "\n";

	for ($i = 1; $i <= $qOfPaginationPages; $i++) {
		$AC->get($urlStart . $urlEnd . $i); 
	}

	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {
		if (round(microtime(1) - $time_start, 0) >= 180) break;
	  $AC->flush_requests();
	  foreach ($bad_urls as $url => $attr) {
	    $AC->get($url, null, $options);   
	  }
	  $bad_urls = array();
	  $AC->execute(WINDOW_SIZE);
	}

/**
 * Callback Three
 */
	$AC->add_debug_msg('Callback Three');
	$AC->flush_requests();
	$AC->__set('callback','callback_three');

	//echo "\n" . 'itemsArray: ' . count($itemsArray) . "\n";

	foreach ($itemsArray as $aurl => $stuff) {
		$AC->get($aurl);
		$AC->add_debug_msg($aurl); // Проверим, какие адреса записываются для выполнения   
	}
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {
		if (round(microtime(1) - $time_start, 0) >= 180) break;
	  $AC->flush_requests();
	  foreach ($bad_urls as $url => $attr) {
	    $AC->get($url, null, $options);   
	  }
	  $bad_urls = array();
	  $AC->execute(WINDOW_SIZE);
	}


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP1;
  global $regexpP2;
  global $qOfPaginationPages;  
  global $bad_urls;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {                

  } else {
		preg_match($regexpP1, $response, $matches);
		print_r($matches);
		preg_match_all($regexpP2, $matches[1], $matches2);
		print_r($matches2);
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
  }
}

function callback_two($response, $info, $request) {
	global $regexp1;
	global $regexp2;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200 || !$response) {
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);        
  } else {	
  	preg_match_all($regexp1, $response, $matches2, PREG_SET_ORDER); //
  	print_r($matches2);
		if (stripos($info['url'], ENGINE_CURR) !== false && !$response && strripos($response, '</html') === false) {	      
	    $bad_urls[$request->url] = array(
	    		$info['http_code'],
	    		$request->options[10004]
	    	);
		} else {  	
	  	foreach ($matches2 as $key) {  		
				preg_match($regexp2, $key[1], $matches);
				print_r($matches);
				if ($matches[1]) {
					if (strripos($key[1], 'В наличии') !== false) {
						$itemsArray[trim($matches[1])] = array(trim($matches[2]), $itemsArray[trim($matches[1])][1], date("d.m.y-H:i:s"), $request->options[10004]);	//trim(preg_replace('~[^\d]+~', '' ,$matches[3]))	
						//echo trim($matches[1]) . "\n";
					} else {
						$itemsArray[trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), $request->options[10004]);
						//echo trim($matches[1]) . " - null\n";					
					}
				} else {
					//echo "\nBAD URL: " . $info['url'] . "\n";
				}							  		
			}
		} 	
  }
}

function callback_three($response, $info, $request) {
	global $regexp3;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);      
  } else {
		preg_match($regexp3, $response, $matches);		
		print_r($matches);
		//echo "\n" . $info['url'] . ' - ' . $info['http_code'] . "\n";		
		if (@$matches[1] && strripos($info['url'], ENGINE_CURR) !== false) {
			price_change_detect($request->url, $itemsArray[$info['url']][0], trim(preg_replace('~[^\d]+~', '' , $matches[1])), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
			$itemsArray[$info['url']][1] = preg_replace('~[^\d]+~', '' , $matches[1]);		
			//echo 'price - ' . preg_replace('~[^\d]+~', '' , $matches[1]) . "\n";		
		} else {
			//echo "DEAD\n";
	    if (stripos($info['url'], ENGINE_CURR) !== false && $response && strripos($response, '</html') === false) {	      
	      $bad_urls[] = $info['url'];
	    }
			////echo substr($response, 100, 500);
			//$tempp = //print_r($request, true);
			//file_put_contents(time(), $info['url'] . "\n" . $tempp . "\n" . $response);
		}
	}
}