<?php 
/**
 * vitek 0
 */
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
	$pathes = glob('/var/www/'.ENGINE_TYPE.'/engines/*/data/'.$cur_date.'*'.ENGINE_TYPE.'*.data');

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

/**
 * Перебираем массив городов, которые необходимо дополнить (книга 6 в settings)
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
	echo 'End creating array. Starting writing to cells...'.PHP_EOL;
	echo 'City->_Shop'.PHP_EOL;










	// Номер (индекс) отчёта
	switch (date('H')) {
		case '8': $sheet_name_index = '1';
			break;
		case '12': $sheet_name_index = '2';
			break;
		default:
			$sheet_name_index = '1';
			break;
	}

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("PricingLogix");
	$objPHPExcel->getProperties()->setTitle("PricingLogix");
	$objPHPExcel->getProperties()->setSubject("PricingLogix" . ' ' . date('H:i:s'));
	$objPHPExcel->getProperties()->setDescription("generated for ".ENGINE_TYPE." by PricingLogix");
	// Добавление листа с цветом
	$objPHPExcel->addExternalSheet($sheet_with_color, 0);

	// Убираем сетку
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setShowGridlines(false);

	$objPHPExcel->setActiveSheetIndex(1);
	// Шрифт по умолчанию
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Verdana')->setSize(8);


	// Высота ячеек по умолчанию
	$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(10.3);
	// Имя книги
	$objPHPExcel->getActiveSheet()->setTitle('Result_City->_Shop_'.$cur_date_sheet.'_'.$sheet_name_index);
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
	$objPHPExcel->getDefaultStyle()->applyFromArray(array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('argb' => 'FFFFFFFF'))));
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
 * Парсим массив с ориентацией City->_Shop
 */

	$iRow = 4; // cell "E"
	$iColour = 1;
	$q_of_stores = count($CITY_ORDER);
	$istatus = 1;
	foreach ($CITY_ORDER as $store_temp => $city_temp) {
		system('clear');
		echo '[';
		for ($is=1; $is < $istatus; $is++) { 
			echo '■';	
		}
		for ($is=$istatus; $is <= $q_of_stores; $is++) { 
			echo '.';	
		}
		echo ']'.PHP_EOL;
		$istatus++;

		echo ' '.$store_temp.PHP_EOL;
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
				echo ' '.$key.PHP_EOL;
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
					print_r($value);die();
					if ($value) {
						//echo '■';
						//echo $store_temp.PHP_EOL;
						//echo $key.PHP_EOL;
						//print_r($value);
						// Отклонение и цвета ячеек
						// Какие данные нам нужны и в каких переменных они хранятся:
						// артикул				$value[1]
						// имя товара			$value[3]
						// РИЦ 						$value[4]
						// Город 					$key
						// Сайт 					$city_temp
						// Цена на сайте	$value[5]
						// Ссылка на цену $value[2]

						$divergency = (int)$value[5]/(int)$value[4];
						if ($divergency <= 0.9) {
							$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FF0000')); // RED
							
						} elseif (($divergency > 0.9 && $divergency <= 0.97)) {
							$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FFFF00')); // YELLOW
							
						} else {
							$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FFFFFF')); // WHITE
							
						}

						

						$colorCell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, $value[0]+4)->getCoordinate();
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
						
						$objPHPExcel->getActiveSheet()->getStyle($colorCell)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->setCellValue($colorCell, '=HYPERLINK("'.$value[2].'", '.$value[5].')');
					}
				}



				$objPHPExcel->getActiveSheet()->getColumnDimension(preg_replace('/\d/','', $colorCell))->setWidth(7);
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

