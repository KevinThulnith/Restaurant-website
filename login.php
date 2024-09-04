<!DOCTYPE html>
<html lang="en">

<head>
  <title>Gallery Cafe - Login</title>
  <?php require_once 'php/styles.php' ?>
  <style>
    body {
      display: flex;
      height: 100vh;
      justify-content: center;
      align-items: center;
    }

    p:hover a {
      color: var(--colorbt);
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <nav>
    <a href="index.html" class="brand"> Gallery Cafe </a>
    <div>
      <ul id="navbar">
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php" class="active">Login</a></li>
        <li class="user" id="user">
          <div class="circle"></div>
          <i class="fa fa-user"></i>
          <?php require_once 'php/exclamation.php' ?>
        </li>
      </ul>
      <div id="userbar">
        <?php require_once 'php/userbar.php' ?>
        <a href="#" id="asd"><i class="fa-solid fa-xmark"></i></a>
      </div>
    </div>
  </nav>
  <!-- END nav -->

  <?php
  require_once 'DbConnect.php';
  $ghr = false;

  // Check if form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data and confirm with data base
    $result = $conn->query("SELECT * FROM user WHERE username = '" . $_POST['username'] . "' AND password = '" . $_POST['password'] . "' AND is_active = true;");
    if ($result->num_rows > 0) {

      // set session varieble username
      $_SESSION['username'] = $_POST['username'];

      // create uswer data array json
      while ($row = $result->fetch_assoc()) {
        $user_data = [
          'name' => $row['name'],
          'user_id' => $row['user_id'],
          'is_admin' => $row['is_admin'],
          'is_staff' => $row['is_staff'],
          'is_customer' => $row['is_customer']
        ];
      }
      $user_data_json = json_encode($user_data);

      // Set session variable
      if (!isset($_SESSION['username'])) {
        header("Location: login.php"); //Redirect to login page if not logged in 
        exit();
      }

      setcookie('user_data', $user_data_json, time() + (86400 * 30), "/"); // set cockie
      header("Location:index.php");
      exit();
    }
    $ghr = true;
  }
  ?>

  <section class="ftco-section ftco-no-pt ftco-no-pb">
    <div class="container">
      <div class="row d-flex">
        <div class="col-md-5 ftco-animate img img-2" style="background-image: url(images/bg_1.jpg)"></div>
        <div class="col-md-7 ftco-animate makereservation p-4 p-md-5">
          <div class="heading-section ftco-animate mb-5">
            <span class="subheading">User Login</span>
            <h2 class="mb-4">Login</h2>
          </div>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="formi" method="post">
            <div class="row">
              <?php if ($ghr) echo "<div class='message'> <i class='fa-solid fa-circle'></i> Wrong username or password </div>"; ?>
              <div class="col-md-6 form-group">
                <label>Username</label>
                <input type="text" class="form-control" placeholder="username" name="username" required />
              </div>
              <div class="col-md-6 form-group"></div>
              <div class="col-md-6 form-group">
                <label>Password</label>
                <input type="password" class="form-control" placeholder="password" name="password" required />
              </div>
              <div class="col-md-12 mt-3">
                <div class="form-group">
                  <input type="submit" value="Login" class="btn btn-primary py-3 px-5" />
                </div>
              </div>
              <div class="col-md-12 mt-3" style="margin: -50px 0;">
                <div class="form-group">
                  <p>Forgot <a href="resetPassword.php">password?</a></p>
                </div>
              </div>
            </div>
          </form>
          <?php if (isset($error)) echo "<p>$error</p>" ?>
        </div>
      </div>
    </div>
  </section>
  <!-- Form -->

  <?php require_once 'php/loader.php' ?>
  <?php require_once 'php/scripts.php' ?>
</body>

</html>