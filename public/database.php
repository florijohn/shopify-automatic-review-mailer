<?php
    require '../config/config.php';
    // get Data with POST method
    $createdAt = $_POST["CreatedAt"];
    $id = $_POST["Id"];
    $isShipping = $_POST["IsShipping"];
    $mail = $_POST["Mail"];
    $totalPrice = $_POST["TotalPrice"];
    $city = $_POST["City"];
    $fullName = $_POST["FirstName"];
    $streetAndNr = $_POST["StreetAndNr"];
    $zip = $_POST["Zip"];

    // create DB Connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO customers (orderID, createdAt, isShipping, mail, totalPrice, city, fullName, street, zip)
    VALUES (\"$id\", \"$createdAt\", $isShipping, \"$mail\", \"$totalPrice\", \"$city\", \"$fullName\", \"$streetAndNr\", \"$zip\")";

    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

?>
