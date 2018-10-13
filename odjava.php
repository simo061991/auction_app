<?php
include("zaglavlje.php");

 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>

<?php
  unset($_SESSION["id"]);
  unset($_SESSION["tipKorisnika"]);
  unset($_SESSION["korisnickoIme"]);
  unset ($_SESSION["imeKorisnika"]);
  unset ($_SESSION["prezimeKorisnika"]);
  header("Location: generiranjePotvrde.php");
 ?>
   </body>
 </html>
