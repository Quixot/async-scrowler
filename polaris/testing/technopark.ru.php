<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * technopark.ru
 */

$URL 	= "http://www.technopark.ru/search/index.php?c=39273&q=polaris&p=1"; 
$regexpP = "~class=\"catalog tp-wrap-main-section\">.*<h2.*>(.+)<~isU";
$regexp1 = "~<li>.*<div class=\"col-1\">.*<div class=\"img-holder(.+)<ul product=~isU";
$regexp2 = "~<a href=\"(.+)\".*<h3><a.*>(.+)</a>.*class=\"price\">.*</i>(.+)<~isU";

$temp = get_web_page($URL, null);
//echo $temp['content'];
//die();
/*
preg_match($regexpP, $temp, $matches);
print_r($matches);
echo preg_replace('~[^\d]+~', '' , $matches[1]);
*/

preg_match_all($regexp1, $temp, $matches, PREG_SET_ORDER);
//print_r($matches);

//preg_match_all($regexp2, $temp, $matches, PREG_SET_ORDER); //
//print_r($matches);
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
