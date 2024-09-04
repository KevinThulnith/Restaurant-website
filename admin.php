<!DOCTYPE html>
<html lang="en">

<head>
  <title>Gallery Cafe - Admin panal</title>
  <?php require_once 'php/styles.php' ?>
</head>

<body>
  <nav>
    <a href="index.html" class="brand"> Galary Cafe </a>
    <div>
      <ul id="navbar">
        <li><a href="index.php">Home</a></li>
        <li><a href="admin.php" class="active">Admin panal</a></li>
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

  <?php top("Admin panal", "Admin Panal") ?>

  <div class="dashbord">
    <?php
    require_once 'DbConnect.php';

    // setting up data 
    $arr = [0, 0, 0, 0, 0];
    $sql = [
      "SELECT COUNT(*) AS count FROM user WHERE is_customer = 1 ;",
      "SELECT COUNT(*) AS count FROM reservation;",
      "SELECT COUNT(*) AS count FROM food;",
      "SELECT COUNT(*) AS count FROM rstrnt_table;",
      "SELECT COUNT(*) AS count FROM user WHERE is_staff = 1;"
    ];
    for ($i = 0; $i < count($sql); $i++) {
      $result = $conn->query($sql[$i]);
      while ($row = $result->fetch_assoc()) {
        $arr[$i] = $row['count'];
      }
    }
    ?>
    <div class="box">
      <h3>Customers</h3><span><?php echo $arr[0] ?></span>
    </div>
    <div class="box">
      <h3>Resavations</h3><span><?php echo $arr[1] ?></span>
    </div>
    <div class="box">
      <h3>Food Items</h3><span><?php echo $arr[2] ?></span>
    </div>
    <div class="box">
      <h3>Tables</h3><span><?php echo $arr[3] ?></span>
    </div>
    <div class="box">
      <h3>Employees</h3><span><?php echo $arr[4] ?></span>
    </div>
  </div>

  <section class="admin-table">
    <h2>Staff member table</h2>
    <span>Information about resturant employees</span>
    <div class="table">
      <div class="table-header parent">
        <div class="table-header-data div1">User ID</div>
        <div class="table-header-data div2">Name</div>
        <div class="table-header-data div4">Username</div>
        <div class="table-header-data div3">Password</div>
        <div class="table-header-data div5">Status</div>
      </div>
      <div class="table-data">
        <?php
        require_once 'DbConnect.php';
        $result = $conn->query("SELECT user_id, name, password, username, is_active FROM user WHERE is_staff = true;");

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<div class='table-row parent'>";
            echo "<div class='table-cell div1'>" . $row['user_id'] . "</div>";
            echo "<div class='table-cell div2'>" . $row['name'] . "</div>";
            echo "<div class='table-cell div4'>" . $row['username'] . "</div>";
            echo "<div class='table-cell div3'>" . $row['password'] . "</div>";
            echo "<div class='table-cell div5'>";
            if ($row['is_active']) echo "<a href='disable.php?id=" . $row['user_id'] . "'> Active<i class='fa-solid fa-circle-check' style='margin-left:-15px'></i></a>";
            else echo "<a href='disable.php?id=" . $row['user_id'] . "'> Disabled </a>";
            echo "</div>";
            echo "</div>";
          }
        } else echo "<div class='table-row parent'> No records fund </div>";

        ?>
      </div>
    </div>
  </section>

  <section class="admin-table" style="margin-bottom: 50px;">
    <h2>Customer table</h2>
    <span>Information about customer accounts</span>
    <div class="table">
      <div class="table-header parent">
        <div class="table-header-data div1">User ID</div>
        <div class="table-header-data div2">Name</div>
        <div class="table-header-data div4">Username</div>
        <div class="table-header-data div3">Password</div>
        <div class="table-header-data div5">Status</div>
      </div>
      <div class="table-data">
        <?php
        $result = $conn->query("SELECT user_id, name, password, username, is_active FROM user WHERE is_customer = true;");

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<div class='table-row parent'>";
            echo "<div class='table-cell div1'>" . $row['user_id'] . "</div>";
            echo "<div class='table-cell div2'>" . $row['name'] . "</div>";
            echo "<div class='table-cell div4'>" . $row['username'] . "</div>";
            echo "<div class='table-cell div3'>" . $row['password'] . "</div>";
            echo "<div class='table-cell div5'>";
            if ($row['is_active']) echo "<a href='disable.php?id=" . $row['user_id'] . "'> Active<i class='fa-solid fa-circle-check' style='margin-left:-15px'></i></a>";
            else echo "<a href='disable.php?id=" . $row['user_id'] . "'> Disabled </a>";
            echo "</div>";
            echo "</div>";
          }
        } else echo "<div class='table-row parent'> No records fund </div>";

        ?>
      </div>
    </div>
  </section>

  <section id="resavation" class="admin-table" style="margin-bottom: 50px;">
    <h2>Resavations' table</h2>
    <span>Information about table resavations</span>
    <div class="table">
      <div class="table-header parent">
        <div class="table-header-data div1">Resavation ID</div>
        <div class="table-header-data div2">Customer</div>
        <div class="table-header-data div3">Date / Time</div>
        <div class="table-header-data div4">Number of People</div>
        <div class="table-header-data div5">Created date/time</div>
      </div>
      <div class="table-data">
        <?php
        $result = $conn->query("SELECT * FROM `reservation` ORDER BY `reservation_id` ASC");

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<div class='table-row parent'>";
            echo "<div class='table-cell div1'>" . $row['reservation_id'] . "</div>";
            $result2 = $conn->query("SELECT name FROM user WHERE user_id =" . $row['user'] . " AND (is_active = 1 OR is_customer = 1);");
            while ($row2 = $result2->fetch_assoc()) echo "<div class='table-cell div2'>" . $row2['name'] . "</div>";
            echo "<div class='table-cell div3'>" . $row['date'] . "/" . $row['time'] . "</div>";
            echo "<div class='table-cell div4'>" . $row['number_of_people'] . "</div>";
            echo "<div class='table-cell div5'>" . $row['created_time'] . "</div>";
            echo "</div>";
          }
        } else echo "<div class='table-row parent'> No records fund </div>";

        ?>
      </div>
    </div>
  </section>

  <section id="resavation" class="admin-table" style="margin-bottom: 140px;">
    <h2>Menu Items' table</h2>
    <span>Rewiew information about menu items</span>
    <div class="table">
      <div class="table-header parent">
        <div class="table-header-data div1">Cousin</div>
        <div class="table-header-data div2">Name</div>
        <div class="table-header-data div3">Type</div>
        <div class="table-header-data div4">Price</div>
        <div class="table-header-data div5">Status</div>
      </div>
      <div class="table-data">
        <?php
        $result = $conn->query("SELECT * FROM `food` ORDER BY name;");

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $imageData = $row["image"];

            // Determine the image type
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $imageType = $finfo->buffer($imageData);

            // Encode the image data to base64
            $base64Image = base64_encode($imageData);

            echo "<div class='table-row parent'>";
            echo "<div class='table-cell div1'>" . $row['cousin'] . "</div>";
            echo "<div class='table-cell div2'>" . $row['name'] . "<div class='image' style='background-image: url(data:$imageType;base64,$base64Image)'></div></div>";
            echo "<div class='table-cell div3'>" . $row['type'] . "</div>";
            echo "<div class='table-cell div4'> LKR  " . $row['price'] . ".00/=</div>";
            echo "<div class='table-cell div5'>";
            if ($row['food_sts']) echo "<a href='disableFood.php?id=" . $row['food_Id'] . "'> Active  <i class='fa-solid fa-circle-check' style='margin-left:5px'></i></a>";
            else echo "<a href='disableFood.php?id=" . $row['food_Id'] . "'> Disabled </a>";
            echo "</div>";
            echo "</div>";
          }
        } else {
          echo "<div class='table-row parent'> No records fund </div>";
        }

        ?>
      </div>
    </div>
  </section>

  <?php require 'php/feature.php' ?>
</body>

</html>