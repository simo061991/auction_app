<?php include("zaglavlje.html");
include("podnozje.html");
include("baza.php");

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="stilovi.css" media=" screen and (max-width:1400px)" />

    <style media="screen">
      .potvrdaDodavanja{
        width: 100%;
        height: 80%;
        background-color: #F4F5F9;
        visibility: hidden;
      }
      .potvrdaSlika{
        margin-top: 7%;
        margin-left: 43%;
      }
      .potvrdnaPoruka{
        color:grey;
        margin-left: 35%;
      }

    </style>
  </head>
  <body>
    <div class="potvrdaDodavanja">
      <img class="potvrdaSlika" src="slike/potvrda.png" alt="Nedostupna">
      <h1 class="potvrdnaPoruka">Uspješno ste dodali predmet</h1>
    </div>
    <?php
      $bp = povezivanjeBaze();
      session_start();
      if ($_POST['submit']) {
        $aukcija_id =$_POST['predmeti'];
        $putanja= $_POST['url'];
        $korisnik_id= $_SESSION['id'];
        $naziv=$_POST['nazivProizvoda'];
        $opis = $_POST['opisPredmeta'];
        $pocetna_cijena =  $_POST['cijena'];
        $sql="INSERT INTO predmet(predmet_id,aukcija_id,korisnik_id,naziv,opis,slika,pocetna_cijena)
        VALUES (NULL,$aukcija_id,$korisnik_id,'$naziv','$opis','$putanja',$pocetna_cijena);";   
        $rez = izvrsiUpit($bp,$sql);
        if (mysqli_query($bp, $sql)) {
          ?> <style media="screen">
            .potvrdaDodavanja{
              visibility: visible;
            }
            </style>
          <?php
  //  header("Location: generiranjePotvrde.html"); OVO DODATI OBAVEZNO (22.12.2017)
        } else {
            echo "Pogreška: " . $sql . "<br>" . mysqli_error($bp);
          }
      }
    ?>
  </body>
</html>
