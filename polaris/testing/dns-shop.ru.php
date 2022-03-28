<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * dns-shop.ru
 */

$URL 	= "http://www.dns-shop.ru";

$regexpP 	= "~<ul class=\"pager\">(.+)</ul>~isU";
$regexpP2 = "~<a href.*>(.+)</a>~isU";
$regexp1 	= "~class=\"object item-list ec-price-item\"(.+)class=\"content-info-column\">~isU";
$regexp1	= "~<div class=\"product\".*>(.+)class=\"price-buttons-catalog\">~isU";
$regexp2 	= "~class=\"item-name\">.*<a href=\"(.+)\".*>(.+)</a>.*class=\"price_g\">.*>(.+)<~isU";
//$regexpRegion  = "~id=\"region_nav_selector\".*>(.+)</a>~isU"; // Ðåãèîí
$regexpRegion2 = "~class=\"icon-left glyphicon glyphicon-map-marker\".*-->(.+)<~isU"; // Ðåãèîí

//$temp = file_get_contents($URL);
$temp = get_web_page($URL, "city_path=moscow;"); // Ïîëó÷àåì êîíòåíò ïîèñêîâîé ñòðàíèöû
//die($temp['content']);
//preg_match($regexpRegion2, $temp['content'], $matches);
//die($matches[1]);
//print_r($temp['content']);
//die();
//preg_match($regexpP, $temp, $matches);
//print_r($matches);

//preg_match_all($regexpP2, $matches[1], $matches2);
//print_r($matches2);
//echo max($matches2[1]);


preg_match_all($regexp1, $temp['content'], $matches, PREG_SET_ORDER); //
//print_r($matches);
//die();
//preg_match_all($regexp2, $matches[0][1], $matches2, PREG_SET_ORDER);
//print_r($matches2);
foreach ($matches as $key) {
	preg_match($regexp2, $key[1], $matches2);
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

