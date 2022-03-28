<?php
/**
 * XML для Polaris
 */
	$timer = microtime(1);
	$date = date('d.m.y');
	$heap_file_path = '/var/www/polaris/heap/'.$date.'_'.$argv[2].'.data';
	echo $heap_file_path;
	$tempHeap = unserialize(file_get_contents($heap_file_path));
	$itemsArray = array();

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

	if ($tempHeap) { // Пересобираем HEAP для удобства поиска
		foreach ($tempHeap as $key => $value) {
			foreach ($value as $key2 => $value2) {
				foreach ($value2 as $info) {
		 			//$itemsArray[$info[1]][$key2][$key][$date] = array($info[4], $info[5], $info[2], $info[3]); 
		 			// КОД -> Город -> Сайт -> Дата  =  РИЦ | Цена магазина | url | Name
					if ($key2 == 'Москва') {
						$itemsArray[$info[7]][$key] = array($info[2], $info[5]);
					}
		 			
				}
			}
		}
		echo microtime(1)-$timer.PHP_EOL;
	} else {
		die('No heap file!');
	}
	
	//print_r($itemsArray); die();
	//file_put_contents('/var/www/reporter/reports/polaris_xml/1.txt', print_r($itemsArray, 1));

	foreach ($client_xml[shop]->offers->offer as $val) { // Основной цикл на базе файлика клиента
		
		$url = trim($val->url);
		$name = trim($val->model);
		$model = trim($val->artikul);
		$price = trim($val->price);
		$artroz = trim($val->artroz);



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
				//echo $axid_val.PHP_EOL;
				$axid_val = trim($axid_val);
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
	


	echo 'unset $tempHeap'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;
	unset($tempHeap);

	echo 'data array is ready'.PHP_EOL;
	echo microtime(1)-$timer.PHP_EOL;

	$xml->save('/var/www/reporter/reports/polaris_xml/test.xml');

	sleep(10);

	$session = ssh2_connect('en378.mirohost.net', '22');
	ssh2_auth_password($session, 'plssh', 'Cfyz13Djkrjd');
	//'/var/www/pricinglogix'
	ssh2_scp_send($session, '/var/www/reporter/reports/polaris_xml/test.xml', '/var/www/pricinglogix/polaris.pricinglogix.com/feed/shop-polaris.xml');


function xml_attribute($object, $attribute)
{
    if(isset($object[$attribute]))
        return (string) $object[$attribute];
}
