<?php
/**
 * goods.ru
 */
	$urlStart = 'https://goods.ru/catalog/page-';
	$urlEnd = '/?q=polaris';
	$regexpP1	 = "~class=\"pagination\"(.+)</nav>~isU";
	$regexpP2  = "~<a.*>(.+)<~isU";
	$regexpPrices  = "~<article(.+)</article>~isU";
	$regexpPrices2 = "~itemprop=\"url\".*href=\"(.+)\".*>(.+)<.*content=\"RUB\">(.+)<~isU";
	$regexpPrices3 = "~itemprop=\"url\".*href=\"(.+)\".*>(.+)<~isU";
	$regexpRegion = "~\"region\":\"(.+)\"~isU";


	foreach ($itemsArray as $key => $value) {
		$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
		//echo (time() - $date->format('U')).PHP_EOL; 
		if (time() - $date->format('U') <= 7000) {
			$already_scanned[] = $value[5];
		}
		
	}
	if ($already_scanned) {
		$already_scanned = array_unique($already_scanned);
		$already_scanned = array_values($already_scanned);
		//print_r($already_scanned); 
	} else {
		$already_scanned = array();
	}
	//$already_scanned = array();


if (ENGINE_LOOP == 13) {
	$regions = array('arhangelsk', 'cheboksary', 'chelyabinsk', 'habarovsk', 'kazan', 'krasnodar', 'krasnoyarsk', 'moscow', 'naberezhnye-chelny', 'novgorod', 'novosibirsk', 'petrozavodsk', 'pyatigorsk', 'omsk', 'perm', 'rostov', 'spb', 'samara', 'ufa', 'volgograd', 'vladivostok', 'yekaterinburg');

	foreach ($regions as $region) {

		$content_file_path = '/var/www/polaris/engines/sbermegamarket.ru/content/'.$region.'.txt';
		if (file_exists($content_file_path) && time() - filemtime($content_file_path) < 13600) {

			$itemsArray = array();

			$AC = new AngryCurl('callback_three');
			$AC->init_console();
			$response = file_get_contents($content_file_path);

			callback_three($response, $region);

			file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . $region . '.data', serialize($itemsArray));
		} else {
			echo 'Старый файл: '.$content_file_path.PHP_EOL;
		}
	}
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';

}

	


/** 
 *              Callback Functions           
 */
function callback_three($response, $region) {
	global $itemsArray;
	global $bad_urls;
	global $region;
	global $city;
	global $regexpRegion;
	global $time_start;

	$regexpPrices  	 = "~div data-product-id=(.+)<!----></div></div>.*<!----></div></div>.*<!----></div></div>~isU";
	$regexpPrices2   = "~class=\"item-price.*span>(.+)<.*itemprop=\"name\".*href=\"(.+)\".*title=\"(.+)\"~isU";


	if ($response) {
		//echo 'response ok'.PHP_EOL;
		//file_put_contents('/var/www/polaris/engines/dns-shop.ru/content.txt', $response);
 	

	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER);
	  //print_r($matches2);
	  //die();
		$i = 0;
		foreach ($matches2 as $key) {
			preg_match($regexpPrices2, $key[0], $matches);
			//print_r($matches);die();
			$i++;

			
			$addr = 'https://'.ENGINE_CURR.trim($matches[2]);
			$name = strip_tags(trim($matches[3]));
			$price = preg_replace('~[\D]+~', '' , $matches[1]);
			
			if ($name && $addr && $price) {
				price_change_detect($addr, $name, $price, date("d.m.y-H:i:s"), 'manual', 'manual','manual', ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$addr] = array($name, $price, date("d.m.y-H:i:s"));
				//AngryCurl::add_debug_msg($addr.' | '.$name.' | '.$price);
				$itemsManual[] = $addr;
			}
			AngryCurl::add_debug_msg($addr.' | '.$name.' | '.$price);
		}

		file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . $region . '.data', serialize($itemsArray));
		//$itemsManual = array_unique($itemsManual);
		//file_put_contents("/var/www/polaris/engines/dns-shop.ru/1.txt", print_r($itemsManual, 1));
		//die('К-во: '.$i);
		return 1;
	} else {
		echo 'bad response'.PHP_EOL;
		return 0;
	}
}








