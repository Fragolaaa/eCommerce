<?php
include("database/connection.php");
//FILTRI
$sql = "SELECT products.Title, products.ID, Price, Discount, Quantity FROM products ";

if (isset($_GET["category"])) {
    if($_GET["category"]!="")
        $sql .= " JOIN categories ON products.CategoryID = categories.ID WHERE Type = '" . $_GET["category"] . "' AND ";
    else 
        $sql .= " JOIN categories ON products.CategoryID = categories.ID WHERE ";
}

if (isset($_GET["filter"])) {
    if($_GET["filter"]=="")
        $sql .= "1";
    else
        $sql .= "Title LIKE '%" . $_GET["filter"] . "%'";
} 


$result = $conn->query($sql);
$r = 1;
echo "<div class='row'>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
       

        if ($row["Discount"] != 0)
            $discountedPrice = round($row["Price"] * (100 - $row["Discount"]) / 100, 2);

            

        echo "<div class='col-md-4'><a href='productDetail.php?ID=" . $row['ID'] . "'>
                                            <div class='product'>
                                                <div class='product-img'>
                                                <img src='./imgs/product-" . $row['ID'] . ".jpg' alt=''>
                                                <div class='product-label'>";
        if ($row["Discount"] > 0)
            echo " <span class='sale'>" . $row['Discount'] . "%</span>";
        echo "</div></div>
                                                <div class='product-body'>
											<p class='product-category'>" . $row["Type"] . "</p>
											<h3 class='product-name'><a href='productDetail.php?ID=" . $row['ID'] . "'>" . $row['Title'] . "</a></h3>";
        if ($row["Discount"] != 0) {
            echo "<h4 class='product-price'>" . $discountedPrice . "$<del class='product-old-price'>" . $row["Price"] . "$</del></h4>";
        } else {
            echo "<h4 class='product-price'>" . $row["Price"] . "$</h4>";
        }
        echo "<div class='product-rating'>
												<i class='fa fa-star'></i>
												<i class='fa fa-star'></i>
												<i class='fa fa-star'></i>
												<i class='fa fa-star'></i>
												<i class='fa fa-star'></i>
											</div>
                                            <div class='product-btns'>
												<button onClick='location.href=\"addToWishList.php?ID=" . $row["ID"] . "\"' class='add-to-wishlist'><i class='fa fa-heart-o'></i><span
														class='tooltipp'>add to wishlist</span></button>
												<button onClick='location.href=\"productDetail.php?ID=" . $row["ID"] . " \"' class='quick-view'><i class='fa fa-eye'></i><span
														class='tooltipp'>quick view</span></button>
											</div>
										</div>
										<div class='add-to-cart'>
											<button onClick='location.href=\"addToShpCart.php?ID=" . $row["ID"] . "&q=1\"' class='add-to-cart-btn'><i class='fa fa-shopping-cart'></i> add to
												cart</button>
										</div>
                                        </div></div>";
        $r += $r;
        if ($r == 3) {
            $r = 1;
            echo "<div class='row'>";
        }

    }
}
echo "</div>"
?>