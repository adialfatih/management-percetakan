<?php $xses = explode(",",$sess); ?>
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
                  <h5 class="mb-0">Data Produksi</h5>
                  <p class="text-sm mb-0">
                    Menampilkan Data Produksi Harian
                  </p>
              </div>
              <div style="display:flex;justify-content:flex-end;gap:10px;">
                  <button class="btn btn-primary" id="openModalButton"><i class="material-symbols-rounded">inventory</i> &nbsp; Input Produksi</button>
                  <button class="btn btn-success" id="openModalButton645"><i class="material-symbols-rounded">upload_file</i> &nbsp; Import Produksi</button>
              </div>
            </div>
            <div class="table-responsive" style="padding:0 15px;">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th style="text-align:left;">Tanggal Produksi</th>
                    <th>Jenis Barang</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <?php if(in_array('Admin Keuangan',$xses) OR in_array('SuperAdmin',$xses)){ ?>
                    <th>Harga</th>
                    <th>Total</th>
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
                        <?php if(in_array('Admin Keuangan',$xses) OR in_array('SuperAdmin',$xses)){ ?>
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
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Input Produksi</h5>
          </div>
          <?php echo form_open_multipart('simpan-produksi',array('name' => 'spreadsheet')); ?>
          <div class="modal-body">
                <div>
                    <label class="form-label">Tanggal Produksi</label>
                    <input type="text" class="form-control2" name="tanggalproduksi" value="<?=date('Y-m-d');?>" placeholder="Pilih Tanggal" id="tanggalProduksi" required>
                </div>
                <br>
                <div>
                    <label class="form-label">Jenis Barang</label>
                    <input type="text" class="form-control2" name="produksijenis" id="produksiID" placeholder="Masukan jenis barang produksi" required>
                </div>
                <br>
                <div>
                    <label class="form-label">Nama Barang</label>
                    <input type="text" class="form-control2" name="produksinama" id="produksiID2" placeholder="Masukan nama barang produksi" required>
                </div>
                <br>
                <div>
                    <label class="form-label">Jumlah Produksi (Qty)</label>
                    <input type="text" oninput="formatNumber(this)" class="form-control2" placeholder="Masukan jumlah produksi" name="jmlproduksi" id="jmlProduksiID" required>
                </div>
                <br>
                <?php if(in_array('Admin Keuangan',$xses) OR in_array('SuperAdmin',$xses)){ ?>
                <div>
                    <label class="form-label">Harga Satuan</label>
                    <input type="text" oninput="formatNumber(this)" class="form-control2" placeholder="Masukan harga barang per satuan" name="hargasatuan" id="hargaSatuan" required>
                </div>
                <?php } else { ?>
                  <input type="hidden" id="hargaSatuan" name="hargasatuan" value="0">
                <?php } ?>
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
                </div><br>
                <div>
                    <label class="form-label">Jenis Barang</label>
                    <input type="text" class="form-control2" name="produksijenis" id="jnsEdit" required>
                </div>
                <br>
                <div>
                    <label class="form-label">Nama Barang</label>
                    <input type="text" class="form-control2" name="produksinama" id="produksiID245" required>
                </div>
                <br>
                <div>
                    <label class="form-label">Jumlah Produksi (Qty)</label>
                    <input type="text" oninput="formatNumber(this)" class="form-control2" name="jmlproduksi" id="jmlProduksiID2" required>
                </div>
                <br>
                <?php if(in_array('Admin Keuangan',$xses) OR in_array('SuperAdmin',$xses)){ ?>
                <div>
                    <label class="form-label">Harga Satuan</label>
                    <input type="text" oninput="formatNumber(this)" class="form-control2" placeholder="Masukan harga barang per satuan" name="hargasatuan" id="hargaSatuan2" required>
                </div>
                <?php } else { ?>
                  <input type="hidden" id="hargaSatuan2" name="hargasatuan" value="0">
                <?php } ?>

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
    <!-- modal -->
    <div class="modal fade" id="exampleModal2566" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel5662">Import Produksi / Barang Jadi</h5>
          </div>
          <?php echo form_open_multipart('simpan-produksi-import',array('name' => 'spreadsheet')); ?>
          <div class="modal-body">
                <div>
                    <label class="form-label">Upload File</label>
                    <input type="file" class="form-control2" name="upload_file" id="upload_file" required>
                </div><br>
               
                
          </div>
          <div class="modal-footer">
            <!-- <a href="<=base_url('uploads/format-data-to-import-stok.xlsx');?>" download><button type="button" class="btn btn-success"><i class="material-symbols-rounded">download</i>Template</button></a> -->
            <a href="<?=base_url('uploads/Format-barang-jadi.xlsx');?>" download><button type="button" class="btn btn-success"><i class="material-symbols-rounded">upload_file</i> Template</button></a>
            <button type="button" class="btn btn-secondary" id="closeModalButton3252" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-info">Upload & Simpan</button>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>