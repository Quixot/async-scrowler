<?php
	/**
	 * dns-shop.ru.xml
	 */
	require ('lib/functions.php');
	ini_set('display_errors',1);
	ini_set('error_reporting',2047);

	$url = 'http://www.dns-shop.ru/up/sitemap/price_items_2.xml.gz';

	$lines = gzfile($url);
	foreach ($lines as $line) {
	    echo $line;
	}
