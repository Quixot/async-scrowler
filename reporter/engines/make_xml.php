<?php
/**
 * XML для Polaris
 */
	$present_file = file_get_contents('/var/www/'.$argv[2].'/heap/'.date('d.m.y').'_'.$argv[3].'.data');

	unset($present_file);
	
	$timer = microtime(1);
/*
	$from = new DateTime('now -15 day');
	$to   = new DateTime('now +1 day');

	$date_for_name = date('dmy');
	$dateHis = date('H:i:s');
	$datedmy = date('d.m.y');


	$period = new DatePeriod($from, new DateInterval('P1D'), $to);
	
	$arrayOfDates = array_map(
	    function($item){return $item->format('d.m.y');},
	    iterator_to_array($period)
	);
	// Переварачиваем массив, чтобы в результирующем отчёте шёл начиная с последней даты (самой свежей информации)
	$arrayOfDates = array_reverse($arrayOfDates);


	$objPHPExcel = PHPExcel_IOFactory::load('/var/www/reporter/settings/polaris_common.xlsx');

	$sheet = $objPHPExcel->getSheet(0);
	//$qountity = $sheet->getCell( 'G1' )->getOldCalculatedValue();
	$qountity = $sheet->getHighestRow(); // Сколько строк
	echo 'массив с ценами РИЦ: '.$qountity.PHP_EOL;
	$data = $sheet->rangeToArray('A2:H'.$qountity);
	$i = 0;
	foreach ($data as $row) {
	  $priceArray[$row[1].'_'.$row[4]] = array($row[0], $row[1], $row[5], $row[2], $row[3], $row[6], $row[7], $row[4]); // REALNAME POSITION CODE REALRICE Тип Наименование товара
	}
*/

	$date = date('d.m.y');

	$heap_file_path = '/var/www/polaris/heap/'.$date.'_'.$argv[2].'.data';
			
	$tempHeap = unserialize(file_get_contents($heap_file_path));

	echo 'making XML for Polaris!<br>';

	$xml = new DomDocument('1.0','utf-8');

	$implementation = new DOMImplementation();
	$xml->appendChild($implementation->createDocumentType('yml_catalog SYSTEM "shops.dtd"'));

	$yml_catalog = $xml->appendChild($xml->createElement('yml_catalog'));

	$date = $xml->createAttribute('date');
	$date->value = date("Y-m-d H:i");
	$yml_catalog->appendChild($date);
	//$xml->appendChild($yml_catalog);

	$shop = $xml->createElement('shop');
	$yml_catalog->appendChild($shop);

	$shop->appendChild($xml->createElement('name', 'Report'));
	$shop->appendChild($xml->createElement('company', 'Pricinglogix'));
	$shop->appendChild($xml->createElement('url', 'https://pricinglogix.com/'));

	$currencies = $shop->appendChild($xml->createElement('currencies'));
	$currency = $currencies->appendChild($xml->createElement('currency'));
	$id = $xml->createAttribute('id');
	$id->value = 'RUB';
	$currency->appendChild($id);

	$offers = $shop->appendChild($xml->createElement('offers'));

print_r($tempHeap);die();

	if ($tempHeap) {
		foreach ($tempHeap as $key => $value) {
			foreach ($value as $key2 => $value2) {
				foreach ($value2 as $info) {
					echo $info[1].PHP_EOL; 	// КОД
					echo $key.PHP_EOL; 			// Site
					echo $key2.PHP_EOL; 		// City
					echo $date.PHP_EOL; 		// Date
					echo $info[4].PHP_EOL; 	// RIC
					echo $info[5].PHP_EOL; 	// Store Price
					echo $info[2].PHP_EOL; 	// URL
					echo $info[3].PHP_EOL; 	// Name
					die();
		 			//$itemsArray[$info[1]][$key2][$key][$date] = array($info[4], $info[5], $info[2], $info[3]); 
		 			// КОД -> Город -> Сайт -> Дата  =  РИЦ | Цена магазина | url | Name
				}
			}
		}
		echo microtime(1)-$timer.PHP_EOL;
	}

	echo 'unset $tempHeap'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;
	unset($tempHeap);

	echo 'data array is ready'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;

	$xml->save('/var/www/reporter/reports/polaris_xml/test.xml');
	die();



	// OFFER ID
	$offer = $offers->appendChild($xml->createElement('offer'));
	$offer_id = $xml->createAttribute('id');
	$offer_id->value = $row['id'];
	$offer->appendChild($offer_id);

	// OTHER INS OFFER
	$url = $offer->appendChild($xml->createElement('url', 'http://bonus-ua.com'.build_link_local($row['id'])));
	$name = $offer->appendChild($xml->createElement('name', $row['headline']));					
	$price = $offer->appendChild($xml->createElement('price', $row['on_main']));




	$i = 6;
	foreach ($itemsArray as $code => $siteArray) { // Артикул
		foreach ($siteArray as $city => $cityArray) { // Город
			foreach ($cityArray as $site => $dateArray) { // Сайт
				$pervy_prohod = 1;
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

					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $i, $code);					// Артикул
					$nomenklatura = substr($info[3], strlen($code)+1);
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $i, $nomenklatura);			// Номенклатура
					$model_name = $priceArray[$info[3]][4];

					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $i, $model_name);					// Модель
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $i, $city);								// Город
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $i, $site);								// Клиент
					if ($info[5]) {
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $i, $info[5]);					// Merchant
					}
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $i, $priceArray[$info[3]][2]); 						// РИЦ
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($info[4]+8, $i, $info[1]); 	// Цена магазина
					//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($max_dates+9, $i, $info[2]); // url в самом конце


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


	echo 'Killing array...';
	unset($itemsArray);
	echo 'Saving...';

	
