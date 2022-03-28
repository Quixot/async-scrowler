<?php
/**
 * XML для Polaris
 */
	include( '/var/www/lib/functions.php' );
	include( '/var/www/lib/PHPExcel.php' );
	include( '/var/www/lib/PHPExcel/Writer/Excel2007.php' );

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	include('/var/www/lib/PHPMailer-6.0.2/src/Exception.php');
	include('/var/www/lib/PHPMailer-6.0.2/src/PHPMailer.php');
	include('/var/www/lib/PHPMailer-6.0.2/src/SMTP.php');

	$timer = microtime(1);
	$date = date('d.m.y');

	// Загружаем инфу с сайта зайдя в профиль
	//$proxarr = get_proxy_and_ua('/var/www/lib/proxies/16.proxy', '/var/www/lib/useragents_short.txt');
	//dprint_r($proxarr);

	//$cmd = 'timeout -k 60s 61s casperjs /var/www/polaris/engines/wildberries.ru/casper.js '.escapeshellarg($url).' '.escapeshellarg($proxarr['ua']).' '.$proxarr['address'].' '.$proxarr['port'].' '.$proxarr['login'].' '.$proxarr['password'];
	

	
	
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
	$sheet = $objPHPExcel->getSheet(0);
	//$qountity = $sheet->getCell( 'G1' )->getOldCalculatedValue();
	$qountity = $sheet->getHighestRow(); // Сколько строк
	echo 'массив с ценами РИЦ: '.$qountity.PHP_EOL;
	$data = $sheet->rangeToArray('A2:H'.$qountity);
	$i = 0;
	foreach ($data as $row) {
	  $priceArray[$row[1].'_'.$row[4]] = array($row[0], $row[1], $row[5], $row[2], $row[3], $row[6], $row[7], $row[4]); 
	  // REALNAME POSITION CODE REALRICE Тип Наименование товара
	}

	//print_r($priceArray); die();
	file_put_contents('/var/www/polaris/engines/wildberries.ru/pricearray.txt', print_r($priceArray, 1));
	$pathes = array(
		'/var/www/polaris/engines/wildberries.ru/data/'.$date.'_wildberries.ru_polaris_moscow.data',
		'/var/www/polaris/engines/wildberries.ru/data_profile/'.$date.'_wildberries.ru.profile_polaris_moscow.data',
		);

	for ($i=0; $i <=1 ; $i++) {
		preg_match("~engines/(.+)/.*polaris_(.+).data~isU", $pathes[$i], $matches);
		if ($i == 0) {
			$STORE = 'wildberries.ru';
		} else {
			$STORE = 'wildberries.ru.profile';
		}
		$CITY  = 'moscow';

		if (file_exists($pathes[$i]) && $CITY == 'moscow') { // Если data файлик реально существует, обрабатываем его
			//echo 'Current: '.$STORE.'_'.$CITY.PHP_EOL;
			//echo $pathes[$i].PHP_EOL;
			echo PHP_EOL.' '.$matches[1].PHP_EOL.' ';
			$current_row_array = unserialize(file_get_contents($pathes[$i])); // Массив текущего магазина/города


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
					$NAME 		  = substr($keyREALNAME[$key], stripos($keyREALNAME[$key], '_') - 1);
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
					//echo $CITY.PHP_EOL;				// Current City
					//echo $CITY_RU.PHP_EOL;		// RU city name
					//echo $STORE.PHP_EOL;			// Current Store
					echo '*******'.PHP_EOL;	
					
					*/

					if ($URL && $CODE && $PRICE && $REALPRICE) {
						$itemsArray[$CODE][$STORE] = array($URL, $NAME, $PRICE, $REALPRICE);
					}
				}
			}
			preg_match("~data/.*_(.+).data~isU", $pathes[$i], $matches);
			
		}
	}
	//file_put_contents('/var/www/polaris/engines/wildberries.ru/itemsarray.txt', print_r($itemsArray, 1));

	

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
	//$shop->appendChild($xml->createElement('time', date("d.m.y H:i:s", filemtime('/var/www/polaris/engines/wildberries.ru/data_profile/'.date('d.m.y').'_wildberries.ru.profile_polaris_moscow.data')+3600))); // Разница с Москвой

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

	foreach ($client_xml['shop']->offers->offer as $val) { // Основной цикл на базе файлика клиента
		
		$url = trim($val->url);
		$name = trim($val->model);
		$model = trim($val->artikul);
		$price = trim($val->price);
		$artroz = trim($val->artroz);

		if (count($val->axid) < 2) {
			$code = trim($val->axid);
			//echo 'COde: '.$code.PHP_EOL;die();
			if (@$itemsArray[$code]) {
				// OFFER ID
				$offer = $offers->appendChild($xml->createElement('offer'));
				$offer_id = $xml->createAttribute('id');
				$offer_id->value = $artroz;///xml_attribute($val, 'axid');
				$offer->appendChild($offer_id);

				// OTHER INS OFFER
				
				$art = $offer->appendChild($xml->createElement('art', $code));
				$artroz = $offer->appendChild($xml->createElement('artroz', $artroz));

				$name = $offer->appendChild($xml->createElement('name', $name));
				$model_ins = $offer->appendChild($xml->createElement('model', $model));	
/*
				echo $itemsArray[$code]['wildberries.ru'][3].PHP_EOL;
				echo $itemsArray[$code]['wildberries.ru'][2].PHP_EOL;
				echo $itemsArray[$code]['wildberries.ru.profile'][2].PHP_EOL;
*/
				
				$price_reg = $offer->appendChild($xml->createElement('price_Regular', $itemsArray[$code]['wildberries.ru'][2]));
				$price_clb = $offer->appendChild($xml->createElement('price_Club', $itemsArray[$code]['wildberries.ru.profile'][2]));
				$price_rrp = $offer->appendChild($xml->createElement('price_RRP', $itemsArray[$code]['wildberries.ru'][3]));

				//print_r($itemsArray[$code]);die();
				
				$url = $offer->appendChild($xml->createElement('url', $itemsArray[$code]['wildberries.ru'][0]));
			}
			
		} else { // Если много вариантов <axid>
			

			foreach ($val->axid as $axid_val) {
				$axid_val = trim($axid_val);
				//echo $axid_val.PHP_EOL;
				//print_r($name);

				$url = trim($val->url);
				$name = trim($val->model);
				$model = trim($val->artikul);
				$price = trim($val->price);
				$artroz = trim($val->artroz);

				if (@$itemsArray[$axid_val]) {

					// OFFER ID
					$offer = $offers->appendChild($xml->createElement('offer'));
					$offer_id = $xml->createAttribute('id');
					$offer_id->value = $artroz;///xml_attribute($val, 'axid');
					$offer->appendChild($offer_id);

					// OTHER INS OFFER
					
					$art = $offer->appendChild($xml->createElement('art', $axid_val));
					$artroz = $offer->appendChild($xml->createElement('artroz', $axid_val));

					$name = $offer->appendChild($xml->createElement('name', $name));
					$model_ins = $offer->appendChild($xml->createElement('model', $model));		

					
					$price_reg = $offer->appendChild($xml->createElement('price_Regular', $itemsArray[$axid_val]['wildberries.ru'][2]));
					$price_clb = $offer->appendChild($xml->createElement('price_Club', $itemsArray[$axid_val]['wildberries.ru.profile'][2]));
					$price_rrp = $offer->appendChild($xml->createElement('price_RRP', $itemsArray[$axid_val]['wildberries.ru'][3]));

					$url = $offer->appendChild($xml->createElement('url', $itemsArray[$axid_val]['wildberries.ru'][0]));
					$iii = 1;
				}
			}		
		}
	}
	


	echo 'unset $tempHeap'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;
	unset($tempHeap);

	echo 'data array is ready'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;

	$xml->save('/var/www/polaris/engines/wildberries.ru/test.xml');

	sleep(10);

	$session = ssh2_connect('en378.mirohost.net', '22');
	ssh2_auth_password($session, 'plssh', 'Cfyz13Djkrjd');
	//'/var/www/pricinglogix'
	ssh2_scp_send($session, '/var/www/polaris/engines/wildberries.ru/test.xml', '/var/www/pricinglogix/polaris.pricinglogix.com/feed/wildberries.ru.xml');


function xml_attribute($object, $attribute)
{
    if(isset($object[$attribute]))
        return (string) $object[$attribute];
}
