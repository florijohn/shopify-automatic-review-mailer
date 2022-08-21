<?php
require '../config/config.php';
require_once '../assets/functions.php';

$happy = $_GET["happy"];
$email = $_GET["email"];

updateDBHappy($email, $happy);
sendTelegramMessage($telegramMsg);

if ($happy == 1) {
  $btn = "positiven";
} else {
  $btn = "negativen";
}

$telegramMsg = "Der Empfänger " . $email . " hat auf den " . $btn . " Button gedrückt";

if ($happy == 1) {
  header('Location: '.$googleReviewURL);
  die();
} else {
  header('Location: '.$alsFeedbackURL);
  die();
}
?>