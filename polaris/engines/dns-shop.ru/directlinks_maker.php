<?php
	$city_arr = array(
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

	$heap = unserialize(file_get_contents('/var/www/polaris/heap/27.02.20_2.data'));
	//file_put_contents('/var/www/polaris/engines/dns-shop.ru/links', print_r($heap, 1));
	//die();

	foreach ($heap['dns-shop.ru'] as $key => $value) {
		echo $key.PHP_EOL;die();
		print_r($value);die();
	}

	foreach ($city_arr as $city) {
		echo $city.PHP_EOL;
		$itemsArray = unserialize(file_get_contents('/var/www/polaris/engines/dns-shop.ru/data/'.date("d.m.y").'_dns-shop.ru_polaris_'.$city.'.data'));
		foreach ($itemsArray as $key => $value) {
			//print_r($value);die();
			$directlinks[] = $value[5];
		}
	}
	$directlinks = array_unique($directlinks);

	file_put_contents('/var/www/polaris/engines/dns-shop.ru/links', $directlinks);
	
