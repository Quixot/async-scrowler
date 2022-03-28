<?php
/**
 * goods.ru
 */
switch (EXTRA_PARAM) {
 	case 'moscow': 				$region = '50'; $city = 'Москва и Московская область'; $region_info = '%7B%22displayName%22%3A%22%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B0%20%D0%B8%20%D0%9C%D0%BE%D1%81%D0%BA%D0%BE%D0%B2%D1%81%D0%BA%D0%B0%D1%8F%20%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C%22%2C%22kladrId%22%3A%227700000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A55.755814%2C%22lon%22%3A37.617635%7D%2C%22id%22%3A%2250%22%7D'; break;
 	case 'spb':						$region = '78'; $city = 'Санкт-Петербург'; $region_info = '%7B%22displayName%22%3A%22%D0%A1%D0%B0%D0%BD%D0%BA%D1%82-%D0%9F%D0%B5%D1%82%D0%B5%D1%80%D0%B1%D1%83%D1%80%D0%B3%22%2C%22kladrId%22%3A%227800000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A59.939095%2C%22lon%22%3A30.315868%7D%2C%22id%22%3A%2278%22%7D'; break;
 	case 'novgorod':			$region = '52'; $city = 'Нижегородская область'; $region_info = '%7B%22displayName%22%3A%22%D0%9D%D0%B8%D0%B6%D0%B5%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%D1%81%D0%BA%D0%B0%D1%8F%20%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C%22%2C%22kladrId%22%3A%225200000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A56.3242093%2C%22lon%22%3A44.0053948%7D%2C%22id%22%3A%2252%22%7D'; break;
 	case 'samara':				$region = '63'; $city = 'Самарская область'; $region_info = '%7B%22displayName%22%3A%22%D0%A1%D0%B0%D0%BC%D0%B0%D1%80%D1%81%D0%BA%D0%B0%D1%8F%20%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C%22%2C%22kladrId%22%3A%226300000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A53.27635%2C%22lon%22%3A50.463301%7D%2C%22id%22%3A%2263%22%7D'; break;
 	case 'kazan':					$region = '16'; $city = 'Республика Татарстан'; $region_info = '%7B%22displayName%22%3A%22%D0%A0%D0%B5%D1%81%D0%BF%D1%83%D0%B1%D0%BB%D0%B8%D0%BA%D0%B0%20%D0%A2%D0%B0%D1%82%D0%B0%D1%80%D1%81%D1%82%D0%B0%D0%BD%22%2C%22kladrId%22%3A%221600000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A55.7943877%2C%22lon%22%3A49.1115312%7D%2C%22id%22%3A%2216%22%7D'; break;
 	case 'yekaterinburg':	$region = '66'; $city = 'Свердловская область'; $region_info = '%7B%22displayName%22%3A%22%D0%A1%D0%B2%D0%B5%D1%80%D0%B4%D0%BB%D0%BE%D0%B2%D1%81%D0%BA%D0%B0%D1%8F%20%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C%22%2C%22kladrId%22%3A%226600000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A56.8386326%2C%22lon%22%3A60.6054887%7D%2C%22id%22%3A%2266%22%7D'; break;
 	case 'krasnodar':			$region = '23'; $city = 'Краснодарский край'; $region_info = '%7B%22displayName%22%3A%22%D0%9A%D1%80%D0%B0%D1%81%D0%BD%D0%BE%D0%B4%D0%B0%D1%80%D1%81%D0%BA%D0%B8%D0%B9%20%D0%BA%D1%80%D0%B0%D0%B9%22%2C%22kladrId%22%3A%222300000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A45.040235%2C%22lon%22%3A38.9760801%7D%2C%22id%22%3A%2223%22%7D'; break;
 	case 'rostov':				$region = '61'; $city = 'Ростовская область'; $region_info = '%7B%22displayName%22%3A%22%D0%A0%D0%BE%D1%81%D1%82%D0%BE%D0%B2%D1%81%D0%BA%D0%B0%D1%8F%20%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C%22%2C%22kladrId%22%3A%226100000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A47.2224364%2C%22lon%22%3A39.7187866%7D%2C%22id%22%3A%2261%22%7D'; break;
 	case 'volgograd':			$region = '34'; $city = 'Волгоградская область'; $region_info = '%7B%22displayName%22%3A%22%D0%92%D0%BE%D0%BB%D0%B3%D0%BE%D0%B3%D1%80%D0%B0%D0%B4%D1%81%D0%BA%D0%B0%D1%8F%20%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C%22%2C%22kladrId%22%3A%223400000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A49.615821%2C%22lon%22%3A44.151406%7D%2C%22id%22%3A%2234%22%7D'; break;
 	case 'chelyabinsk':		$region = '74'; $city = 'Челябинская область'; $region_info = '%7B%22displayName%22%3A%22%D0%A7%D0%B5%D0%BB%D1%8F%D0%B1%D0%B8%D0%BD%D1%81%D0%BA%D0%B0%D1%8F%20%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C%22%2C%22kladrId%22%3A%227400000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A55.1603659%2C%22lon%22%3A61.4007858%7D%2C%22id%22%3A%2274%22%7D'; break;
 	case 'ufa':						$region = '02'; $city = 'Республика Башкортостан'; $region_info = '%7B%22displayName%22%3A%22%D0%A0%D0%B5%D1%81%D0%BF%D1%83%D0%B1%D0%BB%D0%B8%D0%BA%D0%B0%20%D0%91%D0%B0%D1%88%D0%BA%D0%BE%D1%80%D1%82%D0%BE%D1%81%D1%82%D0%B0%D0%BD%22%2C%22kladrId%22%3A%220200000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A54.2715%2C%22lon%22%3A56.525537%7D%2C%22id%22%3A%2202%22%7D'; break;
 	case 'cheboksary':		$region = '21'; $city = 'Чувашская Республика'; $region_info = '%7B%22displayName%22%3A%22%D0%A7%D1%83%D0%B2%D0%B0%D1%88%D1%81%D0%BA%D0%B0%D1%8F%20%D0%A0%D0%B5%D1%81%D0%BF%D1%83%D0%B1%D0%BB%D0%B8%D0%BA%D0%B0%22%2C%22kladrId%22%3A%222100000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A55.492023%2C%22lon%22%3A47.086875%7D%2C%22id%22%3A%2221%22%7D'; break;
 	case 'omsk': 					$region = '55'; $city = 'Омская область'; $region_info = '%7B%22displayName%22%3A%22%D0%9E%D0%BC%D1%81%D0%BA%D0%B0%D1%8F%20%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C%22%2C%22kladrId%22%3A%225500000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A54.994143%2C%22lon%22%3A73.370955%7D%2C%22id%22%3A%2255%22%2C%22domain%22%3A%22%22%2C%22subfolder%22%3A%22%22%7D'; break;
 	case 'krasnoyarsk':		$region = '24'; $city = 'Красноярский край'; $region_info = '%7B%22displayName%22%3A%22%D0%9A%D1%80%D0%B0%D1%81%D0%BD%D0%BE%D1%8F%D1%80%D1%81%D0%BA%D0%B8%D0%B9%20%D0%BA%D1%80%D0%B0%D0%B9%22%2C%22kladrId%22%3A%222400000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A56.023831%2C%22lon%22%3A92.862011%7D%2C%22id%22%3A%2224%22%2C%22domain%22%3A%22%22%2C%22subfolder%22%3A%22%22%7D'; break;
 	case 'naberezhnye-chelny': $region = '16'; $city = 'Республика Татарстан'; $region_info = '%7B%22displayName%22%3A%22%D0%A0%D0%B5%D1%81%D0%BF%D1%83%D0%B1%D0%BB%D0%B8%D0%BA%D0%B0%20%D0%A2%D0%B0%D1%82%D0%B0%D1%80%D1%81%D1%82%D0%B0%D0%BD%22%2C%22kladrId%22%3A%221600000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A55.7943877%2C%22lon%22%3A49.1115312%7D%2C%22id%22%3A%2216%22%2C%22domain%22%3A%22kazan%22%2C%22subfolder%22%3A%22%22%7D'; break;
 	case 'novosibirsk': $region = '54'; $city = 'Новосибирская область'; $region_info = '%7B%22displayName%22%3A%22%D0%9D%D0%BE%D0%B2%D0%BE%D1%81%D0%B8%D0%B1%D0%B8%D1%80%D1%81%D0%BA%D0%B0%D1%8F%20%D0%BE%D0%B1%D0%BB%D0%B0%D1%81%D1%82%D1%8C%22%2C%22kladrId%22%3A%225400000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A55.030441%2C%22lon%22%3A82.923031%7D%2C%22id%22%3A%2254%22%2C%22domain%22%3A%22%22%2C%22subfolder%22%3A%22%22%7D'; break;
 	case 'vladivostok': $region = '25'; $city = 'Приморский край'; $region_info = '%7B%22displayName%22%3A%22%D0%9F%D1%80%D0%B8%D0%BC%D0%BE%D1%80%D1%81%D0%BA%D0%B8%D0%B9%20%D0%BA%D1%80%D0%B0%D0%B9%22%2C%22kladrId%22%3A%222500000000000%22%2C%22isDeliveryEnabled%22%3Atrue%2C%22geo%22%3A%7B%22lat%22%3A45.04198%2C%22lon%22%3A134.709375%7D%2C%22id%22%3A%2225%22%2C%22domain%22%3A%22%22%2C%22subfolder%22%3A%22%22%7D'; break;

 	default:
 		die("Unknown region\n"); 		
}


