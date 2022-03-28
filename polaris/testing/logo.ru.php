<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * logo.ru
 */

$URL 	= "http://www.logo.ru/search-new?q=polaris&page=1";

$regexpP 	= "~<div class=\"pageNav2\">(.+)</div>~isU";
$regexpP2 = "~<a href=\".*>(.+)<~isU";
$regexp1 	= "~<div class=\"itempr(.+)<div class=\"inCart~isU";
$regexp2 	= "~</div>.*<a href=\"(.+)\".*>(.+)</a>.*<span class=\"price\".*>(.+)</span>~isU";

//$temp = file_get_contents($URL);
$temp = get_web_page($URL, "city=a4eb7bd26e0e5a3a35431f1e890429b0"); // Получаем контент поисковой страницы
//print_r($temp['content']);

//preg_match($regexpP, $temp['content'], $matches);
//print_r($matches);
//preg_match_all($regexpP2, $matches[1], $matches2);
//print_r($matches2);
//echo max($matches2[1]);
//die();

preg_match_all($regexp1, $temp['content'], $matches, PREG_SET_ORDER); //
//print_r($matches);

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

