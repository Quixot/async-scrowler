<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * euromax.ru
 */

$URL 	= "http://www.euromaxx.ru/catalog/?query=samsung&p=2";

$regexpP 	= "~class=\"paginator\">(.+)</div>~isU";
$regexpP2 = "~<a href=\".*data-page=\"(.+)\"~isU";
$regexp1 	= "~<div class=\"product\">.*<h2><a href=\"(.+)\">(.+)</a>.*<span class=\"price\">(.+)<~isU";
$regexp1  = "~class=\"info extra\".*<a href=\"(.+)\".*>.*<h3>(.+)<.*class=\"scost\">(.+)<~isU";
//$regexp2 	= "~<h3><a href=\"(.+)\".*>(.+)</a>.*<td class=\"p sel\">(.+)</td>~isU";

//$temp = file_get_contents($URL);
$temp = get_web_page($URL, "region_id=6"); // Получаем контент поисковой страницы
//print_r($temp['content']);

preg_match($regexpP, $temp['content'], $matches);
print_r($matches);
preg_match_all($regexpP2, $matches[1], $matches2);
print_r($matches2);
//echo max($matches2[1]);
die();

preg_match_all($regexp1, $temp['content'], $matches, PREG_SET_ORDER); //
print_r($matches);
foreach ($matches as $key) {
	echo $key[1] . "\n";
	echo $key[2] . "\n";
	echo $key[3] . "\n\n";
}
die();
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

