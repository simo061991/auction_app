<?php include("zaglavlje.php");
include("baza.php")
 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="stilovi.css" media=" screen and (max-width:1400px)" />
    <style media="screen">
      table{
      width: 100%;
      border-collapse: collapse;
      }
      th{
        width: 20%;
        border: 1px solid #EBEBEB;
        height: 50px;
        color: #929292;
      }
      #ponudaKupca{
        width: 5%;
      }
      td{
        height: 50px;
        border: 1px solid #EBEBEB;
      }
      #korisnickaPonuda{
        padding-left: 5%;
        font-weight: bold;
        font-family: Helvetica;
      }
      #poljePobjednika{
         padding-left: 10%;
      }
      .uredivanjeAukcije{
             margin-left: 0.5%;
             margin-top: 40%;
             width: 99%;
             height: 40%;
             background-color: red;
      }

    </style>
  <title></title>

  </head>
  <body>

    <div class="profil">
        <form class="" action="MojProfil.php" method="post">
          <input type="submit" name="aktivniGumb" value="Otvorene aukcije" id="aktivniGumb">
          <input type="submit" name="zatvoreniGumb" value="Zatvorene aukcije" id="zatvoreniGumb">
        </form>
      <table>
        <tr>
          <th id="predmet">Predmet</th>
          <th id="ponudaKupca">Vaša ponuda</th>
          <th id="najvecaPonuda">Najveća ponuda</th>
        </tr>
  <?php
    $iDKorisnik = $_SESSION["id"];
    $redDva=[];
    $redPripadnostiPredmeta=[];
    $bp=povezivanjeBaze();
    $vrijeme = date('Y-m-d H:i:s');
    //echo strtotime($vrijeme);
    if(isset($_POST['aktivniGumb'])){
      $sql="SELECT aukcija_id, datum_vrijeme_zavrsetka FROM aukcija WHERE datum_vrijeme_zavrsetka >'$vrijeme'";
      $rez = izvrsiUpit($bp,$sql);
      if (mysqli_num_rows($rez) > 0) {
        while($red = mysqli_fetch_assoc($rez)) {
          $redDva[]= $red['aukcija_id'];
        }
      }
    }
      if(isset($_POST['zatvoreniGumb'])){
        $sql="SELECT aukcija_id, datum_vrijeme_zavrsetka FROM aukcija WHERE datum_vrijeme_zavrsetka < '$vrijeme'";
        $rez = izvrsiUpit($bp,$sql);
        if (mysqli_num_rows($rez) > 0) {
          while($red = mysqli_fetch_assoc($rez)) {
            $redDva[]= $red['aukcija_id'];
          }
        }
      }
      $sqlPredmeta = "SELECT DISTINCT ponuda.predmet_id FROM ponuda INNER JOIN predmet ON ponuda.predmet_id = predmet.predmet_id WHERE ponuda.korisnik_id='$iDKorisnik' AND predmet.aukcija_id IN (". implode (",", $redDva) .")";
      error_reporting( 0 );
      $rezDva = izvrsiUpit($bp,$sqlPredmeta);
      if (mysqli_num_rows($rezDva) > 0) {
        while($red = mysqli_fetch_assoc($rezDva)) {
          $redPripadnostiPredmeta[] = $red['predmet_id'];
        } 
      }
