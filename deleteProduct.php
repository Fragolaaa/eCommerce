<?php
include("database/connection.php");

$ID = $_GET["ID"];

//cerco carrello associato all'ordine
$sql = $conn->prepare("DELETE FROM articles WHERE ID = ?");
$sql->bind_param('i', $ID);
$sql->execute();
header("location: ../my-account.php?msg=Article deleted successfully!&type=success&pag=seller");