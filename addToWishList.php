<?php
include("database/connection.php");
session_start();

$ArticleID = $_GET['ID'];
$WishListID;

if (isset($_SESSION["WISHLISTID_"])) {                //logged
    $WishListID = $_SESSION["WISHLISTID_"];
} else if (isset($_SESSION["WISHLISTID_GuestUser"])) {       //guest wishlist w cookie
    $WishListID = $_SESSION["WISHLISTID_GuestUser"];
} else if (!isset($_SESSION["WISHLISTID_GuestUser"])) {      //no guest wishlist w cookie, not logged
    
    $sql = $conn->prepare("INSERT INTO wishlist() VALUES ()");
    $sql->execute();

    $WishListID = $conn->insert_id;

    $_SESSION["WISHLISTID_GuestUser"] = $WishListID;

    $cookie_name = "WISHLISTID_GuestUser";
    $cookie_value = $WishListID;
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
}


if (isset($WishListID) && isset($ArticleID)) {
    //article already in?
    $sql = $conn->prepare("SELECT * FROM includes WHERE WishListID = ? AND ArticleID = ? ");
    $sql->bind_param('ii', $WishListID, $ArticleID);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        //remove if already in
        $sql = $conn->prepare("DELETE FROM includes WHERE WishListID = ? AND ArticleID = ?");
        $sql->bind_param('ii', $WishListID, $ArticleID);
        $sql->execute();
        header("location:products.php?msg=Product removed from wishlist&type=danger");
    } else {
        //add product into wishlist
        $sql = $conn->prepare("INSERT INTO includes (WishListID, ArticleID) VALUES (?,?)");
        $sql->bind_param('ii', $WishListID, $ArticleID);
        $sql->execute();
        header("location:products.php?msg=Product added to wishlist&type=success");
    }
} else
    header("location:products.php?msg=Product doesn't exist!&type=danger");
?>