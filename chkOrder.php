<?php
include("database/connection.php");
session_start();

$sql = $conn->prepare("SELECT ID FROM addresses WHERE `Address` = ? AND Country = ? AND City = ? AND Province = ? AND `ZIP Code` = ?");
$sql->bind_param('sssss', $_POST["address"], $_POST["country"], $_POST["city"], $_POST["province"], $_POST["zip-code"]);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ShippingAddressID = $row["ID"];
} else {
    //se non presente inserisco
    if (isset($_SESSION["ID"])) {
        if (isset($_POST["saveAddress"])) {
            $sql = $conn->prepare("INSERT INTO `addresses` (`Address`, `ZIP Code`, Country, City, Province, UserShippingDefault, UserPaymentDefault, UserID) VALUES (?, ?, ?, ?, ?, 0, 0, ?)");
            $sql->bind_param('sssssi', $_POST["address"], $_POST["country"], $_POST["city"], $_POST["province"], $_POST["zip-code"], $_SESSION["ID"]);
        }
    } else {
        if (isset($_POST["saveAddress"])) {
            $sql = $conn->prepare("INSERT INTO addresses  (`Address`, Country, City, Province, `ZIP Code`) VALUES (?, ?, ?, ?, ?)");
            $sql->bind_param('sssss', $_POST["address"], $_POST["country"], $_POST["city"], $_POST["province"], $_POST["zip-code"]);
        }
    }

    $sql->execute();
    $ShippingAddressID = $conn->insert_id;
}


//DELIVERY DATE    
$date = new DateTime('now');
$date->add(new DateInterval('P7D'));
$DelDate = $date->format("Y-m-d");

//PAYMENT METHOD
if (isset($_POST["payment"])) {
    if ($_POST["payment"] == "Paypal") {
        if (isset($_SESSION["ID"])) {
            //controllo se già collegato l'indirizzo email paypal
            $sql = $conn->prepare("SELECT ID FROM payment_methods WHERE Method = 'Paypal' AND Email = ? AND UserID = ?");
            $sql->bind_param('si', $_POST["email"], $_SESSION["ID"]);
            $sql->execute();
            $result = $sql->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $PaymentMethodID = $row["ID"];
            } else {
                //altrimenti aggiungo
                $sql = $conn->prepare("INSERT INTO payment_methods(Method, Email, UserID) VALUES ('Paypal',?,?)");
                $sql->bind_param('si', $_POST["email"], $_SESSION["ID"]);
                $sql->execute();
                $PaymentMethodID = $conn->insert_id;
            }
        } else {
            header("location: login_page.php&msg=Login first!");
        }
    } else if ($_POST["payment"] == "visa" || $_POST["payment"] == "mastercard" || $_POST["payment"] == "amex") {
        if (isset($_SESSION["ID"])) {
            $sql = $conn->prepare("SELECT ID FROM payment_methods WHERE Method = " . $_POST['payment'] . " AND CardNumber = ? AND CardHolder = ? AND ExpirationDate = ? AND UserID = ?");
            $sql->bind_param('sssi', $_POST["CardNumber"], $_POST["CardHolder"], $_POST["expDate"], $_SESSION["ID"]);
            $sql->execute();
            $result = $sql->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $PaymentMethodID = $row["ID"];
            } else {
                //altrimenti aggiungo
                $sql = $conn->prepare("INSERT INTO payment_methods(Method, CardNumber, CardHolder, ExpirationDate, UserID) VALUES (" . $_POST["payment"] . ",?,?,?,?)");
                $sql->bind_param('sssi', $_POST["CardNumber"], $_POST["CardHolder"], $_POST["expDate"], $_SESSION["ID"]);
                $sql->execute();
                $PaymentMethodID = $conn->insert_id;
            }
        } else {
            //guest
            header("location: login_page.php&msg=Login first!");
        }
    }

}

if (isset($_SESSION["CARTID_"]))
    $CartID = $_SESSION["CARTID_"];
else if (isset($_SESSION["CARTID_GuestUser"]))
    $CartID = $_SESSION["CARTID_GuestUser"];

$shippingCost = 4.99;

print_r("\n"  . $ShippingAddressID . " , " . $PaymentMethodID . " , " . $CartID);
if ( isset($ShippingAddressID) && isset($PaymentMethodID) && isset($CartID)) {

    $sql = $conn->prepare("SELECT ArticleID, Title, Quantity, Amount FROM contains JOIN products ON ArticleID = ID WHERE CartID = ?");
    $sql->bind_param('i', $CartID);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["Quantity"] == 0) {
                header("location: shpCart.php?msg=" . $row["Title"] . " not available!&type=danger");
                exit;
            }
            //update db
            $sql = $conn->prepare("UPDATE products SET Quantity= ? WHERE Id = ?");
            $newPieces = $row["Quantity"] - $row["Amount"];
            $sql->bind_param('ii', $newPieces, $row["ArticleID"]);
            $sql->execute();
        }
    } else {
        header("location: shpCart.php");
        exit;
    }


    $sql = $conn->prepare("INSERT INTO orders (OrderDate, DeliveryDate, ShippingAddressID, PaymentMethodID, CartID) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param('siiiii', $date, $DelDate, $ShippingAddressID, $PaymentMethodID, $CartID);
    $sql->execute();

    if (isset($_SESSION["CARTID_"])) {
        $sql = $conn->prepare("INSERT INTO shopping_cart (UserID) VALUES (?)");
        $sql->bind_param('i', $_SESSION["ID"]);
        $sql->execute();

        $NewCartID = $conn->insert_id;

        $_SESSION["CARTID_"] = $NewCartID;
    } else if (isset($_SESSION["CARTID_GuestUser"])) {
        $sql = $conn->prepare("INSERT INTO shopping_cart () VALUES ()");
        $sql->execute();

        $NewCartID = $conn->insert_id;

        $_SESSION["CARTID_GuestUser"] = $NewCartID;

        //aggiorno cookie
        $cookie_name = "CARTID_GuestUser";
        $cookie_value = $NewCartID;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1  
    }
    //header("location: resume.php?msg=success!&type=success");
} else
    header("location: shpCart.php?msg=You must pay!&type=warning");