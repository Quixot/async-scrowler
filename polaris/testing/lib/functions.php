<?php
/**
 * Функции для тестирования
 */

function get_web_page($url, $strCookie) {
	/**
	 * cURL
	 */
  $uagent = "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14";
 
  $ch = curl_init( $url );
 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
  curl_setopt($ch, CURLOPT_HEADER, 1);           // не возвращает заголовки
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
  curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
  curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // таймаут соединения
  curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
  curl_setopt($ch, CURLOPT_MAXREDIRS, 20);       // останавливаться после 10-ого редиректа
  //curl_setopt($ch, CURLOPT_PROXY, '222.88.236.235:843');
  curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
  curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
  curl_setopt($ch, CURLOPT_COOKIE, $strCookie); 
 
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

function screenMaker($url, $filename, $proxy = Null) {
/**
 * Создание скринов сканируемых страниц
 */  
  //$url = 'http://habrahabr.ru'; // "хардкод" для примера
  // имя временного файла для сохранения скриншота
  $tmpfname = tempnam('/tmp', 'catalog') . '.png';
  // эскейпим перед вставкой в строку команды
  $url = escapeshellarg($url);
  // собираем командную строку
  // из параметров для CutyCapt я передавал только мин. ширину экрана, url и имя файла, куда сохранять скриншот - мне этого хватило
  // о "xvfb-run" я писал выше
  $cmd = sprintf('xvfb-run --server-args="-screen 0, 1024x768x24" CutyCapt --min-width=1280 --url=%s --out=\'%s\' --http-proxy=\'%s\'', $url, $tmpfname, $proxy);  
  exec($cmd); // Выполняем
  // Проверяем, что скрин создался
  if (file_exists($tmpfname)) {
    // проверяем, что он не 0 байт (у меня иногда так случалось)
    if (filesize($tmpfname) > 1) {
      // а тут уже делаем с файлом по имени $tmpfname все, что душе угодно
      // делаем его копию в нужную папку, изменяем размер, обрезаем в нужных пропорциях, создаем дополнительный эскиз.....
      // я, например, использовал phpthumb (phpthumb.gxdlabs.com) для обработки        
      copy($tmpfname, $filename);
    }      
    unlink($tmpfname); // удаляем временный файл
  }
}