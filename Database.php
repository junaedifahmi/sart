<?php
  /**
  Kelas ini berisi perintah DML,
  DDL tidak ada dalam kelas ini

   */
  class DB {
    private $sambungan;

    /**
      fungsi ini untuk membuat sambungan
    **/
    function __construct($nama,$db = '127.0.0.1',$user = 'root',$pass='') {
      try{
    		$this->sambungan = new PDO("mysql:host=$db;dbname=$nama",$user,$pass);
    		$this->sambungan->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	}
    	catch(PDOException $e){
        $this->sambungan = null;
            die($e->getMessage());
    		}
    }

    /**
      Ini fungsi untuk mengambil dan menampilkan data dari tabel
      $tabel = nama tabel, $attr = atribut yang akan ditampilkan
      $con = kondisi
      mengembalikan hasil dalam bentuk array assosiatif
    **/
    public function SELECT($tabel,$con="0=0",$attr="*"){
      $query = "SELECT ".$attr." FROM ".$tabel." WHERE ".$con;
      try{
        $stmt = $this->sambungan->query($query);
        if ($stmt) {
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }
        else {
          return self::getMessage();
        }
      }
      catch(PDOException $e){
        $e->getMessage();
      }
    }


    /**
    ini fungsi untuk INSERT tabel
    **/
    public function INSERT($table,$value){
      ## setting atribut
      $attr = '';
      $var = '';
      $a = $this->getCol($table);
      for ($i=0; $i < count($a) ; $i++) {
        $attr .= $a[$i];
        $var .= "?";
        if($i != count($a)-1){
            $attr .=" , ";
            $var .=" , ";
        }
      }

      //buat query
      $query = "INSERT INTO ". $table ." (".$attr." ) VALUES (".$var.")";
      echo $query,"<pre>",print_r($value),"</pre>";
      //run query
      try {
        $stmt = $this->sambungan->prepare($query);
        $hasil = $stmt->execute($value);
        return true;
      } catch (PDOException $e) {
        return false;
      }
    }

    /**
    ini fungsi untuk update table
    membutuhkan
    $table sebagai nama tabel,
    $val adalah array dari nilai yang ingin di UPDATE
    $kond adalah kondisi dari record yang akan diupdate

    mengembalikan true or false
    **/
    public function UPDATE($table,$val,$kol='',$kond){
      ## setting atribut
      if (!$kol) {
        $attr = $this->setColumn($kond);
      }
      else {
        $attr = ':'.$kol;
      }
      $isi = array($val);


      //buat query
      $query = "UPDATE ". $table ." SET ".$attr." WHERE " .$kond;


      //run query
      try {
        $stmt = $this->sambungan->prepare($query);
        $hasil = $stmt->execute($isi);
        return true;
      } catch (PDOException $e) {
        return false;
      }

    }

    /**
    ini fungsi untuk menghapus record
    **/
    public function DELETE($tabel,$kond='0=0'){
      $query = "DELETE FROM ". $tabel ." WHERE " .$kond;

      try{
        $stmt = $this->sambungan->query($query);
        if ($stmt) {
          $stmt->execute();
          return true;
        }
        else {
          return self::getMessage();
        }
      }
      catch(PDOException $e){
        die($e->getMessage());
      }
    }


/**
  fungsi getCol adalah fungsi untuk mendapatkan nama kolom dari tabel tertentu
  $tabel adalah nama tabel yang akan diambil nama kolomnya (atribut)
**/
    private function getCol($tabel){
      $stmt = "DESCRIBE ".$tabel;
      $r = $this->sambungan->query($stmt);
      $col = $r->fetchAll(PDO::FETCH_COLUMN);
      return $col;
    }
    public function setColumn($kond){
      $attr;
      //get unwanted column
      $a = trim($kond);
      $in = strcspn($a,'=');
      $b = substr($a,0,$in);

      //get all column
      $a = $this->getCol($table);
      //bersihkan column
      for ($i=0; $i < count($a); $i++) {
        if ($a[$i] == $b) {
          unset($a[$i]);
          $a = array_values($a);
        }
      }

      for ($i=0; $i < count($a) ; $i++) {
          $attr .= $a[$i]." = :".$a[$i];
          $isi[':'.$a[$i]] = $val[$i];
          if($i != count($a)-1){
              $attr .=" , ";
          }
      }

      return $isi;
    }

  }


 ?>
