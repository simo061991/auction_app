<?php include("zaglavlje.php");
include("baza.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

<?php
//session_start();
$bp = povezivanjeBaze();
$porukaGreske="";
if (isset($_POST['submit'])){
  $korisnickoIme= $_POST["korisnickoIme"];
  $lozinka = $_POST["lozinka"];
  $sql = "SELECT korisnik_id,tip_id,korisnicko_ime,lozinka,ime,prezime FROM korisnik WHERE korisnicko_ime='$korisnickoIme' AND lozinka ='$lozinka'";
  $rez =izvrsiUpit($bp,$sql);
  $red = mysqli_fetch_array($rez);
  if(mysqli_num_rows($rez)==1){
    $_SESSION["id"] = $red["korisnik_id"];
    $_SESSION["tipKorisnika"] = $red["tip_id"];
    $_SESSION["korisnickoIme"] = $red["korisnicko_ime"];
    $_SESSION["imeKorisnika"] = $red["ime"];
    $_SESSION["prezimeKorisnika"] = $red["prezime"];
    header("Location: pocetna.php");
  }
  if (!isset($_SESSION["korisnickoIme"]) || $_SESSION["korisnickoIme"]!=$red["korisnicko_ime"] ) {
      echo  " <H3 style='position:absolute;color:red;margin-top:30%;margin-left:40%;font-size:14px'>Pogrešno korisničko ime ili lozinka</H3>";
  }
}
 ?>
    <h1 id="naslovPrijava">Dobrodošli, molimo prijavite se!</h1>
    <div class="prijava">
      <form class="" action="prijava.php" method="post">
        <div class="podaciPrijava">
          <label id="oznakaKorisnika"for="korIme">Korisničko ime</label>
          <br>
          <input type="text" name="korisnickoIme" size="20" placeholder="Unesite korisničko ime" id="korIme" required>
          <br>
          <label id="oznakaLozinke" for="lozinka">Lozinka</label>
          <input type="password" name="lozinka" value="" placeholder="Unesite lozinku" id="lozinka" required>
          <input type="submit" name="submit" value="Prijavi se" id="prijava">
        </div>
      </form>
    </div>
  </body>
</html>
