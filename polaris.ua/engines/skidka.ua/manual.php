<?php


$itemsArray = unserialize(file_get_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data'));
$regexpPrices   = "~class=\"one-item \"(.+)one-item-descr~isU";
$regexpPrices2  = "~class=\"one-item-tit.*<a href=\"(.+)\".*>(.+)<.*class=\"now-item-price.*>(.+)<~isU"; // Режем карточки товара
$regexpPrices3  = "~class=\"one-item-tit.*<a href=\"(.+)\".*>(.+)<~isU"; // Режем карточки товара нет в наличии
$regexpPricesName = "~class=\"big-img-wrap\".*alt=\"(.+)\"~isU";
$regexpItemPage = "~itemprop=\"price\">.*>(.+)<~isU";

$itemsArray = array();


	$AC = new AngryCurl('callback_two');
	$AC->init_console();
	callback_two($response, $info, $request);

	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));

	function callback_two($response) {
  global $regexpP;
  global $qOfPaginationPages;
  global $bad_urls;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpPricesName;
	global $itemsArray;  
	global $time_start;

	global $itemsArray;

	//file_put_contents('/var/www/engines/rbt.ru/content.txt', $response);
//die();

		if (strlen($response) > 500) {
			echo 'response ok manual'.PHP_EOL;

			$response = stripcslashes($response);

		  preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); //
		  //print_r($matches2);
		  foreach ($matches2 as $key) {
		  	preg_match($regexpPricesName, $key[1], $matchesN);
				preg_match($regexpPrices2, $key[1], $matches);
				@$matchesN[1] = trim($matchesN[1]);
				$matchesN[1] = str_replace(' - фото', '', $matchesN[1]);
				$matches[2] = trim($matches[2]);
				if (strlen($matchesN[1]) > strlen($matches[2])) {
					$matches[2] = $matchesN[1];
				}
				//print_r($matches);
				if (strripos($key[1], 'add-to-basket-action') !== false || strripos($key[1], 'В магазин') !== false) { // Тут дополнительно нужно проверять наличие. Если кнопка оранжевая, сканируем	
					if ($matches[1]) {
						price_change_detect('https://skidka.ua'.trim($matches[1]), trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
						$itemsArray['https://skidka.ua'.trim($matches[1])] = array(trim($matches[2]), preg_replace('~[\D]+~', '' , $matches[3]), date("d.m.y-H:i:s"), 'manual');
						echo trim($matches[2]).' | '.preg_replace('~[\D]+~', '' , $matches[3]).PHP_EOL;	
					}				
				} else {
					preg_match($regexpPrices3, $key[1], $matches);
					if (strripos($key[1], 'Нет в наличии') !== false AND strripos($matches[1], 'http:') !== false) {
						if ($matches[1]) {
							price_change_detect('https://skidka.ua'.trim($matches[1]), trim($matches[2]), '0', date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
							$itemsArray['https://skidka.ua'.trim($matches[1])] = array(trim($matches[2]), '0', date("d.m.y-H:i:s"), 'manual');
							echo trim($matches[2]).' | 0'.PHP_EOL;						
						}					
					}
				}
			}
			return 1;
		}
}

include('/var/www/'.ENGINE_TYPE.'/footer.php');