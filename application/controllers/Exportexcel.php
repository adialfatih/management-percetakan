<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Exportexcel extends CI_Controller {
public function __construct(){
    parent::__construct();
    $this->load->model('data_model');
    date_default_timezone_set("Asia/Jakarta");
}
public function index(){
    $this->load->view('spreadsheet');
}
    function rekap(){
        $st = $this->uri->segment(3);
        
        $thisMonth = date('m');
        $thisYear = date('Y');
        if($st==""){
            $showBulan = $thisYear.'-'.$thisMonth;
        } else {
            $showBulan = $st;
        }
        $filename = "Laporan Gain Loss-".$showBulan."";
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
            $biayaSusut5 = 0;
        } else {
            $biayaSusut2 = floatval($cekSusut->row('biaya_susut')) / floatval($jumlahHari);
            if(floor($biayaSusut2)==$biayaSusut2){
                $biayaSusut = number_format($biayaSusut,0,',','.');
                
            } else {
                $biayaSusut = number_format($biayaSusut,2,',','.');
            }
            $biayaSusut5 = $biayaSusut2;
        }
        //cek biaya Cadangan THR
        $cekTHR = $this->data_model->get_byid('input_cadanganthr',['tahun_bln'=>$showBulan]);
        if($cekTHR->num_rows()==0){
            $biayaTHR = 0;
            $biayaTHR5 = 0;
        } else {
            $cekTHR2 = floatval($cekTHR->row('biaya_thr')) / floatval($jumlahHari);
            if(floor($cekTHR2)==$cekTHR2){
                $biayaTHR = number_format($cekTHR2,0,',','.');
            } else {
                $biayaTHR = number_format($cekTHR2,2,',','.');
            }
            $biayaTHR5 = $cekTHR2;
        }
        //cek biaya MAN Power
        $cekManPower = $this->data_model->get_byid('input_manpower',['tahun_bln'=>$showBulan]);
        if($cekManPower->num_rows()==0){
            $biayaManPower = 0;
            $biayaManPower5 = 0;
        } else {
            $cekManPower2 = floatval($cekManPower->row('biaya_man')) / floatval($jumlahHari);
            if(floor($cekManPower2)==$cekManPower2){
                $biayaManPower = number_format($cekManPower2,0,',','.');
            } else {
                $biayaManPower = number_format($cekManPower2,2,',','.');
            }
            $biayaManPower5 = $cekManPower2;
        }
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('B2:P2');
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        $style_row2 = [
            'font' => [
                'bold' => true, // Set font jadi bold
                'color' => ['rgb' => 'FF0000'] // Set warna font menjadi merah
            ],
            'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        $style_row3 = [
            'font' => [
                'bold' => true, // Set font jadi bold
                'color' => ['rgb' => '1D8207'] // Set warna font menjadi hijau
            ],
            'alignment' => [
            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
            'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
            'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
            'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
            'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        $sheet->setCellValue('B2', $filename); // Set kolom A1 
        //$sheet->setCellValue('C2', "".$nama_cus.""); // Set kolom A1 
        $sheet->setCellValue('B4', "NO"); // Set kolom A1 
        $sheet->setCellValue('C4', "TANGGAL"); // Set kolom A1 
        $sheet->setCellValue('D4', "LISTRIK"); // Set kolom A1 
        $sheet->setCellValue('E4', "BAHAN BAKU"); // Set kolom A1 
        $sheet->setCellValue('F4', "BAHAN BANTU"); // Set kolom A1 
        $sheet->setCellValue('G4', "SPAREPART"); // Set kolom A1 
        $sheet->setCellValue('H4', "SUSUT INVEST"); // Set kolom A1 
        $sheet->setCellValue('I4', "BIAYA PEMELIHARAAN"); // Set kolom A1 
        $sheet->setCellValue('J4', "CADANGAN THR"); // Set kolom A1 
        $sheet->setCellValue('K4', "MAN POWER"); // Set kolom A1 
        $sheet->setCellValue('L4', "BIAYA LAIN-LAIN"); // Set kolom A1 
        $sheet->setCellValue('M4', "PENGELUARAN"); // Set kolom A1 
        $sheet->setCellValue('N4', "PRODUKSI"); // Set kolom A1 
        $sheet->setCellValue('O4', "GL"); // Set kolom A1 
        $sheet->setCellValue('P4', "AKM G/L"); // Set kolom A1 
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);
        $sheet->getColumnDimension('L')->setAutoSize(true);
        $sheet->getColumnDimension('M')->setAutoSize(true);
        $sheet->getColumnDimension('N')->setAutoSize(true);
        $sheet->getColumnDimension('O')->setAutoSize(true);
        $sheet->getColumnDimension('P')->setAutoSize(true);
        $sheet->getStyle('B4')->applyFromArray($style_col);
        $sheet->getStyle('C4')->applyFromArray($style_col);
        $sheet->getStyle('D4')->applyFromArray($style_col);
        $sheet->getStyle('E4')->applyFromArray($style_col);
        $sheet->getStyle('F4')->applyFromArray($style_col);
        $sheet->getStyle('G4')->applyFromArray($style_col);
        $sheet->getStyle('H4')->applyFromArray($style_col);
        $sheet->getStyle('I4')->applyFromArray($style_col);
        $sheet->getStyle('J4')->applyFromArray($style_col);
        $sheet->getStyle('K4')->applyFromArray($style_col);
        $sheet->getStyle('L4')->applyFromArray($style_col);
        $sheet->getStyle('M4')->applyFromArray($style_col);
        $sheet->getStyle('N4')->applyFromArray($style_col);
        $sheet->getStyle('O4')->applyFromArray($style_col);
        $sheet->getStyle('P4')->applyFromArray($style_col);
        // Perulangan tanggal
        $akumulasi_gl = 0;
        $NUMROW = 5;
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
                $hitungPemeliharaan5 = 0;
            } else {
                $hitungPemeliharaan2 = 0;
                $hitungPemeliharaan5 = $hitungPemeliharaan;
            }
            //hitung biaya lainlain
            $hitunglainlain = $this->db->query("SELECT SUM(nominal) AS jml FROM input_lainlain WHERE tgl = '$tgl'")->row("jml");
            if(floatval($hitunglainlain)>0){
                if(floor($hitunglainlain)==$hitunglainlain){
                    $hitunglainlain2 = number_format($hitunglainlain,0,',','.');
                } else {
                    $hitunglainlain2 = number_format($hitunglainlain,2,',','.');
                }
                $hitunglainlain5 = $hitunglainlain;
            } else {
                $hitunglainlain2 = 0;
                $hitunglainlain5 = 0;
            }
            //hitung penjualan
            $penjualan = $this->db->query("SELECT SUM(total_harga) AS jml FROM v_penjualan WHERE tgl_jual = '$tgl'")->row("jml");
            if(floatval($penjualan)>0){
                if(floor($penjualan)==$penjualan){
                    $penjualan2 = number_format($penjualan,0,',','.');
                } else {
                    $penjualan2 = number_format($penjualan,2,',','.');
                }
                $penjualan5 = $penjualan;
            } else {
                $penjualan2 = 0;
                $penjualan5 = 0;
            }
            //hitung produksi
            $produksi = $this->db->query("SELECT SUM(harga_total) AS jml FROM input_produksi WHERE tgl_produksi = '$tgl'")->row("jml");
            if(floatval($produksi)>0){
                if(floor($produksi)==$produksi){
                    $produksi2 = number_format($produksi,0,',','.');
                } else {
                    $produksi2 = number_format($produksi,2,',','.');
                }
                $produksi5 = $produksi;
            } else {
                $produksi2 = 0;
                $produksi5 = 0;
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
           
            $sheet->setCellValue('B'.$NUMROW.'', $i); // Set kolom A1 
            $sheet->setCellValue('C'.$NUMROW.'', $printTgl); // Set kolom A1 
            $sheet->setCellValue('D'.$NUMROW.'', $listrik_harian); // Set kolom A1 
            $sheet->setCellValue('E'.$NUMROW.'', $total_nilai_baku); // Set kolom A1 
            $sheet->setCellValue('F'.$NUMROW.'', $total_nilai_bantu); // Set kolom A1 
            $sheet->setCellValue('G'.$NUMROW.'', $total_nilai_sparepart); // Set kolom A1 
            $sheet->setCellValue('H'.$NUMROW.'', $biayaSusut5); // Set kolom A1 
            $sheet->setCellValue('I'.$NUMROW.'', $hitungPemeliharaan5); // Set kolom A1 
            $sheet->setCellValue('J'.$NUMROW.'', $biayaTHR5); // Set kolom A1 
            $sheet->setCellValue('K'.$NUMROW.'', $biayaManPower5); // Set kolom A1 
            $sheet->setCellValue('L'.$NUMROW.'', $hitunglainlain5); // Set kolom A1 
            $sheet->setCellValue('M'.$NUMROW.'', $penjualan5); // Set kolom A1 
            $sheet->setCellValue('N'.$NUMROW.'', $produksi5); // Set kolom A1 
            $sheet->setCellValue('O'.$NUMROW.'', $gain_loss); // Set kolom A1 
            $sheet->setCellValue('P'.$NUMROW.'', $akumulasi_gl); // Set kolom A1 
            $NUMROW++;
        }
        
        
        $writer = new Xlsx($spreadsheet);
        

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output'); // download file
        
    } //end
    function hitungHariDalamPeriode($tanggal_awal, $tanggal_akhir) {
        // Konversi string tanggal ke objek DateTime
        $start = new DateTime($tanggal_awal);
        $end = new DateTime($tanggal_akhir);
        $end->modify('+1 day');
        $hari = array(
            'Senin' => 0,
            'Selasa' => 0,
            'Rabu' => 0,
            'Kamis' => 0,
            'Jumat' => 0,
            'Sabtu' => 0,
            'Minggu' => 0
        );
        $interval = new DateInterval('P1D'); // Interval satu hari
        $period = new DatePeriod($start, $interval, $end);
    
        foreach ($period as $date) {
            $dayOfWeek = $date->format('l'); // Mendapatkan nama hari dalam format Inggris
            switch ($dayOfWeek) {
                case 'Monday':
                    $hari['Senin']++;
                    break;
                case 'Tuesday':
                    $hari['Selasa']++;
                    break;
                case 'Wednesday':
                    $hari['Rabu']++;
                    break;
                case 'Thursday':
                    $hari['Kamis']++;
                    break;
                case 'Friday':
                    $hari['Jumat']++;
                    break;
                case 'Saturday':
                    $hari['Sabtu']++;
                    break;
                case 'Sunday':
                    $hari['Minggu']++;
                    break;
            }
        }
        $totalHari = array_sum($hari);
        $hari['Total'] = $totalHari;
        return $hari;
    } //end fun

    function waktuTerlambatKeDetik($waktu) {
        list($jam, $menit) = explode(':', $waktu);
        return ($jam * 3600) + ($menit * 60);
    }
}