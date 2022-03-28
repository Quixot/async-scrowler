<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * citilink.ru
 */

$URL = 'http://www.citilink.ru/search/?text=polaris';
$URL2 = 'http://www.citilink.ru/search/?menu_id=211&text=polaris';
$regexpP1 = "~class=\"page_listing\"(.*)</div>~isU";
$regexpP2 = "~<a.*>(.+)<~isU";
$regexpBlock = "~<tbody class=\"product_data__gtm-js\"(.+)</tbody>~isU";
$regexpBlock2 = "~class=\"h3.*<a class=\"link_gtm-js\" href=\"(.+)\".*>(.+)</a>.*class=\"price\"><ins class=\"num\">(.+)<~isU";

//$str = "http://www.citilink.ru/search/?menu_id=263&text=polaris?menu_id=263&text=polaris";
//$str = "http://citilink.ru/search/?menu_id=208&text=polaris";
/*
if (substr_count($str, '?') > 1) {	
	echo substr($str, 0, strripos($str, '?'));
}
die();

$test = array();
for ($i=1; $i<=0; $i++) {
	$test[] = array(
			'url' . $i => $i . 'test';
		);
}
*/

$temp = get_web_page($URL, "_space=spb_cl%3A");
die($temp['content']);


preg_match($regexpP1, $temp['content'], $matches);
preg_match_all($regexpP2, $matches[1], $matchesP); 
print_r($matchesP);

//preg_match_all($regexpCat, $temp['content'], $matchesCat, PREG_SET_ORDER);
//print_r($matchesCat);


preg_match_all($regexpBlock, $temp['content'], $matches, PREG_SET_ORDER); //
//print_r($matches);

foreach ($matches as $key) {	
	preg_match($regexpBlock2, $key[1], $matches2);
	print_r($matches2);
	/*
	echo $matches2[1] . "\n";
	echo $matches2[2] . "\n";
	echo preg_replace('~[^\d.]+~', '' , $matches2[3]) . "\n";
	*/
}
die();
