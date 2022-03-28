<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * oldi.ru
 */

$URL 	= "http://www.oldi.ru/search/?q=polaris";
$URL2 = "http://www.oldi.ru/catalog/8104/polaris/";

$regexp1 	= "~class='cnt'>(.+)<.*<a.*href=\"(.+)\"~isU";
$regexpP1	= "~class='numbs'>(.+)</div~isU";
$regexpP2 = "~<a.*>(.+)<~isU";
$regexpC1 = "~id=\"item_(.+)class=\"inshops~isU";
$regexpC2 = "~class=\"itemname.*<a.*href=\"(.+)\">(.+)<.*class='price'>(.+)<~isU";

//$temp = file_get_contents($URL);
$temp = get_web_page($URL2, "OLDI_SM_GEOIP=a%3A12%3A%7Bs%3A7%3A%22inetnum%22%3Bs%3A27%3A%22109.86.4.0+-+109.86.159.255%22%3Bs%3A7%3A%22country%22%3Bs%3A2%3A%22UA%22%3Bs%3A4%3A%22city%22%3Bs%3A6%3A%22%D1%E0%EC%E0%F0%E0%22%3Bs%3A6%3A%22region%22%3Bs%3A4%3A%22%CA%E8%E5%E2%22%3Bs%3A8%3A%22district%22%3Bs%3A19%3A%22%D6%E5%ED%F2%F0%E0%EB%FC%ED%E0%FF+%D3%EA%F0%E0%E8%ED%E0%22%3Bs%3A3%3A%22lat%22%3Bs%3A9%3A%2250.450001%22%3Bs%3A3%3A%22lng%22%3Bs%3A9%3A%2230.523333%22%3Bs%3A7%3A%22CITY_ID%22%3Bs%3A6%3A%22259788%22%3Bs%3A9%3A%22CITY_CODE%22%3Bs%3A8%3A%2263000001%22%3Bs%3A10%3A%22SECTION_ID%22%3Bs%3A4%3A%229386%22%3Bs%3A15%3A%22CITY_ADDITIONAL%22%3Bs%3A0%3A%22%22%3Bs%3A5%3A%22ALIAS%22%3BN%3B%7D"); // Получаем контент поисковой страницы
die($temp['content']);
preg_match_all($regexp1, $temp['content'], $matches);
print_r($matches);
//die();
preg_match($regexpP1, $temp['content'], $matches);
//print_r($matches);
preg_match_all($regexpP2, $matches[1], $matches2);
print_r($matches2);
//echo max($matches2[1]);
die();

preg_match_all($regexpC1, $temp['content'], $matches, PREG_SET_ORDER); //
//print_r($matches);
//die();
//preg_match_all($regexp2, $matches[0][1], $matches2, PREG_SET_ORDER);
//print_r($matches2);
foreach ($matches as $key) {
	preg_match($regexpC2, $key[1], $matches2);
	print_r($matches2);
}
