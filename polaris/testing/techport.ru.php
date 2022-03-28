<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * techport.ru
 */

$str = 'РњРёСЂ РїРѕСЃСѓРґС‹';
echo mb_detect_encoding($str);


$URL 	= "http://www.techport.ru/q/?t=polaris&offset=0";
//$URL  = "http://www.techport.ru/katalog/products/melkobytovaja-tehnika/melkie-kuhonnye-pribory/multivarki?offset=0";

$regexpP 	= "~<div class=\"tpager\" id=\"tlist-pager\">(.+)</div>~isU";
$regexpP2 = "~<a class=\"tpagerp\" href=.*>(.+)</a>~isU";
$regexp1 	= "~class=\"view_tail\">(.+)</li>~isU";
$regexp2 	= "~class=\"catalog_name\".*>.*<a.*href=\"(.+)\".*>(.+)<.*class=\"catalog_price.*<span>(.+)<~isU";

//$temp = file_get_contents($URL);
$temp = get_web_page($URL, "nusc=2300000100000"); // Получаем контент поисковой страницы
print_r($temp['content']);
die();
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

