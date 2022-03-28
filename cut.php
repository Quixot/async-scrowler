<?php
if (empty($_GET)):
  die('engine doesn\'t connect...'); // Если не ввели параметр engine
else: 
  define('ENGINE_CURR', $_GET['EC']); 		// Текущий движок
	define('ENGINE_TYPE', $_GET['ET']); 		// Тип группы товаров
	define('EXTRA_PARAM', $_GET['EP']);			// Дополнительные движки. Например, для создания списка характеристик или закачки картинок
endif;

include( '/var/www/lib/functions.php');
include( '/var/www/engines/'.ENGINE_CURR.'/regexp.php');
include( '/var/www/engines/'.ENGINE_CURR.'/callback.php');