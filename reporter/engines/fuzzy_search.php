<?php
/**
 * База для нечёткого поиска
 * sudo php app.php fuzzy_search vitek_common vitek Report_VITEK_RU_$(date +\%d\%m\%y)
 */
//$str = 'Мультиварка Vitek VT-4213GY';
//$vowels = array('-','_','(','-');
//$str = str_replace($vowels, ' ', $str);
//$str = preg_replace ("/[^a-zA-Z0-9\s-()]/","", $str);
$str = 'VC VITEK VT-1815 G';
$str = strtolower($str);
$str = str_replace('vitek', '', $str);
$str = preg_replace ("/[^a-zA-Z0-9]/","", $str);

$main_mask = '*';
for ($i=0; $i < strlen($str); $i++) { 
	$main_mask .= $str{$i}.'*';
}
echo $main_mask;



/**
 * Это массив с ценами РИЦ и реальными именами CLIENT_NAME
 */
	$objPHPExcel = PHPExcel_IOFactory::load($dataFfile);
	$sheet = $objPHPExcel->getSheet(0);
	$qountity = $sheet->getCell( 'E1' )->getOldCalculatedValue();
	$data = $sheet->rangeToArray('A2:D'.$qountity);
	foreach ($data as $row) {
	  $priceArray[$row[2]] = array($row[0], $row[1], $row[3]); // REALNAME POSITION CODE REALRICE
	}
	//echo 'Имя и РИЦ: '.count($data).PHP_EOL;

	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("PricingLogix");
	$objPHPExcel->getProperties()->setTitle("PricingLogix");
	$objPHPExcel->getProperties()->setSubject("PricingLogix" . ' ' . date('H:i:s'));
	$objPHPExcel->getProperties()->setDescription("generated for PricingLogix by PricingLogix");

	// Шрифт по умолчанию
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Verdana')->setSize(8);



	$pathes = glob('/var/www/'.ENGINE_TYPE.'/engines/*/data/'.$cur_date.'*'.ENGINE_TYPE.'*.data');
	$i = 1;
	foreach ($pathes as $keypath) { // Перебираем каждый файлик
		if (file_exists($keypath)) {
			//echo $keypath.PHP_EOL;
			$current_row_array = unserialize(file_get_contents($keypath));
			foreach ($current_row_array as $URL => $content) {
				//if (strripos($keypath, '003.ru') !== false) {
					// Разбиваем REALNAME и NAME на два массива, ключами в которых являются лексемы
					/**
					  * На данный момент у нас есть сл. переменные:
					  * $keypath - имя МАГАЗИНа
					  * $REALNAMEarray - массив содержащие лексемы REALNAME
					  * $content[0] - текущее NAME соотв. магазина
					  */ 
					// Разбиваем массив NAME
					$NAME = strtolower($content[0]);
					$NAME = str_replace('vitek', '', $NAME);
					$NAME = preg_replace ("/[^a-z0-9]/","", $NAME);

					$temp_mask = '*';
					for ($tm=0; $tm < strlen($NAME); $tm++) { 
						$temp_mask .= $NAME{$tm}.'*';
					}
					//echo '-----'.PHP_EOL;
					
					//echo $temp_mask.PHP_EOL;
					
					$one = fnmatch($main_mask, $content[0]);
					$two = fnmatch($temp_mask, $str);
					echo $content[0].PHP_EOL;
					if($one == true || $two == true) {
					  if ($URL && $content[0]) {
					  	$objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, $URL);
					  	
						  if ($content[0]) $objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, $content[0]);
						  //if ($content[1]) $objPHPExcel->getActiveSheet()->SetCellValue('C' . $i, $content[1]);
						  //if ($content[2]) $objPHPExcel->getActiveSheet()->SetCellValue('D' . $i, $content[2]);
						  //if ($content[3]) $objPHPExcel->getActiveSheet()->SetCellValue('E' . $i, $content[3]);
						  //if ($content[4]) $objPHPExcel->getActiveSheet()->SetCellValue('F' . $i, $content[3]);
						  $i++;
					  }
				  }
			  //}
			}
		}
	}

	echo round((microtime(1)-$start), 2).PHP_EOL;
	echo 'writing...'.PHP_EOL;
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	
	$fileName = ENGINE_TYPE.'_fazzy_search.xlsx';
	$objWriter->save('/var/www/reporter/reports/'.$fileName);

	echo "Final: ".memory_get_usage()." bytes \n";
	echo "Peak: ".memory_get_peak_usage()." bytes \n";

	echo round((microtime(1)-$start), 2).PHP_EOL;

