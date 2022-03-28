<?php 
/**
 * OPTIMIZED
 */
	$objPHPExcel = PHPExcel_IOFactory::load($dataFfile);
 	// Нечёткий поиск URL NAME CODE
	$sheet = $objPHPExcel->getSheet(4);
	$qountity = $sheet->getCell( 'D1' )->getOldCalculatedValue(); // Хак для формул
	$data = $sheet->rangeToArray('A2:C'.$qountity);
	foreach ($data as $row) {
	  $keyURL[]  = $row[0]; 		// URL
	  $keyNAME[] = $row[1]; 		// NAME
	  $keyREALNAME[] = $row[2]; // REALNAME
	}
	// Алиасы городов
	$sheet = $objPHPExcel->getSheet(1);
	$qountity = $sheet->getCell( 'C1' )->getOldCalculatedValue(); // Хак для формул
	$data = $sheet->rangeToArray('A2:B'.$qountity);
	foreach ($data as $row) {
	  $keyALIAS[$row[1]]  = $row[0]; // ALIAS SITY_RU
	}
	$keyN_ALIAS = array_flip($keyALIAS);
  // Это массив с ценами РИЦ и реальными именами CLIENT_NAME
	$sheet = $objPHPExcel->getSheet(0);
	$qountity = $sheet->getCell( 'E1' )->getOldCalculatedValue();
	$data = $sheet->rangeToArray('A2:D'.$qountity);
	foreach ($data as $row) {
	  $priceArray[$row[2]] = array($row[0], $row[1], $row[3]); // REALNAME POSITION CODE REALRICE
	}
  // Вид: МАГАЗИНЫ
	$sheet = $objPHPExcel->getSheet(3);
	$qountity = $sheet->getCell( 'C1' )->getOldCalculatedValue();
	$data = $sheet->rangeToArray('A2:B'.$qountity);
	foreach ($data as $row) {
	  if ($row[0]) {
	  	$tempStore = $row[0];
	  }
	  $STORE_ORDER[] = $tempStore.'_'.$keyN_ALIAS[$row[1]]; // STORE
	}

  // Вид: ГОРОДА
	$sheet = $objPHPExcel->getSheet(2);
	$qountity = $sheet->getCell( 'C1' )->getOldCalculatedValue();
	$data = $sheet->rangeToArray('A2:B'.$qountity);
	foreach ($data as $row) {
	  if ($row[0]) {
	  	$tempCity = $row[0];
	  }
	  $CITY_ORDER[] = array( $tempCity => $row[1]); // CITY
	}

	foreach ($data as $row) {
	  if ($row[0]) {
	  	$tempCity = $row[0];
	  }
	  $CITY_ORDER[] = $keyN_ALIAS[$tempCity].'_'.$row[1]; // STORE
	}	
		print_r($CITY_ORDER);
		die();

  // База замещения одного города другим (обычно мелкий город замещается крупным городом)
	$sheet = $objPHPExcel->getSheet(5);
	$qountity = $sheet->getCell( 'D1' )->getOldCalculatedValue();
	$data = $sheet->rangeToArray('A2:C'.$qountity);
	foreach ($data as $row) {
	  $CHANGE_CITY[$row[0]][$row[1]] = $row[2]; // ALIAS SITY_RU
	}

	echo round((microtime(1)-$start), 2).PHP_EOL;
	echo 'Starting main LOOP...'.PHP_EOL;
	echo "MEMORY: ".memory_get_usage()." bytes \n";




