<?php
/**
 * 003.ru
 */
	$options = array(
       	CURLOPT_COOKIEFILE     => '/var/www/polaris/engines/003.ru/cookies_'.EXTRA_PARAM.'.txt',
       	CURLOPT_COOKIEJAR      => '/var/www/polaris/engines/003.ru/cookies_'.EXTRA_PARAM.'.txt',
       	CURLOPT_HEADER 				 => 1,
        CURLOPT_AUTOREFERER    => true,
        CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_CONNECTTIMEOUT => 20,
        CURLOPT_TIMEOUT        => 20, 
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => 0   
   );

	$AC->get('https://rozetka.com.ua/producer/braun/', NULL, $options);
	$AC->execute(WINDOW_SIZE);

	die();


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $region;
	global $regexpPrices1;
	global $regexpPrices2;
	global $regexpPrices3;
	global $itemsArray;
  global $bad_urls;
  global $time_start;
  global $regRegion;
  global $regionName;
  global $merchant_array;
  global $merchant_new;

  file_put_contents('/var/www/polaris/engines/003.ru/content.ru', $response);
  echo $response;die();


	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);  


  if ($info['http_code'] !== 200 || !$response) {   
  	if ($info['http_code'] !== 404) {
  		$bad_urls[] = $request->url;
  	} 	
		if (round(microtime(1) - $time_start, 0) >= 90) { $bad_urls = array(); }  	 	         
  } else {

  	preg_match("~Продавец:.*<a.*>(.+)</a~isU", $response, $mReg);
  	@AngryCurl::add_debug_msg('Продавец - '.trim($mReg[1]));

  }
}