/**
 * ОРИЕНТАЦИЯ МАГАЗИНЫ
 */
	$myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Result_Shop->City_'.$cur_date_sheet.'_'.$sheet_name_index);
	$objPHPExcel->addSheet($myWorkSheet, 2);
	$objPHPExcel->setActiveSheetIndex(2);
	// Высота ячеек по умолчанию
	$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(10.3);
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
	$objPHPExcel->getDefaultStyle()->applyFromArray(array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('argb' => 'FFFFFFFF'))));
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
	$array_SKU = array(); // Для отчёта SKU

	$iRow = 4; // cell "E"
	$iColour = 1;
	$q_of_stores = count($STORE_ORDER);
	$istatus = 1;
	foreach ($STORE_ORDER as $store_temp => $city_temp) {
		system('clear');
		echo '[';
		for ($is=1; $is < $istatus; $is++) { 
			echo '■';	
		}
		for ($is=$istatus; $is <= $q_of_stores; $is++) { 
			echo '.';	
		}
		echo ']'.PHP_EOL;
		$istatus++;

		echo ' '.$store_temp.PHP_EOL;

		$isAtLeastOne = 0; // Потом проверим был ли хоть один магазин, чтобы знать как разукрашивать шапку (должно быть поочерёдно белый / серый)
		// Записываем название МАГАЗИНА
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($iRow, 2, $store_temp);
		$store_start = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, 2)->getCoordinate();
		$objPHPExcel->getActiveSheet()->getStyle($store_start)->applyFromArray(array(
				'alignment' => array(
			                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			                'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			            )
			));
		$objPHPExcel->getActiveSheet()->getStyle($store_start)->getAlignment()->setWrapText(true);
		$store_row = $iRow;
		foreach ($city_temp as $key => $cont) { // Перебираем Города внутри магазина
			$q_red = 0;			// К-во красных цен
			$q_yellow = 0;	// К-во жёлтых цен
			$q_white = 0;		// К-во белых цен

			if ($cont) {
				$isAtLeastOne = 1;
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
				
				$price_q_for_SKU = 0; // К-во цен всего внутри Магазин -> Конкретный регион
				foreach ($cont as $value) { // Перебираем позиции внутри магазина
					if ($value) {
						//echo $store_temp.PHP_EOL; // Магазин
						//echo $key.PHP_EOL; 				// 
						//print_r($value); 					//
						// Отклонение и цвета ячеек
						$divergency = (int)$value[5]/(int)$value[4];
						if ($divergency <= 0.9) {
							$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FF0000'));
							$q_red++;
							$array_SKU[$store_temp]['div'][] = 1-((int)$value[5]/(int)$value[4]);
						} elseif (($divergency > 0.9 && $divergency <= 0.97)) {
							$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FFFF00'));
							$q_yellow++;
							$array_SKU[$store_temp]['div'][] = 1-((int)$value[5]/(int)$value[4]);
						} else {
							$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FFFFFF'));
							if ((int)$value[5]>0) {
								$q_white++;
								//$array_SKU[$store_temp]['div'][] = 0;
							}
						}

						$price_q_for_SKU++;

						$colorCell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, $value[0]+4)->getCoordinate();
						$styleArray = array('fill' => $color, 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_NONE, )),'font' => array('size'  => 8, 'name'  => 'Verdana'), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER));
			     
			      $objPHPExcel->getActiveSheet()->getStyle($colorCell)->applyFromArray($styleArray);
						$objPHPExcel->getActiveSheet()->setCellValue($colorCell, '=HYPERLINK("'.$value[2].'", '.$value[5].')');
					}
				} // END // К-во цен всего внутри Магазин -> Конкретный регион

				// Если в рамках этого магазина в обработанном городе было больше цен, то увеличим
				if ($price_q_for_SKU > $array_SKU[$store_temp]['q_of_price']) {
					$array_SKU[$store_temp]['q_of_price'] = $price_q_for_SKU;
				}

				// тут записывать цветные цены:
				if ($q_red 		> $array_SKU[$store_temp]['red']) 		$array_SKU[$store_temp]['red'] 		= $q_red;
				if ($q_yellow > $array_SKU[$store_temp]['yellow']) 	$array_SKU[$store_temp]['yellow'] = $q_yellow;
				if ($q_white	> $array_SKU[$store_temp]['white']) 	$array_SKU[$store_temp]['white'] 	= $q_white;

				$objPHPExcel->getActiveSheet()->getColumnDimension(preg_replace('/\d/','', $colorCell))->setWidth(7);
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
		if ($isAtLeastOne) {
			$iColour++; // Чередующийся цвет ячеек в шапке
		}
	}
	// Цвет границ шапки
	$objPHPExcel->getActiveSheet()->getStyle('E2:'.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow-1, 3)->getCoordinate())->applyFromArray(
    array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')))));


	//print_r($array_SKU); // Массив SKU
 



	// Файл с отчётом по SKU
	$objSKU = PHPExcel_IOFactory::load('/var/www/reporter/reports/Report_SKU_vitek_RU_small.xlsx');
	if (1 == 2) {
		$objSKU->getActiveSheet()->insertNewRowBefore(6, 8);
		$objSKU->getActiveSheet()->getRowDimension(6)->setRowHeight(17.3);
		$objSKU->getActiveSheet()->getRowDimension(7)->setRowHeight(17.3);
		$objSKU->getActiveSheet()->getRowDimension(8)->setRowHeight(17.3);
		$objSKU->getActiveSheet()->getRowDimension(9)->setRowHeight(17.3);
		$objSKU->getActiveSheet()->getRowDimension(10)->setRowHeight(17.3);
		$objSKU->getActiveSheet()->getRowDimension(11)->setRowHeight(17.3);
		$objSKU->getActiveSheet()->getRowDimension(12)->setRowHeight(17.3);
		$objSKU->getActiveSheet()->getRowDimension(13)->setRowHeight(17.3);
	}

	$objSKU->getActiveSheet()->SetCellValue('B6', $cur_date.'_0');
	$objSKU->getActiveSheet()->mergeCells('B6:B12');
	$objSKU->getActiveSheet()->freezePane('C13');

/**
 * Стилизация
 */
/*
	$objSKU->getActiveSheet()->getStyle('B6:B12')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')))));
	$objSKU->getActiveSheet()->getStyle('C6:C12')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')))));
	$objSKU->getActiveSheet()->getStyle('D6:D12')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')))));
	$objSKU->getActiveSheet()->getStyle('E6:E12')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')))));
	$objSKU->getActiveSheet()->getStyle('F6:F12')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')))));
*/
	$objSKU->getActiveSheet()->getStyle('B6:F12')->applyFromArray(
		array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
					'font' => array('size'  => 8, 'name'  => 'Verdana', 'color' => array('rgb' => '000000')), 
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
				  'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER))));
	//$objSKU->getActiveSheet()->getStyle('E6:E12')->applyFromArray(array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_NONE)),'fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'D9D9D9'))));
	//$objSKU->getActiveSheet()->getStyle('D6:F12')->getAlignment()->setTextRotation(90);
	//$objSKU->getActiveSheet()->getStyle("B6:C12")->getFont()->setBold(true);
/**
 * END Стилизация
 * sudo php app.php vitek_night vitek_night vitek Report_vitek_RU_$(date +\%d\%m\%y)_0
 */

	foreach ($array_SKU as $param_SKU => $value_SKU) { // Перебор массива SKU
		switch ($param_SKU) {
			case 'dns-shop.ru':
				$objSKU->getActiveSheet()->SetCellValue('D6', $value_SKU['q_of_price']);
				$objSKU->getActiveSheet()->SetCellValue('D7', $value_SKU['red']);
				$objSKU->getActiveSheet()->SetCellValue('D8', $value_SKU['yellow']);
				$objSKU->getActiveSheet()->SetCellValue('D9', $value_SKU['white']);
				$objSKU->getActiveSheet()->SetCellValue('D10', $value_SKU['red']/($value_SKU['yellow']+$value_SKU['white']+$value_SKU['red']));
				$objSKU->getActiveSheet()->SetCellValue('D11', array_sum($value_SKU['div'])/count($value_SKU['div']));
				break;
			case 'technopoint.ru':
				$objSKU->getActiveSheet()->SetCellValue('E6', $value_SKU['q_of_price']);
				$objSKU->getActiveSheet()->SetCellValue('E7', $value_SKU['red']);
				$objSKU->getActiveSheet()->SetCellValue('E8', $value_SKU['yellow']);
				$objSKU->getActiveSheet()->SetCellValue('E9', $value_SKU['white']);
				$objSKU->getActiveSheet()->SetCellValue('E10', $value_SKU['red']/($value_SKU['yellow']+$value_SKU['white']+$value_SKU['red']));
				$objSKU->getActiveSheet()->SetCellValue('E11', array_sum($value_SKU['div'])/count($value_SKU['div']));
				break;
			case 'frau-technica.ru':
				$objSKU->getActiveSheet()->SetCellValue('F6', $value_SKU['q_of_price']);
				$objSKU->getActiveSheet()->SetCellValue('F7', $value_SKU['red']);
				$objSKU->getActiveSheet()->SetCellValue('F8', $value_SKU['yellow']);
				$objSKU->getActiveSheet()->SetCellValue('F9', $value_SKU['white']);
				$objSKU->getActiveSheet()->SetCellValue('F10', $value_SKU['red']/($value_SKU['yellow']+$value_SKU['white']+$value_SKU['red']));
				$objSKU->getActiveSheet()->SetCellValue('F11', array_sum($value_SKU['div'])/count($value_SKU['div']));
				break;
			default:
				# code...
				break;
		}
		
	}

	//$objWriter = PHPExcel_IOFactory::createWriter($objSKU, 'Excel2007');
	//$objWriter->save('/var/www/reporter/reports/Report_SKU_'.ucfirst(ENGINE_TYPE).'_RU_'.date('d.m.y').'_'.$sheet_name_index); 

	//echo copy(
	//	'/var/www/reporter/reports/Report_SKU_vitek_RU_'.date('d.m.y').'_small.xlsx',
	//	'/var/www/reporter/reports/Report_SKU_vitek_RU_small.xlsx');



	system('clear');
	echo round((microtime(1)-$start).PHP_EOL. 2).PHP_EOL;
	echo 'Starting report writing...'.PHP_EOL;


	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	//$objWriter->setPreCalculateFormulas(true);
	if (!file_exists('/var/www/reporter/reports/'.date('d.m.y'))) {
		mkdir('/var/www/reporter/reports/'.date('d.m.y'));
	}
	$objWriter->save('/var/www/reporter/reports/'.date('d.m.y').'/'.$fileName.'.xlsx');
	echo "Final: ".memory_get_usage()." bytes \n";
	echo "Peak: ".memory_get_peak_usage()." bytes \n";

	echo round((microtime(1)-$start), 2).PHP_EOL;
