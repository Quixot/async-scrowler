<?php
/**
 * База для нечёткого поиска
 */
// sudo php app.php search vitek_common vitek Report_VITEK_RU_$(date +\%d\%m\%y)
// sudo screen -S SEARCH_MAXWELL  php app.php search vitek_common maxwell Report_VITEK_RU_$(date +\%d\%m\%y)
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
			  if ($URL && $content[0] && count($matchc[0])>0) {
			  	$objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, $URL);
				  if ($content[0]) {
				  	$objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, $content[0]);
				  }
				  if ($content[1]) {
				  	$objPHPExcel->getActiveSheet()->SetCellValue('C' . $i, preg_replace('~[^\d.]+~', '' , $content[1]));
				  }
				  if ($content[2]) {
				  	$objPHPExcel->getActiveSheet()->SetCellValue('D' . $i, $content[2]);
				  }
				  if ($content[3]) {
				  	$objPHPExcel->getActiveSheet()->SetCellValue('E' . $i, $content[3]);
				  }
				  if ($content[4]) {
				  	$objPHPExcel->getActiveSheet()->SetCellValue('F' . $i, $content[3]);
				  }
				  $i++;
			  }
			}
		}
	}

	echo round((microtime(1)-$start), 2).PHP_EOL;
	echo 'writing...'.PHP_EOL;
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	
	$fileName = ENGINE_TYPE.'_for_search.xlsx';
	$objWriter->save('/var/www/reporter/reports/'.$fileName);

	echo "Final: ".memory_get_usage()." bytes \n";
	echo "Peak: ".memory_get_peak_usage()." bytes \n";

	echo round((microtime(1)-$start), 2).PHP_EOL;
