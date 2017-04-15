<?php

  /**
    ini adalah kelas untuk sebuah surat, beberapa state yg digunakan
    nomor:
    tanggal:
    sifat:
    perihal:
    lampiran:
   */
  class SURAT {

    private $approved = false;
    private $annouced = false;
    private $launched = false;

    //properti surat
    private $no = 0;
    private $sifat = '';
    private $lamp = 0;
    private $hal = '';
    private $tanggal = '';
    private $status='';



    private $db = null;

    function __construct($no_id,$dba){
      $this->db = $dba;
      $prop = $this->db->SELECT('surat',"no_surat = ".$no_id);
      $this->no = $prop[0]['no_surat'];
      $this->sifat = $prop[0]['sifat'];
      $this->hal = $prop[0]['perihal'];
      $this->tanggal = $prop[0]['tanggal'];
      $this->status = $prop[0]['status'];

    }

    public function setApproval($value=''){
      $this->approved = TRUE;
      $tabel = 'surat';
      $val = 1;
      $kol = 'status';
      $syarat = 'no_surat = '.$this->no;
      $a = $this->db->UPDATE($tabel,$val,$kol,$syarat);

    }

    public function setAnnounce(){
      $this->annouced = TRUE;
      //update status
      $tabel = 'surat';
      $val = 2;
      $kol = 'status';
      $syarat = 'no_surat = '.$this->no;
      $a = $this->db->UPDATE($tabel,$val,$kol,$syarat);
    }

    public function setLaunched($value=''){
      $this->launched = TRUE;
      //update status
      $tabel = 'surat';
      $val = 3;
      $kol = 'status';
      $syarat = 'no_surat = '.$this->no;
      $a = $this->db->UPDATE($tabel,$val,$kol,$syarat);
    }


  }


 ?>
