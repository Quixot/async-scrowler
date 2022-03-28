<?php
	$cmd = 'php /var/www/reporter/app.php polaris_universal polaris_common polaris Report_Polaris_RU_$(date +\%d\%m\%y)_e$(date +\%H\%M) me';
	echo 'request: '.$cmd.PHP_EOL;
	echo '<pre>';

	$response = exec($cmd, $out, $err);
	
	echo $response;
	print_r($out);
	echo '</pre>';
