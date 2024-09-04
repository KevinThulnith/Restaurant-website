<!DOCTYPE html>
<html lang="en">

<head>
	<title>Gallery Cafe - Add Food</title>
	<?php require_once 'php/styles.php' ?>
</head>

<body>
	<nav>
		<a href="index.php" class="brand"> Gallery Cafe </a>
		<div>
			<ul id="navbar">
				<li><a href="index.php">Home</a></li>
				<li><a href="addfood.php" class="active">Add Food</a></li>
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
				<h3>$29</h3>
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
				<a>Make a order</a>
				<div class="xmark"><i class="fa-solid fa-xmark"></i></div>
			</div>
		</div>
	</div>
	<!-- End pop up -->

	<?php top("Add Food", "Add Menu Item") ?>

	<?php
	$ghr = "";

	// retreve data if form is submitted
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$image = $_FILES['image']['tmp_name'];
		$imgContent = addslashes(file_get_contents($image));

		// input data to db
		require_once 'DbConnect.php';
		$sql = "INSERT INTO `food` (`name`,`type`,`price`,`image`, `cousin`) 
                VALUES ( '" . $_POST['name'] . "', '" . $_POST['type'] . "', '" . $_POST['price'] . "', '$imgContent', '" . $_POST['cousin'] . "')";
		if ($conn->query($sql)) {
			$id = $conn->insert_id;
			$ghr = "Process successfully done";
		} else $ghr = "Invalid data detected";
	}
	?>

	<section class="ftco-section ftco-no-pt ftco-no-pb" style="margin-bottom: 100px; margin-top:80px">
		<div class="container">
			<div class="row d-flex">
				<div class="col-md-5 ftco-animate img img-2 image1" style="background-image: url(images/a1.jpg); aspect-ratio: 5 / 5.2 " id="uimage"></div>
				<div class="col-md-7 ftco-animate makereservation p-4 p-md-5">
					<div class="heading-section ftco-animate mb-5">
						<h2 class="mb-4">Add Menu Item</h2>
					</div>
					<form action="addfood.php" method="post" enctype="multipart/form-data" class="formi">
						<div class="row">
							<?php if ($ghr) echo "<div class='message'> <i class='fa-solid fa-circle'></i> $ghr </div>";  ?>
							<div class="col-md-6 form-group">
								<label>Name</label>
								<input type="text" class="form-control" placeholder="name" name="name" required />
							</div>
							<div class="col-md-6 form-group" id="file">
								<label>Image</label>
								<input type="file" class="form-control" title="Edit and resize before uploading" id="uimagetag" accept=".jpg, .jpeg, .png" name="image" id="image" required />
							</div>
							<div class="col-md-6 form-group">
								<label>Food Type</label>
								<div class="select-wrap one-third">
									<div class="icon">
										<i class="fa-solid fa-chevron-down"></i>
									</div>
									<select name="type" class="form-control" required>
										<option value="Breakfast" selected>Breakfast</option>
										<option value="Lunch">Lunch</option>
										<option value="Dinner">Dinner</option>
										<option value="Desserts">Desserts</option>
										<option value="Wine Card">Wine Card</option>
										<option value="Drinks">Drinks</option>
									</select>
								</div>
							</div>
							<div class="col-md-6 form-group">
								<label>Cousin</label>
								<div class="select-wrap one-third">
									<div class="icon">
										<i class="fa-solid fa-chevron-down"></i>
									</div>
									<select name="cousin" class="form-control" required>
										<option value="Sri Lankan" selected>Sri Lankan</option>
										<option value="Chinese">Chinese</option>
										<option value="Italian">Italian</option>
										<option value="Indian">Indian</option>
										<option value="French">French</option>
										<option value="Korean">Korean</option>
									</select>
								</div>
							</div>
							<div class="col-md-6 form-group">
								<label>Price LKR</label>
								<input type="number" class="form-control" placeholder="40" min="40" max="10000" name="price" required />
							</div>
							<div class="col-md-12 mt-3">
								<div class="form-group">
									<input type="submit" value="Add Food Item" class="btn btn-primary py-3 px-5" />
								</div>
							</div>
						</div>
					</form>
					<?php if (isset($error)) echo "<p>$error</p>" ?>
				</div>
			</div>
		</div>
	</section>

	<?php
	// show preview
	if ($ghr == "Process successfully done") {
		$sql = "SELECT * FROM food WHERE food_Id = $id;";
		$result = $conn->query($sql);
		while ($row = $result->fetch_assoc()) {
			$imageData = $row["image"];

			// Determine the image type
			$finfo = new finfo(FILEINFO_MIME_TYPE);
			$imageType = $finfo->buffer($imageData);

			// Encode the image data to base64
			$base64Image = base64_encode($imageData);

			echo "<section class='ftco-section'>
                 <div class='container'>
                   <div class='row justify-content-center mb-5 pb-2'>
                     <div class='col-md-7 text-center heading-section ftco-animate'>
                       <h2 class='mb-4'>Preview</h2>
                     </div>
                   </div>
                   <div class='row'>
                     <div class='col-md-6 col-lg-4 menu-wrap'>
                       <div class='heading-menu text-center ftco-animate'>
                         <h3>" . $row['type'] . "</h3>
                       </div>
                       <div class='menus d-flex ftco-animate'>
                         <div
                           class='menu-img img'
                           style='background-image: url( data:$imageType;base64,$base64Image)'
                         ></div>
                         <div class='text'>
                           <div class='d-flex'>
                             <div class='one-half'>
                               <h3 style='text-transform: capitalize;'>" . $row['name'] . "</h3>
                             </div>
                             <div class='one-forth'>
                               <span class='price'>LKR" . $row['price'] . "</span>
                             </div>
                           </div>
                           <p>
                             <span>" . $row['cousin'] . " cousin</span>
                           </p>
                         </div>
                       </div>
                     </div>
                   </div>
                 </div>
                </section>";
		}
	}
	?>

	<?php require 'php/feature.php' ?>
</body>

</html>