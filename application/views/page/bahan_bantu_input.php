<div class="container-fluid py-2">
    
    <input type="hidden" id="openModalButton2">
	  <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header" style="width:100%;display:flex;justify-content:space-between;">
              <div>
                  <h5 class="mb-0">Pembelian Bahan Bantu</h5>
                  <p class="text-sm mb-0">
                    Masukan Data Barang Masuk Dari Supplier
                  </p>
              </div>
            </div>
            <div class="table-responsive" style="padding:0 15px;margin:10px 0 20px 0;">
                <input type="hidden" name="codeinput" id="codeInput" value="<?=$code_input;?>">
                <input type="hidden" id="openModalButton">
                <div class="form-dta">
                    <label for="sj">No Surat Jalan</label>
                    <?php if($data_row=="null"){ ?>
                        <input type="text" style="max-width:100%;width:400px;" placeholder="Masukan Nomor Surat Jalan" class="form-control2" name="sj" id="sj">
                    <?php } else { ?>
                        <input type="text" style="max-width:100%;width:400px;" placeholder="Masukan Nomor Surat Jalan" class="form-control2" name="sj" id="sj" value="<?=$data_row['no_sj'];?>">
                    <?php } ?>
                </div>
                <div class="form-dta">
                    <label for="sj">No NOTA</label>
                    <?php if($data_row=="null"){ ?>
                        <input type="text" style="max-width:100%;width:400px;" placeholder="Masukan Nomor NOTA" class="form-control2" name="nonota" id="noNota">
                    <?php } else { ?>
                        <input type="text" style="max-width:100%;width:400px;" placeholder="Masukan Nomor NOTA" class="form-control2" name="nonota" id="noNota" value="<?=$data_row['nonota'];?>">
                    <?php } ?>
                </div>
                <div class="form-dta">
                    <label for="tanggalMasuk">Tanggal Masuk</label>
                    <?php if($data_row=="null"){ ?>
                        <input type="date" style="max-width:100%;width:300px;" class="form-control2" name="tanggalmasuk" id="tanggalMasuk">
                    <?php } else { ?>
                        <input type="date" style="max-width:100%;width:300px;" class="form-control2" name="tanggalmasuk" id="tanggalMasuk" value="<?=$data_row['tgl_nota'];?>">
                    <?php } ?>
                </div>
                <div class="form-dta">
                    <label for="namaSupplier">Nama Supplier</label>
                    <?php if($data_row=="null"){ ?>
                        <input type="text" list="dataSupplier" style="max-width:100%;width:300px;" placeholder="Masukan Nama Supplier" class="form-control2" name="namasupplier" id="namaSupplier" required>
                    <?php } else { ?>
                        <input type="text" list="dataSupplier" style="max-width:100%;width:300px;" placeholder="Masukan Nama Supplier" class="form-control2" name="namasupplier" id="namaSupplier" value="<?=$data_row['nama_supplier'];?>">
                    <?php } ?>
                    <datalist id="dataSupplier">
                        <?php 
                        if($showSupplier->num_rows() > 0){
                            foreach($showSupplier->result() as $sp){
                                ?><option value="<?=$sp->nama_supplier;?>"><?php
                            }
                        } else {
                            $newSup = $this->data_model->showSupplier2();
                            foreach($newSup->result() as $sp){
                                ?><option value="<?=$sp->supplier;?>"><?php
                            }
                        }
                        ?>
                    </datalist>
                </div>
                <div class="form-dta">
                    <label for="totalHarga">Total Harga</label>
                    <?php if($data_row=="null"){ ?>
                        <input type="text" style="max-width:100%;width:350px;" placeholder="Masukan Total Harga" class="form-control2" name="totalharga" id="totalHarga" oninput="formatNumber(this)" readonly>
                    <?php } else { ?>
                        <input type="text" style="max-width:100%;width:350px;" placeholder="Masukan Total Harga" class="form-control2" name="totalharga" id="totalHarga" oninput="formatNumber(this)" value="<?=number_format($data_row['total_nota'],0,',','.');?>" readonly>
                    <?php } ?>
                </div>
                <div class="form-dta">
                    <label for="totalHarga">Presentase Pajak</label>
                    <?php if($data_row=="null"){ ?>
                        <input type="text" style="max-width:100%;width:350px;" placeholder="Masukan Presentase Pajak" class="form-control2" name="prespajak" id="prespajak" oninput="formatNumber(this)">
                    <?php } else { ?>
                        <input type="text" style="max-width:100%;width:350px;" placeholder="Masukan Presentase Pajak" class="form-control2" name="prespajak" id="prespajak" oninput="formatNumber(this)" value="<?=number_format($data_row['presentase_pajak'],0,',','.');?>">
                    <?php } ?>
                </div>
                <div class="form-dta">
                    <label for="totalHarga6">Nota Sementara ?</label>
                    <?php if($data_row=="null"){ ?>
                        <div class="form-check form-switch d-flex align-items-center">
                            <input class="form-check-input" type="checkbox" id="notaSementara">
                            <label class="form-check-label mb-0 ms-3" for="notaSementara" id="labelNota">Tidak</label>
                            <input type="hidden" id="notaSementaraValue" name="notaSementaraValue" value="Ya">
                        </div>
                   <?php } else {
                   if($data_row['nota_asli']=='Ya'){ ?>
                        <div class="form-check form-switch d-flex align-items-center">
                            <input class="form-check-input" type="checkbox" id="notaSementara">
                            <label class="form-check-label mb-0 ms-3" for="notaSementara" id="labelNota">Tidak</label>
                            <input type="hidden" id="notaSementaraValue" name="notaSementaraValue" value="Ya">
                        </div>
                   <?php  } else { ?>
                        <div class="form-check form-switch d-flex align-items-center">
                            <input class="form-check-input" type="checkbox" id="notaSementara" checked>
                            <label class="form-check-label mb-0 ms-3" for="notaSementara" id="labelNota">Ya</label>
                            <input type="hidden" id="notaSementaraValue" name="notaSementaraValue" value="Tidak">
                        </div>
                   <?php } ?>
                   <?php } ?>
                </div>
                <div class="form-dta">
                    <label for="totalHarga6">&nbsp;</label>
                    <div id="formnotaSementara">
                    </div>
                    <input type="hidden" id="notaSementaraValue" name="notaSementaraValue" value="Ya">
                </div>
                <div class="table-responsive" id="showTablePengiriman"></div>
                <!-- <div style="width:100%;border-bottom:2px solid #ccc;padding-bottom:5px;margin-bottom:20px;">
                    <span style="color:#2e2e2e;">Data Bahan Baku Masuk</span>
                </div>
                <div class="form-dta">
                    <label for="jenisBarang">Jenis Barang</label>
                    <input type="text" list="jenisbarangList" style="max-width:100%;width:400px;" placeholder="Masukan / Pilih Jenis Barang" class="form-control2" name="jenisbarang" id="jenisBarang" onchange="teschange()" onkeyup="teschange()" required>
                    <datalist id="jenisbarangList">
                        <php foreach($jenisBaku->result() as $baku){ ?>
                        <option value="<=$baku->jenis_barang;?>">
                        <php } ?>
                    </datalist>
                </div>
                <div class="form-dta">
                    <label for="namaBarang">Nama Barang</label>
                    <input type="text" list="namabarangList" style="max-width:100%;width:400px;" placeholder="Masukan / Pilih Barang" class="form-control2" name="namabarang" id="namaBarang" required>
                    <datalist id="namabarangList"></datalist>
                    <small id="load1"></small>
                </div>
                <div class="form-dta">
                    <label for="ukuranBarang">Ukuran</label>
                    <input type="text" style="max-width:100%;width:400px;" placeholder="Masukan Ukuran" class="form-control2" name="ukuranbarang" id="ukuranBarang" required>
                    <select name="satuanukuran" class="select-box" style="width:200px;" id="satuanUkuran2">
                        <option value="NULL">-</option>
                        <option value="MM">Mili Meter (MM)</option>
                        <option value="CM">Centi Meter (CM)</option>
                        <option value="M">Meter (M)</option>
                        <option value="G">Gram (G)</option>
                        <option value="KG">Kilo Gram (KG)</option>
                        <option value="LTR">LTR</option>
                    </select> 
                    <input type="hidden" name="satuanukuran" id="satuanUkuran" value="NULL">
                </div>
                <div class="form-dta">
                    <label for="jumlahBarang">Jumlah Masuk</label>
                    <input type="text" style="max-width:100%;width:400px;" placeholder="Masukan Jumlah Masuk" class="form-control2" name="jumlahbarang" oninput="formatNumber(this)" id="jumlahBarang" required>
                    <select name="satuanjumlah" class="select-box" style="width:200px;" id="satuanJumlah">
                        <option value="LBR">LEMBAR (LBR)</option>
                        <option value="PCS">PCS</option>
                        <option value="DRUM">DRUM</option>
                        <option value="DUS">DUS</option>
                        <option value="GLN">GLN</option>
                        <option value="ROLL">ROLL</option>
                    </select>
                </div>
                <div class="form-dta">
                    <label for="hargaSatuanBarang">Harga Satuan</label>
                    <input type="text" style="max-width:100%;width:400px;" placeholder="Masukan Harga Per Satuan" class="form-control2" name="hargaSatuan" oninput="formatNumber(this)" id="hargaSatuanBarang" required>
                    
                </div>
                <div class="form-dta">
                    <label for="ketBarang">Keterangan</label>
                    <input type="text" style="max-width:100%;width:615px;" placeholder="Masukan Keterangan" class="form-control2" name="ketbarang" id="ketBarang" required>
                    <button class="btn btn-success" id="addBahanBaku">Tambahkan Bahan Baku</button>
                </div> -->
                <div style="width:100%;border-bottom:2px solid #ccc;padding-bottom:5px;margin-bottom:20px;">
                    <span style="color:#2e2e2e;">Data Bahan Bantu Masuk</span>
                </div>
                <div class="form-dta">
                    <label for="jenisBarangBantu">Jenis Barang</label>
                    <input type="text" list="jenisbarangListBantu" style="max-width:100%;width:400px;" placeholder="Masukan / Pilih Jenis Barang" class="form-control2" name="jenisbarangbantu" id="jenisBarangBantu" onchange="teschange2()" onkeyup="teschange2()" required>
                    <datalist id="jenisbarangListBantu">
                        <?php foreach($jenisBantu->result() as $bantu){ ?>
                        <option value="<?=$bantu->nama_barang;?>">
                        <?php } ?>
                    </datalist>
                </div>
                <div class="form-dta">
                    <label for="namaBarangBantu">Nama Barang</label>
                    <input type="text" list="namabarangListBantu" style="max-width:100%;width:400px;" placeholder="Masukan / Pilih Barang" class="form-control2" name="namabarangbantu" id="namaBarangBantu" onchange="teschange4()" onkeyup="teschange4()" required>
                    <datalist id="namabarangListBantu"></datalist>
                    <small id="load2"></small>
                </div>
                <div class="form-dta">
                    <label for="ukuranBarangBantu">Ukuran</label>
                    <input type="text" list="ukuranbarangListBantu" style="max-width:100%;width:400px;" placeholder="Masukan Ukuran" class="form-control2" name="ukuranbarangbantu" id="ukuranBarangBantu" required>
                    <datalist id="ukuranbarangListBantu">
                    </datalist>
                    <!-- <select name="satuanukuranbantu" class="select-box" style="width:200px;" id="satuanUkuranBantu">
                        <option value="NULL">-</option>
                        <option value="MM">Mili Meter (MM)</option>
                        <option value="CM">Centi Meter (CM)</option>
                        <option value="M">Meter (M)</option>
                        <option value="G">Gram (G)</option>
                        <option value="KG">Kilo Gram (KG)</option>
                        <option value="LTR">LTR</option>
                    </select> -->
                    <small id="load4"></small>
                    <input type="hidden" name="satuanukuranbantu" id="satuanUkuranBantu" value="NULL">
                </div>
                <div class="form-dta">
                    <label for="jumlahBarangBantu">Jumlah Masuk</label>
                    <input type="text" style="max-width:100%;width:400px;" placeholder="Masukan Jumlah Masuk" class="form-control2" name="jumlahbarangbantu" oninput="formatNumber(this)" id="jumlahBarangBantu" required>
                    <select name="satuanjumlahbantu" class="select-box" style="width:200px;" id="satuanJumlahBantu">
                        <option value="LBR">LEMBAR (LBR)</option>
                        <option value="PCS">PCS</option>
                        <option value="DRUM">DRUM</option>
                        <option value="DUS">DUS</option>
                        <option value="GLN">GLN</option>
                        <option value="ROLL">ROLL</option>
                        <option value="KG">KG</option>
                        <option value="L">LITER</option>
                        <option value="RIM">RIM</option>
                        <option value="DZ">DZ</option>
                        <option value="PACK">PACK</option>
                        <option value="M">METER</option>
                    </select>
                </div>
                <div class="form-dta">
                    <label for="hargaSatuanBarangBantu">Harga Satuan</label>
                    <input type="text" style="max-width:100%;width:400px;" placeholder="Masukan Harga Per Satuan" class="form-control2" name="hargaSatuanBantu" oninput="formatNumber(this)" id="hargaSatuanBarangBantu" required>
                    
                </div>
                <div class="form-dta">
                    <label for="ketBarangBantu">Keterangan</label>
                    <input type="text" style="max-width:100%;width:615px;" placeholder="Masukan Keterangan" class="form-control2" name="ketbarangbantu" id="ketBarangBantu" required>
                    <button class="btn btn-success" id="addBahanBantu">Tambahkan Bahan Bantu</button>
                </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
          </div>
          <?php echo form_open_multipart('import/importbakuin',array('name' => 'spreadsheet')); ?>
          <div class="modal-body">
                <div style="width:100%;display:flex;flex-direction:column;gap:20px;">
                    <label class="form-label">Upload Excel</label>
                    <input class="form-control" placeholder="Upload List" type="file" name="upload_file" id="upload_file" required>
                </div>
                <input type="hidden" name="tipe_data" value="baku">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalButton" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Upload and Save</button>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
    <script>
        const checkbox = document.getElementById('notaSementara');
        const label = document.getElementById('labelNota');
        const formnotaSementara = document.getElementById('formnotaSementara');
        const notaSementaraValue = document.getElementById('notaSementaraValue');
        function updateLabel() {
            if(checkbox.checked){
                label.textContent = 'Ya';
                formnotaSementara.innerHTML = 'Tagihan nota akan dimasukan mengikuti tanggal Nota Asli diterima';
                notaSementaraValue.value = 'Tidak';
            } else {
                label.textContent = 'Tidak';
                formnotaSementara.innerHTML = '';
                notaSementaraValue.value = 'Ya';
            }
        }
        checkbox.addEventListener('change', updateLabel);
    </script>