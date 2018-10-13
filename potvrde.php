<?php include("zaglavlje.php");
include("baza.php");
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
<?php


$bp = povezivanjeBaze();
if ($_POST['gumbPot']) {

$predmetID =$_POST['predmetID'];


 $korisnik_id= $_SESSION['id'];

 $ponudaCijena=$_POST['ponuda'];

$vrijemeUnosa = date('Y-m-d H:i:s');


$sql="INSERT INTO ponuda(ponuda_id,predmet_id,korisnik_id,datum_vrijeme_ponude,iznos_ponude)
VALUES (NULL,$predmetID,$korisnik_id,'$vrijemeUnosa',$ponudaCijena);";

$rez = izvrsiUpit($bp,$sql);
if ($rez) {
  header("Location: generiranjePotvrde.php");

}
else {
  echo "Došlo je do pogreške";
}
/*
if (mysqli_query($bp, $sql)) {
  header("Location: generiranjePotvrde.php");
}
else {
  //  echo "Pogreška: " . $sql . "<br>";// mysqli_error($bp)
}
*/
}
/*
      if ($_GET['gumbPot']) {
        if ($_GET['ponuda'] > $_GET['maks']) {
          echo "veće" . " ".$_GET['maks']. " ". $_GET['ponuda']. " ". $_GET['predmetID'];
        }

    else {
      echo "Manje" . " ".$_GET['maks']. " ". $_GET['ponuda'];
    }
}
*/


    ?>
  </body>
</html>
