<?php
include("database/connection.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>

<body>
    <?php
    //Filters
    $query = "SELECT Title, ID, Price, Discount, Quantity FROM products ";

    //single product
    if (isset($_GET["filter"])) {
        switch ($_GET["filter"]) {
            case "sales":
                $query .= "WHERE Discount <> 0";
                break;
            case "usage":
                $query .= "WHERE State = 'Usage'";
                break;
            case "newest":
                $query .= "ORDER BY ID DESC";
                break;
            case "popular":
                $query .= "JOIN contains ON products.Id = contains.ArticleID GROUP BY contains.ArticleID ORDER BY COUNT(*) DESC";
                break;
            case "review":
                $query .= "JOIN reviews ON products.ID = reviews.ArticleID GROUP BY reviews.ArticleID ORDER BY AVG(Stars) DESC";
                break;
            // case "<25":
            //     $query .= "WHERE (Price * (100 - Discount) / 100) < 25";
            //     break;
            // case "<50":
            //     $query .= "WHERE (Price * (100 - Discount) / 100) > 25 AND (Price * (100 - Discount) / 100) < 50";
            //     break;
            // case ">50":
            //     $query .= "WHERE (Price * (100 - Discount) / 100) > 50";
            //     break;
            default:
                $query .= "WHERE Title LIKE '%" . $_GET["filter"] . "%'";
                break;
        }

        //categories
    } else if (isset($_GET["categories"])) {
        $categories = explode(",", $_GET["categories"]);
        if (count($categories) < 3)
            $categories[2] = "";
        $query .= "JOIN categories ON products.CategoryID = categories.ID WHERE Type = '" . $categories[0] . "' OR Type = '" . $categories[1] . "' OR Type = '" . $categories[2] . "'";

    } else if (isset($_GET["category"])) {
        $query .= "JOIN categories ON products.CategoryID = categories.ID WHERE Type = '" . $_GET["category"] . "'";

        //no filters
    } else {
        $query .= "JOIN categories ON products.CategoryID = categories.ID";
    }

    //impag.
    if (isset($_GET["p"]))
        $pag = $_GET["p"];
    else
        $pag = 1;

    //15 products/page
    $prodPerPage = 15;
    //first product
    $offset = ($prodPerPage * $pag) - $prodPerPage;

    $query .= " LIMIT $prodPerPage OFFSET $offset";

    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='col-md-2'>
                                         <div class='product-item'>
                                             <div class='product-title'>
                                                 <a href='#'>" . $row["Title"] . "</a>
                                                 <div class='rating'>
                                                     <i class='fa fa-star'></i>
                                                     <i class='fa fa-star'></i>
                                                     <i class='fa fa-star'></i>
                                                     <i class='fa fa-star'></i>
                                                     <i class='fa fa-star'></i>
                                                 </div>
                                             </div>
                                             <div class='product-image d-flex align-items-center'>
                                                 <a href='products.php'>
                                                     <img src='imgs/product-" . $row["ID"] . ".jpg' alt='Product Image'>
                                                 </a>
                                                 <div class='product-action'>
                                                     <a href='check/addToShpCart.php?id=" . $row["ID"] . "&q=1'><i class='fa fa-cart-plus'></i></a>
                                                     <a href='check/addToWishList.php?id=" . $row["ID"] . "&q=1'><i class='fa fa-heart'></i></a>
                                                     <a href='productDetail.php?id=" . $row["ID"] . "&q=1'><i class='fa fa-search'></i></a>
                                                 </div>
                                             </div>
                                             <div class='product-price'>";
            if ($row["Discount"] != 0)
                echo "<h3><span><s>$" . $row["Price"] . "</s> </span>$" . round($row["Price"] * (100 - $row["Discount"]) / 100, 2) . "</h3>";
            else
                echo "<h3>$" . $row["Price"] . "</h3>";

            if ($row["Quantity"] > 0)
                echo "<a class='btn' href='checkoutPage.php?id=" . $row["ID"] . "'><i class='fa fa-shopping-cart'></i>Buy Now</a>";
            else
                echo "<a class='btn soldout'><i class='fa fa-shopping-cart'></i>Sold Out</a>";
            echo "</div></div></div>";
        }
    }
    ?>
    </div>

    <!-- Pagination Start -->
    <div class="col-md-12">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php
                if (isset($_GET["p"]) && $_GET["p"] != 1) {
                    echo "  <li class='page-item active'>
                                         <a class='page-link' href=products.php?p=" . ($_GET["p"] - 1) . "' tabindex='-1'>Previous</a>
                                         </li>";
                } else {
                    echo "  <li class='page-item disabled'>
                                         <a class='page-link' href='' tabindex='-1'>Previous</a>
                                         </li>";
                }

                if (isset($_GET["p"])) {
                    switch ($_GET["p"]) {
                        case 1:
                            echo "  <li class='page-item active'><a class='page-link' href=products.php?p=1'>1</a></li>
                                                     <li class='page-item'><a class='page-link' href='products.php?p=2'>2</a></li>
                                                     <li class='page-item'><a class='page-link' href='products.php?p=3'>3</a></li>";
                            break;
                        case 2:
                            echo "  <li class='page-item'><a class='page-link' href='products.php?p=1'>1</a></li>
                                             <li class='page-item active'><a class='page-link' href='products.php?p=2'>2</a></li>
                                             <li class='page-item'><a class='page-link' href='products.php?p=3'>3</a></li>";
                            break;
                        case 3:
                            echo "  <li class='page-item'><a class='page-link' href='products.php?p=1'>1</a></li>
                                                 <li class='page-item'><a class='page-link' href='products.php?p=2'>2</a></li>
                                                 <li class='page-item active'><a class='page-link' href='products'.php?p=3'>3</a></li>";
                            break;
                        default:
                            for ($i = 1; $i < $_GET["p"]; $i++) {
                                echo "<li class='page-item'><a class='page-link' href='products.php?p=$i'>$i</a></li>";
                            }
                            echo "<li class='page-item active'><a class='page-link' href='products.php?p=" . $_GET["p"] . "'>" . $_GET["p"] . "</a></li>";
                    }
                    echo "  <li class='page-item active'>
                                             <a class='page-link' href='products.php?p=" . ($_GET["p"] + 1) . "' tabindex='-1'>Next</a>
                                         </li>";
                } else {
                    echo "  <li class='page-item active'><a class='page-link' href='products.php?p=1'>1</a></li>
                                                     <li class='page-item'><a class='page-link' href='products.php?p=2'>2</a></li>
                                                     <li class='page-item'><a class='page-link' href='products.php?p=3'>3</a></li>";
                    echo "  <li class='page-item active'>
                                             <a class='page-link' href='products.php?p=2' tabindex='-1'>Next</a>
                                         </li>";
                }
                ?>
            </ul>
        </nav>
    </div>
    <!-- Pagination End -->
    <? include("footer.php")?>

</body>

</html>