<?php
ini_set( 'display_errors', 1 );
ini_set( 'memory_limit', '1024M' );
ini_set( 'error_reporting',2047 );
ini_set( 'max_execution_time', 0 );
ini_set( 'pcre.backtrack_limit',1000000 );
ini_set( 'pcre.recursion_limit',1000000 );
date_default_timezone_set( 'Europe/Kiev' );

include( '/var/www/lib/RollingCurl.class.php');
include( '/var/www/lib/AngryCurl.class.php');
include( '/var/www/lib/functions.php');
include( '/var/www/lib/PHPExcel.php');
include( '/var/www/lib/PHPExcel/Writer/Excel2007.php');

$time_start = microtime(1);
$currTime = date('H');

if (empty($_GET)):
  die('engine doesn\'t connect...'); // Если не ввели параметр engine
else: 
  define('ENGINE_CURR', $_GET['EC']); 			// Текущий движок
	define('ENGINE_TYPE', $_GET['ET']); 			// Тип группы товаров
	define('ENGINE_LOOP', 1); 			// К-во циклов !!!!!!!!!!!!! Костыль
	define('WINDOW_SIZE', 10); // К-во потоков
	define('EXTRA_PARAM', $_GET['EP']);			// Дополнительные движки. Например, для создания списка характеристик или закачки картинок
endif;

define( 'AC_DIR', dirname(__FILE__) );

$AC = new AngryCurl('callback_one');
if ($currTime == '05' || ENGINE_CURR == 'enter.ru') {
	$alive_proxy_list = file_get_contents('http://system.pricinglogix.com/reports/proxylist.txt');
} else {
	//$alive_proxy_list = file_get_contents('/var/www/lib/proxyelite.txt');		
	$proxy_array = glob('/var/www/lib/proxies/*.proxy');
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
	$AC->add_debug_msg("Ускоренная загрузка proxy:\n");	
} else {
	$AC->load_proxy_list( AC_DIR.'/config/proxy_list.txt', 200, 'http', 'http://google.com', 'title>G[o]{2}gle' );
}
$AC->load_useragent_list( '/var/www/lib/useragents_short.txt' );	
$AC->init_console();

$data_file_path = AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.data';
if (file_exists($data_file_path) && date('H') != '10') {
  $itemsArray = unserialize(file_get_contents($data_file_path));
  echo "Today's file\n";
} else {
	$itemsArray = array();
	echo "New file\n";
}
$errorsArray = array();

include('/var/www/'.ENGINE_TYPE.'/engines/'.ENGINE_CURR.'/'.ENGINE_CURR.'.php');
include('/var/www/'.ENGINE_TYPE.'/footer.php');
