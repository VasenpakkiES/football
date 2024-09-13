<?php
include 'debuggeri.php';

$palvelin = "localhost";
$kayttaja = "root";  // tämä on tietokannan käyttäjä, ei tekemäsi järjestelmän
$salasana = "Esiljand6776?!";
$tietokanta = "mysql";
register_shutdown_function('debuggeri_shutdown');

   
// luo yhteys
$yhteys = new mysqli($palvelin, $kayttaja, $salasana, $tietokanta);

// jos yhteyden muodostaminen ei onnistunut, keskeytä
if ($yhteys->connect_error) {
   die("Yhteyden muodostaminen epäonnistui: " . $yhteys->connect_error);
}
// aseta merkistökoodaus (muuten ääkköset sekoavat)
$yhteys->set_charset("utf8");
echo "Yhteys muodostettu onnistuneesti!";

$query = "SELECT * FROM henkilo";
$result = $yhteys->query($query);
// jos tulosrivejä löytyi
if ($result->num_rows > 0) {
   // hae joka silmukan kierroksella uusi rivi
   while($row = $result->fetch_assoc()) {
      // taulukon avaimet (hakasuluissa olevat nimet) ovat TIETOKANNAN KENTTIÄ (sarakkeita)
      foreach ($row as $key => $value) {
         debuggeri($row);
         echo "$key: $value<br>";
         }
   }
} else {
   echo "Ei tuloksia";
}
$query = "INSERT INTO henkilo (hetu, nimi, osoite, puhelinnumero) VALUES ('111188-143A', 'Eero Jokerimies', 'Kantelettarentie 1', '09876543210');";
$result = $yhteys->query($query);
if ($result === TRUE) {
   echo "Henkilö lisätty.";
   } 
else {
   echo "Virhe: " . $query . "<br>" . $conn->error;
   }
   
$query = "INSERT INTO auto (rekisterinro, vari, vuosimalli, omistaja) VALUES ('JOK-111', 'punakeltainen', 2011, '111188-143A')";
$result = $yhteys->query($query);
if ($result === TRUE) {
   echo "Auto lisätty.";
   } 
else {
   echo "Virhe: " . $query . "<br>" . $conn->error;
   }

   $query = "INSERT INTO sakko (id, auto, henkilo, pvm, summa, syy) VALUES (7, 'JOK-111', '111188-143A', '2024-09-12', 100, 'punaisia päin ajo')";
$result = $yhteys->query($query);
if ($result === TRUE) {
   echo "Sakko lisätty.";
   } 
else {
   echo "Virhe: " . $query . "<br>" . $conn->error;
   }
   ?>
