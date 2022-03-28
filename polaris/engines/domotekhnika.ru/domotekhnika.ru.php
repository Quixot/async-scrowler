<?php
/**
 * domotekhnika.ru
 */
switch (EXTRA_PARAM) {
	case 'blagoveschensk': $region = 'blagoveshhensk.'; break;
	case 'vladivostok': 
		$region = ''; 
		$city = 'Владивосток';
		$options = array(
								//CURLOPT_COOKIEJAR       => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
        				//CURLOPT_COOKIEFILE      => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_AUTOREFERER     => TRUE,
                CURLOPT_FOLLOWLOCATION  => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HEADER => true, 
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0
		);
		break;
	case 'ulan-udeh': $region = 'ulan-ude.'; break;
	case 'habarovsk': 
		$region = ''; 
		$city = 'Хабаровск';
		$options = array(
									//CURLOPT_COOKIEJAR       => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
	        				CURLOPT_COOKIEFILE      => '/var/www/polaris/engines/domotekhnika.ru/cookies.txt',
									//CURLOPT_COOKIE => '_ym_d=1607590818',
	                CURLOPT_CONNECTTIMEOUT => 30,
	                CURLOPT_TIMEOUT        => 30,
	                CURLOPT_AUTOREFERER     => TRUE,
	                CURLOPT_FOLLOWLOCATION  => TRUE,
	                CURLOPT_RETURNTRANSFER => TRUE,
	                CURLOPT_HEADER => true, 
	                CURLOPT_SSL_VERIFYPEER => 0,
	                CURLOPT_SSL_VERIFYHOST => 0
		);
		break;
	case 'cheboksary': $region = 'cheboksary.'; $city = 'Чебоксары'; break;
 	default:
 		die("Unknown region\n");  	 		
}

$regexpP1 = "~class=\"b-catalog\"(.+)menu-categories-search~isU";
$regexpP2 = "~i-font_type_thin-grey\">\((.+)\)<~isU";
$regexp1 = "~ProductCard(.+)ProductInstallment~isU";//<!----></div></div></div>
$regexp1_null = "~ProductCard(.+)class=\"lh-1\"~isU";
$regexp2  = "~<a href=.*<a href=\"(.+)\".*class=\"title.*>(.+)<.*class=\"price\".*>(.+)<~isU";
$regexp3  = "~<a href=.*<a href=\"(.+)\".*class=\"title.*>(.+)<~isU";
$bad_urls = array();

$qOfPagesArray = array(); // Создадим массив и выберем больший элемент (он будет содержать более точные данные)


	$directLinks = explode("\n", file_get_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/'.ENGINE_TYPE.'.txt'));
	array_walk($directLinks, 'trim_value');

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
		//print_r($already_scanned); 
	} else {
		$already_scanned = array();
	}


	$is_any = 0;
	for ($i = 0; $i < count($directLinks); $i++) {
		if (!in_array('https://'.$region.$directLinks[$i], $already_scanned)) {
			echo 'сканирую адрес:'.PHP_EOL.'https://'.$region.$directLinks[$i].PHP_EOL;
			$AC->get('https://'.$region.$directLinks[$i], null, $options);
			$is_any = 1;
		} else {
			echo 'уже сканировал:'.PHP_EOL.'https://'.$region.$directLinks[$i].PHP_EOL;
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

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
	global $regexp1;
	global $regexp1_null;
	global $regexp2;
	global $regexp3;
	global $city;
	global $itemsArray;
	global $errorsArray;
	global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {
  	if ($info['http_code'] !== 404) {
    	$bad_urls[] = $request->url;   
    	if (round(microtime(1) - $time_start, 0) >= 800) $bad_urls=array();  
    }   
  } else {	
  	//file_put_contents('/var/www/polaris/engines/domotekhnika.ru/content.txt', $response);//die();
  	preg_match("~i-pin-city.*svg>(.+)<~isU", $response, $matchesRegion);
  	$matchesRegion[1] = trim($matchesRegion[1]);
  	AngryCurl::add_debug_msg($matchesRegion[1].' | '.$city);

  	if ($matchesRegion[1] == $city) {
	  	preg_match_all($regexp1, $response, $matches2, PREG_SET_ORDER); //
	  	if (!$matches2) {
	  		preg_match_all($regexp1_null, $response, $matches2, PREG_SET_ORDER); 		
	  	}

	  	//print_r($matches2);
	  	
		  foreach ($matches2 as $key) {  		
				preg_match($regexp2, $key[1], $matches);
				//print_r($matches);
				if (@$matches[1]) {
						$matches[1] = 'https://domotekhnika.ru'.strtok($matches[1], '?');
						$matches[2] = trim($matches[2]);
						$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);
						//$matches = clean_info($matches, array(1,2,3));
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
				} else {
					preg_match($regexp3, $key[1], $matches);
					//print_r($matches);
						$matches[1] = 'https://domotekhnika.ru'.strtok($matches[1], '?');
						$matches[2] = trim($matches[2]);
						$matches[3] = '0';
						//$matches = clean_info($matches, array(1,2,3));
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
			}
		} else {
	    $bad_urls[] = $request->url;   
	    if (round(microtime(1) - $time_start, 0) >= 800) $bad_urls=array();  
			AngryCurl::add_debug_msg('Регион не совпадает');
		}	
  }
}
