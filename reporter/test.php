<?php

	include('/var/www/lib/PHPMailer-master/class.phpmailer.php');
	include('/var/www/lib/PHPMailer-master/class.smtp.php');
	$fileName = 'Report_Maxwell_RU_231116_test';

	$email = new PHPMailer(true);
$email->IsSMTP();
$email->CharSet = 'UTF-8';
$email->Host = "mx1.mirohost.net";
$email->Port = 25;
$email->SMTPAuth = true;
$email->Username = "info@pricinglogix.com";
$email->Password = "*rybuyC?D7hf";
	$email->SMTPDebug = 3;
	$email->isHTML(true);
	$email->From      = 'info@pricinglogix.com';
	$email->FromName  = 'Мониторинг Цен. PricingLogix';
	$email->Subject   = $fileName.' automatic mailing';
	$email->AddEmbeddedImage('/var/www/reporter/settings/logo.png', 'pricinglogix-logo', 'logo.png');
	$email->Body = '<img alt="PHPMailer" src="cid:pricinglogix-logo"><br><br>лучший инструмент<br>для вашего бизнеса!<a href="http://pricinglogix.com/">http://pricinglogix.com</a>';
	
	$recipients = array('alexandr.volkoff@gmail.com');
	foreach($recipients as $mailaddr) {
  	$email->AddAddress($mailaddr);
	}


	//$file_to_attach = '/var/www/reporter/reports/'.date('d.m.y').'/'.$fileName.'.xlsx';
	//$email->AddAttachment( $file_to_attach , $fileName.'.xlsx' );

	$email->Send();
	
