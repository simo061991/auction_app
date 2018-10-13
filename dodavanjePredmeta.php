<?php include("zaglavlje.php");

include("baza.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="interakcija.js"></script>
    <title></title>
  </head>
  <body>
    <div class="blokUnosaPredmeta">
      <h1 style="margin-left:35%">Dodavanje novog predmeta</h1>
      <hr id="crta">
      <form id="formaPredmeta"  action="dodavanje.php" method="POST">
        <h4 style="margin-left:15%">Odaberite kategoriju</h4>
        <select id="padajuciZaPredmete" name="predmeti">
          <?php
          session_start();
          $bp = povezivanjeBaze();
          $sql= "SELECT naziv,aukcija_id FROM aukcija";
          $rez = izvrsiUpit($bp,$sql);
          if (mysqli_num_rows($rez) > 0) {
            while($row = mysqli_fetch_assoc($rez)) {
          //prenosimo naziv aukcije a dohvaćamo ID sa POST
              echo '<option value='.$row['aukcija_id'].'>'.$row['naziv'].'</option>';
            }
          }
          ?>
        </select>

        <h4 style="position:absolute;top:0;left:63%">Naziv proizvoda</h4>
        <input type="text" name="nazivProizvoda" placeholder="Naziv proizvoda" id="nazivProizvoda" required> <br>
        <h4 style="margin-left:45%">Kratak opis</h4>
        <textarea rows="5" cols="50" id="opisProizvoda" name="opisPredmeta" required></textarea>
        <h4 style="margin-left:45%">Početna cijena</h4>
        <input type="decimal" name="cijena" id="cijenProizvoda" required>HRK
        <h4 style="margin-left:45%">URL slike</h4>
        <input type="url" name="url" value="" id="urlProizvoda" required>
        <input type="submit" name="submit" value="Dodaj" id="potvrdiPredmet" style="border-radius:10px;font-weight:bold" >
      </form>
    </div>
    <?php include("podnozje.html"); ?>
    <style media="screen">
      .podnozje{
        top:90%;
      }
    </style>
  </body>
</html>
