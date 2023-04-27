<?php
 include("database/connection.php");
 session_start();
 ?>

<header>
    <!-- TOP HEADER -->
    <div id="top-header">
        <div class="container">
            <ul class="header-links pull-left">
                <li><a href="#"><i class="fa fa-phone"></i> +123-456-789-1011</a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i> customerService@taniepress.com</a></li>
            </ul>
            <ul class="header-links pull-right">
                <li><a href="login_page.php"><i class="fa fa-user-o"></i> My Account</a></li>
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
                            <!-- <select class="input-select">
                                <option value="0">All Categories</option>
                                <option value="1">Category 01</option>
                                <option value="1">Category 02</option>
                            </select> -->
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
                                <span>Your Wishlist</span>
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
                        <div class="dropdown">
                            <a href="shpCart.php" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Your Cart</span>
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
                            <!-- <div class="cart-dropdown">
                                <div class="cart-list">
                                    <div class="product-widget">
                                        <div class="product-img">
                                            <img src="./img/product01.png" alt="">
                                        </div>
                                        <div class="product-body">
                                            <h3 class="product-name"><a href="#">product name goes here</a></h3>
                                            <h4 class="product-price"><span class="qty">1x</span>$980.00</h4>
                                        </div>
                                        <button class="delete"><i class="fa fa-close"></i></button>
                                    </div>

                                    <div class="product-widget">
                                        <div class="product-img">
                                            <img src="./img/product02.png" alt="">
                                        </div>
                                        <div class="product-body">
                                            <h3 class="product-name"><a href="#">product name goes here</a></h3>
                                            <h4 class="product-price"><span class="qty">3x</span>$980.00</h4>
                                        </div>
                                        <button class="delete"><i class="fa fa-close"></i></button>
                                    </div>
                                </div>
                                <div class="cart-summary">
                                    <small>3 Item(s) selected</small>
                                    <h5>SUBTOTAL: $2940.00</h5>
                                </div>
                                <div class="cart-btns">
                                    <a href="shpCart.php">View Cart</a>
                                    <a href="chechoutPage.php">Checkout  <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div> -->
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
                <li class="active"><a href="#">Home</a></li>
                <li><a href="product-list.php?filter=HotDeals">Hot Deals</a></li>
                <li><a href="product-list.php?filter=Trending">Trending</a></li>
                <li><a href="product-list.php?filter=fashion">Fashion</a></li>
                <li><a href="product-list.php?filter=Electronics">Electronics</a></li>   
                <li><a href="#">Cameras</a></li>
                <li><a href="#">Accessories</a></li>
            </ul>
            <!-- /NAV -->
        </div>
        <!-- /responsive-nav -->
    </div>
    <!-- /container -->
</nav>
<!-- /NAVIGATION -->