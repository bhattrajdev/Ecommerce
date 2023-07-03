<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

ob_start();
//Load Composer's autoloader
require 'vendor/autoload.php';

function phpmailer($address,$verification_code){
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;           //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = "smtp.gmail.com";                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'codex1747@gmail.com';                     //SMTP username
    $mail->Password   = 'xbcolcvayebfgxjd';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('codex1747@gmail.com', 'SneakerStation');
    $mail->addAddress($address);              
    $mail->addReplyTo('codex1747@gmail.com', 'demo');



    //Content
    $mail->isHTML(true);                                  
    $mail->Subject = 'VERIFICATION CODE';
    $mail->Body    = 'Dear Customer,

Thank you for choosing SneakerStation. To ensure the security of your account, we require you to verify your email address.

Please use the following verification code to complete the verification process:

<br><br>
<b>Verification Code:'.$verification_code.'</b>
<br><br>

Thank you for your cooperation.

<br><br>
Best regards,

<br><br>
The SneakerStation Team';
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}
