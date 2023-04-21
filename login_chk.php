<?php
include "\database\connection.php";

$pwd = md5($_POST["password"]+"_"+$_POST["email"]);

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $_POST["username"], $pwd);
$stmt->execute();
$result = $stmt->get_result();

$stmt->close();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["userID"] = $row["ID"];
    header("location: index.php?");
} else {
    header("location: login_page.php?err=Credenziali errate!&oldEmail=" . $_POST["username"]);
}
$conn->close();

?>