<?php
    session_start();
    include('dbcon.php');
    require_once("./mailer/class.phpmailer.php");
    require_once("./mailer/class.smtp.php");


function send_password_reset($name, $email, $verify_token)
{
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
        <h2>Hello $name</h2>
        <h4>You are receiving this email to reset your password of your account.</h4>
        <br>
        <a href = 'http://localhost/Maternal_and_Child_Health_Care_Practice/loginReg/password-change.php?token=$verify_token&email=$email'> Click me </a>
    ";

    $mail->Body = $email_template;
    $mail->send();
    // echo 'Message has been sent';

}


if(isset($_POST['reset_password_link'])){

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $token = md5(rand());

    $check_email = "SELECT email FROM users WHERE email = '$email' LIMIT 1";
    $check_email_run = mysqli_query($con, $check_email);

    if(mysqli_num_rows($check_email_run) > 0){

        $row = mysqli_fetch_array($check_email_run);
        $get_name = $row['name'];
        $get_email = $row['email'];

        $update_token = "UPDATE users SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
        $update_token_run = mysqli_query($con, $update_token);

        if($update_token_run){

            send_password_reset($get_name,$get_email,$token);
            $_SESSION['status'] = "Please check your email to get the password reset link.";
            header("Location: password-reset.php");
            exit(0);
        }
        else{
            $_SESSION['status'] = "Something went wrong #1";
            header("Location: password-reset.php");
            exit(0);
        }
    }

    else{
        $_SESSION['status'] = "No email found";
        header("Location: password-reset.php");
        exit(0);

    }
}

if(isset($_POST['password_update_btn'])){
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
    $token = mysqli_real_escape_string($con, $_POST['password_token']);

    if(!empty($token)){

        if(!empty($token) && !empty($new_password) && !empty($confirm_password)){

            //Checking token is valid or not
            $check_token = "SELECT verify_token FROM users WHERE verify_token = '$token' LIMIT 1";
            $check_token_run = mysqli_query($con, $check_token);

            if(mysqli_num_rows($check_token_run) > 0){

                if($new_password == $confirm_password){

                    $update_password = "UPDATE users SET password='$new_password' WHERE verify_token = '$token' LIMIT 1";
                    $update_password_run = mysqli_query($con, $update_password);

                    if($update_password_run){
                        $new_token = md5(rand());
                        $update_newtoken = "UPDATE users SET verify_token = '$new_token' WHERE verify_token = '$token' LIMIT 1";
                        $update_newtoken_run = mysqli_query($con, $update_newtoken);    

                        $_SESSION['status'] = "Password Updated Successfully.";
                        header("Location: login.php");
                        exit(0);
                    }
                    else{
                        $_SESSION['status'] = "Can not update password. Something went wrong.";
                        header("Location: password-change.php?token=$token&email=$email");
                        exit(0);
                    }
                }
                else{
                    $_SESSION['status'] = "Password and Confirm Password does not match.";
                    header("Location: password-change.php?token=$token&email=$email");
                    exit(0);
                }

            }
            else{
            $_SESSION['status'] = "Invalid token";
            header("Location: password-change.php?token=$token&email=$email");
            exit(0);
            }
        }
        else{
            $_SESSION['status'] = "All fields are mandatry";
            header("Location: password-change.php?token=$token&email=$email");
            exit(0);
        }

    }
    else{
        $_SESSION['status'] = "No token available";
        header("Location: password-change.php");
        exit(0);
    }

}

?>