$merch_id = array(
	'2887' => 'Холодильник'
);

	$urlStart = 'https://goods.ru/catalog/page-';
	$urlEnd = '/?q=polaris';
	$regexpP1	 = "~class=\"pagination\"(.+)</nav>~isU";
	$regexpP2  = "~<a.*>(.+)<~isU";
	$regexpPrices  = "~<article(.+)</article>~isU";
	$regexpPrices2 = "~itemprop=\"url\".*href=\"(.+)\".*>(.+)<.*content=\"RUB\">(.+)<~isU";
	$regexpPrices3 = "~itemprop=\"url\".*href=\"(.+)\".*>(.+)<~isU";
	$regexpRegion = "~\"region\":\"(.+)\"~isU";

	$options = array(
       	CURLOPT_COOKIEFILE      => '/var/www/polaris/engines/sbermegamarket.ru/cook.txt',
       	CURLOPT_COOKIE => 'region_id='.$region.';region_info='.$region_info,
       	//CURLOPT_COOKIEJAR      	=> '/var/www/polaris/engines/xxx/cookies_'.EXTRA_PARAM.'.txt',
        CURLOPT_AUTOREFERER     => true,
        CURLOPT_FOLLOWLOCATION  => true,
				CURLOPT_CONNECTTIMEOUT => 20,
				CURLOPT_TIMEOUT        => 20, 
				CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => 0   
    );


	foreach ($itemsArray as $key => $value) {
		$date = DateTime::createFromFormat('d.m.y-H:i:s', $value[2]);
		//echo (time() - $date->format('U')).PHP_EOL; 
		if (time() - $date->format('U') <= 7000) {
			$already_scanned[] = $value[5];
		}
		
	}
	if ($already_scanned) {
		$already_scanned = array_unique($already_scanned);
		$already_scanned = array_values($already_scanned);
		//print_r($already_scanned); 
	} else {
		$already_scanned = array();
	}
	//$already_scanned = array();


