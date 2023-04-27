<?php
include("database/connection.php");

session_start();

$email = $_POST['email'];
$password = md5($_POST['password']);

$query = $conn->prepare("SELECT Id, E-mail, Password FROM users WHERE E-mail = ? AND Password = ?");
$query->bind_param('sss', $email, $password);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  //save session
  $_SESSION['ID'] = $row['ID'];
  $_SESSION['Username'] = $row['Username'];

  //last user's cart
  $sql = $conn->prepare("SELECT MAX(Id) FROM shopping_cart WHERE UserID = ?");
  $sql->bind_param('i', $_SESSION['ID']);
  $sql->execute();
  $result = $sql->get_result();
  $row = $result->fetch_assoc();
  $_SESSION['CartID'] = $row['MAX(Id)'];

  //select user's wishlist
  $sql = $conn->prepare("SELECT Id FROM wishlist WHERE UserID = ?");
  $sql->bind_param('i', $_SESSION['ID']);
  $sql->execute();
  $result = $sql->get_result();
  $row = $result->fetch_assoc();
  $_SESSION['WishListID'] = $row['Id'];

  header("location:index.php?msg=Logged in&type=success");
} else {
  header("location:login.php?msg=Incorrect email or password&type=danger");
}