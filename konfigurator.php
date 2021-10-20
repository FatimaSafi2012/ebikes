<?php
include("includes/db.php");
require("includes/config.inc.php");
if (count($_POST)>0) {
  te($_POST);
  $ramentyp=$_POST['rahmentyp'];
  $farben=$_POST['farben'];
  $motor=$_POST['motor'];
  $brems=$_POST['brems'];
  $beleuchtung=$_POST['beleuchtung'];

  $nachname=$_POST['nachname'];
  $vorname=$_POST['vorname'];
  $email=$_POST['email'];
  $tel=$_POST['tel'];
  $adresse=$_POST['adresse'];
  $plz=$_POST['plz'];
  $ort=$_POST['ort'];
  $staat=$_POST['staat'];
  $geb=$_POST['geb'];

  $sql = "
  SELECT * FROM tbl_kunden
  WHERE(
    Nachname='". $conn->real_escape_string ($nachname)."' AND  Vorname = '". $conn->real_escape_string ($vorname)."' AND Emailadresse= '". $conn->real_escape_string ($email)."'
    )
  ";
  $idkunde=0;
  te($sql);
$kunden = $conn->query($sql) or die("Fehler in der Quray:" . $conn->error);

if ($kunden->num_rows==1) {
  // kunde ist bereit existirt
  $kunde = $kunden->fetch_assoc();
  te($kunde);
    $idkunde=$kunde['IDKunde'];
  }else {

    $sql = "
    INSERT INTO tbl_kunden (Nachname, Vorname, GebDatum,Adresse,PLZ,Ort,FIDStaat,Emailadresse,Telefon)
VALUES (
  '". $conn->real_escape_string ($nachname) ."',
   '".$conn->real_escape_string ($vorname)."',
    '".$conn->real_escape_string ($geb)."',
      '".$conn->real_escape_string ($adresse)."',
      '".$conn->real_escape_string ($plz)."',
      '".$conn->real_escape_string ($ort)."',
      '".$conn->real_escape_string ($staat)."',
      '".$conn->real_escape_string ($email)."',
      '".$conn->real_escape_string ($tel)."'
    )";

if ($conn->query($sql) === TRUE) {
  // user in tbl_kunden gespeichrt
  $idKunde=$conn->insert_id;


} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

  }
  if ($idkunde =! 0) {
     $sql = "
      INSERT INTO tbl_bestellungen (FIDKunde ,FIDRahmentyp , FIDFarbe ,FIDMotor,FIDBremse ,FIDBeleuchtung)
      VALUES (
     '". $idkunde ."',
        '". $ramentyp ."',
        '". $farben ."',
          '". $motor ."',
            '". $brems ."',
              '". $beleuchtung ."'
          )";

      if ($conn->query($sql) === TRUE) {
        te($sql);
        echo "<p>Vielen Dank, Ihre Bestellung non wird verarbeitet</p>";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }


  }


}

 ?>
 <!DOCTYPE html>
 <html lang="de">
   <head>
     <meta charset="utf-8">
     <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
     <title></title>
       </head>
   <body>
     <header>
       <nav>
         <ul>
           <li> <a href="index.php">Home</a></li>
            <li> <a href="konfigurator.php">Konfigurator</a></li>
            <li> <a href="bestelluebesicht.php">Bestellübersicht</a></li>
         </ul>
       </nav>
     </header>
     <div class="center">
        <form class="" method="post">
          <div class="mb-3">
          <label for="rahmentyp" class="form-label">bitte wählen Sie eine Rahmentyp: </label><?php echo rahmentypen(); ?></div>
        <div class="mb-3">
        <label for="farben" class="form-label">bitte wählen Sie eine Farbe: </label><?php echo farben(); ?></div>
      <div class="mb-3">
      <label for="motor" class="form-label">bitte wählen Sie eine Motor: </label><?php echo  motoren(); ?></div>
    <div class="mb-3">
    <label for="brems" class="form-label">bitte wählen Sie eine Bremssystem: </label><?php echo bremsen(); ?></div>
  <div class="mb-3">
  <label for="beleuchtung" class="form-label">bitte wählen Sie eine Beleuchtung: </label><?php echo beleuchtungen(); ?></div>
<div class="mb-3">
<input type="submit"  class="form-control"  onclick="document.getElementById('example').style.visibility = 'visible'; return false;" value="Bestellen">
</div>

<div  style="visibility: hidden;" id="example" >

<legend>Ihre Daten</legend>
<div class="mb-3">
  <label for="nachname" class="form-label">Nachname:</label>
  <input type="text" class="form-control" id="nachname" name="nachname" >
</div>
<div class="mb-3">
  <label for="vorname" class="form-label">Vorname:</label>
  <input type="text" class="form-control" id="vorname" name="vorname" >
</div>
<div class="mb-3">
  <label for="email" class="form-label">Email:</label>
  <input type="email" class="form-control" id="email" name="email" >
</div>
<div class="mb-3">
  <label for="tel" class="form-label">Telefon:</label>
  <input type="number" class="form-control" id="tel" name="tel" >
</div>
<div class="mb-3">
  <label for="adresse" class="form-label">Adresse:</label>
  <input type="text" class="form-control" id="adresse" name="adresse" >
</div>
<div class="mb-3">
  <label for="plz" class="form-label">PLZ:</label>
  <input type="number" class="form-control" id="plz" name="plz" >
</div>
<div class="mb-3">
  <label for="ort" class="form-label">Ort:</label>
  <input type="text" class="form-control" id="ort" name="ort" >
</div>
<div class="mb-3">
  <label for="staat" class="form-label">Staat:</label><?php echo staaten(); ?></div>
<div class="mb-3">
  <label for="geb" class="form-label">GebDatum:</label>
  <input type="date" class="form-control" id="geb" name="geb" >
</div>
<div class="mb-3">

  <input type="submit" class="form-control" value="Bestellung abschiecken" >
</div>

</div>
</form>
</div>

<?php

 ?>
   </body>
 </html>
