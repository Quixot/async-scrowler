<?php
	$all_sites = glob('/var/www/polaris/engines/*');
	//print_r($all_sites);
	$list = '';

	foreach ($all_sites as $sitepath) {
		$datapathes = glob($sitepath.'/data/'.date("d.m.y").'_*');
		foreach ($datapathes as $key => $datapath) {
			//$list = $list.$datapath.PHP_EOL;
			$datapath = str_replace('/var/www', 'http://takeshi:kobayashimaru_3@82.193.126.150:5080', $datapath);
			//echo $datapath.PHP_EOL;
			$list = $list.$datapath.PHP_EOL;
		}
	}
	file_put_contents('/var/www/polaris/listpath.txt', $list);
