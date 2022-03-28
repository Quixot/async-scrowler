<?php
/**
 * Копирует вчерашний файлик и делает сегодняшний
 */
/**/
/*


$cities = array(
'cheboksary',
'moscow',
'petrozavodsk',
'spb',
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris/engines/komus.ru/data/'.date("d.m.y").'_komus.ru_polaris_'.$city.'.data';
	$newfile = '/var/www/polaris/engines/komus.ru/data/'.date("d.m.y", time()+60*60*24).'_komus.ru_polaris_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_komus.ru_polaris_'.$city.'.data'.PHP_EOL;
}
*/
$cities = array(
	'arhangelsk',
	'cheboksary',
	'chelyabinsk',
	'habarovsk',
	'kazan',
	'krasnodar',
	'krasnoyarsk',
	'moscow',
	'naberezhnye-chelny',
	'novgorod',
	'novosibirsk',
	'omsk',
	'perm',
	'petrozavodsk',
	'pyatigorsk',
	'rostov',
	'samara',
	'spb',
	'ufa',
	'vladivostok',
	'volgograd',
	'yekaterinburg',
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris/engines/positronica.ru/data/'.date("d.m.y").'_positronica.ru_polaris_'.$city.'.data';
	$newfile = '/var/www/polaris/engines/positronica.ru/data/'.date("d.m.y", time()+60*60*24).'_positronica.ru_polaris_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_positronica.ru_polaris_'.$city.'.data'.PHP_EOL;
}

$cities = array(
'chelyabinsk',
'krasnoyarsk',
'moscow',
'novosibirsk',
'omsk',
'ufa',
'vladivostok',
'yekaterinburg',
'kazan',
'naberezhnye-chelny',
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris/engines/rbt.ru/data/'.date("d.m.y").'_rbt.ru_polaris_'.$city.'.data';
	$newfile = '/var/www/polaris/engines/rbt.ru/data/'.date("d.m.y", time()+60*60*24).'_rbt.ru_polaris_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_rbt.ru_polaris_'.$city.'.data'.PHP_EOL;
}

$cities = array(
'moscow',
'spb'
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris/engines/imperiatechno.ru/data/'.date("d.m.y").'_imperiatechno.ru_polaris_'.$city.'.data';
	$newfile = '/var/www/polaris/engines/imperiatechno.ru/data/'.date("d.m.y", time()+60*60*24).'_imperiatechno.ru_polaris_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_imperiatechno.ru_polaris_'.$city.'.data'.PHP_EOL;
}

$cities = array(
'moscow'
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris/engines/auchan.ru/data/'.date("d.m.y").'_auchan.ru_polaris_'.$city.'.data';
	$newfile = '/var/www/polaris/engines/auchan.ru/data/'.date("d.m.y", time()+60*60*24).'_auchan.ru_polaris_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_auchan.ru_polaris_'.$city.'.data'.PHP_EOL;
}
/*
$cities = array(
'moscow',
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris/engines/vstroyka-solo.ru/data/'.date("d.m.y").'_vstroyka-solo.ru_polaris_'.$city.'.data';
	$newfile = '/var/www/polaris/engines/vstroyka-solo.ru/data/'.date("d.m.y", time()+60*60*24).'_vstroyka-solo.ru_polaris_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_vstroyka-solo.ru_polaris_'.$city.'.data'.PHP_EOL;
}

$cities = array(
'moscow',
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris/engines/unixmart.ru/data/'.date("d.m.y").'_unixmart.ru_polaris_'.$city.'.data';
	$newfile = '/var/www/polaris/engines/unixmart.ru/data/'.date("d.m.y", time()+60*60*24).'_unixmart.ru_polaris_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_unixmart.ru_polaris_'.$city.'.data'.PHP_EOL;
}

$cities = array(
'arhangelsk',
'cheboksary',
'chelyabinsk',
'habarovsk',
'kazan',
'krasnodar',
'krasnoyarsk',
'moscow',
'naberezhnye-chelny',
'novgorod',
'novosibirsk',
'omsk',
'perm',
'petrozavodsk',
'pyatigorsk',
'rostov',
'samara',
'spb',
'ufa',
'vladivostok',
'volgograd',
'yekaterinburg',
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris/engines/beru.ru/data/'.date("d.m.y").'_beru.ru_polaris_'.$city.'.data';
	$newfile = '/var/www/polaris/engines/beru.ru/data/'.date("d.m.y", time()+60*60*24).'_beru.ru_polaris_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_beru.ru_polaris_'.$city.'.data'.PHP_EOL;
}
*/

