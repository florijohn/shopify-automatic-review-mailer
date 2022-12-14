<?php
require_once '../config/config.php';
require_once '../assets/functions.php';

// create DB Connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT fullName AS kunde, COUNT(mail) AS Anzahl, mail AS EMail, ishappy, lastMailSent FROM customers GROUP BY mail HAVING (COUNT(mail) > 1)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $emails[] = $row["EMail"];
    $isHappy[] = $row["ishappy"];
    $lastMailSent[] = $row["lastMailSent"];
  }
} else {
  echo "0 results";
}

for($i = 0; $i < count($emails); $i++) {
  $telegramMsg = "An " . $emails[$i] . " wurde eine Email gesendet";
  if(($isHappy[$i] === 0 && $lastMailSent[$i] < date("Y-m-d", strtotime("-30 days"))) || $lastMailSent[$i] === NULL) {
    sendEmail($emails[$i]);
    sendTelegramMessage($telegramMsg);
    updateDB($emails[$i]);
    echo "Mail gesendet an " . $emails[$i] . "<br>";
  } else {
    echo "Keine Mail gesendet für " . $emails[$i] . "<br>";
  }
}

$conn->close();
?>