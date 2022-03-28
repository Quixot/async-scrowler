<?php
	$itemsArray = array();
	for($i = 1;$i <= 3;$i++) {
		exec('xvfb-run --server-args="-screen 0, 1024x768x24" ./CutyCapt --header=Cookie:region=053adb6202177e482e74fdaf1c0fdd3ac2935896%7E --url=http://shop.v-lazer.com/catalog/~/search/page-' . $i . '/?query=rondell --out=out' . $i . '.html');
		$regexpPrices  = "~class=\"cell \"(.+)class=\"availablelist\"~isU";
		$regexpPrices2 = "~class=\"name\".*href=\"(.+)\".*>(.+)<.*class=\"price\".*<li.*>(.+)<~isU";	// Все товары на странице
		$regexpPrices3 = "~class=\"name\".*href=\"(.+)\".*>(.+)<~isU";	// Все товары на странице

  	$response = file_get_contents('/var/www/vitek/engines/shop.v-lazer.com/out' . $i . '.html');
  	

  	preg_match_all($regexpPrices, $response, $matches2, PREG_SET_ORDER); // Режем все карточки на странице
  	//print_r($matches2);
  	foreach ($matches2 as $key) {		
			preg_match($regexpPrices2, $key[1], $matches); // Исследуем каждую карточку в отдельности
			if ($matches[3]) {
				//$matches = parser_clean($matches, 2, 3);
 				$itemsArray['http://shop.v-lazer.com' . trim($matches[1])] = array(iconv('utf-8', 'windows-1251', $matches[2]), $matches[3]);
				//echo 'http://shop.v-lazer.com' . trim($matches[1]) . "\n";	
			} else {
				preg_match($regexpPrices3, $key[1], $matches);
				if ($matches[1]) {					
					$matches[2] = str_replace(';', ' ', $matches[2]);
	 				$itemsArray['http://shop.v-lazer.com' . trim($matches[1])] = array(iconv('utf-8', 'windows-1251', $matches[2]), '0');
					//echo 'http://shop.v-lazer.com' . trim($matches[1]) . "\n";						
				}
			}
		}
		unlink('/var/www/vitek/engines/shop.v-lazer.com/out' . $i . '.html');
	}

//echo 'itemsArray: ' . count($itemsArray) . "\n";
// Create CSV file
if (count($itemsArray) > 0) {
	// Create CSV file
	$handle = fopen('/var/www/vitek/reports/shop.v-lazer.com_rondell_vladivostok.csv', 'w'); // CSV file

	$i = 0;
	$storeHeader = array(); // Название магазина. Хранит уже встречавшиеся названия и соответственно к-во таковых и цены в текущей итерации
	ksort($itemsArray);
	reset($itemsArray);
	$vowels = array("\n", "\r", "\t", "\x0B", "&#8203;", ";");
	foreach ($itemsArray as $key => $value) {
	  $key = str_replace($vowels, ' ', $key);
	  $key = trim($key);
	  fputs($handle, $key . ';' . $value[0] . ';' . preg_replace('~[^\d.]+~', '' , $value[1]) . "\n");
	}
	$time_end = microtime(1);   // Останавливаем счётчик, смотрим, сколько времени работал скрипт
	//fputs($handle, "\n\n" . round($time_end - $time_start, 2) . "sec.");
	//fputs($handle, "\n" . date("d.m.y-H:i:s"));
	fclose($handle);
}
