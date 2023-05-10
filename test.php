<!-- Cart -->
<div>
                            <a href="shpCart.php">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Your cart</span>
                                <!-- <div class="qty">3</div> -->
                                <?php
                                if (isset($_SESSION["CARTID_"])) {
                                    $query = "SELECT COUNT(*) FROM contains JOIN shopping_carts ON contains.CartID = shopping_carts.ID WHERE shopping_carts.ID = '" . $_SESSION["CARTID_"] . "'";

                                    $result = $conn->query($query);

                                    $row = $result->fetch_assoc();
                                    $n = $row["COUNT(*)"];
                                } else if (isset($_SESSION["CARTID_GuestUser"])) {
                                    $query = "SELECT COUNT(*) FROM contains JOIN shopping_carts
                                ON contains.CartID = shopping_carts.ID
                                WHERE shopping_carts.ID = '" . $_SESSION["CARTID_GuestUser"] . "'";

                                    $result = $conn->query($query);
                                    mysqli_error($conn);
                                    $row = $result->fetch_assoc();
                                    $n = $row["COUNT(*)"];
                                } else
                                    $n = 0;
                                echo "<div class='qty'>" . $n . "</div>";
                                ?>
                            </a>
                        </div>
                        <!-- /Cart -->