<?php include("zaglavlje.php");
include("baza.php")
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="stilovi.css" media=" screen and (max-width:1400px)" />
    <style media="screen">
      table{
        width: 100%;
        border-collapse: collapse;
      }
      th{
        width: 15%;
        border: 1px solid #EBEBEB;
        height: 50px;
        color: #929292;
      }
      #adminKorisnici, #adminAukcije{
        border-radius: 10px;
      }
      td{
        text-align: center;
        border: 1px solid #ddd;
      }
      .granicnaCrta{
        height: 30px;
        width: 100%;
        background-color: #7CEAEB;
        text-align: center;
      }
      .korisnici{
        margin-top: 5px;
      }
       tr:nth-child(even){
         background-color: #f2f2f2;
       }
       th{
         background-color: #30B6CC;
         color: white;
         font-weight: bold;
       }
     
      </style>
  </head>
  <body>
    <div class="adminProfil">
      <form class="" action="admin.php" method="post">
        <input id="adminKorisnici" type="submit" name="adminKorisnici" value="Pregled korisnika">
        <input id="adminAukcije" type="submit" name="adminAukcije" value="Pregled aukcija">
      </form>
    <table>
      <?php if(isset($_POST['adminKorisnici'])){?>
        <style media="screen">
          #adminKorisnici{
            background-color: #30B6CC;
            color: white;
          }
        </style>
        <tr>
          <th> Tip korisnika</th>
          <th> Korisničko ime</th>
          <th> Ime</th>
          <th> Prezime</th>
          <th> E-mail</th>
          <th>Uređivanje </th>
          <th id="aukcijaID"style="visibility:hidden;">Aukcija ID</th>
        </tr>
      <?php } ?>
      <?php
        $bp = povezivanjeBaze();
        $sqlKorisnici = "SELECT * FROM korisnik";
        $rezKorisnici = izvrsiUpit($bp,$sqlKorisnici);
        if (isset($_POST['adminKorisnici'])) {
          odabirKorisnika($rezKorisnici);
          ?>
          <div class="granicnaCrta">
            <form class="odabir" action="admin.php" method="post">
              <input class ="korisnici" type="radio" name="tipKorisnika" value="korisnik" required>KORISNIK
              <input class ="korisnici" type="radio" name="tipKorisnika" value="moderator">MODERATOR
              <input type="submit" name="pretraziKorisnika" value="Pretraži">
            </form>
            
            
          </div>
      <?php } ?>
      <?php
        if (isset($_POST['pretraziKorisnika'])) {
          @$vrstaKorisnika=$_POST['tipKorisnika'];
          if ($vrstaKorisnika =="korisnik") {
            $sqlKorisnik = "SELECT * FROM korisnik WHERE tip_id=2";
            $rezObicniKorisnik = izvrsiUpit($bp,$sqlKorisnik);
            odabirKorisnika($rezObicniKorisnik);
          }
          if ($vrstaKorisnika =="moderator") {
            $sqlModDva ="SELECT * FROM korisnik WHERE tip_id = 1";
            $rezModDva = izvrsiUpit($bp,$sqlModDva);
            odabirKorisnika($rezModDva);
          }
        }
        function odabirKorisnika($rezKorisnici){
          if(mysqli_num_rows($rezKorisnici) > 1){
            @$vrstaKorisnika=$_POST['tipKorisnika'];
            while ($red = mysqli_fetch_assoc($rezKorisnici)) {
              $prikaz = $red["slika"];
              ?>
              <tr>
                <td> <?php echo $red["tip_id"]; ?></td>
                <td> <?php echo $red["korisnicko_ime"]; ?></td>
                <td> <?php echo $red["ime"]; ?></td>
                <td> <?php echo $red["prezime"]; ?></td>
                <td> <?php echo $red["email"]; ?></td>
                <td> <form class="" action="adminKorisnici.php" method="post">
                  <input type="hidden" name="tip" value=<?php echo $red["tip_id"]; ?>>
                  <input type="hidden" name="identifikacijaKorisnika" value=<?php echo $red["korisnik_id"] ?>>
                  <input type="hidden" name="kor_ime" value=<?php echo $red["korisnicko_ime"] ?>>
                  <input type="hidden" name="ime" value=<?php echo $red["ime"] ?>>
                  <input type="hidden" name="prezime" value=<?php echo $red["prezime"] ?>>
                  <input type="hidden" name="email" value=<?php echo $red["email"] ?>>
                  <input type="hidden" name="slika" value=<?php echo $prikaz ?>>
                  <?php   if (@$vrstaKorisnika =="moderator") {
                  //postavljamo true jer je moderator da mu znamo omogućiti da admin unese kao moderatora.
                    ?><input type="hidden" name="dodjeljenaAukcija" value=<?php echo true;/*$red["aukcija_id"];*/ ?>>
                    <?php
                  } ?>
                  <input id="uredivanjeKorisnika" type="submit" name="uredivanjeKorisnika" value="Uređivanje korisnika">


                </form> </td>
              </tr>
              <?php
            } 
          }
        }
