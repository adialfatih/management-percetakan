<div class="container-fluid py-2">
    <input type="hidden" id="openModalButton2">
    <input type="hidden" id="openModalButton">
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
            <?php } 
            $_xd2 = explode(',',$this->session->userdata('hak'));
            ?>
          <div class="card">
            <!-- Card header -->
            <div class="card-header" style="width:100%;display:flex;justify-content:space-between;">
              <div>
                  <h5 class="mb-0">Data Penjualan</h5>
                  <p class="text-sm mb-0">
                    Menampilkan Data Penjualan
                  </p>
              </div>
              <div style="display:flex;justify-content:flex-end;gap:10px;">
                  <button class="btn btn-primary" id="openModalButton3"><i class="material-symbols-rounded">inventory</i> &nbsp; Input Penjualan</button>
              </div>
            </div>
            <div class="table-responsive" style="padding:0 15px;">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th style="text-align:left;">Tanggal Kirim</th>
                    <th>No Surat Jalan</th>
                    <th>Customer</th>
                    <th>Jenis Barang</th>
                    <?php if(in_array('Admin Keuangan',$_xd2) OR in_array('SuperAdmin',$_xd2)){?>
                    <th>Total Harga</th>
                    <th>No Nota</th>
                    <?php } ?>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody id="showProduksi">
                    <tr>
                        <td>Loading..</td>
                        <td>Loading..</td>
                        <td>Loading..</td>
                        <td>Loading..</td>
                        <td>Loading..</td>
                        <?php if(in_array('Admin Keuangan',$_xd2) OR in_array('SuperAdmin',$_xd2)){?>
                        <td>Loading..</td>
                        <td>Loading..</td>
                        <?php } ?>
                    </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
      <!-- modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Penjualan</h5>
          </div>
          <?php echo form_open_multipart('simpan-notabaru',array('name' => 'spreadsheet')); ?>
          <div class="modal-body">
                <div class="form-dta nomarg">
                    <label class="form-label">No Surat Jalan</label>
                    <input type="text" class="form-control2" name="nosj" id="nosjid" readonly>
                </div>
                <br>
                <div class="form-dta nomarg">
                    <label class="form-label">No Nota</label>
                    <input type="text" class="form-control2" placeholder="Masukan nomor Nota" name="nonota" id="notaid" required>
                </div>
                <br>
                <div class="form-dta nomarg">
                    <label class="form-label">Tanggal Nota</label>
                    <input type="date" class="form-control2" placeholder="Masukan tanggal Nota" name="tglnota" id="tglnotaid" required>
                </div>
                <br>
                <div class="form-dta nomarg">
                    <label class="form-label">Presentase Pajak</label>
                    <input type="text" oninput="formatNumber(this)" class="form-control2" placeholder="Masukan presentase pajak" name="prepajak" id="prepajak" required>
                </div>
                <br>
                <div class="form-dta nomarg">
                    <label class="form-label">Total Nota</label>
                    <input type="text" class="form-control2" placeholder="Total Akan dihitung secara otomatis" name="total_nota" id="total_nota" readonly>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered" id="owekModals">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Jenis Barang</th>
                          <th>Nama Barang</th>
                          <th>Jumlah</th>
                          <th>Harga Satuan</th>
                        </tr>
                      </thead>
                      <tbody id="bodyByModals">

                      </tbody>
                    </table>
                </div>
                <input type="hidden" id="tipesave" name="tipesave" value="add">
                <br>
          </div>
          <div class="modal-footer">
            <!-- <a href="<=base_url('uploads/format-data-to-import-stok.xlsx');?>" download><button type="button" class="btn btn-success"><i class="material-symbols-rounded">download</i>Template</button></a> -->
            <button type="button" class="btn btn-secondary" id="closeModalButton" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info"> Simpan</button>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
    <!-- modal -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">Input Produksi</h5>
          </div>
          <?php echo form_open_multipart('simpan-produksi',array('name' => 'spreadsheet')); ?>
          <div class="modal-body">
                <div>
                    <label class="form-label">Tanggal Produksi</label>
                    <input type="date" class="form-control2" name="tanggalproduksi" id="tanggalProduksi2" required>
                </div>
                <br>
                <div>
                    <label class="form-label">Produksi</label>
                    <input type="text" class="form-control2" name="produksi" id="produksiID2" required>
                </div>
                <br>
                <div>
                    <label class="form-label">Jumlah Produksi (Qty)</label>
                    <input type="text" oninput="formatNumber(this)" class="form-control2" name="jmlproduksi" id="jmlProduksiID2" required>
                </div>
                <br>
                <div>
                    <label class="form-label">Harga Satuan</label>
                    <input type="text" oninput="formatNumber(this)" class="form-control2" name="hargasatuan" id="hargaSatuan2" required>
                </div>
                <input type="hidden" id="tipesave2" name="tipesave" value="add">
                <br>
          </div>
          <div class="modal-footer">
            <!-- <a href="<=base_url('uploads/format-data-to-import-stok.xlsx');?>" download><button type="button" class="btn btn-success"><i class="material-symbols-rounded">download</i>Template</button></a> -->
            <button type="button" class="btn btn-secondary" id="closeModalButton2" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info"> Simpan</button>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>