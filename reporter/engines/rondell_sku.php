<?php
	include( '/var/www/lib/PHPExcel.php' );
	include( '/var/www/lib/PHPExcel/Writer/Excel2007.php' );
	$objSKU = PHPExcel_IOFactory::load('Report_SKU_Rondell.xlsx');

	
	$objSKU->getActiveSheet()->insertNewRowBefore(6, 8);
	$objSKU->getActiveSheet()->getRowDimension(6)->setRowHeight(17.3);
	$objSKU->getActiveSheet()->getRowDimension(7)->setRowHeight(17.3);
	$objSKU->getActiveSheet()->getRowDimension(8)->setRowHeight(17.3);
	$objSKU->getActiveSheet()->getRowDimension(9)->setRowHeight(17.3);
	$objSKU->getActiveSheet()->getRowDimension(10)->setRowHeight(17.3);
	$objSKU->getActiveSheet()->getRowDimension(11)->setRowHeight(17.3);
	$objSKU->getActiveSheet()->getRowDimension(12)->setRowHeight(17.3);
	$objSKU->getActiveSheet()->getRowDimension(13)->setRowHeight(17.3);

	$objSKU->getActiveSheet()->freezePane('C13');

	$objSKU->getActiveSheet()->SetCellValue('B3', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');

	$objWriter = PHPExcel_IOFactory::createWriter($objSKU, 'Excel2007');
	$objWriter->save('keywords.xlsx'); 
