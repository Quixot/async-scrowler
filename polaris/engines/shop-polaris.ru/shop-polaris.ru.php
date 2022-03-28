<?php
/**
 * shop-polaris.ru
 */
$itemsArray = array();
//casperjs /var/www/polaris/engines/shop-polaris.ru/casper.js 'https://shop-polaris.ru/' 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36' 37.230.138.253 443 2vkxCV33D hv4MzSQeE 'Челябинск'

//$itemsArray = unserialize(file_get_contents('/var/www/polaris/engines/shop-polaris.ru/data/25.09.19_shop-polaris.ru_polaris_novosibirsk.data'));

//$xml = file_get_contents('https://shop-polaris.ru/upload/acrit.exportpro/for_parser.xml');
$regions = array('moscow', 'spb', 'rostov', 'novosibirsk', 'vladivostok', 'samara', 'yekaterinburg', 'volgograd', 'chelyabinsk', 'krasnodar', 'omsk', 'novgorod', 'ufa', 'krasnoyarsk', 'kazan', 'habarovsk', 'naberezhnye-chelny', 'cheboksary');

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);  

$cont = file_get_contents('https://shop-polaris.ru/upload/acrit.exportpro/for_parser.xml?encoding=utf-8', false, stream_context_create($arrContextOptions));
//print_r($cont);
$xml = new SimpleXMLElement($cont);
$xml = (array)$xml;

print_r($xml[shop]);
//file_put_contents('/var/www/polaris/engines/shop-polaris.ru/1.txt', print_r($xml[shop],1));
//print_r($itemsArray);die();

foreach ($xml[shop]->offers->offer as $val) {
	//echo $val->url.PHP_EOL;
	//echo $val->model.PHP_EOL;
	//echo $val->price.PHP_EOL;
	$url = trim($val->url);
	$name = trim($val->model);
	$price = trim($val->price_discount);
	if (stripos($price, '.') !== false) {
		preg_match("~(.+)\.~isU", $price, $matches);
		$price = $matches[1];
	}
	//var_dump($price);die();

price_change_detect($url, $name, $price, date("d.m.y-H:i:s"), 'manual', 'manual', 'manual', ENGINE_CURR, ENGINE_TYPE);
$itemsArray[$url] = array(
									$name, 
									$price,
									date("d.m.y-H:i:s"),
									'manual',
									'manual'
								);
echo $url.' | '.$name.' | '.$price.PHP_EOL;
}

foreach ($regions as $region) {
	file_put_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . $region . '.data', serialize($itemsArray));
		
}


$filename = AC_DIR . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.csv';


