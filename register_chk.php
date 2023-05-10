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

$password = md5($_POST["password"]);
$confirmPwd = md5($_POST["confirmPwd"]);

if (strcmp($password, $confirmPwd) != 0) {
    // echo $password;
    // echo $confirmPwd;
   header("location:register_page.php?msg=Oh no! Something went wrong, passwords do not match!&type=danger");
} else {
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
    $query->bind_param('ssssssi', $firstName, $lastName, $email, $password, $birthDate,  $phoneNumber, $seller);
    if ($query->execute() === true) {
        //se creato correttamente l'utente creo un suo carrello tramite l'id
        $_SESSION['USERNAME'] = $row['FirstName'];
        $_SESSION['USERNAME'] = $row["ID"];
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
        header("location:index.php?msg=registration successfull&type=success");
    } else {
        print_r(mysqli_error($conn));
    }
    
}


?>