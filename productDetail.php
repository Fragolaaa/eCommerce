<?php
include "navbar.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Detailed product</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="css/slick.css" />
	<link type="text/css" rel="stylesheet" href="css/slick-theme.css" />

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="css/font-awesome.min.css">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="css/style.css" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

</head>

<body>
	<script type="text/javascript"></script>
	<script src="javascript/stars.js"></script>
	<script src="javascript/redirScripts.js"></script>

	<!-- SECTION -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- Product main img -->
				<div class="col-md-6">
					<div id="product-main-img">
						<?php
						echo "<img src='imgs/product-" . $_GET["ID"] . ".jpg' alt='Product Image' style='object-fit: contain'>";
						?>
					</div>
				</div>
				<!-- /Product main img -->
				<div class="col-md-6">
					<div class="product-content">
						<?php
						$sql = "SELECT products.ID, products.Title, Price, Discount, AVG(Stars), Quantity, Description FROM products JOIN reviews ON products.ID = reviews.ArticleID WHERE products.ID = '" . $_GET["ID"] . "' GROUP BY products.ID";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							$row = $result->fetch_assoc();
							echo "<form method='get' action='addToShpCart.php?ID=" . $row['products.ID'] . "&q=1'>
										<div class='product-details'>
										<h2 class='product-name'>" . $row["Title"] . "</h2>
                                            </div>
                                            <div class='product-rating'>";
							for ($i = 0; $i < $row["AVG(Stars)"]; $i++) {
								echo "<i class='fa fa-star'></i>";
							}
							for ($i = $row["AVG(Stars)"]; $i < 5; $i++) {
								echo "<i class='far fa-star'></i>";
							}
							echo "</div>";
							//echo "<a class='review-link' href='#'>10 Review(s) | Add your review</a>";
						} else {
							$sql = "SELECT products.ID, products.Title, Price, Discount, Quantity, Description FROM products WHERE products.ID = '" . $_GET["ID"] . "'";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
								$row = $result->fetch_assoc();
								echo "<form method='get' action='addToShpCart.php'>
											<div class='product-details'>
											<h1 class='product-name'>" . $row["Title"] . "</h1>
												</div>
												<div class='product-rating'>";
								for ($i = 0; $i < 5; $i++) {
									echo "<i class='far fa-star'></i>";
								}
							}
							echo "</div>";
						}

						if ($row["Discount"] != 0)
							echo "<h3 class='product-price'>" . round($row["Price"] * (100 - $row["Discount"]) / 100, 2) . "$ <del class='product-old-price'>" . $row["Price"] . "$</del></h3>";
						else
							echo "<h3 class='product-price'>" . $row["Price"] . "$</h3>";
						echo "  </div>
                    
                                                <h4>Quantity:</h4>
                                                <div class='qty'>";
						if ($row["Quantity"] >= 1) {
							echo "<span class='product-available'>" . $row["Quantity"] . " In Stock</span></div>";
							echo "<div class'description'><h4 class='product-price'> Description: </h4>";
							echo "<p>" . $row["Description"] . "</p></div>";

							echo " <div class='add-to-cart'>
											<div class='qty-label'>
												<div class='input-number' value='1' min=1 max=" . $row["Quantity"] . ">
												<input type='hidden' name='ID' value='" . $row["ID"] . "'>
													<input type='number' name='q' value='" . $row["Amount"] . "' min=1 max=" . $row["Quantity"] . "' style='width:100%'/>
													<span onClick='UpdateQty_Cart(" . $row["ID"] . "," . ($row["Amount"] + 1) . ", " . $row["Quantity"] . ")' class='qty-up'>+</span>
													<span onClick='UpdateQty_Cart(" . $row["ID"] . "," . ($row["Amount"] - 1) . ", " . $row["Quantity"] . ")' class='qty-down'>-</span>
													</div>
											</div>
											<input type='submit' class='add-to-cart-btn fa fa-shopping-cart' value='add to cart'>
											<ul class='product-btns'>
											<li><a href='addToWishList.php?ID=" . $row["ID"] . "'><i class='fa fa-heart-o'></i> add to wishlist</a></li></ul></div>";

						} else {
							echo "  <input type='number' name='q' value='0' min=0 max=0>
                                                <input type='hidden' name='ID' value='" . $row["ID"] . "'>
                                                </div>
                                                <div class='action'>
                                                    <button class='btn soldout'><i class='fa fa-shopping-cart'></i>Sold Out</button>
                                                </div>
												<ul class='product-btns'>
									<li><a href='addToWishList.php?ID=" . $row["ID"] . "'><i class='fa fa-heart-o'></i> add to wishlist</a></li></ul></div>";
						}

						echo "</form>
					</div>
				</div>

	<!-- Product details -->

		<!-- /Product details -->

		<!-- Product tab -->
		<div class='col-md-12'>
			<div id='product-tab'>
				<!-- product tab nav -->
				<ul class='tab-nav'>
					<li class='active'><a data-toggle='tab' href='#tab3'>Reviews ";
						$prodID = $row["ID"];
						$query = "SELECT COUNT(*) FROM reviews WHERE ArticleID = " . $prodID;

						$result = $conn->query($query);
						$row = $result->fetch_assoc();
						echo $row["COUNT(*)"];

						echo '</a></li>
						</ul>
					
						<div class="tab-content">

								<!-- Reviews -->
								<div class="col-md-6">
									<div id="reviews">
										<ul class="reviews">';

						echo "<li><div id='reviews' class='review-heading'>";
						$query = "SELECT * FROM reviews JOIN users ON reviews.UserID = users.ID WHERE ArticleID = " . $prodID;
						$result = $conn->query($query);
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo "<div class='reviews-submitted'>
                                            <div class='name'>" . $row["FirstName"] . " " . $row["LastName"] . " - <p class='date'>" . $row["Date"] . "</p></div>
                                                <div class='review-rating'>";
								for ($i = 0; $i < $row["Stars"]; $i++) {
									echo "<i class='fa fa-star'></i>";
								}
								echo "</div><h5>" . $row["Title"] . "</h5><div class='review-body'><p>" . $row["Content"] . "</p></div></div>";
							}
						}
						echo "</div></li>";
						?>
					</div>
				</div>
				<!-- /Reviews -->

				<!-- Review Form -->


				<div class="col-md-3">
					<div id="review-form">
						<form action="addReview.php" method="GET">
							<div class="rating">
								<i class="far fa-star" name="1" id="1" onclick="setStars(1)"></i>
								<i class="far fa-star" name="2" id="2" onclick="setStars(2)"></i>
								<i class="far fa-star" name="3" id="3" onclick="setStars(3)"></i>
								<i class="far fa-star" name="4" id="4" onclick="setStars(4)"></i>
								<i class="far fa-star" name="5" id="5" onclick="setStars(5)"></i>
							</div>
							<div class="row form">
								<div class="col-sm-6">
									<input type="title" name='title' placeholder="Title" required>
								</div>
								<div class="col-sm-3">
									<?php
									echo "<input type='hidden' name='ID' value=" . $_GET['ID'] . ">";
									?>
								</div>
								<div class="col-sm-3">
									<?php
									echo "<input type='hidden' name='stars' id='stars' value='0'>";
									?>
								</div>
								<div class="col-sm-12">
									<textarea placeholder="Review" name='text' required></textarea>
								</div>
								<button class="primary-btn">Submit</button>
						</form>
					</div>
				</div>
				<!-- /Review Form -->
			</div>
		</div>
		<!-- /tab3  -->
	</div>
	<!-- /product tab content  -->
	</div>
	</div>
	<!-- /product tab -->
	</div>
	<!-- /row -->
	</div>
	<!-- /container -->
	</div>
	<!-- /SECTION -->




	<?php include "footer.php" ?>
	<!-- /FOOTER -->

	<!-- jQuery Plugins -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.zoom.min.js"></script>
	<script src="js/main.js"></script>

</body>

</html>