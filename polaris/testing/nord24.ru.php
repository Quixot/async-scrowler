<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * nord24.ru
 */

$URL = 'http://www.nord24.ru/search-new?q=polaris&page=2';
$regexpPagin	 = "~<div class=\"pageNav2\">(.+)</div>~isU"; 
$regexpPagin2	 = "~<a.*href.*>(.+)</a>~isU"; 											 												// К-во найденых товаров
$regexpPrices1 = "~<div class=\"itempr item(.+)id=\"addToCompare~isU";  				 	// Все карточки на странице
$regexpPrices2 = "~<a.*href=\"(.+)\".*<span class=\"price\">(.+)<.*<div class=\"name\".*>(.+)<~isU"; // Карточки товара
$regexpRegion  = "~~isU";
// Chelyabinsk f064e8e0876d2d924010a93e90aa4926
// Yekaterinburg a4eb7bd26e0e5a3a35431f1e890429b0
$temp = get_web_page($URL, 'city=f064e8e0876d2d924010a93e90aa4926'); // Получаем контент поисковой страницы

preg_match($regexpPagin, $temp['content'], $matches);
preg_match_all($regexpPagin2, $matches[0], $matches2);
//print_r($matches2);

//echo $matches[1];
preg_match_all($regexpPrices1, $temp['content'], $matches3, PREG_SET_ORDER);
//print_r($matches3);
foreach ($matches3 as $key) {
	preg_match($regexpPrices2, $key[1], $matches4);
	//echo $key[1];
	//print_r($matches4);
	
	echo $matches4[1] . "\n";
	echo $matches4[2] . "\n";
	echo $matches4[3] . "\n";
	
}
