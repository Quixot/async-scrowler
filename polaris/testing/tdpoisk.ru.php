<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * tdpoisk.ru
 */

$eldoradoURL = 'http://rostov.tdpoisk.ru/search/?NEWS_COUNT_SELECT=60&all_cities_filter=0&search_form_update=1&q=polaris&PAGEN_1=1';

$regexpPagin = "~<span class=\"b-nw\">(.+)<~isU"; // К-во найденных позиций
$regexpBlock1 = "~<li class=\"b-catalog__item\">(.+)</li>~isU"; // Нарезка карточек товара
$regexpBlock2 = "~class=\"b-catalog__name\">.*<a.*href=\"(.+)\".*>(.+)<.*<div class=\"b-price b-hot-price\">(.+)<~isU";
$regexpRegion = "~id=\"select_city\">.*>(.+)<~isU";

$temp = get_web_page($eldoradoURL, null); // Получаем контент поисковой страницы
//print_r($temp['content']);
preg_match($regexpRegion, $temp['content'], $matches);
//echo iconv('windows-1251','utf-8',$matches[1]);
print_r($matches);
die();

preg_match_all($regexpBlock1, $temp['content'], $matches, PREG_SET_ORDER);

foreach ($matches as $key) {
	if (strripos($key[1], 'b-button__title__in')) {
		preg_match($regexpBlock2, $key[1], $matches2);
		//echo $key[1];
		//print_r($matches2);
		echo $matches2[1] . "\n";
		echo $matches2[2] . "\n";
		echo $matches2[3] . "\n";
	}
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
