<?php 
/**
 * ru.aliexpress.com
 */
require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);

$url  = "http://ru.aliexpress.com/store/2058016/search?origin=y&SearchText=polaris";
$reg1 = "~class=\"ui-pagination-navi(.+)</div>~isU";
$reg1 = "~<a.*>(.+)<~isU";
$reg2 = "~<li class=\"item\"(.+)</li>~isU";
$reg3 = "~<a href=\"(.+)\".*>(.+)<.*class=\"cost\"><b>(.+)<~isU";


$temp = get_web_page($url, null);
//echo $temp['content'];

preg_match_all($reg2, $temp['content'], $matches, PREG_SET_ORDER); //
print_r($matches);

foreach ($matches as $key) {
	preg_match($reg3, $key[1], $matches2);
	print_r($matches2);
}
