<?php
require '../config/config.php';
// get Data with POST method
$happy = $_GET["happy"];
$email = $_GET["email"];
if ($happy == "true") {
    header('Location: '.$googleReviewURL);
    die();
} else {
    header('Location: '.$alsFeedbackURL);
    die();
}


?>