/**
 * Будем открывать файл за файлом и...
 */
	//$pathes = glob('/var/www/'.ENGINE_TYPE.'/reports/*.xlsx');
	$pathes = glob('/var/www/'.ENGINE_TYPE.'/engines/*/data/'.$cur_date.'*.data');
	foreach ($pathes as $key) { // Перебираем каждый файлик
		preg_match("~engines/(.+)/.*".ENGINE_TYPE."_(.+).data~isU", $key, $matches);
		$STORE = $matches[1];
		$CITY  = $matches[2];

		if (file_exists($key)) { // Если data файлик реально существует, обрабатываем его
			$current_row_array = unserialize(file_get_contents($key)); // Массив текущего магазина/города
			// Перебираем позицию за позицией и ищем соответствия с эталонным массивом
			foreach ($current_row_array as $URL => $content) {
				$key = array_search($URL, $keyURL);
				if ($key === false) {
					$key = array_search($URL, $keyNAME);
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
					if ($URL && $CODE && $REALNAME && $REALPRICE && $PRICE && isset($STORE_ORDER[$STORE][$CITY_RU])) {
						/**
						 * TODO:
						 * Дописать обработку ситуации, когда файлик есть, а предустановленного региона или магазина в массиве нет
						 */
						$STORE_ORDER[$STORE][$CITY_RU][] = array($V_POSITION, $CODE, $URL, $REALNAME, $REALPRICE, $PRICE);
						$CITY_ORDER[$CITY_RU][$STORE][]  = array($V_POSITION, $CODE, $URL, $REALNAME, $REALPRICE, $PRICE);
					}
				}
			}
		}
	}

