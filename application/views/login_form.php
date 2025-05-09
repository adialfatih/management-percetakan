<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="manifest" href="manifest.json">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="application-name" content="Mitra Sahabat">
  <meta name="apple-mobile-web-app-title" content="Mitra Sahabat">
  <meta name="theme-color" content="#9dcafa">
  <meta name="msapplication-navbutton-color" content="#9dcafa">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="msapplication-starturl" content="/">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url();?>assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?=base_url();?>assets/img/favicon.png">
  <title>
    Login Dashboard - Mitra Sahabat
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="<?=base_url();?>assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="<?=base_url();?>assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="<?=base_url();?>assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  <style>
    .imgmob { display:none; }
    @media screen and (max-width: 768px) {
      .imgmob {
        width:100%;display:flex;justify-content:center;
      }
      .imgmob img {
        width:50%;
      }
    }
    
  </style>
</head>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center" style="background-image: url('<?=base_url();?>logo/front.png'); background-size: cover;">
              </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
              <div class="card card-plain">
                <div class="imgmob">
                  <img src="<?=base_url();?>logo/LOGO2.png" alt="LOGO MITRA SAHABAT">
                </div>
                <div class="card-header">
                  <h4 class="font-weight-bolder">Login Dashboard</h4>
                  <p class="mb-0">Masukan username dan password anda.</p>
                </div>
                <div class="card-body">
                  <form role="form" autocomplete="off" method="post" action="<?=base_url('proses-login');?>">
                    <div class="input-group input-group-outline mb-3">
                      <label for="username">Username</label>&nbsp;&nbsp;
                      <input type="text" id="username" name="username" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="input-group input-group-outline mb-3">
                      <label for="password">Password</label>&nbsp;&nbsp;
                      <input type="password" id="password" name="password" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-check form-check-info text-start ps-0">
                      
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg bg-gradient-dark btn-lg w-100 mt-4 mb-0">Log In</button>
                    </div>
                  </form>
                  <?php if ($this->session->flashdata('error')): ?>
                        <p style="color:red;"><?php echo $this->session->flashdata('error'); ?></p>
                  <?php endif; ?>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-2 text-sm mx-auto">
                    &copy; Team IT - Mitra Sahabat
                    <a href="javascript:void(0);" class="text-primary text-gradient font-weight-bold"><?=date('Y');?></a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!--   Core JS Files   -->
  <script src="<?=base_url();?>assets/js/core/popper.min.js"></script>
  <script src="<?=base_url();?>assets/js/core/bootstrap.min.js"></script>
  <script src="<?=base_url();?>assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="<?=base_url();?>assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('/serviceworker.js')
        .then(() => console.log('Service Worker terdaftar.'))
        .catch((error) => console.log('Pendaftaran Service Worker gagal:', error));
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?=base_url();?>assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>