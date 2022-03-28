<?php
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * e5.ru
 */

//$URL = 'http://www.e5.ru/search/search/?subm=&filter_name=polaris';
$URL = 'http://www.e5.ru/search/search/?subm=&filter_name=polaris&category_id=2602039&category_bounds=7807_7844';
$regexpP = "~<div class=\"searchNotFound.*<a href=.*>(.+)<~isU";
$regexp1 = "~<div class=\"item\"(.+)<div class=\"buy_sm_container\">~isU";
$regexp2 = "~<span class=\"priceblock\">.*<a href=\"(.+)\".*title=\"(.+)\".*<span class=\"price\"><em><strong>(.+)<~isU";


$temp = file_get_contents($URL);

preg_match($regexpP, $temp, $matches);
print_r($matches);
echo preg_replace('~[^\d]+~', '' , $matches[1]);


/**/

preg_match_all($regexp1, $temp, $matches, PREG_SET_ORDER); //
//print_r($matches);

foreach ($matches as $key) {
	//print_r($key);
	preg_match($regexp2, $key[1], $matches2);
	print_r($matches2);
}