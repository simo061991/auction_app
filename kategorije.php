<!DOCTYPE html>
<?php include("zaglavlje.php");
include("baza.php");
?>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="stilovi.css" media=" screen and (max-width:1400px)" />
    <title></title>
  </head>
  <body>
    <?php
      if (isset($_SESSION['tipKorisnika'])) {
        if ($_SESSION["tipKorisnika"]==0 || $_SESSION["tipKorisnika"]==1 || $_SESSION["tipKorisnika"]==2) {
    ?>
          <script type="text/javascript">
          document.getElementById("txtPrijava").innerHTML = "Odjava";
          </script>
            
            <a href="dodavanjePredmeta.php"> <button style="margin-left:40%; width:20%;margin-top:1%;height:5%;" type="button" name="gumbPredmeti">Dodaj novi predmet</button> </a>
          <?php
          
        }
      }
          $bp = povezivanjeBaze();
          $trenutnoVrijeme =   $datumIvrijeme =date("Y-m-d H:i:s");
          $sql = "SELECT naziv,opis,datum_vrijeme_zavrsetka,aukcija_id FROM aukcija WHERE datum_vrijeme_zavrsetka >'$trenutnoVrijeme'  ORDER BY datum_vrijeme_zavrsetka DESC";
          $sqlModerator = "SELECT naziv,opis,datum_vrijeme_zavrsetka,aukcija_id,moderator_id FROM aukcija WHERE datum_vrijeme_zavrsetka >'$trenutnoVrijeme' ORDER BY datum_vrijeme_pocetka ASC";
          $rez = izvrsiUpit($bp,$sql);
          $rezModerator = izvrsiUpit($bp,$sqlModerator);
          echo "<table><tr>";
          $i = 0;
//provjera da li je trenutni korisnik moderator.
          @$trenutniKorisnik=$_SESSION['id'];
          $sqlProvjeraModeratora = "SELECT * FROM aukcija Where moderator_id='$trenutniKorisnik'";
          $rezProvjera = izvrsiUpit($bp,$sqlProvjeraModeratora);
          if (isset($_SESSION['tipKorisnika'])) {
            if(mysqli_num_rows($rezProvjera) > 0 || $trenutniKorisnik == 0){
              ispisKategorija($rezModerator);
            }
            else {
              ispisKategorija($rez);
            }
          } 
        else {
          ispisKategorija($rez);
        }
        function ispisKategorija($rez){
          $bp = povezivanjeBaze();
          $i=0;
          if (mysqli_num_rows($rez) > 0) {
            while($row = mysqli_fetch_assoc($rez)) {
                  $i++;
                  $idAukcije = $row["aukcija_id"];
                  $upit="SELECT naziv FROM predmet WHERE aukcija_id = '$idAukcije'";
                  $rez2=izvrsiUpit($bp,$upit);
                  $brojPredmeta = mysqli_num_rows($rez2);
                  //IF ISSET - ZBOG ANONIMNOG KORISNIKA JER ONDA JAVLJA GREŠKU $_SESSION tipKorisnika undefined
                  if (isset($_SESSION['tipKorisnika'])) {
                    if($_SESSION["tipKorisnika"]==1){           
                    }
                  }
                  ?>
                      <div class="blokKategorija">
                      <form action="noviIzgledAukcije.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $idAukcije ?>">
                        <td id="tablicaKategorije"><button id ="gumbKategorija" type = "submit"><?php echo '<h1 id="naslovKategorije">'.$row['naziv'].'</h1>'."<br> "
                      .'<h3 id="opisKategorije">'. $row['opis'].'</h3>'."<br> ".'<h2 id="datumKategorije">'. $row['datum_vrijeme_zavrsetka'].'</h3>'."<br> ".'<h3 id="brojPredmeta">'."Ukupno predmeta :" .$brojPredmeta.'</h3>'; ?></button>
                      </form>


                  <?php

                  if (isset($_SESSION['tipKorisnika'] )) {
                    if ($_SESSION["id"] == @$row["moderator_id"] || $_SESSION['tipKorisnika'] == 0){
                  ?>
                      <form class="" action="kategorije.php" method="post">
                        <input style="width:41%;float:left;" type="text" name="noviDatum" value="" placeholder="Ažurirajte datum" required>
                        <input style="width:41%;float:right;" type="text" name="novoVrijeme" value="" placeholder="Ažurirajte vrijeme" required>
                        <input style="margin-top: 5px;width:53%;margin-left:22%;border-radius:4px;padding:3px;" type="submit" name="azuriranjeAukcije" value="Ažurirajte aukciju">
                        <input type="hidden" name="aukcijaID" value=<?php echo $idAukcije ?>>
                        <input type="hidden" name="datumZavrsetka" value=<?php echo $row["datum_vrijeme_zavrsetka"] ?>>
                      </form>
                      <form class="" action="kategorije.php" method="post">
                        <input style="background-color:red;margin-top: 5px;width:53%;margin-left:22%;border-radius:4px;padding:3px;" type="submit" name="zatvaranjeAukcije" value="Zatvori aukciju">
                        <input type="hidden" name="idZatvaranja" value=<?php echo $idAukcije ?>>
                      </form>
                    <?php
                    }
                  }
                ?>
                  </td>
                  </div>
                  <?php
                  if ($i % 3 == 0) {
                    echo "</tr><tr>";
                  }
          }
  }
}
echo '</table>';
function validateDate($noviDatum, $format = 'd.m.Y H:i:s')
{
    $d = DateTime::createFromFormat($format, $noviDatum);
    return $d && $d->format($format) == $noviDatum;
}
global $idAukcije;

