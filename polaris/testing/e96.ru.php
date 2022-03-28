<?php
/**
 * e96.ru
 */
require ('lib/functions.php');

ini_set('display_errors',1);
ini_set('error_reporting',2047);

$url1  = 'http://e96.ru/brands/polaris';
$url2 = 'http://e96.ru/kitchen_appliance/pans/polaris';
$regexpCat 		= "~<ul class=\"categories-min\">(.+)<div class=\"social-box\">~isU"; // ������ ��������� ������� �� �������� �� ������� � ����������� �������� � ������
$regexpPagin 	= "~<li><a href=\"(.+)\".*</a>(.+)<~isU"; 														// �������� ������ �� �������� �� ������� � �-��� �������� � ������
$regexpBlock1 = "~<li class=\"catalog-product\".*data-productid=\"(.+)</li>~isU";
$regexpBlock2 = "~<a class=\"name\".*href=\"(.+)\".*>(.+)<.*class=\"price price_big\">(.+)<~isU";

/*
$temp = get_web_page($url1, 'e96_geoposition=2'); // �������� ������� ��������� ��������
preg_match($regexpCat, $temp['content'], $matchesCat); // ����� ���� ���� � ��������
//print_r($matchesCat);
preg_match_all($regexpPagin, $matchesCat[1], $matches, PREG_SET_ORDER); // ����� ������ � �����
//print_r($matches);
foreach ($matches as $key) { // ����� ������� � �-�� ������� � ��������
	//echo $key[1] . "\n";
	//echo preg_replace('~[^\d.]+~', '' , $key[2]) . "\n";
}
*/
$temp = get_web_page($url2, 'e96_geoposition=110'); // �������� ������� �������� � ���������� ������
preg_match_all($regexpBlock1, $temp['content'], $matchesBlock1, PREG_SET_ORDER); // ����� ���� ���� � ����������
//print_r($matchesBlock1);
//preg_match_all($regexpBlock2, $matchesBlock1, $matches2, PREG_SET_ORDER); // ����� �������� ������ - url, ��������, ����
//print_r($matches2);

foreach ($matchesBlock1 as $key) {
	//echo $key[1];
preg_match($regexpBlock2, $key[1], $matches);
	echo $matches[1] . "\n";
	echo $matches[2] . "\n";
	echo $matches[3] . "\n";
}
