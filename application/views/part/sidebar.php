<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href="javascript:void(0);">
        <img src="<?=base_url();?>assets/img/logo-ct-dark.png" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="ms-1 text-sm text-dark">Mitra Sahabat</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <?php if($page=="Dashboard"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url();?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url();?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>

<?php 
//jika user memiliki ke produksi
$ses_hak = $this->session->userdata('hak');
$xses = explode(",",$ses_hak);
if(in_array('Produksi',$xses) OR in_array('SuperAdmin',$xses) OR in_array('Penjualan',$xses) OR in_array('Admin Keuangan',$xses)){
?>
        <li class="nav-item">
          <?php if($page=="Data / Produksi"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('input/produksi');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('input/produksi');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">inventory</i>
            <span class="nav-link-text ms-1">Data Produksi</span>
          </a>
        </li>
<?php } 
//jika user memiliki akses keuangan
if(in_array('Penjualan',$xses) OR in_array('Admin Keuangan',$xses) OR in_array('SuperAdmin',$xses)){
?>
        <li class="nav-item">
          <?php if($page=="Data / Penjualan" OR $page=="Input / Penjualan"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('data/penjualan');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('data/penjualan');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">shopping_cart</i>
            <span class="nav-link-text ms-1">Data Penjualan</span>
          </a>
        </li>
<?php
}
if(in_array('Admin Keuangan',$xses) OR in_array('SuperAdmin',$xses)){
?>
        <li class="nav-item">
          <?php if($page=="laporan"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('laporan/gain-loss');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('laporan/gain-loss');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">summarize</i>
            <span class="nav-link-text ms-1">Gain Loss</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">&raquo; KEUNGANAN</h6>
        </li>
        <li class="nav-item">
          <?php if($page=="Keuangan / Biaya Listrik"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('keuangan/biaya-listrik');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('keuangan/biaya-listrik');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">paid</i>
            <span class="nav-link-text ms-1">Biaya Listrik</span>
          </a>
        </li>
        <li class="nav-item">
          <?php if($page=="Keuangan / Biaya Penyusutan"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('keuangan/biaya-penyusutan');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('keuangan/biaya-penyusutan');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">paid</i>
            <span class="nav-link-text ms-1">Biaya Penyusutan</span>
          </a>
        </li>
        <li class="nav-item">
          <?php if($page=="Keuangan / Biaya Pemeliharaan"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('keuangan/biaya-pemeliharaan');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('keuangan/biaya-pemeliharaan');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">paid</i>
            <span class="nav-link-text ms-1">Biaya Pemeliharaan</span>
          </a>
        </li>
        <li class="nav-item">
          <?php if($page=="Keuangan / Biaya Lain-lain"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('keuangan/biaya-lain-lain');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('keuangan/biaya-lain-lain');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">paid</i>
            <span class="nav-link-text ms-1">Biaya Lain<sup>2</sup></span>
          </a>
        </li>
        <li class="nav-item">
          <?php if($page=="Keuangan / Cadangan THR"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('keuangan/biaya-cadangan-thr');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('keuangan/biaya-cadangan-thr');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">paid</i>
            <span class="nav-link-text ms-1">Cadangan THR</span>
          </a>
        </li>
        <li class="nav-item">
          <?php if($page=="Keuangan / Man Power"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('keuangan/man-power');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('keuangan/man-power');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">paid</i>
            <span class="nav-link-text ms-1">Man Power</span>
          </a>
        </li>
        <li class="nav-item">
          <?php if($page=="Data / Piutang"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('hutang/customer');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('hutang/customer');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">paid</i>
            <span class="nav-link-text ms-1">Piutang Customer</span>
          </a>
        </li>
        <li class="nav-item">
          <?php if($page2=="Nota / Tagihan"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('hutang/supplier');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('hutang/supplier');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">paid</i>
            <span class="nav-link-text ms-1">Hutang Supplier</span>
          </a>
        </li>
        <li class="nav-item">
          <?php if($page=="Nota / Pembelian"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('nota/pembelian');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('nota/pembelian');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">paid</i>
            <span class="nav-link-text ms-1">Nota Pembelian</span>
          </a>
        </li>
<?php } 
if(in_array('Bahan Baku',$xses) OR in_array('SuperAdmin',$xses) OR in_array('Admin Keuangan',$xses)){
?>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">&raquo; Bahan Baku</h6>
        </li>
        <li class="nav-item">
          <?php if($page=="Stok / Bahan Baku"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('stok/bahan-baku');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('stok/bahan-baku');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">view_in_ar</i>
            <span class="nav-link-text ms-1">Stok Bahan Baku</span>
          </a>
        </li>
<?php if(in_array('Admin Keuangan',$xses) OR in_array('SuperAdmin',$xses)){ ?>
        <li class="nav-item">
          <?php if($page=="Bahan Baku / Masuk" OR $page=="Pembelian / Bahan Baku" OR $page=="Nota / Tagihan / Bahan Baku"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('bahan-baku/masuk');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('bahan-baku/masuk');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">view_in_ar</i>
            <span class="nav-link-text ms-1">Pembelian Bahan Baku</span>
          </a>
        </li>
<?php } ?>
        <li class="nav-item">
          <?php if($page=="Pemakaian / Bahan Baku"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('bahan-baku/keluar');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('bahan-baku/keluar');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">view_in_ar</i>
            <span class="nav-link-text ms-1">Pemakaian Bahan Baku</span>
          </a>
        </li>
<?php } 
if(in_array('Bahan Bantu',$xses) OR in_array('SuperAdmin',$xses) OR in_array('Admin Keuangan',$xses)){
?>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">&raquo; Bahan Bantu</h6>
        </li>
        <li class="nav-item">
          <?php if($page=="Stok / Bahan Bantu"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('stok/bahan-bantu');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('stok/bahan-bantu');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">Stok Bahan Bantu</span>
          </a>
        </li>
        <?php if(in_array('Admin Keuangan',$xses) OR in_array('SuperAdmin',$xses)){ ?>
        <li class="nav-item">
          <?php if($page=="Bahan Bantu / Masuk" OR $page=="Pembelian / Bahan Bantu" OR $page=="Nota / Tagihan / Bahan Bantu"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('bahan-bantu/masuk');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('bahan-bantu/masuk');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">Pembelian Bahan Bantu</span>
          </a>
        </li>
        <?php } ?>
        <li class="nav-item">
          <?php if($page=="Pemakaian / Bahan Bantu"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('bahan-bantu/keluar');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('bahan-bantu/keluar');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">Pemakaian Bahan Bantu</span>
          </a>
        </li>
<?php }
if(in_array('Sparepart',$xses) OR in_array('SuperAdmin',$xses) OR in_array('Admin Keuangan',$xses)){
?>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">&raquo; Sparepart</h6>
        </li>
        <li class="nav-item">
          <?php if($page=="Stok / Sparepart"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('stok/sparepart');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('stok/sparepart');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">inbox_customize</i>
            <span class="nav-link-text ms-1">Stok Sparepart</span>
          </a>
        </li>
        <?php if(in_array('Admin Keuangan',$xses) OR in_array('SuperAdmin',$xses)){ ?>
        <li class="nav-item">
          <?php if($page=="Sparepart / Masuk" OR $page=="Pembelian / Sparepart" OR $page=="Nota / Tagihan / Sparepart"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('sparepart/masuk');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('sparepart/masuk');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">inbox_customize</i>
            <span class="nav-link-text ms-1">Pembelian Sparepart</span>
          </a>
        </li>
        <?php } ?>
        <li class="nav-item">
          <?php if($page=="Pemakaian / Sparepart"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('sparepart/keluar');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('sparepart/keluar');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">inbox_customize</i>
            <span class="nav-link-text ms-1">Pemakaian Sparepart</span>
          </a>
        </li>
<?php } ?>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">&raquo; Account pages</h6>
        </li>
<?php
//jika super admin
if(in_array('SuperAdmin',$xses)){ ?>
        <li class="nav-item">
          <?php if($page=="Management / User Data"){ ?>
          <a class="nav-link active bg-gradient-dark text-white" href="<?=base_url('user-data');?>">
          <?php } else { ?>
          <a class="nav-link text-dark" href="<?=base_url('user-data');?>">
          <?php } ?>
            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">User Data</span>
          </a>
        </li>
<?php } ?>
        <li class="nav-item">
          <a class="nav-link text-dark" href="<?=base_url('login/logout');?>">
            <i class="material-symbols-rounded opacity-5">login</i>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link text-dark" href="">
            <i class="material-symbols-rounded opacity-5">assignment</i>
            <span class="nav-link-text ms-1">Sign Up</span>
          </a>
        </li> -->
      </ul>
    </div>
    <!-- <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        <a class="btn btn-outline-dark mt-4 w-100" href="javascript:void(0);" type="button">Documentation</a>
      </div>
    </div> -->
  </aside>