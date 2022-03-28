<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * optvideo.com
 */

$URL 	= "http://optvideo.com/ns/katalog2.php?gr2_by_menu=927575&step=2&gr_by_menu=91742&brend=xxx&id_brend=0&kategory=%CD%CE%D3%D2%C1%D3%CA%C8/%CF%CB%C0%CD%D8%C5%D2%DB&zena1=0&zena2=1000000";

$regexpP 	= "~<table style=\"margin-top:10px\" cellpadding=\"0\" cellspacing=\"0\" class=\"sorting_form\">.*<td colspan=\"2\" align=\"left\">.*<strong>.*из(.+)<~isU";
//$regexpP2 = "~<li><a href=\".*>(.+)</a>~isU";
//$regexp1 	= "~<td class=\"t\">(.+)<td class=\"ct\">~isU";
$regexp2 	= "~<table width=\"100%\">.*<td valign=\"top\">.*<a href=\"(.+)\" class=\"product\">(.+)</a>.*<td valign=\"top\">.*<p.*class=\"price_k vnal\">(.+)<~isU";

//$temp = file_get_contents($URL);
$temp = get_web_page($URL, "city_path=ekaterinburg"); // ѕолучаем контент поисковой страницы
//print_r($temp['content']);

//preg_match($regexpP, $temp['content'], $matches);
//echo $matches[1];
//die();
//print_r($matches);
preg_match_all($regexp2, $temp['content'], $matches2, PREG_SET_ORDER);
print_r($matches2);
//echo max($matches2[1]);
die();

preg_match_all($regexp1, $temp['content'], $matches, PREG_SET_ORDER); //
print_r($matches);
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

