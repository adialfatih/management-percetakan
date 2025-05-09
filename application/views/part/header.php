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
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url();?>assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?=base_url();?>assets/img/favicon.png">
  <title>
    <?=$title;?>
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" integrity="sha256-ZCK10swXv9CN059AmZf9UzWpJS34XvilDMJ79K+WOgc=" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
  <style>
      .form-dta {
          width: 100%;
          display: flex;
          gap:15px;
          align-items:center;
          margin-bottom:10px;
      }
      .form-dta.nomarg {margin-bottom:0px;}
      /* Styling umum untuk input */
      input.form-control2, textarea.form-control2 {
          display: block;
          width: 100%;
          padding: 10px 15px;
          font-size: 16px;
          color: #495057;
          background-color: #fff;
          background-clip: padding-box;
          border: 1px solid #ced4da;
          border-radius: 4px;
          transition: border-color 0.3s ease, box-shadow 0.3s ease;
          box-sizing: border-box;
      }

      /* Fokus pada input */
      input.form-control2:focus {
          border-color: #007bff;
          outline: none;
          box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
      }

      /* Hover pada input */
      input.form-control2:hover {
          border-color: #007bff;
      }

      /* Styling untuk placeholder */
      input.form-control2::placeholder {
          color: #6c757d;
          opacity: 1;
      }

      /* Styling untuk input saat valid */
      input.form-control2.is-valid {
          border-color: #28a745;
          box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
      }

      /* Styling untuk input saat invalid */
      input.form-control2.is-invalid {
          border-color: #dc3545;
          box-shadow: 0 0 5px rgba(220, 53, 69, 0.5);
      }
      @media screen and (max-width: 768px) {
        .form-dta { flex-direction: column; align-items: flex-start; }
      }
      .form-dta label {
          width: 200px;
          color:#000;
          text-align: left;
      }
      /* Styling untuk select box agar mirip dengan Bootstrap */
      .select-box {
          display: inline-block;
          width: 100%;
          max-width: 400px;
          border: 1px solid #ced4da;  /* Warna border */
          border-radius: 0.375rem; /* Radius border (rounded corners) */
          background-color: #fff; /* Latar belakang putih */
          color: #495057; /* Warna teks */
          transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; 
          padding: 10px 15px;
          font-size: 16px;
          color: #495057;
          background-color: #fff;
          background-clip: padding-box;
          border: 1px solid #ced4da;
          border-radius: 4px;
          transition: border-color 0.3s ease, box-shadow 0.3s ease;
          box-sizing: border-box;
      }

      /* Warna border saat fokus */
      .select-box:focus {
          border-color: #80bdff;  /* Warna border saat fokus */
          outline: none;  /* Menghilangkan outline */
          box-shadow: 0 0 0 0.25rem rgba(38, 143, 255, 0.25); /* Efek shadow saat fokus */
      }

      /* Styling untuk select box dengan ukuran kecil (optional) */
      .select-box-sm {
          font-size: 0.875rem;
          padding: 0.25rem 0.5rem;
      }

      /* Styling untuk select box dengan ukuran besar (optional) */
      .select-box-lg {
          font-size: 1.25rem;
          padding: 0.5rem 1rem;
      }

      /* Styling untuk select box saat dalam keadaan disabled */
      .select-box:disabled {
          background-color: #e9ecef;  /* Warna latar belakang saat disabled */
          color: #6c757d;  /* Warna teks saat disabled */
          cursor: not-allowed;  /* Menonaktifkan pointer */
      }

      /* Styling untuk select box dengan pilihan default */
      .select-box option {
          background-color: #fff; /* Latar belakang opsi */
          color: #495057; /* Warna teks */
      }

      /* Hover effect untuk option */
      .select-box option:hover {
          background-color: #f8f9fa; /* Warna latar belakang saat hover */
      }
      .loader {
        width: fit-content;
        font-weight: bold;
        font-family: monospace;
        font-size: 20px;
        clip-path: inset(0 100% 0 0);
        animation: l5 2s steps(11) infinite;
      }
      .loader:before {
        content:"Loading..."
      }
      @keyframes l5 {to{clip-path: inset(0 -1ch 0 0)}}
      
  </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
<?php  $this->load->view('part/sidebar'); ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-0 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm opacity-0 active" aria-current="page" style="color:#fff;"><?=$page;?></li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            
          </div>
          <ul class="navbar-nav d-flex align-items-center justify-content-end">
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>