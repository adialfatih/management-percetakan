<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller
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
            'title' => 'Laporan Gain Loss - Mitra Sahabat',
            'page' => 'laporan'
        );
        $this->load->view('part/header', $data);
        $this->load->view('reports/gainloss_view', $data);
        $this->load->view('part/footer3', $data);
  } //end  
   
  function Laporan(){ 
        $data = array(
            'title' => 'Laporan Gain Loss - Mitra Sahabat',
            'page' => 'laporan'
        );
        $this->load->view('part/header', $data);
        $this->load->view('reports/reports_view', $data);
        $this->load->view('part/footer3', $data);
  } //end  

  function showDataReport(){
        $id = $this->input->post('id', TRUE);
        //echo $id;
        $thisMonth = date('m');
        $thisYear = date('Y');
        if($id=="0"){
            $showBulan = $thisYear.'-'.$thisMonth;
        } else {
            $showBulan = $id;
        }
        $bulanSebelumnya = date("Y-m", strtotime("$showBulan -1 month"));
        $jumlahHari = date("t", strtotime($showBulan . "-01"));
        //cek biaya listrik
        $cekListrik = $this->data_model->get_byid('input_listrik',['tahun_bln'=>$showBulan]);
        if($cekListrik->num_rows() == 1){
            $bayar_listrik = $cekListrik->row('biaya');
        } else {
            $cekListrik = $this->data_model->get_byid('input_listrik',['tahun_bln'=>$bulanSebelumnya]);
            $bayar_listrik = $cekListrik->row('biaya');
        }
        $listrik_harian = floatval($bayar_listrik) / floatval($jumlahHari);
        if(floor($listrik_harian)==$listrik_harian){
            $listrik_harian1 = number_format($listrik_harian,0,',','.');
        } else {
            $listrik_harian1 = number_format($listrik_harian,2,',','.');
        }
        //cek biaya penyusutan
        $cekSusut = $this->data_model->get_byid('input_penyusutan',['tahun_bln'=>$showBulan]);
        if($cekSusut->num_rows()==0){
            $biayaSusut = 0;
        } else {
            $biayaSusut2 = floatval($cekSusut->row('biaya_susut')) / floatval($jumlahHari);
            if(floor($biayaSusut2)==$biayaSusut2){
                $biayaSusut = number_format($biayaSusut,0,',','.');
            } else {
                $biayaSusut = number_format($biayaSusut,2,',','.');
            }
        }
        //cek biaya Cadangan THR
        $cekTHR = $this->data_model->get_byid('input_cadanganthr',['tahun_bln'=>$showBulan]);
        if($cekTHR->num_rows()==0){
            $biayaTHR = 0;
        } else {
            $cekTHR2 = floatval($cekTHR->row('biaya_thr')) / floatval($jumlahHari);
            if(floor($cekTHR2)==$cekTHR2){
                $biayaTHR = number_format($cekTHR2,0,',','.');
            } else {
                $biayaTHR = number_format($cekTHR2,2,',','.');
            }
        }
        //cek biaya MAN Power
        $cekManPower = $this->data_model->get_byid('input_manpower',['tahun_bln'=>$showBulan]);
        if($cekManPower->num_rows()==0){
            $biayaManPower = 0;
        } else {
            $cekManPower2 = floatval($cekManPower->row('biaya_man')) / floatval($jumlahHari);
            if(floor($cekManPower2)==$cekManPower2){
                $biayaManPower = number_format($cekManPower2,0,',','.');
            } else {
                $biayaManPower = number_format($cekManPower2,2,',','.');
            }
        }
        // Perulangan tanggal
        $akumulasi_gl = 0;
        for ($i = 1; $i <= $jumlahHari; $i++) {
            $tgl = date("Y-m-d", strtotime("$showBulan-$i"));
            $printTgl = date("d M Y", strtotime("$showBulan-$i"));

            //hitung pemakaian bahan baku
            $_bahan_baku = $this->db->query("SELECT jumlah_pakai,harga_satuan,tgl_pakai FROM pemakaian_bahan_baku WHERE tgl_pakai = '$tgl'");
            $total_nilai_baku=0;
            foreach($_bahan_baku->result() as $row){
                $total = floatval($row->jumlah_pakai) * floatval($row->harga_satuan);
                $total_nilai_baku += $total;
            }
            //hitung pemakaian bahan bantu
            $_bahan_bantu = $this->db->query("SELECT jumlah_pakai,harga_satuan,tgl_pakai FROM pemakaian_bahan_bantu WHERE tgl_pakai = '$tgl'");
            $total_nilai_bantu=0;
            foreach($_bahan_bantu->result() as $row){
                $total = floatval($row->jumlah_pakai) * floatval($row->harga_satuan);
                $total_nilai_bantu += $total;
            }
            //hitung pemakaian bahan sparepart
            $_bahan_sparepart = $this->db->query("SELECT jumlah_pakai,harga_satuan,tgl_pakai FROM pemakaian_bahan_sparepart WHERE tgl_pakai = '$tgl'");
            $total_nilai_sparepart=0;
            foreach($_bahan_sparepart->result() as $row){
                $total = floatval($row->jumlah_pakai) * floatval($row->harga_satuan);
                $total_nilai_sparepart += $total;
            }
            //hitung biaya pemeliharaan
            $hitungPemeliharaan = $this->db->query("SELECT SUM(nominal) AS jml FROM input_pemeliharaan WHERE tgl = '$tgl'")->row("jml");
            if(floatval($hitungPemeliharaan)>0){
                if(floor($hitungPemeliharaan)==$hitungPemeliharaan){
                    $hitungPemeliharaan2 = number_format($hitungPemeliharaan,0,',','.');
                } else {
                    $hitungPemeliharaan2 = number_format($hitungPemeliharaan,2,',','.');
                }
            } else {
                $hitungPemeliharaan2 = 0;
            }
            //hitung biaya lainlain
            $hitunglainlain = $this->db->query("SELECT SUM(nominal) AS jml FROM input_lainlain WHERE tgl = '$tgl'")->row("jml");
            if(floatval($hitunglainlain)>0){
                if(floor($hitunglainlain)==$hitunglainlain){
                    $hitunglainlain2 = number_format($hitunglainlain,0,',','.');
                } else {
                    $hitunglainlain2 = number_format($hitunglainlain,2,',','.');
                }
            } else {
                $hitunglainlain2 = 0;
            }
            //hitung penjualan
            $penjualan = $this->db->query("SELECT SUM(total_harga) AS jml FROM v_penjualan WHERE tgl_jual = '$tgl'")->row("jml");
            if(floatval($penjualan)>0){
                if(floor($penjualan)==$penjualan){
                    $penjualan2 = number_format($penjualan,0,',','.');
                } else {
                    $penjualan2 = number_format($penjualan,2,',','.');
                }
            } else {
                $penjualan2 = 0;
            }
            //hitung produksi
            $produksi = $this->db->query("SELECT SUM(harga_total) AS jml FROM input_produksi WHERE tgl_produksi = '$tgl'")->row("jml");
            if(floatval($produksi)>0){
                if(floor($produksi)==$produksi){
                    $produksi2 = number_format($produksi,0,',','.');
                } else {
                    $produksi2 = number_format($produksi,2,',','.');
                }
            } else {
                $produksi2 = 0;
            }
            $gain_loss = floatval($produksi) - floatval($penjualan);
            if(floor($gain_loss)==$gain_loss){
                $gain_loss2 = number_format($gain_loss,0,',','.');
            } else {
                $gain_loss2 = number_format($gain_loss,2,',','.');
            }
            $akumulasi_gl = $akumulasi_gl + $gain_loss;
            if(floor($akumulasi_gl)==$akumulasi_gl){
                $akumulasi_gl2 = number_format($akumulasi_gl,0,',','.');
            } else {
                $akumulasi_gl2 = number_format($akumulasi_gl,2,',','.');
            }
            echo "<tr>";
            echo "<td style='text-align:left;'>$printTgl</td>";
            echo "<td style='text-align:center;'>".$listrik_harian1."</td>";
            echo "<td style='text-align:center;'>".$total_nilai_baku."</td>";
            echo "<td style='text-align:center;'>".$total_nilai_bantu."</td>";
            echo "<td style='text-align:center;'>".$total_nilai_sparepart."</td>";
            echo "<td style='text-align:center;'>".$biayaSusut."</td>";
            echo "<td style='text-align:center;'>".$hitungPemeliharaan2."</td>";
            echo "<td style='text-align:center;'>".$biayaTHR."</td>";
            echo "<td style='text-align:center;'>".$biayaManPower."</td>";
            echo "<td style='text-align:center;'>".$hitunglainlain2."</td>";
            echo "<td style='text-align:center;'>".$penjualan2."</td>";
            echo "<td style='text-align:center;'>".$produksi2."</td>";
            echo "<td style='text-align:center;'>".$gain_loss2."</td>";
            echo "<td style='text-align:center;'>".$akumulasi_gl2."</td>";
            echo "</tr>";
        }
  } //end

  function simpannota(){
        $nosj = $this->input->post('nosj', TRUE);
        $nota = $this->input->post('nonota', TRUE);
        $tgl = $this->input->post('tglnota', TRUE);
        $pjk = $this->input->post('prepajak', TRUE);
        $ttl = $this->input->post('total_nota', TRUE);
        $idb = $this->input->post('idBarang', TRUE);
        $hrg = $this->input->post('hargaSatuan', TRUE);
        $jmlSatuan = $this->input->post('jmlSatuan', TRUE);
        $harga_salah=0;
        for ($i=0; $i <count($hrg) ; $i++) { 
            $thisharga = preg_replace('/[^0-9]/', '', $hrg[$i]);
            if(floatval($thisharga) > 0){} else {$harga_salah++;}
        }
        if($nosj!="" AND $nota!="" AND $tgl!="" AND $pjk!=""){
            if($harga_salah==0){
                $jmlsj = $this->data_model->get_byid('data_penjualan',['nosj'=>$nosj])->num_rows();
                if($jmlsj==1){
                    $this->data_model->updatedata('nosj',$nosj,'data_penjualan',['nonota'=>$nota,'presentase_pajak'=>$pjk,'tgl_nota'=>$tgl]);
                    for ($i=0; $i <count($hrg) ; $i++) { 
                        $thisharga = preg_replace('/[^0-9]/', '', $hrg[$i]);
                        $ttlThis = floatval($thisharga) * floatval($jmlSatuan[$i]);
                        $ttlThisround = round($ttlThis,2);
                        $this->data_model->updatedata('iddetil',$idb[$i],'data_penjualan_detil',['harga_satuan'=>$thisharga,'total_harga'=>$ttlThisround]);
                    }
                    $this->session->set_flashdata('success', 'Berhasil update nota '.$nota.'');
                    redirect(base_url('data/penjualan'));
                } else {
                    $this->session->set_flashdata('gagal', 'Surat Jalan Tidak Ditemukan');
                    redirect(base_url('data/penjualan'));
                }
                // echo $nosj."<br>";
                // echo $nota."<br>";
                // echo $tgl."<br>";
                // echo $pjk."<br>";
                // echo $ttl."<br>";
                // echo "<pre>";
                // print_r($idb);
                // echo "</pre>";
                // echo "<pre>";
                // print_r($hrg);
                // echo "</pre>";
                
            } else {
                $this->session->set_flashdata('gagal', 'Anda harus mengisi semua harga dengan benar!!');
                redirect(base_url('data/penjualan'));
            }
        } else {
            $this->session->set_flashdata('gagal', 'Anda tidak mengisi data dengan benar!!');
            redirect(base_url('data/penjualan'));
        }
  } //end

}
?>