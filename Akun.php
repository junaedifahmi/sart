<?php
  /**
   kelas akun, kelas ini menampung segala
   hal yang dimiliki bersama oleh sekretaris umum dan sekretaris acara.
   */
  class Akun{

    public $nama = '';
    public $email = '';
    public $foto = null;
    public $hak = false;
    public $db = null;
    public $npm = '';

    function __construct($uname,$db){
      $this->db = $db;
      $syarat = "user.uname = akun.uname AND user.uname = '".$uname."'";
      $a = $this->db->SELECT('akun,user',$syarat);
      $this->nama = $a[0]['nama'];
      $this->email = $a[0]['email'];
      $this->hak = $a[0]['hak'];
      $this->foto = base64_encode($a[0]['foto']);
      $this->npm = $a[0]['npm'];
      session_start();
    }

    public function logout(){
        session_start();
        unset($_SESSION['user_session']);

        if(session_destroy())      {
          header("Location: index.php");
        }
      }

      public function getFoto(){
        return $this->foto;
      }

      public function makeSurat(){
        $perihal = 'undangan';
        $lamp = 0;
        $sifat = 'biasa';
        $tanggal = date("m/d/Y");
        $array = array($perihal,$lamp,$sifat,$tanggal);
        $a = $this->db->INSERT('surat',$array);
        if ($a) {
          echo "Hwllo";
        }
        else {
          echo $a;
        }
        $U = $this->db->SELECT('surat');
        echo "<pre>",print_r($U),"</pre>";
      }

      public function seeArsip(){
        # code...
      }

      public function launched(){
        # code...
      }
  }


 ?>
