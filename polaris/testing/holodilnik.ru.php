<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * holodilnik.ru
 */

$URL = 'http://www.holodilnik.ru/search/?search=polaris';
$regexpP = "~search_res_info.*<div class='found_rows'>(.+)</b>~isU";
$regexp1 = "~class='prodname_line'>(.+)span class=\"psm\">~isU";
$regexp2 = "~<a href=\"(.+)\".*itemprop=\"name\".*>(.+)<.*<div.*class=\"price price.*>(.+)<~isU";


$temp = get_web_page($URL, null);

//preg_match_all($regexpP, $temp, $matches, PREG_SET_ORDER);
//print_r($matches);
//echo preg_replace('~[^\d]+~', '' , $matches[1]);

/**/

preg_match_all($regexp1, $temp['content'], $matches, PREG_SET_ORDER); //
//print_r($matches);
foreach ($matches as $key) {
	//print_r($key);
	//if (strripos($key[1], iconv('utf-8', 'windows-1251','Временно недоступен для заказа')) === false) {
	//if (strripos($key[1], 'Временно недоступен для заказа') === false) {
		preg_match($regexp2, $key[1], $matches2);
		print_r($matches2);	
		//echo 'позиция недоступна: ' . $matches2[2] . "\n"; 
		//print_r($matches2[2]);
	//}
}