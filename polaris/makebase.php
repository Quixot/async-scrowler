<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$timer = microtime(1);
ini_set( 'display_errors', 1 );										// Display Errors
ini_set( 'error_reporting',2047 );								// Display All Errors
require_once( '/var/www/lib/PHPExcel.php');
require_once( '/var/www/lib/PHPExcel/Writer/Excel2007.php');

$objPHPExcel = PHPExcel_IOFactory::load('/var/www/reporter/settings/polaris_common.xlsx');

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
	}

$brand = 'polaris';
$reportsArray = glob('/var/www/polaris/engines/*/data/25.04.17_*.data');
$reportsArray = array_merge($reportsArray, glob('/var/www/polaris/engines/*/data/26.04.17_*.data'));
$reportsArray =	array_merge($reportsArray, glob('/var/www/polaris/engines/*/data/27.04.17_*.data'));
$reportsArray =	array_merge($reportsArray, glob('/var/www/polaris/engines/*/data/28.04.17_*.data'));
$reportsArray =	array_merge($reportsArray, glob('/var/www/polaris/engines/*/data/29.04.17_*.data'));
$reportsArray =	array_merge($reportsArray, glob('/var/www/polaris/engines/*/data/30.04.17_*.data'));
$reportsArray =	array_merge($reportsArray, glob('/var/www/polaris/engines/*/data/*.05.17_*.data'));
$data = '/var/www/polaris/engines/';

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("PricingLogix");
	$objPHPExcel->getProperties()->setTitle("PricingLogix");
	$objPHPExcel->getProperties()->setSubject("PricingLogix" . ' ' . date('H:i:s'));
	$objPHPExcel->getProperties()->setDescription("generated by PricingLogix");

	$objWorkSheet = $objPHPExcel->createSheet();
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle(date('d.m.y').'Polaris_big_base');	

$i=0;
foreach ($reportsArray as $filepath) {
	//if (strripos($filepath, '.03.17_') != false) {
		preg_match_all("~data/(.+)_(.+)_(.+)_(.+).data~isU", $filepath, $matches, PREG_SET_ORDER);

		$date = $matches[0][1];
		$site = $matches[0][2];
		$brand = $matches[0][3];
		$city = $matches[0][4];

		system('clear');
		echo $filepath.PHP_EOL;
		$items = unserialize(file_get_contents($filepath));
		if ($items) {
			foreach ($items as $url => $info) {
				$key = array_search($info[0], $keyNAME);
				if ($key === false) {
					$key = array_search($url, $keyURL);
				}
				if (strlen($info[0]) < 500) {
					
					$info[1] = preg_replace('~[^\d]+~', '' ,$info[1]);
					if (!isset($info[1]) || $info[1] == '') {
						$info[1] = 0;
					}

					if ($key !== false) {
						$REALNAME = $keyREALNAME[$key];
						$timefile = filemtime($filepath);
						if (!isset($info[2])) {
							$info[2] = date("d.m.y-H:i:s", $timefile);
							//echo 'FILEDATE: '.$info[2].PHP_EOL;
						}

						
						//$arr_date = explode('.', $info[2]);
						//$timest = mktime(0, 0, 0, $arr_date[1], $arr_date[0], $arr_date[2]);
						$dateValue = PHPExcel_Shared_Date::PHPToExcel(DateTime::createFromFormat("d.m.y-H:i:s", $info[2]));
						

						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $i, $site);
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, $city);
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, $url);
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, $REALNAME);
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, $info[1]);
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, $dateValue);
						$objPHPExcel->getActiveSheet()
					    ->getStyle($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $i)->getCoordinate())
					    ->getNumberFormat()
					    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
						$i++;
						echo '■';
					}
				} else {
					echo 'Too large name'.PHP_EOL;
				}
			}
			echo PHP_EOL;
		}
	//}
}



	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	//$objWriter->setPreCalculateFormulas(true);
	$objWriter->save('/var/www/polaris/big_base.xlsx');

//file_put_contents('/var/www/polaris/kill.txt', print_r($items_array, 1));
echo microtime(1)-$timer.PHP_EOL;
