<?php
session_start();
$page_title = "Home Page";
include('./includes/header.php');
include('./includes/navbar.php');
?>


<div class="container">
  <div class="row mb-5">
    <div class="col-md-7">

      <?php if (!isset($_SESSION['authenticated'])) : ?>
        <p>Please Log in</p>
      <?php endif ?>

      <?php if (isset($_SESSION['authenticated'])) : ?>
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
            <h5>Username: <?= $_SESSION['auth_user']['username']; ?> </h5>
            <h5>Email ID: <?= $_SESSION['auth_user']['email']; ?> </h5>
            <h5>Phone No: <?= $_SESSION['auth_user']['phone']; ?> </h5>
            <h5>Auth ID: <?= $_SESSION['auth_user']['authID']; ?> </h5>
          </div>
        </div>
      <?php endif ?>
    </div>
    <div class="col-md-5">
      <h1>Due Date Calculator</h1>

      <form method="POST">

        First day of your last menstrual period:
        <input type="date" name="dates" ><br>

        <p>Usual number of days in your period: <select name="days">
            <?php
            for ($i = 20; $i <= 45; $i++) {
              if ($i == 28) $selected = 'selected="true"';
              else $selected = '';
              echo "<option $selected value='$i'>$i</option>";
            }
            ?>
          </select></p>
        <input type="submit" name="submit" value="Calculate" class="btn btn-outline-info w-100"><br>
      </form>

      <!-- CALCULATOR -->
      <?php
      if(isset($_POST['submit'])):
        $_SESSION['reminder'] = TRUE;
      endif;

      if(isset($_SESSION['reminder'])){
        include('calculator.php');
      }
      
       ?>
    </div>
  </div>
</div>

<!-- INCLUDE FOOTER -->
<?php
include('./includes/footer.php');
?>