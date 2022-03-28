<?php
/**
 * 123.ru
 */

switch (EXTRA_PARAM) {
  case 'moscow': 
  	$region = '18413';
  	$geo = '15238%7C7700000000000%7C20';
  	$regionRu = 'Москва и Подмосковье';
    break;
  case 'spb':
    $region = '111';
    $geo = '4364%7C7800000000000%7C18';
    $regionRu = 'Санкт-Петербург';
    break;
  case 'rostov':
  	$region = '18413';
  	$geo = '6188%7C6100000100000%7C26';
  	$regionRu = 'Ростов-на-Дону';
    break;
  case 'novosibirsk':
  	$region = '18413';
  	$geo = '16465%7C5400000100000%7C22';
  	$regionRu = 'Новосибирск';
  	break;
 	case 'yekaterinburg':
 		$region = '18413';
 		$geo = '6104%7C6600000100000%7C49';
 		break;
 	case 'chelyabinsk':
 		$region = '18413';
 		$geo = '5530%7C7400000100000%7C36';
 		$regionRu = 'Челябинск';
 		break;
 	case 'volgograd':
 		$region = '18413';
 		$geo = '6153%7C3400000100000%7C14';
 		$regionRu = 'Волгоград';
 		break; 
 	case 'perm':
 		$region = '18413';
 		$geo = '6444%7C5900000100000%7C62';
 		$regionRu = 'Пермь';
 		break; 
 	case 'kazan':
 		$region = '18413';
 		$geo = '14055%7C1600000100000%7C4';
 		$regionRu = 'Казань';
 		break; 
 	case 'novgorod':
 		$region = '18413';
 		$geo = '4187%7C5200000100000%7C21';
 		$regionRu = 'Нижний Новгород';
 		break; 
 	case 'omsk':
 		$region = '18413';
 		$geo = '10024%7C5500000100000%7C61';
 		$regionRu = 'Омск';
 		break;
 	case 'samara':
 		$region = '18413';
 		$geo = '20348%7C6300000100000%7C28';
 		$regionRu = 'Самара';
 		break;
 	case 'ufa':
 		$region = '18413';
 		$geo = '10554%7C0200000100000%7C1';
 		$regionRu = 'Уфа';
 		break;
 	case 'krasnoyarsk':
 		$region = '18413';
 		$geo = '';
 		$regionRu = '284%7C2400000100000%7C8';
 		break;
 	case 'voronezh':
 		$region = '18413';
 		$geo = '6490%7C3600000100000%7C59';
 		$regionRu = 'Воронеж';
 		break;
 	case 'vladivostok':
 		$region = '18413';
 		$geo = '2584%7C2500000100000%7C9';
 		$regionRu = 'Владивосток';
 		break; 
 	default:
 		die("Unknown region\n");  	 		
}

switch (ENGINE_TYPE) {
	case 'polaris':
		$brand_code = '?f=13483:80357'; break;
	case 'vitek':
		$brand_code = '?f=13483:80825'; break;
	case 'maxwell':
		$brand_code = '?f=13483:80113'; break;
	case 'rondell':
		$brand_code = '?f=13483:80463'; break;
	case 'redmond':
		$brand_code = '?f=13483:80433'; break;
	default:
		die('No brand code'.PHP_EOL); 	break;
}

	$options 			 = array(CURLOPT_COOKIE => 'scity='.$region.';geo='.$geo); // Подставляем coockie региона
	$regexpP1	 		 = "~pagination-list clearfix(.+)</ul~isU";
	$regexpP2 		 = "~<a.*>(.+)<~isU";
	$regexpPrices1 = "~class=\"product-item(.+)</i></a></div></div></div>~isU";
	$regexpPrices2 = "~class=\"title-wr\".*href=\"(.+)\".*>(.+)<.*class=\"price\">(.+)<span~isU";
	$directLinks = explode("\n", file_get_contents('/var/www/engines/'.ENGINE_CURR.'/'.ENGINE_TYPE.'.txt'));
	array_walk($directLinks, 'trim_value');


	for ($i = 0; $i < count($directLinks); $i++) {
	  $AC->get($directLinks[$i].$brand_code.'&view=list', null, $options);  
	}
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {
		if (round(microtime(1) - $time_start, 0) >= 240) break;
	  $AC->flush_requests();
	  foreach ($bad_urls as $url => $attr) {
	    $AC->get($url, NULL, $options);
	  }
	  $bad_urls = array();
	  $AC->execute(WINDOW_SIZE);
	}

	if ($pagin_list) {
		$AC->flush_requests();
		$AC->__set('callback','callback_two');
		foreach ($pagin_list as $key => $value) {
			for ($i=2; $i <= $value ; $i++) { 
				$AC->get($key.'&p='.$i, null, $options); 
			}
		}
		$AC->execute(WINDOW_SIZE);
	}

	while ($bad_urls) {
		if (round(microtime(1) - $time_start, 0) >= 240) break;
	  $AC->flush_requests();
	  foreach ($bad_urls as $url => $attr) {
	    $AC->get($url, NULL, $options);
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
	global $regexpPrices1;
	global $regexpPrices2;
	global $itemsArray;
	global $bad_urls;
	global $time_start;
	global $pagin_list;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {            
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);
  } else {

		preg_match($regexpP1, $response, $matches);
		print_r($matches);
		@preg_match_all($regexpP2, $matches[1], $matches2);
		print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			//echo "key: " . $key . "\n";
			//echo "value:" . $value . "\n";
			if (is_numeric($value)) {
				$temparrpage[] = $value;
			}
		}

		if (@max($temparrpage) > $pagin_list[$request->url]) {
			$pagin_list[$request->url] = @max($temparrpage);	    	
		}


  	preg_match_all($regexpPrices1, $response, $matches2, PREG_SET_ORDER);
  	//print_r($matches2);
		foreach ($matches2 as $key) {
			if (strripos($key[1], 'instock visible') !== false) {
				preg_match($regexpPrices2, $key[1], $matches);
				
				$matches[1] = 'http://www.'.ENGINE_CURR.trim($matches[1]);
				$matches[2] = strip_tags($matches[2]);
				//$matches = clean_info($matches, array(1,2,3));
				//print_r($matches);
				if ($matches != false) {
					price_change_detect($matches[1], $matches[2], preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);						
					$itemsArray[$matches[1]] = array($matches[2], preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->options[10004]);		
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);		
				}
			}
		} 		
  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices1;
	global $regexpPrices2;
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
  	preg_match_all($regexpPrices1, $response, $matches2, PREG_SET_ORDER);
		foreach ($matches2 as $key) {
			if (strripos($key[1], 'instock visible') !== false) {
				preg_match($regexpPrices2, $key[1], $matches);
				$matches[1] = 'http://www.'.ENGINE_CURR.trim($matches[1]);
				$matches[2] = strip_tags($matches[2]);
				//$matches = clean_info($matches, array(1,2,3));
				//print_r($matches);
				if ($matches != false) {
					price_change_detect($matches[1], $matches[2], preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);						
					$itemsArray[$matches[1]] = array($matches[2], preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->options[10004]);		
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);		
				}
			}
		} 		
  }
}

