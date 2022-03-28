<?php
if (!$_GET) {
	//file_put_contents(AC_DIR.'/engines/'.ENGINE_TYPE.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.data', serialize($itemsArray), LOCK_EX);
	chmod(AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.data', 0777);
}
if ($bad_urls) {
	file_put_contents('/var/www/tasks/'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.task', serialize($bad_urls), LOCK_EX);
	if (!$_GET) {
		chmod('/var/www/tasks/'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.task', 0777);
	}
}

require_once('/var/www/lib/pricechecker/send.php');

// XLS
//PHPExcel_Settings::setLocale(ru);
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("PricingLogix");
//$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
$objPHPExcel->getProperties()->setTitle(ENGINE_CURR);
$objPHPExcel->getProperties()->setSubject(ENGINE_CURR . ' ' . date('H:i:s'));
$objPHPExcel->getProperties()->setDescription("generated for Polaris by PricingLogix");
// Create CSV file
//$handle = fopen($filename, 'w'); // CSV file

// Loop here
$i = 1;
$storeHeader = array(); // Название магазина. Хранит уже встречавшиеся названия и соответственно к-во таковых и цены в текущей итерации
//$storePrices = ''; // Список цен магазинов в определённом порядке

ksort($itemsArray);
reset($itemsArray);
$vowels = array("\n", "\r", "\t", "\x0B", "&#8203;", ";");
foreach ($itemsArray as $key => $value) {
  $key = str_replace($vowels, ' ', $key);
  $key = trim($key);
  if (filter_var($key, FILTER_VALIDATE_URL)) {
//    fputs($handle, $key . ';' . $value[0] . ';' . preg_replace('~[^\d.]+~', '' , $value[1]) . "\n");
    //echo $key . ';' . $value[0] . ';' . preg_replace('~[^\d.]+~', '' , $value[1]) . "\n";
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $i, $key);
    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $i, trim($value[0]));
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
//fputs($handle, "\n\n" . round($time_end - $time_start, 2) . "sec.");
//fputs($handle, "\n" . date("d.m.y-H:i:s"));
// Close CSV
//fclose($handle);

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save(str_replace('.csv', '.xlsx', $filename));
if (!$_GET) {
	echo $filename.PHP_EOL;
	chmod(str_replace('.csv', '.xlsx', $filename), 0777);
}

/**
 * Запись в базу. Тестовая версия
 */
/*
$mysqli = new mysqli('localhost', 'root', 'eldorado', 'storage'); // Trying to connect to the DB
$mysqli->query("SET NAMES 'utf8'");
$mysqli->query("SET SESSION collation_connection = 'utf8_general_ci'");

if ($itemsArray) {
	$sql = "INSERT INTO `heap` (`code`, `country`, `city`, `site`, `brand`, `requesturl`, `url`, `name`, `price`, `time`, `proxy`, `useragent`, `session_type`, `session_id`, `session_time`) VALUES ";
	foreach ($itemsArray as $url => $info) {
		$info[0] = $mysqli->real_escape_string($info[0]);
		if (strlen($info[0]) < 500) {				
			$info[1] = preg_replace('~[^\d]+~', '' ,$info[1]);
			if (!isset($info[1]) || $info[1] == '') { // Цена
				$info[1] = 0;
			}
			if (!isset($info[2])) { // Дата
				$info[2] = date("d.m.y-H:i:s", time()); //echo 'FILEDATE: '.$info[2].PHP_EOL;
			}
			if (!isset($info[3])) { // Proxy
				$info[3] = '';
			}
			if (!isset($info[4])) { // User-agent
				$info[4] = '';
			}
			if ((!isset($argv[6]) || $argv[6] == '') && !$_GET['EC']) {
				$session_type = 1;//cron
			} elseif ($_GET['EC']) {
				$session_type = 2;//http
			} else {
				$session_type = 3;//cli;
			}
			$sql .= " (";
			$sql .= "200, 'RU', '".EXTRA_PARAM."', '".ENGINE_CURR."', '".ENGINE_TYPE."', '$info[5]', '$url', '$info[0]', $info[1], STR_TO_DATE('$info[2]', '%d.%m.%y-%H:%i:%s'), '$info[3]', '$info[4]', '$session_type', 'obolon_".ENGINE_CURR."_".ENGINE_TYPE."_".EXTRA_PARAM."_".$time_start."_".rand(0, 100)."', FROM_UNIXTIME($time_start)";
			$sql .= "),";
		} else {
			echo 'Too large name'.PHP_EOL;
		}
	}
	$sql = substr($sql, 0, -1); //echo $sql.PHP_EOL;
	$ans = $mysqli->query($sql);
	var_dump($ans);
	if (!$ans) {
		//echo $sql.PHP_EOL;
		//print_r($info);
		$filename = str_replace('/reports/', '/temp/', $filename);
		$filename = str_replace('.csv', '.data', $filename);
		file_put_contents(substr($filename, strripos($filepath, '/')), $sql);
	}
}
*/