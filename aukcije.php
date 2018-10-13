<!-- <?php include("zaglavlje.html");
include("baza.php");
?>
<!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8">
    <title></title>

    <style media="screen">

      .mainDiv{
        /*
        margin-top: 2%;
        margin-left: 10%;
        height: 30%;
        width: 15%;
        background-color: #F1F1F1;
        border: 5px solid #7CEAEB;
        */
        width: 800px;
        height: 100px;
        background-color: red;
        margin-top: 5px;
        font-size: 20px;
        position: relative;
      }
      #gumbPredmet{
        background-color: #2FC99F;
        margin-left: 40%;
        width: 20%;
        padding: 10px;
        margin-top: 1%;
      }

    </style>
  </head>
  <body>
<p id="demo"></p>
<?php
    session_start();
    if (isset($_SESSION["tipKorisnika"])){
    if ($_SESSION["tipKorisnika"]==0 || $_SESSION["tipKorisnika"]==1 || $_SESSION["tipKorisnika"]==2) {
      ?>
      <form  action="dodavanjePredmeta.php" method="get">
        <button id="gumbPredmet">Dodaj novi predmet</button>
      </form>
      <?php
    }
  }
    ?>
    <div id="traka">
    </div>

<?php


$bp = povezivanjeBaze();
$kategorijaID=$_POST["id"];
//$sql = "SELECT naziv,slika,opis FROM predmet WHERE aukcija_id ='$kategorijaID'";
//$sql = "SELECT naziv,slika,opis,MAX(iznos_ponude) AS maksimalnaCijena FROM predmet INNER JOIN ponuda ON predmet.predmet_id=ponuda.predmet_id  WHERE aukcija_id ='$kategorijaID'";
$sql= "SELECT naziv,slika,pocetna_cijena,opis,MAX(iznos_ponude) AS maksimalnaCijena FROM predmet LEFT JOIN ponuda ON predmet.predmet_id = ponuda.predmet_id
WHERE aukcija_id='$kategorijaID'  GROUP BY naziv  ";

$rez = izvrsiUpit($bp,$sql);
$count = 0;
  //echo mysqli_num_rows($rez);
  //echo "<table><tr>";



  if (mysqli_num_rows($rez) > 0) {
            while($row = mysqli_fetch_assoc($rez)) {
              echo '<div id="primjer">';
              // echo  "Ime: " . $row["korisnicko_ime"]. "<br>";
              $prikaz = $row["slika"];
            //  echo $prikaz;
            $nazivArtikla= $row["naziv"];
            $opisPredmeta = $row["opis"];
            $maksimalnaCijena = $row["maksimalnaCijena"];
            //ako nije postavljena cijena u tablici ponuda, maksimalna cijena je početna cijena
            if (!isset($row["maksimalnaCijena"])) {
              $maksimalnaCijena=$row["pocetna_cijena"];
            }
              echo " " .'<img id="slika1" src="'.$prikaz.'" alt="Cover">'.'<p id="naziv"> '.$nazivArtikla.'</p>'
              .'<p id="opis"> '.$opisPredmeta.'</p>'.'<p id="maksimalnaCijena"> '.$maksimalnaCijena.' kn</p>';

              ?>
             <?php
              //ISSET- jer pokazuje undefined tipKorisnika ako nije prijavljen.
              if (isset($_SESSION['tipKorisnika'])) {
              if ($_SESSION["tipKorisnika"]==0 || $_SESSION["tipKorisnika"]==1 || $_SESSION["tipKorisnika"]==2) {
           ?>
            <style media="screen">
              #primjer
              {width: 80%;
                margin-left: 100px;
              }
              #maksimalnaCijena{
                margin-left: 75%;
              }
              #naziv{
                width: 10%;
              }
            </style>
            <form   name="formaUnosa"class="novaForma" action="potvrde.php" method="GET">
             <input type="number" name="ponuda" value="" required id="unosPonude" min=<?php echo $maksimalnaCijena +1  ?>>
             <input type="submit" name="gumbPot" value="Unesi ponudu" id="potvrdaPonude" onclick="return provjera()">
             <input type="hidden" name="maks" value=<?php echo $maksimalnaCijena; ?> id="trenutnaCijena">

           </form>

            <?php



       }
}
              echo '</div>';
              $count++;
//echo '<hr id="crta">';
            }
}
?>
</form>
<script type="text/javascript">
/*
function provjera() {
    var novaCijena = document.getElementById('unosPonude').value;
    var trenutnaCijena = document.getElementById('trenutnaCijena').value;
    if(novaCijena <= trenutnaCijena){
    alert ("Iznos mora biti veći od postojećeg koji je " + trenutnaCijena);
    return false;
}
else {
return true;
}
}
*/
</script>
<?php include("podnozje.html") ?>

</body>
</html> -->
