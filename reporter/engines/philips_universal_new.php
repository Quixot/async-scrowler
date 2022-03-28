<?php 
/**
 * PHILIPS
 */
//$cur_date = '01.10.17';

	$from = new DateTime('now -27 day');
	$to   = new DateTime('now +1 day');

	$period = new DatePeriod($from, new DateInterval('P1D'), $to);
	$arrayOfDates = array_map(
	    function($item){return $item->format('d.m.y');},
	    iterator_to_array($period)
	);
	// Переварачиваем массив, чтобы в результирующем отчёте шёл начиная с последней даты (самой свежей информации)
	$arrayOfDates = array_reverse($arrayOfDates);






foreach ($arrayOfDates as $date) {
	$sheet_name_index = substr($fileName, -1);
	$objPHPExcel = PHPExcel_IOFactory::load($dataFfile);

/**
 * Нечёткий поиск URL NAME CODE
 */
	$sheet = $objPHPExcel->getSheet(4);
	$qountity = $sheet->getCell( 'D1' )->getOldCalculatedValue(); // Хак для формул

	$data = $sheet->rangeToArray('A2:C'.$qountity);
	foreach ($data as $row) {
	  $keyURL[]  = $row[0]; // URL
	  $keyNAME[] = $row[1]; // NAME
	  $keyREALNAME[] = $row[2]; // REALNAME
	}
	echo 'Нечёткий поиск: '.count($data).PHP_EOL;

/**
 * Алиасы городов
 */
	$sheet = $objPHPExcel->getSheet(1);
	$qountity = $sheet->getCell( 'C1' )->getOldCalculatedValue(); // Хак для формул
	$data = $sheet->rangeToArray('A2:B'.$qountity);
	foreach ($data as $row) {
	  $keyALIAS[$row[1]]  = $row[0]; // ALIAS SITY_RU
	}
	echo 'Алиасы городов: '.count($data).PHP_EOL;
/**
 * Это массив с ценами РИЦ и реальными именами CLIENT_NAME
 */
	$sheet = $objPHPExcel->getSheet(0);
	$qountity = $sheet->getCell( 'E1' )->getOldCalculatedValue();
	$data = $sheet->rangeToArray('A2:D'.$qountity);
	foreach ($data as $row) {
	  $priceArray[$row[2]] = array($row[0], $row[1], $row[3]); // REALNAME POSITION CODE REALRICE
	}
	echo 'Имя и РИЦ: '.count($data).PHP_EOL;
/**
 * Вид: МАГАЗИНЫ
 */
	$sheet = $objPHPExcel->getSheet(3);
	$qountity = $sheet->getCell( 'C1' )->getOldCalculatedValue();
	$data = $sheet->rangeToArray('A2:B'.$qountity);
	foreach ($data as $row) {
	  if ($row[0]) {
	  	$tempStore = $row[0];
	  }
	  $STORE_ORDER[$tempStore][$row[1]] = array(); // STORE
	}
	echo 'Представление магазины: '.count($data).PHP_EOL;
/**
 * Вид: ГОРОДАМИ
 */
	$sheet = $objPHPExcel->getSheet(2);
	$qountity = $sheet->getCell( 'C1' )->getOldCalculatedValue();
	$data = $sheet->rangeToArray('A2:B'.$qountity);
	foreach ($data as $row) {
	  if ($row[0]) {
	  	$tempCity = $row[0];
	  }
	  $CITY_ORDER[$tempCity][$row[1]] = array(); // CITY
	}
	echo 'Представление города: '.count($data).PHP_EOL;
/**
 * Страница с раскраской
 */	
	$sheet_with_color = $objPHPExcel->getSheet(5);

/**
 * База замещения одного города другим (обычно мелкий город замещается крупным городом)
 */
	$sheet = $objPHPExcel->getSheet(6);
	$qountity = $sheet->getCell( 'D1' )->getOldCalculatedValue();
	$data = $sheet->rangeToArray('A2:C'.$qountity);
	foreach ($data as $row) {
	  $CHANGE_CITY[$row[0]][$row[1]] = $row[2]; // ALIAS SITY_RU
	}

	echo round((microtime(1)-$start), 2).PHP_EOL;
	echo 'Starting main LOOP...'.PHP_EOL;


	
/**
 * Будем открывать файл за файлом и...
 */
	$pathes = glob('/var/www/'.ENGINE_TYPE.'/engines/*/data/'.$date.'*'.ENGINE_TYPE.'*.data');

	$q_of_stores = count($pathes); // Общее к-во
	$istatus = 1;
	

	foreach ($pathes as $keypath) { // Перебираем каждый файлик

		system('clear');
		echo '[';
		for ($is=1; $is < $istatus*100/$q_of_stores; $is++) { 
			echo '■';	
		}
		for ($is=$istatus*100/$q_of_stores; $is <= 100; $is++) { 
			echo '.';	
		}
		echo ']'.PHP_EOL;
		$istatus++;

		preg_match("~engines/(.+)/.*".ENGINE_TYPE."_(.+).data~isU", $keypath, $matches);
		$STORE = $matches[1];
		$CITY  = $matches[2];



		if (file_exists($keypath)) { // Если data файлик реально существует, обрабатываем его
			//echo 'Current: '.$STORE.'_'.$CITY.PHP_EOL;
			//echo $keypath.PHP_EOL;
			echo PHP_EOL.' '.$matches[1].PHP_EOL.' ';
			$current_row_array = unserialize(file_get_contents($keypath)); // Массив текущего магазина/города

			foreach ($current_row_array as $URL => $content) { // Перебираем позицию за позицией и ищем соответствия с эталонным массивом
				$key = array_search($content[0], $keyNAME);
				if ($key === false) {
					$key = array_search($URL, $keyURL);
				}
				
				$content[1] = preg_replace('~[^\d]+~', '' , $content[1]);
				if ($key !== false && $content[1] > 0) { // Ищем по URL или по NAME
					//$key = array_search($content[0], $keyNAME);
					$REALNAME = $keyREALNAME[$key];

					$V_POSITION = $priceArray[$REALNAME][0];
					$CODE 		  = $priceArray[$REALNAME][1];
					$REALPRICE  = $priceArray[$REALNAME][2];
					$PRICE 			= $content[1];
					if (isset($keyALIAS[$CITY])) {
						$CITY_RU		= trim($keyALIAS[$CITY]);
					}
					/*
					echo $URL.PHP_EOL;				// url
					echo $CODE.PHP_EOL;				// client CODE
					echo $REALNAME.PHP_EOL;		// client NAME
					echo $REALPRICE.PHP_EOL;	// client PRICE
					echo $PRICE.PHP_EOL;			// Store 	PRICE
					echo $CITY.PHP_EOL;				// Current City
					echo $CITY_RU.PHP_EOL;		// RU city name
					echo $STORE.PHP_EOL;			// Current Store
					echo '*******'.PHP_EOL;	

					*/

					/**
					 * Массив для отчёта ПО МАГАЗИНАМ и 
					 * Массив для отчёта ПО ГОРОДАМ
					 */
					//echo $V_POSITION.PHP_EOL.$CODE.PHP_EOL. $URL.PHP_EOL. $REALNAME.PHP_EOL. $REALPRICE.PHP_EOL. $PRICE.PHP_EOL;
					if ($URL && $CODE && $REALNAME && $REALPRICE && $PRICE && isset($STORE_ORDER[$STORE][$CITY_RU])) {
						/**
						 * TODO:
						 * Дописать обработку ситуации, когда файлик есть, а предустановленного региона или магазина в массиве нет
						 */
						$STORE_ORDER[$STORE][$CITY_RU][] = array($V_POSITION, $CODE, $URL, $REALNAME, $REALPRICE, $PRICE);
						$CITY_ORDER[$CITY_RU][$STORE][]  = array($V_POSITION, $CODE, $URL, $REALNAME, $REALPRICE, $PRICE);
						echo '■';
					}
				}
			}
			preg_match("~data/.*_(.+).data~isU", $keypath, $matches);
			
		}
	}


	echo round((microtime(1)-$start).PHP_EOL. 2).PHP_EOL;
	echo 'End creating array. Starting writing to cells...'.PHP_EOL;
	echo 'City->_Shop'.PHP_EOL;



	file_put_contents('/var/www/'.ENGINE_TYPE.'/heap/'.$date.'_1.data', serialize($STORE_ORDER));
}
