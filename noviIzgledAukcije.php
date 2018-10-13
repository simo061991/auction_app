<?php include("zaglavlje.php");
include("baza.php");
?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="utf-8">
    <title></title>

  </head>
    <style media="screen">
      body,html{
        height: 100%;
	      margin: 0px;
        padding: 0px;
      }
      td{
        width: 300px;
        height: 400px;
        left: 0%;
        border: 2px solid orange;
        width:300px;
        padding: 1%;
        background-color: white;
        border-radius: 10px;
        position: relative;
        padding-top: 0px;
        padding-bottom: 20px;
      }
      tbody{
        position: absolute;
        margin-left: 17%;
      }

      #slika{
        width: 70%;
        height: 35%;
        position: absolute;
        top: 1px;
        margin-left: 9%;

      } 
      #unos{
        position: absolute;
        top: 90%;
      }

      #opisni{
        position: absolute;
        font-size: 11px;
        top: 180px;
        font-family: Verdana, Arial, sans-serif;
        font-style: italic;
        margin-top: 30px;

      } 
      #naziv{
        position: absolute;
        top: 150px;
        width:60%;
        text-align: center;
        margin-left: 12%;
        font-family: Verdana, Arial, sans-serif;
        font-weight: 500;
        font-size: 16px;
      }
      .novaForma{
        position: absolute;
        top:90%;
        margin-left: 14%;
      }
      #unosPonude{
        width: 160px;
        border-radius: 5px;
        left: 15px;
        padding: 6px;
      }
      #potvrdaPonude{
        width: 200px;
        border-radius: 10px;
        padding: 8px;
        background-color: #5CB85C;
        color: white;
      }
      #potvrdaPonude:hover{
        background-color: #449D44;
      }
      #cijena{
        position: absolute;
        bottom: 20%;
        margin-left: 8%;
        font-family: Verdana, Arial, sans-serif;
        font-size: 14px;
        font-weight: bold;
      }

    </style>
  <body>
    <?php 
      if (isset($_SESSION['tipKorisnika'])) {
        ?>
        <a href="dodavanjePredmeta.php">  <button style=" margin-left:30%; width:40%;margin-top:1%;" type="button" name="button">Dodajte novi predmet</button></a>
      <?php }
    ?>
<?php
    $bp = povezivanjeBaze();
    $kategorijaID=$_POST["id"];
    $sql= "SELECT predmet.predmet_id ,naziv,slika,pocetna_cijena,opis,MAX(iznos_ponude) AS maksimalnaCijena FROM predmet LEFT JOIN ponuda ON predmet.predmet_id = ponuda.predmet_id
    WHERE aukcija_id='$kategorijaID'  GROUP BY naziv  ";
    $rez = izvrsiUpit($bp,$sql);

    echo "<table><tr>";
    $count = 0;
    $i=0;
    if (mysqli_num_rows($rez) > 0) {
      while($row = mysqli_fetch_assoc($rez)) {
        $i++;
          $prikaz = $row["slika"];
          $nazivArtikla= $row["naziv"];
          $opisPredmeta = $row["opis"];
          $maksimalnaCijena = $row["maksimalnaCijena"];
                //ako nije postavljena cijena u tablici ponuda, maksimalna cijena je početna cijena
          if (!isset($row["maksimalnaCijena"])) {
            $maksimalnaCijena=$row["pocetna_cijena"];
          }
        ?>
          <td id="tabela"> <img id="slika" src=<?php echo $prikaz; ?> alt=""> <h2 id="naziv"> <?php echo $nazivArtikla; ?>
          </h2> <p id="opisni"><?php echo $opisPredmeta; ?></p> <p id="cijena"><span style="font-weight:normal"> Trenutna cijena je : </span> <?php echo $maksimalnaCijena; ?> HRK</p>

        <?php
          if (isset($_SESSION['tipKorisnika'])) {
            if ($_SESSION["tipKorisnika"]==0 || $_SESSION["tipKorisnika"]==1 || $_SESSION["tipKorisnika"]==2) {
        ?>
              <script type="text/javascript">
                document.getElementById("txtPrijava").innerHTML = "Odjava";
              </script>
              <form   name="formaUnosa"class="novaForma" action="potvrde.php" method="POST">
                <input type="number" name="ponuda" value="" required placeholder="Unesite Vašu ponudu" id="unosPonude" min=<?php echo $maksimalnaCijena +1  ?>>
                <input type="submit" name="gumbPot" value="Potvrda" id="potvrdaPonude">
                <input type="hidden" name="maks" value=<?php echo $maksimalnaCijena; ?> id="trenutnaCijena">
                <input type="hidden" name="predmetID" value=<?php echo $row['predmet_id']; ?> >
              </form>
        <?php
          }
        }
        ?>
          </td>
        <?php
          if ($i % 3 == 0) {
            echo "</tr><tr>";
          }
      }
    }
      echo '</table>';
    ?>
  </body>
</html>
