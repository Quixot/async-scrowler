<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * xn--80avhbjh.xn--p1ai
 */

$url = 'http://xn--80avhbjh.xn--p1ai/product/search?query=polaris&per-page=50&page=2';
$regexpP1 = "~id=\"pager-container\"(.+)</ul>~isU";
$regexpP2 = "~<a.*>(.+)<~isU";
$regexpPrices1 = "~data-key=(.+)class=\"plus\">~isU";
$regexpPrices2 = "~class=\"hov\".*<a.*href=\"(.+)\".*span>(.+)<.*class=\"price\">(.+)<~isU";

$temp = get_web_page($url, null); // Получаем контент поисковой страницы
//die($temp['content']);
/*
preg_match_all($regexpP1, $temp['content'], $matches, PREG_SET_ORDER);
print_r($matches);
preg_match_all($regexpP2, $matches[0][1], $matches2, PREG_SET_ORDER);
print_r($matches2);
die();
*/
preg_match_all($regexpPrices1, $temp['content'], $matches, PREG_SET_ORDER);
foreach ($matches as $key) {
	preg_match($regexpPrices2, $key[1], $matches2);
	//echo $key[1];
	print_r($matches2);
	//echo $matches2[1] . "\n";
}
/*
$i = 1;
foreach ($matches as $key) {
	echo $i . "<br>\n";
	echo $key[1] . "<br>\n";
	echo $key[2] . "<br>\n";
	echo $key[3] . "<br>\n";
	$i++;
}
*/