$links = array(

"https://sbermegamarket.ru/catalog/chajniki-elektricheskie/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
/*"https://sbermegamarket.ru/catalog/termopoty/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/elektrogrili/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/mikrovolnovye-pechi-solo/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/multivarki/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/parovarki/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/myasorubki/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/pogruzhnye-blendery/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/blendery-stacionarnye/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/planetarnye-miksery/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/miksery-s-chashey/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/miksery-ruchnye/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/aksessuary-dlya-mikserov-i-blenderov/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/sokovyzhimalki-centrobezhnye/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/tostery/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/multipekar/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/elektrovafelnicy/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/sendvichnicy/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/sushilki-dlya-ovoshey-i-fruktov/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/vesy-kuhonnye/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/aksessuary-dlya-kombajnov-i-myasorubok/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/roboty-pylesosy/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/besprovodnye-pylesosy/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/vertikalnye-pylesosy/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/pylesosy-bez-meshka-dlya-sbora-pyli/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/pylesosy-s-pylesbornikom/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/utyugi/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/parogeneratory/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/otparivateli/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/parovye-ochistiteli/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/filtry-dlya-pylesosv/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/meshki-dlya-pylesosov/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/nasadki-dlya-pylesosov/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/shetki-dlya-pylesosov/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/kofemashiny-kapsulnogo-tipa/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/kofevarki-rozhkovogo-tipa/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/kofevarki-kapelnogo-tipa/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/kofemolki/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/feny/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/fen-shetki/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/elektroshipcy/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/vypryamiteli-volos/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/multistajlery/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/mashinki-dlya-strizhki-volos/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/trimmery/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/napolnye-vesy/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/elektricheskie-zubnye-shetki/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/elektricheskaya-rolikovye-pilki/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/manikyurnye-nabory-elektricheskie/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/konvektory/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/radiatory/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/teploventilyatory/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/ventilyatory-napolnye/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/ventilyatory-nastolnye/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/vodonagrevateli-nakopitelnye/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/vodonagrevateli-protochnye/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/vozduhoochistiteli/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/vozduhouvlazhniteli/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/moyki-vozduha/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/klimaticheskie-kompleksy/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/aksessuary-dlya-vozduhoochistitelej/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/kolodki-tormoznye-diskovye/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/remni-variatora-dlya-kvadrociklov/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/samokaty-detskie-trehkolesnye/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/lampy-dlya-manikyura-i-pedikyura/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/manikyurnye-nabory-elektricheskie/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/elektricheskaya-rolikovye-pilki/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/manikyurnye-nabory-elektricheskie/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/nabory-nozhey/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/nabory-kuhonnyh-prinadlezhnostey/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/zazhigalki-dlya-gazovyh-plit/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/skovorody-gril/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/skovorody-vok/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/skovorody-dlya-blinov/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/sotejniki/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/kovshi/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/kastryuli-iz-nerzhaveyushey-stali/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/alyuminievye-kastryuli/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/formy-dlya-vypechki/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/kryshki-dlya-posudy/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/chajniki-dlya-plity/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/french-pressy/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/geyzernye-kofevarki/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/vodonagrevateli-nakopitelnye/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/vodonagrevateli-protochnye/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/infrakrasnye-obogrevateli/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/elektrosamokaty-2463684633781217/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/elektrosamokaty-2463684633781217/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/samokaty-detskie-trehkolesnye/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",
"https://sbermegamarket.ru/catalog/elektrovelosipedy/brand-polaris/#?filters={%222B0B1FF4756D49CF84B094522D57ED3D%22:[%22Polaris%22],%224CB2C27EAAFC4EB39378C4B7487E6C9E%22:[%221%22]}",/**/
);
	foreach ($links as $url) {
		if (!in_array($url, $already_scanned)) {
			echo 'сканирую адрес:'.PHP_EOL.$url.PHP_EOL;
			$AC->get($url, null, $options);
			$is_any = 1;
		} else {
			echo 'уже сканировал:'.PHP_EOL.$url.PHP_EOL;
		}
	}
		if ($is_any) {
			$AC->execute(WINDOW_SIZE);
		}

	while ($bad_urls) {
	  $AC->flush_requests();
	  foreach ($bad_urls as $urls) {
	    $AC->get($urls, NULL, $options);  
	  }
	  unset($urls);

	  $bad_urls = array();
	  $AC->execute(WINDOW_SIZE);
	}
	unset($urls);



	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';
	


