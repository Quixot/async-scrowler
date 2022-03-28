<?php
	$index = date('Hi');
	$date = date('dmy_').$index;




	$cmd = 'php /var/www/reporter/app.php polaris_universal polaris_common polaris Report_Polaris_RU_'.date('dmy_').'1 me';//
	echo 'request: '.$cmd.PHP_EOL;
	echo '<pre>';

	$response = exec($cmd, $out, $err);
	
	echo $response;
	print_r($out);

	$cmd = 'php /var/www/reporter/app.php polaris_big polaris 1 me';//;
	echo 'request: '.$cmd.PHP_EOL;
	echo '<pre>';

	$response = exec($cmd, $out, $err);
	
	echo $response;
	print_r($out);

	echo '</pre>';