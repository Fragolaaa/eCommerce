<?php
include("database/connection.php");

session_start();

$email = $_POST['email'];
$password = md5($_POST['password']."_".$email);

$query = $conn->prepare("SELECT ID, E-mail, Password FROM users WHERE E-mail = ? AND Password = ?");
$query->bind_param('iss', $email, $password);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  //save session
  $_SESSION['ID'] = $row['ID'];
  $_SESSION['Username'] = $row['Username'];

  //last user's cart
  $sql = $conn->prepare("SELECT MAX(ID) FROM shopping_cart WHERE UserID = ?");
  $sql->bind_param('i', $_SESSION['ID']);
  $sql->execute();
  $result = $sql->get_result();
  $row = $result->fetch_assoc();
  $_SESSION['CartID'] = $row['MAX(ID)'];

  //select user's wishlist
  $sql = $conn->prepare("SELECT ID FROM wishlist WHERE UserID = ?");
  $sql->bind_param('i', $_SESSION['ID']);
  $sql->execute();
  $result = $sql->get_result();
  $row = $result->fetch_assoc();
  $_SESSION['WishListID'] = $row['ID'];

  header("location:index.php?msg=Logged in&type=success");
} else {
  header("location:login.php?msg=Incorrect email or password&type=danger");
}