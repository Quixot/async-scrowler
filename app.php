<?php
$loadavg = sys_getloadavg();
echo $loadavg[0].PHP_EOL;
if ($loadavg[0] > 75) {
	die('Высокая загрузка сервера: '.$loadavg[0].PHP_EOL);
}

$is_xeon_ok = file_get_contents('/var/www/lib/is_xeon_ok.txt');

if ($is_xeon_ok != 0) { // Включаться только если PL1 в ауте
	die();
}

$n = date("w", mktime(0,0,0,date("m"),date("d"),date("Y")));

define( '_JEXEC', 1 );
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
	die('This engine has already been started!'.PHP_EOL);
}

define( 'AC_DIR', dirname(__FILE__).'/'.ENGINE_TYPE );

$AC = new AngryCurl('callback_one');
if (ENGINE_CURR == '_techport.ru') {
	$alive_proxy_list = file_get_contents('http://system.pricinglogix.com/reports/proxylist.txt');
} elseif (ENGINE_CURR == '__enter.ru') {
	$proxy_array = glob('/var/www/lib/proxies/1.proxy');
	$alive_proxy_list = '';
	foreach ($proxy_array as $key) {
		$alive_proxy_list .= file_get_contents($key);
		$alive_proxy_list .= "\n";
	}
	$alive_proxy_list = trim($alive_proxy_list);
} else {
	/* 
	$new_proxy_list = file_get_contents('http://account.fineproxy.org/api/getproxy/?format=txt&type=httpauth&login=VIP214996&password=Wda4DE5pxl');
	$new_proxy_list = explode("\r\n", $new_proxy_list);

	for ($i=0; $i < count($new_proxy_list); $i++) { 
		if ($new_proxy_list[$i]) {
			$new_proxy_temp[] = $new_proxy_list[$i].';VIP214996:Wda4DE5pxl';
		}
	}
	$new_proxy_list = $new_proxy_temp;
	*/
	$proxy_array = glob('/var/www/lib/proxies/*.proxy');
	$alive_proxy_list = '';
	foreach ($proxy_array as $key) {
		$alive_proxy_list .= file_get_contents($key);
		$alive_proxy_list .= "\n";
	}
	$alive_proxy_list = trim($alive_proxy_list);
	//$alive_proxy_list = file_get_contents('/var/www/lib/proxyelite.txt');		
}
if ($alive_proxy_list) {
	$alive_proxy_list = explode("\n", $alive_proxy_list);
	//$alive_proxy_list = array_merge($alive_proxy_list, $new_proxy_list);
	//$alive_proxy_list = $new_proxy_list;
	//print_r($alive_proxy_list);
	$AC->__set('array_proxy', $alive_proxy_list);
	$AC->__set('n_proxy', count($alive_proxy_list));
	$AC->add_debug_msg("Ускоренная загрузка proxy:\n");	
} else {
	$AC->load_proxy_list( AC_DIR.'/config/proxy_list.txt', 200, 'http', 'http://google.com', 'title>G[o]{2}gle' );
}
$AC->load_useragent_list( '/var/www/lib/useragents_short.txt' );	
$AC->init_console();

//require_once( '/var/www/lib/timing.php' );
//$AC->add_debug_msg('Актуальность константа: '.$refreshTime);


$data_file_path = AC_DIR.'/engines/'.ENGINE_CURR.'/data/'.date("d.m.y").'_'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.data';
//$AC->add_debug_msg('Глубина файла: '.(time() - filemtime($data_file_path)));
if (file_exists($data_file_path)) {
  $itemsArray = unserialize(file_get_contents($data_file_path));
  echo "Today's file\n";
} else {
	$itemsArray = array();
	echo "New file\n";
}

// TASKS
$task_path = '/var/www/tasks/'.ENGINE_CURR.'_'.ENGINE_TYPE.'_'.EXTRA_PARAM.'.task';
if (file_exists($task_path)) {
	$bad_urls = unserialize(file_get_contents($task_path));
	unlink($task_path);
}

include('/var/www/engines/'.ENGINE_CURR.'/'.ENGINE_CURR.'.php');
include('/var/www/footer.php');
