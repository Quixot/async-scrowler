<?php
$start = microtime(1); // Время начала работы скрипта
echo "Initial: ".memory_get_usage()." bytes \n";
define( '_JEXEC', 1 );
define( 'AC_DIR', dirname(__FILE__) );
ini_set( 'display_errors', 1 );
//ini_set( 'memory_limit', '1024M' );
ini_set( 'max_execution_time', 0 );
//ini_set( 'pcre.backtrack_limit',1000000 );
//ini_set( 'pcre.recursion_limit',1000000 );
error_reporting (E_ERROR | E_WARNING | E_PARSE);
date_default_timezone_set( 'Europe/Kiev' );

$cur_date = date('d.m.y');
$cur_date_sheet = date('dmy');
//$cur_date = '07.11.16';
//$cur_date_sheet = '071116';

	include( '/var/www/lib/functions.php' );
	include( '/var/www/lib/PHPExcel.php' );
	include( '/var/www/lib/PHPExcel/Writer/Excel2007.php' );

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	include('/var/www/lib/PHPMailer-6.0.2/src/Exception.php');
	include('/var/www/lib/PHPMailer-6.0.2/src/PHPMailer.php');
	include('/var/www/lib/PHPMailer-6.0.2/src/SMTP.php');
/**
  * проверяем параметры командной строки
  * php app.php 0 rondell_0 rondell Report_Rondell_RU_031116_0 rondell_0
  * php app.php {номер движка} {файл настроек движка} {бренд} {имя файла отчёта и тема письма} {в конце отослать по адресатам в файле}
  */
if (empty($argv)):
  die('engine doesn\'t connected...'); // Если не ввели параметр engine
else: 
  define('ENGINE_CURR', 		$argv[1]); 			// Текущий движок
	define('ENGINE_SETTINGS', $argv[2]);			// Файл настроек
	define('ENGINE_TYPE', 		$argv[3]); 			// Имя проекта
endif;

// Октроем файл конфигураций
$dataFfile = AC_DIR.'/settings/'.ENGINE_SETTINGS.'.xlsx';
$fileName  = $argv[4];

include(AC_DIR.'/engines/'.ENGINE_CURR.'.php');


if ($argv[5]) {
	$recipients = explode("\n", file_get_contents(AC_DIR.'/settings/mail/'.$argv[5].'.txt'));
	array_walk($recipients, 'trim_value');
	echo 'sending email...';
	include(AC_DIR.'/sender.php');
}

//if (strlen($argv[3])>1) {
	if ($argv[1] == 'polaris.ua_big') {
		if ($argv[4]) {
			$recipients = explode("\n", file_get_contents(AC_DIR.'/settings/mail/'.$argv[4].'.txt'));
			array_walk($recipients, 'trim_value');
			echo 'sending email...';
			include(AC_DIR.'/sender.php');
		}
	} elseif ($argv[1] == 'polaris_big') {
		if ($argv[4]) {
			$recipients = explode("\n", file_get_contents(AC_DIR.'/settings/mail/'.$argv[4].'.txt'));
			array_walk($recipients, 'trim_value');
			echo 'sending email...';
			include(AC_DIR.'/sender.php');
		}
	}
