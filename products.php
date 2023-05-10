<?php
include("database/connection.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>

<body>
    <?php
    //Filters
    $query = "SELECT Title, ID, Price, Discount, Quantity FROM products ";
        
    ?>
    <? include("footer.php")?>

</body>

</html>