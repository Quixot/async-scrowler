<?php 
/**
 * vitek BIG
 */
	/**
	 * Список дат за период
	 */
	$timer = microtime(1);

	$from = new DateTime('now -15 day');
	$to   = new DateTime('now +1 day');

	//$from = new DateTime('now -16 day');
	//$to   = new DateTime('now');	

	$date_for_name = date('dmy');
	$dateHis = date('H:i:s');
	$datedmy = date('d.m.y');

	//$date_for_name = '180617';
	//$dateHis = '';
	//$datedmy = '18.06.17';

	$period = new DatePeriod($from, new DateInterval('P1D'), $to);
	
	$arrayOfDates = array_map(
	    function($item){return $item->format('d.m.y');},
	    iterator_to_array($period)
	);
	// Переварачиваем массив, чтобы в результирующем отчёте шёл начиная с последней даты (самой свежей информации)
	$arrayOfDates = array_reverse($arrayOfDates);

	//$arrayOfDates = array_slice($arrayOfDates, 0, 3); // КОСТЫЛЬ!!! УБРАТЬ!!! ТОЛЬКО ДЛЯ ТЕСТОВ!!!

	$important_cities = array(
		'Москва',
		'Ростов-на-Дону',
		'Новосибирск',
		'Екатеринбург',
		'Нижний Новгород',
		'Уфа',
		'Красноярск',
		'Благовещенск',
		'Калининград',
		'Якутск',
		'Санкт-Петербург',
		'Челябинск',
		'Волгоград',
		'Пермь',
		'Казань',
		'Воронеж',
		'Самара',
		'Омск',
		'Владивосток',
		'Хабаровск',
	);

	/**
	 * Открываем heap:
	 */	
	$max_dates = 0;
	$date_group_index = 0;
	foreach ($arrayOfDates as $date) {
		
			$is_heap = 0;

			echo 'Дата: '.$date.PHP_EOL;
			$heap_file_path = 'http://attraktor:eldorado@82.193.102.178:2080/vitek/heap/'.$date.'_'.$argv[2].'.data';
			//$heap_file_path = '/var/www/'.$argv[2].'/heap/'.$date.'_1'.'.data';
			
			$tempHeap = unserialize(file_get_contents($heap_file_path));
			echo $heap_file_path.PHP_EOL;
			// Дата
			$dateValue = $datedmy;
			if ($tempHeap) {
				$is_heap = 1;
			 	foreach ($tempHeap as $key => $value) {
			 		foreach ($value as $key2 => $value2) {
			 			foreach ($value2 as $info) {
			 				if ($key2 !== 'Усолье-Сибирское') {// USOLIE SIBIRSKOE !!! KOSTYL !!!
			 					$itemsArray[$info[1]][$key2][$key][$date] = array($info[4], $info[5], $info[2], $info[3], $date_group_index, 'VITEK'); 
			 				// КОД -> Город -> Сайт -> Дата  =  РИЦ | Цена магазина | url | Name | Индекс даты | Бренд
			 				}
						}
			 		}
			 	}
			 	echo microtime(1)-$timer.PHP_EOL;
			}


			echo 'Дата: '.$date.PHP_EOL;
			$heap_file_path = 'http://attraktor:eldorado@82.193.102.178:2080/maxwell/heap/'.$date.'_'.$argv[2].'.data';
			//$heap_file_path = '/var/www/'.$argv[2].'/heap/'.$date.'_1'.'.data';
			
			$tempHeap = unserialize(file_get_contents($heap_file_path));
			echo $heap_file_path.PHP_EOL;
			// Дата
			$dateValue = $datedmy;
			if ($tempHeap) {
				$is_heap = 1;
			 	foreach ($tempHeap as $key => $value) {
			 		foreach ($value as $key2 => $value2) {
			 			foreach ($value2 as $info) {
			 				if ($key2 !== 'Усолье-Сибирское') {// USOLIE SIBIRSKOE !!! KOSTYL !!!
			 					$itemsArray[$info[1]][$key2][$key][$date] = array($info[4], $info[5], $info[2], $info[3], $date_group_index, 'MAXWELL'); 
			 				// КОД -> Город -> Сайт -> Дата  =  РИЦ | Цена магазина | url | Name | Индекс даты
			 				}
						}
			 		}
			 	}
			 	echo microtime(1)-$timer.PHP_EOL;
			}

			if ($is_heap > 0) {
				$date_group_index++; // Позиция текущей даты даты, прибавляется к последнему ряду
				$max_dates++;
			}


	} // Dates перебор
	echo 'unset $tempHeap'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;
	unset($tempHeap);

	echo 'data array is ready'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;
	
	/**
	 * Готовим файл Excel
	 */	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("PricingLogix");
	$objPHPExcel->getProperties()->setTitle("PricingLogix");
	//$objPHPExcel->getProperties()->setSubject("PricingLogix" . ' ' . $dateHis);
	$objPHPExcel->getProperties()->setDescription("generated by PricingLogix");
	//$objPHPExcel->getActiveSheet()->setTitle($datedmy.' VM');	
	$objPHPExcel->getActiveSheet()->setShowGridlines(false); // Убрать сетку
	$objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(90); // Масштаб 90%
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Verdana')->setSize(8); // Шрифт по умолчанию
	$objPHPExcel->getActiveSheet()->setTitle('Monitoring_VM_'.$date_for_name.'_1');
	$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(10.3);


	// Вставим ЛОГОТИП
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setName('Logo');
	$objDrawing->setDescription('Logo');
	$logo = AC_DIR.'/settings/logo.png'; // Provide path to your logo file
	$objDrawing->setPath($logo);
	$objDrawing->setOffsetX(1);    // setOffsetX works properly
	$objDrawing->setCoordinates('B2');
	$objDrawing->setHeight(35); // logo height
	$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);			// ...отступ...
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);		// Бренд
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);  	// Артикул
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(29);		// Номенклатура
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(7);			// Ключевые города
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);		// Город
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(18);		// Клиент
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(6);			// РИЦ
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(7);			// Зона цены
	