/**
 * Перебираем массив городов, которые необходимо дополнить (книга 5 в settings)
 * Если есть вообще такие города
 * Если такой магазин есть в массиве магазинов $STORE_ORDER
 * 
 */
	if ($CHANGE_CITY) {
		foreach ($CHANGE_CITY as $change_store => $change_city) {
			if (isset($STORE_ORDER[$change_store])) {
				foreach ($change_city as $key => $value) {
					$STORE_ORDER[$change_store][trim($keyALIAS[$key])] = $STORE_ORDER[$change_store][trim($keyALIAS[$value])];
					$CITY_ORDER[trim($keyALIAS[$key])][$change_store] = $CITY_ORDER[trim($keyALIAS[$value])][$change_store];
				}
			}
		}
	}

	echo round((microtime(1)-$start).PHP_EOL. 2).PHP_EOL;
	echo "MEMORY: ".memory_get_usage()." bytes \n";
	echo 'End creating array. Starting writing to cells...'.PHP_EOL;













	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("PricingLogix");
	$objPHPExcel->getProperties()->setTitle("PricingLogix");
	$objPHPExcel->getProperties()->setSubject("PricingLogix" . ' ' . date('H:i:s'));
	$objPHPExcel->getProperties()->setDescription("generated for Polaris by PricingLogix");

	// Шрифт по умолчанию
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Verdana')->setSize(8);

	$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Color_%');
	$objPHPExcel->addSheet($myWorkSheet, 0);
	$objPHPExcel->setActiveSheetIndex(0);
	// Убираем сетку
	$objPHPExcel->getActiveSheet()->setShowGridlines(false);
	$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(9);
	$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(27);
	$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(15.8);
	$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(15.8);
	$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(15.8);
	$objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(15.8);
	$objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(15.8);
	$objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Таблица цветов %отклонений:');
	$objPHPExcel->getActiveSheet()->SetCellValue('B4', '№:');
		$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'КодЦвета');
		$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'ОтклНиз');
		$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'ОтклВерх');
	$objPHPExcel->getActiveSheet()->SetCellValue('B5', '1');
		$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'White');
		$objPHPExcel->getActiveSheet()->SetCellValue('D5', '-0.03');
		//$objPHPExcel->getActiveSheet()->SetCellValue('E5', '');
	$objPHPExcel->getActiveSheet()->SetCellValue('B6', '2');
		$objPHPExcel->getActiveSheet()->SetCellValue('C6', 'Yellow');
		$objPHPExcel->getActiveSheet()->SetCellValue('D6', '-0.1');
		$objPHPExcel->getActiveSheet()->SetCellValue('E6', '-0.03');
	$objPHPExcel->getActiveSheet()->SetCellValue('B7', '3');
		$objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Red');
		//$objPHPExcel->getActiveSheet()->SetCellValue('D7', '');
		$objPHPExcel->getActiveSheet()->SetCellValue('E7', '-0.1');
		$objPHPExcel->getActiveSheet()->getStyle("B6:E6")->applyFromArray(array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'FFFF00'))));
		$objPHPExcel->getActiveSheet()->getStyle("B7:E7")->applyFromArray(array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'FF0000'))));
		$objPHPExcel->getActiveSheet()->getStyle("B4:E7")->applyFromArray(array('borders' => array(
			'allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
			'alignment' => array(
			                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			                'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER
			            ))));
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(1);  		// Ширина color% таблицы
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(9);  		// Ширина color% таблицы
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(9);  		// Ширина color% таблицы
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(9);  		// Ширина color% таблицы
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(9);  		// Ширина color% таблицы
		$objPHPExcel->getActiveSheet()->getStyle("B3:E4")->getFont()->setBold(true);
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('Logo');
		$objDrawing->setDescription('Logo');
		$logo = AC_DIR.'/settings/logo.png'; // Provide path to your logo file
		$objDrawing->setPath($logo);
		$objDrawing->setOffsetX(7);    // setOffsetX works properly
		$objDrawing->setOffsetY(300);  //setOffsetY has no effect
		$objDrawing->setCoordinates('B1');
		$objDrawing->setHeight(35); // logo height
		$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());




	// Переходим в другую книгу
	$objPHPExcel->setActiveSheetIndex(1);
	// Убираем сетку
	$objPHPExcel->getActiveSheet()->setShowGridlines(false);



	// Высота ячеек по умолчанию
	$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(10.3);
	// Имя книги
	$objPHPExcel->getActiveSheet()->setTitle('Result_City->Shop_'.$cur_date_sheet.'_0');
	// Ширины столбцов 
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(1.3);  	// Отступ
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15); 		// Артикул
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50); 		// Номенклатура
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);  		// Требуемая РИЦ
	// Высоты столбцов
	$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(10.5);  // Отсуп сверху
	$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(39.8);  // МАГАЗИН / ГОРОД
	$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(72.8);  // Шапка
	$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(5.3); 	 // Отступ снизу от шапки
	// Установим масштаб листа 90%
	$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(90);
	// Все ячейки сделаем белыми
	//$objPHPExcel->getDefaultStyle()->applyFromArray(array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('argb' => 'FFFFFFFF'))));
	// Разделители областей
	$objPHPExcel->getActiveSheet()->freezePane('E5');
	// Вставим ЛОГОТИП
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Logo');
	$objDrawing->setDescription('Logo');
	$logo = AC_DIR.'/settings/logo.png'; // Provide path to your logo file
	$objDrawing->setPath($logo);
	$objDrawing->setOffsetX(7);    // setOffsetX works properly
	$objDrawing->setOffsetY(300);  //setOffsetY has no effect
	$objDrawing->setCoordinates('B1');
	$objDrawing->setHeight(35); // logo height
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	// Вставим клиентские позиции и шапку:
	$objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Артикул');
	$objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Номенклатура');
	$objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Требуемая '.PHP_EOL.'РИЦ');
	$objPHPExcel->getActiveSheet()->getStyle("B2:XFD3")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray(array( 'font'  		=> array('color' => array('rgb' => 'FF0000')),
																																				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
																																														 'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_BOTTOM)));
	$objPHPExcel->getActiveSheet()->getStyle('E2:XFD3')->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
																																														 'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_BOTTOM)));
	$objPHPExcel->getActiveSheet()->getStyle('E2:XFD2')->applyFromArray(array( 'font' => array('size'  => 11)));
	$objPHPExcel->getActiveSheet()->getStyle('E3:XFD3')->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setTextRotation(90);
	$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
	// Позиции:
	$currpos = 5; // Строка, с которой начинаеются товарные позиции
	foreach ($priceArray as $names => $pos_code_price) {
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$currpos, $pos_code_price[1]); // Артикул
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$currpos, $names); // Номенклатура
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$currpos, $pos_code_price[2]); // РИЦ
		$styleArray = array('font'  		=> array('color' => array('rgb' => 'FF0000'),),
									    	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_BOTTOM));
		$objPHPExcel->getActiveSheet()->getStyle('D'.$currpos)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("B3:D3")->applyFromArray(
    array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
          ))));
		$currpos++;
	}






