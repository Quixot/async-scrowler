<?php
/**
 * Sender
 */
	$email = new PHPMailer\PHPMailer\PHPMailer();
	$email->CharSet = 'UTF-8';
	$email->IsSMTP();
	$email->Host = "mx1.mirohost.net";
	$email->Port = 25;
	$email->SMTPAuth = true;
	$email->Username = "monitoring@pricinglogix.com";
	$email->Password = "*rybuyC?D7hf";//*rybuyC?D7hf
	$email->isHTML(true);
	$email->From      = 'monitoring@pricinglogix.com';
	$email->FromName  = 'Мониторинг Цен';
	$email->Subject   = $fileName;
	$email->AddEmbeddedImage(AC_DIR.'/settings/logo.png', 'pricinglogix-logo', 'logo.png');
	$email->Body = '<img alt="PHPMailer" src="cid:pricinglogix-logo"><br><br>лучший инструмент<br>для вашего бизнеса!<br><a href="http://pricinglogix.com/">http://pricinglogix.com</a>';
	foreach($recipients as $mailaddr) {
  	$email->AddAddress($mailaddr);
	}

	$recipientscopy = array(
		'alexandr.volkoff@gmail.com',
		'rsp@a-trade.kiev.ua',
		'taras@a-trade.kiev.ua',
	);
	foreach($recipientscopy as $mailaddr) {
  	$email->AddCC($mailaddr);
	}
/**/
	if ($argv[1] == 'search') {
		echo 'ONE TYPE';
		$file_to_attach = '/var/www/reporter/reports/'.$argv[3].'_for_search.xlsx';
		$email->AddAttachment( $file_to_attach , $argv[3].'_for_search.xlsx' );
		echo $file_to_attach.PHP_EOL;
	} elseif (stripos($argv[1], 'polaris_big') !== false) {
		$email->Subject   = 'Report_Monitoring_Polaris_'.date('dmy').'_'.$argv[3];
		$file_to_attach = '/var/www/reporter/reports/polaris_big/'.$fileName;
		$email->AddAttachment( $file_to_attach , $fileName );
		echo $file_to_attach.PHP_EOL;
	} elseif ($argv[1] == 'polaris.ua_big') {
		$email->Subject   = 'Report_Monitoring_Polaris.UA_'.date('dmy').'_'.$argv[3];
		$file_to_attach = '/var/www/reporter/reports/polaris_big/'.$fileName;
		$email->AddAttachment( $file_to_attach , $fileName );
		echo $file_to_attach.PHP_EOL;
	} else {
		$file_to_attach = '/var/www/reporter/reports/'.date('d.m.y').'/'.$fileName.'.xlsx';
		$email->AddAttachment( $file_to_attach , $fileName.'.xlsx' );
		echo $file_to_attach.PHP_EOL;
		//$file_to_attach2 = '/var/www/reporter/reports/'.date('d.m.y').'/'.$red_report;
		//$email->AddAttachment( $file_to_attach2 , $red_report );	
		//echo $file_to_attach2.PHP_EOL;		
	}


	var_dump($email->Send());
	print_r($recipients);
