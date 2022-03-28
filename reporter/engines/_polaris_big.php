<?php 
/**
 * vitek BIG
 */
	/**
	 * Список дат за период
	 */
	$present_file = file_get_contents('http://attraktor:eldorado@176.36.102.174:4080/'.$argv[2].'/heap/'.date('d.m.y').'_'.$argv[3].'.data');
	if (!$present_file) {
		mail('alexandr.volkoff@gmail.com', 'Polaris Big Date Problem!', 'Polaris Big Date Problem! No todays heap file!', "From: info@pricinglogix.com");
		//die('no todays heap file!'.PHP_EOL);
		sleep(180);
		$present_file = file_get_contents('http://attraktor:eldorado@176.36.102.174:4080/'.$argv[2].'/heap/'.date('d.m.y').'_'.$argv[3].'.data');
	}
	
	if (!$present_file) {
		mail('alexandr.volkoff@gmail.com', 'Polaris Big Date Problem 2!', 'Polaris Big Date Problem! No todays heap file! Second try', "From: info@pricinglogix.com");
		//die('no todays heap file!'.PHP_EOL);
		sleep(180);
		$present_file = file_get_contents('http://attraktor:eldorado@176.36.102.174:4080/'.$argv[2].'/heap/'.date('d.m.y').'_'.$argv[3].'.data');
	}	
	if (!$present_file) {
		mail('alexandr.volkoff@gmail.com', 'Polaris Big Date Problem 3!', 'Polaris Big Date Problem! No todays heap file! Third try. Get obolon backup heap', "From: info@pricinglogix.com");
		//die('no todays heap file!'.PHP_EOL);
		//sleep(180);
		$present_file = file_get_contents('http://attraktor:eldorado@82.193.126.150/'.$argv[2].'/heap/'.date('d.m.y').'_'.$argv[3].'.data');
	}
	if (!$present_file) {
		mail('alexandr.volkoff@gmail.com', 'Polaris Big Date Problem 4!', 'Polaris Big Date Problem! No todays heap file! Forth try. Get local heap', "From: info@pricinglogix.com");
		//die('no todays heap file!'.PHP_EOL);
		//sleep(180);
		$present_file = file_get_contents('/var/www/polaris/heap/'.$argv[2].'/heap/'.date('d.m.y').'_'.$argv[3].'.data');
	}			
	unset($present_file);

	$timer = microtime(1);

	$from = new DateTime('now -15 day');
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
	  //print_r($priceArray);die();
	}


	/**
	 * Открываем heap:
	 */	
	$max_dates = 0;
	$date_group_index = 0;
	foreach ($arrayOfDates as $date) {
		//if (strripos($date, '05.17') === false) { // Убираем май !!! KOSTYL !!!

			echo 'Дата: '.$date.PHP_EOL;
			$heap_file_path = 'http://attraktor:eldorado@176.36.102.174:4080/'.$argv[2].'/heap/'.$date.'_'.$argv[3].'.data';
			//$heap_file_path = 'http://quixote:eldorado@82.193.126.150/'.$argv[2].'/heap/'.$date.'_'.$argv[3].'.data';
			//$heap_file_path = '/var/www/'.$argv[2].'/heap/'.$date.'_1'.'.data';
			
			$tempHeap = unserialize(file_get_contents($heap_file_path));
			echo $heap_file_path.PHP_EOL;
			// Дата
			$dateValue = $datedmy;
			if ($tempHeap) {
				$date_group_index++; // Позиция текущей даты даты, прибавляется к последнему ряду
				$max_dates++;
			 	foreach ($tempHeap as $key => $value) {
			 		foreach ($value as $key2 => $value2) {
				 		foreach ($value2 as $info) {
							if ($info && $info[5]/$info[4] >= 0.33 && $info[5]/$info[4] <= 3) { // Отсечка уценки или ошибки с ценой - сильно завышена, сильно занижена
								$itemsArray[$info[1]][$key2][$key][$date] = array($info[4], $info[5], $info[2], $info[3], $date_group_index); 
							}
				 			// КОД -> Город -> Сайт -> Дата  =  РИЦ | Цена магазина | url | Name | Индекс даты		
						}
			 		}
			 	}
			 	echo microtime(1)-$timer.PHP_EOL;
			}
			

		//} // if блок, убираем МАЙ
	} // Dates перебор
	//die();
	echo 'unset $tempHeap'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;
	unset($tempHeap);

	echo 'data array is ready'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;
	
	/**
	 * Готовим файл Excel
	 */	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("PricingLogix");
	$objPHPExcel->getProperties()->setTitle("PricingLogix");
	//$objPHPExcel->getProperties()->setSubject("PricingLogix" . ' ' . $dateHis);
	$objPHPExcel->getProperties()->setDescription("generated by PricingLogix");
	$objPHPExcel->getActiveSheet()->setTitle($datedmy.' '.ucfirst($argv[2]));	
	$objPHPExcel->getActiveSheet()->setShowGridlines(false); // Убрать сетку
	$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(90); // Масштаб 90%
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Verdana')->setSize(8); // Шрифт по умолчанию
	$objPHPExcel->getActiveSheet()->setTitle('Monitoring_'.ucfirst($argv[2]).'_'.$date_for_name.'_'.$argv[3]);
	$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(10.3);


	// Вставим ЛОГОТИП
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Logo');
	$objDrawing->setDescription('Logo');
	$logo = AC_DIR.'/settings/logo.png'; // Provide path to your logo file
	$objDrawing->setPath($logo);
	$objDrawing->setOffsetX(1);    // setOffsetX works properly
	$objDrawing->setCoordinates('B2');
	$objDrawing->setHeight(35); // logo height
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);			// ...отступ...
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(11);  	// Артикул
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(26);		// Номенклатура
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(45);			// Ключевые города
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(18);		// Город
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);		// Клиент
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(6);			// РИЦ
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(7);			// Зона цены
/**/
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 5, 'Артикул');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 5, 'Номенклатура');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 5, 'Модель');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 5, 'Город');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 5, 'Клиент');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 5, 'РИЦ');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 5, 'Зона цены');

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($max_dates + 8, 5, 'Ссылка');

	$objPHPExcel->getActiveSheet()->getStyle("B5:CA5")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("B5:H5")->applyFromArray(array('borders' => array('allborders' => array(
							            					'style' => PHPExcel_Style_Border::BORDER_THIN,
							            					'color' => array('rgb' => '000000')
								            				))));

	echo 'Draw network'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;