//uređivanje aukcije
        if (ISSET($_POST['adminAukcije'])) {
          ?>
          <div class="granicnaCrta">
            <form class="aukcijeOdabir" action="admin.php" method="post">
              <input  class="korisnici"id ="aukcije" type="radio" name="tipAukcije" value="OtvoreneAukcije" required>Otvorene aukcije
              <input class="korisnici"id ="aukcije" type="radio" name="tipAukcije" value="ZatvoreneAukcije">Zatvorene aukcije
              <input type="submit" name="pretraziAukcijePoTipu" value="Pretraži">
            </form>

          </div>
  <!-- kad je gumb kliknut mjenja boju. -->
            <style media="screen">
              #adminAukcije{
                background-color: #30B6CC;
                color:white;
              }
            </style>
 
          <?php
          $sql = "SELECT * FROM aukcija";
          $rez = izvrsiUpit($bp, $sql);
          odabirAukcije($rez);
        }
        function odabirAukcije($rez){
          $bp= povezivanjeBaze();
          if(mysqli_num_rows($rez) > 1){
            ?>
            <tr>
              <th>Identifikator aukcije</th>
              <th>Identifikator moderatora</th>
              <th>Naziv aukcije</th>
              <th>Opis aukcije</th>
              <th>Datum i vrijeme početka</th>
              <th>Datum i vrijeme završetka</th>
              <th>Uređivanje aukcije</th>
            </tr>
          <?php
            while ($red = mysqli_fetch_assoc($rez)) {
            ?>
              <tr>
                <td> <?php echo $red['aukcija_id']; ?></td>
                <td> <?php echo $red['moderator_id']; ?></td>
                <td> <?php echo $red['naziv']; ?></td>
                <td id="opisAukcije"> <?php echo $red['opis']; ?></td>
                <td> <?php echo $red['datum_vrijeme_pocetka']; ?></td>
                <td> <?php echo $red['datum_vrijeme_zavrsetka']; ?></td>
                <td>
                  <form class="" action="adminKorisnici.php" method="post">
                    <input type="hidden" name="identifikacijaAukcije" value=<?php echo $red["aukcija_id"]; ?>>
                    <input type="hidden" name="identifikacijaModeratora" value=<?php echo $red["moderator_id"] ?>>
                    <input type="hidden" name="nazivAukcije" value=<?php echo $red["naziv"] ?>>
                    <input type="hidden" name="opisAukcije" value=<?php echo $red["opis"] ?>>
                    <input type="hidden" name="datumPocetka" value=<?php echo $red["datum_vrijeme_pocetka"] ?>>
                    <input type="hidden" name="datumZavrsetka" value=<?php echo $red["datum_vrijeme_zavrsetka"] ?>>
                    <input type="submit" name="uredivanjeAukcije" value="Uredi aukciju">
                  </form>
                </td>
              </tr>
          <?php
            }
          }
        }

        if (isset($_POST['pretraziAukcijePoTipu'])) {
          @$vrstaAukcije=$_POST['tipAukcije'];
          if ($vrstaAukcije =="OtvoreneAukcije") {
            $vrijeme = date('Y-m-d H:i:s');
            $sql="SELECT * FROM aukcija WHERE datum_vrijeme_zavrsetka > '$vrijeme'";
            $rez = izvrsiUpit($bp,$sql);
            odabirAukcije($rez);
          }
        }
        if (isset($_POST['pretraziAukcijePoTipu'])) {
          @$vrstaAukcije=$_POST['tipAukcije'];
          if ($vrstaAukcije =="ZatvoreneAukcije") {
            $vrijeme = date('Y-m-d H:i:s');
            $sql="SELECT * FROM aukcija WHERE datum_vrijeme_zavrsetka < '$vrijeme'";
            $rez = izvrsiUpit($bp,$sql);
            odabirAukcije($rez);
          }
        }
        ?>
        </table>
        </div>

        <div style="position:absolute;top:85%;width:100%;">
          <form  class="" action="adminKorisnici.php" method="post">
            <input style="width:300px;height:50px;margin-left:20%;" id="noviKorisnik" type="submit" name="noviKorisnik" value="Novi korisnik">
          </form>
          <form style="position:absolute;left:50%;top:1%;"  class="" action="dodavanjeAukcije.php" method="post">
            <input  style ="width:300px;height:50px;" type="submit" name="dodavanjeAukcije" value="Dodajte novu aukciju">
          </form>
        </div>
      <?php 
        include("podnozje.html");
      ?>
      <style>
        .podnozje{
          top:90%;
        }
      </style>
  </body>
</html>
