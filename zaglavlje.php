<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="stilovi.css" media=" screen and (max-width:1400px)" />
    <meta charset="utf-8">

    <title>Aukcije</title>
  </head>
  <body>
  <noscript>
    <div style="background-color:red;color:white;text-align:center;font-weight:bold">Javascript je blokiran, za bolje iskustvo na web stranici promijenite to u "Postavkama" vašeg preglednika.</div>
    
  </noscript>
    <div id="zaglavlje">
      <a id="aLogo" href="pocetna.php"> <img id="logo" src="slike/logo.png" alt=""></a>
      <nav>
        <ul class="navigacija">
          <li><a href="pocetna.php">Početna</a> </li>
          <li><a href="kategorije.php">Aukcije</a> </li>
          <li><a id="txtPrijava" href="prijava.php">Prijava</a> </li>
          <li style="display:none" id="profilKorisnika"><a href="MojProfil.php">Moj profil</a> </li>
          <li style="display:none" id="adminStranica"><a href="admin.php">Admin</a> </li>
          <li><a href="o_autoru.php">O autoru</a> </li>
        </ul>
      </nav>
    </div>
    <?php
      session_start();
      if (isset($_SESSION['tipKorisnika'])) {
        if ($_SESSION["tipKorisnika"]==0 || $_SESSION["tipKorisnika"]==1 || $_SESSION["tipKorisnika"]==2) {
    ?>
          <script type="text/javascript">
            document.getElementById("txtPrijava").innerHTML = "Odjava";
            document.getElementById('txtPrijava').href = "odjava.php"
            document.getElementById('profilKorisnika').style.display="inline";
          </script>
    <?php
        } 
        if ($_SESSION['tipKorisnika'] == 0 ) {
    ?>
          <script type="text/javascript">
          document.getElementById('adminStranica').style.display="inline";
          </script>
        <?php
        }
      }
        ?>

      
  </body>
</html>
