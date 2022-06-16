<?php
require_once("./mailer/class.phpmailer.php");
require_once("./mailer/class.smtp.php");

function sendemail_verify($name, $email, $verify_token) {
        //sendemail_reminder($frName, $yEmail, $DOB);
            $mail = new PHPMailer();

            $mail->SMTPDebug = 2;
            $mail->isSMTP();                                                    //Send using SMTP
            $mail->SMTPAuth   = true;                                           //Enable SMTP authentication

            $mail->Host       = 'smtp.gmail.com';                               //Set the SMTP server to send through
            $mail->Username   = 'ashrafamit9227@gmail.com';                         //SMTP username
            $mail->Password   = 'tqjcecrpjpkfonep';                             //SMTP password

            $mail->SMTPSecure = 'tls';                                              //Enable implicit TLS encryption
            $mail->Port       = 587;                                            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            $mail->setFrom('ashrafamit9227@gmail.com',$name);
            $mail->addAddress($email);                                          //Name is optional
        
            $mail->isHTML(true);                                                    //Set email format to HTML
            $mail->Subject = 'Email Verification From Funda of Web IT';

            $email_template = "
    <h2>You have registered with Funda of Web IT</h2>
    <h5>Verify your email address with the link given below to login</h5>
    <br><br>
    <a href='http://localhost/Maternal_and_Child_Health_Care_Practice/combine mailer/verify-email.php?token=$verify_token'>Click Me</a>
    ";

            $mail->Body = $email_template;
            $mail->send();
    }


?>
