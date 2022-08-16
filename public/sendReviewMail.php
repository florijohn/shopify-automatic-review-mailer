<?php
require_once '../config/config.php';
require_once '../assets/functions.php';
// TODO Daten aus DB Abfragen
/*
    Done Daten aus DB Abfragen
    Done doppelte Einträge zählen
    done emails bei denen doppelte Einträge gezählt werden in Mail array schreiben
    Mail array durchlaufen und functiion sendMail mit Email und Template aufrufen
    function sendmail umbauen auf Übergabeparameter: Email, Template
    bei Bestellungen = 2 senden einer email
    Cronjob einrichten


    SQL Abfrage

    Alle Mails bei denen die Bestellungen 2 sind

    SELECT fullName AS kunde, COUNT(mail) AS Anzahl, mail AS EMail FROM customers GROUP BY mail HAVING (COUNT(mail) > 1);


    TODO Datum Anfragen und Mail nur schicken wenn letzte Mail 30 Tage her ist und Bedingung erfüllt ist

    Bedingung: isHappy = 0
    lastSent: 30 Tage her
*/


// create DB Connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT fullName AS kunde, COUNT(mail) AS Anzahl, mail AS EMail FROM customers GROUP BY mail HAVING (COUNT(mail) > 1)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $emails[] = $row["EMail"];
  }
} else {
  echo "0 results";
}

for($i = 0; $i < count($emails); $i++) {
  sendEmail($emails[$i]);
  updateDB($emails[$i]);
}

$conn->close();
?>