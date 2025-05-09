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
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">&raquo; Account pages</h6>
        </li>
        
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