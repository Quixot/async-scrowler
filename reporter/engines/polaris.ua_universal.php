<?php 
/**
 * POLARIS
 */
	$core_assort = array(
		);

	$sheet_name_index = substr($fileName, strripos($fileName, '_')+1);

	$objPHPExcel = PHPExcel_IOFactory::load($dataFfile);

/**
 * Нечёткий поиск URL NAME CODE
 */
	$sheet = $objPHPExcel->getSheet(4);
	//$qountity = $sheet->getCell( 'D1' )->getOldCalculatedValue(); // Хак для формул
	$qountity = $sheet->getHighestRow(); // Сколько строк
	echo 'Нечёткий поиск: '.$qountity.PHP_EOL;
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
	//$qountity = $sheet->getCell( 'C1' )->getOldCalculatedValue(); // Хак для формул
	$qountity = $sheet->getHighestRow(); // Сколько строк
	echo 'Алиасы городов: '.$qountity.PHP_EOL;
	$data = $sheet->rangeToArray('A2:B'.$qountity);
	foreach ($data as $row) {
	  $keyALIAS[$row[1]]  = $row[0]; // ALIAS SITY_RU
	}
	echo 'Алиасы городов: '.count($data).PHP_EOL;
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
	  $priceArray[$row[1].'_'.$row[4]] = array($row[0], $row[1], $row[5], $row[2], $row[3], $row[6], $row[7]); // REALNAME POSITION CODE REALRICE Тип Наименование товара
	  //$priceArray[$row[2]] = array($row[0], $row[1], $row[3]); // REALNAME POSITION CODE REALRICE
	}

/**
	* $row[0] = [A] №
	* $row[1] = [B] Артикул
	* $row[2] = [C] Тип
	* $row[3] = [D] Наименование товара
	* $row[4] = [E] Модель
	* $row[5] = [F] РИЦ
	* $row[6] = [G] Серый цвет да / нет
	* $row[7] = [H] Примечание
	*/
	echo 'Имя и РИЦ: '.count($data).PHP_EOL;
	//print_r($priceArray);
	
	
/**
 * Вид: МАГАЗИНЫ
 */
	$sheet = $objPHPExcel->getSheet(3);
	//$qountity = $sheet->getCell( 'C1' )->getOldCalculatedValue();
	$qountity = $sheet->getHighestRow(); // Сколько строк
	echo 'К-во строк Вид: МАГАЗИНЫ: '.$qountity.PHP_EOL;
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
	//$qountity = $sheet->getCell( 'C1' )->getOldCalculatedValue();
	$qountity = $sheet->getHighestRow(); // Сколько строк
	echo 'К-во строк Вид: ГОРОДАМИ: '.$qountity.PHP_EOL;
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
	$qountity = $sheet->getHighestRow(); // Сколько строк
	echo 'База замещения одного города другим: '.$qountity.PHP_EOL;	
	$data = $sheet->rangeToArray('A2:C'.$qountity);
	foreach ($data as $row) {
	  $CHANGE_CITY[$row[0]][$row[1]] = $row[2]; // ALIAS SITY_RU
	}

	echo round((microtime(1)-$start), 2).PHP_EOL;
	echo 'Starting main LOOP...'.PHP_EOL;



