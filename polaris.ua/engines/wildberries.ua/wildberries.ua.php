<?php
/**
 * wildberries.ua
 */
$regexpP 			 = "~pagination__list(.+)</div~isU"; 	// Пагинация
$regexpP2  		 = "~<a.*>(.+)<~isU";  
$regexpPrices  = "~class=\"card-cell(.+)</a>.*</div>~isU"; 
$regexpPrices2 = "~href=\"(.+)\".*class=\"price__lower\">(.+)<.*class=\"display-price\">(.+)<~isU";
$regexpPrices3 = "~<h2.*href=\"(.+)\".*>(.+)<~isU";
$url = 'https://wbxcatalog-ua.wildberries.ru/brands/p/catalog?brand=1935&limit=100&sort=popular&page=1';

$options = array(
								//CURLOPT_COOKIE => 'city_id='.$region.';city_id_geo='.$region,
								//CURLOPT_COOKIEJAR       => '/var/www/polaris.ua/cookies',
        				//CURLOPT_COOKIEFILE      => '/var/www/polaris.ua/cookies',
                CURLOPT_CONNECTTIMEOUT 	=> 30,
                CURLOPT_TIMEOUT        	=> 30,
                CURLOPT_AUTOREFERER     => true,
                CURLOPT_FOLLOWLOCATION  => true,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_HEADER 					=> 0, 
                CURLOPT_SSL_VERIFYPEER 	=> 0,
                CURLOPT_SSL_VERIFYHOST 	=> 0,
);

$already_scanned = array();
$already_scanned = scanned_links($itemsArray);
//$already_scanned = array();
print_r($already_scanned);

//$cont = json_decode(file_get_contents('/var/www/polaris.ua/engines/wildberries.ua/cont.txt'));
//file_put_contents('/var/www/polaris.ua/engines/wildberries.ua/obj.txt', print_r($cont,1));

//$AC->get('https://wbxcatalog-ua.wildberries.ru/brands/p/catalog?brand=1935&limit=100&sort=popular&page=1', null, $options);
//$AC->get('https://wbxcatalog-ua.wildberries.ru/brands/p/catalog?brand=1935&limit=100&sort=popular&page=2', null, $options);
$AC->get('https://wbxcatalog-eu.wildberries.ru/brands/p/catalog?brand=1935&limit=60&sort=popular&page=2&lang=uk&locale=ua&regions=1,4,22,30,38,40,48,65,69,78&stores=507,117501', null, $options);
$AC->get('https://wbxcatalog-eu.wildberries.ru/brands/p/catalog?brand=1935&limit=60&sort=popular&page=1&lang=uk&locale=ua&regions=1,4,22,30,38,40,48,65,69,78&stores=507,117501', null, $options);

$AC->execute(WINDOW_SIZE);

file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.data', serialize($itemsArray));
$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'.ua_'.EXTRA_PARAM.'.csv';

/** 
 * Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP;
  global $regexpP2;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPrices4;
	global $itemsArray;  
  global $qOfPaginationPages;
  global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]); 

	echo $response;
	file_put_contents('/var/www/polaris.ua/engines/wildberries.ua/cont.txt', $response);

  if ($info['http_code'] !== 200) {            
    $bad_urls[] = $request->url; 	
		if (round(microtime(1) - $time_start, 0) >= 270) { $bad_urls = array(); } 
  } else {
  	$cont = json_decode($response);
  	file_put_contents('/var/www/polaris.ua/engines/wildberries.ua/json.txt', print_r($cont,1));
	  foreach ($cont->data->products as $key => $value) {
			if ($value->id && $value->name && $value->salePriceU) {
				$addr = 'https://wildberries.ua/product?card='.$value->id;
				$name = $value->name;
				$price = substr($value->salePriceU, 0, -2);

				price_change_detect($addr, $name, $price, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$addr] = array($name, $price, date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url);
				AngryCurl::add_debug_msg($addr.' | '.$name.' | '.$price);
			}	
	  }
  }
}
