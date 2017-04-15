<?php
  include_once 'Akun.php';
  include_once 'SekBis.php';
  include_once 'SekUm.php';
  include_once 'surat.php';
  include_once 'Database.php';


  /**
  ini fungsi yang tidak bisa dimasukkan ke dalam kelas

  **/

  function login($uname,$pass,$db){
    $syarat = "uname = '".$uname."'";
    $a = $db->SELECT('akun',$syarat);
    $pass1 = $a[0]['pass'];
    if($pass1===$pass){
      if($a[0]['status']){
        return true;
      }
      else {
        echo "Akun belum diverifikasi oleh sekretaris umum";
        die();
      }
    }
    else {
      return false;
    }
  }
 ?>
