<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proses extends CI_Controller
{
  function __construct()
  {
      parent::__construct();
      $this->load->model('data_model');
      $this->load->library('form_validation');
      date_default_timezone_set("Asia/Jakarta");
  }
   
  function index(){
      echo "Not Index...";
  }
  
  
    public function adduser() {
        $this->form_validation->set_rules('namauser', 'namauser', 'required|trim');
        //$this->form_validation->set_rules('hak', 'hak', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user_data.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
    
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error_messages', validation_errors());
            redirect(base_url('user-data'));
            //echo validation_errors();
        } else {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);
            $namauser = $this->input->post('namauser', TRUE);
            $hak = $this->input->post('hak', TRUE);
    
            // Hash password sebelum disimpan
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $imhak = implode(',',$hak);
            // Simpan ke database
            $data = [
                'nama_user' => $namauser,
                'username' => $username,
                'password' => $hashed_password,
                'hak_akses' => $imhak,
                'las_login' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('user_data', $data);
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // Redirect ke halaman login
            $this->session->set_flashdata('success', 'Registration successful. Please login.');
            redirect(base_url('user-data'));
        }
    } //end
  
    function inputpembayaran(){
        $tipeid = trim($this->input->post('tipeid', TRUE));
        $sup = trim($this->input->post('sup', TRUE));
        $sup2 = $this->data_model->safe_base64_encode($sup);
        $tgl = $this->input->post('tgl', TRUE);
        $nominal2 = $this->input->post('nominal', TRUE);
        $jnsbayar = $this->input->post('jnsbyr', TRUE);
        $ket = $this->input->post('textare', TRUE);
        $nominal = preg_replace('/[^0-9.]/', '', $nominal2);
        if($tipeid==1){ 
            $tipeidtxt = "Bahan Baku"; 
        } elseif($tipeid==2){ 
            $tipeidtxt = "Bahan Bantu"; 
        } elseif($tipeid==3){ 
            $tipeidtxt = "Sparepart"; 
        } else {
            $tipeidtxt = "All"; 
        }
        if($sup!="" AND $tgl!="" AND $jnsbayar!=""){
            if(intval($nominal)>0){
                $dtlist = [
                    'nama_supplier' => strtoupper($sup),
                    'jumlah_bayar' => $nominal,
                    'tgl_bayar' => $tgl,
                    'tgl_input' => date('Y-m-d H:i:s'),
                    'diinput'=>$this->session->userdata('username'),
                    'jns_bayar'=>$jnsbayar,
                    'keterangan'=>$ket,
                    'jenis_pembelian' => $tipeidtxt
                ];
                $cek = $this->data_model->get_byid('pembayaran_nota',$dtlist)->num_rows();
                if($cek==0){$this->data_model->saved('pembayaran_nota', $dtlist);}
                $this->session->set_flashdata('sukses', 'Data pembayaran berhasil disimpan!!');
                redirect(base_url('nota-tagihan/id/'.$sup2.'/4'));
            } else {
                $this->session->set_flashdata('gagal', 'Nominal pembayaran harus lebih dari nol!!');
                redirect(base_url('nota-tagihan/id/'.$sup2.'/4'));
            }
        } else {
            $this->session->set_flashdata('gagal', 'Anda tidak mengisi data dengan benar!!');
            redirect(base_url('nota-tagihan/id/'.$sup2.'/4'));
        }
    } //end inputpembayaran

    function simpanpemakaian(){
        $tipe = trim($this->input->post('tipe_out', TRUE));
        if($tipe=="Bahan Baku"){ $tolink = "bahan-baku/keluar"; $_tipe="Baku"; $_table="pemakaian_bahan_baku"; }
        if($tipe=="Bahan Bantu"){ $tolink = "bahan-bantu/keluar"; $_tipe="Bantu"; $_table="pemakaian_bahan_bantu"; }
        if($tipe=="Sparepart"){ $tolink = "sparepart/keluar"; $_tipe="Sparepart"; $_table="pemakaian_bahan_sparepart"; }
        $tgl_pakai = trim($this->input->post('tgl_pakai', TRUE));
        $tujuan_pakai = trim($this->input->post('tujuan_pakai', TRUE));
        $jenisbahan = trim($this->input->post('jenisbahan', TRUE));
        $namabahan = trim($this->input->post('namabahan', TRUE));
        $ukuranbahan = trim($this->input->post('ukuranbahan', TRUE));
        $jumlahpakai2 = trim($this->input->post('jumlahpakai', TRUE));
        $jumlahpakai = preg_replace('/[^0-9.]/', '', $jumlahpakai2);
        $ketpakai = trim($this->input->post('ketpakai', TRUE));
        $userlogin = $this->session->userdata('username');
        $tujuan_pakai = strtoupper($tujuan_pakai);
        $allstok = $this->data_model->get_byid('data_stok', ['bahan'=>$_tipe,'jenis_bahan'=>$jenisbahan,'nama_bahan'=>$namabahan,'ukuran'=>$ukuranbahan]);
        $_error = 0;
        foreach($allstok->result() as $det){
            $_newhrg = intval($det->harga_satuan);
            if($_newhrg > 0){

            } else {
                $_error+=1;
            }
        }
        if($_error == 0 ){
        if($tipe != '' && $tgl_pakai != '' && $tujuan_pakai != '' && $jenisbahan != '' && $namabahan != '' && $ukuranbahan != '' && $jumlahpakai != ''){
            $jumlah_stok = $this->db->query("SELECT SUM(jumlah_stok) AS jml FROM data_stok WHERE bahan='$_tipe' AND jenis_bahan='$jenisbahan' AND nama_bahan='$namabahan' AND ukuran='$ukuranbahan'")->row("jml");
            if($jumlah_stok > 0){
                if($jumlahpakai > 0 AND $jumlahpakai <= $jumlah_stok){
                    foreach($allstok->result() as $val){
                        $_id_stok = $val->id_stok;
                        $_kode_stok = $val->kode_stok;
                        $_jumlahstok = $val->jumlah_stok;
                        if($_jumlahstok > 0){
                            if($jumlahpakai > 0){
                                if($jumlahpakai >= $_jumlahstok){
                                    //$this->data_model->updatedata('data_stok', ['id_stok'=>$_id_stok], ['jumlah_stok'=>0]);
                                    $this->data_model->updatedata('id_stok',$_id_stok,'data_stok',['jumlah_stok'=>0]);
                                    $dtlist = [
                                        'kode_stok' => $_kode_stok,
                                        'jenis_bahan' => $val->jenis_bahan,
                                        'nama_bahan' => $val->nama_bahan,
                                        'ukuran' => $val->ukuran,
                                        'satuan_ukuran' => $val->satuan_ukuran,
                                        'jumlah_pakai' => $_jumlahstok,
                                        'satuan_jumlah' => $val->satuan_jml,
                                        'harga_satuan' => $val->harga_satuan,
                                        'tgl_pakai' => $tgl_pakai,
                                        'tgl_input' => date('Y-m-d H:i:s'),
                                        'yginput' => $userlogin,
                                        'tujuan_pakai' => $tujuan_pakai,
                                        'ket' => $ketpakai
                                    ];
                                    $cek = $this->data_model->get_byid($_table, $dtlist)->num_rows();
                                    if($cek == 0){ $this->data_model->saved($_table, $dtlist); }
                                    $jumlahpakai = $jumlahpakai - $_jumlahstok;
                                } else {
                                    $new_stok = $_jumlahstok - $jumlahpakai;
                                    //$this->data_model->updatedata('data_stok', ['id_stok'=>$_id_stok], ['jumlah_stok'=>$new_stok]);
                                    $this->data_model->updatedata('id_stok',$_id_stok,'data_stok',['jumlah_stok'=>$new_stok]);
                                    $dtlist = [
                                        'kode_stok' => $_kode_stok,
                                        'jenis_bahan' => $val->jenis_bahan,
                                        'nama_bahan' => $val->nama_bahan,
                                        'ukuran' => $val->ukuran,
                                        'satuan_ukuran' => $val->satuan_ukuran,
                                        'jumlah_pakai' => $jumlahpakai,
                                        'satuan_jumlah' => $val->satuan_jml,
                                        'harga_satuan' => $val->harga_satuan,
                                        'tgl_pakai' => $tgl_pakai,
                                        'tgl_input' => date('Y-m-d H:i:s'),
                                        'yginput' => $userlogin,
                                        'tujuan_pakai' => $tujuan_pakai,
                                        'ket' => $ketpakai
                                    ];
                                    $cek = $this->data_model->get_byid($_table, $dtlist)->num_rows();
                                    if($cek == 0){ $this->data_model->saved($_table, $dtlist); }
                                    $jumlahpakai = 0;
                                }
                            }
                        }
                    }
                    $this->session->set_flashdata('success', 'BERHASIL.! Menyimpan data pemakaian.'.$tipe.'');
                    redirect(base_url(''.$tolink));
                } else {
                    $this->session->set_flashdata('gagal', 'GAGAL Menyimpan.!! Minimal pemakaian 1, maks '.$jumlah_stok.'');
                    redirect(base_url(''.$tolink));
                }
            } else {
                $this->session->set_flashdata('gagal', 'GAGAL Menyimpan.!!Stok tidak mencukupi!!');
                redirect(base_url(''.$tolink));
            }
        } else {
            $this->session->set_flashdata('gagal', 'GAGAL Menyimpan.!!Anda tidak mengisi data dengan benar!!');
            redirect(base_url(''.$tolink));
        }
        } else {
            $this->session->set_flashdata('gagal', 'Ada stok yang belum memiliki Harga Satuan');
            redirect(base_url(''.$tolink));
        }
    } //end simpanpemakaian

    function resetdataapp(){
        $password2 = $this->input->post('passworde', TRUE);
        $password = "@MitraSahabat#@!2323";
        if($password2 == $password){
            $this->db->query("TRUNCATE `bahan_baku_masuk`");
            $this->db->query("TRUNCATE `bahan_bantu_masuk`");
            $this->db->query("TRUNCATE `bahan_sparepart_masuk`");
            $this->db->query("TRUNCATE `data_stok`");
            $this->db->query("TRUNCATE `pemakaian_bahan_baku`");
            $this->db->query("TRUNCATE `pemakaian_bahan_bantu`");
            $this->db->query("TRUNCATE `pemakaian_bahan_sparepart`");
            $this->db->query("TRUNCATE `pembayaran_nota`");
            $this->db->query("TRUNCATE `pembelian_barang`");
            $this->db->query("TRUNCATE `user_data`");
            $passwordoke = "superadmin123";
            $hashed_password = password_hash($passwordoke, PASSWORD_BCRYPT);
            $this->data_model->saved('user_data',['nama_user'=>'Adi SH','username'=>'superadmin','password'=>$hashed_password,'hak_akses'=>'SuperAdmin','las_login'=>date('Y-m-d H:i:s')]);
            redirect(base_url('login'));
        } else {
            redirect(base_url('beranda'));
        }
    } //end 

    function simpanproduksi(){
        $tipesave = $this->input->post('tipesave', TRUE);
        $tgl = $this->input->post('tanggalproduksi', TRUE);
        $produksijenis = $this->input->post('produksijenis', TRUE);
        $produksinama = $this->input->post('produksinama', TRUE);
        //$pro2 = strtolower($pro);
        $jmlr = $this->input->post('jmlproduksi', TRUE);
        $jml = preg_replace('/[^0-9.]/', '', $jmlr);
        $hrg2 = $this->input->post('hargasatuan', TRUE);
        $hrg = preg_replace('/[^0-9.]/', '', $hrg2);
        $userlogin = $this->session->userdata('username');
        $tanggal_print = date("d M Y", strtotime($tgl));
        if($tgl!="" AND $produksijenis!="" AND $produksinama!="" AND $jml!=""){
            //echo $tgl."<br>".$pro."<br>".$jml."<br>".$hrg."";
            if (!$this->is_valid_date_format($tgl)) {
                $this->session->set_flashdata('gagal', 'GAGAL Menyimpan.!! Format tanggal tidak sesuai (YYYY-MM-DD)');
                redirect(base_url('input/produksi'));
            } else {
                if($tipesave=="add"){
                    $harga_total = intval($jml) * intval($hrg);
                    $dtlist = [
                        'tgl_produksi' => $tgl,
                        'tglinput' => date('Y-m-d H:i:s'),
                        'jenis_produksi' => strtoupper($produksijenis),
                        'produksi' => strtoupper($produksinama),
                        'jumlah' => $jml,
                        'harga_satuan' => $hrg,
                        'harga_total' => $harga_total,
                        'yginput' => $userlogin
                    ];
                    $cek = $this->data_model->get_byid('input_produksi',$dtlist)->num_rows();
                    if($cek==0){$this->data_model->saved('input_produksi',$dtlist);}
                    $this->session->set_flashdata('success', 'Berhasil Menyimpan Produksi Tanggal '.$tanggal_print.'');
                    redirect(base_url('input/produksi'));
                } else {
                    $harga_total = intval($jml) * intval($hrg);
                    $dtlist = [
                        'tgl_produksi' => $tgl,
                        'jenis_produksi' => strtoupper($produksijenis),
                        'produksi' => strtoupper($produksinama),
                        'jumlah' => $jml,
                        'harga_satuan' => $hrg,
                        'harga_total' => $harga_total
                    ];
                    $this->data_model->updatedata('idproduksi',$tipesave,'input_produksi',$dtlist);
                    $this->session->set_flashdata('success', 'Berhasil Update Produksi Tanggal '.$tanggal_print.'');
                    redirect(base_url('input/produksi'));
                }
            }
        } else {
            $this->session->set_flashdata('gagal', 'GAGAL Menyimpan.!! Anda tidak mengisi data dengan benar!!');
            redirect(base_url('input/produksi'));
        }
    }
    private function is_valid_date_format($date){
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    } //end 

    function pakaisparepart(){
        $userlogin = $this->session->userdata('username');
        $tgl    = $this->input->post('tglpakai', TRUE);
        $cicil  = $this->input->post('cicil', TRUE);
        $cicilx = intval($cicil);
        $tujuan = $this->input->post('tujuan', TRUE);
        $ket    = $this->input->post('ket', TRUE);
        $id     = $this->input->post('id_bantuin', TRUE);
        $cekkode = $this->data_model->get_byid('bahan_sparepart_masuk',['id_bantuin'=>$id])->row('code_input');
        if($tgl!="" AND $cicil!="" AND $tujuan!="" AND $id!=""){
            $cek = $this->data_model->get_byid('bahan_sparepart_masuk',['id_bantuin'=>$id,'code_input'=>$cekkode]);
            if($cek->num_rows() == 1){
                $_jnsbrg = $cek->row("nama_barang");
                $_nmabrg = $cek->row("keterangan");
                $_ukrbrg = $cek->row("ukuran");
                $_satukr = $cek->row("satuan_ukr");
                $_jmlbrg = $cek->row("jumlah");
                $_satjml = $cek->row("satuan_jml");
                $_hrgbrg = $cek->row("harga_satuan");
                $_kode_stok = 'Sparepart-'.strtoupper($_jnsbrg).'-'.strtoupper($_nmabrg).'-'.strtoupper($_ukrbrg).'-'.strtoupper($_satukr).'-'.strtoupper($_satjml).'-'.$_hrgbrg;
                $_jumlahstok2 = floatval($_jmlbrg) / $cicilx;
                $_jumlahstok = round($_jumlahstok2,2);
                if (!$this->is_valid_date_format($tgl)) {} else {
                    $dtlist = [
                        'code_input'    =>$cekkode,
                        'id_bantuin'    =>$id,
                        'tgl_pakai'     =>$tgl,
                        'selama'        =>$cicil
                    ];
                    $cek = $this->data_model->get_byid('pemakaian_langsung',$dtlist)->num_rows();
                    if($cek == 0){
                        $this->data_model->saved('pemakaian_langsung',$dtlist);
                        //input pengurangan stok
                        $cekstok = $this->data_model->get_byid('data_stok',['kode_stok'=>$_kode_stok])->row("jumlah_stok");
                        $newstok = floatval($cekstok) - floatval($_jmlbrg); 
                        $this->data_model->updatedata('kode_stok',$_kode_stok,'data_stok',['jumlah_stok'=>$newstok]);
                        if($cicilx > 0 AND $cicilx < 13){
                            $tanggalCicilan = [];
                            $date = DateTime::createFromFormat('Y-m-d', $tgl);
                            for ($i = 0; $i < $cicil; $i++) {
                                $tanggalCicilan[] = $date->format('Y-m-d');
                                $date->add(new DateInterval('P1M')); // P1M berarti satu bulan
                            }
                            foreach ($tanggalCicilan as $tanggal) {
                                //echo $tanggal . "<br>";
                                $dtlist2 = [
                                    'kode_stok' => $_kode_stok,
                                    'jenis_bahan' => strtoupper($_jnsbrg),
                                    'nama_bahan' => strtoupper($_nmabrg),
                                    'ukuran' => strtoupper($_ukrbrg),
                                    'satuan_ukuran' => strtoupper($_satukr),
                                    'jumlah_pakai' => $_jumlahstok,
                                    'satuan_jumlah' => strtoupper($_satjml),
                                    'harga_satuan' => $_hrgbrg,
                                    'tgl_pakai' => $tanggal,
                                    'tgl_input' => date('Y-m-d H:i:s'),
                                    'yginput' => $userlogin,
                                    'tujuan_pakai' => $tujuan,
                                    'ket' => $ket,
                                    'code_pakai' => $cekkode
                                ];
                                $cek = $this->data_model->get_byid('pemakaian_bahan_sparepart', $dtlist2)->num_rows();
                                if($cek == 0){ 
                                    $this->data_model->saved('pemakaian_bahan_sparepart', $dtlist2);
                                }
                            }

                        }
                    }
                }
            }
            $this->session->set_flashdata('success', 'Menyimpan Data Pemakaian');
            redirect(base_url('input/sparepart/'.$cekkode));
        } else {
            $this->session->set_flashdata('gagal', 'GAGAL Menyimpan.!! Anda tidak mengisi data dengan benar!!');
            redirect(base_url('input/sparepart/'.$cekkode));
        }
    } //end

    function delpemakaianlangsung(){
        $id = $this->input->post('id', TRUE);
        $cek = $this->data_model->get_byid('pemakaian_langsung',['id_bantuin'=>$id]);
        if($cek->num_rows() == 1){
            $code_input = $cek->row("code_input");
            $aldt = $this->db->query("SELECT SUM(jumlah_pakai) AS jml FROM pemakaian_bahan_sparepart WHERE code_pakai='$code_input'")->row("jml");
            $alldt2 = $this->db->query("SELECT kode_stok,code_pakai FROM pemakaian_bahan_sparepart WHERE code_pakai='$code_input' LIMIT 1")->row("kode_stok");
            $jmlstok_awal = $this->data_model->get_byid('data_stok',['kode_stok'=>$alldt2])->row("jumlah_stok");
            $new_stok = floatval($jmlstok_awal) + floatval($aldt);
            $this->data_model->updatedata('kode_stok',$alldt2,'data_stok',['jumlah_stok'=>round($new_stok,2)]);
            $this->db->query("DELETE FROM pemakaian_bahan_sparepart WHERE code_pakai='$code_input'");
            $this->db->query("DELETE FROM pemakaian_langsung WHERE id_bantuin='$id'");
            echo json_encode(array("statusCode"=>200, "psn"=>"oke"));
        } else {
            echo json_encode(array("statusCode"=>500, "psn"=>"ID tidak ditemukan"));
        }
    } //emnd

    function simpanlistrik(){
        $bulan = $this->input->post('bulanlis', TRUE);
        $nominal2 = $this->input->post('nominal', TRUE);
        $userlogin = $this->session->userdata('username');
        $nominal = preg_replace('/[^0-9.]/', '', $nominal2);
        if($nominal!="" AND $nominal>0 AND $bulan!=""){
            //echo $bulan."<br>".$nominal;
            $cek = $this->data_model->get_byid('input_listrik',['tahun_bln'=>$bulan])->num_rows();
            if($cek==0){
                $this->data_model->saved('input_listrik',['tahun_bln'=>$bulan,'biaya'=>$nominal,'yg_input'=>$userlogin,'input_tgl'=>date('Y-m-d H:i:s')]);
            } else {
                $this->data_model->updatedata('tahun_bln',$bulan,'input_listrik',['biaya'=>$nominal,'input_tgl'=>date('Y-m-d H:i:s')]);
            }
            $this->session->set_flashdata('success', 'BERHASIL MENYIMPAN..');
            redirect(base_url('keuangan/biaya-listrik'));
        } else {
            $this->session->set_flashdata('gagal', 'GAGAL Menyimpan.!! Anda tidak mengisi data dengan benar!!');
            redirect(base_url('keuangan/biaya-listrik'));
        }
    }

    function simpansusut(){
        $bulan = $this->input->post('bulanlis', TRUE);
        $nominal2 = $this->input->post('nominal', TRUE);
        $userlogin = $this->session->userdata('username');
        $nominal = preg_replace('/[^0-9.]/', '', $nominal2);
        if($nominal!="" AND $nominal>0 AND $bulan!=""){
            //echo $bulan."<br>".$nominal;
            $cek = $this->data_model->get_byid('input_penyusutan',['tahun_bln'=>$bulan])->num_rows();
            if($cek==0){
                $this->data_model->saved('input_penyusutan',['tahun_bln'=>$bulan,'biaya_susut'=>$nominal,'tgl_input'=>date('Y-m-d H:i:s'),'yg_input'=>$userlogin]);
            } else {
                $this->data_model->updatedata('tahun_bln',$bulan,'input_penyusutan',['biaya_susut'=>$nominal,'tgl_input'=>date('Y-m-d H:i:s')]);
            }
            $this->session->set_flashdata('success', 'BERHASIL MENYIMPAN..');
            redirect(base_url('keuangan/biaya-penyusutan'));
        } else {
            $this->session->set_flashdata('gagal', 'GAGAL Menyimpan.!! Anda tidak mengisi data dengan benar!!');
            redirect(base_url('keuangan/biaya-penyusutan'));
        }
    } //end

    function simpanthr(){
        $bulan = $this->input->post('bulanlis', TRUE);
        $nominal2 = $this->input->post('nominal', TRUE);
        $userlogin = $this->session->userdata('username');
        $nominal = preg_replace('/[^0-9.]/', '', $nominal2);
        if($nominal!="" AND $nominal>0 AND $bulan!=""){
            //echo $bulan."<br>".$nominal;
            $cek = $this->data_model->get_byid('input_cadanganthr',['tahun_bln'=>$bulan])->num_rows();
            if($cek==0){
                $this->data_model->saved('input_cadanganthr',['tahun_bln'=>$bulan,'biaya_thr'=>$nominal,'tgl_input'=>date('Y-m-d H:i:s'),'yg_input'=>$userlogin]);
            } else {
                $this->data_model->updatedata('tahun_bln',$bulan,'input_cadanganthr',['biaya_thr'=>$nominal,'tgl_input'=>date('Y-m-d H:i:s')]);
            }
            $this->session->set_flashdata('success', 'BERHASIL MENYIMPAN..');
            redirect(base_url('keuangan/biaya-cadangan-thr'));
        } else {
            $this->session->set_flashdata('gagal', 'GAGAL Menyimpan.!! Anda tidak mengisi data dengan benar!!');
            redirect(base_url('keuangan/biaya-cadangan-thr'));
        }
    } //end

    function simpanman(){
        $bulan = $this->input->post('bulanlis', TRUE);
        $nominal2 = $this->input->post('nominal', TRUE);
        $userlogin = $this->session->userdata('username');
        $nominal = preg_replace('/[^0-9.]/', '', $nominal2);
        if($nominal!="" AND $nominal>0 AND $bulan!=""){
            //echo $bulan."<br>".$nominal;
            $cek = $this->data_model->get_byid('input_manpower',['tahun_bln'=>$bulan])->num_rows();
            if($cek==0){
                $this->data_model->saved('input_manpower',['tahun_bln'=>$bulan,'biaya_man'=>$nominal,'tgl_input'=>date('Y-m-d H:i:s'),'yg_input'=>$userlogin]);
            } else {
                $this->data_model->updatedata('tahun_bln',$bulan,'input_manpower',['biaya_man'=>$nominal,'tgl_input'=>date('Y-m-d H:i:s')]);
            }
            $this->session->set_flashdata('success', 'BERHASIL MENYIMPAN..');
            redirect(base_url('keuangan/man-power'));
        } else {
            $this->session->set_flashdata('gagal', 'GAGAL Menyimpan.!! Anda tidak mengisi data dengan benar!!');
            redirect(base_url('keuangan/man-power'));
        }
    } //end

    function simpanpemeliharaan(){
        $tgl = $this->input->post('tgl', TRUE);
        $ket = $this->input->post('ket', TRUE);
        $nominal2 = $this->input->post('nominal', TRUE);
        $tipesave = $this->input->post('tipesave', TRUE);
        $userlogin = $this->session->userdata('username');
        $nominal = preg_replace('/[^0-9.]/', '', $nominal2);
        if($nominal!="" AND $nominal>0 AND $tgl!=""){
            if($tipesave=="Pemeliharaan"){
            //echo $bulan."<br>".$nominal;
                $cek = $this->data_model->get_byid('input_pemeliharaan',['tgl'=>$tgl,'nominal'=>$nominal,'keterangan'=>$ket])->num_rows();
                if($cek==0){
                    $this->data_model->saved('input_pemeliharaan',['tgl'=>$tgl,'tgl_input'=>date('Y-m-d H:i:s'),'nominal'=>$nominal,'keterangan'=>$ket,'yginput'=>$userlogin,]);
                }
                $this->session->set_flashdata('success', 'BERHASIL MENYIMPAN..');
                redirect(base_url('keuangan/biaya-pemeliharaan'));
            } else {
                $cek = $this->data_model->get_byid('input_lainlain',['tgl'=>$tgl,'nominal'=>$nominal,'keterangan'=>$ket])->num_rows();
                if($cek==0){
                    $this->data_model->saved('input_lainlain',['tgl'=>$tgl,'tgl_input'=>date('Y-m-d H:i:s'),'nominal'=>$nominal,'keterangan'=>$ket,'yginput'=>$userlogin,]);
                }
                $this->session->set_flashdata('success', 'BERHASIL MENYIMPAN..');
                redirect(base_url('keuangan/biaya-lain-lain'));
            }
        } else {
            $this->session->set_flashdata('gagal', 'GAGAL Menyimpan.!! Anda tidak mengisi data dengan benar!!');
            redirect(base_url('keuangan/biaya-pemeliharaan'));
        }
    } //end
    function updateharga(){
        $id = $this->input->post('id', TRUE);
        $type = $this->input->post('tipe_data', TRUE);
        $harg2 = $this->input->post('harg', TRUE);
        $harg = preg_replace('/[^0-9.]/', '', $harg2);
        $userlogin = $this->session->userdata('username');
        $dt = $this->data_model->get_byid('data_stok',['id_stok'=>$id])->row_array();
        $_jns = $dt['jenis_bahan'];
        $_nma = $dt['nama_bahan'];
        $_ukr = $dt['ukuran'];
        $_hrg = number_format($dt['harga_satuan'],2,',','.');
        $_hrg2 = number_format($harg,2,',','.');
        $txtx = $userlogin." mengubah harga ".$_jns." ".$_nma." ".$_ukr." harga ".$_hrg." menjadi ".$_hrg2."";
        
        if($type=="Bahan Baku"){ $ln="bahan-baku"; }
        if($type=="Bahan Bantu"){ $ln="bahan-bantu"; }
        if($type=="Sparepart"){ $ln="sparepart"; }
        if(intval($harg) > 0){
            $this->data_model->updatedata('id_stok',$id,'data_stok',['harga_satuan'=>$harg]);
            $this->data_model->saved('log_user',['username'=>$userlogin,'waktu'=>date('Y-m-d H:i:s'),'logtext'=>$txtx]);
            $this->session->set_flashdata('success', 'BERHASIL MENYIMPAN..');
        } else {
            $this->session->set_flashdata('gagal', 'GAGAL Menyimpan.!! Anda tidak mengisi data dengan benar!!');
        }
        redirect(base_url('stok/'.$ln));
    } //end

    function pembayarancustomer(){
        $nama_cus = $this->input->post('upload_file', TRUE);
        $linkcus = $this->data_model->safe_base64_encode($nama_cus);
        $tgl_bayar = $this->input->post('tglBayar', TRUE);
        $nominal = $this->input->post('nominal', TRUE);
        $metode = $this->input->post('metode', TRUE);
        $ket = $this->input->post('ket', TRUE);
        $jumlah_bayar = preg_replace('/[^0-9.]/', '', $nominal);
        if(floatval($jumlah_bayar)>0 AND $nama_cus!="" AND $tgl_bayar!="" AND $metode!=""){
            $dtlist = [
                'nama_customer' => strtoupper($nama_cus),
                'jumlah_bayar' => $jumlah_bayar,
                'tgl_bayar' => $tgl_bayar,
                'tgl_simpan' => date('Y-m-d H:i:s'),
                'diinput'=>$this->session->userdata('username'),
                'jns_bayar'=>$metode,
                'keterangan'=>$ket
            ];
            $this->data_model->saved('pembayaran_customer',$dtlist);
            $this->session->set_flashdata('success', 'BERHASIL MENYIMPAN PEMBAYARAN..');
        } else {
            $this->session->set_flashdata('gagal', 'GAGAL Menyimpan.!! Anda tidak mengisi data dengan benar!!');
        }
        redirect(base_url('hutang/customer/'.$linkcus));
    } //end
    function updatenota(){
        $sj = $this->input->post('nonota', TRUE);
        $nonota2 = $this->input->post('nonota2', TRUE);
        $tglnota = $this->input->post('tglnota', TRUE);
        $idpembelian = $this->input->post('idpembelian', TRUE);
        $user=$this->session->userdata('username');
        if($sj!="" AND $tglnota!="" AND $idpembelian!=""){
            $cek=$this->data_model->get_byid('pembelian_barang',['id_pembelian'=>$idpembelian]);
            if($cek->num_rows()==1){
                $_sj = $cek->row("no_sj");
                $_tgl = $cek->row("tgl_nota");
                $txt = "Nota Sementara (".$_sj.") Tanggal ".$_tgl." telah di ubah ke nota sebenarnya oleh ".$user.". Nota sebenarnya adalah ".$nonota." dan tanggal ".$tglnota."";
                $this->data_model->updatedata('id_pembelian',$idpembelian,'pembelian_barang',['nonota'=>$nonota2,'tgl_nota'=>$tglnota,'nota_asli'=>'Ya']);
                $this->data_model->saved('log_user',['username'=>$user,'waktu'=>date('Y-m-d H:i:s'),'logtext'=>$txt]);
                redirect('nota/pembelian');
            }
        } else {
            echo "Anda tidak mengisi data dengan benar!!";
        }
    }//end
}
?>