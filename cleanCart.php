<?php
include("database/connection.php");
session_start();

$CartID;

if (isset($_SESSION["CARTID_"])) {
    $CartID = $_SESSION["CARTID_"];
} else if (isset($_SESSION["CARTID_GuestUser"])) {
    $CartID = $_SESSION["CARTID_GuestUser"];
}

if (isset($CartID)) {
    $sql = $conn->prepare("DELETE FROM contains WHERE CartID = ?");
    echo $con->error;
    $sql->bind_param('i', $CartID);
    $sql->execute();
    header("location: shpCart.php?msg=Clean successfully!&type=success");
} else
    header("location: shpCartcart.php");