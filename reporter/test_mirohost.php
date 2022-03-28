<?php
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
		'alexandr.volkoff@gmail.com'
	);
	foreach($recipientscopy as $mailaddr) {
  	$email->AddCC($mailaddr);
	}

	$file_to_attach = '/var/www/reporter/reports/polaris_for_search.xlsx';
	$email->AddAttachment( $file_to_attach , 'polaris_for_search.xlsx' );	

	var_dump($email->Send());
	print_r($recipients);	
