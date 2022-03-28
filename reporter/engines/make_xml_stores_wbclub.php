<?php
/**
 * XML для Polaris
 */
	$timer = microtime(1);
	$date = date('d.m.y');

	
	// Загружаем файл с БД нечеткого поиска
	$objPHPExcel = PHPExcel_IOFactory::load('/var/www/reporter/settings/polaris_xml.xlsx');
/**
 * Нечёткий поиск URL NAME CODE
 */
	$sheet = $objPHPExcel->getSheet(3);
	//$qountity = $sheet->getCell( 'D1' )->getOldCalculatedValue(); // Хак для формул
	$qountity = $sheet->getHighestRow(); // Сколько строк
	echo 'Нечёткий поиск: '.$qountity.PHP_EOL;
	$data = $sheet->rangeToArray('A2:C'.$qountity);
	foreach ($data as $row) {
	  $keyURL[]  = $row[0]; // URL
	  $keyNAME[] = $row[1]; // NAME
	  $keyREALNAME[] = $row[2]; // REALNAME
	}


/**
 * Будем открывать файл за файлом и...
 */
	$pathes = glob('/var/www/polaris/engines/*/data*/'.$date.'*polaris*moscow.data');

	$q_of_stores = count($pathes); // Общее к-во
	$istatus = 1;
	

	$allow_stores = array(
		'citilink.ru',
		'dns-shop.ru',
		'technopark.ru',
		'ozon.ru',
		'rbt.ru',
		'technopoint.ru',
		'ru.aliexpress.com',
		'komus.ru',
		'auchan.ru',
		'maxidom.ru',
		'beru.ru',
		'wildberries.ru',
		'wildberries.ru_CLUB',
		'holodilnik.ru',
		'globus.ru',
		'metro-cc.ru',
		'lenta.com',
		'goods.ru',
	);



	$except_arts = array(
'10305506','10505426','10505428','10505427','10505425','10305505',
		);

	foreach ($pathes as $keypath) { // Перебираем каждый файлик

		system('clear');
		echo '[';
		for ($is=1; $is < $istatus*100/$q_of_stores; $is++) { 
			echo '■';	
		}
		for ($is=$istatus*100/$q_of_stores; $is <= 100; $is++) { 
			echo '.';	
		}
		echo ']'.PHP_EOL;
		$istatus++;

		preg_match("~engines/(.+)/.*polaris_(.+).data~isU", $keypath, $matches);
		$STORE = $matches[1];
		if ($STORE == 'wildberries.ru') {
			if (strripos($keypath, 'profile_polaris') !== false) {
				$STORE = 'wildberries.ru_CLUB';
			}
		}
		$CITY  = $matches[2];



		if (file_exists($keypath) && $CITY == 'moscow' && in_array($STORE, $allow_stores)) { // Если data файлик реально существует, обрабатываем его
			//echo 'Current: '.$STORE.'_'.$CITY.PHP_EOL;
			//echo $keypath.PHP_EOL;
			echo PHP_EOL.' '.$matches[1].PHP_EOL.' ';
			$current_row_array = unserialize(file_get_contents($keypath)); // Массив текущего магазина/города


			foreach ($current_row_array as $URL => $content) { // Перебираем позицию за позицией и ищем соответствия с эталонным массивом
				$key = array_search($content[0], $keyNAME);
				if ($key === false) {
					$key = array_search($URL, $keyURL);
				}
				
				$content[1] = preg_replace('~[^\d]+~', '' , $content[1]);
				if ($key !== false && $content[1] > 0) { // Ищем по URL или по NAME
					//$key = array_search($content[0], $keyNAME);
					$REALNAME = $keyREALNAME[$key];

					$V_POSITION = $priceArray[$REALNAME][0];
					$CODE 		  = substr($keyREALNAME[$key], 0, stripos($keyREALNAME[$key], '_'));
					$REALPRICE  = $priceArray[$REALNAME][2];
					$PRICE 			= $content[1];
					if (isset($keyALIAS[$CITY])) {
						$CITY_RU		= trim($keyALIAS[$CITY]);
					}
					/*
					echo '*******'.PHP_EOL;
					echo $URL.PHP_EOL;				// url
					echo $CODE.PHP_EOL;				// client CODE
					echo $REALNAME.PHP_EOL;		// client NAME
					echo $REALPRICE.PHP_EOL;	// client PRICE
					echo $PRICE.PHP_EOL;			// Store 	PRICE
					echo $CITY.PHP_EOL;				// Current City
					echo $CITY_RU.PHP_EOL;		// RU city name
					echo $STORE.PHP_EOL;			// Current Store
					echo '*******'.PHP_EOL;	
					die();
					*/


					if ($URL && $CODE && $PRICE && $STORE && $URL != 'https://www.ozon.ru/product/kupit-utyug-polaris-pir-2285k-goluboy-v-internet-magazine-ozon-tseny-otzyvy-harakteristiki-foto-173327374/'/*$REALPRICE && $PRICE && isset($STORE_ORDER[$STORE][$CITY_RU])*/) {
						$itemsArray[$CODE][$STORE] = array($URL, $PRICE);
						echo '■';
					}

				}
			}
			preg_match("~data/.*_(.+).data~isU", $keypath, $matches);
			
		}
	}

	$client_xml = new SimpleXMLElement(file_get_contents('https://shop-polaris.ru/upload/acrit.exportpro/for_parser.xml'));
	$client_xml = (array)$client_xml;

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
	$shop->appendChild($xml->createElement('parser_end_time', date("d.m.y H:i:s", filemtime($heap_file_path)+3600))); // Разница с Москвой

	$currencies = $shop->appendChild($xml->createElement('currencies'));
	$currency = $currencies->appendChild($xml->createElement('currency'));
	$id = $xml->createAttribute('id');
	$id->value = 'RUB';
	$currency->appendChild($id);

	$offers = $shop->appendChild($xml->createElement('offers'));

	//print_r($tempHeap);
	//die();
	
	//print_r($itemsArray); die();
	//file_put_contents('/var/www/reporter/reports/polaris_xml/1.txt', print_r($itemsArray, 1));

	foreach ($client_xml[shop]->offers->offer as $val) { // Основной цикл на базе файлика клиента
		
		$url = trim($val->url);
		$name = trim($val->model);
		$model = trim($val->artikul);
		$price = trim($val->price);
		$artroz = trim($val->artroz);


		if (!in_array($artroz, $except_arts)) {

			if (count($val->axid) < 2) {
				$code = trim($val->axid);
				if ($itemsArray[$code]) {
					// OFFER ID
					$offer = $offers->appendChild($xml->createElement('offer'));
					$offer_id = $xml->createAttribute('id');
					$offer_id->value = xml_attribute($val, 'id');//$code;///xml_attribute($val, 'axid');
					$offer->appendChild($offer_id);

					// OTHER INS OFFER
					
					$name = $offer->appendChild($xml->createElement('name', $name));
					$model_ins = $offer->appendChild($xml->createElement('model', $model));	

					$artroz = $offer->appendChild($xml->createElement('artroz', $artroz));	

					$prices = $offer->appendChild($xml->createElement('prices'));

					foreach ($itemsArray[$code] as $cl_name => $cl_value) {
						$client = $prices->appendChild($xml->createElement('client'));
						$price = $xml->createAttribute('price');
						$price->value = $cl_value[1];
						$client->appendChild($price);

						$type = $xml->createAttribute('type');
						$type->value = $cl_name;
						$client->appendChild($type);

						$url_ins = $xml->createAttribute('url');
						$url_ins->value = $cl_value[0];
						$client->appendChild($url_ins);
					}

					$url = $offer->appendChild($xml->createElement('url', $url));
				}
				
			} else { // Если много вариантов <axid>
				//print_r($val);

				foreach ($val->axid as $axid_val) {
					$axid_val = trim($axid_val);
					echo $axid_val.PHP_EOL;
					print_r($val);
					print_r($name);

			$url = trim($val->url);
			$name = trim($val->model);
			$model = trim($val->artikul);
			$price = trim($val->price);
			$artroz = trim($val->artroz);

					if (@$itemsArray[$axid_val]) {
						// OFFER ID
						$offer = $offers->appendChild($xml->createElement('offer'));
						$offer_id = $xml->createAttribute('id');
						$offer_id->value = xml_attribute($val, 'id');///xml_attribute($val, 'axid');
						$offer->appendChild($offer_id);

						// OTHER INS OFFER
						
						$name = $offer->appendChild($xml->createElement('name', $name));
						$model_ins = $offer->appendChild($xml->createElement('model', $model));		

						$artroz = $offer->appendChild($xml->createElement('artroz', $artroz));

						$prices = $offer->appendChild($xml->createElement('prices'));

						foreach ($itemsArray[$axid_val] as $cl_name => $cl_value) {
							$client = $prices->appendChild($xml->createElement('client'));
							$price = $xml->createAttribute('price');
							$price->value = $cl_value[1];
							$client->appendChild($price);

							$type = $xml->createAttribute('type');
							$type->value = $cl_name;
							$client->appendChild($type);

							$url_ins = $xml->createAttribute('url');
							$url_ins->value = $cl_value[0];
							$client->appendChild($url_ins);
						}

						$url = $offer->appendChild($xml->createElement('url', $url));
					}
				}
				
			}
		}
	}
	


	echo 'unset $tempHeap'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;
	unset($tempHeap);

	echo 'data array is ready'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;

	$xml->save('/var/www/reporter/reports/polaris_xml/test_wbclub.xml');

	sleep(10);

	$session = ssh2_connect('en378.mirohost.net', '22');
	ssh2_auth_password($session, 'plssh', 'Cfyz13Djkrjd');
	//'/var/www/pricinglogix'
	ssh2_scp_send($session, '/var/www/reporter/reports/polaris_xml/test_wbclub.xml', '/var/www/pricinglogix/polaris.pricinglogix.com/feed/club.xml');


function xml_attribute($object, $attribute)
{
    if(isset($object[$attribute]))
        return (string) $object[$attribute];
}
