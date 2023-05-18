<?php
session_start();
include("database/connection.php");

$msg = "";

if ($_FILES["fileToUpload"]["tmp_name"] != null && $_POST["description"] != null && $_POST["title"] != null && $_POST["conditions"] != null && $_POST["price"] != null && $_POST["discount"] != null &&  $_POST["pieces"] != null &&  $_POST["category"] != null) {
    $sql = $conn->prepare("SELECT Id FROM categories WHERE Type = ?");
    $sql->bind_param('s', $_POST["category"]);
    $sql->execute();

    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $categoryId = $row["Id"];
        $sql = $conn->prepare("INSERT INTO articles (Title, `Description`, Seller, Conditions, Price, Discount, Pieces, IdCategory) VALUES (?,?,?,?,?,?,?,?)");
        $sql->bind_param('ssssddii', $_POST["title"], $_POST["description"], $_SESSION["Username"], $_POST["conditions"], $_POST["price"], $_POST["discount"], $_POST["pieces"], $categoryId);
        $sql->execute();

        $id = $conn->insert_id;

        $target_dir = "../img/";
        $target_file = $target_dir . "product-$id.jpg";
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check === false) {
            $msg .= "File is not an image.\n";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $msg .= "Sorry, file already exists.\n";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg") {
            $msg .= "Sorry, only JPG files are allowed.\n";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $msg .= "Sorry, your file was not uploaded.&type=danger";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $msg .= "The file product-$id.jpg has been uploaded.&type=success";
            } else {
                $msg .= "Sorry, there was an error uploading your file.&type=danger";
            }
        }
    }
} else {
    $msg .= "Error while adding the article!&type=danger";
}
header("location:../my-account.php?pag=seller&msg=$msg");