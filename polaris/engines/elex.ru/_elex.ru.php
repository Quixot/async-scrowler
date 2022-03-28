<?php
/**
 * elex.ru
 */
defined('_JEXEC') or die('Silentium videtur confessio');

switch (EXTRA_PARAM) {
  case 'moscow':
    $region = 'moscow.';
    break;
 	default:
 		die("Unknown region\n");  	 		
}

$urlStart = 'http://'.$region.ENGINE_CURR.'/search/#!page=';
$regexpP1 = "~id=\"goodPagesList\"(.*)</div~isU";
$regexpP2 = "~<a.*>(.+)<~isU";
$regexpPrices1 = "~class=\"goodInfo\"(.+)class=\"goodQuality\"~isU";
$regexpPrices2 = "~class=\"goodItemAnchor\".*href=\"(.+)\".*>(.+)<.*class=\"price\">(.+)<~isU";

/**
 * МЕГАЦИКЛ
 */
for ($iGlobalLoop = 0; $iGlobalLoop < ENGINE_LOOP; $iGlobalLoop++) {
	if ($iGlobalLoop > 0) {
		$AC->flush_requests();
		$AC->__set('callback','callback_one');
	}	
	// Узнаем, сколько позиций в пагинации
	$AC->request('http://moscow.elex.ru/ajax/search_new/', "POST", array('search' => ENGINE_TYPE, 'page' => '2', 'count' => '1'));
	$AC->request('http://moscow.elex.ru/ajax/search_new/', "POST", array('search' => ENGINE_TYPE, 'page' => '3', 'count' => '1'));
	$AC->execute(6);

	// Наименования товара и цены
	$AC->flush_requests();
	$AC->__set('callback','callback_two');	

	if ($qOfPaginationPages < 1) { $qOfPaginationPages = 1; } // Если к-во страниц не определилось, сканируем хотя бы одну, иначе будет ошибка Window size
	echo 'Количество страниц: ' . $qOfPaginationPages . "\n";

	for ($i = 1; $i <= $qOfPaginationPages; $i++) {
	  $AC->request($urlStart.$i, "POST", array('search' => ENGINE_TYPE, 'page' => $i, 'count' => '1'));
	  $AC->add_debug_msg( $urlStart.$i ); // Проверим, какие адреса записываются для выполнения    
	}
	$AC->execute(WINDOW_SIZE);

	// Сохраним массив в переменную
	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));

} // МЕГАЦИКЛ

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
	global $regexpPrices1;
	global $regexpPrices2;
	global $itemsArray;
  global $qOfPaginationPages;
  global $bad_urls;
  global $time_start;

  echo $info['http_code']."\n";
  echo $info['url']."\n";
  echo substr($response, 100,1000);

  if ($info['http_code'] !== 200) {            
  } else {
		preg_match($regexpP1, $response, $matches);
		preg_match_all($regexpP2, $matches[1], $matches2);
		print_r($matches2);
		$temparrpage = array();
		foreach ($matches2[1] as $key => $value) {
			if (is_numeric($value)) {
				$temparrpage[] = $value;
			}
		}
		if (@max($temparrpage) > $qOfPaginationPages) {
			$qOfPaginationPages = @max($temparrpage);	    	
		}
	  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER);
		foreach ($matches as $key) {
			preg_match($regexpPrices2, $key[1], $matches2);
			if ($matches2[1] && $matches2[2]) {
				$itemsArray['http://'.ENGINE_CURR.$matches2[1]] = array(iconv('utf-8', 'windows-1251', $matches2[2]), preg_replace('~[^\d.]+~', '', $matches2[3]), date("d.m.y-H:i:s"), $request->options[10004]);			
				echo $matches2[2]."\n";	
			}		
		}
  }
}

function callback_two($response, $info, $request) {
	global $regexpPrices1;
	global $regexpPrices2;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

  if ($info['http_code'] !== 200) {
    if (stripos($info['url'], ENGINE_CURR)) {
      $bad_urls[] = $info['url'];
    }	
		if (round(microtime(1) - $time_start, 0) >= 1800) { $bad_urls = array(); }       
  } else {
	  preg_match_all($regexpPrices1, $response, $matches, PREG_SET_ORDER);
		foreach ($matches as $key) {
			preg_match($regexpPrices2, $key[1], $matches2);
			if ($matches2[1] && $matches2[2]) {
				$itemsArray['http://'.ENGINE_CURR.$matches2[1]] = array(iconv('utf-8', 'windows-1251', $matches2[2]), preg_replace('~[^\d.]+~', '', $matches2[3]), date("d.m.y-H:i:s"), $request->options[10004]);			
				echo $matches2[2]."\n";	
			}		
		}
  }
}
