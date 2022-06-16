 <!-- Primary Navigation -->
 <nav class="navbar navbar-expand-lg navbar-dark color-second-bg">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Maternal And Child Health Care</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav m-auto font-rubik">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Category</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Categories</a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">Prenatal Care</a></li>
                <li><a class="dropdown-item" href="#">Postnatal Care</a></li>
                <!-- <li><hr class="dropdown-divider"></li> -->
                <li><a class="dropdown-item" href="#">Maternal Health</a></li>
                <li><a class="dropdown-item" href="#">Infant Health</a></li>
                <li><a class="dropdown-item" href="#">Mental Health</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Blog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Query</a>
            </li>
            <li class="nav-item">
              <div class="ddown">
                <a class="nav-link" href="#">Other <i class="fas fa-caret-down"></i></a>
                <div class="ddown-content">
                  <a href="i">Link 1</a>
                  <a href="#">Link 2</a>
                  <a href="#">Link 3</a>
                </div>
              </div>
            </li>

            

          </ul>

          <div class="justify-content-between font-rubik">
            <?php if(!isset($_SESSION['authenticated'])) : ?>
            <a href="login.php" class="px-2 py-2 rounded-pill color-primary-bg text-white font-size-12" style="text-decoration:none;">Sign In</a>
            <a href="register.php" class="px-2 py-2 rounded-pill color-primary-bg text-white font-size-12" style="text-decoration:none;">Sign Up</a>
            <?php endif ?>
            <?php if(isset($_SESSION['authenticated'])) : ?>
            <a href="logout.php" class="px-2 py-2 rounded-pill color-primary-bg text-white font-size-12" style="text-decoration:none;">Sign Out</a>
            <?php endif ?>
          </div>
        </div>
      </div>
    </nav>
    <!-- !Primary Navigation -->
  </header>
  <!-- !Start #header -->

  <!-- start #main-site -->
  <main id="main-site">