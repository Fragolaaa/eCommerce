<?php
include("database/connection.php");
session_start();

$ProductID = $_GET["ID"];

if ($_GET["stars"] != 0) {
    if (isset($_SESSION["ID"])) {
        $sql = $conn->prepare("INSERT INTO reviews (ArticleID, UserID, Title, Content, Stars) VALUES (?, ?, ?, ?, ?)");
        $sql->bind_param('iissi', $ProductID, $_SESSION["ID"], $_GET["title"], $_GET["text"], $_GET["stars"]);
        $sql->execute();
        header("location: productDetail.php?ID=$ProductID&msg=Review added successfully!&type=success");
    } else
        header("location: login.php?msg=Log in to review!&type=warning");
} else {
    header("location: productDetail.php?ID=$ProductID&msg=Stars must be at least one!&type=warning");
}