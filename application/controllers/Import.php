<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    class Import extends CI_Controller {
        public function __construct(){
            parent::__construct();
            $this->load->model('data_model');
            date_default_timezone_set("Asia/Jakarta");
        }
        public function index(){
            echo "Token Expired";
        }

        function importbakuin(){
            $datetime = date('Y-m-d H:i:s');
            $userlogin = $this->session->userdata('username');
            $tipe_data = $this->input->post('tipe_data');
            $kode_import = "IMPORT".date('d-m-Y')."";
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if(isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if('csv' == $extension){
                  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                
                $berhasil_simpan = 0;
                $gagal_simpan = 0;
                for ($i=1; $i <count($sheetData) ; $i++) { 
                    $kolom1 = $sheetData[$i][0];
                    $kolom2 = $sheetData[$i][1];
                    $kolom3 = $sheetData[$i][2];
                    $kolom4 = $sheetData[$i][3];
                    $kolom5 = $sheetData[$i][4];
                    $kolom6 = $sheetData[$i][5];
                    $kolom7 = $sheetData[$i][6];
                    $kolom8 = $sheetData[$i][7];
                    $kolom9 = $sheetData[$i][8];
                    $kolom10 = $sheetData[$i][9];
                    if($kolom1==""){ $tgl=date('Y-m-d'); } else { $tgl=$kolom1; }
                    if($kolom2==""){ $jenis_barang="NULL"; } else { $jenis_barang=$kolom2; }
                    if($kolom3==""){ $nama_barang="NULL"; } else { $nama_barang=$kolom3; }
                    if($kolom4==""){ $ukuran="NULL"; } else { $ukuran=$kolom4; }
                    if($kolom5==""){ $sat_ukuran="NULL"; } else { $sat_ukuran=$kolom5; }
                    if($kolom6==""){ $jumlah_barang="NULL"; } else { $jumlah_barang=$kolom6; }
                    if($kolom7==""){ $sat_jumlah="NULL"; } else { $sat_jumlah=$kolom7; }
                    if($kolom8==""){ $supplier="NULL"; } else { $supplier=$kolom8; }
                    if($kolom9==""){ $ket="NULL"; } else { $ket=$kolom9; }
                    if($kolom10==""){ $harga_satuan=0; } else { $harga_satuan=$kolom10; }
                    //$kode_stok = $jenis_barang.'-'.$nama_barang.'-'.$ukuran.'-'.$sat_ukuran.'-'.$sat_jumlah.'-'.$harga_satuan;
                    if($tipe_data == "Bahan Baku"){
                        $kode_stok = 'Baku-'.$jenis_barang.'-'.$nama_barang.'-'.$ukuran.'-'.$sat_ukuran.'-'.$sat_jumlah.'-'.$harga_satuan;
                        $dtlist = [
                            'tgl_masuk'     => $tgl,
                            'waktu_masuk'   => $datetime,
                            'jenis_barang'  => $jenis_barang,
                            'nama_barang'   => $nama_barang,
                            'ukuran'        => $ukuran,
                            'satuan_ukuran' => $sat_ukuran,
                            'jumlah_masuk'  => $jumlah_barang,
                            'satuan_jumlah' => $sat_jumlah,
                            'supplier'      => $supplier,
                            'keterangan'    => $ket,
                            'diinput'       => $userlogin,
                            'harga_satuan'  => $harga_satuan,
                            'code_input'    => $kode_import,
                        ];
                        $cek = $this->data_model->get_byid('bahan_baku_masuk',$dtlist)->num_rows();
                        if($cek == 0) { 
                            $this->data_model->saved('bahan_baku_masuk', $dtlist); 
                            $cekstok = $this->data_model->get_byid('data_stok',['kode_stok' => $kode_stok]);
                            if($cekstok->num_rows() == 0){
                                $this->data_model->saved('data_stok',['kode_stok'=>$kode_stok,'bahan'=>'Baku','jenis_bahan'=>$jenis_barang,'nama_bahan'=>$nama_barang,'ukuran'=>$ukuran,'satuan_ukuran'=>$sat_ukuran,'satuan_jml'=>$sat_jumlah,'harga_satuan'=>$harga_satuan,'jumlah_stok'=>$jumlah_barang]);
                            } else {
                                $stok_awal = intval($cekstok->row('jumlah_stok'));
                                $stok_akhir = $stok_awal + $jumlah_barang;
                                $this->data_model->updatedata('kode_stok',$kode_stok,'data_stok',['jumlah_stok'=>$stok_akhir]);
                            }
                        }
                    }
                    if($tipe_data == "Bahan Bantu"){
                        $kode_stok = 'Bantu-'.$jenis_barang.'-'.$nama_barang.'-'.$ukuran.'-'.$sat_ukuran.'-'.$sat_jumlah.'-'.$harga_satuan;
                        $dtlist = [
                            'tgl_masuk'     => $tgl,
                            'tgl_input'     => $datetime,
                            'nama_barang'   => $jenis_barang,
                            'keterangan'    => $nama_barang,
                            'ukuran'        => $ukuran,
                            'satuan_ukr'    => $sat_ukuran,
                            'jumlah'        => $jumlah_barang,
                            'satuan_jml'    => $sat_jumlah,
                            'supplier_bnt'  => $supplier,
                            'ket'           => $ket,
                            'diinput'       => $userlogin,
                            'harga_satuan'  => $harga_satuan,
                            'code_input'    => $kode_import,
                        ];
                        $cek = $this->data_model->get_byid('bahan_bantu_masuk',$dtlist)->num_rows();
                        if($cek == 0) { 
                            $this->data_model->saved('bahan_bantu_masuk', $dtlist); 
                            $cekstok = $this->data_model->get_byid('data_stok',['kode_stok' => $kode_stok]);
                            if($cekstok->num_rows() == 0){
                                $this->data_model->saved('data_stok',['kode_stok'=>$kode_stok,'bahan'=>'Bantu','jenis_bahan'=>$jenis_barang,'nama_bahan'=>$nama_barang,'ukuran'=>$ukuran,'satuan_ukuran'=>$sat_ukuran,'satuan_jml'=>$sat_jumlah,'harga_satuan'=>$harga_satuan,'jumlah_stok'=>$jumlah_barang]);
                            } else {
                                $stok_awal = intval($cekstok->row('jumlah_stok'));
                                $stok_akhir = $stok_awal + $jumlah_barang;
                                $this->data_model->updatedata('kode_stok',$kode_stok,'data_stok',['jumlah_stok'=>$stok_akhir]);
                            }
                        }
                    }
                    if($tipe_data == "Sparepart"){
                        $kode_stok = 'Sparepart-'.$jenis_barang.'-'.$nama_barang.'-'.$ukuran.'-'.$sat_ukuran.'-'.$sat_jumlah.'-'.$harga_satuan;
                        $dtlist = [
                            'tgl_masuk'     => $tgl,
                            'tgl_input'     => $datetime,
                            'nama_barang'   => $jenis_barang,
                            'keterangan'    => $nama_barang,
                            'ukuran'        => $ukuran,
                            'satuan_ukr'    => $sat_ukuran,
                            'jumlah'        => $jumlah_barang,
                            'satuan_jml'    => $sat_jumlah,
                            'supplier_bnt'  => $supplier,
                            'ket'           => $ket,
                            'diinput'       => $userlogin,
                            'harga_satuan'  => $harga_satuan,
                            'code_input'    => $kode_import,
                        ];
                        $cek = $this->data_model->get_byid('bahan_sparepart_masuk',$dtlist)->num_rows();
                        if($cek == 0) { 
                            $this->data_model->saved('bahan_sparepart_masuk', $dtlist); 
                            $cekstok = $this->data_model->get_byid('data_stok',['kode_stok' => $kode_stok]);
                            if($cekstok->num_rows() == 0){
                                $this->data_model->saved('data_stok',['kode_stok'=>$kode_stok,'bahan'=>'Sparepart','jenis_bahan'=>$jenis_barang,'nama_bahan'=>$nama_barang,'ukuran'=>$ukuran,'satuan_ukuran'=>$sat_ukuran,'satuan_jml'=>$sat_jumlah,'harga_satuan'=>$harga_satuan,'jumlah_stok'=>$jumlah_barang]);
                            } else {
                                $stok_awal = intval($cekstok->row('jumlah_stok'));
                                $stok_akhir = $stok_awal + $jumlah_barang;
                                $this->data_model->updatedata('kode_stok',$kode_stok,'data_stok',['jumlah_stok'=>$stok_akhir]);
                            }
                        }
                    }
                    //echo "$kolom1 - $kolom2 - $kolom3 - $kolom4 - $kolom5 - $kolom6 - $kolom7 - $kolom8 - $kolom9 <br>";
                    //$this->session->set_flashdata('sukses', 'Import Data Bahan Baku Masuk Berhasil');
                } //end foreach
                //echo "File upload success";\
                if($tipe_data == "Bahan Baku") {
                    $this->session->set_flashdata('success', 'Import Data Bahan Baku Berhasil');
                    redirect(base_url('stok/bahan-baku'));
                }
                if($tipe_data == "Bahan Bantu") {
                    $this->session->set_flashdata('success', 'Import Data Bantu Baku Berhasil');
                    redirect(base_url('stok/bahan-bantu'));
                }
                if($tipe_data == "Sparepart") {
                    $this->session->set_flashdata('success', 'Import Data Sparepart Berhasil');
                    redirect(base_url('stok/sparepart'));
                }
            } else {
                //echo "File upload failed";
                if($tipe_data == "Bahan Baku") {
                    $this->session->set_flashdata('gagal', 'Import Data Bahan Baku gagal');
                    redirect(base_url('stok/bahan-baku'));
                }
                if($tipe_data == "Bahan Bantu") {
                    $this->session->set_flashdata('gagal', 'Import Data Bantu Baku gagal');
                    redirect(base_url('stok/bahan-bantu'));
                }
                if($tipe_data == "Sparepart") {
                    $this->session->set_flashdata('gagal', 'Import Data Sparepart gagal');
                    redirect(base_url('stok/sparepart'));
                }
            }
        } //end function importbakuin

        function importBarangjadi(){
            $datetime = date('Y-m-d H:i:s');
            $userlogin = $this->session->userdata('username');
            //$tipe_data = $this->input->post('tipe_data');
            $kode_import = "IMPORT".$userlogin."";
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if(isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if('csv' == $extension){
                  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                
                $berhasil_simpan = 0;
                $gagal_simpan = 0;
                for ($i=1; $i <count($sheetData) ; $i++) { 
                    $kolom1 = $sheetData[$i][0];
                    $kolom2 = $sheetData[$i][1];
                    $kolom31 = $sheetData[$i][2];
                    $kolom3 = preg_replace('/[^0-9]/', '', $kolom31);
                    $kolom4 = $sheetData[$i][3];
                    $kolom5 = $sheetData[$i][4];
                    if($kolom1==""){ $_jnsbarang="NULL"; } else { $_jnsbarang=$kolom1; }
                    if($kolom2==""){ $_namabarang="NULL"; } else { $_namabarang=$kolom2; }
                    if($kolom3==""){ $_total=0; } else { $_total=$kolom3; }
                    if($kolom4==""){ $_hrgsatuan=0; } else { $_hrgsatuan=$kolom4; }
                    if($kolom5==""){ $_tgl=date('Y-m-d'); } else { $_tgl=$kolom5; }
                    if($_hrgsatuan==0){
                        $_hrg_total = 0;
                    } else {
                        $_hrg_total = intval($_total) * intval($_hrgsatuan);
                    }
                    $dtlist = [
                        'tgl_produksi' => $_tgl,
                        'tglinput' => $datetime,
                        'jenis_produksi' => strtoupper($_jnsbarang),
                        'produksi' => strtoupper($_namabarang),
                        'jumlah' => $_total,
                        'harga_satuan' => $_hrgsatuan,
                        'harga_total' => $_hrg_total,
                        'yginput' => $kode_import
                    ];
                    $cek = $this->data_model->get_byid('input_produksi',$dtlist)->num_rows();
                    if($cek == 0) {
                        $this->data_model->saved('input_produksi',$dtlist);
                    }
                } //end foreach
                //echo "File upload success";\
                $this->session->set_flashdata('success', 'Import Data Berhasil');
                redirect(base_url('input/produksi'));
            } else {
                $this->session->set_flashdata('gagal', 'Import Data gagal');
                redirect(base_url('input/produksi'));
            }
        } //end function importbakuin

        //DIBAWAH INI UNTUK IMPORT SALDO AWAL PIUTANG
        function importbakuin2(){
            $datetime = date('Y-m-d H:i:s');
            $userlogin = $this->session->userdata('username');
            //$tipe_data = $this->input->post('tipe_data');
            $kode_import = "IMPORT".$userlogin."";
            $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if(isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['upload_file']['name']);
                $extension = end($arr_file);
                if('csv' == $extension){
                  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                
                $berhasil_simpan = 0;
                $gagal_simpan = 0;
                for ($i=1; $i <count($sheetData) ; $i++) { 
                    $kdjual = $this->data_model->acakKode(15);
                    $kolom1 = $sheetData[$i][0];
                    $kolom2 = $sheetData[$i][1];
                    $kolom3 = preg_replace('/[^0-9]/', '', $kolom2);
                    echo $kolom1."-".$kolom3."<br>";
                    $this->data_model->saved('data_penjualan',[
                        'tgl_jual' => '2024-12-30',
                        'tgl_input' => '2025-01-15 23:51:00',
                        'code_penjualan' => $kdjual,
                        'yg_jual' => 'superadmin',
                        'customer' => $kolom1,
                        'nosj' => 'SLDAWL'.$i.'',
                        'nonota' => 'SLDAWL'.$i.'',
                        'presentase_pajak' => '0',
                        'tgl_nota' => '2024-12-30'
                    ]);
                    $this->data_model->saved('data_penjualan_detil',[
                        'code_penjualan' => $kdjual,
                        'jenis_barang' => 'superadmin',
                        'nama_barang' => $kolom1,
                        'jumlah_jual' => '1',
                        'harga_satuan' => $kolom3,
                        'total_harga' => $kolom3,
                        'tgljual' => '2024-12-30'
                    ]);
                } //end foreach

                //echo "File upload success";\
                $this->session->set_flashdata('success', 'Import Data Berhasil');
                echo "owek";
                //redirect(base_url('input/produksi'));
            } else {
                $this->session->set_flashdata('gagal', 'Import Data gagal');
                //redirect(base_url('input/produksi'));
            }
        } //end function importbakuin


        
    } //end of File