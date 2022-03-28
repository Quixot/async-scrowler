<?php
$listfiles = glob('/var/www/polaris/engines/dns-shop.ru/kill/*.data');


foreach ($listfiles as $key => $url) {
	echo $url.PHP_EOL;

	$temp = unserialize(file_get_contents($url));

	print_r($temp);
	file_put_contents("/var/www/polaris/engines/dns-shop.ru/kill/1.txt", print_r($temp, 1));
	die();

}