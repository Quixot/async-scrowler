<?php
/**
 * База для нечёткого поиска
 */
	$objPHPExcel = PHPExcel_IOFactory::load('/var/www/reporter/settings/polaris_common.xlsx');
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



	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("PricingLogix");
	$objPHPExcel->getProperties()->setTitle("PricingLogix");
	$objPHPExcel->getProperties()->setSubject("PricingLogix" . ' ' . date('H:i:s'));
	$objPHPExcel->getProperties()->setDescription("generated for PricingLogix by PricingLogix");


	// Шрифт по умолчанию
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Verdana')->setSize(8);



	$pathes = glob('/var/www/'.ENGINE_TYPE.'/engines/*/data/'.$cur_date.'*.data');
	$i = 1;
	foreach ($pathes as $keypath) { // Перебираем каждый файлик
		if (file_exists($keypath)) {
			echo $keypath.PHP_EOL;
			$current_row_array = unserialize(file_get_contents($keypath));
			foreach ($current_row_array as $URL => $content) {
				preg_match("/[\d]+/", $content[0], $matchc);

				//echo $URL.PHP_EOL;
				//echo $content[0].PHP_EOL;
				//echo count($matchc[0]).PHP_EOL;
				//die();

			  if ($URL && $content[0] && count($matchc[0])>0) {
					// Ищем, определена ли позиция
					$key = array_search($content[0], $keyNAME);
					if ($key === false) {
						$key = array_search($URL, $keyURL);
					}

					
					/*
					echo 'REALNAME: '.$REALNAME.PHP_EOL;
					echo 'URL: '.$URL.PHP_EOL;
					echo 'NAME: '.$content[0].PHP_EOL;
					*/
					if ($key) { // Если позиция определена ставим 1
						$REALNAME = $keyREALNAME[$key];
						$objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, $URL);
					  if ($content[0]) {
					  	$objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, $content[0]);
					  }
					  $objPHPExcel->getActiveSheet()->SetCellValue('C' . $i, '1');
					  $objPHPExcel->getActiveSheet()->SetCellValue('D' . $i, $REALNAME);
					  $i++;
					} else { // Если позиция не распознана ставим 0
						$objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, $URL);
					  if ($content[0]) {
					  	$objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, $content[0]);
					  }
					  $objPHPExcel->getActiveSheet()->SetCellValue('C' . $i, '0');
					  $i++;
					}



			  }
			}
		}
	}

	echo round((microtime(1)-$start), 2).PHP_EOL;
	echo 'writing...'.PHP_EOL;
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	
	$fileName = ENGINE_TYPE.'_links.xlsx';
	$objWriter->save('/var/www/reporter/reports/'.$fileName);

	echo "Final: ".memory_get_usage()." bytes \n";
	echo "Peak: ".memory_get_peak_usage()." bytes \n";

	echo round((microtime(1)-$start), 2).PHP_EOL;
