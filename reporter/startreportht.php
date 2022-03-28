<?php
	$index = date('Hi');
	$date = date('dmy_').$index;




	$cmd = 'php /var/www/reporter/app.php polaris_universal polaris_common polaris Report_Polaris_RU_'.$date.' me';//
	echo 'request: '.$cmd.PHP_EOL;
	echo '<pre>';

	$response = exec($cmd, $out, $err);
	
	echo $response;
	print_r($out);

	$cmd = 'php /var/www/reporter/app.php polaris_big polaris '.$index.' me';//;
	echo 'request: '.$cmd.PHP_EOL;
	echo '<pre>';

	$response = exec($cmd, $out, $err);
	
	echo $response;
	print_r($out);

	echo '</pre>';