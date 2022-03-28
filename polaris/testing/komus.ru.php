<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * komus.ru
 */

$url = 'http://www.komus.ru/search?q=&text=polaris&sort=relevance&listingMode=PLAIN&page=2';
$regexpP1 = "~class=\"ul-cat-pager\">(.*)</ul>~isU";
$regexpP2 = "~<a.*PAGEN_2=(.+)\"~isU";
$regexpPrices1 = "~class=\"item-list group\">(.+)</article~isU";
$regexpPrices2 = "~class=\"caption-list\".*<a.*href=\"(.+)\".*>(.+)<.*class=\"price\">.*span>(.+)<~isU";

$temp = get_web_page($url, 'CURRENT_REGION=78;region=0;area=77'); // Получаем контент поисковой страницы
die($temp['content']);
/*
preg_match_all($regexpP1, $temp['content'], $matches, PREG_SET_ORDER);
print_r($matches);
preg_match_all($regexpP2, $matches[0][1], $matches2, PREG_SET_ORDER);
print_r($matches2);
die();
*/
preg_match_all($regexpPrices1, $temp['content'], $matches, PREG_SET_ORDER);
foreach ($matches as $key) {
	preg_match($regexpPrices2, $key[1], $matches2);
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
