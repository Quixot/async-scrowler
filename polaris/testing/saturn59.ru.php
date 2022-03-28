<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * saturn59.ru
 */

$URL = 'http://saturn59.ru/shopsearch.htm?search[name]=polaris&order=%F6%E5%ED%E5&pageCount=10&page=1';
$regexpPagin	 = "~<div class=\"seek\">(.+)</div>~isU"; 
$regexpPagin2	 = "~<a.*href.*>(.+)</a>~isU"; 											 												// К-во найденых товаров
$regexpPrices1 = "~<h2 class=\"name\">(.+)</tr>~isU";  				 	// Все карточки на странице
$regexpPrices2 = "~<a href=\"(.+)\">(.+)</a>.*<div class=\"price\">.*<span>(.+)<~isU"; // Карточки товара

$temp = get_web_page($URL, null); // Получаем контент поисковой страницы
preg_match($regexpPagin, $temp['content'], $matches);
preg_match_all($regexpPagin2, $matches[0], $matches2);

//echo $matches[1];
preg_match_all($regexpPrices1, $temp['content'], $matches3, PREG_SET_ORDER);
foreach ($matches3 as $key) {
	preg_match($regexpPrices2, $key[1], $matches4);
	//echo $key[1];
	print_r($matches4);
	/*
	echo $matches4[1] . "\n";
	echo $matches4[2] . "\n";
	echo $matches4[3] . "\n";
	*/
}
