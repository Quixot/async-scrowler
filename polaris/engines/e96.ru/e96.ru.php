<?php
/**
 * e96.ru
 */
switch (EXTRA_PARAM) { 
  case 'chelyabinsk':		$region = '185';	$domain = 'chelyabinsk.';	break;
  case 'novosibirsk':		$region = '110'; 	$domain = 'novosibirsk.'; break;
  case 'perm':					$region = '123'; 	$domain = 'perm.'; break;
  case 'yekaterinburg':	$region = '2'; 	 	$domain = ''; break; 
  case 'berezniki':			$region = '233'; 	$domain = 'berezniki.'; break;
  case 'kurgan':				$region = '220'; 	$domain = 'kurgan.'; break;
  case 'magnitogorsk':	$region = '318'; 	$domain = 'magnitogorsk.'; break;
  case 'miass':					$region = '478'; 	$domain = 'miass.'; break;
  case 'nadym':					$region = '1298'; $domain = 'nadym.'; break;
  case 'nizhnevartovsk':$region = '270'; 	$domain = 'nizhnevartovsk.'; break;
  case 'omsk':					$region = '891'; 	$domain = 'omsk.'; break;
  case 'samara':				$region = '573'; 	$domain = 'samara.'; break;
  case 'tyumen':				$region = '35'; 	$domain = 'tyumen.'; break;
  case 'nizhnij-tagil':	$region = '17'; 	$domain = 'nijnii-tagil.'; break; 
  //case 'ugorsk':				$region = '124'; 	$domain = 'yugorsk.'; break;
  case 'ufa':						$region = '272'; 	$domain = 'ufa.'; break;
	case 'revda': 				$region = '8'; 		$domain = ''; break;
	case 'oktyabrskij': 	$region = '1664'; $domain = 'otkyabrskij.'; break;
	case 'novyj-urengoj': $region = '1300'; $domain = 'novyj-urengoj.'; break;
	case 'hanty-mansijsk':$region = '1272'; $domain = 'hmao.'; break;
	case 'surgut': 				$region = '775'; 	$domain = 'surgut.'; break;
	//case 'barnaul': 			$region = '1983'; $domain = ''; break;
	case 'pervouralsk': 	$region = '7'; 		$domain = ''; break;
	case 'noyabrsk': 			$region = '1815'; $domain = 'nojabrsk.'; break;
	case 'nefteyugansk': 	$region = '1860'; $domain = 'neftejugansk.'; break;
	//case 'krasnoturinsk': $region = '187'; 	$domain = 'serov.'; break;
	case 'nyagan': 				$region = '219'; 	$domain = 'nyagan.'; break;
 	default: die("Unknown region\n");  	
}
$options 				= array(CURLOPT_COOKIE => 'e96_geoposition=' . $region);
$urlStart 			= 'http://'.$domain.'e96.ru/brands/'.ENGINE_TYPE;
$regexpCatalog	= "~<ul class=\"categories-min\">(.+)id=\"footer\"~isU";
$regexpCatalog2 = "~<li><a href=\"(.+)\".*</a>(.+)<~isU";
$regexpPrices 	= "~<li class=\"catalog-product\".*data-productid=\"(.+)</li>~isU";
$regexpPrices2 	= "~<a class=\"name\".*href=\"(.+)\".*>(.+)<.*class=\"price price_big\">(.+)<~isU";
$regexpPrices3 	= "~<a class=\"name\".*href=\"(.+)\".*>(.+)<~isU";
$regexpRegion 	= "~\"user-city\":\"(.+)\"~isU";

	$qOfPagesArray = array();
	$AC->get($urlStart, NULL, $options);
	$AC->get($urlStart, NULL, $options);
	$AC->execute(2);

	while ($bad_urls) {
		if (!$qOfPagesArray) {
		  $AC->flush_requests();
		  foreach ($bad_urls as $urls) {
		    $AC->get($urls, NULL, $options);
		  }
		  unset($urls);
		  $bad_urls = array();
		  $AC->execute(WINDOW_SIZE);
	  }
	}

	if ($qOfPagesArray) {
		$AC->flush_requests();
		$AC->__set('callback','callback_two');

		foreach ($qOfPagesArray as $key => $value) {
			for ($i = 1; $i <= ceil($value / 20); $i++) {
				if ($i == 1) {
					$AC->get($key , NULL, $options);
				} else {
					$AC->get($key . '?page=' . $i, NULL, $options);
				}			
			}
		}
		$AC->execute(WINDOW_SIZE);

		while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
		  $AC->flush_requests(); // Чистим массив запросов
		  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
		    $AC->get($urls, NULL, $options);
		  }
		  unset($urls);

		  $bad_urls = array();    // Чистим массив URL-ов для следующего (возможного) цикла    
		  $AC->execute(WINDOW_SIZE);       // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
		}	
		unset($urls);
	}



/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpCatalog;
  global $regexpCatalog2;
  global $domain;
  global $bad_urls;
  global $qOfPagesArray;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200 && !$qOfPagesArray) {            
    $bad_urls[] = $request->url;
    if (round(microtime(1) - $time_start, 0) >= 222) { $bad_urls = array(); } 
  } else {
  	preg_match($regexpCatalog, $response, $matchesLinks); // Блок со страницы каталога
    preg_match_all($regexpCatalog2, $matchesLinks[1], $matches, PREG_SET_ORDER); // Режем ссылки и к-во    
  	foreach ($matches as $key) {
  		$key[1] = trim($key[1]);
  		if (strripos($key[1], 'http') === false) { // Если адрес уже содержит http//
  			$key[1] = 'http://'.$domain.'e96.ru'.trim($key[1]);
  		}
			if (@$qOfPagesArray[$key[1]] < preg_replace('~[^\d]+~', '' , $key[2])) {
				$qOfPagesArray[$key[1]] = preg_replace('~[^\d]+~', '' , $key[2]);	
				AngryCurl::add_debug_msg($key[1]);
			}			
		}
  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpRegion;
	global $domain;
	global $region;	
	global $itemsArray;
	global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);  

  if ($info['http_code'] !== 200) {
    $bad_urls[] = $request->url;
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 300) $bad_urls = array();     
  } else {	
		preg_match($regexpRegion, $response, $matches_region);
		AngryCurl::add_debug_msg('Регион - '.$matches_region[1]);

		preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER);
	  foreach ($matches2 as $key) {
			preg_match($regexpPrices2, $key[1], $matches);
			if (@$matches[1]) {
				$itemsArray['http://'.$domain.'e96.ru'.trim($matches[1])] = array(trim($matches[2]), preg_replace('~[^\d]+~', '' , $matches[3]));
				AngryCurl::add_debug_msg(trim($matches[2]).' | '.preg_replace('~[^\d]+~', '' , $matches[3]));
			} else {					
				preg_match($regexpPrices3, $key[1], $matches);
				if (@$matches[1]) {
					$itemsArray['http://'.$domain.'e96.ru'.trim($matches[1])] = array(trim($matches[2]), '0');
					AngryCurl::add_debug_msg(trim($matches[2]).' | 0');			
				}
			} 
		}	
  }
}
