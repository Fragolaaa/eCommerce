<?php include "navbar.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>Register</title>

 		<!-- Google font -->
 		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

 		<!-- Bootstrap -->
 		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

 		<!-- Slick -->
 		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
 		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

 		<!-- nouislider -->
 		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

 		<!-- Font Awesome Icon -->
 		<link rel="stylesheet" href="css/font-awesome.min.css">

 		<!-- Custom stlylesheet -->
 		<link type="text/css" rel="stylesheet" href="css/style.css"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

    </head>

<body>

    <form action="register_chk.php" method="POST">
    First Name:<br>
    <input type="text" id="FirstName" name="FirstName" placeholder="Mario" required><br>
	Last Name:<br>
    <input type="text" id="LastName" name="LastName" placeholder="Rossi" required><br>
	Email:<br>
    <input type="email" id="email" name="email" placeholder="mario.rossi@taniexpress.com" required><br>
    Birth Date:<br>
	<input type="date" id="birthDate" name="birthDate" required><br>
	Phone Number:<br>
    <input type="text" id="phoneNumber" name="phoneNumber" placeholder="phone number" required><br>
    Password:<br>
    <input type="password" id="password" name="password" placeholder="password" required><br>
    <input type="password" id="confirmPwd" name="confirmPwd" placeholder="confirm your password" required><br>
	Register as a seller? <input type="radio" name="seller" value="1"> Yes <input type="radio" name="seller" value="0"> No<br>
	<input type="submit" value="Register">
    </form>
	Already a costumer? <a href="login_page.php">LOGIN NOW!</a>
    <?php include "footer.php" ?>

    <!-- jQuery Plugins -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/slick.min.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/jquery.zoom.min.js"></script>
		<script src="js/main.js"></script>
</body>

</html>