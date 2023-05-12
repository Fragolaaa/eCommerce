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

	<title>Wishlist</title>

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
<script src="javascript/redirScripts.js"></script>

	<?php
	$sql = "";
	if (isset($_SESSION["WISHLISTID_"]))
		$sql = "SELECT products.ID, Title, Price, Discount FROM includes JOIN products ON includes.ArticleID = products.ID WHERE WishListID = '" . $_SESSION["WISHLISTID_"] . "'";
	else if (isset($_SESSION["WISHLISTID_GuestUser"]))
		$sql = "SELECT products.Id, Title, Price, Discount FROM includes JOIN products ON includes.ArticleID = products.ID WHERE WishListID = '" . $_SESSION["WISHLISTID_GuestUser"] . "'";

	if ($sql != "") {
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo "<tr>
                                                    <td>
													<div class='img pl2'>
                                                            <a href='products.php?id=" . $row["ID"] . "'><img src='imgs/product-" . $row["ID"] . ".jpg' alt='Image'></a>
                                                            <p>" . $row["Title"] . "</p>
                                                        </div>
                                                    </td>";
				if ($row["Discount"] != 0)
					echo "<td><s>$" . $row["Price"] . "</s> $" . round($row["Price"] * (100 - $row["Discount"]) / 100, 2) . "</td>";
				else
					echo "<td>$" . $row["Price"] . "</td>";
				echo "  <td><button class='btn-cart' onclick='AddTo_Cart(" . $row["ID"] . ", 1)'>Add to Cart</button></td> 
                                                            <td><button onclick='RemoveFrom_Wishlist(" . $row["ID"] . ")'><i class='fa fa-trash'></i></button></td>
                                                        </tr>";
			}
		} else {
			echo "<tr><td>No products here :(</td><td></td><td></td><td></td></tr>";
		}
	} else {
		echo "<tr><td>No products here :(</td><td></td><td></td><td></td></tr>";
	}
	?>

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