/**/
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 5, 'Бренд');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 5, 'Артикул');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 5, 'Номенклатура');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 5, 'Ключевые города');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 5, 'Город');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 5, 'Клиент');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 5, 'РИЦ');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 5, 'Зона цены');
	

	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($max_dates + 9, 5, 'Ссылка');

	$objPHPExcel->getActiveSheet()->getStyle("B5:CA5")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("B5:H5")->applyFromArray(array('borders' => array('allborders' => array(
							            					'style' => PHPExcel_Style_Border::BORDER_THIN,
							            					'color' => array('rgb' => '000000')
								            				))));

	echo 'Draw network'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;

/**
  * Рисуем сетку:
  */ 
	$objPHPExcel->getDefaultStyle()
	    ->getAlignment()
	    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	//$objPHPExcel->getDefaultStyle()
	//    ->getAlignment()
	//    ->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);	    


	echo 'Height'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;	
	$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(39);

	$objPHPExcel->getActiveSheet()->getStyle('B5:W5')->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('B5:W5')->applyFromArray(
		array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
															 'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER)));

/*
	$endC 	= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $i-1)->getCoordinate();
	$objPHPExcel->getActiveSheet()->getStyle('B5:'.$endC)->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(39); 	 // Высота шапки
	$objPHPExcel->getActiveSheet()->freezePane('I6');	

	$endC 	= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($max_dates+8, $i-1)->getCoordinate();
	$objPHPExcel->getActiveSheet()->getStyle('B5:'.$endC)->applyFromArray(
		array('alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
															 'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER)));
*/


// $itemsArray[$info[1]][$key][$key2][$date.'_'.$pref] = array($info[4], $info[5], $info[2], $info[3]); // РИЦ | Цена магазина | url | Name
// Код / Город / Сайт / Дата = РИЦ | Цена магазина | url | Name
	

	
	$i = 6;
	foreach ($itemsArray as $code => $siteArray) { // Артикул
		foreach ($siteArray as $city => $cityArray) { // Город
			foreach ($cityArray as $site => $dateArray) { // Сайт
				foreach ($dateArray as $date => $info) { // Дата и информация
					// Раскрашиваем "Зона цены", разница в ценах между вчера и сегодня
					
					if ($info[4] == 1) { // Если это первый проход
						if ((int)$info[1]>0 && (int)$info[0]!=0) {
							$divergency = (int)$info[1]/(int)$info[0];
							if ($divergency <= 0.9) {
								$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FF0000'));
							} elseif (($divergency > 0.9 && $divergency <= 0.97)) {
								$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FFFF00'));
							} else {
								$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FFFFFF'));
							}
						}							
						$styleArray = array('fill' => $color);
						$colorCell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(8, $i)->getCoordinate();
						$objPHPExcel->getActiveSheet()->getStyle($colorCell)->applyFromArray($styleArray);
					}

	

					$dateValue = PHPExcel_Shared_Date::PHPToExcel(DateTime::createFromFormat('d.m.y', $date));
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($info[4]+9, 5, $dateValue); // Дата
					$objPHPExcel->getActiveSheet()
							    ->getStyle($objPHPExcel->getActiveSheet()->getCellByColumnAndRow($info[4]+9, 5)->getCoordinate())
							    ->getNumberFormat()
							    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, $info[5]); 		// Бренд
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, $code);					// Артикул
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, $info[3]);			// Номенклатура
					if (in_array($city, $important_cities)) {
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, 'да');				// Ключевые города
					} else {
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, '--');
					}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, $city);					// Город
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, $site);					// Клиент
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i, $info[0]); 			// РИЦ
					//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i, $info[2]); 		// Зона цены
					//////////
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($info[4]+9, $i, $info[1]); // Цена магазина

					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($max_dates+9, $i, $info[2]); // url в самом конце



					/**
					 * Розово - Зелёные цены
					 */

					// Тут нужно поймать такую же позицию за прошлый день:
					// КОД -> Город -> Сайт -> Дата  =  РИЦ | Цена магазина | url | Name | Индекс даты
					/*
					echo $code.PHP_EOL;
					echo $city.PHP_EOL;
					echo $site.PHP_EOL;
					echo $date.PHP_EOL;
					$key_of_date = array_search($date, $arrayOfDates);
					echo $arrayOfDates[$key_of_date+1].PHP_EOL;
					echo $itemsArray[$code][$city][$site][$arrayOfDates[$key_of_date+1]][1].PHP_EOL;
					print_r($itemsArray[$code][$city][$site][$arrayOfDates[$key_of_date+1]]);
					die();
					*/
					$key_of_date = array_search($date, $arrayOfDates);
					if (!isset($itemsArray[$code][$city][$site][$arrayOfDates[$key_of_date+1]])) { // На случай, когда выпадает один день по середине массива, ищем день ранее
						$key_of_date++;
					}
					$color = '';
					if ((int)$itemsArray[$code][$city][$site][$arrayOfDates[$key_of_date+1]][1]>0 && isset($arrayOfDates[$key_of_date+1])) {
						$divergency = (int)$info[1]/(int)$itemsArray[$code][$city][$site][$arrayOfDates[$key_of_date+1]][1];
						if ($divergency >= 1.00333) { // Заливаем светл.зел.цветом, если ТекЦена/ЦенаВчерДня >= 1,00333
							$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'c6efce'));
						} elseif ($divergency <= 0.99667) { // Заливаем роз.цветом, если ТекЦена/ЦенаВчерДня <= 0,99667
							$color = array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'ffc7ce'));
						}
					}

					if ($color) {
						$colorCell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($info[4]+9, $i)->getCoordinate();
						$objPHPExcel->getActiveSheet()->getStyle($colorCell)->applyFromArray(array('fill' => $color));
					}
				}
				$objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(10.3); 
				$i++;
			}
		}
		echo microtime(1)-$timer.PHP_EOL;
		unset($itemsArray[$code]);
		echo $code.PHP_EOL;
	}

	echo 'Borders'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;

	$endC 	= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($max_dates+8, 5)->getCoordinate();
	$objPHPExcel->getActiveSheet()->getStyle('B5:'.$endC)->applyFromArray(
		array('borders' => array('allborders' => array(
							            					'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
							            					'color' => array('rgb' => '000000')
							            				))));

	echo 'Autofilters'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;

	$objPHPExcel->getActiveSheet()->setAutoFilter('B5:'.$endC); // Фильтры
	// Делаем красным всю колонку РИЦ
	echo 'Red colour РИЦ'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;	
	$endC 	= $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $i-1)->getCoordinate();
	$objPHPExcel->getActiveSheet()->getStyle('G5:'.$endC)->applyFromArray(array( 'font'  		=> array('color' => array('rgb' => 'FF0000'))));


	$objPHPExcel->getActiveSheet()->freezePane('J6');

	echo 'Password...';
	// Пароль на запись
	$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
	$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
	$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
	$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
	$objPHPExcel->getActiveSheet()->getProtection()->setPassword('1129');

	echo 'Killing array...';
	unset($itemsArray);
	echo 'Saving...';
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save('/var/www/reporter/reports/big/Monitoring_Vitek_Maxwell_'.$date_for_name.'_'.$argv[2].'.xlsx');
	//Monitoring_Vitek_RU_060617_1
