<?php
include("includes/db.php");
require("includes/config.inc.php");
if (count($_POST)>0) {
  $beginn=$_POST['von'];
  $ende=$_POST['bis'];
  $motor=$_POST['motor'];
  $rahmentype=$_POST['rahmentyp'];
  te($_POST);
  $sql="
  SELECT tbl_bestellungen.*,tbl_motoren.IDMotor,tbl_motoren.Bezeichnung AS BzMotor,tbl_farben.IDFarbe ,tbl_farben.Bezeichnung AS BZfarbe,tbl_bremsen.IDBremse,tbl_bremsen.Bezeichnung AS BZbremsen, tbl_beleuchtungen.IDBeleuchtung ,tbl_beleuchtungen.Bezeichnung AS BzBeluchtung,tbl_rahmentypen.IDRahmentyp ,tbl_rahmentypen.Bezeichnung AS BZRahmen,tbl_rahmentypen.Preis AS rahmenPreis FROM tbl_bestellungen
  INNER JOIN tbl_motoren ON tbl_bestellungen.FIDMotor= tbl_motoren.IDMotor
  INNER JOIN tbl_farben ON tbl_bestellungen.FIDFarbe= tbl_farben.IDFarbe
  INNER JOIN tbl_bremsen ON tbl_bestellungen.FIDBremse = tbl_bremsen.IDBremse
  INNER JOIN tbl_beleuchtungen ON tbl_bestellungen.FIDBeleuchtung = tbl_beleuchtungen.IDBeleuchtung
  INNER JOIN tbl_rahmentypen ON tbl_bestellungen.FIDRahmentyp= tbl_rahmentypen.IDRahmentyp
  WHERE(
    tbl_bestellungen.DatumBestellung BETWEEN '$beginn' AND '$ende'  AND
    tbl_bestellungen.FIDMotor=". $motor ."  AND   tbl_bestellungen.FIDRahmentyp = ". $rahmentype . "
    )
  ";

  echo "<ul>";
  $result = $conn->query($sql)or die("fehler in der Query:" . $conn->error);
  //te($sql);
  if ($result->num_rows > 0) {
      te($result);
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo '
    <li>DatumBestellung: '. $row['DatumBestellung'] .'</li>
    <li> rahmenPreis: '. $row['rahmenPreis'] .'</li>
    <li>Rahmentyp: : '. $row['BZRahmen'] .'</li>
    <li>Farbe: '. $row['BZfarbe'] .'</li>
    <li>Motror: '. $row['BzMotor'] .'</li>
    <li>Motror: '. $row['BZbremsen'] .'</li>
  <li>Motror: '. $row['BzBeluchtung'] .'</li><br>
    ';
  }
}
}

 ?>
 <!DOCTYPE html>
 <html lang="de">
   <head>
     <meta charset="utf-8">
     <link rel="stylesheet" href="css/style.css">
     <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

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
  <label for="von" class="form-label">von:</label>
  <input type="date" class="form-control" id="von" name="von">
</div>
<div class="mb-3">
  <label for="bis" class="form-label">Bis:</label>
  <input type="date" class="form-control" id="bis"  name="bis" >
</div>
<div class="mb-3">
  <label for="bis" class="form-label">Motorleistungen:</label>
  <?php echo motoren(); ?>
</div>
<div class="mb-3">
  <label for="bis" class="form-label">Rahmentypen:</label>
  <?php echo rahmentypen(); ?>
</div>
<div class="mb-3">

  <input type="submit" class="form-control" value="filtern">
</div>

</form>
 </div>
   </body>
 </html>