$cities = array(
'arhangelsk',
'cheboksary',
'chelyabinsk',
'habarovsk',
'kazan',
'krasnodar',
'krasnoyarsk',
'moscow',
'naberezhnye-chelny',
'novgorod',
'novosibirsk',
'omsk',
'perm',
'petrozavodsk',
'pyatigorsk',
'rostov',
'samara',
'spb',
'ufa',
'vladivostok',
'volgograd',
'yekaterinburg',
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris/engines/ozon.ru/data/'.date("d.m.y").'_ozon.ru_polaris_'.$city.'.data';
	$newfile = '/var/www/polaris/engines/ozon.ru/data/'.date("d.m.y", time()+60*60*24).'_ozon.ru_polaris_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_ozon.ru_polaris_'.$city.'.data'.PHP_EOL;
}


$cities = array(
'arhangelsk',
'cheboksary',
'chelyabinsk',
'habarovsk',
'kazan',
'krasnodar',
'krasnoyarsk',
'moscow',
'naberezhnye-chelny',
'novgorod',
'novosibirsk',
'omsk',
'perm',
'petrozavodsk',
'pyatigorsk',
'rostov',
'samara',
'spb',
'ufa',
'vladivostok',
'volgograd',
'voronezh',
'yekaterinburg',
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris/engines/dns-shop.ru/data/'.date("d.m.y").'_dns-shop.ru_polaris_'.$city.'.data';
	$newfile = '/var/www/polaris/engines/dns-shop.ru/data/'.date("d.m.y", time()+60*60*24).'_dns-shop.ru_polaris_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_dns-shop.ru_polaris_'.$city.'.data'.PHP_EOL;
}


$cities = array(
'kiev'
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris.ua/engines/foxtrot.com.ua/data/'.date("d.m.y").'_foxtrot.com.ua_polaris.ua_'.$city.'.data';
	$newfile = '/var/www/polaris.ua/engines/foxtrot.com.ua/data/'.date("d.m.y", time()+60*60*24).'_foxtrot.com.ua_polaris.ua_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_foxtrot.com.ua_polaris.ua_'.$city.'.data'.PHP_EOL;
}
$cities = array(
'kiev'
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris.ua/engines/comfy.ua/data/'.date("d.m.y").'_comfy.ua_polaris.ua_'.$city.'.data';
	$newfile = '/var/www/polaris.ua/engines/comfy.ua/data/'.date("d.m.y", time()+60*60*24).'_comfy.ua_polaris.ua_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_comfy.ua_polaris.ua_'.$city.'.data'.PHP_EOL;
}




