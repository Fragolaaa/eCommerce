<?php
include("database/connection.php");
session_start();


$password = md5($_POST["password"]);
$chk = md5($_POST["chkPassword"]);
if ($_POST["password"] != "") {
    if (strcmp($password, $chk) == 0) {

     
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $birthDate = $_POST["birthDate"];
        $mobileNumber = $_POST["mobileNumber"];
        $email = $_POST["email"];


        $sql = $conn->prepare("SELECT Email FROM users WHERE ID <> ?");
        $sql->bind_param('i', $_SESSION["ID"]);
        $sql->execute();
        $result = $sql->get_result();


        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc())
                if ($username == $row["Email"]) {
                    header("location:userAccount.php?msg=Email already used!&type=warning");
                    return 0;
                }
        }

        //update utente
        $sql = $conn->prepare("UPDATE users SET  FirstName = ?, LastName = ?, BirthDate = ?, PhoneNumber = ?, Email = ?, Password = ? WHERE ID = ?");
        $sql->bind_param('ssdsssi', $username, $firstName, $lastName, $birthDate, $mobileNumber, $email, $password, $_SESSION["ID"]);
        $sql->execute();

        header("location:userAccount.php?msg=Updated successfully!&type=success");
    } else {
        header("location:userAccount.php?msg=Wrong password!&type=danger");
    }
} else
    header("location:userAccount.php?msg=Password cannot be empty!&type=danger");
