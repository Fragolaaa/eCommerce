<?php
include "connection.php";
if(!isset($_SESSION["username"]))
{
    session_start();
    die();
}
?>