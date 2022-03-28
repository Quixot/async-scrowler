<?php 
include('/var/www/lib/PHPMailer-master/class.phpmailer.php');
include('/var/www/lib/PHPMailer-master/class.smtp.php');
	$date_for_name = date('dmy');


// ADD THIS:
$email = new PHPMailer();
$email->IsSMTP();
$email->CharSet = 'utf-8';
$email->Host = "mx1.mirohost.net";
$email->Port = 25;
$email->SMTPAuth = true;
$email->Username = "info@pricinglogix.com";
$email->Password = "*rybuyC?D7hf";
$email->isHTML(true);
$email->From      = 'info@pricinglogix.com';
$email->FromName  = 'PricingLogix';
$email->AddEmbeddedImage('/var/www/reporter/settings/logo.png', 'pricinglogix-logo', 'logo.png');


	$email->Subject   = 'Monitoring_Vitek-Rondell-Maxwell_'.$date_for_name.'_1';
	$email->Body  = 'Это ссылка на папку GOLDER-ELECTRONICS, по этой ссылке Вы всегда сможете скачать отчеты c <br>Яндекс.Диска ';
	$email->Body .= '<a href="https://yadi.sk/d/w463C-bx3JsuZE">https://yadi.sk/d/w463C-bx3JsuZE</a><br><br>';
	$email->Body .= '<img alt="PHPMailer" src="cid:pricinglogix-logo"><br><br>';
	$email->Body .= 'Лучший инструмент <br>для Вашего бизнеса<br><br>';
	$email->Body .= '<a href="http://pricinglogix.com/">http://pricinglogix.com/</a>';

$recipients = array('alexandr.volkoff@gmail.com', 'rsp.bt.tech@gmail.com');
foreach($recipients as $mailaddr) {
 	$email->AddAddress($mailaddr);
}
$email->Send();
print_r($recipients);