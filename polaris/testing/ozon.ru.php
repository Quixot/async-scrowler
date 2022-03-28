<?php
ini_set('display_errors',1);
ini_set('error_reporting',2047);
require ('lib/functions.php');
/**
 * ozon.ru
 */

$URL 	= "http://www.ozon.ru/context/detail/id/31793623/";

$regexpPrices  = "~class=\"eOzonPrice_main.*>(.*)<.*<h1 class=\"bItemName\".*>(.+)<~isU";
$regexpPrices2 = "~<h1 class=\"bItemName\".*>(.+)<~isU";

$regName 	= "~\"prodName\":\"(.+)\"~isU";
$regPrice = "~\"itemPrice\":(.+)\.~isU";
$regAvail = "~\"itemAvailability\":\"(.+)\"~isU";

$temp = get_web_page($URL, null);
preg_match($regName, $temp['content'], $mName);
preg_match($regPrice, $temp['content'], $mPrice);
preg_match($regAvail, $temp['content'], $mAvail);
echo $mName[1] . "\n";
echo $mPrice[1] . "\n";
echo $mAvail[1] . "\n";
die();


preg_match_all($regexpP2, $matches[1], $matches2);
print_r($matches2);
echo max($matches2[1]);
die();

preg_match_all($regexp1, $temp['content'], $matches, PREG_SET_ORDER); //
//print_r($matches);
//die();
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

