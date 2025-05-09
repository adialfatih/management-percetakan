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
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#tanggalProduksi", {
        dateFormat: "Y-m-d", // Format tanggal
        placeholder: "Pilih tanggal" // Placeholder custom
    });

    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
   
    document.getElementById('closeModalButton').addEventListener('click', function() {
      $('#exampleModal').modal('hide');
    });
    document.getElementById('closeModalButton2').addEventListener('click', function() {
      $('#exampleModal2').modal('hide');
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
        <?php if($showData=="produksi"){?>
        document.getElementById('openModalButton').addEventListener('click', function() {
            $('#exampleModal').modal('show');
            $('#exampleModalLabel').html('Input Produksi');
            $('#tanggalProduksi').val('');
            $('#produksiID').val('');
            $('#jmlProduksiID').val('');
            $('#hargaSatuan').val('');
            $('#tipesave').val('add');
        });
        document.getElementById('openModalButton645').addEventListener('click', function() {
            $('#exampleModal2566').modal('show');
        });
        document.getElementById('closeModalButton3252').addEventListener('click', function() {
            $('#exampleModal2566').modal('hide');
        });
        function loadProduksi(){
            $.ajax({
                url:"<?=base_url();?>prosesajax2/loadproduksi",
                type: "POST",
                data: {"jenis" : "jenis"},
                cache: false,
                success: function(dataResult){
                    $('#myTable').DataTable().destroy();
                    $('#showProduksi').html(dataResult);
                    $('#myTable').DataTable({
                        "serverSide": false,
                        "draw": 1,
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        columnDefs: [
                            { type: 'date', targets: 0 } // Tentukan kolom tanggal
                        ],
                        order: [[0, 'desc']]
                    });
                }
            });
        }
        loadProduksi();
        function editdt(id,produksi,jumlah,harga_satuan,tgl,jns){
            $('#exampleModal2').modal('show'); 
            $('#exampleModalLabel2').html('Udate Produksi');
            $('#tanggalProduksi2').val(''+tgl+'');
            $('#produksiID245').val(''+produksi);
            $('#jnsEdit').val(''+jns);
            $('#jmlProduksiID2').val(''+jumlah);
            $('#hargaSatuan2').val(''+harga_satuan);
            $('#tipesave2').val(''+id);
        }
        <?php } ?>
        <?php if($showData=="listrik"){?>
        document.getElementById('openModalButton').addEventListener('click', function() {
            $('#exampleModal').modal('show');
        });
        function loadProduksi(){
            $.ajax({
                url:"<?=base_url();?>prosesajax2/loadlistrik",
                type: "POST",
                data: {"jenis" : "jenis"},
                cache: false,
                success: function(dataResult){
                    $('#myTable').DataTable().destroy();
                    $('#showProduksi').html(dataResult);
                    $('#myTable').DataTable({
                        "serverSide": false,
                        "draw": 1,
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        columnDefs: [
                            { type: 'date', targets: 0 } // Tentukan kolom tanggal
                        ],
                        order: [[0, 'desc']]
                    });
                }
            });
        }
        loadProduksi();
        <?php } ?>
        <?php if($showData=="penyusutan"){?>
        document.getElementById('openModalButton').addEventListener('click', function() {
            $('#exampleModal').modal('show');
        });
        function loadProduksi(){
            $.ajax({
                url:"<?=base_url();?>prosesajax2/loadpenyusutan",
                type: "POST",
                data: {"jenis" : "jenis"},
                cache: false,
                success: function(dataResult){
                    $('#myTable').DataTable().destroy();
                    $('#showProduksi').html(dataResult);
                    $('#myTable').DataTable({
                        "serverSide": false,
                        "draw": 1,
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        columnDefs: [
                            { type: 'date', targets: 0 } // Tentukan kolom tanggal
                        ],
                        order: [[0, 'desc']]
                    });
                }
            });
        }
        loadProduksi();
        <?php } 
         if($showData=="thr"){?>
        document.getElementById('openModalButton').addEventListener('click', function() {
            $('#exampleModal').modal('show');
        });
        function loadProduksi(){
            $.ajax({
                url:"<?=base_url();?>prosesajax2/loadthr",
                type: "POST",
                data: {"jenis" : "jenis"},
                cache: false,
                success: function(dataResult){
                    $('#myTable').DataTable().destroy();
                    $('#showProduksi').html(dataResult);
                    $('#myTable').DataTable({
                        "serverSide": false,
                        "draw": 1,
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        columnDefs: [
                            { type: 'date', targets: 0 } // Tentukan kolom tanggal
                        ],
                        order: [[0, 'desc']]
                    });
                }
            });
        }
        loadProduksi();
        <?php }
        if($showData=="manpower"){ ?>
        document.getElementById('openModalButton').addEventListener('click', function() {
            $('#exampleModal').modal('show');
        });
        function loadProduksi(){
            $.ajax({
                url:"<?=base_url();?>prosesajax2/manpower",
                type: "POST",
                data: {"jenis" : "jenis"},
                cache: false,
                success: function(dataResult){
                    $('#myTable').DataTable().destroy();
                    $('#showProduksi').html(dataResult);
                    $('#myTable').DataTable({
                        "serverSide": false,
                        "draw": 1,
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        columnDefs: [
                            { type: 'date', targets: 0 } // Tentukan kolom tanggal
                        ],
                        order: [[0, 'desc']]
                    });
                }
            });
        }
        loadProduksi();
        <?php 
        } 
         if($showData=="Pemeliharaan"){?>
        document.getElementById('openModalButton').addEventListener('click', function() {
            $('#exampleModal').modal('show');
        });
        function loadProduksi(){
            $.ajax({
                url:"<?=base_url();?>prosesajax2/loadpemeliharaan",
                type: "POST",
                data: {"jenis" : "jenis"},
                cache: false,
                success: function(dataResult){
                    $('#myTable').DataTable().destroy();
                    $('#showProduksi').html(dataResult);
                    $('#myTable').DataTable({
                        "serverSide": false,
                        "draw": 1,
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        columnDefs: [
                            { type: 'date', targets: 0 } // Tentukan kolom tanggal
                        ],
                        order: [[0, 'desc']]
                    });
                }
            });
        }
        loadProduksi();
        <?php }
        if($showData=="Lain-lain"){ ?>
        document.getElementById('openModalButton').addEventListener('click', function() {
            $('#exampleModal').modal('show');
        });
        function loadProduksi(){
            $.ajax({
                url:"<?=base_url();?>prosesajax2/loadpemeliharaan",
                type: "POST",
                data: {"jenis" : "lain"},
                cache: false,
                success: function(dataResult){
                    $('#myTable').DataTable().destroy();
                    $('#showProduksi').html(dataResult);
                    $('#myTable').DataTable({
                        "serverSide": false,
                        "draw": 1,
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        columnDefs: [
                            { type: 'date', targets: 0 } // Tentukan kolom tanggal
                        ],
                        order: [[0, 'desc']]
                    });
                }
            });
        }
        loadProduksi();
        <?php
        }
        if($showData=="penjualan"){?>
        document.getElementById('openModalButton3').addEventListener('click', function() {
            location.href = "<?=base_url();?>input/penjualan";
        });
        function loadProduksi(){
            $.ajax({
            url:"<?=base_url();?>prosesajax2/loadpenjualan2",
                type: "POST",
                data: {"jenis" : "jenis"},
                cache: false,
                success: function(dataResult){
                    $('#myTable').DataTable().destroy();
                    $('#showProduksi').html(dataResult);
                    $('#myTable').DataTable({
                        "serverSide": false,
                        "draw": 1,
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        columnDefs: [
                            { type: 'date', targets: 0 } // Tentukan kolom tanggal
                        ],
                        order: [[0, 'desc']]
                    });
                }
            });
        }
        loadProduksi();
        <?php } ?>
        function deletes(tipe,id,text){
          Swal.fire({
          title: "Hapus Data ?",
          text: ""+text+"",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Hapus"
              }).then((result) => {
                if (result.isConfirmed) {
                  console.log('id-'+id+'-table-'+tipe);
                  $.ajax({
                    url:"<?=base_url();?>prosesajax2/deletedata",
                    type: "POST",
                    data: {"tipe" : tipe, "id" : id},
                      cache: false,
                      success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode == 200){
                          Swal.fire({ title: "Berhasil",text: ""+dataResult.psn+"", icon: "success"
                            }).then((result) => { location.reload(); });
                        } else {
                          Swal.fire({ title: "Gagal",text: ""+dataResult.psn+"",icon: "error"});
                            
                        }
                      }
                  });
                }
            });
        }
        function teschange21(){
            const namaBarangList = document.getElementById("namabarangListBantu");
            namaBarangList.innerHTML = '';
            $('#load2').html('Loading...');
            const datas = $('#jenisBarangBantu').val();
            $.ajax({
              url:"<?=base_url();?>prosesajax2/cariJenisBarangJadi",
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
        <?php if($customJS=="penjualan"){ ?>
        function loadInputJual(id){
            $.ajax({
              url:"<?=base_url();?>prosesajax2/loadPenjualan",
              type: "POST",
              data: {"id" : id},
                cache: false,
                success: function(dataResult){
                    $('#showTablePengiriman').html(dataResult);
                }
            });
            $.ajax({
              url:"<?=base_url();?>prosesajax2/loadPenjualanHarga",
              type: "POST",
              data: {"id" : id},
                cache: false,
                success: function(dataResult){
                    $('#totalHarga').val(''+dataResult);
                }
            });
        }
        var kodeinput2 = $('#codeInput').val();
        loadInputJual(kodeinput2);
        $('#addJual').on('click', function() {
            var sj = $('#sj').val();
            var tanggalKirim = $('#tanggalMasuk').val();
            var customer = $('#namaSupplier').val();
            var jenisBarang = $('#jenisBarangBantu').val();
            var namaBarang = $('#namaBarangBantu').val();
            var jumlahBarang = $('#jumlahBarangBantu').val();
            var ketBarang = $('#ketBarangBantu').val();
            var codeInput = $('#codeInput').val();
            if(sj==""){
                Swal.fire('Peringatan','Anda perlu mengisi Nomor Surat Jalan','warning');
            } else {
                if(tanggalKirim==""){
                    Swal.fire('Peringatan','Anda perlu mengisi tanggal kirim','warning');
                } else {
                    if(customer==""){
                        Swal.fire('Peringatan','Anda perlu mengisi nama customer','warning');
                    } else {
                        if(jenisBarang!="" && namaBarang!="" && jumlahBarang!="" && codeInput!=""){
                            console.log('sj-'+sj+'-tanggalKirim-'+tanggalKirim+'-customer-'+customer+'-jenisBarang-'+jenisBarang+'-namaBarang-'+namaBarang+'-jumlahBarang-'+jumlahBarang+'-ketBarang-'+ketBarang);
                            $.ajax({
                                url:"<?=base_url();?>prosesajax2/simpanPenjualan",
                                type: "POST",
                                data: {"sj" : sj, "tanggalKirim":tanggalKirim, "customer":customer, "jenisBarang":jenisBarang, "namaBarang":namaBarang, "jumlahBarang":jumlahBarang, "ketBarang":ketBarang, "codeInput":codeInput},
                                cache: false,
                                success: function(dataResult){
                                    var dataResult = JSON.parse(dataResult);
                                    if(dataResult.statusCode == 200){
                                        Swal.fire('Success',dataResult.psn,'success').then((result) => { loadInputJual(codeInput); });
                                    } else {
                                        Swal.fire('Error',dataResult.psn,'error');
                                    }
                                }
                            });
                        } else {
                            Swal.fire('Peringatan','Anda perlu mengisi jenis barang, nama barang dan jumlah barang','warning');
                        }
                    }
                }
            }
        });
        <?php } ?>
        function changeNota(code){
            $.ajax({
                url:"<?=base_url();?>prosesajax2/showDataPenjualan",
                type: "POST",
                data: {"code" : code},
                cache: false,
                success: function(dataResult){
                    var dataResult = JSON.parse(dataResult);
                    var tbody = document.getElementById('bodyByModals');
                    tbody.innerHTML = "";
                    if(dataResult.statusCode == 200){
                        var dataArray = dataResult.ar;
                        dataArray.forEach((item, index) => {
                        var row = document.createElement('tr'); // Buat elemen <tr>

                        // Buat kolom untuk setiap data yang ingin ditampilkan
                        var cellNo = document.createElement('td');
                        cellNo.textContent = index + 1; // Nomor urut
                        row.appendChild(cellNo);

                        var cellJenisBarang = document.createElement('td');
                        cellJenisBarang.textContent = item.jenis_barang || "-";
                        var cellIDInput = document.createElement('input');
                        cellIDInput.type = 'hidden'; // Tipe input
                        cellIDInput.name = 'idBarang[]';
                        cellIDInput.value = item.iddetil || "0";
                        cellJenisBarang.appendChild(cellIDInput);
                        row.appendChild(cellJenisBarang);

                        var cellNamaBarang = document.createElement('td');
                        cellNamaBarang.textContent = item.nama_barang || "-"; // Nama Barang
                        row.appendChild(cellNamaBarang);

                        var cellJumlah = document.createElement('td');
                        cellJumlah.textContent = item.jumlah_jual || "0"; // Jumlah
                        var cellJumlahInput = document.createElement('input');
                        cellJumlahInput.type = 'hidden'; // Tipe input
                        cellJumlahInput.name = 'jmlSatuan[]';
                        cellJumlahInput.value = item.jumlah_jual || "0";
                        cellJumlah.appendChild(cellJumlahInput);
                        row.appendChild(cellJumlah);

                        var cellHargaSatuan = document.createElement('td');
                        var inputHargaSatuan = document.createElement('input');
                        inputHargaSatuan.type = 'text'; // Tipe input
                        inputHargaSatuan.name = 'hargaSatuan[]';
                        inputHargaSatuan.addEventListener('input', function() {
                            formatNumber(this);
                            saveThisHitung();
                        });
                        inputHargaSatuan.value = item.harga_satuan || "0"; // Nilai default dari harga_satuan
                        inputHargaSatuan.className = 'form-control2'; // 
                        //cellHargaSatuan.textContent = item.harga_satuan || "0"; // Harga Satuan
                        cellHargaSatuan.appendChild(inputHargaSatuan);
                        row.appendChild(cellHargaSatuan);

                        // Tambahkan baris ke tbody
                        tbody.appendChild(row);
                        });
                        var row = document.createElement('tr');
                        var cellNo = document.createElement('td');
                        cellNo.textContent = "";
                        row.appendChild(cellNo);
                        var cellJenisBarang = document.createElement('td');
                        cellJenisBarang.textContent = ""; // Jenis Barang
                        row.appendChild(cellJenisBarang);
                        var cellNamaBarang = document.createElement('td');
                        cellNamaBarang.textContent = ""; // Nama Barang
                        row.appendChild(cellNamaBarang);
                        var cellJumlah = document.createElement('td');
                        cellJumlah.textContent = ""; // Jumlah
                        row.appendChild(cellJumlah);
                        var cellHargaSatuan = document.createElement('td');
                        cellHargaSatuan.textContent = ""; // Jumlah
                        row.appendChild(cellHargaSatuan);
                        tbody.appendChild(row);
                        //console.log(dataResult);
                        $('#nosjid').val(''+dataResult.sj);
                        if(dataResult.nonota=="null"){
                            $('#notaid').val('');
                        } else {
                            $('#notaid').val(''+dataResult.nonota);
                        }
                        $('#tglnotaid').val(''+dataResult.tglnota);
                        if(dataResult.pajak=="0"){
                            $('#prepajak').val('0');
                        } else {
                            $('#prepajak').val(''+dataResult.pajak);
                        }
                        
                        $('#exampleModal').modal('show');
                        saveThisHitung();
                    } else {
                        Swal.fire('Error',dataResult.psn,'error');
                    } 
                }
            });
            
        } //end changeNota
        function saveThisHitung(){
            const rows = document.querySelectorAll('#owekModals tbody tr');
            let totalNota = 0;
            rows.forEach((row) => {
                const hargaInput = row.querySelector('input[name="hargaSatuan[]"]');
                const jumlahCell = row.querySelector('input[name="jmlSatuan[]"]');
                if (!hargaInput || !jumlahCell) {
                    console.error("Elemen input hargaSatuan atau jmlSatuan tidak ditemukan di baris:", row);
                    return; // Lanjutkan ke baris berikutnya
                }
                const harga = parseFloat(hargaInput.value.replace(/\./g, '')) || 0; // Hilangkan titik
                const jumlah = parseFloat(jumlahCell.value) || 0;
                const subtotal = harga * jumlah;
                totalNota += subtotal;
            });

            // Update field Total Nota
            const totalNotaField = document.querySelector('#total_nota');
            totalNotaField.value = totalNota.toLocaleString('id-ID'); 
        }
        
  </script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?=base_url();?>assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>