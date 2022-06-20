<?php
session_start();
$page_title = "Home Page";
include('./includes/header.php');
include('./includes/navbar.php');

function due($dateOfLMP, $periodCycle)
{
  include('dbcon.php');
  $visit = array();
  $name = $_SESSION['auth_user']['username'];
  $phone = $_SESSION['auth_user']['phone'];
  $email = $_SESSION['auth_user']['email'];
  $verify_token = $_SESSION['auth_user']['authID'];

  $lasttime = strtotime($dateOfLMP);

  // next period start
  $next_period = $lasttime + $periodCycle * 24 * 3600;
  $next_period = date("F d, Y", $next_period);

  //first fertile day
  $firstdaytime = $lasttime + $periodCycle * 24 * 3600 - 16 * 24 * 3600;
  $firstday = date("F d, Y", $firstdaytime);

  //last fertile day
  $lastdaytime = $lasttime + $periodCycle * 24 * 3600 - 12 * 24 * 3600;
  $lastday = date("F d, Y", $lastdaytime);

  //have to adjust due date?
  $diff = $periodCycle - 28;

  //due date $date + 280 days
  $duedatetime = $lasttime + 280 * 24 * 3600 + $diff * 24 * 3600;
  $duedate = date("F d, Y", $duedatetime);

  //output
  echo '<br><h3>Here are the results based on the information you provided:</h3><br>';
  echo 'Last period :' . date("F d, Y", $lasttime) . '<br>Next period: ' . $next_period . '<br>First firtile day: ' . $firstday . '<br>Last firtile day: ' . $lastday . '<br>';
  echo 'Your estimated <b>due date</b> will be : ' . $duedate;

  //visits to doctor
  //4 to 28 weeks--> One visit per month (every four weeks)
  for ($i = 4; $i < 29; $i = $i + 4) {
    array_push($visit,  date("y-m-d", $lasttime + $i * 7 * 24 * 3600));
  }

  //28 to 36 weeks --> Two visits per month (every two to three weeks)
  for ($i = 30; $i < 37; $i = $i + 2) {
    array_push($visit,  date("y-m-d", $lasttime + $i * 7 * 24 * 3600));
  }

  //36 weeks to delivery --> One visit per week
  for ($i = 37; $i < 41; $i++) {
    array_push($visit,  date("y-m-d", $lasttime + $i * 7 * 24 * 3600));
  }

  echo "<br><br><p><b>*Recommended Schedule for a Healthy Pregnancy :<br>";
  echo "For a healthy pregnancy, your doctor will probably want to see you on the following recommended schedule of prenatal visits:</b></p>";
  echo "<ul>
    <li>Weeks 4 to 28: 1 prenatal visit a month</li>
    <ul>
        <li>1st visit date : $visit[0]</li>
        <li>2nd visit date : $visit[1]</li>
        <li>3rd visit date : $visit[2]</li>
        <li>4th visit date : $visit[3]</li>
        <li>5th visit date : $visit[4]</li>
        <li>6th visit date : $visit[5]</li>
        <li>7th visit date : $visit[6]</li>
        
        
    </ul>
    <li>Weeks 28 to 36: 1 prenatal visit every 2 weeks</li>
    <ul>
    <li>8th visit date : $visit[7]</li>
    <li>9th visit date : $visit[8]</li>
    <li>10th visit date : $visit[9]</li>
    <li>11th visit date : $visit[10]</li>
    
    </ul>
    <li>Weeks 36 to 40: 1 prenatal visit every week</li>
    <ul>
    <li>12th visit date : $visit[11]</li>
    <li>13th visit date : $visit[12]</li>
    <li>14h visit date : $visit[13]</li>
    <li>15th visit date : $visit[14]</li>
    </ul>
    
</ul>";

?>

<!-- Buttons -->
  <form method="POST">
    <div class="row d-flex">
      <div class="col-lg-6">
        <input type="submit" name="unset" value="Clear ALL" class="btn btn-outline-info w-100">
      </div>
      <div class="col-lg-6">
        <input type="submit" name="reminderbtn" value="Get Reminder" class="btn btn-outline-info w-100">
        <small class="font-rale text-primary">*will send mail one day before visit</small>
      </div>
    </div>
  </form>



<?php
  if (isset($_POST['reminderbtn'])) {
    for ($i = 0; $i < 15; $i++) {
      $query = "INSERT INTO reminder(name,phone,email,verify_token,rdate) values('$name','$phone','$email','$verify_token','$visit[$i]')";
      $query_run = mysqli_query($con, $query);
    }
  }

  if (isset($_POST['unset'])) {
    // $delete_query = "DELETE FROM reminder where r_status=0 and verify_token='$verify_token'";
    // $delete_query_run = mysqli_query($con, $delete_query);

    unset($_SESSION['reminder']);
    // header("Refresh:0");
    echo "<script>refreshDiv();</script>";
    
  }
}
?>


<!-- ekhane pura page er container suru -->
<div class="container-fluid">
  <div class="row mb-5">
    <!-- eta left er column ta, ignore koro -->
    <div class="col-md-8">

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
      <?php
        $name = $_SESSION['auth_user']['username'];
        $phone = $_SESSION['auth_user']['phone'];
        $email = $_SESSION['auth_user']['email'];
        $verify_token = $_SESSION['auth_user']['authID'];
      endif ?>
    </div>


<!-- ekhan theke drkr -->
<!-- eta due date er column -->
    <div class="col-md-4 mx-0 px-0">
      <div class="container mx-0 px-0">
        <div class="row justify-content-center mx-0 px-0">
          <div class="col round ">
            <div class="name">
              <div class="card shadow">
                <div class="card-header ">
                  <h4 align="center" class="name">Due Date Calculator</h5>
                </div>
                <div class="card-body">
                  <div class="duedate">
                    <form method="POST">
                      <div>
                        <p align="center">Select the first day of your last menstrual period: <input type="date" name="dates"></p>
                      </div>
                      <br>
                      <p align="center" class="mb-5">Usual number of days in your period: <select name="days">
                          <?php
                          for ($i = 20; $i <= 45; $i++) {
                            if ($i == 28) $selected = 'selected="true"';
                            else $selected = '';
                            echo "<option $selected value='$i'>$i</option>";
                          }
                          ?>
                        </select></p>
                      <input align="center" type="submit" name="submit" value="Calculate" class="btn btn-outline-info w-100"><br>

                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center mx-0 px-0">


        <!-- result show korar div -->
          <div class="col alert" id="refresh-div">
            <hr>
            <?php
            // Calculate button click krle reminder set hcche
            if (isset($_POST['submit'])) :
              $_SESSION['dateOfLMP']=$_POST['dates'];
              $_SESSION['periodCycle']=$_POST['days'];
              $_SESSION['reminder'] = TRUE;
            endif;


          // Function call if reminder set
            if (isset($_SESSION['reminder'])) {
              due($_SESSION['dateOfLMP'], $_SESSION['periodCycle']);
            }

            ?>

            <div>




            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- INCLUDE FOOTER -->
<?php
include('./includes/footer.php');
?>