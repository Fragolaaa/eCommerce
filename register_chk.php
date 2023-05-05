<?php
include("database/connection.php");
session_start();
//check password

if (strlen($_POST["password"]) < 8) {
    header("location:register_page.php&Password too short!");
}

if (!preg_match("#[0-9]+#", $_POST["password"])) {
    header("location:register_page.php&Password must include at least one number!");
}

if (!preg_match("#[a-zA-Z]+#", $_POST["password"])) {
    header("location:register_page.php&Password must include at least one letter!");
}


$password = md5($_POST["password"]."_".$_POST["email"]);
$confirmPwd = md5($_POST["confirmpwd"]."_".$_POST["email"]);

if (strcmp($password, $confirmPwd) == 0) {

    $firstName = $_POST["FirstName"];
    $lastName = $_POST["LastName"];
    $birthDate = $_POST["birthDate"];
    $phoneNumber = $_POST["phoneNumber"];
    $email = $_POST["email"];
    $seller = $_POST["seller"];
        if($seller === "Yes")
            $seller = 1;
        else 
            $seller = 0;

    //email already registered?
    $query = "SELECT email FROM users";
    $result = $conn->query($query);

    //controllo
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc())
            if ($email == $row["E-mail"]) {
                header("location:register_page.php?msg=This email has already been registered&type=warning");
                exit;
            }
    }

    //nuovo utente
    $query = $conn->prepare("INSERT INTO users (FirstName, LastName, E-mail, Password, BirthDate, PhoneNumber, Seller) VALUES (?,?,?,?,?,?,?)");
    $query->bind_param('ssssssi', $firstName, $lastName, $birthDate, $email, $phoneNumber, $password, $seller);
    if ($query->execute() === true) {
        //se creato correttamente l'utente creo un suo carrello tramite l'id
        $sql = "SELECT ID FROM users WHERE E-mail = '$email'";
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
        echo "Error: " . $query . "<br>" . $conn->error;
    }
    header("location:index.php?msg=registration successfull&type=success");
} else {
    header("location:register_page.php?msg=Oh no! Something went wrong, passwords do not match!&type=danger");
}