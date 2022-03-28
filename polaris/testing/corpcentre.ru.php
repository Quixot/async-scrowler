<?php
/**
 * corpcentre.ru
 */
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);

$URL = 'http://www.corpcentre.ru/search/?q=vitek&s=&PAGEN_1=1';
$regexpP1 = "~class=\"catalog-pagenav clearfix(.+)</div>~isU";
$regexpP2 = "~<a.*>(.+)<~isU";
$regexp1 = "~class=\"catalog-item catalog-position catalog-item(.+)width=\"11\" height=\"11\"~isU";
$regexp2 = "~class=\"name\"><a href=\"(.+)\".*>(.+)<.*class=\"price\">.*<span>(.+)<~isU";


$temp = get_web_page($URL, 'BITRIX_SM_STORE=a%3A8%3A%7Bs%3A2%3A%22id%22%3Bi%3A30%3Bs%3A10%3A%22externalId%22%3Bs%3A36%3A%2274aa7c78-9971-11df-8f4e-00215ec42b38%22%3Bs%3A5%3A%22title%22%3Bs%3A57%3A%22%D0%95%D0%BA%D0%B0%D1%82%D0%B5%D1%80%D0%B8%D0%BD%D0%B1%D1%83%D1%80%D0%B3%2C+%D0%A1%D0%B2%D0%B5%D1%80%D0%B4%D0%BB%D0%BE%D0%B2%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB%22%3Bs%3A4%3A%22slug%22%3Bs%3A12%3A%22ekaterinburg%22%3Bs%3A9%3A%22kladrCode%22%3Bs%3A11%3A%2266000001000%22%3Bs%3A12%3A%22columnNumber%22%3Bi%3A3%3Bs%3A8%3A%22yandexId%22%3Bi%3A54%3Bs%3A7%3A%22default%22%3Bs%3A1%3A%22Y%22%3B%7D;BX_USER_ID=42650250413aa3d81a9e7c08f0daf106');

//preg_match($regexpP1, $temp['content'], $matches);
//preg_match_all($regexpP2, $matches[1], $matchesP); 
//print_r($matchesP);
die($temp['content']);

preg_match_all($regexp1, $temp['content'], $matches, PREG_SET_ORDER); //
print_r($matches);
foreach ($matches as $key) {
	print_r($key);
	preg_match($regexp2, $key[1], $matches2);
	if (strripos($key[1], 'span class="noisset"') === false) {
		echo $matches2[1] . ' - ' . $matches2[2] . ' - ' . $matches2[3] . "\n";
	} else {
		echo $matches2[1] . ' - ' . $matches2[2] . ' - 0' . "\n";
	}
}