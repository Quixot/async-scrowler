<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * ulmart.ru
 */

$url = 'http://www.ulmart.ru/searchAdditional?string=polaris&category=&rootCategory=&subcategory=&filters=&numericFilters=&brands=&shops=&recommended=&superPrice=&specOffers=&sort=6&viewType=2&minPrice=&maxPrice=&extended=&extendedFilters=&pageNum=1';
//$url ='http://www.ulmart.ru/search?string=' . 'polaris' . '&rootCategory=&sort=6&viewType=2';
//$regexpBlock = "~<div class=\"item\">.*<div class=\"itemTitle\"><a href=\"(.+)\".*>(.+)</a>.*<p class=\"itemPrice\">(.+)<~isU";
$regexpPagin	= "~class=\"normal text-muted\">(.+)<~isU"; 	
//$regexpBlock = "~b-product-list-item__section-wrap.*<div class=\"b-product-list-item__title\">.*<a href=\"(.+)\".*>(.+)</a>.*<span class=\"b-price b-price_size3\">.*class=\"b-price__num\">(.+)<~isU";
$regexpBlock = "~<div class=\"b-product__price\">.*class=\"b-price__num\">(.+)<.*class=\"b-product__title b-truncate\">.*<a.*href=\"(.+)\".*>(.+)<~isU";

$temp = get_web_page($url, "city=18414");
//echo $temp['content'];
preg_match($regexpPagin, $temp['content'], $matches);
print_r($matches);
//$matches = array();

preg_match_all($regexpBlock, $temp['content'], $matches, PREG_SET_ORDER);
print_r($matches);
$i = 1;
foreach ($matches as $key) {
	echo $i . "<br>\n";
	echo $key[1] . "<br>\n";
	echo $key[2] . "<br>\n";
	echo $key[3] . "<br>\n";
	$i++;
}
