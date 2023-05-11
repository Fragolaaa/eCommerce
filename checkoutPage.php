<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Checkout</title>

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
	<!-- HEADER -->
	<?php include "navbar.php" ?>
	<!-- /HEADER -->

	<!-- BREADCRUMB -->
	<div id="breadcrumb" class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<div class="col-md-12">
					<h3 class="breadcrumb-header">Checkout</h3>
					<ul class="breadcrumb-tree">
						<li><a href="#">Home</a></li>
						<li class="active">Checkout</li>
					</ul>
				</div>
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /BREADCRUMB -->

	<!-- SECTION -->
	<form action="chkOrder.php" method="Post">
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<div class="col-md-7">
						<!-- Billing Details -->
						<?php
						$sql = $conn->prepare("SELECT * FROM addresses join users on addresses.UserID = users.ID WHERE UserID = ? AND ShippingDefault = 1");
						$sql->bind_param('i', $_SESSION["ID"]);
						$sql->execute();
						$result = $sql->get_result();
						if ($result->num_rows > 0) {
							$row = $result->fetch_assoc();
							echo '<div class="billing-details">
							<div class="section-title">
								<h3 class="title">Shipping address</h3>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="FirstName" value="' . $row["FirstName"] . '" placeholder="Mario">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="LastName" value="' . $row["LastName"] . '" placeholder="Rossi">
							</div>
							<div class="form-group">
								<input class="input" type="email" name="email" value="' . $row["Email"] . '" placeholder="mariorossi@taniexpress.com">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="address" value="' . $row["addresses.Address"] . '" placeholder="Via Roma">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="city" value="' . $row["City"] . '" placeholder="Roma">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="province" value="' . $row["Province"] . '" placeholder="Roma">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="country" value="' . $row["Country"] . '" placeholder="Italy">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="zip-code" value="' . $row["ZIPCode"] . '" placeholder="00123">
							</div>
							<div class="form-group">
								<input class="input" type="tel" name="tel"value="' . $row["PhoneNumber"] . '" placeholder="+391232467891">
							</div>';
						} else
							echo '<div class="billing-details">
						<div class="section-title">
							<h3 class="title">Shipping address</h3>
						</div>
						<div class="form-group">
							<input class="input" type="text" name="FirstName" placeholder="Mario">
						</div>
						<div class="form-group">
							<input class="input" type="text" name="LastName" placeholder="Rossi">
						</div>
						<div class="form-group">
							<input class="input" type="email" name="email" placeholder="mariorossi@taniexpress.com">
						</div>
						<div class="form-group">
							<input class="input" type="text" name="address" placeholder="Via Roma">
						</div>
						<div class="form-group">
							<input class="input" type="text" name="city" placeholder="Roma">
						</div>
						<div class="form-group">
							<input class="input" type="text" name="province" placeholder="Roma">
						</div>
						<div class="form-group">
							<input class="input" type="text" name="country" placeholder="Italy">
						</div>
						<div class="form-group">
							<input class="input" type="text" name="zip-code" placeholder="00123">
						</div>
						<div class="form-group">
							<input class="input" type="tel" name="tel" placeholder="+391232467891">
						</div>
						<div class="form-group">
							<div class="input-checkbox">
								<input type="checkbox" id="saveAddress" name="saveAddress">
								<label for="Save address">
									<span></span>
									Save address?
								</label>
							</div>
						</div>';
						?>


					</div>
				</div>
				<!-- /Billing Details -->

				<!-- Order Details -->
				<div class="col-md-5 order-details">
					<div class="section-title text-center">
						<h3 class="title">Your Order</h3>
					</div>
					<div class="order-summary">
						<div class="order-col">
							<div><strong>PRODUCT</strong></div>
							<div><strong>TOTAL</strong></div>
						</div>
						<div class="order-products">
							<?php
							$sql = "";
							$totPrice = 4.99;
							if (isset($_SESSION["CARTID_"]))
								$sql = "SELECT Price, Discount, Amount, Title FROM contains JOIN products ON contains.ArticleID = products.ID WHERE CartID = '" . $_SESSION["CARTID_"] . "'";
							else if (isset($_SESSION["CARTID_GuestUser"]))
								$sql = "SELECT Price, Discount, Amount, Title FROM contains JOIN products ON contains.ArticleID = products.ID WHERE CartID = '" . $_SESSION["CARTID_GuestUser"] . "'";
							if ($sql != "") {
								$result = $conn->query($sql);

								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
									while ($row = $result->fetch_assoc()) {
										echo "<div class='order-col'>";
										echo "<div>" . $row["Amount"] . "x " . $row["Title"] . "</div>";

										if ($row["Discount"] != 0) {
											echo "<div>$" . round($row["Price"] * (100 - $row["Discount"]) / 100, 2) * $row["Amount"] . "</div>";
											$totPrice += round($row["Price"] * (100 - $row["Discount"]) / 100, 2) * $row["Amount"];
										} else {
											echo "<div>$" . $row["Price"] . "</div>";
											$totPrice += $row["Price"] * $row["Amount"];
										}

									}
								}
								echo "</div>";
								echo "<div class='order-col'>
											<div>Shipping</div>
											<div><strong>$4.99</strong></div>
											</div>";
								echo "<div class='order-col'>
											<div><strong>TOTAL</strong></div>
											<div><strong class='order-total'>$" . $totPrice . "</strong></div>
											</div></div>";

							}
							?>
							<div class="payment-method">
								<div class="input-radio">
									<input type="radio" name="payment" id="mastercard" value="mastercard" />
									<label for="mastercard">
										<span></span>
										Mastercard
									</label>
									<div class="caption">
										<div class="form-group">
											<input class="input" type="text" name="CardHolder"
												placeholder="Mario Rossi" />
										</div>
										<div class="form-group">
											<input class="input" type="text" name="CardNumber"
												placeholder="card number" />
										</div>
										<div class="form-group">
											<input class="input" type="month" name="expDate" placeholder="05/23" />
										</div>
										<div class="form-group">
											<input class="input" type="password" name="cvv" placeholder="cvv" />
										</div>
									</div>
								</div>
								<div class="input-radio">
									<input type="radio" name="payment" id="visa" value="visa" />
									<label for="visa">
										<span></span>
										Visa
									</label>
									<div class="caption">
										<div class="form-group">
											<input class="input" type="text" name="CardHolder"
												placeholder="Mario Rossi" />
										</div>
										<div class="form-group">
											<input class="input" type="text" name="CardNumber"
												placeholder="card number" />
										</div>
										<div class="form-group">
											<input class="input" type="month" name="expDate" placeholder="05/23" />
										</div>
										<div class="form-group">
											<input class="input" type="password" name="cvv" placeholder="cvv" />
										</div>
									</div>
								</div>
								<div class="input-radio">
									<input type="radio" name="payment" id="amex" value="amex" />
									<label for="amex">
										<span></span>
										American Express
									</label>
									<div class="caption">
										<div class="form-group">
											<input class="input" type="text" name="CardHolder"
												placeholder="Mario Rossi" />
										</div>
										<div class="form-group">
											<input class="input" type="text" name="CardNumber"
												placeholder="card number" />
										</div>
										<div class="form-group">
											<input class="input" type="month" name="expDate" placeholder="05/23" />
										</div>
										<div class="form-group">
											<input class="input" type="password" name="cvv" placeholder="cvv" />
										</div>
									</div>
								</div>
								<div class="input-radio">
									<input type="radio" name="payment" id="paypal" value="paypal" />
									<label for="paypal">
										<span></span>
										PayPal
									</label>
									<div class="caption">
										<div class="form-group">
											<input class="input" type="email" name="email" placeholder="email" />
										</div>
									</div>
								</div>
							</div>
							<div class="input-checkbox">
								<input type="checkbox" id="terms">
								<label for="terms">
									<span></span>
									I've read and accept the <a href="terms_and_conditions.php">terms &
										conditions</a>
								</label>
							</div>
							<input type="submit" value="Place order" class="primary-btn order-submit">
						</div>
						<!-- /Order Details -->
					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div>
		</div>
	</form>
	<!-- /SECTION -->

	<!-- FOOTER -->
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