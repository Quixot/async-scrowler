<?php
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * tehnosila.ru
 */

$URL = 'http://tehnosila.ru/search?q=polaris&p=1';
$regexpPagin = "~class=\"items-per-page-view\">(.+)<~isU";
//$regexpBlock = "~<div class=\"item-info\"(.+)<span class=\"cart-block~isU";
$regexpBlock = "~<div class=\"item-info\"(.+)<div class=\"clear\"></div>\s*</div>\s*</div>~isU";
$regexpBlock2 = "~<div class=\"item-info-block\">.*<a.*href=\"(.+)\".*>(.+)</a>.*<div class=\"price\">.*<span class=\"number(.+)<span class=\"currency\">~isU";
//$regexpBlock2 = "~<div class=\"item-info-block\">.*<a href=\"(.+)\".*>(.+)</a>.*class=\"price-holder\">(.+)class=\"express\"~isU"; // Режем карточки товара


$temp = file_get_contents($URL);
//print_r($temp);

preg_match($regexpPagin, $temp, $matchesP);
print_r($matchesP);
die();
preg_match_all($regexpBlock, $temp, $matches, PREG_SET_ORDER);

/*
echo '<pre>';
print_r($matches);
echo '</pre>';
die();

preg_match_all($regexpBlock2, $matches, $matches2, PREG_SET_ORDER); //
print_r($matches2);
die();
*/
foreach ($matches as $key) {
	//print_r($key);
	preg_match($regexpBlock2, $key[0], $matches2);
	
	print_r($matches2);
	
	echo $matches2[1] . "\n";
	echo $matches2[2] . "\n";	
	echo preg_replace('~[^\d.]+~', '' , $matches2[3]) . "\n";
	
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
