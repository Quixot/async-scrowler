<?php
/**
 * komfortbt.ru
 */

switch (EXTRA_PARAM) {
  case 'moscow': $region = 'msk'; break;
  case 'tver': $region = 'tvr'; break;
  case 'kaluga': $region = 'klg'; break;
 	default:
 		die("Unknown region\n");  	 		
}

switch (ENGINE_TYPE) {
	case 'vitek':
		$index = 12;
		break;
	case 'maxwell':
		$index = 5;
		break;
	case 'rondell':
		$index = 13;
		break;			
	default:
		die();
		break;
}

$options 			 = array(
		CURLOPT_COOKIE => 'df_subregions_sid=' . $region,
		CURLOPT_CONNECTTIMEOUT => 20,
		CURLOPT_TIMEOUT        => 60,
		CURLOPT_AUTOREFERER     => TRUE,
		CURLOPT_FOLLOWLOCATION  => TRUE,
		CURLOPT_HEADER => true, 
		CURLOPT_SSL_VERIFYPEER => 0	
); // Подставляем coockie региона
$urlStart 		 = 'https://www.komfortbt.ru/search/';			// Первая часть адреса
$urlStart = 'https://www.komfortbt.ru/search/?search%5Bs_word%5D='.ENGINE_TYPE.'&search%5Baction%5D=search&search%5Bcat_path%5D=';
//$regexpP 			 = "~name=\"result\">.*<b>(.+)<~isU";						// Пагинация
$regexpPrices  = "~<td colspan=\"3\" class=\"menu_b\">(.+)/img/more_btm.gif~isU";	// Все товары на странице
$regexpPrices2 = "~href=\"(.+)\".*>(.+)<.*<span class=\"price\">(.+)<~isU"; // Режем карточки товара

$regexpPrices = "~class='card'>(.+)card-appearance-comment~isU";
$regexpPrices2 = "~href='(.+)'.*class='price'.*<b>(.+)<.*class='action_field_from' itemsid=.*>(.+)<~isU";

$regexpPrices = "~class='card (.+)class='controls'~isU";
$regexpPrices2 = "~href='.*href='(.+)'.*>(.+)<.*class='price'.*<b>(.+)<~isU";

/*
	$options = array(
        CURLOPT_HEADER       		=> FALESE,
        CURLOPT_AUTOREFERER     => TRUE,
        CURLOPT_RETURNTRANSFER  => TRUE,
        CURLOPT_POSTFIELDS => 'search=' . ENGINE_TYPE . '&x=0&y=0'
    );
    action=search&s_word=rondell&search_desc=1&search_code=0&page=all
*/
	$post_data = array('action' 		 => 'search',
									   's_word' 		 => ENGINE_TYPE,	
									   'search_desc' => 1,
										 'search_code' => 0,
										 'page' 			 => 'all'
										 );
	//$AC->request($urlStart, "POST", $post_data, null, $options);
	//$AC->request($urlStart, "POST", $post_data, null, $options);
	for ($i=1; $i <= $index ; $i++) { 
		//$AC->get('https://www.komfortbt.ru/search/page_'.$i.'/?search%5Bs_word%5D='.ENGINE_TYPE.'&search%5Baction%5D=search&search%5Bcat_path%5D=', null, $options);
		$AC->request('https://www.komfortbt.ru/search/page_'.$i.'/?search%5Bs_word%5D='.ENGINE_TYPE.'&search%5Baction%5D=search&search%5Bcat_path%5D=', "POST", $post_data, null, $options);
	}
	

	//echo$urlStart . "\n";
//	$AC->post($url, $post_data = null, $headers = null, $options = null);
//	$AC->post($urlStart, null, null, $options);
	$AC->execute(WINDOW_SIZE);	
/*
	// Наименования товара и цены
	$AC->flush_requests();
	$AC->__set('callback','callback_two');	

	if ($qOfPaginationPages <= 0) { $qOfPaginationPages = 1; } // Если к-во страниц не определилось, сканируем хотя бы одну, иначе будет ошибка Window size
	//echo'Количество страниц: ' . $qOfPaginationPages . "\n";

	for ($i = 1; $i <= $qOfPaginationPages; $i++) {	  
	  $AC->request($urlStart . $i, "POST", $post_data);
	  $AC->add_debug_msg( $urlStart . $i ); // Проверим, какие адреса записываются для выполнения    
	}

	$AC->execute(WINDOW_SIZE);
*/
	while ($bad_urls) {      // Перебираем заново адреса, не вернувшие контент
	  $AC->flush_requests(); // Чистим массив запросов
	  foreach ($bad_urls as $urls) { // Готовим новый цикл из битых URLs
	    $AC->request($urls,"POST", $post_data, null, $options);
	    $AC->add_debug_msg("Bad URLs: $urls"); // LOG ⇒ Можем посмотреть сколько адресов при первом прогоне вернули пустоту        
	  }
	  unset($urls);

	  $bad_urls = array();    // Чистим массив URL-ов для следующего (возможного) цикла    
	  $AC->execute(WINDOW_SIZE);       // Запускаем цикл, пока последний адрес не вернёт контент. Нужно придумать условия выхода!!!!!
	}
	
	unset($urls);



/** 
 *              Callback Functions           
 */
/*
function callback_one($response, $info, $request) {
  global $regexpP;
  global $regexpP2;
  global $qOfPaginationPages;
  global $bad_urls;

  if ($info['http_code'] !== 200) {            

  } else {
		preg_match($regexpP, $response, $matches);
		//print_r($matches);
		if ($matches[1] > ceil($matches[1] / 50)) {
			$qOfPaginationPages = ceil($matches[1] / 50);		    	
		}
  }
}
*/
function callback_one($response, $info, $request) {
	global $regexpPrices;
	global $regexpPrices2;
	global $itemsArray;
	global $bad_urls;
	global $time_start;

	//file_put_contents('/var/www/engines/komfortbt.ru/1.txt', $response);

	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {
    if (stripos($info['url'], ENGINE_CURR)) {
      $bad_urls[] = $info['url'];
    }   
  	/**
  	 * Выходим, если прошло слишком много времени
  	 */  	
		if (round(microtime(1) - $time_start, 0) >= 120) { $bad_urls = array(); }    
  } else {
  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); // Режем все карточки на странице
  	//print_r($matches2);die();
  	foreach ($matches2 as $key) {
			preg_match($regexpPrices2, $key[0], $matches); // Исследуем каждую карточку в отдельности			
			//print_r($matches);
								
				
				if ($matches[3]) {
					price_change_detect('https://www.' . ENGINE_CURR . trim($matches[1]), trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE);
					$itemsArray['https://www.' . ENGINE_CURR . trim($matches[1])] = array(trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), $request->options[10004]);
					AngryCurl::add_debug_msg(trim($matches[3]).' | '.preg_replace('~[\D]+~', '' , $matches[2]));
				}								
			
		} 	
  }
}
