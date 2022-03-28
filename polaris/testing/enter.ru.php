<?php
ini_set('display_errors',1);
ini_set('error_reporting',2047);
require ('lib/functions.php');
/**
 * enter.ru
 */

$URL 	= "http://www.enter.ru/search?q=polaris&sort=default-desc&page=1";

$regexpP = "~<ul class=\"bSortingList\">(.+)</ul>~isU";
$regexpP2 = "~bSortingList__eLink js-category-pagination-page-link.*>(.+)<~isU";
$regexp1 = "~<li class=\"bListingItem.*>(.+)class=\"bBtnLine clearfix\">~isU";
$regexp2 = "~<div class=\"bListingItem__eInner\">.*<p class=\"bSimplyDesc__eText\"><a href=\"(.+)\".*>(.+)<.*<span class=\"bPrice\"><strong>(.+)<~isU";

$temp = get_web_page($URL, 'geoshop=14974');
//preg_match($regexpP, $temp['content'], $matches);
//print_r($matches);


//preg_match_all($regexpP2, $matches[1], $matches2);
//print_r($matches2);
//echo max($matches2[1]);
//die();

preg_match_all($regexp1, $temp['content'], $matches, PREG_SET_ORDER); //
foreach ($matches as $key) {
	echo $key[1] . "\n\n";
}
echo "**************************************************\n\n";
//die();
foreach ($matches as $key) {
	//print_r($key);
	preg_match($regexp2, $key[1], $matches2);
	echo trim($matches2[1]) . "\n";
	echo trim($matches2[2]) . "\n";
	echo trim($matches2[3]) . "\n";
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

