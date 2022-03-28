<?php
//require ('lib/functions.php');
ini_set('display_errors',1);
ini_set('error_reporting',2047);
/**
 * yandex.ru
 */

$URL 	= "http://market.yandex.ru/offers.xml?modelid=7757846&hid=90599&grhow=shop&track=top5";

$reg1 = "~<div class=\"product-title\">.*<h1.*>(.+)<~isU"; // Заголовок (Имя товара)
$reg2 = "~<div class=\"b-pager__pages\">(.+)</div>~isU";	 // Первая часть пагинации
$reg3 = "~<a.*>(.+)</a>~isU"; // Вторая часть пагинации. Нужно будет выбирать большее значение
$reg4 = "~<div class=\"b-serp__item b-offers(.+)</ul></div></div></div>~isU"; // Все предложения, не разрезанные
$reg5 = "~<h3 class=\"b-offers__title\"><a.*href=\"(.+)\">(.+)</a>.*<span class=\"b-old-prices__num\">(.+)</span>.*div class=\"b-offers__onstock\">(.+)<.*<div class=\"b-offers__delivery.*class=\"b-offers__delivery-text\"(.+)</div>.*<div class=\"b-offers__feats\"><a.*>(.+)</a>~isU";
// url, Название, Цена, Наличие, Доставка, Магазин


//$temp = file_get_contents($URL);
$temp = get_web_page($URL, 'yandex_gid=10174'); // Получаем контент поисковой страницы

//die($temp['content']);

echo $temp['content'];


echo "Заголовок\n";
preg_match($reg1, $temp['content'], $matches);
echo $matches[1];

echo "Пагинация\n";
preg_match($reg2, $temp['content'], $matches);
preg_match_all($reg3, $matches[1], $matches2);
print_r($matches2);

echo "Все предложения на странице\n";
preg_match_all($reg4, $temp['content'], $matches);
/*
echo "Разрезанные предложения";
preg_match_all($reg4, $matches, $matches2);
print_r($matches2);
*/

function get_web_page( $url, $strCookie) {
	/**
	 * cURL
	 */
  $uagent = "Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1";
 
  $ch = curl_init( $url );
 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
  curl_setopt($ch, CURLOPT_HEADER, 0);           // не возвращает заголовки
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
  curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
  curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); // таймаут соединения
  curl_setopt($ch, CURLOPT_TIMEOUT, 60);        // таймаут ответа
  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // останавливаться после 10-ого редиректа
  curl_setopt($ch, CURLOPT_PROXY, '120.203.214.144:80');
  curl_setopt($ch, CURLOPT_COOKIE, $strCookie); 
  curl_setopt($ch, CURLOPT_COOKIEJAR, "/var/www/polaris/testing/cookie.txt"); 
  curl_setopt($ch, CURLOPT_COOKIEFILE, "/var/www/polaris/testing/cookie.txt");  
 
  $content = curl_exec( $ch );
  $err     = curl_errno( $ch );
  $errmsg  = curl_error( $ch );
  $header  = curl_getinfo( $ch );
  curl_close( $ch );
 
  $header['errno']   = $err;
  $header['errmsg']  = $errmsg;
  $header['content'] = $content;
  return $header;
}
/*
94.202.60.199:80
31.15.48.12:80
*/