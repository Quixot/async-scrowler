<?php
/**
 * wildberries.ru
 */
switch (EXTRA_PARAM) {
 	case 'moscow': $region = 'cityId=77&regionId=0&city=%d0%9c%d0%be%d1%81%d0%ba%d0%b2%d0%b0&phone=84957755505&latitude=55,724667&longitude=37,788245'; break;
 	case 'spb': $region = 'cityId=78&regionId=78&city=%d0%a1%d0%b0%d0%bd%d0%ba%d1%82-%d0%9f%d0%b5%d1%82%d0%b5%d1%80%d0%b1%d1%83%d1%80%d0%b3&phone=88123098091&latitude=59,933754&longitude=30,267451'; break;
	case 'arhangelsk': $region = 'cityId=3916&regionId=29&city=%d0%90%d1%80%d1%85%d0%b0%d0%bd%d0%b3%d0%b5%d0%bb%d1%8c%d1%81%d0%ba&phone=88001007505&latitude=64,553034&longitude=40,496763'; break;
	case 'chelyabinsk': $region = 'cityId=5978&regionId=74&city=%d0%a7%d0%b5%d0%bb%d1%8f%d0%b1%d0%b8%d0%bd%d1%81%d0%ba&phone=83512020413&latitude=55,160283&longitude=61,400856'; break;
	case 'habarovsk': $region = 'cityId=3898&regionId=27&city=%d0%a5%d0%b0%d0%b1%d0%b0%d1%80%d0%be%d0%b2%d1%81%d0%ba&phone=84212929507&latitude=48,468976&longitude=135,064909'; break;
	case 'kazan': $region = 'cityId=2947&regionId=16&city=%d0%9a%d0%b0%d0%b7%d0%b0%d0%bd%d1%8c&phone=88001007505&latitude=55,800382&longitude=49,245734'; break;
	case 'krasnodar': $region = 'cityId=3332&regionId=23&city=%d0%9a%d1%80%d0%b0%d1%81%d0%bd%d0%be%d0%b4%d0%b0%d1%80&phone=88612041250&latitude=45,023877&longitude=38,970157'; break;
	case 'krasnoyarsk': $region = 'cityId=3358&regionId=24&city=%d0%9a%d1%80%d0%b0%d1%81%d0%bd%d0%be%d1%8f%d1%80%d1%81%d0%ba&phone=83912046355&latitude=56,012019&longitude=92,856226'; break;
	case 'novgorod': $region = 'cityId=5568&regionId=52&city=%d0%9d%d0%b8%d0%b6%d0%bd%d0%b8%d0%b9%20%d0%9d%d0%be%d0%b2%d0%b3%d0%be%d1%80%d0%be%d0%b4&phone=88312351250&latitude=56,325061&longitude=44,012811'; break;
	case 'novosibirsk': $region = 'cityId=5618&regionId=54&city=%d0%9d%d0%be%d0%b2%d0%be%d1%81%d0%b8%d0%b1%d0%b8%d1%80%d1%81%d0%ba&phone=83833121150&latitude=55,02583&longitude=82,91935'; break;
	case 'omsk': $region = 'cityId=5645&regionId=55&city=%d0%9e%d0%bc%d1%81%d0%ba&phone=88001007505&latitude=54,980012&longitude=73,372937'; break;
	case 'perm': $region = 'cityId=5681&regionId=59&city=%d0%9f%d0%b5%d1%80%d0%bc%d1%8c&phone=88001007505&latitude=58,011208&longitude=56,2314'; break;
	case 'petrozavodsk': $region = 'cityId=2881&regionId=10&city=%d0%9f%d0%b5%d1%82%d1%80%d0%be%d0%b7%d0%b0%d0%b2%d0%be%d0%b4%d1%81%d0%ba&phone=88001007505&latitude=61,789036&longitude=34,359688'; break;
	case 'pyatigorsk': $region = 'cityId=3885&regionId=26&city=%d0%9f%d1%8f%d1%82%d0%b8%d0%b3%d0%be%d1%80%d1%81%d0%ba&phone=88652206580&latitude=44,041209&longitude=43,065327'; break;
	case 'rostov': $region = 'cityId=3885&regionId=26&city=%d0%9f%d1%8f%d1%82%d0%b8%d0%b3%d0%be%d1%80%d1%81%d0%ba&phone=88652206580&latitude=44,041209&longitude=43,065327'; break;
	case 'samara': $region = 'cityId=167234&regionId=69&city=%d0%a1%d0%b0%d0%bc%d0%b0%d1%80%d0%b0&phone=88001007505&latitude=57,2015&longitude=33,0933'; break;
	case 'ufa': $region = 'cityId=2008&regionId=2&city=%d0%a3%d1%84%d0%b0&phone=88001007505&latitude=54,732732&longitude=55,95406'; break;
	case 'vladivostok': $region = 'cityId=3867&regionId=25&city=%d0%92%d0%bb%d0%b0%d0%b4%d0%b8%d0%b2%d0%be%d1%81%d1%82%d0%be%d0%ba&phone=88001007505&latitude=43,116206&longitude=131,882075'; break;
	case 'volgograd': $region = 'cityId=4355&regionId=34&city=%d0%92%d0%be%d0%bb%d0%b3%d0%be%d0%b3%d1%80%d0%b0%d0%b4&phone=88001007505&latitude=48,51019&longitude=44,542372'; break;
	case 'voronezh': $region = 'cityId=4388&regionId=36&city=%d0%92%d0%be%d1%80%d0%be%d0%bd%d0%b5%d0%b6&phone=84732045313&latitude=51,722806&longitude=39,177227'; break;
	case 'yekaterinburg': $region = 'cityId=5802&regionId=66&city=%d0%95%d0%ba%d0%b0%d1%82%d0%b5%d1%80%d0%b8%d0%bd%d0%b1%d1%83%d1%80%d0%b3&phone=83432366235&latitude=56,846674&longitude=60,625806'; break;
 	default:
 		die("Unknown region\n");  	 		
}

