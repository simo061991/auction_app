
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
    <div class="blokUnosaPredmeta">
      <h1 style="margin-left:35%">Dodavanje nove aukcije</h1>
      <hr id="crta">
      <form id="formaPredmeta"  action="dodavanjeAukcije.php" method="POST">
        <h4 style="margin-left:15%">Odaberite moderatora*</h4>
        <select id="padajuciZaPredmete" name="moderatori" required>
      <?php
        session_start();
        $bp = povezivanjeBaze();
        $sql= "SELECT korisnik_id,korisnicko_ime FROM korisnik WHERE tip_id = 1";
        $rez = izvrsiUpit($bp,$sql);
        if (mysqli_num_rows($rez) > 0) {
          while($row = mysqli_fetch_assoc($rez)) {
              //prenosimo naziv aukcije a dohvaćamo ID sa POST
            echo '<option value='.$row['korisnik_id'].'>'.$row['korisnicko_ime'].'</option>';
            }
          }
      ?>
        </select>
        <h4 style="position:absolute;top:0;left:63%">Naziv aukcije*</h4>
        <input type="text" name="nazivProizvoda" placeholder="Naziv aukcije" id="nazivProizvoda" required> <br>
        <h4 style="margin-left:45%">Kratak opis*</h4>
        <textarea rows="5" cols="50" id="opisProizvoda" name="opisPredmeta"required ></textarea>
        <br>
        <label style="margin-left:40%;font-weight:bold;"for="vrijemePocetka">Datum i vrijeme početka*</label>
        <br>
        <input style="width:40%;height:5%;margin-left:30%;" type="text" name="vrijemePocetka" id="vrijemePocetka" placeholder="dd.mm.gggg" required>
        <br>
        <label style="margin-left:40%;font-weight:bold;" for="datumZavrsetka">Datum i vrijeme završetka*</label>
        <br>
        <input style="width:40%;height:5%;margin-left:30%;" type="text" name="vrijemeZavrsetka" value="" id="vrijemeZavrsetka" placeholder="dd.mm.gggg" required>
        <br>
        <p style="color:  #999999;margin-left:33%;">Polja označena sa (*) su obavezna za unos</p>
        <input type="submit" name="potvrdaAukcije" value="Dodaj" id="potvrdiPredmet" style="border-radius:10px;font-weight:bold" >
      </form>
    </div>
    <?php
    function validateDate($noviDatum, $format = 'd.m.Y H:i:s'){
      $d = DateTime::createFromFormat($format, $noviDatum);
      return $d && $d->format($format) == $noviDatum;
    }
    function validateDateDva($noviDatumZavrsetka, $format = 'd.m.Y H:i:s'){
      $d = DateTime::createFromFormat($format, $noviDatumZavrsetka);
      return $d && $d->format($format) == $noviDatumZavrsetka;
    } 
    function formatiranjeDatuma ($noviDatum ,$noviDatumZavrsetka/*,$novoVrijeme,$idAukcije*/,$moderator,$nazivAukcije,$opis){
      $bp=povezivanjeBaze();
  //nakon micanja razmaka spajamo dva stringa sa samo razmakom izmedu
      echo '<br>';
      if(validateDate($noviDatum) && validateDateDva($noviDatumZavrsetka)){
        echo '<br>';
        $noviDatum = date ("Y.m.d H:i:s", strtotime($noviDatum));
        $noviDatumZavrsetka = date ("Y.m.d H:i:s", strtotime($noviDatumZavrsetka));
        $sql="INSERT INTO aukcija(aukcija_id,moderator_id,naziv,opis,datum_vrijeme_pocetka,datum_vrijeme_zavrsetka)
        VALUES (NULL,$moderator,'$nazivAukcije','$opis','$noviDatum','$noviDatumZavrsetka');";
        $rez = izvrsiUpit($bp,$sql);
        if($rez){
      //window.location zato sto header neće.
          echo "<script> window.location = 'generiranjePotvrde.php' </script>";
        }
      }
      else {
        $poruka = "Pogrešan unos. Molimo unesite vrijeme u formatu dan.mjesec.godina Sat:minute:sekunde";
        echo "<script type='text/javascript'>alert('$poruka');</script>";
      }
  }

  if (ISSET($_POST['potvrdaAukcije'])) {
    $bp = povezivanjeBaze();
    $moderator = $_POST['moderatori'];
    $nazivAukcije =$_POST['nazivProizvoda'];
    $opis =$_POST['opisPredmeta'];
    $vrijemePocetka = $_POST['vrijemePocetka'];
    $vrijemeZavrsetka = $_POST['vrijemeZavrsetka'];
    formatiranjeDatuma($vrijemePocetka,$vrijemeZavrsetka,$moderator,$nazivAukcije,$opis);
  }
 ?>
  <?php include("podnozje.html"); ?>
    <style media="screen">
      .podnozje{
        top:90%;
      }
    </style>
  </body>
</html>
