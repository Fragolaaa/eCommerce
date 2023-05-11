<?php
include("database/connection.php");
session_start();

$ProdID = $_GET['ID'];
$WishListID;

//controllo se loggato
if (isset($_SESSION["WISHLISTID_"])) {
    $WishListID = $_SESSION["WISHLISTID_"];
} else if (isset($_SESSION["WISHLISTID_GuestUser"])) {
    $WishListID = $_SESSION["WISHLISTID_GuestUser"];
}

if (isset($WishListID) && isset($ProdID)) {
    //rimuovo articolo
    $sql = $conn->prepare("DELETE FROM includes WHERE WishListID = ? AND ArticleID = ?");
    $sql->bind_param('ii', $WishListID, $ProdID);
    $sql->execute();
    header("location:wishList.php?msg=Removed from wishlist successfully!&type=success");
} else {
    header("location:wishList.php");
}