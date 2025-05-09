<div class="container-fluid py-2">
    <input type="hidden" id="openModalButton2">
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
            <?php } ?>
          <div class="card">
            <!-- Card header -->
            <div class="card-header" style="width:100%;display:flex;justify-content:space-between;">
              <div>
                  <h5 class="mb-0">Biaya <?=$thisData;?></h5>
                  <p class="text-sm mb-0">
                    Menampilkan Data Biaya <?=$thisData;?>
                  </p>
              </div>
              <div style="display:flex;justify-content:flex-end;gap:10px;">
                  <button class="btn btn-primary" id="openModalButton"><i class="material-symbols-rounded">inventory</i> &nbsp; Input <?=$thisData;?></button>
              </div>
            </div>
            <div class="table-responsive" style="padding:0 15px;">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th style="text-align:left;">Tanggal</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th>Diinput oleh</th>
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
                    </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      
      <!-- modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Input Biaya <?=$thisData;?></h5>
          </div>
          <?php echo form_open_multipart('simpan-pemeliharaan',array('name' => 'spreadsheet')); ?>
          <div class="modal-body">
                <div>
                    <label class="form-label">Tanggal</label>
                    <input type="date" class="form-control2" name="tgl" id="tgl23" required>
                </div>
                <br>
                <div>
                    <label class="form-label">Biaya Pemeliharaan</label>
                    <input type="text" oninput="formatNumber(this)" placeholder="Masukan biaya <?=$thisData;?>" class="form-control2" name="nominal" id="nominal" required>
                </div>
                <br>
                <div>
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control2" name="ket" id="ket" placeholder="Masukan keterangan <?=$thisData;?>"></textarea>
                </div>
                <input type="hidden" id="tipesave" name="tipesave" value="<?=$thisData;?>">
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