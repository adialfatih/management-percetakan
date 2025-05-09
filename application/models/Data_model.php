<?php
class Data_model extends CI_Model{
 
  function delete($table,$key,$id){
    $this->db->where($key, $id);
    $this->db->delete($table);
  }
  function del_multi($table,$where){
    $this->db->where($where);
    $this->db->delete($table);
  }

  function saved($table, $datalist){
      //$this->db->insert($table,$datalist);
      if ($this->db->insert($table, $datalist)) {
        return true;
      } else {
          log_message('error', 'Insert failed: ' . $this->db->last_query());
          return false;
      }
  }


  function get_record($table){
     $result = $this->db->get($table);
     return $result;
  }
  
  function sort_record($key, $table){
     $this->db->order_by($key, 'DESC');
     $result = $this->db->get($table);
     return $result;
  }

  function get_view($table, $key, $limit){
    $this->db->limit($limit);
    $this->db->order_by($key, 'DESC');
    $result = $this->db->get($table);
    return $result;
  }
  
  function get_byid($table,$where){      
        return $this->db->get_where($table,$where);
  }

  function updatedata($key, $id, $table, $data){
    $this->db->where($key, $id);
    $this->db->update($table, $data);
  }

  function get_sum($field, $table){
    $this->db->select_sum($field);
    $result = $this->db->get($table);
    return $result;
  }
  function kosongke($table){
    $this->db->truncate($table);
  }
  
  function get_spesifik($key, $id, $sort,$table){
    $this->db->where($key, $id);
    $this->db->order_by($sort, 'ASC');
    $result = $this->db->get($table);
    return $result;
  }
  function get_jml($key){
    $this->db->where('jnslog', $key);
    $result = $this->db->get('log');
    return $result->num_rows();
  }
    
  function filter($data){
        $str_in = strip_tags(htmlspecialchars($data));
        $arrrays = array('~', "`", '!', '#', '$', '%', '^', '&', '*', '(', ')', '+', '=', '{', '[', ']', '}', '|', '\\', "'", '"', ':', ';', '<', '>', '?', "‘", '“',);
        $str = str_replace($arrrays, '', $str_in);
        return $str;
  }
  function clean($data){
        $str_in = strip_tags(htmlspecialchars($data));
        $arrrays = array('~', "`", '!', '#', '$', '%', '^', '&', '*', '(', ')', '-', '+', '=', '{', '[', ']', '}', '|', '\\', "'", '"', ':', ';', '<', ',', '>', '?', '/', "‘", '“', '.', '_', '@');
        $str = str_replace($arrrays, '', $str_in);
        return $str;
  }
  
  function acakKode($jml){
    return substr(str_shuffle(str_repeat($x='1234567890QWERTYUIOPLKJHGFDSAZXCVBNMqwertyuiopasdfghjklzxcvbnm', ceil($jml/strlen($x)) )),1,$jml);
  } //end
  function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = $this->penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . $this->penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . $this->penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim($this->penyebut($nilai));
		} else {
			$hasil = trim($this->penyebut($nilai));
		}     		
		return $hasil;
	}
  function showJenisBaku(){
      $data = $this->db->query("SELECT DISTINCT jenis_barang FROM bahan_baku_masuk ORDER BY jenis_barang ASC");
      return $data;
  }
  function showJenisBahanJadi(){
    $data = $this->db->query("SELECT DISTINCT jenis_produksi FROM input_produksi ORDER BY jenis_produksi ASC");
    return $data;
  }
  function showJenisBantu(){
      $data = $this->db->query("SELECT DISTINCT nama_barang FROM bahan_bantu_masuk ORDER BY nama_barang ASC");
      return $data;
  }
  function showJenisSparepart(){
      $data = $this->db->query("SELECT DISTINCT nama_barang FROM bahan_sparepart_masuk ORDER BY nama_barang ASC");
      return $data;
  }
  function get_tujuan($tipe){
      if($tipe=="bahanbaku"){
        $data = $this->db->query("SELECT DISTINCT tujuan_pakai FROM pemakaian_bahan_baku ORDER BY tujuan_pakai ASC");
      }
      if($tipe=="bahanbantu"){
        $data = $this->db->query("SELECT DISTINCT tujuan_pakai FROM pemakaian_bahan_bantu ORDER BY tujuan_pakai ASC");
      }
      if($tipe=="sparepart"){
        $data = $this->db->query("SELECT DISTINCT tujuan_pakai FROM pemakaian_bahan_sparepart ORDER BY tujuan_pakai ASC");
      }
      return $data;
  }
  function showSupplier($tipe){
      if($tipe=="all"){
        $data = $this->db->query("SELECT DISTINCT nama_supplier FROM pembelian_barang ORDER BY nama_supplier ASC");
      } else {
        $data = $this->db->query("SELECT DISTINCT nama_supplier FROM pembelian_barang WHERE jenis_pembelian='$tipe' ORDER BY nama_supplier ASC");
      }
      return $data;
  }
  function showCustomer(){
      $data = $this->db->query("SELECT DISTINCT customer FROM data_penjualan ORDER BY customer ASC");
      return $data;
  }
  function showSupplier2(){
      $data = $this->db->query("SELECT DISTINCT supplier FROM bahan_baku_masuk ORDER BY supplier ASC");
      return $data;
  }
  
  function safe_base64_encode($data) {
      $encoded = base64_encode($data);
      $encoded = str_replace(['+', '/', '='], ['-', '_', '~'], $encoded);
      return $encoded;
  }

  function safe_base64_decode($data) {
      $data = str_replace(['-', '_', '~'], ['+', '/', '='], $data);
      return base64_decode($data);
  }
  public function check_login($username, $password) {
    // Hindari SQL Injection dengan query binding
    $query = $this->db->get_where('user_data', ['username' => $username], 1);

    if ($query->num_rows() === 1) {
        $user = $query->row();

        // Verifikasi password menggunakan password_verify
        if (password_verify($password, $user->password)) {
            return $user;
        }
    }
    return false;
  }
  
}
?>