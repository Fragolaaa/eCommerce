<?php
include "connection.php";
if(!isset($_SESSION["username"]))
{
    header("location: index.php?err&Login first!");
    die();
}
?>