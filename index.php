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

	<title>taniexpress</title>

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

	<?php

	//Logout
	if (isset($_GET['msg']) && $_GET['msg'] == "Logged out") {
		unset($_SESSION["ID"]);
		unset($_SESSION['Username']);
		unset($_SESSION["IDCart"]);
		unset($_SESSION["IDWishlist"]);
	}

	//load cookies 
	if (isset($_COOKIE["WISHLISTID_GuestUser"])) {
		$_SESSION["WISHLISTID_GuestUser"] = $_COOKIE["WISHLISTID_GuestUser"];
	}
	if (isset($_COOKIE["SHPCARTID_GuestUser"])) {
		$_SESSION["SHPCARTID_GuestUser"] = $_COOKIE["SHPCARTID_GuestUser"];
	}
	?>
</head>

<body>
	<!-- SHOW PRODOTTI -->
	<div class="container">
	<?php include "products.php" ?>
	</div>
	<!-- FOOTER -->
	<?php include "footer.php"; ?>
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