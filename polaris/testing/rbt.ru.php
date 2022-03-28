<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * rbt.ru
 */


$URL 	= "http://www.rbt.ru/search/index/page/1/?q=polaris";

$regexpP			 = "~<div.*class=\"paginator-pages\".*>(.+)</div>~isU";		// Пагинация
$regexpP2 		 = "~<a.*span.*>(.+)<~isU";								// Пагинация
$regexpPrices  = "~itemtype=\"http://schema.org/Product(.+)itemprop=\"priceCurrency~isU"; 																							 		// Все товары на странице
$regexpPrices2 = "~<a.*class=\"link link_underline-color_orange.*href=\"(.+)\".*>.*>(.+)<.*class=\"price__row price__row_current.*>(.+)<~isU";  //

//$temp = file_get_contents($URL);
$temp = get_web_page($URL, "region=3;ItemsOnPage=45"); // Получаем контент поисковой страницы

//preg_match($regexpP, $temp['content'], $matches);
//print_r($matches);
//preg_match_all($regexpP2, $matches[1], $matches2);
//print_r($matches2);

preg_match_all($regexpPrices, $temp['content'], $matches, PREG_SET_ORDER); //
//print_r($matches);
//die();
//preg_match_all($regexp2, $matches[0][1], $matches2, PREG_SET_ORDER);
//print_r($matches2);
foreach ($matches as $key) {
	preg_match($regexpPrices2, $key[1], $matches2);
	print_r($matches2);
}
die();

foreach ($matches as $key) {
	//print_r($key);
	preg_match($regexp2, $key[1], $matches2);
	print_r($matches2);
}
die();
$i = 1;
foreach ($matches as $key) {
	echo $i . "<br>\n";
	echo $key[1] . "<br>\n";
	echo $key[2] . "<br>\n";
	echo $key[3] . "<br>\n";
	$i++;
}

