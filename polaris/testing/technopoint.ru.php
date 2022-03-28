<?php
/*
$json = '"cities":{"34":"\u0410\u0431\u0430\u043a\u0430\u043d","52":"\u0410\u043d\u0433\u0430\u0440\u0441\u043a","19":"\u0411\u0430\u0440\u043d\u0430\u0443\u043b","10":"\u0411\u043b\u0430\u0433\u043e\u0432\u0435\u0449\u0435\u043d\u0441\u043a","40":"\u0411\u0440\u0430\u0442\u0441\u043a","1":"\u0412\u043b\u0430\u0434\u0438\u0432\u043e\u0441\u0442\u043e\u043a","31":"\u0415\u043a\u0430\u0442\u0435\u0440\u0438\u043d\u0431\u0443\u0440\u0433","74":"\u0418\u0436\u0435\u0432\u0441\u043a","6":"\u0418\u0440\u043a\u0443\u0442\u0441\u043a","13":"\u041a\u0435\u043c\u0435\u0440\u043e\u0432\u043e","96":"\u041a\u0438\u0440\u043e\u0432","9":"\u041a\u043e\u043c\u0441\u043e\u043c\u043e\u043b\u044c\u0441\u043a-\u043d\u0430-\u0410\u043c\u0443\u0440\u0435","18":"\u041a\u0440\u0430\u0441\u043d\u043e\u044f\u0440\u0441\u043a","67":"\u041c\u0430\u0433\u043d\u0438\u0442\u043e\u0433\u043e\u0440\u0441\u043a","4":"\u041d\u0430\u0445\u043e\u0434\u043a\u0430","8":"\u041d\u043e\u0432\u043e\u043a\u0443\u0437\u043d\u0435\u0446\u043a","20":"\u041d\u043e\u0432\u043e\u0441\u0438\u0431\u0438\u0440\u0441\u043a","30":"\u041e\u043c\u0441\u043a","42":"\u041f\u0435\u0440\u043c\u044c","35":"\u0420\u043e\u0441\u0442\u043e\u0432-\u043d\u0430-\u0414\u043e\u043d\u0443","17":"\u0422\u043e\u043c\u0441\u043a","65":"\u0422\u044e\u043c\u0435\u043d\u044c","11":"\u0423\u043b\u0430\u043d-\u0423\u0434\u044d","3":"\u0423\u0441\u0441\u0443\u0440\u0438\u0439\u0441\u043a","41":"\u0423\u0444\u0430","5":"\u0425\u0430\u0431\u0430\u0440\u043e\u0432\u0441\u043a","36":"\u0427\u0435\u043b\u044f\u0431\u0438\u043d\u0441\u043a","33":"\u0427\u0438\u0442\u0430","37":"\u042e\u0436\u043d\u043e-\u0421\u0430\u0445\u0430\u043b\u0438\u043d\u0441\u043a","71":"\u042f\u043a\u0443\u0442\u0441\u043a"},"cityId":"20"';
$json = '\u0410\u0431\u0430\u043a\u0430\u043d';
var_dump(json_decode($json, true));
die();
*/
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * techpoint.ru
 */

#$URL 	= "http://technopoint.ru/search/?avail=1&length=10&q=polaris&p=1";
$URL = "http://technopoint.ru/search?q=polaris";
//$URL = "http://technopoint.ru/geo/setCity?id=36&YII_CSRF_TOKEN=6369267368d85959d655556835f9ea3be3470fda";

//$regexpP 	= "~<ul class=\"pager\">(.+)</ul>~isU";
//$regexpP2 = "~<li><a href=\".*>(.+)</a>~isU";
$regexp1 	= "~<tr class=\"product.*\"(.+)</tr>~isU";
$regexp2 	= "~class=\"info\".*<a.*href=\"(.+)\".*>(.+)<span class=\"price-ru nowrap\">(.+)<~isU";

//$temp = file_get_contents($URL);
$temp = get_web_page($URL, "__CITY__=34"); // Получаем контент поисковой страницы
//$temp = get_web_page($URL, $cook);
//$temp = get_web_page($URL, "city_id=5d5f0d20124568db1059ab544a04dda78d5e5726s%3A2%3A%2236%22%3B; __CITY__=366cdce47fd5fe9eec08b508f540fbfe9ba16040i%3A36%3B");
//die($temp['content']);
//die();
//preg_match($regexpP, $temp['content'], $matches);
//print_r($matches);
//preg_match_all($regexpP2, $matches[1], $matches2);
//print_r($matches2);
//echo max($matches2[1]);
//die();

preg_match("~<a href=\"#\" class=\"city\" data-role=\"choose-city\".*>(.+)<~isU", $temp['content'], $matches2);
print_r($matches2);
//die();
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