// OVO JE U SLUČAJU AKO KORISNIK NEMA NITI JEDAN DEFINIRAN PREDMET, DA MU NE PRIKAZUJE GREŠKU.
      else{
        error_reporting( 0 );
      ?>
        <style media="screen">
          #greska{
            display: none;
          }
  </style>
  <?php
      }
      $sqlTri="SELECT MAX(iznos_ponude) AS maksimum FROM ponuda WHERE predmet_id IN (". implode (",", $redPripadnostiPredmeta) .")  GROUP BY predmet_id";
      $rez = izvrsiUpit($bp,$sqlTri);
      $polje = array();
      $i=0;
      if (mysqli_num_rows($rez) > 0) {
        while($red = mysqli_fetch_assoc($rez)) {
//pretvaramo u polje da mu možemo pristupiti putem polje[$i] jer nam inače ispisuje u jedan red sve
          $pristupKorisnikuNajvecePonude [] = $red["maksimum"];
          $polje[]=$red;
          $i++;
        }
      }
      else {
          error_reporting( 0 );
      }
      $sqlCetiri="SELECT ponuda.korisnik_id,ponuda.iznos_ponude, korisnik.ime FROM ponuda INNER JOIN korisnik ON korisnik.korisnik_id = ponuda.korisnik_id WHERE iznos_ponude IN (". implode (",", $pristupKorisnikuNajvecePonude) .") ";
      $rez = izvrsiUpit($bp,$sqlCetiri);
      $poljePobjednika=array();
      if (mysqli_num_rows($rez) > 0) {
        while($red = mysqli_fetch_assoc($rez)) {
          $poljePobjednika[]=$red;
        }
      }
      $sqlDva="SELECT naziv,slika,predmet.predmet_id,iznos_ponude,MAX(iznos_ponude) AS maksimalnaCijena FROM predmet LEFT JOIN ponuda ON predmet.predmet_id = ponuda.predmet_id
      WHERE aukcija_id IN (". implode (",", $redDva) .") AND ponuda.korisnik_id='$iDKorisnik' GROUP BY ponuda.predmet_id";
      $rez = izvrsiUpit($bp,$sqlDva);
      $i=0;
//micanje pogreški zbog tog da možemo napraviti generički prvi if, da ne ponavljamo kod.
      error_reporting( 0 );

      if (mysqli_num_rows($rez) > 0) {
        while($red = mysqli_fetch_assoc($rez)) {
          echo '<tr>';
          ?><td> <?php echo $red["naziv"]; ?></td>
          <td id="korisnickaPonuda"> <?php echo $red["maksimalnaCijena"]. " kn" ;?></td>
          <td id="poljePobjednika"><?php   echo $polje[$i]["maksimum"]. " kn";
          if(isset($_POST['zatvoreniGumb'])){
            echo "- Ime pobjednika na aukciji je =  " .$poljePobjednika[$i]["ime"]." ";
          }
          else{
            echo "- Ime korisnika =  " .$poljePobjednika[$i]["ime"]." ";
          }
          ?> </td></tr>
      <?php
          $i++;
        }
      }
      else{
        error_reporting( 0 );
      ?>
        <style media="screen">
          #greska{
            display: none;
          }
        </style>
      <?php
      }
     ?>
      </table>
    </div>
<?php
  if ($_POST['azuriranjeAukcije']) {
    $idAukcije = $_POST["aukcijaID"];
    echo $idAukcije;
    echo '<br>';
    echo $_POST["datumZavrsetka"];
  // zbog tog što nam sam echo izbacuje skraćeni oblik npr (OD, umjesto od glave do pete)
  ?>
    <div style="position:absolute; margin-top:35%;"class="">
      <table>
        <th>Identifikator aukcije</th>
        <th>Naziv aukcije</th>
        <th>Datum završetka aukcije</th>
        <th>Ažurirani datum završetka</th>
        <th>Zatvaranje aukcije</th>
  <?php
    $sqlModeratorNaziv = "SELECT naziv FROM aukcija WHERE aukcija_id = '$idAukcije'";
    $rez=izvrsiUpit($bp,$sqlModeratorNaziv);
    while($row = mysqli_fetch_assoc($rez)) {
      
    }
    
//echo $row["naziv"];
?>
  </table>
</div>
<?php
}
     ?>
     <?php
       include 'podnozje.html';
      ?>
      <style media="screen">
        .podnozje{
          top:80%;
        }
      </style>
  </body>
</html>
