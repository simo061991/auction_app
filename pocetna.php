<?php
include("zaglavlje.php");

 ?>

<!DOCTYPE html>
<html>
  <head>
    <!-- dodati meta autora itd -->
    <link rel="stylesheet" href="stilovi.css" media=" screen and (max-width:1400px)" />
    <meta charset="utf-8">
    <title></title>
  </head>
  <style>
    @supports (-moz-appearance:none) {
    #prijavaPocetna{
      margin-left:1%;
    }
}
  
  </style>
  <body>
    <div class="naslovnica">
      <img id="naslovnaSlika" src="slike/naslovna.png" alt="Nedostupna slika">
      <a id="prijavaPocetna" href="prijava.php"><button style="position:absolute;margin-left:38%;top:60%;border-radius:10px;width:20%;font-weight:bold;color:black" type="button" name="submit" id="prijava">Prijavi se</button></a>
    </div>
    <?php
      include 'podnozje.html';
      if (isset($_SESSION['tipKorisnika'])) {
        ?>
      <script>
        document.getElementById('prijavaPocetna').style.visibility="hidden";
      </script>
<?php } ?>
  </body>
</html>
