<?php
ini_set('display_errors',1);
ini_set('error_reporting',2047);

require ('lib/functions.php');
/**
 * dostavka.ru
 */

$URL = 'http://www.dostavka.ru/search?page_number=1&no_act=1&s=polaris';
$regexpP = "~id=\"count-products-all\">(.+)<~isU";
$regexp1 = "~class=\"sale-block box(.+)class=\"sale-bottom-box~isU";
$regexp2 = "~class=\"category-name.*<a class=\"name\".*href=\"(.+)\".*>(.+)<.*class=\"price\">(.+)<span~isU";
$regexp3 = "~class=\"category-name.*<a class=\"name\".*href=\"(.+)\".*>(.+)<~isU";


$temp = get_web_page($URL, null);

preg_match($regexpP, $temp['content'], $matches);
print_r($matches);
//echo preg_replace('~[^\d]+~', '' , $matches[1]);
die();
/**/

preg_match_all($regexp1, $temp['content'], $matches, PREG_SET_ORDER); //
//print_r($matches);

foreach ($matches as $key) {
	preg_match($regexp2, $key[1], $matches);
	if ($matches[1]) {
		print_r($matches);
	} else {
		preg_match($regexp3, $key[1], $matches);
		print_r($matches);
	}
	

}