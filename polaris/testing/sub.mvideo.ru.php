<?php
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * sub.mvideo.ru
 */

$URL = 'http://rostov.mvideo.ru/listing1.php?SearchWord=polaris&sort=2&direct=0&page=1';
$regexpP = "~<div class=\"lb_pages\">(.+)<div class=\"lb_more cfx\">~isU";
$regexpP2 = "~<a rel=\"nofollow\".*>(.*)<~isU";
$regexp1 = "~class=\"listing_good transpstn(.+)</table>~isU";
$regexp2 = "~<a href=\"(.+)\".*>(.+)<.*<td class=\"numbers\".*>(.+)</td>~isU";


$temp = file_get_contents($URL);

preg_match($regexpP, $temp, $matches);
//print_r($matches);
//echo preg_replace('~[^\d]+~', '' , $matches[1]);

/**/
$qOfPaginationPages = 0;
preg_match_all($regexpP2, $matches[1], $matches2); //

echo max($matches2[1]);


die();

foreach ($matches as $key) {
	//print_r($key);
	preg_match($regexp2, $key[1], $matches2);
	//print_r($matches2);
	echo $matches2[1] . "\n";
	echo trim($matches2[2]) . "\n";
	echo preg_replace('~[^\d]+~', '' , $matches2[3]) . "\n\n";
}