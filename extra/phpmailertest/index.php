<?php
error_reporting(E_ALL);
require("PHPMailer_5.2.4/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP(); //set mailer to use SMTP
$mail->SMTPDebug = 2;
$mail->From = "tayboonhau@gmail.com";
$mail->FromName = "BusForAll.com";
$mail->Host = "smtp.gmail.com"; //specif smtp server
$mail->SMTPSecure= "ssl"; //Used instead of TLS when only POP mail
$mail->Port = 465; //Used instead of 587 when only POP mail is selected
$mail->SMTPAuth = true;
$mail->Username = "tayboonhau@gmail.com"; //SMTP username, (your email)
$mail->Password = "tbh950427"; //SMTP password, (your password)
$mail->AddAddress("bryantanhw@gmail.com", "Bryan Tan");
$mail->AddReplyTo("bryantanhw@gmail.com", "bryantanhw");
$mail->WordWrap = 50; //set word warp
//$mail->AddAttachment("C:\\temp\\js-bak.sql"); //add attachments
//$mail->AddAttachment("c:/temp/11-10-00.zip");

$mail->IsHTML(true);
$mail->Subject = 'HELLO HOW ARE YOU';
$mail->Body = 'CONGRATULATIONS';

if($mail->Send()) {echo "Send mail successfully";}
else {echo "send mail fail";}

?>