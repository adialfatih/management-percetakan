<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prosesajax extends CI_Controller
{
  function __construct()
  {
      parent::__construct();
      $this->load->model('data_model');
      date_default_timezone_set("Asia/Jakarta");
  }
   
  function index(){
      echo "Not Index...";
  }

  function tesajax(){
    $kd = $this->input->post('kd');
    $kode = $this->data_model->get_byid('new_tb_pkg_list', ['no_roll'=>$kd]);
    if($kode->num_rows() == 1){
        echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
    } else {
        echo json_encode(array("statusCode"=>404, "psn"=>"failde"));
    }
    
  }//end

  function deletedata(){
        $table = $this->input->post('table', TRUE);
        $id = $this->input->post('id', TRUE);
        $tm = date('Y-m-d H:i:s');
        if($table=="userdata"){
            $nama_user = $this->data_model->get_byid('user_data',['id_user'=>$id])->row("nama_user");
            $this->db->query("DELETE FROM user_data WHERE id_user='$id'");
            echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil menghapus user"));
        } elseif($table=="pembelian_barang") {
            $cn1 = $this->data_model->get_byid('bahan_bantu_masuk',['code_input'=>$id])->num_rows();
            $cn2 = $this->data_model->get_byid('bahan_baku_masuk',['code_input'=>$id])->num_rows();
            $cn3 = intval($cn1) + intval($cn2);
            if($cn3 > 0){
                echo json_encode(array("statusCode"=>404, "psn"=>"Anda harus menghapus data pembelian barang terlebih dahulu.!"));
            } else {
                $this->db->query("DELETE FROM pembelian_barang WHERE code_input='$id'");
                echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil menghapus data pembelian barang"));
            }
        } elseif($table=="bahan_baku_masuk"){
            $dt = $this->data_model->get_byid('bahan_baku_masuk',['id_bbm'=>$id])->row_array();
            $kode_stok = $dt['jenis_barang']."-".$dt['nama_barang']."-".$dt['ukuran']."-".$dt['satuan_ukuran']."-".$dt['satuan_jumlah']."-".$dt['harga_satuan'];
            $nx = $dt['code_input'];
            $stok_awal = $this->data_model->get_byid('data_stok', ['kode_stok'=>$kode_stok])->row("jumlah_stok");
            $stok_akhir = $stok_awal - $dt['jumlah_masuk'];
            $this->data_model->updatedata('kode_stok', $kode_stok, 'data_stok', ['jumlah_stok'=>$stok_akhir]);
            $this->db->query("DELETE FROM bahan_baku_masuk WHERE id_bbm='$id'");
            echo json_encode(array("statusCode"=>201, "psn"=>"Berhasil menghapus data bahan baku", "psn2"=>$nx));
        } elseif($table=="bahan_bantu_masuk"){
            $dt = $this->data_model->get_byid('bahan_bantu_masuk',['id_bantuin'=>$id])->row_array();
            $kode_stok = $dt['nama_barang']."-".$dt['keterangan']."-".$dt['ukuran']."-".$dt['satuan_ukr']."-".$dt['satuan_jml']."-".$dt['harga_satuan'];
            $nx = $dt['code_input'];
            $stok_awal = $this->data_model->get_byid('data_stok', ['kode_stok'=>$kode_stok])->row("jumlah_stok");
            $stok_akhir = $stok_awal - $dt['jumlah'];
            $this->data_model->updatedata('kode_stok', $kode_stok, 'data_stok', ['jumlah_stok'=>$stok_akhir]);
            $this->db->query("DELETE FROM bahan_bantu_masuk WHERE id_bantuin='$id'");
            echo json_encode(array("statusCode"=>201, "psn"=>"Berhasil menghapus data bahan bantu", "psn2"=>$nx));
        } elseif($table=="pembayaran_nota"){
            $this->db->query("DELETE FROM pembayaran_nota WHERE id_pemby='$id'");
            echo json_encode(array("statusCode"=>202, "psn"=>"Berhasil menghapus pembayaran"));
        } elseif($table=="pembayaran_cus"){
            $this->db->query("DELETE FROM pembayaran_customer WHERE id_byrcus='$id'");
            echo json_encode(array("statusCode"=>202, "psn"=>"Berhasil menghapus pembayaran"));
        } elseif($table=="bahan_sparepart_masuk"){
            $dt = $this->data_model->get_byid('bahan_sparepart_masuk',['id_bantuin'=>$id])->row_array();
            $kode_stok = $dt['nama_barang']."-".$dt['keterangan']."-".$dt['ukuran']."-".$dt['satuan_ukr']."-".$dt['satuan_jml']."-".$dt['harga_satuan'];
            $nx = $dt['code_input'];
            $stok_awal = $this->data_model->get_byid('data_stok', ['kode_stok'=>$kode_stok])->row("jumlah_stok");
            $stok_akhir = $stok_awal - $dt['jumlah'];
            $this->data_model->updatedata('kode_stok', $kode_stok, 'data_stok', ['jumlah_stok'=>$stok_akhir]);
            $this->db->query("DELETE FROM bahan_sparepart_masuk WHERE id_bantuin='$id'");
            echo json_encode(array("statusCode"=>201, "psn"=>"Berhasil menghapus data sparepart", "psn2"=>$nx));
        } elseif($table=="pemakaian_bahan_baku"){
            $cekJumlahPakai = $this->data_model->get_byid('pemakaian_bahan_baku',['id_pakai'=>$id])->row_array();
            $kode_stok = $cekJumlahPakai['kode_stok'];
            $jumlah_pakai = $cekJumlahPakai['jumlah_pakai'];
            $stok_disistem = $this->data_model->get_byid('data_stok', ['kode_stok'=>$kode_stok])->row("jumlah_stok");
            $new_stok = floatval($stok_disistem) + floatval($jumlah_pakai);
            $this->data_model->updatedata('kode_stok', $kode_stok, 'data_stok', ['jumlah_stok'=>$new_stok]);
            $this->db->query("DELETE FROM pemakaian_bahan_baku WHERE id_pakai='$id'");
            echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil menghapus pemakaian bahan baku"));
        } elseif($table=="pemakaian_bahan_bantu"){
            $cekJumlahPakai = $this->data_model->get_byid('pemakaian_bahan_bantu',['id_pakai'=>$id])->row_array();
            $kode_stok = $cekJumlahPakai['kode_stok'];
            $jumlah_pakai = $cekJumlahPakai['jumlah_pakai'];
            $stok_disistem = $this->data_model->get_byid('data_stok', ['kode_stok'=>$kode_stok])->row("jumlah_stok");
            $new_stok = floatval($stok_disistem) + floatval($jumlah_pakai);
            $this->data_model->updatedata('kode_stok', $kode_stok, 'data_stok', ['jumlah_stok'=>$new_stok]);
            $this->db->query("DELETE FROM pemakaian_bahan_bantu WHERE id_pakai='$id'");
            echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil menghapus pemakaian bahan baku"));
        } elseif($table=="pemakaian_bahan_sparepart"){
            $cekJumlahPakai = $this->data_model->get_byid('pemakaian_bahan_sparepart',['id_pakai'=>$id])->row_array();
            $kode_stok = $cekJumlahPakai['kode_stok'];
            $jumlah_pakai = $cekJumlahPakai['jumlah_pakai'];
            $stok_disistem = $this->data_model->get_byid('data_stok', ['kode_stok'=>$kode_stok])->row("jumlah_stok");
            $new_stok = floatval($stok_disistem) + floatval($jumlah_pakai);
            $this->data_model->updatedata('kode_stok', $kode_stok, 'data_stok', ['jumlah_stok'=>$new_stok]);
            $this->db->query("DELETE FROM pemakaian_bahan_sparepart WHERE id_pakai='$id'");
            echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil menghapus pemakaian bahan baku"));
        } else {
            echo json_encode(array("statusCode"=>200, "psn"=>'Table tidak ditemukan'));
        }
        
  } //
  public function cariJenisBaku(){
        $data = trim($this->input->post('datas', TRUE));
        $load = $this->db->query("SELECT DISTINCT nama_barang FROM bahan_baku_masuk WHERE jenis_barang = '$data' ORDER BY nama_barang ASC");
        if($load->num_rows() > 0){
            $alldata = array();
            foreach($load->result() as $row){
                $alldata[] = $row->nama_barang;
            }
            echo json_encode(array("statusCode"=>200, "psn"=>$alldata));
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"failed"));
        }
        
  } //end
  public function cariJenisBaku2(){
    $data = trim($this->input->post('datas', TRUE));
    $data2 = trim($this->input->post('datas2', TRUE));
    $load = $this->db->query("SELECT * FROM bahan_baku_masuk WHERE jenis_barang = '$data' AND nama_barang='$data2' ORDER BY ukuran ASC");
    if($load->num_rows() > 0){
        $alldata = array();
        foreach($load->result() as $row){
            if(!in_array($row->ukuran, $alldata)){ $alldata[] = $row->ukuran; }
        }
        echo json_encode(array("statusCode"=>200, "psn"=>$alldata));
    } else {
        echo json_encode(array("statusCode"=>404, "psn"=>"failed"));
    }
    
} //end
  public function cariJenisBantu(){
        $data = trim($this->input->post('datas', TRUE));
        $load = $this->db->query("SELECT DISTINCT keterangan FROM bahan_bantu_masuk WHERE nama_barang = '$data' ORDER BY keterangan ASC");
        if($load->num_rows() > 0){
            $alldata = array();
            foreach($load->result() as $row){
                $alldata[] = $row->keterangan;
            }
            echo json_encode(array("statusCode"=>200, "psn"=>$alldata));
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"failed"));
        }
        
  } //end
  
  public function cariJenisBantu2(){
    $data = trim($this->input->post('datas', TRUE));
    $data2 = trim($this->input->post('datas2', TRUE));
    $load = $this->db->query("SELECT * FROM bahan_bantu_masuk WHERE nama_barang = '$data' AND keterangan='$data2' ORDER BY ukuran ASC");
    if($load->num_rows() > 0){
        $alldata = array();
        foreach($load->result() as $row){
            if(!in_array($row->ukuran, $alldata)){ $alldata[] = $row->ukuran; }
        }
        echo json_encode(array("statusCode"=>200, "psn"=>$alldata));
    } else {
        echo json_encode(array("statusCode"=>404, "psn"=>"failed"));
    }
    
} //end-
  
