<div class="container-fluid py-2">
    
    <input type="hidden" id="openModalButton2">
    <input type="hidden" id="closeModalButton2">
	  <div class="row">
        <div class="col-12">
            <?php if($this->session->flashdata('success')!=""){ ?>
            <div class="alert alert-success alert-dismissible text-white" role="alert">
                <span class="text-sm"><?=$this->session->flashdata('success');?></span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } ?>
            <?php if($this->session->flashdata('gagal')!=""){ ?>
            <div class="alert alert-danger alert-dismissible text-white" role="alert">
                <span class="text-sm"><?=$this->session->flashdata('gagal');?></span>
                <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } $_xd2 = explode(',',$this->session->userdata('hak')); ?>
          <div class="card">
            <!-- Card header -->
            <div class="card-header" style="width:100%;display:flex;justify-content:space-between;">
              <div>
                  <h5 class="mb-0">Input Data Penjualan</h5>
                  <p class="text-sm mb-0">
                    Masukan data penjualan barang.
                  </p>
              </div>
            </div>
            <div class="table-responsive" style="padding:0 15px;margin:10px 0 20px 0;">
                <input type="hidden" name="codeinput" id="codeInput" value="<?=$code_input;?>">
                <input type="hidden" id="openModalButton">
                <div class="form-dta">
                    <label for="sj">No Surat Jalan</label>
                    <?php if($data_row=="null"){ ?>
                        <input type="text" style="max-width:100%;width:400px;" placeholder="Masukan Nomor Surat Jalan / Nota" class="form-control2" name="sj" id="sj">
                    <?php } else { ?>
                        <input type="text" style="max-width:100%;width:400px;" placeholder="Masukan Nomor Surat Jalan / Nota" class="form-control2" name="sj" id="sj" value="<?=$data_row['nosj'];?>">
                    <?php } ?>
                </div>
                <div class="form-dta">
                    <label for="tanggalMasuk">Tanggal Kirim</label>
                    <?php if($data_row=="null"){ ?>
                        <input type="date" style="max-width:100%;width:300px;" class="form-control2" name="tanggalmasuk" id="tanggalMasuk">
                    <?php } else { ?>
                        <input type="date" style="max-width:100%;width:300px;" class="form-control2" name="tanggalmasuk" id="tanggalMasuk" value="<?=$data_row['tgl_jual'];?>">
                    <?php } ?>
                </div>
                <div class="form-dta">
                    <label for="namaSupplier">Nama Customer</label>
                    <?php if($data_row=="null"){ ?>
                        <input type="text" list="dataSupplier" style="max-width:100%;width:300px;" placeholder="Masukan Nama Customer" class="form-control2" name="namasupplier" id="namaSupplier" required>
                    <?php } else { ?>
                        <input type="text" list="dataSupplier" style="max-width:100%;width:300px;" placeholder="Masukan Nama Customer" class="form-control2" name="namasupplier" id="namaSupplier" value="<?=$data_row['customer'];?>">
                    <?php } ?>
                    <datalist id="dataSupplier">
                        <?php 
                        if($showCustomer->num_rows() > 0){
                            foreach($showCustomer->result() as $sp){
                                ?><option value="<?=$sp->customer;?>"><?php
                            }
                        } 
                        ?>
                    </datalist>
                </div>
                <?php if(in_array('Admin Keuangan',$_xd2) OR in_array('SuperAdmin',$_xd2)){?>
                <div class="form-dta">
                    <label for="totalHarga">Total Harga</label>
                    <?php if($data_row=="null"){ ?>
                        <input type="text" style="max-width:100%;width:350px;" placeholder="Masukan Total Harga" class="form-control2" name="totalharga" id="totalHarga" oninput="formatNumber(this)" readonly>
                    <?php } else { ?>
                        <input type="text" style="max-width:100%;width:350px;" placeholder="Masukan Total Harga" class="form-control2" name="totalharga" id="totalHarga" oninput="formatNumber(this)" value="<?=number_format($data_row['id_penjualan'],0,',','.');?>" readonly>
                    <?php } ?>
                </div>
                <?php } else { ?>
                <input type="hidden" id="totalHarga" value="0" name="totalharga">
                <?php } ?>
                <div class="table-responsive" id="showTablePengiriman"></div>
                
                <div style="width:100%;border-bottom:2px solid #ccc;padding-bottom:5px;margin-bottom:20px;">
                    <span style="color:#2e2e2e;">Masukan Jenis Barang Yang Di Kirim</span>
                </div>
                <div class="form-dta">
                    <label for="jenisBarangBantu">Jenis Barang</label>
                    <input type="text" list="jenisbarangListBantu" style="max-width:100%;width:400px;" placeholder="Masukan / Pilih Jenis Barang" class="form-control2" name="jenisbarangbantu" id="jenisBarangBantu" onchange="teschange21()" onkeyup="teschange21()" required>
                    <datalist id="jenisbarangListBantu">
                        <?php foreach($showJenisBahanJadi->result() as $sp){ ?>
                        <option value="<?=$sp->jenis_produksi;?>">
                        <?php } ?>
                    </datalist>
                </div>
                <div class="form-dta">
                    <label for="namaBarangBantu">Nama Barang</label>
                    <input type="text" list="namabarangListBantu" style="max-width:100%;width:400px;" placeholder="Masukan / Pilih Barang" class="form-control2" name="namabarangbantu" id="namaBarangBantu"  required>
                    <datalist id="namabarangListBantu"></datalist>
                    <small id="load2"></small>
                </div>
                
                <div class="form-dta">
                    <label for="jumlahBarangBantu">Jumlah Kirim</label>
                    <input type="text" style="max-width:100%;width:400px;" placeholder="Masukan Jumlah Kirim" class="form-control2" name="jumlahbarangbantu" oninput="formatNumber(this)" id="jumlahBarangBantu" required>
                </div>
                
                <div class="form-dta">
                    <label for="ketBarangBantu">Keterangan</label>
                    <input type="text" style="max-width:100%;width:615px;" placeholder="Masukan Keterangan" class="form-control2" name="ketbarangbantu" id="ketBarangBantu" required>
                    <button class="btn btn-success" id="addJual">Simpan & Tambahkan</button>
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
            <h5 class="modal-title" id="exampleModalLabel">Pemakaian Sparepart</h5>
          </div>
          <?php echo form_open_multipart('proses/pakaisparepart',array('name' => 'spreadsheet')); ?>
          <div class="modal-body">
                <div style="width:100%;display:flex;flex-direction:column;">
                    <label class="form-label">Tanggal Pemakaian</label>
                    <input class="form-control2" placeholder="Tanggal Pakai" type="date" name="tglpakai" id="tglpakai" required>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:15px;">
                    <label class="form-label">Cicil Pemakaian</label>
                    <input class="form-control2" placeholder="Cicil berapa x pemakaian" type="number" name="cicil" id="cicil" max="12"min="1" required>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:15px;">
                    <label class="form-label">Tujuan Pemakaian</label>
                    <input class="form-control2" placeholder="Masukan tujuan pemakaian" type="text" name="tujuan" id="tujuan" required>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:15px;">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control2" placeholder="Masukan keterangan" name="ket" id="ket"></textarea>
                </div>
                <input type="hidden" id="closeModalButton">
                <input type="hidden" id="idBantuin" value="0" name="id_bantuin">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalButton98" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
    