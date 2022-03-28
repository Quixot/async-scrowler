<?php
//brain.com.ua
switch (EXTRA_PARAM) {
 	case 'kiev': 
 		$city = 'Киев';
		$region = '23562';
 		break;
 	case 'odessa': 
 		$city = 'Одесса';
		$region = '23613';
 		break;
	case 'kharkov': 
		$city = 'Харьков';
		$region = '23563';
		break;
	case 'lvov': 
		$city = 'Львов';
		$region = '23567';
		break;
	case 'dnepr': 
		$city = 'Днепр';
		$region = '23566';
		break;
 	default:
 		die("Unknown region\n");  	 		
}

$regexpP 			 = "~class=\"page-good(.+)</ul>~isU"; 	// Пагинация
$regexpP2  		 = "~<a.*>(.+)<~isU";  
$regexpPrices  = "~product-wrapper(.+)br-pp-r~isU"; 
$regexpPrices2 = "~data-price=\"(.+)\".*data-stock=\"(.+)\".*href=.*href=\"(.+)\".*>(.+)</a~isU";

$options = array(
								CURLOPT_COOKIE => 'CityID='.$region,
								//CURLOPT_COOKIEJAR       => '/var/www/polaris.ua/cookies/xx/t.txt',
        				//CURLOPT_COOKIEFILE      => '/var/www/polaris.ua/cookies/xx/t.txt',
                CURLOPT_CONNECTTIMEOUT 	=> 45,
                CURLOPT_TIMEOUT        	=> 45,
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

//https://brain.com.ua/category/Blenderi-c600/filter=3-21505590000;page=2/
//filter=3-21505590000/

$links = array(
'https://brain.com.ua/category/Blenderi-c600/',
'https://brain.com.ua/category/Vafelnici-c603/',
'https://brain.com.ua/category/Sendvichnici-c605/',
'https://brain.com.ua/category/Vesi_kuhonnie-c606/',
'https://brain.com.ua/category/Aerogrili-c608/',
'https://brain.com.ua/category/Elektrogrili-c609/',
'https://brain.com.ua/category/Yogurtnici-c611/',
'https://brain.com.ua/category/Kofevarki_i_kofemashini-c612/',
'https://brain.com.ua/category/Kofemolki-c613/',
'https://brain.com.ua/category/Mikseri-c617/',
'https://brain.com.ua/category/Multivarki-c619/',
'https://brain.com.ua/category/Myasorubki-c620/',
'https://brain.com.ua/category/Parovarki-c621/',
'https://brain.com.ua/category/Sokovizhimalki-c622/',
'https://brain.com.ua/category/Sushki_dlya_fruktov_i_ovoschey-c623/',
'https://brain.com.ua/category/Frityurnici-c625/',
'https://brain.com.ua/category/Elektrochayniki_i_termopoti-c629/',
'https://brain.com.ua/category/Aksessuari_k_multivarkam-c634/',
'https://brain.com.ua/category/Vesi_napolnie-c641/',
'https://brain.com.ua/category/Mashinki_dlya_strizhki-c654/',
'https://brain.com.ua/category/Mashinki_dlya_chistki_trikotazha-c655/',
'https://brain.com.ua/category/Vipryamiteli_dlya_volos-c657/',
'https://brain.com.ua/category/Ployki-c658/',
'https://brain.com.ua/category/Feni-c664/',
'https://brain.com.ua/category/Pilesosi-c671/',
'https://brain.com.ua/category/Uvlazhniteli_vozduha-c672/',
'https://brain.com.ua/category/Utyugi-c674/',
'https://brain.com.ua/category/Otparivateli_dlya_odezhdi-c676/',
'https://brain.com.ua/category/Stayleri-c689/',
'https://brain.com.ua/category/Boyleri-c904/',
'https://brain.com.ua/category/Obogrevateli-c905/',
);


foreach ($links as $url) {
	$qOfPaginationPages = 0;

	$AC->flush_requests();
	$AC->__set('callback','callback_one');

	$AC->get($url.'filter=3-21505590000/', null, $options);
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
			if (!in_array($url.'filter=3-21505590000;page='.$i.'/', $already_scanned)) {
				//AngryCurl::add_debug_msg('сканирую адрес: '.$url.'filter=3-21505590000;page='.$i.'/');
				$AC->get($url.'filter=3-21505590000;page='.$i.'/', null, $options);
				$is_scan = 1;
			} else {
			AngryCurl::add_debug_msg('уже сканировал: '.$url.'filter=3-21505590000;page='.$i.'/');
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
	global $itemsArray;  
  global $qOfPaginationPages;
  global $bad_urls;
	global $time_start;
	global $city;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

	//file_put_contents('/var/www/polaris.ua/engines/brain.com.ua/content.txt', $response);
	//die();

  if ($info['http_code'] !== 200) {            
    $bad_urls[] = $request->url; 	
		if (round(microtime(1) - $time_start, 0) >= 2700) $bad_urls = array();
  } else {
		preg_match("~data-cityid.*>(.+)<~isU", $response, $region);
		AngryCurl::add_debug_msg('request  region: '.$city);
		AngryCurl::add_debug_msg('response region: '.trim($region[1]));
		//sleep(3);

		preg_match($regexpP, $response, $matches);
		preg_match_all($regexpP2, $matches[0], $matches2);
		//print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			if (is_numeric(trim($value))) $temparrpage[] = trim($value);
		}
		if (@max($temparrpage) > $qOfPaginationPages) $qOfPaginationPages = @max($temparrpage);	

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
	  //print_r($matches2);

	  foreach ($matches2 as $key) {
		  preg_match($regexpPrices2, $key[1], $matches);
		  //print_r($matches);
	  	if ($matches[2]) {
	  		if (@$matches[1] && $matches[2]) {
					$matches[3] = 'https://brain.com.ua'.trim($matches[3]);
					$matches[4] = trim(strip_tags($matches[4]));
					$matches[1] = preg_replace('~[\D]+~', '' , $matches[1]);

					if (@$matches[1] && $matches[2]) {
						price_change_detect($matches[3], $matches[4], $matches[1], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[3]] = array($matches[4], $matches[1], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
						AngryCurl::add_debug_msg($matches[3].' | '.$matches[4].' | '.$matches[1]);
					}									
	  		}	
	  	} else {
	  		if (@$matches[1] && $matches[2]) {
					$matches[3] = 'https://brain.com.ua'.trim($matches[3]);
					$matches[4] = trim(strip_tags($matches[4]));
					$matches[1] = '0';

					if (@$matches[1] && $matches[2]) {
						price_change_detect($matches[3], $matches[4], $matches[1], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
						$itemsArray[$matches[3]] = array($matches[4], $matches[1], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
						AngryCurl::add_debug_msg($matches[3].' | '.$matches[4].' | '.$matches[1]);
					}									
	  		}		  		
	  	}
	  }
  }
}