/**
 * Парсим массив с ориентацией City->_Shop
 */



	$iRow = 4; // cell "E"
	$iColour = 1;
	foreach ($CITY_ORDER as $store_temp => $city_temp) {
		// Записываем название МАГАЗИНА
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iRow, 2, $store_temp);
		$store_start = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, 2)->getCoordinate();
		$objPHPExcel->getActiveSheet()->getStyle($store_start)->applyFromArray(array(
				'alignment' => array(
			                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			                'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			            )
			));
		$objPHPExcel->getActiveSheet()->getStyle($store_start)->getAlignment()->setWrapText(true);
		$store_row = $iRow;
		foreach ($city_temp as $key => $cont) {
			if ($cont) {
				// Шапочка
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iRow, 3, $key);
				$objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, 3)->getCoordinate())->getAlignment()->setTextRotation(90);
				if ($iColour%2 == 0) {
					$objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, 2)->getCoordinate().':'.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, 3)->getCoordinate())->applyFromArray(
					array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '808080')),
								'font' => array('color' => array('rgb' => 'FFFFFF'))
								));
				} else {
					$objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, 2)->getCoordinate().':'.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, 3)->getCoordinate())->applyFromArray(
					array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'D9D9D9')),
								//'font' => array('color' => array('rgb' => 'FFFFFF'))
								));
				}
				
				foreach ($cont as $value) {
					if ($value) {
						//echo $store_temp.PHP_EOL;
						//echo $key.PHP_EOL;
						//print_r($value);
						// Отклонение и цвета ячеек
						$divergency = (int)$value[5]/(int)$value[4];
						if ($divergency <= 0.9) {
							$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FF0000'));
						} elseif (($divergency > 0.9 && $divergency <= 0.97)) {
							$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FFFF00'));
						} else {
							$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FFFFFF'));
						}

						$colorCell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, $value[0]+4);
						$styleArray = array(
									'fill' => $color,
			 						'borders' => array(
							        				'allborders' => array(
							            		'style' => PHPExcel_Style_Border::BORDER_NONE,
							            		//'style' => PHPExcel_Style_Border::BORDER_THICK,
							            		//'color' => array('rgb' => 'AAAAAA'
							            		)),
				          'font' => array(
										          //'italic' => TRUE,
										          //'color'  => array('rgb' => 'FFCC00'),
										          'size'  => 8,
								        			'name'  => 'Verdana'),
									'alignment' => array(
			                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			                'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			            ));
			      $objPHPExcel->getActiveSheet()->getStyle($colorCell->getCoordinate())->applyFromArray($styleArray);
			      //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iRow, $value[0]+4, '=HYPERLINK("'.$value[2].'",'.$value[5].')');
						$objPHPExcel->getActiveSheet()->setCellValue($colorCell->getCoordinate(), '=HYPERLINK("'.$value[2].'",'.$value[5].')');
					}
				}
				$objPHPExcel->getActiveSheet()->getColumnDimension(preg_replace('/\d/','',$colorCell->getCoordinate()))->setWidth(7);
				$iRow++;
			}
		}
		// Объядиняем ячейки в шапке
		if ($iRow - $store_row > 1) {
			$objPHPExcel->getActiveSheet()->mergeCells($store_start.':'.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow-1, 2)->getCoordinate());
		}
		//$objPHPExcel->getActiveSheet()->mergeCells($store_start.':'.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow-1, 2)->getCoordinate());
		/*
		echo $store_row.PHP_EOL;
		echo $iRow.PHP_EOL;
		echo $store_temp.PHP_EOL;
		echo $store_start.PHP_EOL;
		echo $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow-1, 2)->getCoordinate().PHP_EOL;
		*/
		$iColour++; // Чередующийся цвет ячеек в шапке
	}
	// Цвет границ шапки
	$objPHPExcel->getActiveSheet()->getStyle('E2:'.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow-1, 3)->getCoordinate())->applyFromArray(
    array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
          )
        )
    	)
		);


echo "BEFORE SITI_ORDER UNSET: ".memory_get_usage()." bytes \n";
	$CITY_ORDER = array();
	unset($CITY_ORDER);
