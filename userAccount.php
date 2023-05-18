<?php
include("database/connection.php");
session_start();

if (isset($_GET['seller']) && $_GET['seller'] == 1) {
	$sql = $conn->prepare("UPDATE users SET Seller = ? WHERE ID = ?");
	$sql->bind_param('ii', $_GET["seller"], $_SESSION["ID"]);
	$sql->execute();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>User Account</title>

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
	<!-- /NAVIGATION -->
	<br>
	<form action="updateUserAcc.php" method="post">
		<div class="container">
			<h4><b>Account Details</b></h4>
			<?php
			$sql = "SELECT * FROM users WHERE ID = '" . $_SESSION["ID"] . "'";

			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				echo "
                                    
                                                <div class='row'>
                                                    <div class='col-md-3'>First Name: </div>
                                                    <div class='col-md-3'><input type='text' name='firstName' style = 'width: 300px' class='form-control' value='" . $row["FirstName"] . "'></div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>Last Name: </div>
                                                    <div class='col-md-3'><input type='text' name='lastName' style = 'width: 300px' class='form-control' value='" . $row["LastName"] . "'></div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>Birth Date: </div>
                                                    <div class='col-md-3'><input type='date' name='birthDate' style = 'width: 300px' class='form-control' value='" . $row["BirthDate"] . "'></div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>Email: </div>
                                                    <div class='col-md-3'><input type='email' name='email' style = 'width: 300px' class='form-control' style='width:auto;' value='" . $row["Email"] . "'></div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>Mobile Number: </div>
                                                    <div class='col-md-3'><input type='text' name='mobileNumber' style = 'width: 300px' class='form-control' value='" . $row["PhoneNumber"] . "'></div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>Password: </div>
                                                    <div class='col-md-3'><input type='password' name='password' style = 'width: 300px' class='form-control' value=''></div>
                                                </div>
                                                <div class='row'>
                                                    <div class='col-md-3'>New Password: </div>
                                                    <div class='col-md-3'><input type='password' name='chkPassword' style = 'width: 300px' class='form-control' value=''></div>
                                                </div>";
			}

			?>
			<input type="submit" value="Submit" class="btn">
		</div>

	</form>
	</div>

	<div>
		<h4><b>Seller</b></h4>

		<?php
		$sql = $conn->prepare("SELECT Seller FROM users WHERE ID = ?");
		$sql->bind_param('i', $_SESSION["ID"]);
		$sql->execute();
		$result = $sql->get_result();

		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			if ($row["Seller"] == 1) {
				$sql = $conn->prepare("SELECT products.ID, Title, Price, Discount, Quantity, State, Type FROM products JOIN categories ON products.CategoryID=categories.ID WHERE Seller = ?");
				$sql->bind_param('s', $_SESSION["USERNAME"]);
				$sql->execute();
				$result = $sql->get_result();
				echo "<table class='table table-bordered'>
                                                    <thead class='thead-dark'>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Title</th>
                                                            <th>Price</th>
                                                            <th>Discount</th>
                                                            <th>Pieces</th>
                                                            <th>Conditions</th>
                                                            <th>Category</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <p><h5 class='text-center'>Articles on sale</h5></p>";
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						echo "<tr>
                                                    <td>" . $row['ID'] . "</td>
                                                    <td>" . $row['Title'] . "</td>
                                                    <td>" . $row['Price'] . "</td>
                                                    <td>" . $row['Discount'] . "</td>
                                                    <td>" . $row['Quantity'] . "</td>
                                                    <td>" . $row['State'] . "</td>
                                                    <td>" . $row['Type'] . "</td>
                                                    <td><button class='btn' data-toggle='modal' data-target='#myModalSeller' onclick='caricaModalSeller(" . $row['ID'] . ")'><i class='bi bi-pencil-square'></i></button>
                                                    <button onclick='toDeleteArticle(" . $row['ID'] . ")' class='btn'><i class='bi bi-trash'></i></button></td>
                                                    </tr>";
					}
					echo "  <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><button data-toggle='modal' data-target='#myModalAdd'  class='btn'>Add new</button></td></tr>
                                                </tbody>
                                                </table>";
				} else
					echo "<tr><td>No articles on sale...</td><td></td><td></td><td></td><td></td><td></td><td></td><td><button data-toggle='modal' data-target='#myModalAdd' class='btn'>Add new</button></td></tr></tbody></table>";
			} else
				echo "<h5>Do you want to become a seller?</h5>
                        <a href='userAccount.php?pag=seller&seller=1'>start selling</a> on Taniexpress";
		}
		?>
		<div>
			<div>
				<div>
					<div>
						<h4>New Article</h4>
					</div>
					<div>
						<form id='formAdd' method='post' action='check/addProduct.php' enctype='multipart/form-data'>
							<p>
								Select image to upload:
								<input type='file' name='fileToUpload' id='fileToUpload' required>
							</p>
							<div class='row'>
								<div class='col-md-3'>Title: </div>
								<div class='col-md-3'><input type='text' name='title' class='form-control w-auto'
										required></div>
							</div>
							<div class='row'>
								<div class='col-md-3'>Description: </div>
								<div class='col-md-3'><textArea name='description' class='form-control w-auto'
										required></textArea></div>
							</div>
							<div class='row'>
								<div class='col-md-3'>State: </div>
								<div class='col-md-3'>
									<select name='state' class='form-control w-auto' required>
										<option hidden>State</option>
										<option value='New'>New</option>
										<option value='Used'>Used</option>
									</select>
								</div>
							</div>
							<div class='row'>
								<div class='col-md-3'>Price: </div>
								<div class='col-md-3'><input type='number' name='price' min=0
										class='form-control w-auto' required></div>
							</div>
							<div class='row'>
								<div class='col-md-3'>Discount: </div>
								<div class='col-md-3'><input type='number' name='discount' min=0
										class='form-control w-auto' required></div>
							</div>
							<div class='row'>
								<div class='col-md-3'>Quantity: </div>
								<div class='col-md-3'><input type='number' name='quantity' min=1
										class='form-control w-auto' required></div>
							</div>
							<div class='row'>
								<div class='col-md-3'>Category: </div>
								<div class='col-md-3'>
									<select name='category' class='form-control w-auto' required>
										<option hidden>Choose here</option>
										<?php
										include("database/connection.php");
										$sql = $conn->prepare("SELECT * FROM categories");
										$sql->execute();
										$result = $sql->get_result();
										if ($result->num_rows > 0) {
											while ($row = $result->fetch_assoc()) {
												$type = $row["Type"];
												echo "<option value='$type'>$type</option>";
											}
										}
										?>
									</select>
								</div>
							</div>
						</form>
					</div>
					<div>
						<button class='btn' onclick="$('#formAdd').submit();">Add</button>
						<button type='button' class='btn btn-default'>Cancel</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div>
		<div>
			<table>
				<thead>
					<tr>
						<th>ID</th>
						<th>Shipping Costs</th>
						<th>Shipping Address</th>
						<th>Payment Method</th>
						<th>Submission Date</th>
						<th>Delivery Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<h4><b>Orders</b></h4>
					<?php
					$sql = "SELECT orders.ID, ShippingCosts, ShippingAddressID, PaymentMethodID, OrderDate, DeliveryDate
                                                FROM orders
                                                JOIN shopping_carts ON orders.CartID = shopping_carts.ID
                                                WHERE shopping_carts.UserID = " . $_SESSION["ID"];
					$result = $conn->query($sql);

					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							echo "
                                                    <tr>
                                                        <td>" . $row["ID"] . "</td>
                                                        <td>$" . $row["ShippingCosts"] . "</td>
                                                        <td><a class='noChangeColorLink' href='my-account.php?pag=address'>" . $row["ShippingAddressID"] . "</a></td>
                                                        <td><a class='noChangeColorLink' href='my-account.php?pag=payment'>" . $row["PaymentMethodID"] . "</a></td>
                                                        <td>" . $row["OrderDate"] . "</td>
                                                        <td>" . $row["DeliveryDate"] . "</td>
                                                        <td><button class='btn' onclick='caricaPopupModal(" . $row["ID"] . ")'>View</button></td>
                                                    </tr>";
						}
					} else {
						echo "<tr><td>No orders here......</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
					}
					?>
				</tbody>
			</table>
		</div>
	</div>


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