if (isset($_POST['azuriranjeAukcije'])) {

  $idAukcije = $_POST["aukcijaID"];
  $noviDatum = $_POST['noviDatum'];
  $novoVrijeme = $_POST['novoVrijeme'];
  //$noviDatum = $_POST['noviDatum']." ".$_POST['novoVrijeme'];
  formatiranjeDatuma($noviDatum,$novoVrijeme,$idAukcije);
}
  //Mičemo sve razmake iz stringova i pretvaramo dmy u Ymd
  //$noviDatum = $noviDatum->format('Y.m.d');
  function formatiranjeDatuma ($noviDatum,$novoVrijeme,$idAukcije){
    $bp=povezivanjeBaze();
    $noviDatum = preg_replace('/\s+/', '', $noviDatum);
    $novoVrijeme = preg_replace('/\s+/', '', $novoVrijeme);
  //nakon micanja razmaka spajamo dva stringa sa samo razmakom izmedu
    echo '<br>';
    $datumIvrijeme =$noviDatum." ".$novoVrijeme;
    if(validateDate($datumIvrijeme)){
      echo '<br>';
      $noviDatum = date ("Y.m.d", strtotime($noviDatum));
      $datumIvrijeme =$noviDatum." ".$novoVrijeme;
      $sqlPromjenaVremena="UPDATE aukcija SET datum_vrijeme_zavrsetka='$datumIvrijeme' WHERE aukcija_id='$idAukcije'";
      $rez = izvrsiUpit($bp,$sqlPromjenaVremena);
      if($rez){
      //window.location zato sto header neće.
        echo "<script> window.location = 'generiranjePotvrde.php' </script>";

      }
  }
  else {
  $poruka = "Pogrešan unos. Molimo unesite vrijeme u formatu Godina.mjesec.dan Sat:minute:sekunde";
  echo "<script type='text/javascript'>alert('$poruka');</script>";
  }
}
if (isset($_POST["zatvaranjeAukcije"])) {
  $datumIvrijeme =date("Y-m-d H:i:s");
  @$idAukcije= $_POST['idZatvaranja'];
  $sqlZatvaranje="UPDATE aukcija SET datum_vrijeme_zavrsetka='$datumIvrijeme' WHERE aukcija_id='$idAukcije'";
  $rez = izvrsiUpit($bp,$sqlZatvaranje);
  if($rez){
  //window.location zato sto header neće.
    echo "<script> window.location = 'generiranjePotvrde.php' </script>";
  } 
  else {
    $poruka = "Dogodila se pogreška";
    echo "<script type='text/javascript'>alert('$poruka');</script>";
  }
}
          ?>
          <?php
            include 'podnozje.html';
           ?>
    <style>
      .podnozje{
        top:90%;
      }
    </style>
  </body>
</html>
