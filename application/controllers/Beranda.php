<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller
{
  function __construct()
  {
      parent::__construct();
      $this->load->model('data_model');
      date_default_timezone_set("Asia/Jakarta");
      if (!$this->session->userdata('user_id')) {
        redirect('login');
      }
  }
   
  function index(){ 
        $data = array(
            'title' => 'Dashboard - Mitra Sahabat',
            'page' => 'Dashboard'
        );
        $this->load->view('part/header', $data);
        $this->load->view('beranda_view', $data);
        $this->load->view('part/footer', $data);
  } //end  
  function userdata(){
    $_xses = explode(',',$this->session->userdata('hak'));
    
        $data = array(
            'title' => 'Management User Data',
            'page' => 'Management / User Data',
            'datatbl' => $this->data_model->get_record('user_data'),
            'setupdata' => 'yes'
        );
        $this->load->view('part/header', $data);
        if(in_array('SuperAdmin',$_xses)){
            $this->load->view('page/user_view', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        $this->load->view('part/footer', $data);
    
  } //end
  function bakuin(){
    $_xses = explode(',',$this->session->userdata('hak'));
        $data = array(
            'title' => 'Data Masuk - Bahan Baku',
            'page' => 'Bahan Baku / Masuk',
            'inData' => $this->data_model->sort_record('tgl_masuk', 'bahan_baku_masuk'),
            'tipeTable' => 'baku'
        );
        $this->load->view('part/header', $data);
        if(in_array('Bahan Baku',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/bahan_bakuin', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        $this->load->view('part/footer', $data);
  } //end
  function baku_input(){
        $uri = $this->uri->segment(3);
        $cekuri = $this->data_model->get_byid('pembelian_barang', ['code_input'=>$uri]);
        if($cekuri->num_rows() == 1){
            $kode = $uri;
            $data_row = $cekuri->row_array();
        } else {
            $kode = $this->data_model->acakKode(15);
            $data_row = "null";
        }
        
        $data = array(
            'title' => 'Input Data Masuk - Bahan Baku',
            'page' => 'Pembelian / Bahan Baku',
            'jenisBaku' => $this->data_model->showJenisBaku(),
            'jenisBantu' => $this->data_model->showJenisBantu(),
            'showSupplier' => $this->data_model->showSupplier('Bahan Baku'),
            'customJS' => 'bakuinput',
            'code_input' => $kode,
            'data_row' => $data_row
        );
        $this->load->view('part/header', $data);
        $this->load->view('page/bahan_bakuin_input', $data);
        $this->load->view('part/footer', $data);
  } //end
  function bantu_input(){
        $uri = $this->uri->segment(3);
        $cekuri = $this->data_model->get_byid('pembelian_barang', ['code_input'=>$uri]);
        if($cekuri->num_rows() == 1){
            $kode = $uri;
            $data_row = $cekuri->row_array();
        } else {
            $kode = $this->data_model->acakKode(15);
            $data_row = "null";
        }
        
        $data = array(
            'title' => 'Input Data Masuk - Bahan Bantu',
            'page' => 'Pembelian / Bahan Bantu',
            'jenisBaku' => $this->data_model->showJenisBaku(),
            'jenisBantu' => $this->data_model->showJenisBantu(),
            'showSupplier' => $this->data_model->showSupplier('Bahan Bantu'),
            'customJS' => 'bakuinput',
            'code_input' => $kode,
            'data_row' => $data_row
        );
        $this->load->view('part/header', $data);
        $this->load->view('page/bahan_bantu_input', $data);
        $this->load->view('part/footer', $data);
  } //end
  function spare_input(){
        $uri = $this->uri->segment(3);
        $cekuri = $this->data_model->get_byid('pembelian_barang', ['code_input'=>$uri]);
        if($cekuri->num_rows() == 1){
            $kode = $uri;
            $data_row = $cekuri->row_array();
        } else {
            $kode = $this->data_model->acakKode(15);
            $data_row = "null";
        }
        
        $data = array(
            'title' => 'Input Data Masuk - Sparepart',
            'page' => 'Pembelian / Sparepart',
            'jenisSparepart' => $this->data_model->showJenisSparepart(),
            'showSupplier' => $this->data_model->showSupplier('Sparepart'),
            'customJS' => 'bakuinput2',
            'code_input' => $kode,
            'data_row' => $data_row,
            'spareinput' => 'yes'
        );
        $this->load->view('part/header', $data);
        $this->load->view('page/bahan_sparepart_input', $data);
        $this->load->view('part/footer', $data);
  } //end
  function bantuin(){
    $_xses = explode(',',$this->session->userdata('hak'));
        $data = array(
            'title' => 'Data Masuk - Bahan Bantu',
            'page' => 'Bahan Bantu / Masuk',
            'inData' => $this->data_model->sort_record('tgl_masuk', 'bahan_bantu_masuk'),
            'tipeTable' => 'baku'
        );
        $this->load->view('part/header', $data);
        if(in_array('Bahan Baku',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/bahan_bantuin', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        $this->load->view('part/footer', $data);
  } //end-
  function sparepartin(){
    $_xses = explode(',',$this->session->userdata('hak'));
        $data = array(
            'title' => 'Data Masuk - Sparepart',
            'page' => 'Sparepart / Masuk',
            'inData' => $this->data_model->sort_record('tgl_masuk', 'bahan_sparepart_masuk'),
            'tipeTable' => 'baku'
        );
        $this->load->view('part/header', $data);
        if(in_array('Bahan Baku',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/spare_partin', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        
        $this->load->view('part/footer', $data);
  } //end-sparepartin
  function bakuimport(){
        $data = array(
            'title' => 'Import Data Bahan Baku Masuk',
            'page' => 'Bahan Baku / Masuk'
        );
        $this->load->view('part/header', $data);
        $this->load->view('page/bakuimport', $data);
        $this->load->view('part/footer', $data);
  } //end
  function penerimaan_barang(){
        $_xses = explode(',',$this->session->userdata('hak'));
        $uri = $this->uri->segment(2);
        if($uri == "bahan-baku"){ $tipeuri = "Bahan Baku"; $txuri="bahan-baku"; }
        if($uri == "bahan-bantu"){ $tipeuri = "Bahan Bantu"; $txuri="bahan-bantu"; }
        if($uri == "sparepart"){ $tipeuri = "Sparepart"; $txuri="sparepart"; }
        $data = array(
            'title' => 'Nota Pembelian '.$tipeuri.'',
            'page' => 'Pembelian / '.$tipeuri.'',
            'txuri' => $txuri,
            'tipeuri' => $tipeuri,
            //'inData' => $this->data_model->get_byid('pembelian_barang',['jenis_pembelian'=>$tipeuri]),
            'inData' => $this->db->query("SELECT * FROM pembelian_barang WHERE jenis_pembelian='$tipeuri' AND code_input NOT LIKE '%SLDAWL%' ORDER BY tgl_nota DESC")
        );
        $this->load->view('part/header', $data);
        if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/penerimaan_baku_view', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        $this->load->view('part/footer', $data);
  } //end-
  function nota_penerimaan_barang(){
        $_xses = explode(',',$this->session->userdata('hak'));
        $data = array(
            'title' => 'Nota Pembelian ',
            'page' => 'Nota / Pembelian',
            //'inData' => $this->data_model->sort_record('tgl_nota','pembelian_barang'),
            'inData' => $this->db->query("SELECT * FROM pembelian_barang WHERE code_input NOT LIKE '%SLDAWL%' ORDER BY tgl_nota DESC"),
            'tipeTable' => 'baku'
        );
        $this->load->view('part/header', $data);
        if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/penerimaan_baku_view2', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        $this->load->view('part/footer', $data);
  } //end-
  function stok_baku(){
        $_xses = explode(',',$this->session->userdata('hak'));
        $data = array(
            'title' => 'Data Stok Bahan Baku',
            'page' => 'Stok / Bahan Baku',
            'inData' => $this->data_model->get_byid('data_stok', ['bahan'=>'Baku'])
        );
        $this->load->view('part/header', $data);
        if(in_array('Bahan Baku',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/stok_bahan', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        $this->load->view('part/footer', $data);
  } //end-stok_baku
  function stok_bantu(){
        $_xses = explode(',',$this->session->userdata('hak'));
        $data = array(
            'title' => 'Data Stok Bahan Bantu',
            'page' => 'Stok / Bahan Bantu',
            'inData' => $this->data_model->get_byid('data_stok', ['bahan'=>'Bantu'])
        );
        $this->load->view('part/header', $data);
        if(in_array('Bahan Bantu',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/stok_bahan', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        $this->load->view('part/footer', $data);
  } //end-stok_baku
  function stok_sparepart(){
    $_xses = explode(',',$this->session->userdata('hak'));
        $data = array(
            'title' => 'Data Stok Sparepart',
            'page' => 'Stok / Sparepart',
            'inData' => $this->data_model->get_byid('data_stok', ['bahan'=>'Sparepart'])
        );
        $this->load->view('part/header', $data);
        if(in_array('Sparepart',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/stok_bahan', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        $this->load->view('part/footer', $data);
  } //end-stok_baku
  function nota_tagihan(){
    $_xses = explode(',',$this->session->userdata('hak'));
        $uri = $this->uri->segment(2);
        if($uri == "bahan-baku"){ $tipeuri = "Bahan Baku"; $tipeid = 1; }
        if($uri == "bahan-bantu"){ $tipeuri = "Bahan Bantu"; $tipeid = 2; }
        if($uri == "sparepart"){ $tipeuri = "Sparepart"; $tipeid = 3; }
        if($uri == "all"){ $tipeuri = "all"; $tipeid = 4; }
        if($uri == "supplier"){ $tipeuri = "all"; $tipeid = 4; }
        $data = array(
            'title' => 'Nota Tagihan Penerimaan',
            'page' => 'Nota / Tagihan / '.$tipeuri.'',
            'page2' => 'Nota / Tagihan',
            'inData' => $this->data_model->showSupplier($tipeuri),
            'tipe_data' => 'all',
            'tipeid' => $tipeid
        );
        $this->load->view('part/header', $data);
        if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/nota_tagihan_view', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        
        $this->load->view('part/footer', $data);
  } //end-stok_baku
  function nota_tagihanid(){
    $_xses = explode(',',$this->session->userdata('hak'));
        $uri = $this->uri->segment(3);
        $tipeid = $this->uri->segment(4);
        //echo $uri."<br>";
        $nama_supplier = $this->data_model->safe_base64_decode($uri);
        //echo $nama_supplier;
        if($tipeid == 1){ 
            $tipetext = "Bahan Baku";
            $cek = $this->data_model->get_byid('pembelian_barang', ['nama_supplier'=>$nama_supplier,'jenis_pembelian'=>'Bahan Baku','nota_asli'=>'Ya']); 
        } elseif($tipeid == 2){ 
            $tipetext = "Bahan Bantu";
            $cek = $this->data_model->get_byid('pembelian_barang', ['nama_supplier'=>$nama_supplier,'jenis_pembelian'=>'Bahan Bantu','nota_asli'=>'Ya']);
        } elseif($tipeid == 3){
            $tipetext = "Sparepart";
            $cek = $this->data_model->get_byid('pembelian_barang', ['nama_supplier'=>$nama_supplier,'jenis_pembelian'=>'Sparepart','nota_asli'=>'Ya']);
        } else {
            $tipetext = "Semua";
            $cek = $this->data_model->get_byid('pembelian_barang', ['nama_supplier'=>$nama_supplier,'nota_asli'=>'Ya']);
        }
        $data = array(
            'title' => 'Nota Tagihan Penerimaan Bahan',
            'page' => 'Nota / Tagihan / '.$tipetext.'',
            'page2' => 'Nota / Tagihan',
            'inData' => $cek,
            'tipe_data' => $nama_supplier,
            'tipeid' => $tipeid,
            'tipetext' => $tipetext,
            'modalDoble' => 'yes'
        );
        $this->load->view('part/header', $data);
        if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/nota_tagihan_view', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        $this->load->view('part/footer', $data);
  } //end-stok_baku

  function bahan_keluar(){
        $uri1 = $this->uri->segment(1);
        $uri2 = $this->uri->segment(2);
        //echo $uri1."<br>";
        if($uri1 == "bahan-baku"){ 
            $uri3 = "Bahan Baku"; 
            $table_view = "pemakaian_bahan_baku";
            $tujuan_pakai = $this->data_model->get_tujuan('bahanbaku');
            $jenis_bahan = $this->db->query("SELECT DISTINCT jenis_bahan FROM data_stok WHERE bahan='Baku'");
        }
        if($uri1 == "bahan-bantu"){ 
            $uri3 = "Bahan Bantu"; 
            $table_view = "pemakaian_bahan_bantu";
            $tujuan_pakai = $this->data_model->get_tujuan('bahanbantu');
            $jenis_bahan = $this->db->query("SELECT DISTINCT jenis_bahan FROM data_stok WHERE bahan='Bantu'");
        }
        if($uri1 == "sparepart"){ 
            $uri3 = "Sparepart"; 
            $table_view = "pemakaian_bahan_sparepart";
            $tujuan_pakai = $this->data_model->get_tujuan('sparepart');
            $jenis_bahan = $this->db->query("SELECT DISTINCT jenis_bahan FROM data_stok WHERE bahan='Sparepart'");
        }
        $_xses = explode(',',$this->session->userdata('hak'));
        //echo $uri2;
        $data = array(
            'title' => 'Data Pemakaian - '.$uri3.'',
            'page' => 'Pemakaian / '.$uri3.'',
            'uri3' => $uri3,
            'inData' => $this->data_model->sort_record('tgl_pakai', $table_view),
            'tipeTable' => 'baku',
            'tujuan_pakai' => $tujuan_pakai,
            'jenis' => $jenis_bahan,
            'table_view' => $table_view,
            'customJS' => 'pemakaianbahan'
        );
        $this->load->view('part/header', $data);
        if(in_array('Sparepart',$_xses) OR in_array('SuperAdmin',$_xses) OR in_array('Bahan Baku',$_xses) OR in_array('Bahan Bantu',$_xses) OR in_array('Admin Keuangan',$_xses)){
            $this->load->view('page/view_pemakaian', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        
        $this->load->view('part/footer', $data);
  }//end

}
?>