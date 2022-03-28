<?php 
$zip = new ZipArchive();
$filename = "/var/www/reporter/test.zip";

if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
    exit("Невозможно открыть <$filename>\n");
}


$reportsArray = glob('/var/www/vitek/engines/*/data/*'.date("d.m.y").'*.data');
print_r($reportsArray);
foreach ($reportsArray as $key) {
$zip->addFile($key);
}
echo "numfiles: " . $zip->numFiles . "\n";
echo "status:" . $zip->status . "\n";
$zip->close();

die();

include( '/var/www/lib/PHPExcel.php' );
include( '/var/www/lib/PHPExcel/Writer/Excel2007.php' );
	$xxx = '=HYPERLINK("http://google.com", 5)';

$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("PricingLogix");
	$objPHPExcel->getProperties()->setTitle("PricingLogix");
	$objPHPExcel->getProperties()->setSubject("PricingLogix" . ' ' . date('H:i:s'));
	$objPHPExcel->getProperties()->setDescription("generated for by PricingLogix");
$objPHPExcel->getActiveSheet()->setCellValue('A1', $xxx);

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	//$objWriter->setPreCalculateFormulas(true);
	$objWriter->save('/var/www/reporter/'.date('d.m.y').'_test.xlsx');

die();


		require_once('/var/www/lib/PHPMailer-master/class.phpmailer.php');
		$email = new PHPMailer();
		$email->isHTML(true);
		$email->From      = 'pricinglogix@gmail.com';
		$email->FromName  = 'PricingLogix';
		$email->Subject   = 'Rondell_RU '.date('dmy').'_0 automatic mailing';
		$email->AddEmbeddedImage('/var/www/reporter/settings/logo.png', 'pricinglogix-logo', 'logo.png');
		$email->Body      = '<img alt="PHPMailer" src="cid:pricinglogix-logo"><br><br>Лучший инструмент<br>для Вашего бизнеса<br><br><a href="http://pricinglogix.com/">http://pricinglogix.com</a>';
		//$email->AddAddress(  'rsp.bt.tech@gmail.com' );
		$recipients = array('alexandr.volkoff@gmail.com', 'volkoff@mail.ua');
		foreach($recipients as $mailaddr) {
			echo $mailaddr;
  		//$email->AddAddress("'".$email."'");
		}

		//$file_to_attach = '/var/www/reporter/reports'.date('d.m.y').'/Report_Rondell_RU_'.date('dmy').'_0';
		//$email->AddAttachment( $file_to_attach , 'Report_Rondell_RU_'.date('dmy').'_0' );

		return $email->Send();