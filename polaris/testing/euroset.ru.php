<?php
ini_set('display_errors',1);
ini_set('error_reporting',2047);
require ('lib/functions.php');
/**
 * euroset.ru
 * sankt-peterburg/
 */
$URL = 'http://euroset.ru/search/?q=POLARIS&filter[0]=products&SHOW_ALL=&page=1';
$URL = 'http://euroset.ru/ekaterinburg/search/?q=polaris&amp;filter[0]=products&amp;SHOW_ALL=&amp;page=1
';
$regexpP = "~document.getElementById\(\"amount_res\"\).innerHTML(.+);~isU";
$regexp1 = "~<div class=.*bottom.*>(.+)</li>~isU";	
$regexp2 = "~<a.*href=\"(.+)\".*<p class=.*product-name.*>(.+)<.*<p class=.*product-cost.*>(.+)<~isU";

$temp = get_web_page($URL, 'ORIGINAL_GEO_LOC_ID=-1; _gat_ekt=1; GEO_LOC_ID=167');
preg_match('~<li.*class=change-cities>(.+)<~isU', $temp['content'], $regionid);
echo $regionid[0];
die();
preg_match($regexpP, $temp['content'], $matches);
print_r($matches);
//echo preg_replace('~[^\d]+~', '' , $matches[1]);
echo ceil(preg_replace('~[^\d]+~', '' , $matches[1]) / 20);
//die();


/**/

preg_match_all($regexp1, $temp['content'], $matches, PREG_SET_ORDER); //
//print_r($matches);

foreach ($matches as $key) {
	if (strripos($key[1], 'ÍÅÒ Â ÍÀËÈ×ÈÈ') === false) {
		//print_r($key);
		preg_match($regexp2, $key[1], $matches2);
		print_r($matches2);
	}
}