/*
$cities = array(
'kiev'
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris.ua/engines/aleco.com.ua/data/'.date("d.m.y").'_aleco.com.ua_polaris.ua_'.$city.'.data';
	$newfile = '/var/www/polaris.ua/engines/aleco.com.ua/data/'.date("d.m.y", time()+60*60*24).'_aleco.com.ua_polaris.ua_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_aleco.com.ua_polaris.ua_'.$city.'.data'.PHP_EOL;
}
$cities = array(
'kiev'
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris.ua/engines/didi.ua/data/'.date("d.m.y").'_didi.ua_polaris.ua_'.$city.'.data';
	$newfile = '/var/www/polaris.ua/engines/didi.ua/data/'.date("d.m.y", time()+60*60*24).'_didi.ua_polaris.ua_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_didi.ua_polaris.ua_'.$city.'.data'.PHP_EOL;
}
$cities = array(
'kiev'
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris.ua/engines/f.ua/data/'.date("d.m.y").'_f.ua_polaris.ua_'.$city.'.data';
	$newfile = '/var/www/polaris.ua/engines/f.ua/data/'.date("d.m.y", time()+60*60*24).'_f.ua_polaris.ua_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_f.ua_polaris.ua_'.$city.'.data'.PHP_EOL;
}

$cities = array(
'kiev'
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris.ua/engines/protovar.com.ua/data/'.date("d.m.y").'_protovar.com.ua_polaris.ua_'.$city.'.data';
	$newfile = '/var/www/polaris.ua/engines/protovar.com.ua/data/'.date("d.m.y", time()+60*60*24).'_protovar.com.ua_polaris.ua_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_protovar.com.ua_polaris.ua_'.$city.'.data'.PHP_EOL;
}

$cities = array(
'kiev'
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris.ua/engines/mta.ua/data/'.date("d.m.y").'_mta.ua_polaris.ua_'.$city.'.data';
	$newfile = '/var/www/polaris.ua/engines/mta.ua/data/'.date("d.m.y", time()+60*60*24).'_mta.ua_polaris.ua_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_mta.ua_polaris.ua_'.$city.'.data'.PHP_EOL;
}

$cities = array(
'kiev'
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris.ua/engines/skidka.ua/data/'.date("d.m.y").'_skidka.ua_polaris.ua_'.$city.'.data';
	$newfile = '/var/www/polaris.ua/engines/skidka.ua/data/'.date("d.m.y", time()+60*60*24).'_skidka.ua_polaris.ua_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_skidka.ua_polaris.ua_'.$city.'.data'.PHP_EOL;
}


$cities = array(
'kiev'
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris.ua/engines/tehnomaster.com/data/'.date("d.m.y").'_tehnomaster.com_polaris.ua_'.$city.'.data';
	$newfile = '/var/www/polaris.ua/engines/tehnomaster.com/data/'.date("d.m.y", time()+60*60*24).'_tehnomaster.com_polaris.ua_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_tehnomaster.com_polaris.ua_'.$city.'.data'.PHP_EOL;
}

$cities = array(
'moscow'
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris/engines/lenta.com/data/'.date("d.m.y").'_lenta.com_polaris_'.$city.'.data';
	$newfile = '/var/www/polaris/engines/lenta.com/data/'.date("d.m.y", time()+60*60*24).'_lenta.com_polaris_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_lenta.com_polaris_'.$city.'.data'.PHP_EOL;
}




$cities = array(
'arhangelsk',
'cheboksary',
'chelyabinsk',
'habarovsk',
'kazan',
'krasnodar',
'krasnoyarsk',
'moscow',
'naberezhnye-chelny',
'novgorod',
'novosibirsk',
'omsk',
'perm',
'petrozavodsk',
'pyatigorsk',
'rostov',
'samara',
'spb',
'ufa',
'vladivostok',
'volgograd',
'voronezh',
'yekaterinburg',
	);
foreach ($cities as $city) {
	$file =		 '/var/www/polaris/engines/technopoint.ru/data/'.date("d.m.y").'_technopoint.ru_polaris_'.$city.'.data';
	$newfile = '/var/www/polaris/engines/technopoint.ru/data/'.date("d.m.y", time()+60*60*24).'_technopoint.ru_polaris_'.$city.'.data';
	copy($file, $newfile);
	chmod($newfile, 0777);
	echo 'copying: '.date("d.m.y").'_technopoint.ru_polaris_'.$city.'.data'.PHP_EOL;
}



*/

//mail('alexandr.volkoff@gmail.com', 'Копирование файлов для Polaris завершено', 'Копирование файлов для Polaris завершено', "From: info@pricinglogix.com");
