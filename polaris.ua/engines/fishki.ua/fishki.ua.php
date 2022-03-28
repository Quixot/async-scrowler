<?php
//fishki.ua
switch (EXTRA_PARAM) {
	case 'kiev': 		$city = 'Киев'; 		$region = '4'; 	break;
	case 'kharkov': $city = 'Харьков'; 	$region = '%D0%A5%D0%B0%D1%80%D1%8C%D0%BA%D0%BE%D0%B2'; break;
	case 'dnepr': 	$city = 'Днепр'; 		$region = '%D0%94%D0%BD%D0%B5%D0%BF%D1%80'; 	break;
	case 'odessa': 	$city = 'Одесса'; 	$region = '10'; break;
	case 'lvov': 		$city = 'Львов'; 		$region = '8'; 	break;
 	default:
 		die("Unknown region\n"); 		
}	

$regexpP 			 = "~class=\"pagination(.+)</ul>~isU";
$regexpP2  		 = "~<a.*>(.+)<~isU";  
$regexpPrices  = "~<li id(.+)</li>~isU"; 
$regexpPrices2 = "~product_section-list_name.*href=\"(.+)\".*>(.+)</.*class=\"product_main-page_price\">(.+)<~isU";
$regexpPrices3 = "~product_section-list_name.*href=\"(.+)\".*>(.+)</~isU";

$options = array(
								CURLOPT_COOKIE => 'STORE_NAME='.$region,
								//CURLOPT_COOKIEJAR       => '/var/www/polaris.ua/cookies',
        				//CURLOPT_COOKIEFILE      => '/var/www/polaris.ua/cookies',
                CURLOPT_CONNECTTIMEOUT 	=> 20,
                CURLOPT_TIMEOUT        	=> 20,
                CURLOPT_AUTOREFERER     => true,
                CURLOPT_FOLLOWLOCATION  => true,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_HEADER 					=> true, 
                CURLOPT_SSL_VERIFYPEER 	=> 0,
                CURLOPT_SSL_VERIFYHOST 	=> 0,
);

$already_scanned = array();
$already_scanned = scanned_links($itemsArray);
//$already_scanned = array();
print_r($already_scanned);

$links = array(
'https://fishki.ua/multivarki/brend-is-polaris/',
'https://fishki.ua/napolnye-vesy/brend-is-polaris/',
'https://fishki.ua/myasorubki/brend-is-polaris/',
'https://fishki.ua/pribory-dlya-ukladki-volos/brend-is-polaris/',
'https://fishki.ua/blendery/brend-is-polaris/',
'https://fishki.ua/feny/brend-is-polaris/',
'https://fishki.ua/mashinki-dlya-strizhki/brend-is-polaris/',
'https://fishki.ua/elektrochayniki/brend-is-polaris/',
'https://fishki.ua/uvlazhniteli-ochistiteli-vozdukha/brend-is-polaris/',
'https://fishki.ua/miksery/brend-is-polaris/',
'https://fishki.ua/kofevarki/brend-is-polaris/',
'https://fishki.ua/tostery/brend-is-polaris/',
'https://fishki.ua/sokovyzhimalki/brend-is-polaris/',
'https://fishki.ua/vesy-kukhonnye/brend-is-polaris/',
'https://fishki.ua/kofemolki/brend-is-polaris/',
'https://fishki.ua/grili/brend-is-polaris/',
'https://fishki.ua/utyugi/brend-is-polaris/',
'https://fishki.ua/buterbrodnitsy-i-vafelnitsy/brend-is-polaris/',
'https://fishki.ua/obogrevateli/brend-is-polaris/',
'https://fishki.ua/trimmery/brend-is-polaris/	',
);

foreach ($links as $url) {
	$qOfPaginationPages = 0;

	$AC->flush_requests();
	$AC->__set('callback','callback_one');

	$AC->get($url, null, $options);
	$AC->execute(WINDOW_SIZE);

	while ($bad_urls) {
		$AC->flush_requests();
		foreach ($bad_urls as $urls) {
		  $AC->get($urls, null, $options);
		}
		$bad_urls = array();
		$AC->execute(WINDOW_SIZE);
	}

	if ($qOfPaginationPages > 1) {
		$is_scan = 0;
		for ($i = 2; $i <= $qOfPaginationPages; $i++) {
			if (!in_array($url.'page-'.$i.'/', $already_scanned)) {
				//AngryCurl::add_debug_msg('сканирую адрес: '.$url.'page-'.$i.'/');
				$AC->get($url.'page-'.$i.'/', null, $options);
				$is_scan = 1;
			} else {
			AngryCurl::add_debug_msg('уже сканировал: '.$url.'page-'.$i.'/');
			}			
		}
		if ($is_scan) {
			$AC->execute(WINDOW_SIZE);
		}

		while ($bad_urls) {
			$AC->flush_requests();
			foreach ($bad_urls as $urls) {
			  $AC->get($urls, null, $options);
			}
			$bad_urls = array();
			$AC->execute(WINDOW_SIZE);
		}
	}
}

file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';



function callback_one($response, $info, $request) {
  global $regexpP;
  global $regexpP2;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;  
  global $qOfPaginationPages;
  global $bad_urls;
	global $time_start;
	global $city;

	//file_put_contents('/var/www/polaris.ua/engines/fishki.ua/content.txt', $response);die($response);

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]); 

	//echo $response;

  if ($info['http_code'] !== 200) {
  	if ($info['http_code'] !== 400) {            
	    $bad_urls[] = $request->url; 	
			if (round(microtime(1) - $time_start, 0) >= 2700) { $bad_urls = array(); } 
		}
  } else {
		preg_match("~id=\"popup-dlv-name\">(.+)<~isU", $response, $region);
		AngryCurl::add_debug_msg('request  region: '.$city);
		AngryCurl::add_debug_msg('response region: '.trim($region[1])); 

		preg_match($regexpP, $response, $matches);
		preg_match_all($regexpP2, $matches[0], $matches2);
		//print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			if (is_numeric($value)) $temparrpage[] = $value;
		}
		if (@max($temparrpage) > $qOfPaginationPages) $qOfPaginationPages = @max($temparrpage);	

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  //print_r($matches2);
	  foreach ($matches2 as $key) {
	  	if (strripos(mb_strtolower($key[0]), 'color: #797979') === false) {
	  		preg_match($regexpPrices2, $key[1], $matches);
				$matches[1] = 'https://fishki.ua'.trim($matches[1]);
				$matches[2] = trim(strip_tags($matches[2]));
				$matches[3] = preg_replace('~[\D]+~', '' , $matches[3]);

				if (@$matches[1] && $matches[2]) {
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
				}	
	  	} else {
	  		preg_match($regexpPrices3, $key[1], $matches);
	  		print_r($matches);
				$matches[1] = 'https://fishki.ua'.trim($matches[1]);
				$matches[2] = trim(strip_tags($matches[2]));
				$matches[3] = '0';

				if (@$matches[1] && $matches[2]) {
					price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
					AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
				}		  		
	  	}
	  }
  } 
}
