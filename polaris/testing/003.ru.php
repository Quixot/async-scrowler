<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * 003.ru
 */
$URL = 'http://hotline.ua/bt-multivarki/redmond-rmc-pm4506/?tab=2';
//$URL = 'http://www.003.ru/index.php?find=polaris';
$regexpP = "~<div class=\"search_result\">(.+)<p>~isU";
//$regexp1 = "~itemtype=\"http://schema.org/SomeProducts\" itemid=(.+)</table>~isU";
$regexp1 = "~itemtype=\"http://schema.org/SomeProducts\" itemid=(.+)</table>~isU";
$regexp2 = "~<a itemprop=\"name\" href=\"(.+)\">(.+)<.*<div class=\"price\">(.+)<~isU";


//$temp = file_get_contents($URL);
$temp = get_web_page($URL, null);
die($temp['content']);
preg_match($regexpP, $temp['content'], $matches);
print_r($matches);
//echo mb_detect_encoding($matches[1]);
//die();
//echo preg_replace('~[^\d]+~', '' , $matches[1]);
//die();
/**/

preg_match_all($regexp1, $temp, $matches, PREG_SET_ORDER); //
//print_r($matches);
foreach ($matches as $key) {
	//print_r($key);
	preg_match($regexp2, $key[1], $matches2);
	print_r($matches2);
}