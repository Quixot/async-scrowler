<?php 
/**
 * BIG SKU
 */
	/**
	 * Список дат за период
	 */
	$timer = microtime(1);

	$from = new DateTime('now -2 day');
	$to   = new DateTime('now +1 day'); // Последние три дня. Если за вчера отчёта небыло, берём за позавчера

	$pref = $argv[3]; // Префикс отчёта, устанавливается командной строкой, чтобы не думать


	$period = new DatePeriod($from, new DateInterval('P1D'), $to);

	$arrayOfDates = array_map(
	    function($item){return $item->format('d.m.y');},
	    iterator_to_array($period)
	);
/*
	$arrayOfDates = array(
		'28.06.17',
		'29.06.17',
		'30.06.17',
		);
*/
	$important_cities = array( // Список ключевых городов (по старому стилю, для совместимости с текущим файликом отчёта SKU)
		'Москва',
		'Санкт-Петербург',
		'Ростов-на-Дону',
		'Новосибирск',
		'Екатеринбург',
		'Челябинск',
		'Волгоград',
		'Пермь',
		'Казань',
		'Воронеж',
		'Нижний Новгород',
		'Самара',
		'Уфа',
		'Омск',
		'Красноярск',
		'Владивосток',
	);

	$sites_order = array(
		'mvideo.ru',
		'eldorado.ru',
		'mediamarkt.ru',
		'tehnosila.ru',
		'003.ru',
		'dns-shop.ru',
		'technopoint.ru',
		'frau-technica.ru',
		'citilink.ru',
		'ulmart.ru',
		'vstroyka-solo.ru',
		'komfortbt.ru',
		'enter.ru',
		'123.ru',
		'holodilnik.ru',
		'technopark.ru',
		'rbt.ru',
		'ozon.ru',
		'shop.v-lazer.com',
		'domotekhnika.ru',
		'e96.ru',
		'corpcentre.ru',
		'nord24.ru',
		'logo.ru',
		'idei.ru',
		'onlinetrade.ru',
		'poiskhome.ru',
		'techport.ru',
		'kotofoto.ru',
		'220-volt.ru',
		'oldi.ru',
		'wildberries.ru',
		);


	/**
	 * Открываем heap за сегодня:
	 */
	$heap_file_path = '/var/www/'.$argv[2].'/heap/'.$arrayOfDates[2].'_'.$pref.'.data';


	if (!file_exists($heap_file_path)) { // Если сегодняшний heap файл отсутствует, выходим с ошибкой
		die('За сегодня нет heap файла'.PHP_EOL);
	} else {
		$tempHeap = unserialize(file_get_contents($heap_file_path));
		echo $heap_file_path.' открылся'.PHP_EOL;
	}


	if ($pref == 1) { // Если префикс один, значит предыдущий файлик вчерашний с префиксом 2
		$sku_prev_file = '/var/www/reporter/reports/_big_sku/Report_SKU_'.ucfirst($argv[2]).'_RU_'.str_replace('.', '', $arrayOfDates[1]).'_2.xlsx';
		if (!file_exists($sku_prev_file)) {
			die('Какая-то хуйня с предыдущим файлом'.$sku_prev_file.PHP_EOL);
		}
	} elseif($pref == 2) { // Если префикс 2, то предыдущий файлик того же дня с префиксом 1
		$sku_prev_file = '/var/www/reporter/reports/_big_sku/Report_SKU_'.ucfirst($argv[2]).'_RU_'.str_replace('.', '', $arrayOfDates[2]).'_1.xlsx';
		if (!file_exists($sku_prev_file)) { // Если это воскресенье, то отчёт один, значит берём вчерашний день с префиксом 2
			$sku_prev_file = '/var/www/reporter/reports/_big_sku/Report_SKU_'.ucfirst($argv[2]).'_RU_'.str_replace('.', '', $arrayOfDates[0]).'_2.xlsx';
			if (!file_exists($sku_prev_file)) {
				die('Какая-то хуйня с предыдущим файлом'.$sku_prev_file.PHP_EOL);
			}
		}
	} else {
		die('Неизвестное исключение'.PHP_EOL);
	}

	$objSKU = PHPExcel_IOFactory::load($sku_prev_file);
	$sheet = $objSKU->getSheet(0);
	$highestColumn = $sheet->getHighestColumn();
	echo $highestColumn.PHP_EOL;
	$colNumber = PHPExcel_Cell::columnIndexFromString($highestColumn) - 1; // Находим пустую ячейку справа

	echo 'Файл окрыт успешно, начинаю заполнять с колонки: '.$colNumber.PHP_EOL;

	$header_array = array(
		'% Откл.от РРЦ',
		'Общ.Кол-во SKU',
		'Кол-во White SKU',
		'Кол-во Yellow SKU',
		'% Откл.Red SKU от РРЦ',
		'% Red SKU',
		'Кол-во Red SKU',
		);
	$index = 0;

	//print_r(range($colNumber, $colNumber+5));die();

  foreach (range($colNumber, $colNumber+6) as $col) { // Объединяем в группу новые данные (7 ячеек)
    if ($index < 6) {
    	$objSKU->getActiveSheet()->getColumnDimensionByColumn($col)->setOutlineLevel(1)->setVisible(false)->setCollapsed(true); // Создаём группу
    }
    $objSKU->getActiveSheet()->setCellValueByColumnAndRow($col, 5, $header_array[$index]);
    $index++;
  }


	$objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber, 4, str_replace('.', '', $arrayOfDates[2]).'_'.$pref); // Дата данных в шапке
	// Объединим 7 ячеек с датой:
	$cellFrom = $objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber, 4)->getCoordinate();
	$cellTill = $objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+6, 4)->getCoordinate();
	$objSKU->getActiveSheet()->mergeCells($cellFrom.':'.$cellTill);
	// Линии:
	$objSKU->getActiveSheet()->getStyle($cellFrom.':'.$objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+6, 4)->getCoordinate())->applyFromArray(
		array(
			'font' 			=> array(
										          'color' => array('rgb' => 'FFFFFF'),
										          'size'  => 9,
								        			'name'  => 'Verdana'),
			'borders' 	=> array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('rgb' => '000000'))),
			'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER))	
		);
	$objSKU->getActiveSheet()->getStyle($highestColumn.'5:'.$objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+6, 5)->getCoordinate())->applyFromArray(
		array(
			'font' 			=> array(
										          'color' => array('rgb' => '000000'),
										          'size'  => 9,
								        			'name'  => 'Verdana'),
			'borders' 	=> array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('rgb' => '000000'))),
			'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER))	
		);	
	$objSKU->getActiveSheet()->getStyle($highestColumn.'4:'.$objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+6, 5)->getCoordinate())->getAlignment()->setWrapText(true); // Переносить по слогам

	// Шрифт болдом:
	$objSKU->getActiveSheet()->getStyle($cellFrom.':'.$objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+6, 5)->getCoordinate())->getFont()->setBold(true);
	// Разукрасим:
	$objSKU->getActiveSheet()->getStyle($cellFrom.':'.$cellTill)->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'808080'))));
	$objSKU->getActiveSheet()->getStyle($objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+3, 5)->getCoordinate())->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FFFF00'))));
	$objSKU->getActiveSheet()->getStyle($objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+4, 5)->getCoordinate())->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FF0000'))));
	$objSKU->getActiveSheet()->getStyle($objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+5, 5)->getCoordinate())->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FF0000'))));
	$objSKU->getActiveSheet()->getStyle($objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+6, 5)->getCoordinate())->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'FF0000'))));

	$colorCell = $objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+4, 5)->getCoordinate();
	$objSKU->getActiveSheet()->getColumnDimension(preg_replace('/\d/','', $colorCell))->setWidth(10.2);
	$colorCell = $objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+6, 5)->getCoordinate();
	$objSKU->getActiveSheet()->getColumnDimension(preg_replace('/\d/','', $colorCell))->setWidth(11.4);
	

	$objSKU->getActiveSheet()->setSelectedCell('KN');	
	$objSKU->getActiveSheet()->freezePane('D6');


	// Разукраски
	$cellFrom = $objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber, 6)->getCoordinate();
	$cellTill = $objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+6, 613)->getCoordinate();
	// Линии:
	$objSKU->getActiveSheet()->getStyle($cellFrom.':'.$cellTill)->applyFromArray(
		array(
			'font' 			=> array('color' => array('rgb' => '000000'),
										       'size'  => 8,
								        	 'name'  => 'Verdana'),
			'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_CENTER),
			'fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'd8d8d8'))
		));
	// Линии справа, мать их
	foreach (range(0, 6) as $range_value) {
			$cellFrom = $objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+$range_value, 6)->getCoordinate();
			$cellTill = $objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+$range_value, 613)->getCoordinate();
			$objSKU->getActiveSheet()->getStyle($cellFrom.':'.$cellTill)->applyFromArray(
				array(
        'borders' => array(
            'right' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
          )
        )
      )); 
      if ($range_value == 0 || $range_value == 4 || $range_value == 5) {
       	$objSKU->getActiveSheet()->getStyle($cellFrom.':'.$cellTill)->getNumberFormat()->setFormatCode('0%;-0%');
      }
	}


	/**
	 * Основной цикл
	 */

	$next_string = 6;
	foreach ($sites_order as $site) {
		$temp_data_array = array(); // Временных масси всего, что нужно для записи файлика
		$imp_curr_red = array(); // Массив хранит позиции по текущему ГОРОДУ текущего САЙТА, которые уже были, т.е. которые пересекаются. При проверке если есть в этом массиве позиция, то она больше не плюсуется как красная
		$other_curr_red = array(); // Тоже самое, но не ключевые города
		$all_curr_red = array();

		$current_cities = array();
		/*
		foreach ($important_cities as $imc_value) {
			$current_cities[$imc_value]['red'] = 0;
			$current_cities[$imc_value]['yellow'] = 0;
			$current_cities[$imc_value]['white'] = 0;
			$current_cities[$imc_value]['all'] = 0;
			$current_cities[$imc_value]['otkl_ot_rrc'] = array(); // Откл от РРЦ Ключевые города
			$current_cities['otkl_ot_rrc_all'] = array(); // Откл от РРЦ остальные города
			$current_cities[$imc_value]['otkl_red_ot_rrc'] = array(); // Откл Red от РРЦ Ключевые города
			$current_cities['otkl_red_ot_rrc_all'] = array(); // Откл Red от РРЦ остальные города
		}
		*/
		foreach ($tempHeap[$site] as $city => $data_array) { // Перебор ГОРОДОВ внутри текущего САЙТА
			$city_red_index = 0;    // К-во красных цен
			$city_yellow_index = 0;	// К-во желтых цен
			$city_white_index = 0;	// К-во белых цен
			foreach ($data_array as $key => $info) { // Текущий блок ЦЕН в рамках контекста САЙТА и ГОРОДА
				/*
				echo 'site: '.$site.PHP_EOL;
				echo 'city: '.$city.PHP_EOL;
				print_r($info);
				die();
				*/
				$divergency = (int)$info[5]/(int)$info[4];



				/**
				 * КРАСНАЯ ЦЕНА КРАСНАЯ ЦЕНА КРАСНАЯ ЦЕНА КРАСНАЯ ЦЕНА КРАСНАЯ ЦЕНА КРАСНАЯ ЦЕНА 
				 */
				if ($divergency <= 0.9) { // Красная цена
					$city_red_index++;
					$all_curr_red[] = $info[3]; // Все красные, добавляем, потом оставим только уникальные, получится пересечения
					/**
					 * КЛЮЧЕВОЙ город
					 */
					if (in_array($city, $important_cities)) { // Если Ключевой Город
						$imp_curr_red[] = $info[3]; //
						$current_cities[$city]['red']++;
						$current_cities[$city]['otkl_ot_rrc'][] = $divergency-1; // Общий процент отклонений
						$current_cities[$city]['otkl_red_ot_rrc'][] = $divergency-1; // RED процент отклонений
						$current_cities['otkl_ot_rrc_main_cities'][] = $divergency-1;
						// 29.06.17
						// Накапливаем Красные Цены для Ключевых городов с учётом пересечений ассортимента
						$current_cities['main_cities_red'][$info[3]] = $divergency-1;
					/**
					 * Обычный город
					 */	
					} else { // Если Обычный Город
						$other_curr_red[] = $info[3];
						$current_cities['otkl_ot_rrc_other_cities'][] = $divergency-1; 		// Общий процент отклонений остальные города
						// 29.06.17
						// Накапливаем Красные Цены для Остальных городов с учётом пересечений ассортимента
						$current_cities['other_cities_red'][$info[3]] = $divergency-1;
					}
					/**
					 * ВСЕ ГОРОДА
					 */
					$current_cities['otkl_ot_rrc_all'][] = $divergency-1; 		// Общий процент отклонений остальные города
					// 29.06.17
					// Накапливаем Красные Цены для Остальных городов с учётом пересечений ассортимента
					$current_cities['all_cities_red'][$info[3]] = $divergency-1;					
				
					$current_cities['otkl_red_ot_rrc_all'][$info[3]] = $divergency-1; // RED % отклонений все города


				/**
				 * ЖЕЛТАЯ ЦЕНА ЖЕЛТАЯ ЦЕНА ЖЕЛТАЯ ЦЕНА ЖЕЛТАЯ ЦЕНА ЖЕЛТАЯ ЦЕНА ЖЕЛТАЯ ЦЕНА ЖЕЛТАЯ ЦЕНА 
				 */					
				} elseif (($divergency > 0.9 && $divergency <= 0.97)) { // Жёлтая цена
					$city_yellow_index++;
					/**
					 * КЛЮЧЕВОЙ город
					 */					
					if (in_array($city, $important_cities)) {
						$current_cities[$city]['yellow']++;
						$current_cities[$city]['otkl_ot_rrc'][] = $divergency-1; // Общий процент отклонений
						$current_cities['otkl_ot_rrc_main_cities'][] = $divergency-1;
						$yellow_main++;
					/**
					 * Обычный город
					 */							
					} else {
						$current_cities['otkl_ot_rrc_other_cities'][] = $divergency-1; 		// Общий процент отклонений остальные города
						$yellow_other++;
					}
					/**
					 * ВСЕ ГОРОДА
					 */
					$current_cities['otkl_ot_rrc_all'][] = $divergency-1; 		// Общий процент отклонений остальные города
					$yellow_all++;


				/**
				 * БЕЛАЯ ЦЕНА БЕЛАЯ ЦЕНА БЕЛАЯ ЦЕНА БЕЛАЯ ЦЕНА БЕЛАЯ ЦЕНА БЕЛАЯ ЦЕНА БЕЛАЯ ЦЕНА БЕЛАЯ ЦЕНА
				 */	
				} else { // Белая цена
					$city_white_index++;
					/**
					 * КЛЮЧЕВОЙ город
					 */					
					if (in_array($city, $important_cities)) { // Если Ключевой Город
						$current_cities[$city]['white']++;
						$current_cities[$city]['otkl_ot_rrc'][] = $divergency-1; // Общий процент отклонений
						$current_cities['otkl_ot_rrc_main_cities'][] = $divergency-1;
						$white_main++;
					/**
					 * Обычный город
					 */						
					} else { // Если Обычный Город
						$current_cities['otkl_ot_rrc_other_cities'][] = $divergency-1; 		// Общий процент отклонений остальные города
						$white_other++;
					}
					/**
					 * ВСЕ ГОРОДА
					 */					
					$current_cities['otkl_ot_rrc_all'][] = $divergency-1; 		// Общий процент отклонений остальные города
					$white_all++;
				}		

				$all_prices++;
				if (in_array($city, $important_cities)) {
					$all_prices_main++;
				} else {
					$all_prices_other++;
				}


				// Общее к-во цен: ???????????????
				if (in_array($city, $important_cities)) {
					$current_cities[$city]['all']++;//?????????????????
				} else {
					$current_other_cities[$city]++;
				}

			}// Текущий блок ЦЕН в рамках контекста САЙТА и ГОРОДА
			
			$all_prices_arr[] 			= $all_prices; // Общее к-во цен, МАКСИМУМ:
			//if (in_array($city, $important_cities)) {
				$all_prices_main_arr[] 	= $all_prices_main; // Ключ  к-во цен, МАКСИМУМ:
			//} else {
				$all_prices_other_arr[] = $all_prices_other; // Остальные к-во цен, МАКСИМУМ:
			//}
			
			$all_prices = 0;
			$all_prices_main = 0;
			$all_prices_other = 0;

			// WHITE
			$white_all_arr[] = $white_all;
			//if (in_array($city, $important_cities)) {
				$white_main_arr[] = $white_main;
			//} else {
				$white_other_arr[] = $white_other;
			//}
				
			$white_all = 0;
			$white_main = 0;
			$white_other = 0;

			// YELLOW
			$yellow_all_arr[] = $yellow_all;
			//if (in_array($city, $important_cities)) {
				$yellow_main_arr[] = $yellow_main;
			//} else {
				$yellow_other_arr[] = $yellow_other;
			//}
			
			$yellow_all = 0;
			$yellow_main = 0;
			$yellow_other = 0;			

		}// Перебор ГОРОДОВ внутри текущего САЙТА
		


		
		// RED ??? Возможно не правильно считаю максимум
		$all_prices_max = max($all_prices_arr); // Максимум цен
		$all_prices_main_max = max($all_prices_main_arr); // Максимум цен Ключевые
		$all_prices_other_max = max($all_prices_other_arr); // Максимум цен Остальные

		// WHITE
		$white_prices_max = max($white_all_arr); // Максимум цен
		$white_prices_main_max = max($white_main_arr); // Максимум цен Ключевые
		$white_prices_other_max = max($white_other_arr); // Максимум цен Остальные

		// YELLOW
		$yellow_prices_max = max($yellow_all_arr); // Максимум цен
		$yellow_prices_main_max = max($yellow_main_arr); // Максимум цен Ключевые
		$yellow_prices_other_max = max($yellow_other_arr); // Максимум цен Остальные



		// Обнуляем массивы
		$all_prices_arr = array();
		$all_prices_main_arr = array();
		$all_prices_other_arr = array();
		$white_all_arr = array();
		$white_main_arr = array();
		$white_other_arr = array();
		$yellow_all_arr = array();
		$yellow_main_arr = array();
		$yellow_other_arr = array();





		/**
		 * Добавить запись в файл
		 */
		$all_curr_red = array_unique($all_curr_red); 			// Кол-во Red SKU / Все города
		$other_curr_red = array_unique($other_curr_red); 	// Кол-во Red SKU / Прочие города города
		$imp_curr_red = array_unique($imp_curr_red); 			// Кол-во Red SKU / Ключевые города
		

		echo 'site: '.$site.PHP_EOL;
		echo 'ВСЕ Города: '.count($all_curr_red).PHP_EOL;
		echo 'Прочие города: '.count($other_curr_red).PHP_EOL; // 
		echo 'Ключевые Города: '.count($imp_curr_red).PHP_EOL;
		//print_r($current_cities); // Ключевые города Red, Yellow, White и Все цены
		//die(); 
		//print_r($current_other_cities); // К-во
		echo 'ВСЕ Города / Общ.Кол-во SKU: '.max($current_other_cities).PHP_EOL;
		echo '/------------------/'.PHP_EOL;



		// % отклонений RED Все города. Перепишем массив в индексный, чтобы можно было посчитать среднее
		$otkl_proc_ot_red_all = array();
		if ($current_cities['otkl_red_ot_rrc_all']) {
			foreach ($current_cities['otkl_red_ot_rrc_all'] as $r_all_key => $r_all_value) {
				$otkl_proc_ot_red_all[] = $r_all_value;
			}
		}
		$otkl_proc_ot_red_main = array();
		if ($current_cities['main_cities_red']) {
			foreach ($current_cities['main_cities_red'] as $r_main_key => $r_main_value) {
				$otkl_proc_ot_red_main[] = $r_main_value;
			}
		}
		$otkl_proc_ot_red_other = array();
		if ($current_cities['other_cities_red']) {
			foreach ($current_cities['other_cities_red'] as $r_other_key => $r_other_value) {
				$otkl_proc_ot_red_other[] = $r_other_value;
			}
		}




		$odd = 1;
		foreach ($important_cities as $ins_city_value) { // Начинаем заполнять данные в xlsx файл. Перебираем ГОРОДА в рамках МАГАЗИНА
			// Ключевые города:
			if ($current_cities[$ins_city_value]['otkl_ot_rrc']) {
				$objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber, $next_string, array_sum($current_cities[$ins_city_value]['otkl_ot_rrc'])/count($current_cities[$ins_city_value]['otkl_ot_rrc'])); // % Откл.от РРЦ
			}
			$objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+1, $next_string, $current_cities[$ins_city_value]['all']); // Общ.Кол-во SKU
			$objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+2, $next_string, $current_cities[$ins_city_value]['white']); // Кол-во White SKU
			$objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+3, $next_string, $current_cities[$ins_city_value]['yellow']); // Кол-во Yellow SKU
			if ($current_cities[$ins_city_value]['otkl_red_ot_rrc']) {
				$objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+4, $next_string, array_sum($current_cities[$ins_city_value]['otkl_red_ot_rrc'])/count($current_cities[$ins_city_value]['otkl_red_ot_rrc'])); // % Откл.Red SKU от РРЦ 
			}
			if ($current_cities[$ins_city_value]['red']) {
				$objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+5, $next_string, $current_cities[$ins_city_value]['red']/$current_cities[$ins_city_value]['all']); // % Red SKU
			}
			if ($current_cities[$ins_city_value]['red']) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+6, $next_string, $current_cities[$ins_city_value]['red']); // Кол-во Red SKU
			$next_string++;

			// Белые - серые полосы
			$cellFrom = $objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber, 	 $next_string)->getCoordinate();
			$cellTill = $objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+6, $next_string)->getCoordinate();
			if ($odd%2 == 0) {
				$objSKU->getActiveSheet()->getStyle($cellFrom.':'.$cellTill)->applyFromArray(
					array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'D8D8D8'))));
			} else {
				$objSKU->getActiveSheet()->getStyle($cellFrom.':'.$cellTill)->applyFromArray(
					array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'FFFFFF'))));
			}
			$odd++;
		}













		/**
		 * Ключевые Города
		 */ 
		// Ключевые Города | % Откл.от РРЦ
		if ($current_cities['otkl_ot_rrc_main_cities'])	$objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+0, $next_string, array_sum($current_cities['otkl_ot_rrc_main_cities'])/count($current_cities['otkl_ot_rrc_main_cities']));
		// Ключевые Города | Общ.Кол-во SKU
		if ($all_prices_main_max) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+1, $next_string, $all_prices_main_max); 
		// Ключевые Города | Кол-во White SKU
		if ($white_prices_main_max) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+2, $next_string, $white_prices_main_max);
		// Ключевые Города | Кол-во Yellow SKU
		if ($yellow_prices_main_max) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+3, $next_string, $yellow_prices_main_max);
		// Ключевые Города | % Откл.Red SKU от РРЦ
		if ($otkl_proc_ot_red_main) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+4, $next_string, array_sum($otkl_proc_ot_red_main)/count($otkl_proc_ot_red_main));
		// Ключевые Города | % Red SKU
		if ($all_prices_main_max) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+5, $next_string, count($current_cities['main_cities_red'])/$all_prices_main_max);
		// Ключевые Города | Кол-во Red SKU
		if (count($current_cities['main_cities_red'])) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+6, $next_string, count($current_cities['main_cities_red']));
		

		$cellFrom = $objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber, 	 $next_string)->getCoordinate();
		$cellTill = $objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+6, $next_string)->getCoordinate();
		$objSKU->getActiveSheet()->getStyle($cellFrom.':'.$cellTill)->applyFromArray(
    array(
        'borders' => array(
            'top' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
          )
        )
    	)
		);

		$next_string++;
	



		/**
		  * Прочие города
		  */
		// ВСЕ Города | % Откл.от РРЦ
		if ($current_cities['otkl_ot_rrc_other_cities']) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+0, $next_string, array_sum($current_cities['otkl_ot_rrc_other_cities'])/count($current_cities['otkl_ot_rrc_other_cities']));
		// Прочие Города | Общ.Кол-во SKU
		if ($all_prices_other_max) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+1, $next_string, $all_prices_other_max);
		// Прочие Города | Кол-во White SKU
		if ($white_prices_other_max) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+2, $next_string, $white_prices_other_max);
		// Прочие Города | Кол-во Yellow SKU
		if ($yellow_prices_other_max) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+3, $next_string, $yellow_prices_other_max);
		// Прочие Города | % Откл.Red SKU от РРЦ
		if ($otkl_proc_ot_red_other) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+4, $next_string, array_sum($otkl_proc_ot_red_other)/count($otkl_proc_ot_red_other));
		// Прочие Города | % Red SKU
		if ($all_prices_other_max) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+5, $next_string, count($current_cities['other_cities_red'])/$all_prices_other_max);
		// Прочие Города | Кол-во Red SKU
		if (count($current_cities['other_cities_red'])) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+6, $next_string, count($current_cities['other_cities_red']));
		
		$cellFrom = $objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber, 	 $next_string)->getCoordinate();
		$cellTill = $objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+6, $next_string)->getCoordinate();
		$objSKU->getActiveSheet()->getStyle($cellFrom.':'.$cellTill)->applyFromArray(
					array('fill' => array('type'  => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb' => 'FFFFFF'))));
		
		$next_string++;




		/**
		  * ВСЕ Города
		  */
		// ВСЕ Города | % Откл.от РРЦ
		if ($current_cities['otkl_ot_rrc_all']) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+0, $next_string, array_sum($current_cities['otkl_ot_rrc_all'])/count($current_cities['otkl_ot_rrc_all']));
		// ВСЕ Города | Общ.Кол-во SKU
		if ($all_prices_max) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+1, $next_string, $all_prices_max);
		// ВСЕ Города | Кол-во White SKU
		if ($white_prices_max) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+2, $next_string, $white_prices_max);
		// ВСЕ Города | Кол-во Yellow SKU
		if ($yellow_prices_max) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+3, $next_string, $yellow_prices_max);
		// ВСЕ Города | % Откл.Red SKU от РРЦ
		if ($otkl_proc_ot_red_all) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+4, $next_string, array_sum($otkl_proc_ot_red_all)/count($otkl_proc_ot_red_all));
		// ВСЕ Города | % Red SKU
		if ($all_prices_max) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+5, $next_string, count($current_cities['all_cities_red'])/$all_prices_max);
		// ВСЕ Города | Кол-во Red SKU
		if (count($current_cities['all_cities_red'])) $objSKU->getActiveSheet()->setCellValueByColumnAndRow($colNumber+6, $next_string, count($current_cities['all_cities_red']));


		$cellFrom = $objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber, 	 $next_string)->getCoordinate();
		$cellTill = $objSKU->getActiveSheet()->getCellByColumnAndRow($colNumber+6, $next_string)->getCoordinate();
		$objSKU->getActiveSheet()->getStyle($cellFrom.':'.$cellTill)->applyFromArray(
    array(
        'borders' => array(
            'bottom' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('rgb' => '000000')
          )
        )
    	)
		);
		$objSKU->getActiveSheet()->getStyle($cellFrom.':'.$cellTill)->getFont()->setBold(true);
		$next_string++;
	}


	/**
	 * ./ Основной цикл
	 */	


	echo 'Saving...';
	$objWriter = new PHPExcel_Writer_Excel2007($objSKU);
	$fileName = 'Report_SKU_'.ucfirst($argv[2]).'_RU_'.str_replace('.', '', $arrayOfDates[2]).'_'.$argv[3].'.xlsx';
	$objWriter->save('/var/www/reporter/reports/_big_sku/'.$fileName);




	echo microtime(1)-$timer.PHP_EOL;
