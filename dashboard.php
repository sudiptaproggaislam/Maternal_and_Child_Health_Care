<?php 
session_start();


if(!isset($_SESSION['authenticated']))
{
    $_SESSION['status'] = "Please login to access user dashboard.";
    header("location:login.php");
    exit(0);
}


$page_title = "Dashboard";
include('./includes/header.php');
include('./includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">


                <div class="alert">
                    <?php
                    if (isset($_SESSION['status'])) {
                    ?>
                        <div class="alert alert-success">
                            <h5><?= $_SESSION['status']; ?></h5>
                        </div>
                    <?php
                        unset($_SESSION['status']);
                    }
                    ?>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h4>User Dashboard</h4>
                    </div>
                    <div class="card-body">
                        <h4>Access when you are Logged In</h4>
                        <hr>
                        <h5>Username: <?= $_SESSION['auth_user']['username'];?> </h5>
                        <h5>Email ID: <?= $_SESSION['auth_user']['email'];?> </h5>
                        <h5>Phone No: <?= $_SESSION['auth_user']['phone'];?> </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('./includes/footer.php'); ?>