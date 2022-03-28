<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * idei74.ru
 */

$URL = 'http://www.idei74.ru/search/page_num/1/?new_search=1&stext=polaris';

$regexpP1 = "~<ul class=\"cfilter fl clr mb20\">(.+)</ul>~isU";
$regexpP2 = "~<li><a.*>(.+)<~isU";
$regexpBlock1 = "~<div class=\"c-div\"><a href=\"(.+)\".*class=\"cat02\">(.+)<~isU";
$regexpBlock2 = "~<div class=\"control c-div\">.*<big>(.+)<~isU";

$temp = get_web_page($URL, null); // Получаем контент поисковой страницы
//print_r($temp['content']);
//preg_match($regexpRegion, $temp['content'], $matches);
//echo iconv('windows-1251','utf-8',$matches[1]);
//die();

preg_match_all($regexpBlock1, $temp['content'], $matches, PREG_SET_ORDER);
//preg_match_all($regexpBlock2, $temp['content'], $matches, PREG_SET_ORDER);
print_r($matches);
die();

foreach ($matches as $key) {
	preg_match($regexpBlock2, $key[1], $matches2);
	//echo $key[1];
	//print_r($matches2);
	echo $matches2[1] . "\n";
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
