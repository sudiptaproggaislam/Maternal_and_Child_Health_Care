<?php

session_start();
include('dbcon.php');
include('phpMailer.php');

if (isset($_POST['register_button'])) 
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $verify_token = md5(rand());

    //check email id already exists or not
    $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);
}

if (mysqli_num_rows($check_email_query_run) > 0) 
{
    $_SESSION['status'] = "Email id already exists";
    header('location:register.php');
} 
else 
{
    //register user
    $query = "INSERT INTO users(name,phone,email,password,verify_token) values('$name','$phone','$email','$password','$verify_token')";
    $query_run = mysqli_query($con, $query);

    if ($query_run) 
    {
        sendemail_verify("$name", "$email", "$verify_token");
        $_SESSION['status'] = "Registration successful. Please verify your email.";
        header('location:register.php');
    } 
    else 
    {
        $_SESSION['status'] = "Registration failed";
        header('location:register.php');
    }
}
