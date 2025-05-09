<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    
class Data extends CI_Controller
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
            echo 'Invalid token';
    } //end
   
    function data_produksi(){ 
        $_xses = explode(',',$this->session->userdata('hak'));
          $data = array(
              'title' => 'Data Produksi - Mitra Sahabat',
              'page' => 'Data / Produksi',
              'tipeTable' => 'baku',
              'showData' => 'produksi',
              'sess' => $this->session->userdata('hak')
          );
            $this->load->view('part/header', $data);
            if(in_array('Produksi',$_xses) OR in_array('SuperAdmin',$_xses) OR in_array('Penjualan',$_xses) OR in_array('Admin Keuangan',$_xses)){
                $this->load->view('page/view_produksi', $data);
            } else {
                $this->load->view('page/no_aksesview', $data);
            }
            $this->load->view('part/footer2', $data);
    } //end
    function biaya_listrik(){ 
        $_xses = explode(',',$this->session->userdata('hak'));
        $data = array(
            'title' => 'Keuangan - Biaya Listrik',
            'page' => 'Keuangan / Biaya Listrik',
            'tipeTable' => 'baku',
            'showData' => 'listrik'
        );
        $this->load->view('part/header', $data);
        if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/view_biayalistrik', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        $this->load->view('part/footer2', $data);
    } //end--
    function biaya_penyusutan(){ 
        $_xses = explode(',',$this->session->userdata('hak'));
        $data = array(
            'title' => 'Keuangan - Biaya Penyusutan',
            'page' => 'Keuangan / Biaya Penyusutan',
            'tipeTable' => 'baku',
            'showData' => 'penyusutan'
        );
        $this->load->view('part/header', $data);
        if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/view_biayapenyusutan', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        $this->load->view('part/footer2', $data);
    } //end--biaya_penyusutan-
    function biaya_cadanganthr(){ 
        $_xses = explode(',',$this->session->userdata('hak'));
        $data = array(
            'title' => 'Keuangan - Cadangan THR',
            'page' => 'Keuangan / Cadangan THR',
            'tipeTable' => 'baku',
            'showData' => 'thr'
        );
        $this->load->view('part/header', $data);
        if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/view_cadanganthr', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        $this->load->view('part/footer2', $data);
    } //end---biaya_cadanganthr-
    function biaya_manpower(){ 
        $_xses = explode(',',$this->session->userdata('hak'));
        $data = array(
            'title' => 'Keuangan - MAN Power',
            'page' => 'Keuangan / Man Power',
            'tipeTable' => 'baku',
            'showData' => 'manpower'
        );
        $this->load->view('part/header', $data);
        if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/view_manpower', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        $this->load->view('part/footer2', $data);
    } //end---biaya_manpower-
    function biaya_pemeliharaan(){ 
        $uri = $this->uri->segment(2);
        //echo $uri;
        if($uri == "biaya-pemeliharaan"){
            $thisData = "Pemeliharaan";
        } else {
            $thisData = "Lain-lain";
        }
        $_xses = explode(',',$this->session->userdata('hak'));
        $data = array(
            'title' => 'Keuangan - Biaya '.$thisData.'',
            'page' => 'Keuangan / Biaya '.$thisData.'',
            'tipeTable' => 'baku',
            'showData' => $thisData,
            'thisData' => $thisData
        );
        $this->load->view('part/header', $data);
        if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/view_biayapemeliharaan', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        $this->load->view('part/footer2', $data);
    } //end---biaya_pemeliharaan

    function datapenjualan(){
        $_xses = explode(',',$this->session->userdata('hak'));
        $data = array(
            'title' => 'Data Penjualan - Mitra Sahabat',
            'page' => 'Data / Penjualan',
            'tipeTable' => 'baku',
            'showData' => 'penjualan'
        );
        $this->load->view('part/header', $data);
        if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses) OR in_array('Penjualan',$_xses)){
            $this->load->view('page/view_penjualan', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        $this->load->view('part/footer2', $data);

    } //end

    function penjualan_input(){
        $_xses = explode(',',$this->session->userdata('hak'));
        $uri = $this->uri->segment(3);
        $cekuri = $this->data_model->get_byid('data_penjualan', ['code_penjualan'=>$uri]);
        if($cekuri->num_rows() == 1){
            $kode = $uri;
            $data_row = $cekuri->row_array();
        } else {
            $kode = $this->data_model->acakKode(15);
            $data_row = "null";
        }
        
        $data = array(
            'title' => 'Input Data Penjualan',
            'page' => 'Input / Penjualan',
            'showJenisBahanJadi' => $this->data_model->showJenisBahanJadi(),
            'showCustomer' => $this->data_model->showCustomer(),
            'customJS' => 'penjualan',
            'code_input' => $kode,
            'data_row' => $data_row
        );
        $this->load->view('part/header', $data);
        if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses) OR in_array('Penjualan',$_xses)){
            $this->load->view('page/input_penjualan', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        
        $this->load->view('part/footer2', $data);
    } //end

    function hutangcus(){
        $_xses = explode(',',$this->session->userdata('hak'));
        $uri = $this->uri->segment(3);
        $customer = $this->db->query("SELECT DISTINCT customer FROM data_penjualan ORDER BY customer ASC");
        $data = array(
            'title' => 'Piutang Customer - Mitra Sahabat',
            'page' => 'Data / Piutang',
            'customJS' => 'hutang',
            'code_input' => $kode,
            'data_row' => $customer
        );
        $this->load->view('part/header', $data);
        if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/hutang_customer', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        
        $this->load->view('part/footer', $data);
    } //end

    function hutangcusid(){
        $_xses = explode(',',$this->session->userdata('hak'));
        $uri = $this->uri->segment(3);
        $cus = $this->data_model->safe_base64_decode($uri);
        $customer = $this->data_model->get_spesifik('customer',$cus,'tgl_jual','data_penjualan');
        $total_bayar = $this->db->query("SELECT SUM(jumlah_bayar) AS ttl FROM pembayaran_customer WHERE nama_customer='$cus'")->row()->ttl;
        $data = array(
            'title' => 'Piutang Customer - '.$cus.'',
            'page' => 'Data / Piutang',
            'customJS' => 'hutang',
            'code_input' => $kode,
            'cus' => $cus,
            'data_row' => $customer,
            'total_bayar' => $total_bayar
        );
        $this->load->view('part/header', $data);
        if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses)){
            $this->load->view('page/hutang_customer2', $data);
        } else {
            $this->load->view('page/no_aksesview', $data);
        }
        
        $this->load->view('part/footer', $data);
    } //end

}
?>