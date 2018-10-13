<?php include("zaglavlje.php");
include("baza.php");
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title></title>
     <link rel="stylesheet" href="stilovi.css" media=" screen and (max-width:1400px)" />

     <style media="screen">
       #naslovStranice{
         font-family: Noto Sans, sans-serif;
         position: absolute;
         margin-top: 5.5%;
         margin-left: 5%;

       }
       .slika{
         height: 50%;
         width:25%;
         margin-left: 5%;
         border: 1px solid grey;
       }
       .korisničkeInformacije{
         position: absolute;
         top: 35%;
         width: 50%;
         height: 50%;
         margin-left: 36%;
         background-color: white;
       }
       .unosi{
         margin-left: 25%;
         display: block;
         margin-top: -15px;
         text-indent: 0px;

       }
       .oznakeUnosa{
        margin-left: 1%;
        margin-top: 10%;
        font-family: Helvetica;
        font-size: 15px;
        text-decoration: underline;
        font-weight: bold;

       }
       .unosiSelect{


       }
       #azuriranjeKorisnika{
         margin-left: 10%;
         padding: 10px;
         border-radius: 5px;
       }
       .noviKorisnik{
         margin-left: 35%;
       }
       .statistika{
         position: absolute;
         background-color: #B3B3B3;
         top:0%;
         left: 100%;
         margin-left: 10%;
         width: 55%;
         height: 100%;
       }
       table{
         width: 100%;
         border-collapse: collapse;
       }
         th{
           width: 5%;
           border: 1px solid #EBEBEB;
           height: 20px;
           color: #929292;
         }
         td{
           text-align: center;
           border: 1px solid #ddd;
         }
    th{
            background-color: #30B6CC;
            color: white;
            font-weight: bold;
          }

     </style>
   </head>
   <body>
    <h3 id="naslovStranice">Uređivanje korisnika</h3>
    <hr style="margin:5%;width:90%; height:2px;background-color:#30B6CC;margin-top:7%;">
    <?php
      $moderatorDefault = "";
      if (isset($_POST['uredivanjeKorisnika'])) {
        @$id=$_POST['identifikacijaKorisnika'];
    ?>
        <div class="slika">
          <img style="width:90% ; height:90%;"src=<?php echo @$_POST['slika']; ?> alt="Nedostupna slika">
        </div>
        <div class="korisničkeInformacije">
          <form class="" action="adminKorisnici.php" method="post"> 
          <br>
            <label class="oznakeUnosa" for="kor_ime"> KORISNIČKO IME</label>
            <input class="unosi" id="k_ime" type="text" name="korisnickoIme" value=<?php echo @$_POST['kor_ime']; ?>>
            <br>
            <label class="oznakeUnosa" for="imeKorisnika"> IME</label>
            <input class="unosi" id="imeKorisnika" type="text" name="ime" value=<?php echo @$_POST['ime']; ?>>
            <br>
            <label class="oznakeUnosa" for="prezime"> PREZIME </label>
            <input class="unosi" id="prezime" type="text" name="prezime" value=<?php echo @$_POST['prezime']; ?>>
            <br>
          	<label class="oznakeUnosa" for="mail"> E-MAIL </label>
            <input class="unosi" id="mail" type="text" name="mail" value=<?php echo @$_POST['email']; ?>>
            <br>
            <label class="oznakeUnosa" for="slika"> SLIKA </label>
            <input class="unosi" id="slika" type="text" name="slika" value=<?php echo @$_POST['slika']; ?>>
            <br>
         <!-- ako je postavljena dodjeljenaAukcija onda prikazujemo ovaj input, to jest ako je u pitanju moderator, ovo ILI je zbog tog da u početnom popisu korisnika prepozna moderatora -->
         <?php
          if (isset($_POST['dodjeljenaAukcija'])|| @$_POST['tip']==1 ) {
            echo '<label class="oznakeUnosa" for="aukcije"> MODERATOR </label>';
            echo'<select class="unosi" name="aukcije">';
            echo '<option disabled selected value> -- Odaberite aukciju -- </option>';
            $bp = povezivanjeBaze();
            $sql= "SELECT naziv,aukcija_id FROM aukcija";
            $rez = izvrsiUpit($bp,$sql);
            if (mysqli_num_rows($rez) > 0) {
              while($row = mysqli_fetch_assoc($rez)) {
                echo '<option value='.$row['aukcija_id'].'>'.$row['naziv'].'</option>';
              }
            }
          ?>
                </select>
    <?php } ?>
            <br>
      <input id="azuriranjeKorisnika" type="submit" name="azuriranje" value="Unesite promjene">
      </form>
      </div>
    <?php
    }

    //NOVI KORISNIK!
    if (isset($_POST['noviKorisnik'])) {
    ?>
      <div class="noviKorisnik">
       <form class="" action="adminKorisnici.php" method="post">
         <label class="oznakeUnosa" for="kor_ime"> TIP KORISNIKA</label>
         <select class="unosi" name="tipKorisnika" required>
           <option disabled selected value> -- Tip korisnika -- </option>
           <option value="0">Administrator</option>
           <option value="1">Moderator</option>
           <option value="2">Korisnik</option>
         </select>
         <br>
         <label class="oznakeUnosa" for="kor_ime"> KORISNIČKO IME</label>
         <input class="unosi" id="k_ime" type="text" name="korisnickoIme" value="">
         <br>
         <label class="oznakeUnosa" for="lozinka"> LOZINKA</label>
         <input class="unosi" id="" type="password" name="lozinka" value="">
         <br>
         <label class="oznakeUnosa" for="imeKorisnika"> IME</label>
         <input class="unosi" id="imeKorisnika" type="text" name="ime" value="">
         <br>
         <label class="oznakeUnosa" for="prezime"> PREZIME </label>
         <input class="unosi" id="prezime" type="text" name="prezime" value="">
         <br>
         <label class="oznakeUnosa" for="mail"> E-MAIL </label>
         <input class="unosi" id="mail" type="text" name="mail" value="">
         <br>
         <label class="oznakeUnosa" for="slika"> SLIKA </label>
         <input class="unosi" id="slika" type="text" name="slika" value="">
         <br>
         <input id="azuriranjeKorisnika" type="submit" name="dodavanje" value="Unesite korisnika">
      </form>
    </div>
  <?php
    }
    if(isset($_POST['dodavanje'])){
      $bp = povezivanjeBaze();
      $tip =$_POST['tipKorisnika'];
      $kor_ime =$_POST['korisnickoIme'];
      $lozinka=$_POST['lozinka'];
      $imeKorisnika = $_POST['ime'];
      $prezime= $_POST['prezime'];
      $mail= $_POST['mail'];
      $slika = $_POST['slika'];
      $sql="INSERT INTO korisnik(korisnik_id,tip_id,korisnicko_ime,lozinka,ime,prezime,email,slika)
        VALUES (NULL,$tip, '$kor_ime','$lozinka','$imeKorisnika','$prezime','$mail','$slika');";
      $rez= izvrsiUpit($bp,$sql);
      if($rez){
      //window.location zato sto header neće.
        echo "<script> window.location = 'generiranjePotvrde.php' </script>";
      }
    }
  if (isset($_POST['azuriranje'])) {
      $id  = $_POST['identifikator'];
      $korisnickoIme  = $_POST['korisnickoIme'];
      $ime  = $_POST['ime'];
      $prezime  = $_POST['prezime'];
      $mail =$_POST['mail'];
      $slika = $_POST['slika'];
//provjera da li su postavljene aukcije
    if (isset($_POST['aukcije'])) {
      $aukcije = $_POST['aukcije'];
      $bp=povezivanjeBaze();
      $sqlUpdateModeratora="UPDATE korisnik,aukcija SET korisnik.korisnicko_ime='$korisnickoIme',korisnik.ime='$ime',korisnik.prezime='$prezime',korisnik.email='$mail',korisnik.slika='$slika',
      aukcija.moderator_id = '$id' WHERE korisnik.korisnik_id='$id' AND aukcija.aukcija_id ='$aukcije'";
      $rez = izvrsiUpit($bp,$sqlUpdateModeratora);
      if($rez){
          //window.location zato sto header neće.
        echo "<script> window.location = 'generiranjePotvrde.php' </script>";

      }
    }
    else {
      $bp=povezivanjeBaze();
      $sqlUpdateKorisnika= "UPDATE korisnik SET korisnicko_ime='$korisnickoIme',ime = '$ime', prezime='$prezime',
      email='$mail',slika ='$slika' WHERE korisnik_id = '$id'";
      $rez = izvrsiUpit($bp,$sqlUpdateKorisnika);
      if($rez){
      //window.location zato sto header neće.
        echo "<script> window.location = 'generiranjePotvrde.php' </script>";
      }
    }
  }
     //ažuriranje aukcije
     if (isset($_POST['uredivanjeAukcije'])) {
       //mjenjamo naslov uredivanje korisnika u uredivanje aukcijeOdabir
      $datumIvrijeme =date("Y-m-d H:i:s");
      $aukcija_id=$_POST['identifikacijaAukcije'];
      $bp=povezivanjeBaze();
      
      $sql="SELECT * FROM aukcija WHERE aukcija_id='$aukcija_id'";
      $rez = izvrsiUpit($bp,$sql);
    ?>
      <script type="text/javascript">
        document.getElementById("naslovStranice").innerHTML="Uređivanje aukcije";
      </script>
    <div style="margin-left:10%;" class="korisničkeInformacije">
      <form class="" action="adminKorisnici.php" method="post" name="forma">
    <?php
      if (mysqli_num_rows($rez) > 0) {
        while($row = mysqli_fetch_assoc($rez)) {
?>
          <br>
          <label class="oznakeUnosa" for="IDAukcije"> ID aukcije</label>
          <input class="unosi" id="$idAukcije" type="text" name="identifikatorAukcije" value=<?php echo $aukcija_id; ?> readonly>
          <br>
          <br>
          <label class="oznakeUnosa" for="naziv"> NAZIV </label>
          <textarea class="unosi" name="naziv" rows="2" cols="30" required><?php echo $row['naziv']; ?></textarea>
          <br>
          <label class="oznakeUnosa" for="opis"> OPIS </label>
          <textarea class="unosi" name="opis" rows="3" cols="30" required><?php echo $row['opis'] ?></textarea>
          <br>
          <label class="oznakeUnosa" for="vrijemePocetka"> Vrijeme početka </label>
          <textarea class="unosi" name="vrijemePocetka" rows="1" cols="30" required><?php echo $row['datum_vrijeme_pocetka']; ?></textarea>
          <br>
          <label class="oznakeUnosa" for="vrijemeZavrsetka" required> Vrijeme završetka </label>
          <textarea class="unosi" name="vrijemeZavrsetka" rows="1" cols="30"><?php echo $row['datum_vrijeme_zavrsetka']; ?></textarea>
          <br>
          <br>
<?php
// biranje moderatora preko select. Šaljemo ID a prikazujemo kor_ime.
          echo '<label class="oznakeUnosa" for="aukcije"> MODERATOR </label>';
          echo'<select class="unosi" name="IdentifikatorModeratora" required>';
          echo '<option disabled selected value> -- Odaberite moderatora -- </option>';
          $sqlModeratorPrikaz="SELECT DISTINCT korisnik_id, korisnicko_ime FROM korisnik WHERE tip_id = 1";
          $rezPrikazModeratora = izvrsiUpit($bp,$sqlModeratorPrikaz);
          if (mysqli_num_rows($rezPrikazModeratora) > 0) {
            while($redModeratora = mysqli_fetch_assoc($rezPrikazModeratora)) {
              echo '<option value='.$redModeratora['korisnik_id'].'>'.$redModeratora['korisnicko_ime'].'</option>';
            }
          }
    ?>
          </select>
          <br><br>
          <input style="margin-left:25%;" type="submit" name="potvrdaAzuiranjaAukcije" value="Potvrdi ažuriranje">
          </form>
<?php
            //Može vidjeti broj prodavača i kupaca po pojedinoj završenoj aukciji unutar odabranog vremenskog intervala na temelju datuma i vremena početka aukcije.
          if($row['datum_vrijeme_zavrsetka'] < $datumIvrijeme) {
  ?>
            <div class="statistika">
              <h4 style="text-align:center;">STATISTIKA</h4>
              <form class="" action="adminKorisnici.php" method="post" >
                <label class="oznakeUnosa" for="vrijemePocetka"> Vrijeme početka </label>
                <textarea style="width:40%;margin-left:40%;" class="unosi" name="vrijemePocetka" rows="1" cols="30" readonly><?php echo $row['datum_vrijeme_pocetka']; ?></textarea>
                <br>
                <label class="oznakeUnosa" for="interval">Interval (do) </label>
                <textarea style="width:40%;margin-left:40%;" class="unosi" name="interval" rows="1" cols="30" placeholder="dd.mm.gggg"></textarea>
                <br>
                <input style="margin-left:35%" type="submit" name="potvrdaStatistike" value="Prikaz rezultata" >
                <input type="hidden" name="id" value=<?php echo $row['aukcija_id'] ?>>
              </form>
            </div>
<?php
          } ?>
            <?php
        }
      }
    }
    if (ISSET($_POST['potvrdaAzuiranjaAukcije'])) {
      $bp = povezivanjeBaze();
      $idAukcije = $_POST['identifikatorAukcije'];
      $naziv = $_POST['naziv'];
      $opis = $_POST['opis'];
      $vrijemePocetka = $_POST['vrijemePocetka'];
      $vrijemeZavrsetka = $_POST['vrijemeZavrsetka'];
      $moderator = $_POST['IdentifikatorModeratora'];

      $sqlAzuiranjeAukcije="UPDATE aukcija SET moderator_id ='$moderator',naziv= '$naziv', opis='$opis', datum_vrijeme_pocetka ='$vrijemePocetka',datum_vrijeme_zavrsetka = '$vrijemeZavrsetka' WHERE aukcija_id ='$idAukcije'";
      $rez = izvrsiUpit($bp,$sqlAzuiranjeAukcije);
      if($rez){
        //window.location zato sto header neće.
          echo "<script> window.location = 'generiranjePotvrde.php' </script>";
        }
    }
    if (isset($_POST['potvrdaStatistike'])) {
      $id = $_POST['id'];
      $interval = $_POST['interval'];
      $vrijemePocetka = $_POST['vrijemePocetka'];
      $bp=povezivanjeBaze();
      $sqlProdavaci = "SELECT predmet_id FROM predmet WHERE aukcija_id = '$id'";
      $rezProdavaci= izvrsiUpit($bp,$sqlProdavaci);
      $brojProdavaca = mysqli_num_rows($rezProdavaci);
  //Spremanje predmet_id u polje da bi smo usporedivali kojoj aukciji pripadaju unosPonude
      $pripadnostPonuda=array();
      if (mysqli_num_rows($rezProdavaci) > 0) {
        while($red = mysqli_fetch_assoc($rezProdavaci)) {
                $pripadnostPonuda[]=$red['predmet_id'];

        }
      }
      function validacijaDatuma($noviDatumZavrsetka, $format = 'd.m.Y H:i:s'){
        $d = DateTime::createFromFormat($format, $noviDatumZavrsetka);
        return $d && $d->format($format) == $noviDatumZavrsetka;
      }
      if(validacijaDatuma($interval)){
        $interval = date ("Y.m.d H:i:s", strtotime($interval));
        $sqlKupci = "SELECT ponuda_id,datum_vrijeme_ponude FROM ponuda WHERE datum_vrijeme_ponude <= '$interval' AND predmet_id IN (". implode (",", $pripadnostPonuda) .")";
        $rezKupci = izvrsiUpit($bp,$sqlKupci);
        $brojKupaca = mysqli_num_rows($rezKupci);
    ?>
      <table style="margin-left:0%;">
        <tr>
          <th>Ukupno Prodavača</th>
          <th>Ukupno Kupaca</th>
        </tr>
        <tr>
          <td><?php echo $brojProdavaca; ?></td>
          <td> <?php echo $brojKupaca; ?></td>
        </tr>
      </table>
  <?php
    }
    else {
      $poruka = "Pogrešan unos. Molimo unesite vrijeme u formatu dan.mjesec.Godina Sat:minute:sekunde";
      echo "<script type='text/javascript'>alert('$poruka');</script>";
    }
  }
      ?>
   </body>
 </html>
