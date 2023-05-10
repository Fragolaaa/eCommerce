<?php
include("database/connection.php");
session_start();

$password = md5("ciao");
$confirmPwd = md5("ciao");

if (strcmp($password, $confirmPwd) != 0) {
    echo $password;
    echo $confirmPwd;
} else {
    echo "sto querando";
    $firstName = $_POST["FirstName"];
    $lastName = $_POST["LastName"];
    $birthDate = $_POST["birthDate"];
    $phoneNumber = $_POST["phoneNumber"];
    $email = $_POST["email"];
    $password = md5($_POST["password"] . "_" . $email);
    $confirmPwd = md5($_POST["confirmpwd"] . "_" . $email);

    $seller = intval($_POST["seller"]);
    //email already registered?
    $query = "SELECT Email FROM users";
    $result = $conn->query($query);

    //controllo
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc())
            if ($email == $row["Email"]) {
                header("location:register_page.php?msg=This email has already been registered&type=warning");
                exit;
            }
    }

    //nuovo utente
    $query = $conn->prepare("INSERT INTO users (FirstName, LastName, Email, Password, BirthDate, PhoneNumber, Seller) VALUES (?,?,?,?,?,?,?)");
    $query->bind_param('ssssssi', $firstName, $lastName, $birthDate, $email, $phoneNumber, $password, $seller);
    if ($query->execute() === true) {
        //se creato correttamente l'utente creo un suo carrello tramite l'id
        $sql = "SELECT ID FROM users WHERE Email = '$email'";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        $id = $row["ID"];

        $query = $conn->prepare("INSERT INTO shopping_cart (UserID) VALUES (?)");
        $query->bind_param('i', $id);
        $query->execute();

        $query = $conn->prepare("INSERT INTO wishlist (UserID) VALUES (?)");
        $query->bind_param('i', $id);
        $query->execute();
    } else {
        print_r("Error: " . $query . "<br>" . mysqli_error($conn));
    }
    header("location:index.php?msg=registration successfull&type=success");
}


?>