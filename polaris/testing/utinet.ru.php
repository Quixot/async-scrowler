<?php
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * utinet.ru
 */

$URL 	= "http://dom.utinet.ru/hairdryer/polaris/phd_2038ti_black/990874/";

$regexpP 	= "~<ul class=\"pager\">(.+)</ul>~isU";
$regexpP2 = "~<a href.*>(.+)</a>~isU";
$regexp1 	= "~class=\"title\">(.+)class=\"cart\"~isU";
$regexp2 	= "~<a href=\"(.+)\">(.+)</a>.*td.*class=\"price\">(.+)</td>~isU";
$regexpRegion ="~id=\"chooseRegion\">.*</i>(.+)</span>~isU";

//$temp = file_get_contents($URL);
$temp = get_web_page($URL, null); // 1409073727_36qv4c52wzb5m6nukrnet 1409073454_qe081o1fz3fxjnn9bvxw2
//1409075915_wg38ft9jj86bxovsrsczk
//1409075915_wg38ft9jj86bxovsrsczk
preg_match($regexpRegion, $temp['content'], $matches);

print_r($matches);
die();

//preg_match($regexpP, $temp, $matches);
//print_r($matches);

//preg_match_all($regexpP2, $matches[1], $matches2);
//print_r($matches2);
//echo max($matches2[1]);


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

