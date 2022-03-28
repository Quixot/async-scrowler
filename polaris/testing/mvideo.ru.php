<?php
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * mvideo.ru
 */

$URL = 'http://www.mvideo.ru/product-list?Dy=1&No=144&Nrpp=24&Ntt=polaris&Nty=1&cityId=CityCZ_2246';
$regexpPagin = "~class=\"search-results-heading-qty\">(.+)</span>~isU";
$regexpBlock = "~class=\"product-tile-picture\"(.+)<div class=\"product-tile-gift-card\">~isU";
$regexpBlock2 = "~class=\"product-tile-description\".*<a href=\"(.+)\".*>(.+)<.*class=\"product-price-current\">(.+)<~isU";

$temp = file_get_contents($URL);

preg_match($regexpPagin, $temp, $matches);
print_r($matches);
die();

preg_match_all($regexpBlock, $temp, $matches, PREG_SET_ORDER); //
//print_r($matches);
foreach ($matches as $key) {
	//print_r($key);
	preg_match($regexpBlock2, $key[1], $matches2);
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
