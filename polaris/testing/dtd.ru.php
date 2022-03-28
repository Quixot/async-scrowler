<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * dtd.ru
 */

$URL = 'http://dtd.ru/search/?q=polaris&s=&PAGEN_2=2';
$URL = 'http://dtd.ru/product/elektrochaynik_polaris_pwk_1822_floris/';
//$URL = 'http://dtd.ru/product/provodnye_naushniki_pioneer_se_cl501_k/'; // нет в наличии
$regexpPagin	 = "~<div class=\"catalog-pagenav clearfix\">.*</a>.*</div>~isU"; 
$regexpPagin2	 = "~<a.*href.*>(.+)</a>~isU"; 											 												// К-во найденых товаров
$regexpPrices1 = "~<div.*class=\"catalog-item catalog-position catalog(.+)<div class=\"attributes\"~isU";  				 	// Все карточки на странице
$regexpPrices2 = "~<div.*class=\"price\".*>(.+)<.*class=\"name\">.*<a.*href=\"(.+)\".*>(.+)</a>~isU"; // Карточки товара
$regexpRegion  = "~~isU";
//$regexpDirectLinks = "~<div class=\"catalog-element\">.*<div class=\"title\">.*<h1>(.+)<.*class=\"price\">.*<strong>(.+)<~isU";
$regexpAllCatalog = "~<div class=\"catalog-element\">(.+)class=\"bottom-text\">~isU";
$regexpDirectLinks = "~<div class=\"catalog-element\">.*<div class=\"title\">.*<h1>(.+)<.*class=\"insider-price\">.*<strong>(.+)<.*class=\"button-orange-158x30 add2basket\"(.+)</div>~isU";
$temp = get_web_page($URL, 'BITRIX_SM_SELECTED_CITY_KLADRCODE=23000001000;BITRIX_SM_SELECTED_CITY=%D0%9A%D1%80%D0%B0%D1%81%D0%BD%D0%BE%D0%B4%D0%B0%D1%80%2C+%D0%9A%D1%80%D0%B0%D1%81%D0%BD%D0%BE%D0%B4%D0%B0%D1%80%D1%81%D0%BA%D0%B8%D0%B9+%D0%BA%D1%80%D0%B0%D0%B9');
echo $temp['content'];
die();
preg_match($regexpDirectLinks, $temp['content'], $matches);
print_r($matches);
die();
preg_match($regexpDirectLinks, $matches[1], $matches2);
print_r($matches2);
die();

//print_r($temp['content']);
//preg_match($regexpPagin, $temp['content'], $matches);
//preg_match_all($regexpPagin2, $matches[0], $matches2);

//die();
//echo $matches[1];
preg_match_all($regexpPrices1, $temp['content'], $matches3, PREG_SET_ORDER);
foreach ($matches3 as $key) {
	preg_match($regexpPrices2, $key[1], $matches4);
	//echo $key[1];
	//print_r($matches4);
	
	echo $matches4[1] . "\n";
	echo $matches4[2] . "\n";
	echo $matches4[3] . "\n";
	
}
die();

preg_match_all($regexpPrices1, $temp['content'], $matches, PREG_SET_ORDER);
//print_r($matches);

foreach ($matches as $key) {
	preg_match($regexpPrices2, $key[1], $matches2);
	//echo $key[1];
	print_r($matches2);
	/*
	echo $matches2[1] . "\n";
	echo $matches2[2] . "\n";
	echo $matches2[3] . "\n";
	*/
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
