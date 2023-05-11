<?php
include("database/connection.php");

session_start();

$ProdID = $_GET['ID'];
$CartID;
$q = $_GET['q'];

//controllo se loggato
if (isset($_SESSION["CARTID_"])) {
    $idCart = $_SESSION["CARTID_"];
} else if (isset($_SESSION["CARTID_GuestUser"])) {
    $idCart = $_SESSION["CARTID_GuestUser"];
}


if (isset($CartID) && isset($ProdID) && isset($_GET['q'])) {
    //aggiorno quantità
    $sql = $conn->prepare("UPDATE contains SET Amount = ? WHERE CartID = ? AND ArticleID = ?");
    $sql->bind_param('iii', $q, $CartID, $ProdID);
    $sql->execute();
    header("location: shpCart.php?msg=Updated successfully!&type=success");
} else {
    header("location: shpCart.php");
}