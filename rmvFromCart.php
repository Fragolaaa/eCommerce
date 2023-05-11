<?php
include("database/connection.php");
session_start();

$ProdID = $_GET['ID'];
$CartID;

//controllo se loggato
if (isset($_SESSION["CARTID_"])) {
    $CartID = $_SESSION["CARTID_"];
} else if (isset($_SESSION["CARTID_GuestUser"])) {
    $CartID = $_SESSION["CARTID_GuestUser"];
}

if (isset($CartID) && isset($ProdID)) {
    //rimuovo articolo
    $sql = $conn->prepare("DELETE FROM contains WHERE CartID = ? AND ArticleID = ?");
    $sql->bind_param('ii', $CartID, $ProdID);
    $sql->execute();
    header("location:shpCart.php?msg=Removed from cart successfully!&type=success");
} else
    header("location:shpCart.php");