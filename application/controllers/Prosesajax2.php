<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prosesajax2 extends CI_Controller
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
  function loadlistrik(){
    $prod = $this->data_model->sort_record('input_tgl', 'input_listrik');
      if($prod->num_rows() > 0){
        foreach ($prod->result() as $row) {
            $x = explode(' ', $row->input_tgl);
            $tgl = date("d M Y", strtotime($x[0]));
            $xtxt = "Hapus Listrik Bulan ".$row->tahun_bln."?";
            $xx = explode('-', $row->tahun_bln);
            $_tahun = $xx[0];
            $_bulan = $xx[1];
            $ar_bulan = ['01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'];
            echo "<tr>";
            echo "<td class='text-sm font-weight-normal' style='text-align:left;'>".$tgl."</td>";
            echo "<td class='text-sm font-weight-normal'>".$ar_bulan[$_bulan]."</td>";
            echo "<td class='text-sm font-weight-normal'>".$_tahun."</td>";
            echo "<td class='text-sm font-weight-normal'>Rp. ".number_format($row->biaya, 0, ",", ".")."</td>";
            echo "<td class='text-sm font-weight-normal'>";
            ?>
            <a href="javascript:void(0);" onclick="deletes('Listrik','<?=$row->id_listrik;?>','<?=$xtxt;?>')" title="Hapus Data" style="color:#bd0b0b;"><i class="material-symbols-rounded">delete</i></a>
            <?php
            echo "</td>";
            echo "</tr>";
        }
      } else {
        
      }
  } //end--
  function loadpenyusutan(){
    $prod = $this->data_model->sort_record('tgl_input', 'input_penyusutan');
      if($prod->num_rows() > 0){
        foreach ($prod->result() as $row) {
            $x = explode(' ', $row->tgl_input);
            $tgl = date("d M Y", strtotime($x[0]));
            $xtxt = "Hapus Susut Bulan ".$row->tahun_bln."?";
            $xx = explode('-', $row->tahun_bln);
            $_tahun = $xx[0];
            $_bulan = $xx[1];
            $ar_bulan = ['01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'];
            echo "<tr>";
            echo "<td class='text-sm font-weight-normal' style='text-align:left;'>".$tgl."</td>";
            echo "<td class='text-sm font-weight-normal'>".$ar_bulan[$_bulan]."</td>";
            echo "<td class='text-sm font-weight-normal'>".$_tahun."</td>";
            echo "<td class='text-sm font-weight-normal'>Rp. ".number_format($row->biaya_susut, 0, ",", ".")."</td>";
            echo "<td class='text-sm font-weight-normal'>";
            ?>
            <a href="javascript:void(0);" onclick="deletes('Penyusutan','<?=$row->id_penyusutan;?>','<?=$xtxt;?>')" title="Hapus Data" style="color:#bd0b0b;"><i class="material-symbols-rounded">delete</i></a>
            <?php
            echo "</td>";
            echo "</tr>";
        }
      } else {
        
      }
  } //end--loadpenyusutan
  function loadthr(){
    $prod = $this->data_model->sort_record('tgl_input', 'input_cadanganthr');
      if($prod->num_rows() > 0){
        foreach ($prod->result() as $row) {
            $x = explode(' ', $row->tgl_input);
            $tgl = date("d M Y", strtotime($x[0]));
            $xtxt = "Hapus Cadangan THR Bulan ".$row->tahun_bln."?";
            $xx = explode('-', $row->tahun_bln);
            $_tahun = $xx[0];
            $_bulan = $xx[1];
            $ar_bulan = ['01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'];
            echo "<tr>";
            echo "<td class='text-sm font-weight-normal' style='text-align:left;'>".$tgl."</td>";
            echo "<td class='text-sm font-weight-normal'>".$ar_bulan[$_bulan]."</td>";
            echo "<td class='text-sm font-weight-normal'>".$_tahun."</td>";
            echo "<td class='text-sm font-weight-normal'>Rp. ".number_format($row->biaya_thr, 0, ",", ".")."</td>";
            echo "<td class='text-sm font-weight-normal'>";
            ?>
            <a href="javascript:void(0);" onclick="deletes('Cadangan THR','<?=$row->id_thr;?>','<?=$xtxt;?>')" title="Hapus Data" style="color:#bd0b0b;"><i class="material-symbols-rounded">delete</i></a>
            <?php
            echo "</td>";
            echo "</tr>";
        }
      } else {
        
      }
  } //end--loadthr--
  function manpower(){
    $prod = $this->data_model->sort_record('tgl_input', 'input_manpower');
      if($prod->num_rows() > 0){
        foreach ($prod->result() as $row) {
            $x = explode(' ', $row->tgl_input);
            $tgl = date("d M Y", strtotime($x[0]));
            $xtxt = "Hapus Man Power Bulan ".$row->tahun_bln."?";
            $xx = explode('-', $row->tahun_bln);
            $_tahun = $xx[0];
            $_bulan = $xx[1];
            $ar_bulan = ['01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'];
            echo "<tr>";
            echo "<td class='text-sm font-weight-normal' style='text-align:left;'>".$tgl."</td>";
            echo "<td class='text-sm font-weight-normal'>".$ar_bulan[$_bulan]."</td>";
            echo "<td class='text-sm font-weight-normal'>".$_tahun."</td>";
            echo "<td class='text-sm font-weight-normal'>Rp. ".number_format($row->biaya_man, 0, ",", ".")."</td>";
            echo "<td class='text-sm font-weight-normal'>";
            ?>
            <a href="javascript:void(0);" onclick="deletes('Man Power','<?=$row->id_man;?>','<?=$xtxt;?>')" title="Hapus Data" style="color:#bd0b0b;"><i class="material-symbols-rounded">delete</i></a>
            <?php
            echo "</td>";
            echo "</tr>";
        }
      } else {
        
      }
  } //end--manpower--
  function loadpemeliharaan(){
    $id = trim($this->input->post('jenis', TRUE));
    if($id == "lain"){
        $prod = $this->data_model->sort_record('tgl', 'input_lainlain');
        if($prod->num_rows() > 0){
            foreach ($prod->result() as $row) {
                $x = explode(' ', $row->tgl);
                $tgl = date("d M Y", strtotime($x[0]));
                $xtxt = "Hapus Biaya Lain-lain ".$row->keterangan."?";
                echo "<tr>";
                echo "<td class='text-sm font-weight-normal' style='text-align:left;'>".$tgl."</td>";
                echo "<td class='text-sm font-weight-normal'>Rp. ".number_format($row->nominal, 0, ",", ".")."</td>";
                echo "<td class='text-sm font-weight-normal'>".$row->keterangan."</td>";
                echo "<td class='text-sm font-weight-normal'>".strtoupper($row->yginput)."</td>";
                echo "<td class='text-sm font-weight-normal'>";
                ?>
                <a href="javascript:void(0);" onclick="deletes('Lain-Lain','<?=$row->id_lainlain;?>','<?=$xtxt;?>')" title="Hapus Data" style="color:#bd0b0b;"><i class="material-symbols-rounded">delete</i></a>
                <?php
                echo "</td>";
                echo "</tr>";
            }
        } else {
            
        }
    } else {
        $prod = $this->data_model->sort_record('tgl', 'input_pemeliharaan');
        if($prod->num_rows() > 0){
            foreach ($prod->result() as $row) {
                $x = explode(' ', $row->tgl);
                $tgl = date("d M Y", strtotime($x[0]));
                $xtxt = "Hapus Biaya Pemeliharaan ".$row->keterangan."?";
                echo "<tr>";
                echo "<td class='text-sm font-weight-normal' style='text-align:left;'>".$tgl."</td>";
                echo "<td class='text-sm font-weight-normal'>Rp. ".number_format($row->nominal, 0, ",", ".")."</td>";
                echo "<td class='text-sm font-weight-normal'>".$row->keterangan."</td>";
                echo "<td class='text-sm font-weight-normal'>".strtoupper($row->yginput)."</td>";
                echo "<td class='text-sm font-weight-normal'>";
                ?>
                <a href="javascript:void(0);" onclick="deletes('Pemeliharaan','<?=$row->id_pemeliharaan;?>','<?=$xtxt;?>')" title="Hapus Data" style="color:#bd0b0b;"><i class="material-symbols-rounded">delete</i></a>
                <?php
                echo "</td>";
                echo "</tr>";
            }
        } else {
            
        }
      }
  } //end--loadpemeliharaan-
  function loadpenjualan2(){
    $_xd2 = explode(',',$this->session->userdata('hak'));
    //$prod = $this->data_model->sort_record('tgl_jual', 'data_penjualan');
    $prod = $this->db->query("SELECT * FROM data_penjualan WHERE nosj NOT LIKE '%SLDAWL%'");
      if($prod->num_rows() > 0){
        foreach ($prod->result() as $row) {
            //$x = explode(' ', $row->tgl_jual);
            $tgl = date("d M Y", strtotime($row->tgl_jual));
            $sj = $row->nosj;
            $cd = $row->code_penjualan;
            $nt = $row->nonota;
            //if($nt=="null"){ $nt="BELUM DIBUAT";}
            $pjk = $row->presentase_pajak;
            $cid_penjualand = $row->id_penjualan;
            $xtxt = "Hapus Penjualan Dengan Nomor Surat Jalan ".$sj."";
            $cek_barang = $this->data_model->get_byid('data_penjualan_detil',['code_penjualan'=>$cd]);
            if($cek_barang->num_rows()>0){
                if($cek_barang->num_rows() == 1){
                    $penjualan = $cek_barang->row("jenis_barang")."-".$cek_barang->row("nama_barang")."";
                    $total_harga = "Rp. ".number_format($cek_barang->row("total_harga"), 0, ",", ".");
                } elseif($cek_barang->num_rows() == 2) {
                    $penjualan1 = array(); $total_harga=0;
                    foreach($cek_barang->result() as $cal){
                        $penjualan1[] = $cal->jenis_barang."-".$cal->nama_barang;
                        $total_harga += $cal->total_harga;
                    }
                    $penjualan = implode(' dan ', $penjualan1);
                    $total_harga = "Rp. ".number_format($total_harga, 0, ",", ".");
                } else {
                    $penjualan1 = array(); $total_harga=0;
                    foreach($cek_barang->result() as $cal){
                        $penjualan1[] = $cal->jenis_barang."-".$cal->nama_barang;
                        $total_harga += $cal->total_harga;
                    }
                    $jumlah_ar = count($penjualan1);
                    $tampilkan = $jumlah_ar - 1;
                    $penjualan = $penjualan1[0]." dan ".$tampilkan." lainnya";
                    $total_harga = "Rp. ".number_format($total_harga, 0, ",", ".");
                }
            } else {
                $penjualan = "<font style='color:red;'>Tidak Ada Pengiriman</font>";
                $total_harga = "Rp. 0";
            }
            echo "<tr>";
            echo "<td class='text-sm font-weight-normal' style='text-align:left;'>".$tgl."</td>";
            echo "<td class='text-sm font-weight-normal'>".$sj."</td>";
            echo "<td class='text-sm font-weight-normal'>".$row->customer."</td>";
            echo "<td class='text-sm font-weight-normal'>".$penjualan."</td>";
            if(in_array('Admin Keuangan',$_xd2) OR in_array('SuperAdmin',$_xd2)){
            echo "<td class='text-sm font-weight-normal'>".$total_harga."</td>";
            if($nt=="null"){
            ?>
            <td class="text-sm font-weight-normal">
                <a href="javascript:void(0);" style="color:red;font-weight:bold;" onclick="changeNota('<?=$cd;?>')">
                BELUM DIBUAT</a>
            </td>
            <?php
            } else {
            echo "<td class='text-sm font-weight-normal'>".$nt."</td>";
            }
            }
            echo "<td class='text-sm font-weight-normal'>";
            ?>
            <a href="<?=base_url('input/penjualan/'.$cd);?>" style="color:#0c7d2a;" title="Lihat Selengkapnya"><i class="material-symbols-rounded">open_in_new</i></a>
            <a href="javascript:void(0);" onclick="deletes('Data Penjualan','<?=$cd;?>','<?=$xtxt;?>')" title="Hapus Data" style="color:#bd0b0b;"><i class="material-symbols-rounded">delete</i></a>
            
            <?php
            echo "</td>";
            echo "</tr>";
        }
      } else {
        
      }
  } //end--loadpenjualan-
  function loadPenjualanHarga(){
      $id = trim($this->input->post('id', TRUE));
      $total = $this->db->query("SELECT SUM(total_harga) AS jml FROM data_penjualan_detil WHERE code_penjualan='$id'")->row("jml");
      $nominal = number_format($total,0,',','.');
      echo $nominal;
  }
  function loadproduksi(){
      $_xses = explode(',',$this->session->userdata('hak'));
      $prod = $this->data_model->sort_record('tgl_produksi', 'input_produksi');
      if($prod->num_rows() > 0){
        foreach ($prod->result() as $row) {
            $tgl = date("d M Y", strtotime($row->tgl_produksi));
            $xtxt = "Hapus Produksi tanggal ".$tgl."?";
            $_jml = floatval($row->jumlah);
            $_terjual = floatval($row->terjual);
            $sisa_stok = $_jml - $_terjual;
            if($sisa_stok<0){ $sisa_stok = 0; }
            if($row->produksi==""){$produksi = "-"; } else { $produksi = $row->produksi; }
            if($row->jenis_produksi==""){$produksi2 = "-"; } else { $produksi2 = $row->jenis_produksi; }
            echo "<tr>";
            echo "<td class='text-sm font-weight-normal' style='text-align:left;'>".$tgl."</td>";
            echo "<td class='text-sm font-weight-normal'>".strtoupper($produksi2)."</td>";
            echo "<td class='text-sm font-weight-normal'>".strtoupper($produksi)."</td>";
            echo "<td class='text-sm font-weight-normal'>".number_format($sisa_stok, 0, ",", ".")."</td>";
            if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses)){
            echo "<td class='text-sm font-weight-normal'>Rp. ".number_format($row->harga_satuan, 0, ",", ".")."</td>";
            echo "<td class='text-sm font-weight-normal'>Rp. ".number_format($row->harga_total,0, ",", ".")."</td>";
            }
            echo "<td class='text-sm font-weight-normal'>";
            ?>
            <a href="javascript:void(0);" onclick="editdt('<?=$row->idproduksi;?>','<?=strtoupper($produksi);?>','<?=$row->jumlah;?>','<?=$row->harga_satuan;?>','<?=$row->tgl_produksi;?>','<?=strtoupper($produksi2);?>')" title="Edit Data" style="color:#0b65bf;"><i class="material-symbols-rounded">edit_note</i></a>
            <a href="javascript:void(0);" onclick="deletes('Produksi','<?=$row->idproduksi;?>','<?=$xtxt;?>')" title="Hapus Data" style="color:#bd0b0b;"><i class="material-symbols-rounded">delete</i></a>
            <?php
            echo "</td>";
            echo "</tr>";
        }
      } else {
        echo "";
      }
  } //

  function deletedata(){
      $tipeData = trim($this->input->post('tipe', TRUE));
      $id = trim($this->input->post('id', TRUE));
      if($tipeData=="Produksi"){
          $this->data_model->delete('input_produksi','idproduksi',$id);
          echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil hapus data produksi"));
      }
      if($tipeData=="Listrik"){
          $this->data_model->delete('input_listrik','id_listrik',$id);
          echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil hapus data pembayaran Listrik"));
      }
      if($tipeData=="Penyusutan"){
          $this->data_model->delete('input_penyusutan','id_penyusutan',$id);
          echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil hapus data penyusutan"));
      }
      if($tipeData=="Pemeliharaan"){
          $this->data_model->delete('input_pemeliharaan','id_pemeliharaan',$id);
          echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil hapus data pemeliharaan"));
      }//Lain-Lain
      if($tipeData=="Lain-Lain"){
        $this->data_model->delete('input_lainlain','id_lainlain',$id);
        echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil hapus data lain-lain"));
    }//
      if($tipeData=="Cadangan THR"){
          $this->data_model->delete('input_cadanganthr','id_thr',$id);
          echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil hapus cadangan THR"));
      }
      if($tipeData=="Man Power"){
          $this->data_model->delete('input_manpower','id_man',$id);
          echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil hapus data man power"));
      }
      if($tipeData=="Penjualan"){
          $ot = $this->data_model->get_byid('data_penjualan_detil',['iddetil'=>$id])->row_array();
          $jns = $ot['jenis_barang'];
          $nma = $ot['nama_barang'];
          $jml = $ot['jumlah_jual'];
          $hrg = $ot['harga_satuan'];
          $cek = $this->data_model->get_byid('input_produksi',['jenis_produksi'=>$jns,'produksi'=>$nma,'harga_satuan'=>$hrg]);
          $jmlkembali = intval($jml);
          foreach($cek->result() as $val){
              $idproduksi = $val->idproduksi;
              $terjual = $val->terjual;
              if($jmlkembali > 0){
                if($jmlkembali >= $terjual){
                    $this->data_model->updatedata('idproduksi',$idproduksi,'input_produksi',['terjual'=>0]);
                    $jmlkembali = $jmlkembali - $terjual;
                } else {
                    $newTerjual = $terjual - $jmlkembali;
                    $this->data_model->updatedata('idproduksi',$idproduksi,'input_produksi',['terjual'=>$newTerjual]);
                    $jmlkembali = 0;
                }
                
              }
          }
          $this->data_model->delete('data_penjualan_detil','iddetil',$id);
          echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil hapus data barang keluar"));
      }
      if($tipeData=="Data Penjualan"){
          $cek = $this->data_model->get_byid('data_penjualan_detil',['code_penjualan'=>$id]);
          if($cek->num_rows() == 0){
              $this->data_model->delete('data_penjualan','code_penjualan',$id);
              echo json_encode(array("statusCode"=>200, "psn"=>"Berhasil hapus data penjualan"));
          } else {
              echo json_encode(array("statusCode"=>503, "psn"=>"Anda harus menghapus data barang yang di kirim terlebih dahulu."));
          }
      }
  } //end
  
  public function cariJenisBarangJadi(){
    $data = trim($this->input->post('datas', TRUE));
    $load = $this->db->query("SELECT * FROM input_produksi WHERE jenis_produksi = '$data' ORDER BY produksi ASC");
    if($load->num_rows() > 0){
        $alldata = array();
        foreach($load->result() as $row){
            if(!in_array($row->produksi, $alldata)){ $alldata[] = $row->produksi; }
        }
        echo json_encode(array("statusCode"=>200, "psn"=>$alldata));
    } else {
        echo json_encode(array("statusCode"=>404, "psn"=>"failed"));
    }
    
  } //end-
  function simpanPenjualan(){
      $userlogin = $this->session->userdata('username');
      $det = date('Y-m-d H:i:s');
      $sj = trim($this->input->post('sj', TRUE));
      $tanggalKirim = trim($this->input->post('tanggalKirim', TRUE));
      $customer = trim($this->input->post('customer', TRUE));
      $nama_customer = strtoupper($customer);
      $jenisBarang = trim($this->input->post('jenisBarang', TRUE));
      $namaBarang = trim($this->input->post('namaBarang', TRUE));
      $jumlahBarang2 = trim($this->input->post('jumlahBarang', TRUE));
      $jumlahBarang = preg_replace('/[^0-9.]/', '', $jumlahBarang2);
      $ketBarang = trim($this->input->post('ketBarang', TRUE));
      $codeInput = trim($this->input->post('codeInput', TRUE));
      $cekstok = $this->data_model->get_byid('input_produksi',['jenis_produksi'=>$jenisBarang,'produksi'=>$namaBarang]);
      $_allStok = 0; $_allID = array(); $error_harga = 0;
      $cekSJ = $this->data_model->get_byid('data_penjualan',['nosj'=>strtoupper($sj)])->num_rows();
      foreach($cekstok->result() as $val){
          $jumlah_stok = $val->jumlah;
          $terjual = $val->terjual;
          $harga_satuan = $val->harga_satuan;
          //if($harga_satuan<1){ $error_harga++; }
          $sisa_stok = $jumlah_stok - $terjual;
          if($sisa_stok>0){ $_allID[] = $val->idproduksi; }
          $_allStok += $sisa_stok;
      }
      if($sj!="" AND $tanggalKirim!="" AND $customer!="" AND $jenisBarang!="" AND $namaBarang!="" AND $jumlahBarang!="" AND $jumlahBarang>0){
        if($_allStok >= $jumlahBarang){
          if($error_harga==0){
            
                $dtlist = [
                'tgl_jual'        =>$tanggalKirim,
                'tgl_input'       =>$det,
                'code_penjualan'  =>$codeInput,
                'yg_jual'         =>$userlogin,
                'customer'        =>$nama_customer,
                'nosj'            =>strtoupper($sj)
                ];
                $ceksj = $this->data_model->get_byid('data_penjualan',['code_penjualan'=>$codeInput])->num_rows();
                if($ceksj==0){
                    $this->data_model->saved('data_penjualan', $dtlist);
                } else {
                    $dtlist = [
                    'tgl_jual'    =>$tanggalKirim,
                    'customer'    =>$nama_customer,
                    'nosj'        =>strtoupper($sj)
                    ];
                    $this->data_model->updatedata('code_penjualan',$codeInput,'data_penjualan', $dtlist);
                }
                sort($_allID);
                $im = implode(",", $_allID);
                $thisquery = $this->db->query("SELECT * FROM input_produksi WHERE idproduksi IN ($im) ORDER BY idproduksi ASC");
                $harus_jual = $jumlahBarang;
                foreach($thisquery->result() as $row){
                    $idproduksi = $row->idproduksi;
                    $jumlah = $row->jumlah;
                    $harga_satuan = $row->harga_satuan;
                    $terjual = $row->terjual;
                    $sisa_stok = $jumlah - $terjual;
                    if($harus_jual>0){
                    if($sisa_stok > 0){
                        if($harus_jual >= $sisa_stok){
                            $newterjual = $terjual + $sisa_stok;
                            $this->data_model->updatedata('idproduksi',$idproduksi,'input_produksi',['terjual'=>$newterjual]);
                            $total_harga_input = $sisa_stok * $harga_satuan;
                            $newlist = [
                                'code_penjualan'  =>$codeInput,
                                'jenis_barang'    =>$jenisBarang,
                                'nama_barang'     =>$namaBarang,
                                'jumlah_jual'     =>$sisa_stok,
                                'harga_satuan'    =>$harga_satuan,
                                'total_harga'     =>$total_harga_input,
                                'tgljual'         =>$tanggalKirim
                            ];
                            $this->data_model->saved('data_penjualan_detil',$newlist);
                            $harus_jual = $harus_jual - $sisa_stok;
                        } else {
                            $newterjual = $terjual + $harus_jual;
                            $this->data_model->updatedata('idproduksi',$idproduksi,'input_produksi',['terjual'=>$newterjual]);
                            $total_harga_input = $harus_jual * $harga_satuan;
                            $newlist = [
                                'code_penjualan'  =>$codeInput,
                                'jenis_barang'    =>$jenisBarang,
                                'nama_barang'     =>$namaBarang,
                                'jumlah_jual'     =>$harus_jual,
                                'harga_satuan'    =>$harga_satuan,
                                'total_harga'     =>$total_harga_input,
                                'tgljual'         =>$tanggalKirim
                            ];
                            $this->data_model->saved('data_penjualan_detil',$newlist);
                            $harus_jual = 0;
                        }
                    }
                    }
                } //end foreach
                echo json_encode(array("statusCode"=>200, "psn"=>"Menyimpan Data Penjualan"));
            
          } else {
              echo json_encode(array("statusCode"=>404, "psn"=>"Data produksi belum memiliki harga satuan."));
          }
        } else {
            echo json_encode(array("statusCode"=>404, "psn"=>"Stok barang tidak mencukupi"));
        }
      } else {
          echo json_encode(array("statusCode"=>404, "psn"=>"Anda harus mengisi data dengan benar!!"));
      }
  } //end

  function loadPenjualan(){
      $id = trim($this->input->post('id', TRUE));
      $_xses = explode(',',$this->session->userdata('hak'));
      $cek = $this->data_model->get_byid('data_penjualan_detil',['code_penjualan'=>$id]);
      if($cek->num_rows() > 0){
          ?>
          <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Jenis Barang</th>
                  <th>Nama Barang</th>
                  <th>Jumlah Kirim</th>
                  <?php if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses)){?>
                  <th>Harga Satuan</th>
                  <th>Harga Total</th>
                  <?php } ?>
                  <th>#</th>
                </tr>
              </thead>
              <tbody>
                    <?php
          $no=1;
          foreach($cek->result() as $num){
            $iddetil = $num->iddetil;
            $txt = "Hapus Pengeluaran ".$num->jenis_barang." - ".$num->nama_barang." sejumlah ".number_format($num->jumlah_jual,0, ',', '.')."";
          ?>    
                  <tr>
                      <td><?=$no++;?></td>
                      <td><?=$num->jenis_barang;?></td>
                      <td><?=$num->nama_barang;?></td>
                      <td><?=number_format($num->jumlah_jual,0, ',', '.');?></td>
                      <?php if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses)){?>
                      <td>Rp. <?=number_format($num->harga_satuan,0, ',', '.');?></td>
                      <td>Rp. <?=number_format($num->total_harga,0, ',', '.');?></td>
                      <?php } ?>
                      <td><a href="javascript:;" onclick="deletes('Penjualan','<?=$iddetil;?>','<?=$txt;?>')"><i class="material-symbols-rounded" style="color:red;">delete</i></a></td>
                  </tr>
          <?php
          }
                    ?>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <?php if(in_array('Admin Keuangan',$_xses) OR in_array('SuperAdmin',$_xses)){?>
                      <td></td>
                      <td></td>
                      <?php } ?>
                      <td></td>
                    </tr>
              </tbody>
          </table>
          <?php
      } else {
          echo "";
      }
  } //

  function lihatBayarCus(){
      $idcs = trim($this->input->post('id', TRUE));
      //echo $id;
      $cekPembayaran = $this->db->query("SELECT * FROM pembayaran_customer WHERE nama_customer='$idcs' ORDER BY tgl_bayar DESC");
        if($cekPembayaran->num_rows() > 0){
            foreach($cekPembayaran->result() as $val){
                $id = $val->id_byrcus;
                $tgl = $val->tgl_bayar;
                $jns = $val->jns_bayar;
                $ket = $val->keterangan;
                $tyx = "pembayaran customer sebesar Rp.".number_format($val->jumlah_bayar,0,',','.')."";
                $printTgl = date("d M Y", strtotime($tgl));
                $printTgl2 = date("d M Y H:i", strtotime($val->tgl_simpan));
                echo "<small style='font-size:12px;'>Tanggal : <strong>".$printTgl."</strong> Dari <strong>".$idcs."</strong></small>";
                ?>
                <div style="width:100%;display:flex;gap:10px;justify-content:space-between;" id="sprid<?=$id;?>">
                    <div style="width:50%;display:flex;align-items:center;font-size:18px;gap:5px;">
                        <span class="material-symbols-rounded" style="color:#0c4da8;">local_atm</span>
                        <span style="color:#0c4da8;font-weight:bold;">Rp. <?=number_format($val->jumlah_bayar,0,',','.');?></span>
                    </div>
                    <div><a href="javascript:void(0);" onclick="deletes('Pembayaran','<?=$tyx;?>','<?=$id?>','pembayaran_cus')"><i class="material-symbols-rounded" style="color:red;cursor:pointer;">delete</i></a></div>
                </div>
                <div style="width:100%;display:flex;justify-content:space-between;border-bottom:2px solid #ccc;margin-bottom:10px;">
                    <div><strong><?=$jns;?></strong>, Keterangan : <?=$ket;?></div>
                    <div style="font-size:11px;">Di input Oleh : <strong><?=ucwords($val->diinput);?></strong>, <?=$printTgl2;?></div>
                </div>
                <?php
            }
        } else {
            echo "<font style='color:red;'>Belum ada riwayat pembayaran dari ".$idcs."</font>";
        }
  } //end 

  function cariNota(){
        $id = trim($this->input->post('id', TRUE));
        $nota = $this->data_model->get_byid('pembelian_barang',['id_pembelian'=>$id]);
        if($nota->num_rows() == 1){
            $nota = $nota->row_array();
            $sj = $nota['no_sj'];
            $tgl = $nota['tgl_nota'];
            $nonota = $nota['nonota'];
            $ttl = $nota['total_nota'];
            if(floor($ttl) == $ttl){
                $total_nota = number_format($ttl,0,',','.');
            } else {
                $total_nota = number_format($ttl,2,',','.');
            }
            echo json_encode(array("statusCode"=>200, "sj"=>$sj, "tgl"=>$tgl, "ttl"=>$total_nota,"nonota"=>$nonota));
        } else {
            echo json_encode(array("statusCode"=>500, "psn"=>"Nota Tidak Ditemukan"));
        }
  } //end

  function showDataPenjualan(){
      $id = trim($this->input->post('code', TRUE));
      $cek = $this->data_model->get_byid('data_penjualan',['code_penjualan'=>$id]);
      if($cek->num_rows()==1){
            $nosj = $cek->row("nosj");
            $nonota = $cek->row("nonota");
            $tgl_nota = $cek->row("tgl_nota");
            $prespajak = $cek->row("presentase_pajak");
            $cek_datajual = $this->data_model->get_byid('data_penjualan_detil',['code_penjualan'=>$id])->result();
            echo json_encode(array("statusCode"=>200, "sj"=>$nosj,"nonota"=>$nonota,"tglnota"=>$tgl_nota, "pajak"=>$prespajak,"ar"=>$cek_datajual));
      } else {
            echo json_encode(array("statusCode"=>500, "psn"=>"ID Penjualan tidak ditemukan!!"));
      }
  }
  
}