/** 
 *              Callback Functions           
 */
function callback_one($response, $info, $request) {
	global $regexpP1;
	global $regexpP2;
	global $regexpPrices;
	global $regexpPrices2;
	global $regexpPrices3;
	global $regexpRegion;
	global $city;
	global $qOfPaginationPages;
	global $itemsArray;
	global $bad_urls;
	global $time_start;


	AngryCurl::add_debug_msg(PHP_EOL.$request->url);
	AngryCurl::add_debug_msg($info['http_code']);
	AngryCurl::add_debug_msg($request->options[10004]);	

  if ($info['http_code'] !== 200) {
  	if ($info['http_code'] !== 404) {
	    $bad_urls[] = $request->url;
			if (round(microtime(1) - $time_start, 0) >= 300) { $bad_urls = array(); }  
		}  
  } else {
  	file_put_contents('/var/www/polaris/engines/sbermegamarket.ru/content.txt', $response);
  	preg_match("~window.application.state(.+)window.application.selectedFilters~isU", $response, $matches);
  	$variant = 1;
  	if (!$matches) {
  		preg_match("~apiBaseUrl(.+)</script>~isU", $response, $matches);
  		$variant = 2;
  	}
  	//print_r($matches); die();

  	//print_r($matches); die();
  	preg_match_all('~"name":"(.+)".*"url":"(.+)".*"final_price":(.+),.*merchant_name":"(.+)".*"stock":(.+),~isU', $matches[1], $mcode, PREG_SET_ORDER);
  	
  	//file_put_contents('/var/www/polaris/engines/goods.ru/json.txt', print_r($mcode, 1));
  	if (!$mcode) {
  		preg_match_all('~goodsId.*"title":"(.+)".*"webUrl":"(.+)".*"stocks":(.+),.*"finalPrice":(.+),.*merchantId":"(.+)"~isU', $matches[1], $mcode, PREG_SET_ORDER);
  		
  	}
  	print_r($mcode);
  	//print($variant);
  	//die();

  	




  	preg_match($regexpRegion, $response, $mReg);
  	if (!$mReg) {
  		preg_match("~\"displayName\":\"(.+)\"~isU", $response, $mReg);
  	}
  	if (!$mReg) preg_match("~class=\"region-trigger\".*span>(.+)<~isU", $response, $mReg);
  	
  	$mReg[1] = trim($mReg[1]);

  	AngryCurl::add_debug_msg($mReg[1].' | '.$city);
  	//die();
  	
  	if ($mReg[1] == $city) {
  		//print_r($value);
		  foreach ($mcode as $key => $value) {
		  	//print_r($value);
					
				if ($variant == 1) {
					if (stripos($value[4], '2887') !== false && $value[1] && $value[3]) { //'Официальный интернет-магазин Polaris'
						$address = 'https://sbermegamarket.ru'.trim(stripcslashes($value[2]));
						$address = str_replace('\u002F', '\\', $address);
						$value[1] = trim(str_replace('\u002F', '\\', $value[1]));
						$value[3] = trim($value[3]);

						price_change_detect(
							$address, $value[1], $value[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE
						);
						$itemsArray[$address] = array(
							$value[1], $value[3], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url
						);
						AngryCurl::add_debug_msg($address.' | '.$value[1].' | '.$value[3]);
					}
				} else {
					if (stripos($value[5], '2887') !== false && $value[1] && $value[3]) {
						$address = str_replace('\u002F', '\\', $value[2]);
						$value[1] = trim(str_replace('\u002F', '\\', $value[1]));
						$value[4] = trim($value[4]);

						price_change_detect(
							$address, $value[1], $value[4], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10006], $request->options[10018], ENGINE_CURR, ENGINE_TYPE
						);
						$itemsArray[$address] = array(
							$value[1], $value[4], date("d.m.y-H:i:s"), $request->options[10004], $request->options[10018], $request->url
						);
						AngryCurl::add_debug_msg($address.' | '.$value[1].' | '.$value[4]);	
					}					
				}

				
			}
			file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data', serialize($itemsArray));
	  }
	}
}
