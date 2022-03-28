<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * eldorado.ru
 */

$eldoradoURL = 'http://www.eldorado.ru/search/catalog.php?PAGEN_SEARCH=4&list_num=50&q=polaris';
//$regexpBlock = "~<div class=\"item\">.*<div class=\"itemTitle\"><a href=\"(.+)\".*>(.+)</a>.*<p class=\"itemPrice\">(.+)<~isU";
$regexpBlock1 = "~<div class=\"itemInfo\">(.+)<a data-position~isU";
$regexpBlock2 = "~<div class=\"itemDescription\".*<a href=\"(.+)\".*>(.+)</a>.*itemPrice\">(.+)<span~isU";
$regexpRegion = "~<a class=\"headerRegionName\">(.+)</a>~isU";

$temp = get_web_page($eldoradoURL, "iRegionSectionId=11324"); // Получаем контент поисковой страницы
//print_r($temp['content']);
//preg_match($regexpRegion, $temp['content'], $matches);
//echo iconv('windows-1251','utf-8',$matches[1]);
echo $temp['content'];
//$temp = file_get_contents($eldoradoURL);
die();
preg_match_all($regexpBlock1, $temp['content'], $matches, PREG_SET_ORDER);
print_r($matches);

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
