<?php
/**
 * sibvez.ru
 */
switch (EXTRA_PARAM) {
	case 'novosibirsk': $region = 'novosibirsk'; break;
 	default:
 		die("Unknown region\n");  	 		
}

$urlStart = 'http://www.sibvez.ru/'.$region.'/search/?q='.ENGINE_TYPE;
$regexpP1 = "";
$regexpP2 = "";
$regexp1  = "~class=\"search-item(.+)class=\"search-preview~isU";
$regexp2  = "~href=\"(.+)\".*>(.+)</a>~isU";
$regexp3  = "~class=\"item_current_price.*>(.+)<~isU";

	$AC->flush_requests();
	$AC->__set('callback','callback_two');

	$qOfPagesArray = array();
	$AC->get($urlStart);
	$AC->get($urlStart);
	$AC->get($urlStart);
	$AC->execute(3);



/**
 * Callback Three
 */
	$AC->add_debug_msg('Callback Three');
	$AC->flush_requests();
	$AC->__set('callback','callback_three');


	foreach ($itemsArray as $aurl => $stuff) {
		$AC->get($aurl);
		$AC->add_debug_msg($aurl); // Проверим, какие адреса записываются для выполнения   
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


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpP1;
  global $regexpP2;
  global $qOfPaginationPages;  
  global $bad_urls;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);

  if ($info['http_code'] !== 200) {                

  } else {
		preg_match($regexpP1, $response, $matches);
		//print_r($matches);
		preg_match_all($regexpP2, $matches[1], $matches2);
		//print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			//echo "key: " . $key . "\n";
			//echo "value:" . $value . "\n";
			if (is_numeric($value)) {
				$temparrpage[] = $value;
			}
		}

		if (@max($temparrpage) > $qOfPaginationPages) {
			$qOfPaginationPages = @max($temparrpage);	    	
		}		
  }
}

function callback_two($response, $info, $request) {
	global $regexp1;
	global $regexp2;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200 || !$response) {
    $bad_urls[$request->url] = array(
    		$info['http_code'],
    		$request->options[10004]
    	);        
  } else {	
  	preg_match_all($regexp1, $response, $matches2, PREG_SET_ORDER); //
  	print_r($matches2);
 		foreach ($matches2 as $key) {  		
			preg_match($regexp2, $key[1], $matches);
			if ($matches[1]) {
				$matches[1] = substr($matches[1], 0, strripos($matches[1], '?'));
				$itemsArray['http://www.sibvez.ru'.trim($matches[1])] = array(trim(iconv('windows-1251', 'utf-8', strip_tags($matches[2]))), '0', date("d.m.y-H:i:s"), $request->options[10004]);
				echo trim($matches[1]) . "\n";
			}						  		
		}	
  }
}

function callback_three($response, $info, $request) {
	global $regexp3;
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
		preg_match($regexp3, $response, $matches);
		print_r($matches);	
		if (@$matches[1]) {
			price_change_detect($request->url, $itemsArray[$request->url][0], trim(preg_replace('~[^\d]+~', '' , $matches[1])), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
			$itemsArray[$request->url][1] = preg_replace('~[^\d]+~', '' , $matches[1]);		
			echo 'price - ' . preg_replace('~[^\d]+~', '' , $matches[1]) . "\n";		
		}
	}
}