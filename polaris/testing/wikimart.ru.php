<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * wikimart.ru
 */

$URL = 'http://wikimart.ru/search/?query=polaris&geodata[city_id]=78';
$regexpPagin	 = "~<span.*class=\"count\">(.+)<~isU"; 											 												// Ê-âî íàéäåíûõ òîâàðîâ
$regexpPrices1 = "~<div itemprop=\"itemListElement\"(.+)itemprop=\"priceCurrency\"~isU";  				 	// Âñå êàðòî÷êè íà ñòðàíèöå
$regexpPrices2 = "~<a itemprop=\"url\".*href=\"(.+)\".*class=\"lookLikeH4\">(.+)</span>.*<span itemprop=\"price\">(.+)<~isU";
$regexpRegion  = "~city-name=\"(.+)\"~isU";

$temp = get_web_page($URL, Null); // Ïîëó÷àåì êîíòåíò ïîèñêîâîé ñòðàíèöû
//print_r($temp['content']);
preg_match($regexpRegion, $temp['content'], $matches);
echo $matches[1];
die();

preg_match($regexpPagin, $temp['content'], $matches2);
//print_r($matches2);

preg_match_all($regexpPrices1, $temp['content'], $matches, PREG_SET_ORDER);
//print_r($matches);

foreach ($matches as $key) {
	preg_match($regexpPrices2, $key[1], $matches2);
	//echo $key[1];
	//print_r($matches2);
	
	echo $matches2[1] . "\n";
	echo $matches2[2] . "\n";
	echo $matches2[3] . "\n";
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
