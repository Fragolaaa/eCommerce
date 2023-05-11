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

		<title>Shopping Cart</title>

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
	<div class="cart-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-page-inner">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Discount</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">

                                    <?php
                                    $sql = "";
                                    if (isset($_SESSION["CARTID_"]))
                                        $sql = "SELECT products.ID, Title, Price, Discount, Quantity, Amount FROM contains JOIN products ON contains.ArticleID = products.ID WHERE CartID = '" . $_SESSION["CARTID_"] . "'";
                                    else if (isset($_SESSION["CARTID_GuestUser"]))
                                        $sql = "SELECT products.Id, Title, Price, Discount, Quantity, Amount FROM contains JOIN products ON contains.ArticleID = products.ID WHERE CartID = '" . $_SESSION["CARTID_GuestUser"] . "'";
                                    if ($sql != "") {
                                        $result = $conn->query($sql);

                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>
                                                    <td>
                                                         <div class='img pl-2'>
                                                            <a href='productDetail.php?id=" . $row["ID"] . "'><img src='img/product-" . $row["ID"] . ".jpg' alt='Image' style='width:7%'></a>
                                                            <p>" . $row["Title"] . "</p>
                                                        </div>
                                                    </td>
                                                    <td>$" . $row["Price"] . "</td>
                                                    <td>" . $row["Discount"] . "%</td>
                                                    <td>
                                                        <div class='qty'>
                                                            <button class='btn-minus' onclick='UpdateQty_Cart(" . $row["ID"] . "," . ($row["Amount"] - 1) . ", " . $row["Quantity"] . ")'><i class='fa fa-minus'></i></button>
                                                            <input class='pb-1' type='text' name='q' value='" . $row["Amount"] . "' min=1 max=" . $row["Amount"] . "'>
                                                            <button class='btn-plus' onclick='UpdateQty_Cart(" . $row["ID"] . "," . ($row["Amount"] + 1) . ", " . $row["Quantity"] . ")'><i class='fa fa-plus'></i></button>
                                                        </div>
                                                    </td>";

                                                if ($row["Discount"] != 0)
                                                    echo "<td><s>$" . $row["Price"] . "</s> $" . round($row["Price"] * (100 - $row["Discount"]) / 100, 2) * $row["Quantity"] . "</td>";
                                                else
                                                    echo "<td>$" . $row["Price"] * $row["Quantity"] . "</td>";

                                                echo "<td><button onclick='RemoveFrom_Cart(" . $row["ID"] . ")'><i class='fa fa-trash'></i></button></td></tr>";
                                            }
                                        } else {
                                            echo "<tr><td>No products here :(</td><td></td><td></td><td></td><td></td><td></td></tr>";
                                        }
                                    } else {
                                        echo "<tr><td>No products here :(</td><td></td><td></td><td></td><td></td><td></td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart-page-inner">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="cart-summary">
                                    <div class="cart-content">
                                        <h1>Cart Summary</h1>
                                        <?php
                                        $sql = "";
                                        $totPrice = 0;
                                        if (isset($_SESSION["CARTID_"]))
                                            $sql = "SELECT Price, Discount, Quantity FROM contains JOIN products ON contains.ArticleID = products.ID WHERE CartID = '" . $_SESSION["CARTID_"] . "'";
                                        else if (isset($_SESSION["CARTID_GuestUser"]))
                                            $sql = "SELECT Price, Discount, Quantity FROM contains JOIN products ON contains.ArticleID = products.ID WHERE CartID = '" . $_SESSION["CARTID_GuestUser"] . "'";
                                        if ($sql != "") {
                                            $result = $conn->query($sql);

                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    if ($row["Discount"] != 0)
                                                        $totPrice += round($row["Price"] * (100 - $row["Discount"]) / 100, 2) * $row["Quantity"];
                                                    else
                                                        $totPrice += $row["Price"] * $row["Quantity"];
                                                }
                                            }
                                        }
                                        echo "<p>Sub Total<span>$" . $totPrice . "</span></p>
                                              <p>Shipping Cost<span> $4.99 </span></p>                                        
                                              <h2>Grand Total <span>$" . ($totPrice + 4.99) . "</span></h2>";
                                        ?>
                                    </div>
        
                                        <div class="cart-btn">
                                            <?php
                                            if (isset($_SESSION["CARTID_"]) || isset($_SESSION["CARTID_GuestUser"]))
                                                echo '  <button onclick="CleanCart()">Clear All</button>
                                                        <button onclick="Checkout()">Checkout</button>';
                                            else
                                                echo '  <button onclick="CleanCart()" disabled>Clear All</button>
                                                        <button onclick="Checkout()" disabled>Checkout</button>';
                                            ?>
                                        </div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
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