/**
  * Рисуем сетку:
  */ 
	$objPHPExcel->getDefaultStyle()
	    ->getAlignment()
	    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	//$objPHPExcel->getDefaultStyle()
	//    ->getAlignment()
	//    ->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);	    


	echo 'Height'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;	
	$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(39);

	$objPHPExcel->getActiveSheet()->getStyle('B5:Y5')->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('B5:Y5')->applyFromArray(
		array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
															 'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER)));

/*
	$endC 	= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $i-1)->getCoordinate();
	$objPHPExcel->getActiveSheet()->getStyle('B5:'.$endC)->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(39); 	 // Высота шапки
	$objPHPExcel->getActiveSheet()->freezePane('I6');	

	$endC 	= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($max_dates+8, $i-1)->getCoordinate();
	$objPHPExcel->getActiveSheet()->getStyle('B5:'.$endC)->applyFromArray(
		array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
															 'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER)));
*/


// $itemsArray[$info[1]][$key][$key2][$date.'_'.$pref] = array($info[4], $info[5], $info[2], $info[3]); // РИЦ | Цена магазина | url | Name
// Код / Город / Сайт / Дата = РИЦ | Цена магазина | url | Name
	

	
	$i = 6;
	foreach ($itemsArray as $code => $siteArray) { // Артикул
		foreach ($siteArray as $city => $cityArray) { // Город
			foreach ($cityArray as $site => $dateArray) { // Сайт
				$pervy_prohod = 1;
				foreach ($dateArray as $date => $info) { // Дата и информация
					// Раскрашиваем "Зона цены", разница в ценах между вчера и сегодня
					
					if ($info[4] == 1) { // Если это первый проход
						if ((int)$info[1]>0 && (int)$info[0]!=0) {
							$divergency = (int)$info[1]/(int)$info[0];
							if ($divergency <= 0.9) {
								$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FF0000'));
							} elseif (($divergency > 0.9 && $divergency <= 0.97)) {
								$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FFFF00'));
							} else {
								$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FFFFFF'));
							}
						}							
						$styleArray = array('fill' => $color);
						$colorCell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $i)->getCoordinate();
						$objPHPExcel->getActiveSheet()->getStyle($colorCell)->applyFromArray($styleArray);

					}




	

					$dateValue = PHPExcel_Shared_Date::PHPToExcel(DateTime::createFromFormat('d.m.y', $date));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($info[4]+7, 5, $dateValue); // Дата
					$objPHPExcel->getActiveSheet()
							    ->getStyle($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($info[4]+7, 5)->getCoordinate())
							    ->getNumberFormat()
							    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, $code);					// Артикул
					$nomenklatura = substr($info[3], strlen($code)+1);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, $nomenklatura);			// Номенклатура
					$model_name = $priceArray[$info[3]][4];



					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, $model_name);					// Модель
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, $city);								// Город
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, $site);								// Клиент
					//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, $info[0]); 						// РИЦ
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, $priceArray[$info[3]][2]); 						// РИЦ
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($info[4]+7, $i, $info[1]); 	// Цена магазина
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($max_dates+8, $i, $info[2]); // url в самом конце


					/**
					 * Розово - Зелёные цены
					 */

					// Тут нужно поймать такую же позицию за прошлый день:
					// КОД -> Город -> Сайт -> Дата  =  РИЦ | Цена магазина | url | Name | Индекс даты
					/*
					echo $code.PHP_EOL;
					echo $city.PHP_EOL;
					echo $site.PHP_EOL;
					echo $date.PHP_EOL;
					$key_of_date = array_search($date, $arrayOfDates);
					echo $arrayOfDates[$key_of_date+1].PHP_EOL;
					echo $itemsArray[$code][$city][$site][$arrayOfDates[$key_of_date+1]][1].PHP_EOL;
					print_r($itemsArray[$code][$city][$site][$arrayOfDates[$key_of_date+1]]);
					die();
					*/
					$key_of_date = array_search($date, $arrayOfDates);
					if (!isset($itemsArray[$code][$city][$site][$arrayOfDates[$key_of_date+1]])) { // На случай, когда выпадает один день по середине массива, ищем день ранее
						$key_of_date++;
					}
					$color = '';
					if ((int)$itemsArray[$code][$city][$site][$arrayOfDates[$key_of_date+1]][1]>0 && isset($arrayOfDates[$key_of_date+1])) {
						$divergency = (int)$info[1]/(int)$itemsArray[$code][$city][$site][$arrayOfDates[$key_of_date+1]][1];
						if ($divergency >= 1.00333) { // Заливаем светл.зел.цветом, если ТекЦена/ЦенаВчерДня >= 1,00333
							$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'c6efce'));
						} elseif ($divergency <= 0.99667) { // Заливаем роз.цветом, если ТекЦена/ЦенаВчерДня <= 0,99667
							$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'ffc7ce'));
						}
					}

					if ($color) { // Цвет Зона цены
						$colorCell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($info[4]+7, $i)->getCoordinate();
						$objPHPExcel->getActiveSheet()->getStyle($colorCell)->applyFromArray(array('fill' => $color));
					}


					if ($pervy_prohod == 1) {
						$pervy_prohod = 0;
/**
 * Разукрашиваем ПРОМО и COREASSORT
 */
						if ($priceArray[$info[3]][5]) {
							$objPHPExcel->getActiveSheet()->getStyle('B'.$i.':F'.$i)->applyFromArray(
									array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffc7ce'))));
						}
						if ($priceArray[$info[3]][6]) {
							$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->applyFromArray(
									array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffc7ce'))));
							$objPHPExcel->getActiveSheet()->getComment('G'.$i)->setAuthor('PricingLogix');
							$objPHPExcel->getActiveSheet()->getComment('G'.$i)->getText()->createTextRun($priceArray[$info[3]][6]);
						}

						// Если core ассортимент, закрашиваем модель в #ffeb9c
						if (stripos($priceArray[$info[3]][6], 'Core assort') !== false && stripos($priceArray[$info[3]][6], 'ПРОМО') === false) {
							$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->applyFromArray(
									array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffeb9c'))));		
							$objPHPExcel->getActiveSheet()->getStyle('B'.$i.':G'.$i)->applyFromArray(
									array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffeb9c'))));	
						}
/**
 * Разукрашиваем ПРОМО и COREASSORT
 */
					}


				}
				$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(10.3); 
				$i++;
			}
		}
		echo microtime(1)-$timer.PHP_EOL;
		unset($itemsArray[$code]);
		echo $code.PHP_EOL;
	}

	echo 'Borders'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;

	$endC 	= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($max_dates+8, 5)->getCoordinate();
	$objPHPExcel->getActiveSheet()->getStyle('B5:'.$endC)->applyFromArray(
		array('borders' => array('allborders' => array(
							            					'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
							            					'color' => array('rgb' => '000000')
							            				))));

	echo 'Autofilters'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;

	$objPHPExcel->getActiveSheet()->setAutoFilter('B5:'.$endC); // Фильтры
	// Делаем красным всю колонку РИЦ
	echo 'Red colour РИЦ'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;	
	$endC 	= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $i-1)->getCoordinate();
	$objPHPExcel->getActiveSheet()->getStyle('G5:'.$endC)->applyFromArray(array( 'font'  		=> array('color' => array('rgb' => 'FF0000'))));


	$objPHPExcel->getActiveSheet()->freezePane('I6');

	//echo 'Password...';
	// Пароль на запись
	//$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
	//$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
	//$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
	//$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
	//$objPHPExcel->getActiveSheet()->getProtection()->setPassword('1129');

	echo 'Killing array...';
	unset($itemsArray);
	echo 'Saving...';
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

	$fileName = 'Monitoring_'.ucfirst($argv[2]).'_'.$date_for_name.'_'.$argv[3].'.xlsx';
	$objWriter->save('/var/www/reporter/reports/polaris_big/'.$fileName);
