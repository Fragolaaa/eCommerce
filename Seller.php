<?php
include("database/connection.php");

$prodID = $_GET["ID"];

echo "  <div class='modal-dialog w-auto'>
        <div class='modal-content'>
        <div class='modal-header'>
            <h4 class='modal-title'>Product #$prodID</h4>
        </div>
        <div class='modal-body'>
        <form id='form' method='post' action='updateProduct.php' enctype='multipart/form-data'>";

$sql = $conn->prepare("SELECT * FROM products JOIN categories ON products.CategoryID = categories.ID WHERE products.ID = ?");
$sql->bind_param('i', $prodID);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "  <input type='hidden' name='productID' value='$prodID'>
            <p>
                <img class='mx-auto' style='width: 215px; height: auto; object-fit: scale-down;' src='img/product-" . $prodID . ".jpg'>
                <input type='file' name='fileToUpload' id='fileToUpload' required>
            </p>
            <div class='row'>
            <div class='col-md-3'>Title: </div>
            <div class='col-md-3'><input type='text' name='title' value='" . $row["Title"] . "' class='form-control w-auto' required></div>
            </div>
            <div class='row'>
            <div class='col-md-3'>Description: </div>
            <div class='col-md-3'><textArea name='description' class='form-control w-auto' required>" . $row["Description"] . "</textArea></div>
            </div>
            <div class='row'>
            <div class='col-md-3'>State: </div>
            <div class='col-md-3'>
                <select name='state' class='form-control w-auto' required>";
    if ($row["State"] == "New")
        echo "  <option value='New' selected>New</option>
                <option value='Used'>Used</option>";
    else
        echo "  <option value='New' >New</option>
                <option value='Used' selected>Used</option>";
    echo   "</select>
            </div>
            </div>
            <div class='row'>
            <div class='col-md-3'>Price: </div>
            <div class='col-md-3'><input type='number' name='price' value='" . $row["Price"] . "' class='form-control w-auto' required></div>
            </div>
            <div class='row'>
            <div class='col-md-3'>Discount: </div>
            <div class='col-md-3'><input type='number' name='discount' value='" . $row["Discount"] . "' class='form-control w-auto' required></div>
            </div>
            <div class='row'>
            <div class='col-md-3'>Quantity: </div>
            <div class='col-md-3'><input type='number' name='pieces' value='" . $row["Quantity"] . "' class='form-control w-auto' required></div>
            </div>
            <div class='row'>
            <div class='col-md-3'>Category: </div>
            <div class='col-md-3'>
                <select name='category' class='form-control w-auto' required>
                <option selected value='" . $row["Type"] . "'>" . $row["Type"] . "</option>";
    $sql = $conn->prepare("SELECT * FROM categories WHERE Type <> ?");
    $sql->bind_param('s', $row["Type"]);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $type = $row["Type"];
            echo "<option value='$type'>$type</option>";
        }
        echo "</select>
            </div>
            </div>";
    }
}
