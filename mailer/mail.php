<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once ($path .'/vendor/phpmailer/phpmailer/src/Exception.php');
require_once ($path .'/vendor/phpmailer/phpmailer/src/PHPMailer.php');
require_once ($path .'/vendor/phpmailer/phpmailer/src/SMTP.php');


$mail = new PHPMailer(true);
$mail->IsSMTP();
$mail->Mailer = "smtp";

$mail->SMTPDebug  = 0;  
$mail->SMTPAuth   = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port       = 587;
$mail->Host       = "smtp.gmail.com";
$mail->Username   = "noreplytsbcarshare@gmail.com";
$mail->Password   = "tsbcarshare123";

include($path ."/mailer/sendemail.php");
