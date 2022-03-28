<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * terminal.ru
 */

$URL 	= "http://ekaterinburg.terminal.ru/search/?q=polaris&x=0&y=0";

$regexpP 	= "~<div class=\"pageListing\">(.+)</div>~isU";
$regexpP2 = "~<a.*>(\d+)</a>~isU";
$regexp1 	= "~<li class = \"catCard p_id.*(.+)</li>~isU";
$regexp2 	= "~<div itemprop=\"price\".*>(.+)<.*<img.*<a href = \"(.+)>(.+)<~isU";

//$temp = file_get_contents($URL);
$temp = get_web_page($URL, null); // Получаем контент поисковой страницы
//print_r($temp['content']);

//preg_match($regexpP, $temp['content'], $matches);
//print_r($matches);
//preg_match_all($regexpP2, $matches[1], $matches2);
//print_r($matches2);
//echo max($matches2[1]);
//die();

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