echo "AFTER SITI_ORDER UNSET: ".memory_get_usage()." bytes \n";

/**
 * ОРИЕНТАЦИЯ МАГАЗИНЫ
 */
	$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Result_Shop->City_'.$cur_date_sheet.'_0');
	$objPHPExcel->addSheet($myWorkSheet, 2);
	$objPHPExcel->setActiveSheetIndex(2);
	// Убираем сетку
	$objPHPExcel->getActiveSheet()->setShowGridlines(false);
	// Высота ячеек по умолчанию
	$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(10.3);
	// Имя книги
	//$objPHPExcel->getActiveSheet()->setTitle('Result_City->_Shop'.$cur_date_sheet.'_0');
	// Ширины столбцов 
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(1.3);  	// Отступ
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15); 		// Артикул
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50); 		// Номенклатура
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);  		// Требуемая РИЦ
	// Высоты столбцов
	$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(10.5);  // Отсуп сверху
	$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(39.8);  // МАГАЗИН / ГОРОД
	$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(72.8);  // Шапка
	$objPHPExcel->getActiveSheet()->getRowDimension(4)->setRowHeight(5.3); 	 // Отступ снизу от шапки
	// Установим масштаб листа 90%
	$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(90);
	// Все ячейки сделаем белыми
	// $objPHPExcel->getDefaultStyle()->applyFromArray(array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('argb' => 'FFFFFFFF'))));
	// Разделители областей
	$objPHPExcel->getActiveSheet()->freezePane('E5');
	// Вставим ЛОГОТИП
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Logo');
	$objDrawing->setDescription('Logo');
	$logo = AC_DIR.'/settings/logo.png'; // Provide path to your logo file
	$objDrawing->setPath($logo);
	$objDrawing->setOffsetX(7);    // setOffsetX works properly
	$objDrawing->setOffsetY(300);  //setOffsetY has no effect
	$objDrawing->setCoordinates('B1');
	$objDrawing->setHeight(35); // logo height
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
	// Вставим клиентские позиции и шапку:
	$objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Артикул');
	$objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Номенклатура');
	$objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Требуемая '.PHP_EOL.'РИЦ');
	$objPHPExcel->getActiveSheet()->getStyle("B2:XFD3")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray(array( 'font'  		=> array('color' => array('rgb' => 'FF0000')),
																																				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
																																														 'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_BOTTOM)));
	$objPHPExcel->getActiveSheet()->getStyle('E2:XFD3')->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
																																														 'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_BOTTOM)));
	$objPHPExcel->getActiveSheet()->getStyle('E2:XFD2')->applyFromArray(array( 'font' => array('size'  => 11)));
	$objPHPExcel->getActiveSheet()->getStyle('E3:XFD3')->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setTextRotation(90);
	$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setWrapText(true);
	// Позиции:
	$currpos = 5; // Строка, с которой начинаеются товарные позиции
	foreach ($priceArray as $names => $pos_code_price) {
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$currpos, $pos_code_price[1]); // Артикул
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$currpos, $names); // Номенклатура
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$currpos, $pos_code_price[2]); // РИЦ
		$styleArray = array('font'  		=> array('color' => array('rgb' => 'FF0000'),),
									    	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_BOTTOM));
		$objPHPExcel->getActiveSheet()->getStyle('D'.$currpos)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("B3:D3")->applyFromArray(
    array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
          )
        )
    	)
		);
		$currpos++;
	}






