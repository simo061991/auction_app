
<?php  include("zaglavlje.php"); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="stilovi.css" media=" screen and (max-width:1400px)" />
  </head>
  <body>
    <div class="autorskeInformacije">
      <img id="slikaOautoru" src="slike/autor.jpg" alt="Nedostupna slika">
      <table id="autorskaTablica">
        <tr>
          <th class="informacije">Ime i prezime</th>
          <td class="autorPodaci">Šimo Matijević</td>
        </tr>
        <tr>
          <th class="informacije">Broj indeksa</th>
          <td class="autorPodaci">Z-44358/15-I</td>
        </tr>
        <tr>
          <th class="informacije">E-MAIL</th>
          <td class="autorPodaci">smatijevi@foi.hr</td>
        </tr>
        <tr>
          <th class="informacije">Centar</th>
          <td class="autorPodaci">PITUP-Zabok</td>
        </tr>
        <tr>
          <th class="informacije">Godina upisa</th>
          <td class="autorPodaci">2017/2018</td>
        </tr>
      </table>
    </div>
    <?php include("podnozje.html") ?>
  </body>
</html>
