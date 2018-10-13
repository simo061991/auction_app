
<?php

function validateDate($noviDatum, $format = 'd.m.Y H:i:s')
{
    $d = DateTime::createFromFormat($format, $noviDatum);
    return $d && $d->format($format) == $noviDatum;
}
function validateDateDva($noviDatumZavrsetka, $format = 'd.m.Y H:i:s')
{
    $d = DateTime::createFromFormat($format, $noviDatumZavrsetka);
    return $d && $d->format($format) == $noviDatumZavrsetka;
}
function formatiranjeDatumaAzuriranjeAukcija ($noviDatum ,$noviDatumZavrsetka/*,$novoVrijeme,$idAukcije*/,$moderator,$naziv,$opis,$idAukcije){
  $bp=povezivanjeBaze();
  //$noviDatum = preg_replace('/\s+/', '', $noviDatum);
//  $novoVrijeme = preg_replace('/\s+/', '', $novoVrijeme);
  //nakon micanja razmaka spajamo dva stringa sa samo razmakom izmedu
  echo '<br>';
//  $datumIvrijeme =$noviDatum." ".$novoVrijeme;
//  echo $datumIvrijeme;
//echo $noviDatum;
if(validateDate($noviDatum) && validateDateDva($noviDatumZavrsetka)){
    //echo $datumIvrijeme;
    echo '<br>';
    $noviDatum = date ("Y.m.d H:i:s", strtotime($noviDatum));
    $noviDatumZavrsetka = date ("Y.m.d H:i:s", strtotime($noviDatumZavrsetka));
    //$datumIvrijeme =$noviDatum." ".$novoVrijeme;
    //echo $datumIvrijeme;
  //$sqlPromjenaVremena="UPDATE aukcija SET datum_vrijeme_zavrsetka='$datumIvrijeme' WHERE aukcija_id='$idAukcije'";
  $sql="UPDATE aukcija SET opis= '$opis',naziv = '$naziv',moderator_id = '$moderator',datum_vrijeme_pocetka ='$noviDatum',datum_vrijeme_zavrsetka='$noviDatumZavrsetka', WHERE aukcija_id='$idAukcije'";
   $rez = izvrsiUpit($bp,$sql);
    if($rez){
      //window.location zato sto header neće.
     echo "<script> window.location = 'generiranjePotvrde.php' </script>";

    //}
  }

}
else {
  $poruka = "Pogrešan unos. Molimo unesite vrijeme u formatu dan.mjesec.Godina Sat:minute:sekunde";
  echo "<script type='text/javascript'>alert('$poruka');</script>";
}

}















//funkcija za statistiku

  function validacijaDatuma($noviDatumZavrsetka, $format = 'd.m.Y H:i:s'){
      $d = DateTime::createFromFormat($format, $noviDatumZavrsetka);
      return $d && $d->format($format) == $noviDatumZavrsetka;
  }
  function formatiranjeDatumaStatistike ($noviDatumZavrsetka){
    $bp=povezivanjeBaze();
    if(validacijaDatuma($noviDatumZavrsetka)){
      $noviDatumZavrsetka = date ("Y.m.d H:i:s", strtotime($noviDatumZavrsetka));
  }
    else {
      $poruka = "Pogrešan unos. Molimo unesite vrijeme u formatu dan.mjesec.Godina Sat:minute:sekunde";
        echo "<script type='text/javascript'>alert('$poruka');</script>";
    }
  }











?>
