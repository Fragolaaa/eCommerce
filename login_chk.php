<?php
include "./database/connection.php";
session_start();
$email = $_POST['email'];
$password = md5($_POST['password']."_".$email);

$query = $conn->prepare("SELECT ID, Email, Password FROM users WHERE Email = ? AND Password = ?");
print_r($conn->error_list);
$query->bind_param('ss', $email, $password);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  //save session
  $_SESSION['ID'] = $row['ID'];
  $_SESSION['USERNAME'] = $row['Username'];

  //last user's cart
  $sql = $conn->prepare("SELECT ID FROM shopping_cart WHERE UserID = ?");
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