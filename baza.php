

<?php
 define ("posluzitelj","localhost");
 define ("korisnik","iwa_2017");
 define("lozinka","foi2017");
 define("baza","iwa_2017_zb_projekt");
  function povezivanjeBaze(){
    $poveznica = mysqli_connect(posluzitelj,korisnik,lozinka,baza);
    if(!$poveznica ){
      die('Spajanje neuspjelo! ' . mysqli_error());
    }
    mysqli_set_charset($poveznica,"utf8");
    return $poveznica;
  }
  function izvrsiUpit($poveznica,$upit){
    mysqli_set_charset($poveznica,"utf-8");
    $rezultat=mysqli_query($poveznica,$upit);
    if(mysqli_error($poveznica)!==""){
      echo '<h1 id="greska">GREŠKA: Problem sa upitom </h1>'
     };
   return $rezultat;
  }

?>
