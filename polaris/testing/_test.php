<?php 
ini_set('display_errors',1);
ini_set('error_reporting',2047);



$url 		 = 'http://housebt.ru/';
$regexpPrices = "~class=\"g-i-title\".*<a href(.+)>(.+)</a>.*class=\"price\">(.+)<~isU";

$data = get_web_page($url);
echo $data['content'];die();
preg_match_all($regexpPrices, $data['content'], $matches, PREG_SET_ORDER);

foreach ($matches as $key => $value) {
  echo $value[1] . "<br>\n";
  echo iconv('windows-1251', 'utf-8', $value[2]) . "<br>\n";
  echo preg_replace('~[\D]+~', '' , $value[3]) . "<br><br>\n\n";
}

function get_web_page($url) {
	/**
	 * cURL
	 */
  $uagent = "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14";
 
  $ch = curl_init( $url );
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
  curl_setopt($ch, CURLOPT_HEADER, 0);           // не возвращает заголовки
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
  curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
  curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // таймаут соединения
  curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // останавливаться после 10-ого редиректа
 
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