$options 			 = array(
								CURLOPT_COOKIE => '__wbl='.$region,
								CURLOPT_COOKIEJAR       => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
        				//CURLOPT_COOKIEFILE      => '/var/www/philips/engines/skidka.ua/xxx/1.txt',
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_TIMEOUT        => 40,
                CURLOPT_AUTOREFERER     => TRUE,
                CURLOPT_FOLLOWLOCATION  => TRUE,
                CURLOPT_HEADER => true, 
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0
	);

$urlStart = 'https://www.wildberries.ru/brands/polaris/all?pagesize=200';

$regexp_links = "~class=\"sidemenu(.+)~isU";

$regexpP1 = "~class=\"pageToInsert\"(.+)</div>~isU";
$regexpP2 = "~<a.*>(.+)<~isU";
$regexp1  = "~class=\"dtList\"(.+)block-dop-info~isU";
$regexp2  = "~href=\"(.+)\".*class=\"goods-name\">(.+)<.*class=\"price\">.*class=.*>(.+)</~isU";
$regexpName = "~class=\"pp\">Модель:<span>(.+)<~isU";
$regexpName2 = "~class=\"article j-article\">(.+)<~isU";
$regexpRegion = "~class=\"set-city-ip\".*>(.+)<~isU";


	$AC->get($urlStart, null, $options);
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {
		if (round(microtime(1) - $time_start, 0) >= 180 || $qOfPaginationPages) break;
	  $AC->flush_requests();
	  foreach ($bad_urls as $url => $attr) {
	    $AC->get($url, null, $options);   
	  }
	  $bad_urls = array();
	  $AC->execute(WINDOW_SIZE);
	}	

	if ($qOfPaginationPages > 1) {
		$AC->flush_requests();
		$AC->__set('callback','callback_two');
		for ($i = 1; $i <= $qOfPaginationPages; $i++) {
			$AC->get($urlStart.'&page='.$i, null, $options);
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
	}


	if ($pos_without_name) {
		$AC->flush_requests();
		$AC->__set('callback','callback_three');
		foreach ($pos_without_name as $key => $value) {
			$AC->get($key);
		}
		$AC->execute(WINDOW_SIZE);

		while ($bad_urls) {
			if (round(microtime(1) - $time_start, 0) >= 180) break;
		  $AC->flush_requests();
		  foreach ($bad_urls as $url => $attr) {
		    $AC->get($url);   
		  }
		  $bad_urls = array();
		  $AC->execute(WINDOW_SIZE);
		}
	}



// Сохраним массив в переменную
file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
/**
 * Формируем CSV файл
 *
 */
$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP1;
  global $regexpP2;
	global $regexp1;
	global $regexp2;
	global $itemsArray;
  global $qOfPaginationPages;  
  global $bad_urls;
  global $pos_without_name;
  global $regexpRegion;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {                
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);
  } else {
  	// Region
  	preg_match($regexpRegion, $response, $mReg);
  	AngryCurl::add_debug_msg('Region: '.$mReg[1]);
  	sleep(5);
		preg_match($regexpP1, $response, $matches);
		//print_r($matches);
		@preg_match_all($regexpP2, $matches[1], $matches2);
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

  	preg_match_all($regexp1, $response, $matches2, PREG_SET_ORDER);
  	//print_r($matches2);
  	foreach ($matches2 as $key) {  		
			preg_match($regexp2, $key[1], $matches);
			print_r($matches);
			$matches[1] = trim($matches[1]);
			$matches[3] = html_entity_decode($matches[3]);
			$matches = clean_info($matches, array(1,2,3));

			preg_match("/[\d]+/", $matches[2], $matchd);
			if (@$matchd[0] <= 0) {
				$pos_without_name[$matches[1]] = 1;
			}

			if ($matches != false) {
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004]);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			} 							  		
		}
  }
}

function callback_two($response, $info, $request) {
	global $regexp1;
	global $regexp2;
	global $itemsArray;
	global $bad_urls;
	global $pos_without_name;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);       
  } else {
  	preg_match_all($regexp1, $response, $matches2, PREG_SET_ORDER);
  	foreach ($matches2 as $key) {  		
			preg_match($regexp2, $key[1], $matches);
			$matches[1] = trim($matches[1]);
			$matches[3] = html_entity_decode($matches[3]);
			$matches = clean_info($matches, array(1,2,3));

			preg_match("/[\d]+/", $matches[2], $matchd);
			if (@$matchd[0] <= 0) {
				$pos_without_name[$matches[1]] = 1;
			}

			if ($matches != false) {
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004]);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			} 							  		
		}	
  }
}

function callback_three($response, $info, $request) {
	global $regexpName;
	global $regexpName2;
	global $itemsArray;
	global $bad_urls;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);       
  } else { 		
		preg_match($regexpName, $response, $matches);
		print_r($matches);
		if (@$matches[1]) {
			$itemsArray[$request->url][0] = $itemsArray[$request->url][0].' '.trim($matches[1]);
			AngryCurl::add_debug_msg(trim($matches[1]));							  		
		}	else {
			preg_match($regexpName2, $response, $matches);
			if (@$matches[1]) {
				$itemsArray[$request->url][0] = $itemsArray[$request->url][0].' '.trim($matches[1]);
				AngryCurl::add_debug_msg(trim($matches[1]));							  		
			}
		}
  }
}