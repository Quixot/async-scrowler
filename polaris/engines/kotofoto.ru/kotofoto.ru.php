<?php
/**
 * kotofoto.ru
 */
switch (EXTRA_PARAM) {
  case 'moscow': 
  	$region = 'district=12';
    break;
  case 'spb':
    $region = 'district=1';
    break;
 	case 'yekaterinburg':
 		$region = 'district=13';
 		break;
 	case 'krasnodar':
 		$region = 'district=9';
 		break;
 	case 'novgorod':
 		$region = 'district=5';
 		break; 	
  case 'novosibirsk':
  	$region = 'district=2';
  	break;	
  case 'rostov':
  	$region = 'district=3';
    break;
 	case 'samara':
 		$region = 'district=10';
 		break;
 	case 'tumen':
 		$region = 'district=15';
 		break;
 	case 'chelyabinsk':
 		$region = 'district=14';
 		break;
 	default:
 		die("Unknown region\n");  		
}

$urlStart 		 = 'https://kotofoto.ru/find/?f='.ENGINE_TYPE; 
$regexpPrices  = "~li class=\"column(.+)</li>~isU";
$regexpPrices2 = "~href=\"(.+)\".*class=\"sltitlecart\">(.+)<.*class=\"slprisecart\">(.+)<~isU";
$regexpPrices3 = "~href=\"(.+)\".*class=\"sltitlecart\">(.+)<~isU";
$regexpPricesCross = "~href=\"(.+)\".*class=\"sltitlecart\">(.+)<.*<br>(.+)<~isU";

	// Узнаем, сколько позиций в пагинации
	$AC->get($urlStart);
	$AC->get($urlStart);
	$AC->get($urlStart);
	$AC->execute(3);	

	while ($bad_urls) {
		if (round(microtime(1) - $time_start, 0) >= 180) break;
	  $AC->flush_requests();
	  foreach ($bad_urls as $url => $attr) {
	    $AC->get($url);     
	  }
	  $bad_urls = array();
	  $AC->execute(WINDOW_SIZE);
	}



/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPricesCross;
	global $itemsArray;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {            
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);
  } else {
	  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER);
	  foreach ($matches2 as $key) {
			if (strripos($key[1], 'AddToCart') !== false) {
				if (strripos($key[1], 'slprisecarts') === false) {
					preg_match($regexpPrices2, $key[1], $matches);
				} else {
					preg_match($regexpPricesCross, $key[1], $matches);
					print_r($matches);
				}

			}	else {
				preg_match($regexpPrices3, $key[1], $matches);
			}
			$matches[1] = 'http://'.ENGINE_CURR.trim($matches[1]);
			$matches = clean_info($matches, array(1,2,3));

			if ($matches != false) {
				price_change_detect($matches[1], $matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray[$matches[1]] = array($matches[2], $matches[3], date("d.m.y-H:i:s"), $request->options[10004]);
				AngryCurl::add_debug_msg($matches[1].' | '.$matches[2].' | '.$matches[3]);
			}
	 	}								
	} 
}
