<footer class="footer py-4  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              
            </div>
            <div class="col-lg-6">
              
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  
  <!--   Core JS Files   -->
  <script src="<?=base_url();?>assets/js/core/popper.min.js"></script>
  <script src="<?=base_url();?>assets/js/core/bootstrap.min.js"></script>
  <script src="<?=base_url();?>assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="<?=base_url();?>assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
  <script src="https://cdn.datatables.net/plug-ins/1.13.6/sorting/datetime-moment.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js" integrity="sha256-IW9RTty6djbi3+dyypxajC14pE6ZrP53DLfY9w40Xn4=" crossorigin="anonymous"></script>
  <?php if($customJS=="hutang"){ ?>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
    flatpickr("#tanggalProduksi", {
        dateFormat: "Y-m-d", // Format tanggal
        placeholder: "Pilih tanggal" // Placeholder custom
    }); 
        // document.getElementById('openModalButton1234').addEventListener('click', function() {
        //   $('#exampleModal234').modal('show');
        // });
        document.getElementById('closeModalButton23').addEventListener('click', function() {
          $('#exampleModal234').modal('hide');
        });
        function showCustomerBayar(cus){
            document.getElementById("modalLargeBody2").innerHTML = 'Please Wait...';
            $.ajax({
                url:"<?=base_url();?>prosesajax2/lihatBayarCus",
                type: "POST",
                data: {"id":cus},
                cache: false,
                success: function(dataResult){
                    setInterval(() => {
                      document.getElementById("modalLargeBody2").innerHTML = ''+dataResult;
                    }, 1200);
                    
                }
            });
            $('#exampleModal234').modal('show');
        }
    </script>
  <?php } ?>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    <?php if($setupdata=="yes"){?>
        document.getElementById('openModalButton234').addEventListener('click', function() {
          $('#exampleModal234').modal('show');
        });
        document.getElementById('closeModalButton234').addEventListener('click', function() {
          $('#exampleModal234').modal('hide');
        });
    <?php } ?>
    document.getElementById('openModalButton').addEventListener('click', function() {
      $('#exampleModal').modal('show');
    });
    <?php if($modalDoble=="yes"){ ?>
        document.getElementById('openModalButton23').addEventListener('click', function() {
            var namaSupplier = document.getElementById("namaSupplierIDModals").value;
            var tipeData = document.getElementById("tipeDataIDModals").value;
            document.getElementById("modalLargeBody").innerHTML = 'Please Wait...';
            $.ajax({
                url:"<?=base_url();?>prosesajax/lihatPembayaran",
                type: "POST",
                data: {"namaSupplier":namaSupplier, "tipeData":tipeData},
                cache: false,
                success: function(dataResult){
                    setInterval(() => {
                      document.getElementById("modalLargeBody").innerHTML = ''+dataResult;
                    }, 1200);
                    
                }
            });
            $('#exampleModal2').modal('show');
        });
        document.getElementById('closeModalButton23').addEventListener('click', function() {
          $('#exampleModal2').modal('hide');
        });
    <?php } ?>
    document.getElementById('closeModalButton').addEventListener('click', function() {
      $('#exampleModal').modal('hide');
    });
    
    // Inisialisasi DataTable
    
    <?php if($tipeTable=="baku"){ ?>
      $.fn.dataTable.moment('DD MMM YYYY');
      $('#myTable').DataTable({
          columnDefs: [
              { type: 'date', targets: 0 } // Tentukan kolom tanggal
          ],
          order: [[0, 'desc']]
      });
      
    <?php } else { ?>
      let table = new DataTable('#myTable');
    <?php } ?>
    function deletes(title,text,id,table){
      Swal.fire({
          title: ""+title+"",
          text: "Anda akan menghapus "+text+"",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        }).then((result) => {
          if (result.isConfirmed) {
            //console.log('id'+id+'table'+table);
            $.ajax({
              url:"<?=base_url();?>prosesajax/deletedata",
              type: "POST",
              data: {"table" : table, "id" : id},
                cache: false,
                success: function(dataResult){
                  var dataResult = JSON.parse(dataResult);
                  if(dataResult.statusCode == 200){
                      Swal.fire({
                        title: "Berhasil",
                        text: ""+dataResult.psn+"",
                        icon: "success"
                      }).then((result) => {
                        location.reload();
                      });
                  } else {
                    if(dataResult.statusCode == 201){
                      Swal.fire({ title: "Berhasil", text: ""+dataResult.psn+"", icon: "success" }).then((result) => {
                        loadTablePengiriman(dataResult.psn2);
                        //console.log(''+dataResult.psn2+'');
                      });
                    } else {
                      if(dataResult.statusCode == 202){
                          Swal.fire({ title: "Berhasil", text: ""+dataResult.psn+"", icon: "success" }).then((result) => {
                            location.reload();
                          });
                      } else {
                        Swal.fire({
                          title: "Gagal",
                          text: ""+dataResult.psn+"",
                          icon: "error"
                        });
                      }
                    }
                  }
                }
            });
          }
      });
    }
        $(document).ready(function () {
            $('#upload_file').on('change', function () {
                const file = this.files[0]; // Ambil file yang dipilih
                if (file) {
                    const fileName = file.name; // Nama file
                    const fileExtension = fileName.split('.').pop().toLowerCase(); // Ekstensi file

                    // Daftar ekstensi file yang diperbolehkan
                    const allowedExtensions = ['xls', 'xlsx'];

                    // Validasi ekstensi file
                    if (!allowedExtensions.includes(fileExtension)) {
                        // Reset nilai input file
                        $(this).val('');

                        // Tampilkan pesan error menggunakan SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid File',
                            text: 'Please upload a valid Excel file (.xls, .xlsx).',
                            confirmButtonColor: '#d33'
                        });
                    }
                }
            });
            // Data untuk autocomplete
            
        });
        function teschange(){
            const namaBarangList = document.getElementById("namabarangList");
            namaBarangList.innerHTML = '';
            $('#load1').html('Loading...');
            const datas = $('#jenisBarang').val();
            $.ajax({
              url:"<?=base_url();?>prosesajax/cariJenisBaku",
              type: "POST",
              data: {"datas" : datas},
                cache: false,
                success: function(dataResult){
                  const data = JSON.parse(dataResult);
                  if(data.statusCode == 200){
                      data.psn.forEach(function(item) {
                          const option = document.createElement("option");
                          option.value = item; // Menambahkan nama barang ke dalam option
                          namaBarangList.appendChild(option);
                      });
                  } else {
                      namaBarangList.innerHTML = '';
                  }
                  //console.log(JSON.stringify(data));
                  $('#load1').html('');
                }
            });
        }
        function teschange2(){
            const namaBarangList = document.getElementById("namabarangListBantu");
            namaBarangList.innerHTML = '';
            $('#load2').html('Loading...');
            const datas = $('#jenisBarangBantu').val();
            $.ajax({
              url:"<?=base_url();?>prosesajax/cariJenisBantu",
              type: "POST",
              data: {"datas" : datas},
                cache: false,
                success: function(dataResult){
                  const data = JSON.parse(dataResult);
                  if(data.statusCode == 200){
                      data.psn.forEach(function(item) {
                          const option = document.createElement("option");
                          option.value = item; // Menambahkan nama barang ke dalam option
                          namaBarangList.appendChild(option);
                      });
                  } else {
                      namaBarangList.innerHTML = '';
                  }
                  //console.log(JSON.stringify(data));
                  $('#load2').html('');
                }
            });
        }
        function teschange21(){
            const namaBarangList = document.getElementById("namabarangListBantu");
            namaBarangList.innerHTML = '';
            $('#load2').html('Loading...');
            const datas = $('#jenisBarangBantu').val();
            $.ajax({
              url:"<?=base_url();?>prosesajax/cariJenisSpare",
              type: "POST",
              data: {"datas" : datas},
                cache: false,
                success: function(dataResult){
                  const data = JSON.parse(dataResult);
                  if(data.statusCode == 200){
                      data.psn.forEach(function(item) {
                          const option = document.createElement("option");
                          option.value = item; // Menambahkan nama barang ke dalam option
                          namaBarangList.appendChild(option);
                      });
                  } else {
                      namaBarangList.innerHTML = '';
                  }
                  //console.log(JSON.stringify(data));
                  $('#load2').html('');
                }
            });
        }
        function teschange3(){
            const namaBarangList = document.getElementById("ukuranbarangListBaku");
            namaBarangList.innerHTML = '';
            $('#load4').html('Loading...');
            const datas = $('#jenisBarang').val();
            const datas2 = $('#namaBarang').val();
            //console.log(datas+'--'+datas2);
            $.ajax({
              url:"<?=base_url();?>prosesajax/cariJenisBaku2",
              type: "POST",
              data: {"datas" : datas, "datas2" : datas2},
                cache: false,
                success: function(dataResult){
                  const data = JSON.parse(dataResult);
                  //console.log(data);
                  if(data.statusCode == 200){
                      //console.log(data.psn);
                      data.psn.forEach(function(item) {
                          const option = document.createElement("option");
                          option.value = item; // Menambahkan nama barang ke dalam option
                          namaBarangList.appendChild(option);
                      });
                  } else {
                      namaBarangList.innerHTML = '';
                  }
                  //console.log(JSON.stringify(data));
                  $('#load4').html('');
                }
            });
        }
        function teschange4(){
            const namaBarangList = document.getElementById("ukuranbarangListBantu");
            namaBarangList.innerHTML = '';
            $('#load4').html('Loading...');
            const datas = $('#jenisBarangBantu').val();
            const datas2 = $('#namaBarangBantu').val();
            //console.log(datas+'--'+datas2);
            $.ajax({
              url:"<?=base_url();?>prosesajax/cariJenisBantu2",
              type: "POST",
              data: {"datas" : datas, "datas2" : datas2},
                cache: false,
                success: function(dataResult){
                  const data = JSON.parse(dataResult);
                  //console.log(data);
                  if(data.statusCode == 200){
                      //console.log(data.psn);
                      data.psn.forEach(function(item) {
                          const option = document.createElement("option");
                          option.value = item; // Menambahkan nama barang ke dalam option
                          namaBarangList.appendChild(option);
                      });
                  } else {
                      namaBarangList.innerHTML = '';
                  }
                  //console.log(JSON.stringify(data));
                  $('#load4').html('');
                }
            });
        }
        function teschange41(){
            const namaBarangList = document.getElementById("ukuranbarangListBantu");
            namaBarangList.innerHTML = '';
            $('#load4').html('Loading...');
            const datas = $('#jenisBarangBantu').val();
            const datas2 = $('#namaBarangBantu').val();
            //console.log(datas+'--'+datas2);
            $.ajax({
              url:"<?=base_url();?>prosesajax/cariJenisSpare2",
              type: "POST",
              data: {"datas" : datas, "datas2" : datas2},
                cache: false,
                success: function(dataResult){
                  const data = JSON.parse(dataResult);
                  //console.log(data);
                  if(data.statusCode == 200){
                      //console.log(data.psn);
                      data.psn.forEach(function(item) {
                          const option = document.createElement("option");
                          option.value = item; // Menambahkan nama barang ke dalam option
                          namaBarangList.appendChild(option);
                      });
                  } else {
                      namaBarangList.innerHTML = '';
                  }
                  //console.log(JSON.stringify(data));
                  $('#load4').html('');
                }
            });
        }
        function formatNumber2(input) {
            let value = input.value;
            value = value.replace(/[^0-9]/g, "");
            input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        function formatNumber(input) {
            let value = input.value;
            value = value.replace(/[^0-9.]/g, "");
            let parts = value.split(".");
            if (parts.length > 2) {
                value = parts[0] + "." + parts.slice(1).join("");
            }
            parts = value.split(".");
            if (parts[1]) {
                parts[1] = parts[1].substring(0, 4);
            }
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            input.value = parts.join(".");
        }
        $( "#addBahanBaku" ).on( "click" , function() {
            const codeInput = document.getElementById("codeInput").value;
            const sj = document.getElementById("sj").value;
            const tanggalMasuk = document.getElementById("tanggalMasuk").value;
            const namaSupplier = document.getElementById("namaSupplier").value;
            const totalHarga = document.getElementById("totalHarga").value;

            const jenisBarang = document.getElementById("jenisBarang").value;
            const namaBarang = document.getElementById("namaBarang").value;
            const ukuranBarang = document.getElementById("ukuranBarang").value;
            const satuanUkuran = document.getElementById("satuanUkuran").value;
            const jumlahBarang = document.getElementById("jumlahBarang").value;
            const satuanJumlah = document.getElementById("satuanJumlah").value;
            const prespajak = document.getElementById("prespajak").value;
            const notaSementaraValue = document.getElementById("notaSementaraValue").value;
            const hargaSatuanBarang = document.getElementById("hargaSatuanBarang").value;
            const ketBarang = document.getElementById("ketBarang").value;
            if(codeInput == ""){
                Swal.fire('Info','Anda perlu merefresh halaman ini!!','info');
            } else {
                if(sj == ""){
                    Swal.fire('Info','Anda perlu mengisi Nomor Surat Jalan / Nota!!','info');
                } else {
                    if(tanggalMasuk == ""){
                        Swal.fire('Info','Anda perlu mengisi Tanggal Masuk!!','info');
                    } else {
                        if(namaSupplier == ""){
                            Swal.fire('Info','Anda perlu mengisi Nama Supplier!!','info');
                        } else {
                            if(jenisBarang!="" && namaBarang!="" && ukuranBarang!="" && satuanUkuran!="" && jumlahBarang!="" && satuanJumlah!="" && hargaSatuanBarang!=""){
                                $.ajax({
                                  url:"<?=base_url();?>prosesajax/inputDataMasuk",
                                  type: "POST",
                                  data: {"codeInput":codeInput, "sj":sj, "tanggalMasuk":tanggalMasuk, "namaSupplier":namaSupplier, "totalHarga":totalHarga, "namaBarang":namaBarang, "ukuranBarang":ukuranBarang, "satuanUkuran":satuanUkuran, "jumlahBarang":jumlahBarang, "satuanJumlah":satuanJumlah, "hargaSatuanBarang":hargaSatuanBarang, "ketBarang":ketBarang, "jenisBarang":jenisBarang, "prespajak":prespajak,"notaSementaraValue":notaSementaraValue},
                                    cache: false,
                                    success: function(dataResult){
                                      const data = JSON.parse(dataResult);
                                      if(data.statusCode == 200){
                                          Swal.fire('Berhasil',data.psn,'success');
                                          document.getElementById("jenisBarang").value = '';
                                          document.getElementById("namaBarang").value = '';
                                          document.getElementById("ukuranBarang").value = '';
                                          document.getElementById("jumlahBarang").value = '';
                                          document.getElementById("hargaSatuanBarang").value = '';
                                          document.getElementById("ketBarang").value = '';
                                          loadTablePengiriman(codeInput);
                                      } else {
                                          Swal.fire('Gagal',data.psn,'error');
                                      }
                                    }
                                });
                            } else {
                              Swal.fire('Warning','Anda harus mengisi data dengan benar!!','warning');
                            }
                        }
                    }
                }
            }
        } ); //end addBahanBaku-
        
        $( "#addBahanSpare" ).on( "click" , function() {
            const codeInput = document.getElementById("codeInput").value;
            const sj = document.getElementById("sj").value;
            const tanggalMasuk = document.getElementById("tanggalMasuk").value;
            const namaSupplier = document.getElementById("namaSupplier").value;
            const totalHarga = document.getElementById("totalHarga").value;

            const jenisBarang = document.getElementById("jenisBarangBantu").value;
            const namaBarang = document.getElementById("namaBarangBantu").value;
            const ukuranBarang = document.getElementById("ukuranBarangBantu").value;
            const satuanUkuran = document.getElementById("satuanUkuranBantu").value;
            const jumlahBarang = document.getElementById("jumlahBarangBantu").value;
            const satuanJumlah = document.getElementById("satuanJumlahBantu").value;
            const prespajak = document.getElementById("prespajak").value;
            const notaSementaraValue = document.getElementById("notaSementaraValue").value;
            const hargaSatuanBarang = document.getElementById("hargaSatuanBarangBantu").value;
            const ketBarang = document.getElementById("ketBarangBantu").value;
            if(codeInput == ""){
                Swal.fire('Info','Anda perlu merefresh halaman ini!!','info');
            } else {
                if(sj == ""){
                    Swal.fire('Info','Anda perlu mengisi Nomor Surat Jalan / Nota!!','info');
                } else {
                    if(tanggalMasuk == ""){
                        Swal.fire('Info','Anda perlu mengisi Tanggal Masuk!!','info');
                    } else {
                        if(namaSupplier == ""){
                            Swal.fire('Info','Anda perlu mengisi Nama Supplier!!','info');
                        } else {
                            if(jenisBarang!="" && namaBarang!="" && ukuranBarang!="" && satuanUkuran!="" && jumlahBarang!="" && satuanJumlah!="" && hargaSatuanBarang!=""){
                                $.ajax({
                                  url:"<?=base_url();?>prosesajax/inputDataMasuk3",
                                  type: "POST",
                                  data: {"codeInput":codeInput, "sj":sj, "tanggalMasuk":tanggalMasuk, "namaSupplier":namaSupplier, "totalHarga":totalHarga, "namaBarang":namaBarang, "ukuranBarang":ukuranBarang, "satuanUkuran":satuanUkuran, "jumlahBarang":jumlahBarang, "satuanJumlah":satuanJumlah, "hargaSatuanBarang":hargaSatuanBarang, "ketBarang":ketBarang, "jenisBarang":jenisBarang, "prespajak":prespajak,"notaSementaraValue":notaSementaraValue},
                                    cache: false,
                                    success: function(dataResult){
                                      const data = JSON.parse(dataResult);
                                      if(data.statusCode == 200){
                                          Swal.fire('Berhasil',data.psn,'success');
                                          document.getElementById("jenisBarangBantu").value = '';
                                          document.getElementById("namaBarangBantu").value = '';
                                          document.getElementById("ukuranBarangBantu").value = '';
                                          document.getElementById("jumlahBarangBantu").value = '';
                                          document.getElementById("hargaSatuanBarangBantu").value = '';
                                          document.getElementById("ketBarangBantu").value = '';
                                          loadTablePengiriman(codeInput);
                                      } else {
                                          Swal.fire('Gagal',data.psn,'error');
                                      }
                                    }
                                });
                            } else {
                              Swal.fire('Warning','Anda harus mengisi data dengan benar!!','warning');
                            }
                        }
                    }
                }
            }
        });
        $( "#addBahanBantu" ).on( "click" , function() {
            const codeInput = document.getElementById("codeInput").value;
            const sj = document.getElementById("sj").value;
            const tanggalMasuk = document.getElementById("tanggalMasuk").value;
            const namaSupplier = document.getElementById("namaSupplier").value;
            const totalHarga = document.getElementById("totalHarga").value;

            const jenisBarang = document.getElementById("jenisBarangBantu").value;
            const namaBarang = document.getElementById("namaBarangBantu").value;
            const ukuranBarang = document.getElementById("ukuranBarangBantu").value;
            const satuanUkuran = document.getElementById("satuanUkuranBantu").value;
            const jumlahBarang = document.getElementById("jumlahBarangBantu").value;
            const satuanJumlah = document.getElementById("satuanJumlahBantu").value;
            const prespajak = document.getElementById("prespajak").value;
            const notaSementaraValue = document.getElementById("notaSementaraValue").value;
            const hargaSatuanBarang = document.getElementById("hargaSatuanBarangBantu").value;
            const ketBarang = document.getElementById("ketBarangBantu").value;
            if(codeInput == ""){
                Swal.fire('Info','Anda perlu merefresh halaman ini!!','info');
            } else {
                if(sj == ""){
                    Swal.fire('Info','Anda perlu mengisi Nomor Surat Jalan / Nota!!','info');
                } else {
                    if(tanggalMasuk == ""){
                        Swal.fire('Info','Anda perlu mengisi Tanggal Masuk!!','info');
                    } else {
                        if(namaSupplier == ""){
                            Swal.fire('Info','Anda perlu mengisi Nama Supplier!!','info');
                        } else {
                            if(jenisBarang!="" && namaBarang!="" && ukuranBarang!="" && satuanUkuran!="" && jumlahBarang!="" && satuanJumlah!="" && hargaSatuanBarang!=""){
                                $.ajax({
                                  url:"<?=base_url();?>prosesajax/inputDataMasuk2",
                                  type: "POST",
                                  data: {"codeInput":codeInput, "sj":sj, "tanggalMasuk":tanggalMasuk, "namaSupplier":namaSupplier, "totalHarga":totalHarga, "namaBarang":namaBarang, "ukuranBarang":ukuranBarang, "satuanUkuran":satuanUkuran, "jumlahBarang":jumlahBarang, "satuanJumlah":satuanJumlah, "hargaSatuanBarang":hargaSatuanBarang, "ketBarang":ketBarang, "jenisBarang":jenisBarang, "prespajak":prespajak,"notaSementaraValue":notaSementaraValue},
                                    cache: false,
                                    success: function(dataResult){
                                      const data = JSON.parse(dataResult);
                                      if(data.statusCode == 200){
                                          Swal.fire('Berhasil',data.psn,'success');
                                          document.getElementById("jenisBarangBantu").value = '';
                                          document.getElementById("namaBarangBantu").value = '';
                                          document.getElementById("ukuranBarangBantu").value = '';
                                          document.getElementById("jumlahBarangBantu").value = '';
                                          document.getElementById("hargaSatuanBarangBantu").value = '';
                                          document.getElementById("ketBarangBantu").value = '';
                                          loadTablePengiriman(codeInput);
                                      } else {
                                          Swal.fire('Gagal',data.psn,'error');
                                      }
                                    }
                                });
                            } else {
                              Swal.fire('Warning','Anda harus mengisi data dengan benar!!','warning');
                            }
                        }
                    }
                }
            }
        } ); //end addBahanBantu
        <?php if($customJS=="bakuinput"){ ?>
            function loadTablePengiriman(id){
                if(id == 0){
                    $('#showTablePengiriman').html('');
                } else {
                  $.ajax({
                      url:"<?=base_url();?>prosesajax/showTablePengiriman",
                      type: "POST",
                      data: {"id":id},
                      cache: false,
                      success: function(dataResult){
                          $('#showTablePengiriman').html(dataResult);
                      }
                  });
                  $.ajax({
                      url:"<?=base_url();?>prosesajax/ambilTotalHarga",
                      type: "POST",
                      data: {"id":id},
                      cache: false,
                      success: function(dataResult){
                          var data = JSON.parse(dataResult);
                          document.getElementById("totalHarga").value = data.psn;
                      }
                  });
                }
            } //end function - loadTablePengiriman
            var idload = document.getElementById("codeInput").value;
            loadTablePengiriman(idload);
        <?php } ?>
        <?php if($customJS=="bakuinput2"){ ?>
            function loadTablePengiriman(id){
                if(id == 0){
                    $('#showTablePengiriman').html('');
                } else {
                  $.ajax({
                      url:"<?=base_url();?>prosesajax/showTablePengiriman",
                      type: "POST",
                      data: {"id":id,"spare":"yes"},
                      cache: false,
                      success: function(dataResult){
                          $('#showTablePengiriman').html(dataResult);
                      }
                  });
                  $.ajax({
                      url:"<?=base_url();?>prosesajax/ambilTotalHarga",
                      type: "POST",
                      data: {"id":id,"spare":"yes"},
                      cache: false,
                      success: function(dataResult){
                          var data = JSON.parse(dataResult);
                          document.getElementById("totalHarga").value = data.psn;
                      }
                  });
                }
            } //end function - loadTablePengiriman
            var idload = document.getElementById("codeInput").value;
            loadTablePengiriman(idload);
        <?php } ?>
        <?php if($customJS=="pemakaianbahan"){ ?>
          function cekJenis(){
            var jenis = document.getElementById("jenisBahan").value;
            var tipeOut = document.getElementById("tipeOut").value;
            const namaBarangList = document.getElementById("cekNamaBahan");
            namaBarangList.innerHTML = '';
            $('#load1').html('Loading...');
            //console.log(jenis+'--'+tipeOut);
              $.ajax({
                url:"<?=base_url();?>prosesajax/cariJenisStok",
                type: "POST",
                data: {"jenis" : jenis, "tipeOut" : tipeOut},
                  cache: false,
                  success: function(dataResult){
                    const data = JSON.parse(dataResult);
                    //console.log(data);
                    if(data.statusCode == 200){
                        //console.log(data.psn);
                        data.psn.forEach(function(item) {
                            const option = document.createElement("option");
                            option.value = item; // Menambahkan nama barang ke dalam option
                            namaBarangList.appendChild(option);
                        });
                        document.getElementById("namaBahan").disabled = false;
                    } else {
                        namaBarangList.innerHTML = '';
                        document.getElementById("namaBahan").value = '';
                        document.getElementById("namaBahan").disabled = true;
                    }
                    //console.log(JSON.stringify(data));
                    $('#load1').html('');
                  }
              });
              cekTotalStok();
          }
          function cekJenisDanNama(){
            var jenis = document.getElementById("jenisBahan").value;
            var tipeOut = document.getElementById("tipeOut").value;
            var namaBahan = document.getElementById("namaBahan").value;
            const namaBarangList = document.getElementById("cekUkuranBahan");
            namaBarangList.innerHTML = '';
            $('#load2').html('Loading...');
            //console.log(jenis+'--'+tipeOut);
              $.ajax({
                url:"<?=base_url();?>prosesajax/cariJenisNamaStok",
                type: "POST",
                data: {"jenis" : jenis, "tipeOut" : tipeOut, "namaBahan" : namaBahan},
                  cache: false,
                  success: function(dataResult){
                    const data = JSON.parse(dataResult);
                    //console.log(data);
                    if(data.statusCode == 200){
                        //console.log(data.psn);
                        data.psn.forEach(function(item) {
                            const option = document.createElement("option");
                            option.value = item; // Menambahkan nama barang ke dalam option
                            namaBarangList.appendChild(option);
                        });
                        document.getElementById("ukuranBahan").disabled = false;
                    } else {
                        namaBarangList.innerHTML = '';
                        document.getElementById("ukuranBahan").value = '';
                        document.getElementById("ukuranBahan").disabled = true;
                    }
                    //console.log(JSON.stringify(data));
                    $('#load2').html('');
                  }
              });
              cekTotalStok();
          }
          function cekTotalStok(){
              var jenis = document.getElementById("jenisBahan").value;
              var tipeOut = document.getElementById("tipeOut").value;
              var namaBahan = document.getElementById("namaBahan").value;
              var ukuranBahan = document.getElementById("ukuranBahan").value;
              if(jenis != '' && tipeOut != '' && namaBahan != '' && ukuranBahan != ''){
                  $('#load3').html('Sedang memuat jumlah stok...');
                  $.ajax({
                      url:"<?=base_url();?>prosesajax/cekTotalStok",
                      type: "POST",
                      data: {"jenis" : jenis, "tipeOut" : tipeOut, "namaBahan" : namaBahan, "ukuranBahan" : ukuranBahan},
                      cache: false,
                      success: function(dataResult){
                          var data = JSON.parse(dataResult);
                          if(data.statusCode == 200){
                              $('#btnSimpan').attr('disabled',false);
                              $('#load3').html(data.psn);
                          } else {
                              $('#btnSimpan').attr('disabled',true);
                              $('#load3').html(data.psn);
                          }
                      }
                  });
                  //$('#btnSimpan').attr('disabled',false);
              } else {
                  $('#btnSimpan').attr('disabled',true);
                  $('#load3').html('');
              }
          }
        <?php } if($spareinput=="yes"){?>
        function pakailangsung(checkbox, id){
            $('#idBantuin').val(''+id);
            if (checkbox.checked) { 
                var datacek = "yes"; 
                $('#exampleModal').modal('show');
            } else { 
              var datacek = "no"; 
              $.ajax({
                url:"<?=base_url();?>proses/delpemakaianlangsung",
                type: "POST",
                data: {"id" : id},
                cache: false,
                success: function(dataResult){
                  var data = JSON.parse(dataResult);
                  if(data.statusCode == 200){} else {
                    Swal.fire({title: "Error",text: ""+dataResult.psn+"",icon: "error"});
                  }
                }
              });
            }
            
        }
        document.getElementById('closeModalButton98').addEventListener('click', function() {
          location.reload();
        });
        <?php } ?>
        function changeHarga(id){
            $('#exampleModal266').modal('show');
            $('#idStokUpdate').val(''+id);
        }
        function thisDismis(){
            $('#exampleModal266').modal('hide');
        }
        function updateNotaSementara(id){
          $.ajax({
                url:"<?=base_url();?>prosesajax2/cariNota",
                type: "POST",
                data: {"id" : id},
                cache: false,
                success: function(dataResult){
                  var data = JSON.parse(dataResult);
                  console.log(dataResult);
                  if(data.statusCode == 200){
                      $('#nonota45').val(''+data.sj);
                      $('#nonota452').val(''+data.nonota);
                      $('#tglnota23').val(''+data.tgl);
                      $('#nominal24').val(''+data.ttl);
                      $('#idPembelianNota').val(''+id);
                      $('#exampleModal').modal('show');
                  } else {
                      Swal.fire({title: "Error",text: ""+data.psn+"",icon: "error"});
                  }
                }
          });
        }
  </script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?=base_url();?>assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>