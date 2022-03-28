<?php
/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
  global $regexpPagin;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices1;
	global $regexpPrices2;
	global $itemsArray;
	global $time_start;
	global $regexpRegion;
	global $regionRu;

	echo $info['http_code']."\n";
	echo $info['url']."\n";
	//file_put_contents('/var/www/engines/eldorado.ru/'.time(), $response);

  if ($info['http_code'] !== 200) {            
    //if (stripos($info['url'], ENGINE_CURR)) {
    //  $bad_urls[] = $info['url'];
    //}
  } else {
    preg_match($regexpPagin, $response, $matches); // Сколько страниц цен   
    ////echo"К-во страниц до обработки - " . $matches[1] . "\n";
    ////echo"Позиция в строке - " . strpos($matches[1], iconv("utf-8", "windows-1251", "из")) . "\n";    
    $temp = ceil(substr($matches[1], strpos($matches[1], iconv("utf-8", "windows-1251", "из")) + 3) / 50);
    if ($qOfPaginationPages < $temp) {
    	$qOfPaginationPages = $temp;
    }  

  	preg_match($regexpRegion, $response, $mregion);
  	echo"Регион: " . $regionRu . "\n";
  	echo"Регион: " . iconv('windows-1251','utf-8', $mregion[1]) . "\n";

  	if (iconv('windows-1251','utf-8', trim($mregion[1])) == $regionRu) {  // Проверка региона  	
  		echo'Регион сработал' . "\n"; 

	  	preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER); // Все карточки товара	
	  		
			foreach ($matches as $key) { // Режем каждую карточку
				preg_match($regexpPrices2, $key[1], $matches2);
				price_change_detect('http://' . ENGINE_CURR . $matches2[1], iconv('windows-1251','utf-8', $matches2[2]), $matches2[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray['http://' . ENGINE_CURR . $matches2[1]] = array(iconv('windows-1251','utf-8', $matches2[2]), $matches2[3], date("d.m.y-H:i:s"), $request->options[10004]);			
				echo $matches2[1] . "\n";			
			} 
		}

  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices1;
	global $regexpPrices2;
	global $matches;
	global $itemsArray;
	global $bad_urls;
	global $time_start;
	global $regexpRegion;
	global $regionRu;

	echo $info['http_code']."\n";
	echo $info['url']."\n";

  if ($info['http_code'] !== 200) {
    if (stripos($info['url'], ENGINE_CURR)) {
      $bad_urls[] = $info['url'];
    }  
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 180) { $bad_urls = array(); }       
  } else {
  	preg_match($regexpRegion, $response, $mregion);
  	////echo"Регион: " . $regionRu . "\n";
  	////echo"Регион: " . iconv('windows-1251','utf-8', $mregion[1]) . "\n";

  	if (iconv('windows-1251','utf-8', trim($mregion[1])) == $regionRu) {  // Проверка региона  	
  		////echo'Регион сработал' . "\n"; 

	  	preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER); // Все карточки товара		
			foreach ($matches as $key) { // Режем каждую карточку
				preg_match($regexpPrices2, $key[1], $matches2);
				price_change_detect('http://' . ENGINE_CURR . $matches2[1], iconv('windows-1251','utf-8', $matches2[2]), $matches2[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
				$itemsArray['http://' . ENGINE_CURR . $matches2[1]] = array(iconv('windows-1251','utf-8', $matches2[2]), $matches2[3], date("d.m.y-H:i:s"), $request->options[10004]);			
				//echo$matches2[1] . "\n";			
			} 
		} 	
  }
}