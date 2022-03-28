<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * naifl.ru
 */

$eldoradoURL 	= 'http://www.naifl.ru/find?find_text=polaris&PAGEN_1=4';
$regexpP 			= "~<div class=\"main-content\">.*<h1>.*<h3>(.+)</h3>~isU";
$regexpBlock1 = "~<li class=\"item-list\"(.+)</li>~isU";
$regexpBlock2 = "~<div class=\"title\".*<a.*href=\"(.+)\".*>(.+)<.*<span class=\"price\".*<span class=\"value\">(.+)<~isU";
$regexpRegion = "~<div id=\"city_change_block\">.*<a class=\"popup_ajax city_change_link\".*>(.+)</a>~isU";

$temp = get_web_page($eldoradoURL, "iRegionSectionId=11279"); // Получаем контент поисковой страницы
//print_r($temp['content']);
preg_match($regexpRegion, $temp['content'], $matches);
echo $matches[1];
//die();



//$temp = file_get_contents($eldoradoURL);

preg_match_all($regexpBlock1, $temp['content'], $matches, PREG_SET_ORDER);
//print_r($matches);

foreach ($matches as $key) {
	preg_match($regexpBlock2, $key[1], $matches2);
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
