<!DOCTYPE html>
<html lang="en">

<head>
  <title>Gallery Cafe - Resavations</title>
  <?php require_once 'php/styles.php' ?>
</head>

<body>
  <nav>
    <a href="index.php" class="brand"> Gallery Cafe </a>
    <div>
      <ul id="navbar">
        <li><a href="index.php">Home</a></li>
        <li><a href="reservation.php" class="active">Reservations</a></li>
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

  <?php top("Reservation", "Make Reservation") ?>

  <section class="ftco-section">
    <div class="container">
      <div class="row justify-content-center mb-5 pb-2">
        <div class="col-md-7 text-center heading-section ftco-animate">
          <span class="subheading">Dine as you desire</span>
          <h2 class="mb-4">Tables</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-3 ftco-animate">
          <div class="staff">
            <div class="img" style="background-image: url(images/two.jpg)"></div>
            <div class="text px-4 pt-4">
              <h3>Two to Four Person</h3>
              <span class="position mb-2">Most common and popular</span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 ftco-animate">
          <div class="staff">
            <div class="img" style="background-image: url(images/Booth.jpg)"></div>
            <div class="text px-4 pt-4">
              <h3>Booth</h3>
              <span class="position mb-2">A great choice</span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 ftco-animate">
          <div class="staff">
            <div class="img" style="background-image: url(images/Outdoors.jpg)"></div>
            <div class="text px-4 pt-4">
              <h3>Outdoors</h3>
              <span class="position mb-2">outdoor dining space</span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 ftco-animate">
          <div class="staff">
            <div class="img" style="background-image: url(images/Family%20Dining.jpg)"></div>
            <div class="text px-4 pt-4">
              <h3>Family Dining</h3>
              <span class="position mb-2">The large dining table</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
  $ghr = "";

  // retreve data if form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nop = $_POST['nop'];
    $type = $_POST['type'];
    $date = $_POST['date'];
    $dateTime = DateTime::createFromFormat('g:i A', $_POST['time']);
    $outputTime = $dateTime->format('H:i');

    // prepare array for query
    $arr = [0, 0, 0, 0];
    if ($type == "Booth") $arr[0] = 1;
    elseif ($type == "Two_to_Four_Person") $arr[1] = 1;
    elseif ($type == "Family_Dining") $arr[2] = 1;
    else $arr[3] = 1;


    // count needed number of tables
    $not = 1;
    if ($nop > 16) $not = 4;
    elseif ($nop > 12) $not = 3;
    elseif ($nop > 6) $not = 2;

    // check nop with not
    $conn1 = mysqli_connect("localhost", "root", "", "hd36");
    $sql1 = "SELECT table_id
                 FROM rstrnt_table
                 WHERE (Booth = $arr[0] AND Two_to_Four_Person = $arr[1] AND Family_Dining = $arr[2] AND Outdoors = $arr[3] ) 
                 AND table_id NOT IN (
                     SELECT table_id
                     FROM resavatio_table JOIN reservation 
                     ON reservation.reservation_id = resavatio_table.resavation
                     WHERE reservation.date = '$date');";
    $result1 = $conn1->query($sql1);
    $conn1->close();

    if ($result1->num_rows == 0 or $not > $result1->num_rows) $ghr = "Sorry, request unavailable";
    else {
      $ghr = "Resavation set successfully";
      // get user id to set resavation
      $user_data = json_decode($_COOKIE['user_data'], true);
      $user_id = $user_data['user_id'];

      // make resavation
      $conn2 = mysqli_connect("localhost", "root", "", "hd36");
      $sql2 = "INSERT INTO `reservation` ( `number_of_people`, `time`, `date`, `user`) 
                   VALUES ('$nop', '$outputTime', '$date', '$user_id');";
      $result2 = $conn2->query($sql2);

      // get resavation id
      $reservation_id = $conn2->insert_id;
      $conn2->close();

      // get available tables
      $conn3 = mysqli_connect("localhost", "root", "", "hd36");
      $result3 = $conn3->query($sql1);

      // set tables to resavation
      while ($row = $result3->fetch_assoc()) {
        $table = $row['table_id'];
        $sql3 = "INSERT INTO `resavatio_table` (`resavation`, `table_r`) VALUES ('$reservation_id', '$table');";
        $conn3->query($sql3);
        $not -= 1;
        if ($not == 0) break;
      }
      $conn3->close();
    }
  }
  ?>

  <section class="ftco-section ftco-no-pt ftco-no-pb" style="margin-bottom: 90px" id="form">
    <div class="container">
      <div class="row d-flex">
        <div class="col-md-5 ftco-animate img img-2" style="background-image: url(images/bg_2.jpg)"></div>
        <div class="col-md-7 ftco-animate makereservation p-4 p-md-5">
          <div class="heading-section ftco-animate mb-5">
            <span class="subheading">Book a Table</span>
            <h2 class="mb-4">Make Reservation</h2>
          </div>
          <form action="reservation.php#form" class="formi" method="post">
            <div class="row">
              <?php if ($ghr)  echo "<div class='message'> <i class='fa-solid fa-circle'></i> $ghr </div>";  ?>
              <div class="col-md-6 form-group">
                <label>Date</label>
                <input type="date" class="form-control" placeholder="Date" name="date" required />
              </div>
              <div class="col-md-6 form-group">
                <label>Time</label>
                <input type="text" class="form-control" id="book_time" placeholder="Time" name="time" required />
              </div>
              <div class="col-md-6 form-group">
                <label>Table Type</label>
                <div class="select-wrap one-third">
                  <div class="icon">
                    <i class="fa-solid fa-chevron-down"></i>
                  </div>
                  <select name="type" class="form-control" required>
                    <option value="Family_Dining" selected>Family dining</option>
                    <option value="Two_to_Four_Person">Two to Four Person</option>
                    <option value="Outdoors">Outdoor tables</option>
                    <option value="Booth">Booths</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6 form-group">
                <label>People</label>
                <input type="number" class="form-control" placeholder="2" min="1" max="20" name="nop" required />
              </div>
              <div class="col-md-12 mt-3">
                <div class="form-group">
                  <input type="submit" value="Make a Reservation" class="btn btn-primary py-3 px-5" />
                </div>
              </div>
            </div>
          </form>
          <?php if (isset($error)) echo "<p>$error</p>" ?>
        </div>
      </div>
    </div>
  </section>

  <?php require 'php/feature.php' ?>
</body>

</html>