echo 'Sending...';
$fileName = 'Monitoring_Vitek_Maxwell_'.$date_for_name.'_'.$argv[2].'.xlsx';


$url = '/GOLDER-ELECTRONICS/'.$fileName; // Путь на yandex диске
$file = '/var/www/reporter/reports/big/'.$fileName; // Локальный путь
$user = 'rsp.ratushnyy'; // Логин на yandex диск
$pass = 'zaq12wsxcde3';  // Пароль на yandex диск
$ch = curl_init();
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_URL, 'https://webdav.yandex.ru' . $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($file));
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic " . base64_encode($user . ":" . $pass)));
curl_setopt($ch, CURLOPT_PROXY, '195.88.209.224:44941');
curl_setopt($ch, CURLOPT_PROXYUSERPWD, '9WxazV6Mus:rsp.bt.tech@gmail.com');

$answer = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);
$version = '1';

if ($info['http_code'] != '201') {
	sleep(3);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:41.0) Gecko/20100101 Firefox/41.0');
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_URL, 'https://webdav.yandex.ru' . $url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
	curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($file));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Basic " . base64_encode($user . ":" . $pass)));
	curl_setopt($ch, CURLOPT_PROXY, '151.236.13.116:7951');
	curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'gp3070909:5hKa4xXxi6');

	$answer = curl_exec($ch);
	$info = curl_getinfo($ch);
	curl_close($ch);
	$version = '2';
}


