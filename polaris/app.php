#!/usr/bin/php
<?php
/*
$ctx = stream_context_create(array('http'=>
    array(
        'timeout' => 180,
    )
));
$is_xeon2_ok = file_get_contents('http://attraktor:eldorado@176.36.102.174:4080/iamok', false, $ctx);
$is_obolon_ok = file_get_contents('http://quixote:eldorado@82.193.126.150/iamok', false, $ctx);

if ($is_obolon_ok == 1 && $is_xeon2_ok == 1) {
	die();
}

*/

$loadavg = sys_getloadavg();
echo $loadavg[0].PHP_EOL;
if ($loadavg[0] > 20) {
	die('Высокая загрузка сервера: '.$loadavg[0].PHP_EOL);
}
define( '_JEXEC', 1 );
define( 'AC_DIR', dirname(__FILE__) );
ini_set( 'display_errors', 1 );
ini_set( 'memory_limit', '1024M' );
ini_set( 'max_execution_time', 0 );
ini_set( 'pcre.backtrack_limit',1000000 );
ini_set( 'pcre.recursion_limit',1000000 );
error_reporting (E_ERROR | E_WARNING | E_PARSE);
date_default_timezone_set( 'Europe/Kiev' );

/**
 * Загружаем основные классы
 * и библиотеки функций
 */
require_once( '/var/www/lib/RollingCurl.class.php');
require_once( '/var/www/lib/AngryCurl.class.php');
require_once( '/var/www/lib/functions.php');
require_once( '/var/www/lib/PHPExcel.php');
require_once( '/var/www/lib/PHPExcel/Writer/Excel2007.php');
 
$time_start = microtime(1);

// проверяем параметры командной строки             
if (empty($argv)):
  die('engine doesn\'t connect...'); // Если не ввели параметр engine
else: 
  define('ENGINE_CURR', $argv[1]); 			// Текущий движок
	define('ENGINE_TYPE', $argv[2]); 			// Тип группы товаров
	define('ENGINE_LOOP', $argv[3]); 			// К-во циклов
	define('WINDOW_SIZE', (int)$argv[4]); // К-во потоков
	define('EXTRA_PARAM', $argv[5]);			// Дополнительные движки. Например, для создания списка характеристик или закачки картинок
endif;     

if (is_engine_in_array(ENGINE_CURR, ENGINE_TYPE, EXTRA_PARAM)) {
	//die('This engine has already been started!'.PHP_EOL);
} 

$pathToData = ENGINE_CURR . '_' . ENGINE_TYPE . '_' . date("d.m.y_H.i.s");
/*
 * Вариант для быстрой загрузки без тестирования proxy:
 */
	$AC = new AngryCurl('callback_one');
	if (1 != 1/* date('H') == '05' || ENGINE_CURR == 'enter.ru'*/) {
		$alive_proxy_list = file_get_contents('http://system.pricinglogix.com/reports/proxylist.txt');
	} else {
		//$alive_proxy_list = file_get_contents('/var/www/lib/proxyelite.txt');

		$rand_proxy_type = rand(0,1).PHP_EOL;

		if ($rand_proxy_type == 0 && ENGINE_CURR != 'dns-shop.ru' && ENGINE_CURR != 'beru.ru' && ENGINE_CURR != 'positronica.ru') {
			$proxy_array = glob('/var/www/lib/proxies_socks/*.proxy');
		} else {
			$proxy_array = glob('/var/www/lib/proxies/*.proxy');
		}

		
		$alive_proxy_list = '';
		foreach ($proxy_array as $key) {
			$alive_proxy_list .= file_get_contents($key);
			$alive_proxy_list .= "\n";
		}
		$alive_proxy_list = trim($alive_proxy_list);		
	}
	if ($alive_proxy_list) {
		$alive_proxy_list = explode("\n", $alive_proxy_list);		
		$AC->__set('array_proxy', $alive_proxy_list);
		$AC->__set('n_proxy', count($alive_proxy_list));
		if ($rand_proxy_type == 0 && ENGINE_CURR != 'dns-shop.ru' && ENGINE_CURR != 'beru.ru' && ENGINE_CURR != 'positronica.ru') {
			$AC->__set('options', array(CURLOPT_PROXYTYPE => CURLPROXY_SOCKS5));
		}	
		$AC->add_debug_msg("Ускоренная загрузка proxy:\n");	
	} else {
		$AC->load_proxy_list( AC_DIR . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'proxy_list.txt', 200, 'http', 'http://google.com', 'title>G[o]{2}gle' );
	}
	$AC->load_useragent_list( '/var/www/lib/useragents_short.txt' );	
	$AC->init_console();



$currTime = date('H');
if (date('N') == '6' || date('N') == '7') {
	if (file_exists(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data')) {
	  $itemsArray = unserialize(file_get_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data'));
	  echo "Today file\n";
	} else {
		$itemsArray = array();
		echo "New file\n";
	}
} else {
	if ((file_exists(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data') && $currTime != '11' && $currTime != '14' && $currTime != '20' && $currTime != '23'/**/)  || ENGINE_CURR == 'beru.ru' || ENGINE_CURR == '_dns-shop.ru'/*|| ENGINE_CURR == 'mvideo.ru'*/) {
	  $itemsArray = unserialize(file_get_contents(AC_DIR . DIRECTORY_SEPARATOR . 'engines' . DIRECTORY_SEPARATOR . ENGINE_CURR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . date("d.m.y") . '_' . ENGINE_CURR . '_' . ENGINE_TYPE . '_' . EXTRA_PARAM . '.data'));
	  echo "Today file\n";
	} else {
		$itemsArray = array();
		echo "New file\n";
	}
}
$errorsArray = array();

/**
 * Подключаем engine
 * 
 * sudo screen php app.php hotline.ua mbt 1 30 12345
 * sudo screen php app.php engine type
 */
require_once( 
							AC_DIR 			. DIRECTORY_SEPARATOR 
						. 'engines' 	. DIRECTORY_SEPARATOR 
						. ENGINE_CURR . DIRECTORY_SEPARATOR 
						. ENGINE_CURR . '.php'
						);

require_once( 
							AC_DIR 			. DIRECTORY_SEPARATOR 
						. 'footer.php'
						);