<?php
/**
 * Создание скринов 
 */		
$temp = get_html_translation_table(HTML_ENTITIES);
print_r(array_flip($temp));
$arr1 = array_values($temp);
$arr2 = array_keys($temp);
print_r($arr1);
print_r($arr2);
die();

	require ('lib/functions.php');
	ini_set('display_errors',1);
	ini_set('error_reporting',2047);

	//screenMaker('http://shop.v-lazer.com/catalog/~/search/page-1/?query=vitek', '/var/www/polaris/screen/test.png', null);
	//exec('sudo -u ninja -p GjCrkjyeAelpb -S xvfb-run --server-args="-screen 0, 1024x768x24" CutyCapt --url=' . $urlStart . '&p=' . $i . ' --out=/var/www/screen/technopark.jpg');
	echo exec('xvfb-run --server-args="-screen 0, 1024x768x24" ./CutyCapt --url=http://pricinglogix.com --out=/var/www/polaris/screen/new.html');