function callback_one($response, $info, $request) {
	global $regexpP1;
	global $regexpP2;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpRegion;
	global $city;
	global $qOfPaginationPages;
	global $itemsArray;
	global $bad_urls;
	global $time_start;


	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {
  	if ($info['http_code'] !== 404) {
	    $bad_urls[] = $request->url;
			if (round(microtime(1) - $time_start, 0) >= 300) { $bad_urls = array(); }  
		}  
  } else {
  	file_put_contents('/var/www/polaris/engines/sbermegamarket.ru/content.txt', $response);
  	preg_match("~window.application.state(.+)window.application.selectedFilters~isU", $response, $matches);
  	$variant = 1;
  	if (!$matches) {
  		preg_match("~apiBaseUrl(.+)</script>~isU", $response, $matches);
  		$variant = 2;
  	}
  	//print_r($matches); die();

  	//print_r($matches); die();
  	preg_match_all('~"name":"(.+)".*"url":"(.+)".*"final_price":(.+),.*merchant_name":"(.+)".*"stock":(.+),~isU', $matches[1], $mcode, PREG_SET_ORDER);
  	
  	//file_put_contents('/var/www/polaris/engines/goods.ru/json.txt', print_r($mcode, 1));
  	if (!$mcode) {
  		preg_match_all('~goodsId.*"title":"(.+)".*"webUrl":"(.+)".*"stocks":(.+),.*"finalPrice":(.+),.*merchantId":"(.+)"~isU', $matches[1], $mcode, PREG_SET_ORDER);
  		
  	}
  	print_r($mcode);
  	//print($variant);
  	//die();

  	




  	preg_match($regexpRegion, $response, $mReg);
  	if (!$mReg) {
  		preg_match("~\"displayName\":\"(.+)\"~isU", $response, $mReg);
  	}
  	if (!$mReg) preg_match("~class=\"region-trigger\".*span>(.+)<~isU", $response, $mReg);
  	
  	$mReg[1] = trim($mReg[1]);

  	AngryCurl::add_debug_msg($mReg[1].' | '.$city);
  	//die();
  	
  	if ($mReg[1] == $city) {
  		//print_r($value);
		  foreach ($mcode as $key => $value) {
		  	//print_r($value);
					
				if ($variant == 1) {
					if (stripos($value[4], '2887') !== false && $value[1] && $value[3]) { //'Официальный интернет-магазин Polaris'
						$address = 'https://sbermegamarket.ru'.trim(stripcslashes($value[2]));
						$address = str_replace('\u002F', '\\', $address);
						$value[1] = trim(str_replace('\u002F', '\\', $value[1]));
						$value[3] = trim($value[3]);

						price_change_detect(
							$address, $value[1], $value[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE
						);
						$itemsArray[$address] = array(
							$value[1], $value[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url
						);
						AngryCurl::add_debug_msg($address.' | '.$value[1].' | '.$value[3]);
					}
				} else {
					if (stripos($value[5], '2887') !== false && $value[1] && $value[3]) {
						$address = str_replace('\u002F', '\\', $value[2]);
						$value[1] = trim(str_replace('\u002F', '\\', $value[1]));
						$value[4] = trim($value[4]);

						price_change_detect(
							$address, $value[1], $value[4], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE
						);
						$itemsArray[$address] = array(
							$value[1], $value[4], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url
						);
						AngryCurl::add_debug_msg($address.' | '.$value[1].' | '.$value[4]);	
					}					
				}

				
			}
			file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	  }
	}
}