/**
 * Парсим массив с ориентацией МАГАЗИНЫ
 */



	$iRow = 4; // cell "E"
	$iColour = 1;
	foreach ($STORE_ORDER as $store_temp => $city_temp) {
		// Записываем название МАГАЗИНА
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iRow, 2, $store_temp);
		$store_start = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, 2)->getCoordinate();
		$objPHPExcel->getActiveSheet()->getStyle($store_start)->applyFromArray(array(
				'alignment' => array(
			                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			                'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			            )
			));
		$objPHPExcel->getActiveSheet()->getStyle($store_start)->getAlignment()->setWrapText(true);
		$store_row = $iRow;
		foreach ($city_temp as $key => $cont) {
			if ($cont) {
				// Шапочка
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iRow, 3, $key);
				$objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, 3)->getCoordinate())->getAlignment()->setTextRotation(90);
				if ($iColour%2 == 0) {
					$objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, 2)->getCoordinate().':'.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, 3)->getCoordinate())->applyFromArray(
					array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => '808080')),
								'font' => array('color' => array('rgb' => 'FFFFFF'))
								));
				} else {
					$objPHPExcel->getActiveSheet()->getStyle($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, 2)->getCoordinate().':'.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, 3)->getCoordinate())->applyFromArray(
					array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'D9D9D9')),
								//'font' => array('color' => array('rgb' => 'FFFFFF'))
								));
				}
				
				foreach ($cont as $value) {
					if ($value) {
						//echo $store_temp.PHP_EOL;
						//echo $key.PHP_EOL;
						//print_r($value);
						// Отклонение и цвета ячеек
						$divergency = (int)$value[5]/(int)$value[4];
						if ($divergency <= 0.9) {
							$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FF0000'));
						} elseif (($divergency > 0.9 && $divergency <= 0.97)) {
							$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FFFF00'));
						} else {
							$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FFFFFF'));
						}

						$colorCell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, $value[0]+4);
						$styleArray = array(
									'fill' => $color,
			 						'borders' => array(
							        				'allborders' => array(
							            		'style' => PHPExcel_Style_Border::BORDER_NONE,
							            		//'style' => PHPExcel_Style_Border::BORDER_THICK,
							            		//'color' => array('rgb' => 'AAAAAA'
							            		)),
				          'font' => array(
										          //'italic' => TRUE,
										          //'color'  => array('rgb' => 'FFCC00'),
										          'size'  => 8,
								        			'name'  => 'Verdana'),
									'alignment' => array(
			                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			                'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			            ));
			      $objPHPExcel->getActiveSheet()->getStyle($colorCell->getCoordinate())->applyFromArray($styleArray);
			      //$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iRow, $value[0]+4, '=HYPERLINK("'.$value[2].'",'.$value[5].')');
						$objPHPExcel->getActiveSheet()->setCellValue($colorCell->getCoordinate(), '=HYPERLINK("'.$value[2].'",'.$value[5].')');
					}
				}
				$objPHPExcel->getActiveSheet()->getColumnDimension(preg_replace('/\d/','',$colorCell->getCoordinate()))->setWidth(7);
				$iRow++;
			}
		}
		// Объядиняем ячейки в шапке
		if ($iRow - $store_row > 1) {
			$objPHPExcel->getActiveSheet()->mergeCells($store_start.':'.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow-1, 2)->getCoordinate());
		}
		//$objPHPExcel->getActiveSheet()->mergeCells($store_start.':'.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow-1, 2)->getCoordinate());
		/*
		echo $store_row.PHP_EOL;
		echo $iRow.PHP_EOL;
		echo $store_temp.PHP_EOL;
		echo $store_start.PHP_EOL;
		echo $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow-1, 2)->getCoordinate().PHP_EOL;
		*/
		$iColour++; // Чередующийся цвет ячеек в шапке
	}
	// Цвет границ шапки
	$objPHPExcel->getActiveSheet()->getStyle('E2:'.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow-1, 3)->getCoordinate())->applyFromArray(
    array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
          )
        )
    	)
		);
















	echo round((microtime(1)-$start).PHP_EOL. 2).PHP_EOL;
	echo 'Starting report writing...'.PHP_EOL;


	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->setPreCalculateFormulas(true);
	if (!file_exists('/var/www/reporter/reports/'.date('d.m.y'))) {
		mkdir('/var/www/reporter/reports/'.date('d.m.y'));
	}
	$objWriter->save('/var/www/reporter/reports/'.date('d.m.y').'/'.$fileName.'.xlsx');
	echo "Final: ".memory_get_usage()." bytes \n";
	echo "Peak: ".memory_get_peak_usage()." bytes \n";

	echo round((microtime(1)-$start), 2).PHP_EOL;
