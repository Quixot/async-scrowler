<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * mediamarkt.ru
 */
//$URL 	= "https://www.mediamarkt.ru/search?q=polaris+PWP+3610&per_page=18&location=shop_R002&page=1";
$URL 	= "http://www.mediamarkt.ru/"; 
//$URL = "http://www.mediamarkt.ru/search?q=polaris+PWP+3610+&per_page=18";
//$URL 	= "http://www.mediamarkt.ru/search?q=polaris+PWP+3610&per_page=18&location=shop_R002"; 
$regexpP = "~<li class=\"pager js-page-pager\">(.+)</ul>~isU";
$regexpP2 = "~data-page=\"(.+)\"~isU";
$regexp1 = "~<li>.*<div class=\"item \"(.+)class=\"product_action~isU";
$regexp2 = "~<div class=\"title\"><a href=\"(.+)\">(.+)</a>.*class=\"mm-price mm-item-price\" >(.+)<~isU";

$temp = get_web_page($URL, null);
echo $temp['content'];
die();
//preg_match($regexpP, $temp, $matches);
print_r($matches);

//preg_match_all($regexpP2, $matches[1], $matches2);
//print_r($matches2);
//echo max($matches2[1]);
//die();


preg_match_all($regexp1, $temp['content'], $matches, PREG_SET_ORDER); //
print_r($matches);
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
