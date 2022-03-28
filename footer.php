<?php
// Сохраним массив в переменную
file_put_contents(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.data', serialize($itemsArray), LOCK_EX);
if (!$_GET) {
	chmod(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.data', 0777);
}
/*
if ($bad_urls) {
	file_put_contents('/var/www/tasks/'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.task', serialize($bad_urls), LOCK_EX);
	if (!$_GET) {
		chmod('/var/www/tasks/'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.task', 0777);
	}
}
*/
require_once('/var/www/lib/pricechecker/send.php');

if (ENGINE_TYPE == 'philips') {
	$filename = AC_DIR.'/reports/'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.xlsx';
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("PricingLogix");
	$objPHPExcel->getProperties()->setTitle(ENGINE_CURR);
	$objPHPExcel->getProperties()->setSubject(ENGINE_CURR . ' ' . date('H:i:s'));
	$objPHPExcel->getProperties()->setDescription("generated for ".ENGINE_TYPE." by PricingLogix");

	// Loop here
	$i = 1;
	ksort($itemsArray);
	reset($itemsArray);
	$vowels = array("\n", "\r", "\t", "\x0B", "&#8203;", ";");
	foreach ($itemsArray as $key => $value) {
	  $key = str_replace($vowels, ' ', $key);
	  $key = trim($key);
	  if (filter_var($key, FILTER_VALIDATE_URL)) {
	    $objPHPExcel->setActiveSheetIndex(0);
	    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, $key);
	    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, $value[0]);
	    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $i, preg_replace('~[^\d.]+~', '' , $value[1]));
		  if (@$value[2]) {
		  	$objPHPExcel->getActiveSheet()->SetCellValue('D' . $i, $value[2]);
		  }
		  if (@$value[3]) {
		  	$objPHPExcel->getActiveSheet()->SetCellValue('E' . $i, $value[3]);
		  }  
	    $i++;
	  }
	}

	$time_end = microtime(1);   // Останавливаем счётчик, смотрим, сколько времени работал скрипт
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save($filename);
}