public function cariJenisSpare2(){
  $data = trim($this->input->post('datas', TRUE));
  $data2 = trim($this->input->post('datas2', TRUE));
  $load = $this->db->query("SELECT * FROM bahan_sparepart_masuk WHERE nama_barang = '$data' AND keterangan='$data2' ORDER BY ukuran ASC");
  if($load->num_rows() > 0){
      $alldata = array();
      foreach($load->result() as $row){
          if(!in_array($row->ukuran, $alldata)){ $alldata[] = $row->ukuran; }
      }
      echo json_encode(array("statusCode"=>200, "psn"=>$alldata));
  } else {
      echo json_encode(array("statusCode"=>404, "psn"=>"failed"));
  }
  
} //end-
  
public function cariJenisSpare(){
    $data = trim($this->input->post('datas', TRUE));
    $load = $this->db->query("SELECT DISTINCT keterangan FROM bahan_sparepart_masuk WHERE nama_barang = '$data' ORDER BY keterangan ASC");
    if($load->num_rows() > 0){
        $alldata = array();
        foreach($load->result() as $row){
            $alldata[] = $row->keterangan;
        }
        echo json_encode(array("statusCode"=>200, "psn"=>$alldata));
    } else {
        echo json_encode(array("statusCode"=>404, "psn"=>"failed"));
    }
  
} //end-cariJenisSpare
  function inputDataMasuk(){
        $codeInput = trim($this->input->post('codeInput', TRUE));
        $sj = trim($this->input->post('sj', TRUE));
        $sj = strtoupper($sj);
        $tanggalMasuk = trim($this->input->post('tanggalMasuk', TRUE));
        $namaSupplier = trim($this->input->post('namaSupplier', TRUE));
        $totalHarga2 = trim($this->input->post('totalHarga', TRUE));
        //$totalHarga = preg_replace('/[^0-9.]/', '', $totalHarga2);
        $cleaned_input = str_replace(",", "", $totalHarga2); // Hilangkan koma
        $totalHarga = (double) $cleaned_input; // Ubah ke tipe double
        $jenisBarang = trim($this->input->post('jenisBarang', TRUE));
        $namaBarang = trim($this->input->post('namaBarang', TRUE));
        $ukuranBarang = trim($this->input->post('ukuranBarang', TRUE));
        if($ukuranBarang==""){ $ukuranBarang = "NULL"; }
        $satuanUkuran = trim($this->input->post('satuanUkuran', TRUE));
        $jumlahBarang2 = trim($this->input->post('jumlahBarang', TRUE));
        $cleaned_input2 = str_replace(",", "", $jumlahBarang2); // Hilangkan koma
        $jumlahBarang = (double) $cleaned_input2; // Ubah ke tipe double
        $satuanJumlah = trim($this->input->post('satuanJumlah', TRUE));
        $prespajak = trim($this->input->post('prespajak', TRUE));
        $notaSementaraValue = trim($this->input->post('notaSementaraValue', TRUE));
        $hargaSatuanBarang2 = trim($this->input->post('hargaSatuanBarang', TRUE));
        //$hargaSatuanBarang = preg_replace('/[^0-9.]/', '', $hargaSatuanBarang2);
        $cleaned_input3 = str_replace(",", "", $hargaSatuanBarang2); // Hilangkan koma
        $hargaSatuanBarang = (double) $cleaned_input3; // Ubah ke tipe double
        $ketBarang = trim($this->input->post('ketBarang', TRUE));
        $tm = date('Y-m-d H:i:s');
        //if($codeInput!="" AND $sj!="" AND $tanggalMasuk!="" AND $namaSupplier!="" AND $totalHarga!="" AND $namaBarang!="" AND $ukuranBarang!="" AND $jumlahBarang!="" AND $satuanJumlah!="" AND $hargaSatuanBarang!="" AND $jenisBarang!=""){
            $cekin = $this->data_model->get_byid('pembelian_barang',['code_input'=>$codeInput])->num_rows();
            if($cekin == 0){
                $this->data_model->saved('pembelian_barang',['no_sj'=>$sj,'nama_supplier'=>strtoupper($namaSupplier),'total_nota'=>$totalHarga,'tgl_input'=>$tm,'code_input'=>$codeInput,'tgl_nota'=>$tanggalMasuk,'userlogin'=>$this->session->userdata('username'),'jenis_pembelian'=>'Bahan Baku','presentase_pajak'=>$prespajak,'nota_asli'=>$notaSementaraValue]);
            } elseif($cekin == 1) {
                $this->data_model->updatedata('code_input',$codeInput,'pembelian_barang',['no_sj'=>$sj,'nama_supplier'=>strtoupper($namaSupplier),'total_nota'=>$totalHarga,'tgl_nota'=>$tanggalMasuk,'presentase_pajak'=>$prespajak,'nota_asli'=>$notaSementaraValue]);
            }
            $dtlist = [
                'tgl_masuk' => $tanggalMasuk,
                'waktu_masuk' => date('Y-m-d H:i:s'),
                'jenis_barang' => strtoupper($jenisBarang),
                'nama_barang' => strtoupper($namaBarang),
                'ukuran' => strtoupper($ukuranBarang),
                'satuan_ukuran' => strtoupper($satuanUkuran),
                'jumlah_masuk' => strtoupper($jumlahBarang),
                'satuan_jumlah' => strtoupper($satuanJumlah),
                'supplier' => strtoupper($namaSupplier),
                'keterangan' => $keterangan=='' ? 'NULL': $keterangan,
                'diinput' => $this->session->userdata('username'),
                'harga_satuan' => $hargaSatuanBarang,
                'code_input' => $codeInput
            ];
            $cekinb = $this->data_model->get_byid('bahan_baku_masuk',$dtlist)->num_rows();
            if($cekinb==0){ 
                $this->data_model->saved('bahan_baku_masuk',$dtlist); 
                $kode_stok = 'Baku-'.$jenisBarang.'-'.$namaBarang.'-'.$ukuranBarang.'-'.$satuanUkuran.'-'.$satuanJumlah.'-'.$hargaSatuanBarang;
                $cekstok = $this->data_model->get_byid('data_stok',['kode_stok'=>$kode_stok]);
                if($cekstok->num_rows() == 0){
                    $this->data_model->saved('data_stok',['kode_stok'=>$kode_stok,'bahan'=>'Baku','jenis_bahan'=>$jenisBarang,'nama_bahan'=>$namaBarang,'ukuran'=>$ukuranBarang,'satuan_ukuran'=>$satuanUkuran,'satuan_jml'=>$satuanJumlah,'harga_satuan'=>$hargaSatuanBarang,'jumlah_stok'=>$jumlahBarang]);
                } else {
                    $jumlah_awal = $cekstok->row('jumlah_stok');
                    $jumlah_akhir = $jumlah_awal + $jumlahBarang;
                    $this->data_model->updatedata('kode_stok',$kode_stok,'data_stok',['jumlah_stok'=>$jumlah_akhir]);
                }
            }
            echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil menambahkan data."));
        // } else {
        //     echo json_encode(array("statusCode"=>404, "psn"=>"Anda tidak mengisi semua data dengan benar!!"));
        // }
  } //end
  function inputDataMasuk2(){
        $codeInput = trim($this->input->post('codeInput', TRUE));
        $sj = trim($this->input->post('sj', TRUE));
        $sj = strtoupper($sj);
        $tanggalMasuk = trim($this->input->post('tanggalMasuk', TRUE));
        $namaSupplier = trim($this->input->post('namaSupplier', TRUE));
        $totalHarga2 = trim($this->input->post('totalHarga', TRUE));
        $cleaned_input = str_replace(",", "", $totalHarga2); // Hilangkan koma
        $totalHarga = (double) $cleaned_input; // Ubah ke tipe double

        //$totalHarga = preg_replace('/[^0-9.]/', '', $totalHarga2);
        $jenisBarang = trim($this->input->post('jenisBarang', TRUE));
        $namaBarang = trim($this->input->post('namaBarang', TRUE));
        $ukuranBarang = trim($this->input->post('ukuranBarang', TRUE));
        $satuanUkuran = trim($this->input->post('satuanUkuran', TRUE));
        if($ukuranBarang==""){ $ukuranBarang = "NULL"; }
        $jumlahBarang2 = trim($this->input->post('jumlahBarang', TRUE));
        $cleaned_input3 = str_replace(",", "", $jumlahBarang2); // Hilangkan koma
        $jumlahBarang = (double) $cleaned_input3; // Ubah ke tipe double
        $satuanJumlah = trim($this->input->post('satuanJumlah', TRUE));
        $prespajak = trim($this->input->post('prespajak', TRUE));
        $notaSementaraValue = trim($this->input->post('notaSementaraValue', TRUE));
        $hargaSatuanBarang2 = trim($this->input->post('hargaSatuanBarang', TRUE));
        //$hargaSatuanBarang = preg_replace('/[^0-9.]/', '', $hargaSatuanBarang2);
        $cleaned_input2 = str_replace(",", "", $hargaSatuanBarang2); // Hilangkan koma
        $hargaSatuanBarang = (double) $cleaned_input2; // Ubah ke tipe double
        $ketBarang = trim($this->input->post('ketBarang', TRUE));
        $tm = date('Y-m-d H:i:s');
        $text2 = "(".$codeInput.")-(".$sj.")-(".$tanggalMasuk.")-(".$namaSupplier.")-(".$totalHarga.")-(".$namaBarang.")-(".$ukuranBarang.")-(".$jumlahBarang.")-(".$satuanJumlah.")-(".$hargaSatuanBarang.")-(".$jenisBarang.")";
        
        //if($codeInput!=""){
            $cekin = $this->data_model->get_byid('pembelian_barang',['code_input'=>$codeInput])->num_rows();
            if($cekin == 0){
                $this->data_model->saved('pembelian_barang',['no_sj'=>$sj,'nama_supplier'=>strtoupper($namaSupplier),'total_nota'=>$totalHarga,'tgl_input'=>$tm,'code_input'=>$codeInput,'tgl_nota'=>$tanggalMasuk,'userlogin'=>$this->session->userdata('username'),'jenis_pembelian'=>'Bahan Bantu','presentase_pajak'=>$prespajak,'nota_asli'=>$notaSementaraValue]);
            } elseif($cekin == 1) {
                $this->data_model->updatedata('code_input',$codeInput,'pembelian_barang',['no_sj'=>$sj,'nama_supplier'=>strtoupper($namaSupplier),'total_nota'=>$totalHarga,'tgl_nota'=>$tanggalMasuk,'presentase_pajak'=>$prespajak,'nota_asli'=>$notaSementaraValue]);
            }
            $dtlist = [
                'tgl_masuk' => $tanggalMasuk,
                'tgl_input' => date('Y-m-d H:i:s'),
                'nama_barang' => strtoupper($jenisBarang),
                'keterangan' => strtoupper($namaBarang),
                'ukuran' => strtoupper($ukuranBarang),
                'satuan_ukr' => strtoupper($satuanUkuran),
                'jumlah' => strtoupper($jumlahBarang),
                'satuan_jml' => strtoupper($satuanJumlah),
                'supplier_bnt' => strtoupper($namaSupplier),
                'ket' => $keterangan=='' ? 'NULL': $keterangan,
                'diinput' => $this->session->userdata('username'),
                'harga_satuan' => $hargaSatuanBarang,
                'code_input' => $codeInput
            ];
            $cekinb = $this->data_model->get_byid('bahan_bantu_masuk',$dtlist)->num_rows();
            if($cekinb==0){ 
                $this->data_model->saved('bahan_bantu_masuk',$dtlist); 
                $kode_stok = 'Bantu-'.$jenisBarang.'-'.$namaBarang.'-'.$ukuranBarang.'-'.$satuanUkuran.'-'.$satuanJumlah.'-'.$hargaSatuanBarang;
                $cekstok = $this->data_model->get_byid('data_stok',['kode_stok'=>$kode_stok]);
                if($cekstok->num_rows() == 0){
                    $this->data_model->saved('data_stok',['kode_stok'=>$kode_stok,'bahan'=>'Bantu','jenis_bahan'=>$jenisBarang,'nama_bahan'=>$namaBarang,'ukuran'=>$ukuranBarang,'satuan_ukuran'=>$satuanUkuran,'satuan_jml'=>$satuanJumlah,'harga_satuan'=>$hargaSatuanBarang,'jumlah_stok'=>$jumlahBarang]);
                } else {
                    $jumlah_awal = $cekstok->row('jumlah_stok');
                    $jumlah_akhir = $jumlah_awal + $jumlahBarang;
                    $this->data_model->updatedata('kode_stok',$kode_stok,'data_stok',['jumlah_stok'=>$jumlah_akhir]);
                }
            }
            echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil menambahkan data."));
        // } else {
        //     echo json_encode(array("statusCode"=>404, "psn"=>$text2));
        // }
  } //end
  function inputDataMasuk3(){
        $codeInput = trim($this->input->post('codeInput', TRUE));
        $sj = trim($this->input->post('sj', TRUE));
        $tanggalMasuk = trim($this->input->post('tanggalMasuk', TRUE));
        $namaSupplier = trim($this->input->post('namaSupplier', TRUE));
        $totalHarga2 = trim($this->input->post('totalHarga', TRUE));
        //$totalHarga = preg_replace('/[^0-9.]/', '', $totalHarga2);
        $cleaned_input = str_replace(",", "", $totalHarga2); // Hilangkan koma
        $totalHarga = (double) $cleaned_input; // Ubah ke tipe double
        $jenisBarang = trim($this->input->post('jenisBarang', TRUE));
        $namaBarang = trim($this->input->post('namaBarang', TRUE));
        $ukuranBarang = trim($this->input->post('ukuranBarang', TRUE));
        $satuanUkuran = trim($this->input->post('satuanUkuran', TRUE));
        $jumlahBarang2 = trim($this->input->post('jumlahBarang', TRUE));
        $cleaned_input2 = str_replace(",", "", $jumlahBarang2); // Hilangkan koma
        $jumlahBarang = (double) $cleaned_input2; // Ubah ke tipe double
        $satuanJumlah = trim($this->input->post('satuanJumlah', TRUE));
        $prespajak = trim($this->input->post('prespajak', TRUE));
        $notaSementaraValue = trim($this->input->post('notaSementaraValue', TRUE));
        $hargaSatuanBarang2 = trim($this->input->post('hargaSatuanBarang', TRUE));
        //$hargaSatuanBarang = preg_replace('/[^0-9.]/', '', $hargaSatuanBarang2);
        $cleaned_input3 = str_replace(",", "", $hargaSatuanBarang2); // Hilangkan koma
        $hargaSatuanBarang = (double) $cleaned_input3; // Ubah ke tipe double
        $ketBarang = trim($this->input->post('ketBarang', TRUE));
        $tm = date('Y-m-d H:i:s');
        $tipe_data = "$codeInput - $sj - $tanggalMasuk - $namaSupplier - $totalHarga - $namaBarang - $ukuranBarang - $jumlahBarang - $satuanJumlah - $hargaSatuanBarang - $jenisBarang";
        //if($codeInput!="" AND $sj!="" AND $tanggalMasuk!="" AND $namaSupplier!="" AND $totalHarga!="" AND $namaBarang!="" AND  $jumlahBarang!="" AND $satuanJumlah!="" AND $hargaSatuanBarang!="" AND $jenisBarang!=""){
            $cekin = $this->data_model->get_byid('pembelian_barang',['code_input'=>$codeInput])->num_rows();
            if($cekin == 0){
                $this->data_model->saved('pembelian_barang',['no_sj'=>$sj,'nama_supplier'=>strtoupper($namaSupplier),'total_nota'=>$totalHarga,'tgl_input'=>$tm,'code_input'=>$codeInput,'tgl_nota'=>$tanggalMasuk,'userlogin'=>$this->session->userdata('username'),'jenis_pembelian'=>'Sparepart','presentase_pajak'=>$prespajak,'nota_asli'=>$notaSementaraValue]);
            } elseif($cekin == 1) {
                $this->data_model->updatedata('code_input',$codeInput,'pembelian_barang',['no_sj'=>$sj,'nama_supplier'=>strtoupper($namaSupplier),'total_nota'=>$totalHarga,'tgl_nota'=>$tanggalMasuk,'presentase_pajak'=>$prespajak,'nota_asli'=>$notaSementaraValue]);
            }
            $dtlist = [
                'tgl_masuk' => $tanggalMasuk,
                'tgl_input' => date('Y-m-d H:i:s'),
                'nama_barang' => strtoupper($jenisBarang),
                'keterangan' => strtoupper($namaBarang),
                'ukuran' => strtoupper($ukuranBarang),
                'satuan_ukr' => strtoupper($satuanUkuran),
                'jumlah' => $jumlahBarang,
                'satuan_jml' => strtoupper($satuanJumlah),
                'supplier_bnt' => strtoupper($namaSupplier),
                'ket' => $keterangan=='' ? 'NULL': $keterangan,
                'diinput' => $this->session->userdata('username'),
                'harga_satuan' => $hargaSatuanBarang,
                'code_input' => $codeInput
            ];
            $cekinb = $this->data_model->get_byid('bahan_sparepart_masuk',$dtlist)->num_rows();
            if($cekinb==0){ 
                $this->data_model->saved('bahan_sparepart_masuk',$dtlist); 
                $kode_stok = 'Sparepart-'.strtoupper($jenisBarang).'-'.strtoupper($namaBarang).'-'.strtoupper($ukuranBarang).'-'.strtoupper($satuanUkuran).'-'.strtoupper($satuanJumlah).'-'.$hargaSatuanBarang;
                $cekstok = $this->data_model->get_byid('data_stok',['kode_stok'=>$kode_stok]);
                if($cekstok->num_rows() == 0){
                    $this->data_model->saved('data_stok',['kode_stok'=>$kode_stok,'bahan'=>'Sparepart','jenis_bahan'=>$jenisBarang,'nama_bahan'=>$namaBarang,'ukuran'=>$ukuranBarang,'satuan_ukuran'=>$satuanUkuran,'satuan_jml'=>$satuanJumlah,'harga_satuan'=>$hargaSatuanBarang,'jumlah_stok'=>$jumlahBarang]);
                } else {
                    $jumlah_awal = $cekstok->row('jumlah_stok');
                    $jumlah_akhir = $jumlah_awal + $jumlahBarang;
                    $this->data_model->updatedata('kode_stok',$kode_stok,'data_stok',['jumlah_stok'=>$jumlah_akhir]);
                }
            }
            echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil menambahkan data."));
        // } else {
        //     echo json_encode(array("statusCode"=>404, "psn"=>"Anda tidak mengisi semua data dengan benar,;-$tipe_data!!"));
        // }
  } //end

    function showTablePengiriman(){
        $id = trim($this->input->post('id', TRUE));
        $spare = trim($this->input->post('spare', TRUE));
        if($spare=="yes"){
            $load2 = $this->data_model->get_byid('bahan_sparepart_masuk',['code_input'=>$id]);
            $_name = "Sparepart";
        } else {
            $load2 = $this->data_model->get_byid('bahan_bantu_masuk',['code_input'=>$id]);
            $_name = "Bahan Bantu";
        }
        $load1 = $this->data_model->get_byid('bahan_baku_masuk',['code_input'=>$id]);
        $n1 = $load1->num_rows();
        $n2 = $load2->num_rows();
        $load3 = intval($n1) + intval($n2);
        if($load3 > 0){
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Stok</th>
                        <th>Jenis Barang</th>
                        <th>Nama Barang</th>
                        <th>Ukuran</th>
                        <th>Jumlah</th>
                        <th>Hapus</th>
                        <?=$spare=="yes" ? '<th>Pakai Langsung</th>':'';?>
                    </tr>
                </thead>
                <tbody>
            <?php $no=1;
            foreach($load1->result() as $val){
                $id_bbm = $val->id_bbm;
                if($val->ukuran=="NULL"){
                    $ukr = "";
                } else {
                    if($val->ukuran=="-"){
                        $ukr = "";
                    } else {
                        $ukr = $val->ukuran;
                    }
                }
                if($val->satuan_ukuran=="NULL"){
                    $satukr = "";
                } else {
                    $satukr = $val->satuan_ukuran;
                }
                echo "<tr>";
                echo "<td>".$no."</td>";
                echo "<td>BAHAN BAKU</td>";
                echo "<td>".$val->jenis_barang."</td>";
                echo "<td>".$val->nama_barang."</td>";
                echo "<td>".$ukr." ".$satukr."</td>";
                if (floor($val->jumlah_masuk) == $val->jumlah_masuk) {
                    echo "<td>".number_format($val->jumlah_masuk, 0, ',', '.')." ".$val->satuan_jumlah."</td>";
                } else {
                    echo "<td>".number_format($val->jumlah_masuk, 2, ',', '.')." ".$val->satuan_jumlah."</td>";
                }
                echo "<td>";
                $tx = $val->nama_barang." ".$val->ukuran." ".$val->satuan_ukuran."";
                ?><a href="javascript:void(0);" onclick="deletes('Bahan Baku','<?=$tx;?>','<?=$id_bbm;?>','bahan_baku_masuk')"><i class="material-symbols-rounded" style="color:red;cursor:pointer;">delete</i></a><?php
                echo "</td>";
                echo "</tr>";
                $no++;
            }
            foreach($load2->result() as $val){
                $id_bbm = $val->id_bantuin;
                $cek_checked = $this->data_model->get_byid('pemakaian_langsung',['id_bantuin'=>$id_bbm])->num_rows();
                if($val->ukuran=="NULL"){
                    $ukr = "";
                } else {
                    if($val->ukuran=="-"){
                        $ukr = "";
                    } else {
                        $ukr = $val->ukuran;
                        
                    }
                }
                if($val->satuan_ukr=="NULL"){
                    $satukr = "";
                } else {
                    $satukr = $val->satuan_ukr;
                }
                echo "<tr>";
                echo "<td>".$no."</td>";
                echo "<td>".$_name."</td>";
                echo "<td>".$val->nama_barang."</td>";
                echo "<td>".$val->keterangan."</td>";
                echo "<td>".$ukr." ".$satukr."</td>";
                if (floor($val->jumlah) == $val->jumlah) {
                    echo "<td>".number_format($val->jumlah, 0, ',', '.')." ".$val->satuan_jml."</td>";
                } else {
                    echo "<td>".number_format($val->jumlah, 2, ',', '.')." ".$val->satuan_jml."</td>";
                }
                echo "<td>";
                $tx = $val->keterangan." ".$val->ukuran." ".$satukr."";
                if($_name=="Sparepart"){
                ?><a href="javascript:void(0);" onclick="deletes('Sparepart','<?=$tx;?>','<?=$id_bbm;?>','bahan_sparepart_masuk')"><i class="material-symbols-rounded" style="color:red;cursor:pointer;">delete</i></a><?php
                } else {
                ?><a href="javascript:void(0);" onclick="deletes('Bahan Bantu','<?=$tx;?>','<?=$id_bbm;?>','bahan_bantu_masuk')"><i class="material-symbols-rounded" style="color:red;cursor:pointer;">delete</i></a><?php
                }
                if($spare=="yes"){
                    echo "<td>";
                    ?>
                    <input type="checkbox" onclick="pakailangsung(this, '<?=$id_bbm;?>')" name="pakai_langsung" id="pakai_langsung" value="<?=$id_bbm;?>" <?=$cek_checked==0 ?'':'checked';?>>
                    <label for="pakai_langsung">Pakai Langsung</label>
                    <?php
                    echo "</td>";
                }
                echo "</tr>";
                $no++;
            }
            echo "<tr><td colspan='8'></td></tr>";
            echo "</tbody>";
            echo "</table>";
        } //end if  
    } //end function 

    function ambilTotalHarga(){
            $id = trim($this->input->post('id', TRUE));
            $spare = trim($this->input->post('spare', TRUE));
            $load1 = $this->data_model->get_byid('bahan_baku_masuk',['code_input'=>$id]);
            if($spare=="yes"){
                $load2 = $this->data_model->get_byid('bahan_sparepart_masuk',['code_input'=>$id]);
            } else {
                $load2 = $this->data_model->get_byid('bahan_bantu_masuk',['code_input'=>$id]);
            }
            $total_harga = 0;
            if($load1->num_rows() > 0){
                foreach($load1->result() as $bal){
                    $jml = intval($bal->jumlah_masuk);
                    $harga = intval($bal->harga_satuan);
                    $jumlah_harga = $jml * $harga;
                    $total_harga = $total_harga + $jumlah_harga;
                }
            }
            if($load2->num_rows() > 0){
                foreach($load2->result() as $val){
                    $jml = intval($val->jumlah);
                    $harga = intval($val->harga_satuan);
                    $jumlah_harga = $jml * $harga;
                    $total_harga = $total_harga + $jumlah_harga;
                }
            }
            $this->data_model->updatedata('code_input',$id,'pembelian_barang',['total_nota'=>$total_harga]);
            echo json_encode(array("statusCode"=>200, "psn"=>$total_harga));
    } //end function 

    function lihatPembayaran(){
        $namaSupplier = trim($this->input->post('namaSupplier', TRUE));
        $tipeData = trim($this->input->post('tipeData', TRUE));
        //$cekPembayaran = $this->data_model->get_byid('pembayaran_nota',['nama_supplier'=>$namaSupplier,'jenis_pembelian'=>$tipeData]);
        $cekPembayaran = $this->db->query("SELECT * FROM pembayaran_nota WHERE nama_supplier='$namaSupplier' ORDER BY tgl_bayar DESC");
        if($cekPembayaran->num_rows() > 0){
            foreach($cekPembayaran->result() as $val){
                $id = $val->id_pemby;
                $tgl = $val->tgl_bayar;
                $jns = $val->jns_bayar;
                $ket = $val->keterangan;
                $tyx = "pembayaran sebesar Rp.".number_format($val->jumlah_bayar,0,',','.')."";
                $printTgl = date("d M Y", strtotime($tgl));
                $printTgl2 = date("d M Y H:i", strtotime($val->tgl_input));
                echo "<small style='font-size:12px;'>Tanggal : <strong>".$printTgl."</strong> Ke <strong>".$namaSupplier."</strong></small>";
                ?>
                <div style="width:100%;display:flex;gap:10px;justify-content:space-between;" id="sprid<?=$id;?>">
                    <div style="width:50%;display:flex;align-items:center;font-size:18px;gap:5px;">
                        <span class="material-symbols-rounded" style="color:#0c4da8;">local_atm</span>
                        <span style="color:#0c4da8;font-weight:bold;">Rp. <?=number_format($val->jumlah_bayar,0,',','.');?></span>
                    </div>
                    <div><a href="javascript:void(0);" onclick="deletes('Pembayaran','<?=$tyx;?>','<?=$id?>','pembayaran_nota')"><i class="material-symbols-rounded" style="color:red;cursor:pointer;">delete</i></a></div>
                </div>
                <div style="width:100%;display:flex;justify-content:space-between;border-bottom:2px solid #ccc;margin-bottom:10px;">
                    <div><strong><?=$jns;?></strong>, Keterangan : <?=$ket;?></div>
                    <div style="font-size:11px;">Di input Oleh : <strong><?=ucwords($val->diinput);?></strong>, <?=$printTgl2;?></div>
                </div>
                <?php
            }
        } else {
            echo "<font style='color:red;'>Belum ada riwayat pembayaran ke ".$namaSupplier."</font>";
        }
    }
    public function cariJenisStok(){
        $jenis = trim($this->input->post('jenis', TRUE));
        $tipeOut = trim($this->input->post('tipeOut', TRUE));
        if($tipeOut == "Sparepart"){
            $load = $this->db->query("SELECT * FROM data_stok WHERE bahan = 'Sparepart' AND jenis_bahan='$jenis' ORDER BY nama_bahan ASC");
        }
        if($tipeOut == "Bahan Baku"){
            $load = $this->db->query("SELECT * FROM data_stok WHERE bahan = 'Baku' AND jenis_bahan='$jenis' ORDER BY nama_bahan ASC");
        }
        if($tipeOut == "Bahan Bantu"){
            $load = $this->db->query("SELECT * FROM data_stok WHERE bahan = 'Bantu' AND jenis_bahan='$jenis' ORDER BY nama_bahan ASC");
        }
        if($load->num_rows() > 0){
            $alldata = array();
            foreach($load->result() as $row){
                if(!in_array($row->nama_bahan, $alldata)){ $alldata[] = $row->nama_bahan; }
            }
            echo json_encode(array("statusCode"=>200, "psn"=>$alldata));
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"failed"));
        }
    } //end-
    function cariJenisNamaStok(){
        $jenis = trim($this->input->post('jenis', TRUE));
        $tipeOut = trim($this->input->post('tipeOut', TRUE));
        $namaBahan = trim($this->input->post('namaBahan', TRUE));
        if($tipeOut == "Sparepart"){
            $load = $this->db->query("SELECT * FROM data_stok WHERE bahan = 'Sparepart' AND jenis_bahan='$jenis' AND nama_bahan='$namaBahan' ORDER BY ukuran ASC");
        }
        if($tipeOut == "Bahan Baku"){
            $load = $this->db->query("SELECT * FROM data_stok WHERE bahan = 'Baku' AND jenis_bahan='$jenis' AND nama_bahan='$namaBahan' ORDER BY ukuran ASC");
        }
        if($tipeOut == "Bahan Bantu"){
            $load = $this->db->query("SELECT * FROM data_stok WHERE bahan = 'Bantu' AND jenis_bahan='$jenis' AND nama_bahan='$namaBahan' ORDER BY ukuran ASC");
        }
        if($load->num_rows() > 0){
            $alldata = array();
            foreach($load->result() as $row){
                if(!in_array($row->ukuran, $alldata)){ $alldata[] = $row->ukuran; }
            }
            echo json_encode(array("statusCode"=>200, "psn"=>$alldata));
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"failed"));
        }
    } //end
    function cekTotalStok(){
        $jenis = trim($this->input->post('jenis', TRUE));
        $tipeOut = trim($this->input->post('tipeOut', TRUE));
        $namaBahan = trim($this->input->post('namaBahan', TRUE));
        $ukuranBahan = trim($this->input->post('ukuranBahan', TRUE));
        if($tipeOut == "Sparepart"){ $tipeData = "Sparepart"; }
        if($tipeOut == "Bahan Baku"){ $tipeData = "Baku"; }
        if($tipeOut == "Bahan Bantu"){ $tipeData = "Bantu"; }

        if($jenis != '' && $tipeOut != '' && $namaBahan != '' && $ukuranBahan != ''){
            $cekstok = $this->data_model->get_byid('data_stok',['bahan'=>$tipeData,'jenis_bahan'=>$jenis,'nama_bahan'=>$namaBahan,'ukuran'=>$ukuranBahan]);
            if($cekstok->num_rows() > 0){
                $notif = "";
                $total_stok = 0;
                foreach($cekstok->result() as $row){
                    $jumlah_stok = $row->jumlah_stok;
                    if($jumlah_stok > 0){
                        $notif .= "Sisa Stok = <strong>".number_format($jumlah_stok,0,',','.')."</strong><br>";
                        $total_stok += $jumlah_stok;
                    }
                }
                if($total_stok > 0){
                    echo json_encode(array("statusCode"=>200, "psn"=>$notif));
                } else {
                    echo json_encode(array("statusCode"=>404, "psn"=>"Stok Habis"));
                }
                
            } else {
                echo json_encode(array("statusCode"=>404, "psn"=>"Stok tidak ditemukan"));
            }
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"Anda perlu mengisi semua data"));
        }
    }
} //end of class