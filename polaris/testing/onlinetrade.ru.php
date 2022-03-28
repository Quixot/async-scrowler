<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * onlinetrade.ru
 */
$URL = 'http://www.onlinetrade.ru/search.html?query=polaris&page=0';
$regexpP1 = "~class=\"catalogItemList__paginator\"(.*)</div>~isU";
$regexpP2 = "~<a.*>(.+)<~isU";
$regexp1 = "~class=\"search__findedItem\"(.+)class=\"search__findedItem__columnDescription\"~isU";
$regexp2 = "~<a href=\"(.+)\".*alt=\"(.+)\".*class=\"catalog__displayedItem__actualPrice\">(.+)<~isU";


//$temp = file_get_contents($URL);
$temp = get_web_page($URL, 'user_city=1');
preg_match($regexpP1, $temp['content'], $matches);
preg_match_all($regexpP2, $matches[1], $matchesP); 
print_r($matchesP);

preg_match_all($regexp1, $temp['content'], $matches, PREG_SET_ORDER); //
//print_r($matches);
foreach ($matches as $key) {
	//print_r($key);
	preg_match($regexp2, $key[1], $matches2);
	print_r($matches2);
}