/**
 * Будем открывать файл за файлом и...
 */
	$pathes = glob('/var/www/'.ENGINE_TYPE.'.ua/engines/*/data/'.$cur_date.'*'.ENGINE_TYPE.'*.data');

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

		preg_match("~engines/(.+)/.*".ENGINE_TYPE.".ua_(.+).data~isU", $keypath, $matches);
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
					echo '*******'.PHP_EOL;
					echo $URL.PHP_EOL;				// url
					echo $CODE.PHP_EOL;				// client CODE
					echo $REALNAME.PHP_EOL;		// client NAME
					echo $REALPRICE.PHP_EOL;	// client PRICE
					echo $PRICE.PHP_EOL;			// Store 	PRICE
					echo $CITY.PHP_EOL;				// Current City
					echo $CITY_RU.PHP_EOL;		// RU city name
					echo $STORE.PHP_EOL;			// Current Store
					echo '*******'.PHP_EOL;	
					//die();
					*/

					/**
					 * Массив для отчёта ПО МАГАЗИНАМ и 
					 * Массив для отчёта ПО ГОРОДАМ
					 */
					//echo $V_POSITION.PHP_EOL.$CODE.PHP_EOL. $URL.PHP_EOL. $REALNAME.PHP_EOL. $REALPRICE.PHP_EOL. $PRICE.PHP_EOL;
					if ($URL && $CODE && $REALNAME && /*$REALPRICE &&*/ $PRICE && isset($STORE_ORDER[$STORE][$CITY_RU])) {
						/**
						 * TODO:
						 * Дописать обработку ситуации, когда файлик есть, а предустановленного региона или магазина в массиве нет
						 */
						$STORE_ORDER[$STORE][$CITY_RU][] = array($V_POSITION, $CODE, $URL, $REALNAME, $REALPRICE, $PRICE, $content[6], $CODE);
						$CITY_ORDER[$CITY_RU][$STORE][]  = array($V_POSITION, $CODE, $URL, $REALNAME, $REALPRICE, $PRICE, $content[6], $CODE);
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
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(0.5);  	// Отступ
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(3.33);  		// №
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8); 		// Артикул
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(27); 		// Тип
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(43);  	// Наименование товара
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);  	// Модель
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(6);  		// РИЦ
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
	$objPHPExcel->getActiveSheet()->freezePane('H5');
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
	$objPHPExcel->getActiveSheet()->SetCellValue('B3', '№');
	$objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Артикул');
	$objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Тип');
	$objPHPExcel->getActiveSheet()->SetCellValue('E3', 'Наименование товара');
	$objPHPExcel->getActiveSheet()->SetCellValue('F3', 'Модель');
	$objPHPExcel->getActiveSheet()->SetCellValue('G3', 'РИЦ');
	$objPHPExcel->getActiveSheet()->getStyle("B2:XFD3")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray(array( 'font'  		=> array('color' => array('rgb' => 'FF0000')),
																																				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
																																														 'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_BOTTOM)));
	$objPHPExcel->getActiveSheet()->getStyle('H2:XFD3')->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
																																														 'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_BOTTOM)));
	$objPHPExcel->getActiveSheet()->getStyle('E2:XFD2')->applyFromArray(array( 'font' => array('size'  => 11)));
	$objPHPExcel->getActiveSheet()->getStyle('E3:XFD3')->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setTextRotation(90);
	$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setWrapText(true);
	// Позиции:
	$currpos = 5; // Строка, с которой начинаеются товарные позиции
	foreach ($priceArray as $names => $pos_code_price) {
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$currpos, $pos_code_price[0]); // #
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$currpos, $pos_code_price[1]); // Артикул
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$currpos, $pos_code_price[3]); // Тип
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$currpos, $pos_code_price[4]); // Наименование товара

		$model = str_replace($pos_code_price[1].'_', '', $names);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$currpos, $model); // Модель


		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$currpos, $pos_code_price[2]); // РИЦ
		if ($pos_code_price[5]) {
			$objPHPExcel->getActiveSheet()->getStyle('B'.$currpos.':F'.$currpos)->applyFromArray(
					array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffc7ce'))));
		}
		if ($pos_code_price[6]) {
			$objPHPExcel->getActiveSheet()->getStyle('G'.$currpos)->applyFromArray(
					array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffc7ce'))));
			$objPHPExcel->getActiveSheet()->getComment('G'.$currpos)->setAuthor('PricingLogix');
			$objPHPExcel->getActiveSheet()->getComment('G'.$currpos)->getText()->createTextRun($pos_code_price[6]);
		}

		// Если core ассортимент, закрашиваем модель в #ffeb9c
		if (stripos($pos_code_price[6], 'Core assort') !== false && stripos($pos_code_price[6], 'ПРОМО') === false) {
			$objPHPExcel->getActiveSheet()->getStyle('F'.$currpos)->applyFromArray(
					array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffeb9c'))));
					//$objPHPExcel->getActiveSheet()->getComment('G'.$currpos)->setAuthor('PricingLogix');
					//$objPHPExcel->getActiveSheet()->getComment('G'.$currpos)->getText()->createTextRun('Core assort');			
			$objPHPExcel->getActiveSheet()->getStyle('B'.$currpos.':G'.$currpos)->applyFromArray(
					array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffeb9c'))));	
		}
		
		$styleArray = array('font'  		=> array('color' => array('rgb' => 'FF0000'),),
									    	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_BOTTOM));
		$objPHPExcel->getActiveSheet()->getStyle('G'.$currpos)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("B3:G3")->applyFromArray(
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

	$iRow = 7; // cell "E"
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
				
				// Блок ЦЕНЫ
				foreach ($cont as $value) {
					if ($value && $value[4] == 0) { // Если РИЦ == 0 то просто выводим цену, не закрашиваем
						$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FFFFFF')); // WHITE
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
						if (filter_var($value[2], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
							$objPHPExcel->getActiveSheet()->setCellValue($colorCell, '=HYPERLINK("'.$value[2].'", '.$value[5].')');
						}

					} elseif ($value && $value[4] > 0) {
						if ($value && $value[5]/$value[4] >= 0.4 && $value[5]/$value[4] <= 2.5) { // 
							//echo '■';
							//echo $store_temp.PHP_EOL;
							//echo $key.PHP_EOL;
							//print_r($value);
							// Отклонение и цвета ячеек
							$divergency = (int)$value[5]/(int)$value[4];
							if ($divergency <= 0.9) {
								$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FF0000')); // RED

								$red_price_array[$value[1]][] = array(// articul	
										$value[3], 		// name
										$value[4], 		// РИЦ
										$store_temp,	// City
										$key,					// Site
										$value[5],		// Цена на сайте
										$value[2]			// Ссылка
									);
								
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
							if (filter_var($value[2], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
								$objPHPExcel->getActiveSheet()->setCellValue($colorCell, '=HYPERLINK("'.$value[2].'", '.$value[5].')');
							}
						}
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
	$objPHPExcel->getActiveSheet()->getStyle('H2:'.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow-1, 3)->getCoordinate())->applyFromArray(
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
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(0.5);  	// Отступ
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(3.33);  		// №
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(8); 		// Артикул
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(27); 		// Тип
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(43);  	// Наименование товара
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);  	// Модель
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(6);  		// РИЦ
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
	$objPHPExcel->getActiveSheet()->freezePane('H5');
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
	$objPHPExcel->getActiveSheet()->SetCellValue('B3', '№');
	$objPHPExcel->getActiveSheet()->SetCellValue('C3', 'Артикул');
	$objPHPExcel->getActiveSheet()->SetCellValue('D3', 'Тип');
	$objPHPExcel->getActiveSheet()->SetCellValue('E3', 'Наименование товара');
	$objPHPExcel->getActiveSheet()->SetCellValue('F3', 'Модель');
	$objPHPExcel->getActiveSheet()->SetCellValue('G3', 'РИЦ');
	$objPHPExcel->getActiveSheet()->getStyle("B2:XFD3")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray(array( 'font'  		=> array('color' => array('rgb' => 'FF0000')),
																																				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
																																														 'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_BOTTOM)));
	$objPHPExcel->getActiveSheet()->getStyle('H2:XFD3')->applyFromArray(array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
																																														 'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_BOTTOM)));
	$objPHPExcel->getActiveSheet()->getStyle('E2:XFD2')->applyFromArray(array( 'font' => array('size'  => 11)));
	$objPHPExcel->getActiveSheet()->getStyle('E3:XFD3')->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setTextRotation(90);
	$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setWrapText(true);
	// Позиции:
	$currpos = 5; // Строка, с которой начинаеются товарные позиции
	foreach ($priceArray as $names => $pos_code_price) {
		$objPHPExcel->getActiveSheet()->SetCellValue('B'.$currpos, $pos_code_price[0]); // #
		$objPHPExcel->getActiveSheet()->SetCellValue('C'.$currpos, $pos_code_price[1]); // Артикул
		$objPHPExcel->getActiveSheet()->SetCellValue('D'.$currpos, $pos_code_price[3]); // Тип
		$objPHPExcel->getActiveSheet()->SetCellValue('E'.$currpos, $pos_code_price[4]); // Наименование товара
		$model = str_replace($pos_code_price[1].'_', '', $names);
		$objPHPExcel->getActiveSheet()->SetCellValue('F'.$currpos, $model); // Модель


		$objPHPExcel->getActiveSheet()->SetCellValue('G'.$currpos, $pos_code_price[2]); // РИЦ
		if ($pos_code_price[5]) {
			$objPHPExcel->getActiveSheet()->getStyle('B'.$currpos.':F'.$currpos)->applyFromArray(
					array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffc7ce'))));
		}
		if ($pos_code_price[6]) {
			$objPHPExcel->getActiveSheet()->getStyle('G'.$currpos)->applyFromArray(
					array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffc7ce'))));
			$objPHPExcel->getActiveSheet()->getComment('G'.$currpos)->setAuthor('PricingLogix');
			$objPHPExcel->getActiveSheet()->getComment('G'.$currpos)->getText()->createTextRun($pos_code_price[6]);
		}


		// Если core ассортимент, закрашиваем модель в #ffeb9c
		
		if (stripos($pos_code_price[6], 'Core assort') !== false && stripos($pos_code_price[6], 'ПРОМО') === false ) {
			$objPHPExcel->getActiveSheet()->getStyle('F'.$currpos)->applyFromArray(
					array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffeb9c'))));
					//$objPHPExcel->getActiveSheet()->getComment('G'.$currpos)->setAuthor('PricingLogix');
					//$objPHPExcel->getActiveSheet()->getComment('G'.$currpos)->getText()->createTextRun('Core assort');
			$objPHPExcel->getActiveSheet()->getStyle('B'.$currpos.':G'.$currpos)->applyFromArray(
					array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'ffeb9c'))));	
		}
		/**/
		$styleArray = array('font'  		=> array('color' => array('rgb' => 'FF0000'),),
									    	'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_BOTTOM));
		$objPHPExcel->getActiveSheet()->getStyle('G'.$currpos)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle("B3:G3")->applyFromArray(
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

	$iRow = 7; // cell "E"
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
				// Блок цены
				foreach ($cont as $value) { // Перебираем позиции внутри магазина
					if ($value && $value[4] == 0) { // Если РИЦ == 0, просто выводим цену в ячейку
						$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FFFFFF'));

						$price_q_for_SKU++;

						$colorCell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow, $value[0]+4)->getCoordinate();
						$styleArray = array('fill' => $color, 'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_NONE, )),'font' => array('size'  => 8, 'name'  => 'Verdana'), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' 	 => PHPExcel_Style_Alignment::VERTICAL_CENTER));
				     
				    $objPHPExcel->getActiveSheet()->getStyle($colorCell)->applyFromArray($styleArray);
						//$objPHPExcel->getActiveSheet()->setCellValue($colorCell, '=HYPERLINK("'.$value[2].'", '.$value[5].')');
						if (filter_var($value[2], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
							$objPHPExcel->getActiveSheet()->setCellValue($colorCell, '=HYPERLINK("'.$value[2].'", '.$value[5].')');
						}
					} elseif ($value && $value[4] > 0) {
						if ($value && $value[5]/$value[4] >= 0.4 && $value[5]/$value[4] <= 2.5) { // Если цены выша или ниже на 100%, определяем как ошибку
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
							if (filter_var($value[2], FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
								$objPHPExcel->getActiveSheet()->setCellValue($colorCell, '=HYPERLINK("'.$value[2].'", '.$value[5].')');
							}
							
						}
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
	$objPHPExcel->getActiveSheet()->getStyle('H2:'.$objPHPExcel->getActiveSheet()->getCellByColumnAndRow($iRow-1, 3)->getCoordinate())->applyFromArray(
    array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')))));


	//print_r($array_SKU); // Массив SKU
 

	file_put_contents('/var/www/polaris.ua/heap/'.date('d.m.y').'_'.$sheet_name_index.'.data', serialize($STORE_ORDER));



	system('clear');
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




