<?php
include("database/connection.php");
session_start();
?>

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


</head>
<header>

    <!-- TOP HEADER -->
    <div id="top-header">
        <div class="container">
            <ul class="header-links pull-left">
                <li><a href="#"><i class="fa fa-phone"></i> +123-456-789-1011</a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i> customerService@taniexpress.com</a></li>
            </ul>
            <ul class="header-links pull-right">
                <div class="dropdown">
                    <?php
                    if (isset($_SESSION["USERNAME"])) {
                        echo "<a href='#' class='nav-link dropdown-toggle' data-toggle='dropdown'>" . $_SESSION["USERNAME"] . "</a>
                                <div class='dropdown-content'>
                                    <a href='userAccount.php' class='dropdown-item userDropdown' style='color:white'>My Account</a>
                                    <a href='logout.php?' class='dropdown-item userDropdown'>Logout</a>
                                </div>";
                    } else {
                        echo "<a href='#' class='nav-link dropdown-toggle' data-toggle='dropdown' style='color:white'>Account</a>
                                <div class='dropdown-content'>
                                    <a href='login_page.php' class='dropdown-item userDropdown'>Login</a>
                                    <a href='register_page.php' class='dropdown-item userDropdown'>Register</a>
                                </div>";
                    }
                    ?>
                </div>
        </div>

        </ul>
    </div>
    </div>
    <!-- /TOP HEADER -->

    <!-- MAIN HEADER -->
    <div id="header">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- LOGO -->
                <div class="col-md-3">
                    <div class="header-logo">
                        <a href="#" class="logo">
                            <img src="./imgs/logo.png" alt="">
                        </a>
                    </div>
                </div>
                <!-- /LOGO -->

                <!-- SEARCH BAR -->
                <div class="col-md-6">
                    <div class="header-search">
                        <form href="products.php" method="get">
                            <select class="input-select">
                                <option value="0">All Categories</option>
                                <?php
                                $query = "SELECT Type FROM categories";
                                $result = $conn->query($query);

                                //controllo
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc())
                                        echo "<option value=" . $row['ID'] . ">" . $row['Type'] . "</option>";
                                }
                                ?>

                            </select>
                            <input class="input" placeholder="Search here">
                            <button class="search-btn">Search</button>
                        </form>
                    </div>
                </div>
                <!-- /SEARCH BAR -->

                <!-- ACCOUNT -->
                <div class="col-md-3 clearfix">
                    <div class="header-ctn">
                        <!-- Wishlist -->
                        <div>
                            <a href="wishList.php">
                                <i class="fa fa-heart-o"></i>
                                <span>Your wishlist</span>
                                <!-- <div class="qty">2</div> -->
                                <?php
                                if (isset($_SESSION["WISHLISTID_"])) {

                                    $query = "SELECT COUNT(*) FROM includes JOIN wishlist
                                ON includes.WishListID = wishlist.ID
                                WHERE wishlist.ID = '" . $_SESSION["WISHLISTID_"] . "'";

                                    $result = $conn->query($query);


                                    $row = $result->fetch_assoc();
                                    $n = $row["COUNT(*)"];
                                } else if (isset($_SESSION["WISHLISTID_GuestUser"])) {
                                    $sql = "SELECT COUNT(*) FROM includes JOIN wishlist
                                ON includes.WishListID = wishlist.ID
                                WHERE wishlist.Id = '" . $_SESSION["WISHLISTID_GuestUser"] . "'";

                                    $result = $conn->query($query);

                                    $row = $result->fetch_assoc();
                                    $n = $row["COUNT(*)"];
                                } else
                                    $n = 0;
                                echo "<div class='qty'>" . $n . "</div>";
                                ?>
                            </a>
                        </div>
                        <!-- /Wishlist -->

                        <!-- Cart -->
                        <div>
                            <a href="shpCart.php">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Your cart</span>
                                <!-- <div class="qty">3</div> -->
                                <?php
                                if (isset($_SESSION["CARTID_"])) {
                                    $query = "SELECT COUNT(*) FROM contains JOIN shopping_carts
                                ON contains.CartID = shopping_carts.ID
                                WHERE shopping_carts.ID = '" . $_SESSION["CARTID_"] . "'";

                                    $result = $conn->query($query);

                                    $row = $result->fetch_assoc();
                                    $n = $row["COUNT(*)"];
                                } else if (isset($_SESSION["CARTID_GuestUser"])) {
                                    $query = "SELECT COUNT(*) FROM contains JOIN shopping_carts
                                ON contains.CartID = shopping_carts.ID
                                WHERE shopping_carts.ID = '" . $_SESSION["CARTID_GuestUser"] . "'";

                                    $result = $conn->query($query);

                                    $row = $result->fetch_assoc();
                                    $n = $row["COUNT(*)"];
                                } else
                                    $n = 0;
                                echo "<div class='qty'>" . $n . "</div>";
                                ?>
                            </a>
                        </div>
                        <!-- /Cart -->

                        <!-- Menu Toogle -->
                        <div class="menu-toggle">
                            <a href="#">
                                <i class="fa fa-bars"></i>
                                <span>Menu</span>
                            </a>
                        </div>
                        <!-- /Menu Toogle -->
                    </div>
                </div>
                <!-- /ACCOUNT -->
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </div>
    <!-- /MAIN HEADER -->
</header>

<!-- NAVIGATION -->
<nav id="navigation">
    <!-- container -->
    <div class="container">
        <!-- responsive-nav -->
        <div id="responsive-nav">
            <!-- NAV DA SISTEMARE!!! -->
            <ul class="main-nav nav navbar-nav">
                <li class="active"><a href="index.php">Home</a></li>
                <?php
                $query = "SELECT Type FROM categories";
                $result = $conn->query($query);

                //controllo
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc())
                        echo "<li><a href='products.php?filter=" . $row['Type'] . "'>" . $row['Type'] . "</a></li>";
                }
                ?>

            </ul>
            </ul>
            <!-- /NAV -->
        </div>
        <!-- /responsive-nav -->
    </div>
    <!-- /container -->
</nav>
<!-- /NAVIGATION -->