<?php
  include_once 'init.php';


  $db = new DB('sart');
  $sur = new SURAT(1,$db);
  $sur->setAnnounce();


  $a = new SekUm('juunnn',$db);
  $a->makeSurat();
  $login = login('juunnn',sha1('juunnn'),$db);
  if ($login) {
    echo "Hello world";
  }
  else {
    echo "Destroy the World";
  }
  //buat ngambil foto
  //echo "<img src='data:image/jpeg;base64,".$a->getFoto()."'/>";
  echo $a->getFoto();



?>
