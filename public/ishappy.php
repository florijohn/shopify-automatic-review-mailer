<?php
require '../config/config.php';
require_once '../assets/functions.php';
// get Data with POST method
$happy = $_GET["happy"];
$email = $_GET["email"];

updateDBHappy($email, $happy);
if ($happy == 1) {
  $btn = "positiven";
} else {
  $btn = "negativen";
}
$telegramMsg = "Der Empfänger " . $email . " hat auf den " . $btn . " Button gedrückt";
sendTelegramMessage($telegramMsg);

function updateDBHappy($email, $happy) {
    require '../config/config.php';
  $conn = new mysqli($servername, $username, $password, $dbname);
  //$now = date_create()->format('Y-m-d H:i:s');
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "UPDATE customers SET ishappy = \"$happy\" WHERE mail = \"$email\" ";

  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}

if ($happy == 1) {
    header('Location: '.$googleReviewURL);
    die();
} else {
    header('Location: '.$alsFeedbackURL);
    die();
}
?>