$email = new PHPMailer();
$email->IsSMTP();
$email->CharSet = 'utf-8';
$email->Host = "mx1.mirohost.net";
$email->Port = 25;
$email->SMTPAuth = true;
$email->Username = "info@pricinglogix.com";
$email->Password = "*rybuyC?D7hf";
$email->isHTML(true);
$email->From      = 'info@pricinglogix.com';
$email->FromName  = 'PricingLogix';
$email->AddEmbeddedImage('/var/www/reporter/settings/logo.png', 'pricinglogix-logo', 'logo.png');

if ($info['http_code'] != '201') {
	$email->Subject   = 'YANDEX DISK ERROR! Can\'t save '.$fileName.' to yandex.disk ('.$version.')';
	$email->Body  = '<img alt="PHPMailer" src="cid:pricinglogix-logo"><br><br><a href="http://pricinglogix.com/">http://pricinglogix.com</a><br><br>';
	$email->Body .= 'Can\'t write '.$fileName.' to YANDEX.disk automaticly. Please do it manualy:<br>';
	$email->Body .= '
	<br>
	Server catalogue link:
	<br>
	<a href="http://176.36.102.141:5080/reporter/reports/big/">http://176.36.102.141:5080/reporter/reports/big/</a>
	<br>
	Direct link:
	<br>
	<a href="http://176.36.102.141:5080/reporter/reports/big/'.$fileName.'">http://176.36.102.141:5080/reporter/reports/big/'.$fileName.'</a>
	';
} else {
	$email->Subject   = $fileName.' has been saved to yandex.disk successful! ('.$version.')';
	$email->Body  = '<img alt="PHPMailer" src="cid:pricinglogix-logo"><br><br><a href="http://pricinglogix.com/">http://pricinglogix.com</a><br><br>';
	$email->Body .=  $fileName.' has been saved to yandex.disk successful!<br>';
	$email->Body .= '
	<br>
	Server catalogue link:
	<br>
	<a href="http://176.36.102.141:5080/reporter/reports/big/">http://176.36.102.141:5080/reporter/reports/big/</a>
	<br>
	Direct link:
	<br>
	<a href="http://176.36.102.141:5080/reporter/reports/big/'.$fileName.'">http://176.36.102.141:5080/reporter/reports/big/'.$fileName.'</a>
	<br>
	Use YANDEX disk link:
	<br>
	<a href="https://yadi.sk/d/w463C-bx3JsuZE">https://yadi.sk/d/w463C-bx3JsuZE</a>
	<br>';
}
$recipients = array('alexandr.volkoff@gmail.com', 'rsp.bt.tech@gmail.com', 'woldemarx77@gmail.com');
foreach($recipients as $mailaddr) {
 	$email->AddAddress($mailaddr);
}
$email->Send();
print_r($recipients);



