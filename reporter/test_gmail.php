<?php
	include('/var/www/lib/PHPMailer-master/class.phpmailer.php');
	include('/var/www/lib/PHPMailer-master/class.smtp.php');

    $email = new PHPMailer;
    //Enable SMTP debugging. 
    $email->SMTPDebug = 0;
    //Set PHPMailer to use SMTP.
    $email->isSMTP();
    //Set SMTP host name                          
    $email->Host = 'smtp.gmail.com';
    //Set this to true if SMTP host requires authentication to send email
    $email->SMTPAuth = true;
    //Provide username and password     
    $email->Username = 'pricinglogix@gmail.com';
    $email->Password = 'GjCrkjyeAelpb';
    //If SMTP requires TLS encryption then set it
    $email->SMTPSecure = "ssl";
    //Set TCP port to connect to 
    $email->Port = 465;
    $email->From = 'pricinglogix@gmail.com';  
    $email->FromName = 'pricinglogix';
    $email->addAddress('alexandr.volkoff@gmail.com');
    $email->isHTML(true);
    $email->Subject = 'Aaaaa, Ya nastroil dva akkaunta na odnom servere!!!!!!!!';
    $email->Body = 'Aaaaa, Ya nastroil dva akkaunta na odnom servere!!!!!!!!';
    $email->AltBody = "This is the plain text version of the email content";
    if (!$email->send()) {
        echo "Mailer Error: " . $email->ErrorInfo;
    }
    else {
           echo 'Mail Sent Successfully';
    }