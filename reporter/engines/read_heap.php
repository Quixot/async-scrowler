<?php 
/**
 * vitek BIG
 */
	/**
	 * Список дат за период
	 */
	//$present_file = file_get_contents('http://attraktor:eldorado@176.36.102.174:4080/'.$argv[2].'/heap/'.date('d.m.y').'_'.$argv[3].'.data');


//var_dump(filter_var('https://www.ozon.ruhttps://seller.ozon.ru/","isVisible":false,"cellTrackingInfo":{"index":1,"type":"ui","title":"Ваши товары на Ozon"}},{"title":"Реферальная программа","link":"/manager/', FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED));

//var_dump(filter_var('https://www.ozon.ru/context/detail/id/155723631/', FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED));

//die();

	$present_file = file_get_contents('/var/www/'.$argv[2].'/heap/'.date('d.m.y').'_'.$argv[3].'.data');

	unset($present_file);
	
	$timer = microtime(1);

	$from = new DateTime('now');
	$to   = new DateTime('now +1 day');

	//$from = new DateTime('now -16 day');
	//$to   = new DateTime('now');	

	$date_for_name = date('dmy');
	$dateHis = date('H:i:s');
	$datedmy = date('d.m.y');

	//$date_for_name = '180617';
	//$dateHis = '';
	//$datedmy = '18.06.17';

	$period = new DatePeriod($from, new DateInterval('P1D'), $to);
	
	$arrayOfDates = array_map(
	    function($item){return $item->format('d.m.y');},
	    iterator_to_array($period)
	);
	// Переварачиваем массив, чтобы в результирующем отчёте шёл начиная с последней даты (самой свежей информации)
	$arrayOfDates = array_reverse($arrayOfDates);

	//$arrayOfDates = array_slice($arrayOfDates, 0, 3); // КОСТЫЛЬ!!! УБРАТЬ!!! ТОЛЬКО ДЛЯ ТЕСТОВ!!!

	$objPHPExcel = PHPExcel_IOFactory::load('/var/www/reporter/settings/polaris_common.xlsx');
/**
 * Это массив с ценами РИЦ и реальными именами CLIENT_NAME
 */
	$sheet = $objPHPExcel->getSheet(0);
	//$qountity = $sheet->getCell( 'G1' )->getOldCalculatedValue();
	$qountity = $sheet->getHighestRow(); // Сколько строк
	echo 'массив с ценами РИЦ: '.$qountity.PHP_EOL;
	$data = $sheet->rangeToArray('A2:H'.$qountity);
	$i = 0;
	foreach ($data as $row) {
	  $priceArray[$row[1].'_'.$row[4]] = array($row[0], $row[1], $row[5], $row[2], $row[3], $row[6], $row[7], $row[4]); // REALNAME POSITION CODE REALRICE Тип Наименование товара
	}


	/**
	 * Открываем heap:
	 */	
	$max_dates = 0;
	$date_group_index = 0;
	foreach ($arrayOfDates as $date) {
		//if (strripos($date, '05.17') === false) { // Убираем май !!! KOSTYL !!!

			echo 'Дата: '.$date.PHP_EOL;
			if (strlen($argv[3])>1) {
				$indx = 1;
			} else {
				$indx = $argv[3];
			}/**/
			$heap_file_path = '/var/www/'.$argv[2].'/heap/'.$date.'_'.$argv[3].'.data';
			
			//$heap_file_path = '/var/www/'.$argv[2].'/heap/'.$date.'_1'.'.data';

			
			$tempHeap = unserialize(file_get_contents($heap_file_path));
			echo $heap_file_path.PHP_EOL;
			//file_put_contents('/var/www/polaris/engines/beru.ru/1.txt', print_r($tempHeap, 1));die();
			// Дата
			$dateValue = $datedmy;
			if ($tempHeap) {
				$date_group_index++; // Позиция текущей даты даты, прибавляется к последнему ряду
				$max_dates++;
			 	foreach ($tempHeap as $key => $value) {
			 		foreach ($value as $key2 => $value2) {
				 		foreach ($value2 as $info) {
				 			if ($info && $info[5]/$info[4] >= 0.33 && $info[5]/$info[4] <= 3) { // Отсечка уценки или ошибки с ценой - сильно завышена, сильно занижена
				 				$itemsArray[] = $info[2]; 
				 			// КОД -> Город -> Сайт -> Дата  =  РИЦ | Цена магазина | url | Name | Индекс даты | Merch
				 			}
						}
			 		}
			 	}
			 	echo microtime(1)-$timer.PHP_EOL;
			}

		//} // if блок, убираем МАЙ
	} // Dates перебор
	$itemsArray = array_unique($itemsArray);
	file_put_contents('/var/www/reporter/heaps.txt', print_r($itemsArray, 1));