// Письмо Витеку


if ($argv[2] == '1') { // Если отчёт Витек, то высылаем "письмо счастья"
	// ADD THIS:
	$email = new PHPMailer();
	$email->IsSMTP();
	$email->CharSet = 'utf-8';
	$email->Host = "mx1.mirohost.net";
	$email->Port = 25;
	$email->SMTPAuth = true;
	$email->Username = "info@pricinglogix.com";
	$email->Password = "*rybuyC?D7hf";
	$email->isHTML(true);
	$email->From      = 'info@pricinglogix.com';
	$email->FromName  = 'PricingLogix';
	$email->AddEmbeddedImage('/var/www/reporter/settings/logo.png', 'pricinglogix-logo', 'logo.png');


		$email->Subject   = 'Monitoring_Vitek-Rondell-Maxwell_'.$date_for_name.'_1';
		$email->Body  = 'Это ссылка на папку GOLDER-ELECTRONICS, по этой ссылке Вы всегда сможете скачать отчеты c <br>Яндекс.Диска ';
		$email->Body .= '<a href="https://yadi.sk/d/w463C-bx3JsuZE">https://yadi.sk/d/w463C-bx3JsuZE</a><br><br>';
		$email->Body .= '<img alt="PHPMailer" src="cid:pricinglogix-logo"><br><br>';
		$email->Body .= 'Лучший инструмент <br>для Вашего бизнеса<br><br>';
		$email->Body .= '<a href="http://pricinglogix.com/">http://pricinglogix.com/</a>';

	$recipients = array('alexandr.volkoff@gmail.com', 'rsp.bt.tech@gmail.com', 'grechko_yy@vitek.ru', 'woldemarx77@gmail.com');
	foreach($recipients as $mailaddr) {
	 	$email->AddAddress($mailaddr);
	}
	$email->Send();
	print_r($recipients);
}
/**/


echo microtime(1)-$timer.PHP_EOL;


