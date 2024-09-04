<!DOCTYPE html>
<html lang="en">

<head>
  <title>Gallery Cafe - Specialties</title>
  <?php require_once 'php/styles.php' ?>
</head>

<body>
  <nav>
    <a href="index.php" class="brand"> Gallery Cafe </a>
    <div>
      <ul id="navbar">
        <?php navigation(3) ?>
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

  <div class="contrt hide" style="margin-top: -50px;">
    <div class="menu-box">
      <div class="image" style="background-image: url(images/breakfast-1.jpg)"></div>
      <div class="text">
        <h1>Grilled Beef with potatoes</h1>
        <p>
          <span>Meat</span>, <span>Potatoes</span>, <span>Rice</span>,
          <span>Tomatoe</span>
        </p>
        <h3>LKR29</h3>
        <div class="rating">
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
        </div>
        <button>
          <i class="fa-solid fa-heart"></i>
          Add to favourites
        </button>
        <a href="#">Make a order</a>
        <div class="xmark"><i class="fa-solid fa-xmark"></i></div>
      </div>
    </div>
  </div>
  <!-- End pop up -->

  <?php top("Menu", "Specialties") ?>

  <section class="ftco-section">
    <div class="container">
      <div class="row justify-content-center mb-5 pb-2">
        <div class="col-md-7 text-center heading-section ftco-animate">
          <span class="subheading">Specialties</span>
          <h2 class="mb-4">Our Menu</h2>
          <section class="search">
            <input type="text" id="search" placeholder="search here...">
            <button id="search-bt"><i class="fa-solid fa-magnifying-glass"></i></button>
          </section>
        </div>
      </div>
      <div class="row">
        <?php
        $array = ['Breakfast', 'Lunch', 'Dinner', 'Desserts', 'Wine Card', 'Drinks'];
        include_once 'DbConnect.php';

        foreach ($array as $wrd) {
          echo "<div class='col-md-6 col-lg-4 menu-wrap'>
                  <div class='heading-menu text-center ftco-animate'>
                    <h3>$wrd</h3>
                  </div>";

          $result = $conn->query("SELECT * FROM food WHERE type = '$wrd';");
          while ($row = $result->fetch_assoc()) {
            $imageData = $row["image"];

            // Determine the image type
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $imageType = $finfo->buffer($imageData);

            // Encode the image data to base64
            $base64Image = base64_encode($imageData);

            echo "<div class='menus d-flex ftco-animate'>
                    <div class='menu-img img' style='background-image: url(data:$imageType;base64,$base64Image)'></div>
                    <div class='text'>
                      <div class='d-flex'>
                        <div class='one-half'>
                          <h3 style='text-transform: capitalize;'>" . $row['name'] . "</h3>
                        </div>
                        <div class='one-forth'>
                          <span class='price'> LKR" . $row['price'] . "</span>
                        </div>
                      </div>
                      <p>
                        <span>" . $row['cousin'] . " cousin</span>
                      </p>
                    </div>
                  </div>";
          }
          echo "</div>";
        }
        $conn->close();
        ?>
      </div>
    </div>
  </section>

  <?php require 'php/feature.php' ?>
</body>

</html>