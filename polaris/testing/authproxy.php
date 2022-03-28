<?php 
/**
 * Auth Proxy
 */
$proxies = array(
		'151.248.126.67:42757',
		'37.140.195.35:42757',
		'193.124.47.14:42757',
	);
$uagent = file_get_contents('useragent2015.txt');
$uagent = explode("\n", $uagent);
$content = curlFile('http://bonus-ua.com', $proxies, $uagent);

echo $content;

function curlFile($url,$proxy,$loginpassw,$useragent)
{
		$ua_key = array_rand($useragent, 1);
		$rand_key = array_rand($proxy, 1);
		//$ckfile = tempnam ("/tmp", 'cookiename.txt');
    $loginpassw = '2Q6zq2qssd:rsp_home@uk.net';
		$uag = $useragent[$ua_key];
		$tmproxy = explode(':', $proxy[$rand_key]);
		$proxy_ip = $tmproxy[0];
		$proxy_port = $tmproxy[1];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
	  curl_setopt($ch, CURLOPT_HEADER, 0);           // не возвращает заголовки
	  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
	  curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
	  curl_setopt($ch, CURLOPT_USERAGENT, $uag);	   // useragent
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // таймаут соединения
	  curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
	  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // останавливаться после 10-ого редиректа
    curl_setopt($ch, CURLOPT_PROXYPORT, $proxy_port);
    curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
    curl_setopt($ch, CURLOPT_PROXY, $proxy_ip);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $loginpassw);
		//curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
		//curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile);
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}