<?php
include("database/connection.php");
session_start();

$ProdID = $_GET['ID'];
$CartID;

if (isset($_SESSION["CARTID_"])) {                       //logged user
    $CartID = $_SESSION["CARTID_"];
} else if (isset($_SESSION["CARTID_GuestUser"])) {           //guest user cart
    $CartID = $_SESSION["CARTID_GuestUser"];
} else if (!isset($_SESSION["CARTID_GuestUser"])) {          //no guest user cart, not logged
    //creating guest user cart 
    $sql = $conn->prepare("INSERT INTO shopping_cart () VALUES ()");
    $sql->execute();

    $CartID = $conn->insert_id;

    $_SESSION["CARTID_GuestUser"] = $CartID;

    //creating cookie with CartID value
    $cookie_name = "CARTID_GuestUser";
    $cookie_value = $CartID;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
}

if (isset($CartID) && isset($ProdID) && $_GET["q"] != null && $_GET["q"] != 0) {
    //product already in the cart?
    $sql = $conn->prepare("SELECT Amount FROM contains WHERE CartID = ? AND ArticleID = ?");
    $sql->bind_param('ii', $CartID, $ProdID);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        //if it's already there then rise the amount in the cart
        $row = $result->fetch_assoc();
        $newQuantity = $row["Quantity"] + $_GET["q"];

        //product availability
        $sql = $conn->prepare("SELECT Quantity FROM products WHERE ID = ?");
        $sql->bind_param('i', $ProdID);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row["Pieces"] >= $newQuantity) {
                //update product's amount in the cart
                $sql = $conn->prepare("UPDATE contains SET Amount = ? WHERE CartID = ? AND ArticleID = ?");
                $sql->bind_param("iii", $newQuantity, $CartID, $ProdID);
                $sql->execute();
                header("location:products.php?msg=Added to cart successfully!&type=success");
            } else {
                header("location:products.php?msg=Insufficient amount of pieces of the product!&type=danger");
            }
        } else
            header("location:..\products.php?msg=Product doesn't exist!&type=danger");
    } else {
        $sql = $conn->prepare("SELECT Quantity FROM products WHERE ID = ?");
        $sql->bind_param('i', $ProdID);
        $sql->execute();
        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row["Pieces"] >= $_GET["q"]) {
                //aggiungo articolo
                $sql = $conn->prepare("INSERT INTO contains (CartID, ArticleID, Amount) VALUES (?,?,?)");
                $sql->bind_param('iii', $CartID, $ProdID, $_GET['q']);
                $sql->execute();
                header("location:products.php?msg=Added to cart successfully!&type=success");
            } else {
                header("location:products.php?msg=Insufficient amount of pieces of the product!&type=danger");
            }
        } else
            header("location:products.php?msg=Product doesn't exist!&type=danger");
    }
} else
    header("location:products.php?msg=Product sold out!&type=danger");
?>