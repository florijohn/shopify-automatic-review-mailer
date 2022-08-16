<?php
require '../config/config.php';
// get Data with POST method
$happy = $_GET["happy"];
$email = $_GET["email"];

updateDBHappy($email, $happy);

function updateDBHappy($email, $happy) {
    require '../config/config.php';
  $conn = new mysqli($servername, $username, $password, $dbname);
  $now = date_create()->format('Y-m-d H:i:s');
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