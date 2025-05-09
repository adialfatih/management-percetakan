<div class="container-fluid py-2">
    
    <input type="hidden" id="openModalButton">
	  <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header" style="width:100%;display:flex;justify-content:space-between;">
                <div>
                    <h5 class="mb-0">Bahan Bantu</h5>
                    <p class="text-sm mb-0">
                        Menampilkan Data Bahan Bantu Masuk
                    </p>
                </div>
                <div style="display:flex;justify-content:flex-end;gap:10px;">
                  <a href="<?=base_url('input/bahan-bantu');?>"><button class="btn btn-primary"><i class="material-symbols-rounded">note_add</i> &nbsp; Input Pembelian</button></a>
                  <a href="<?=base_url('nota/bahan-bantu');?>"><button class="btn btn-info"><i class="material-symbols-rounded">payments</i> &nbsp; Nota Pembelian</button></a>
                  <!-- <button class="btn btn-primary" id="openModalButton2"><i class="material-symbols-rounded">upload_file</i> &nbsp; Import</button> -->
                </div>
            </div>
            <div class="table-responsive" style="padding:0 15px;">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th style="text-align:left;">Tanggal Masuk</th>
                    <th>Jenis Barang</th>
                    <th>Nama Barang</th>
                    <th>Ukuran</th>
                    <th>Jumlah Masuk</th>
                    <th>Supplier</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  if($inData->num_rows() >0){
                      foreach($inData->result() as $val){
                          $tgl_masuk = date("d M Y", strtotime($val->tgl_masuk));
                          ?>
                          <tr>
                              <td class="text-sm font-weight-normal" style="text-align:left;"><?=$tgl_masuk;?></td>
                              <td class="text-sm font-weight-normal"><?=$val->nama_barang;?></td>
                              <td class="text-sm font-weight-normal"><?=$val->keterangan;?></td>
                              <?php if($val->ukuran=="NULL" AND $val->satuan_ukr=="NULL"){ ?>
                              <td class="text-sm font-weight-normal">-</td>
                              <?php } else { ?>
                              <td class="text-sm font-weight-normal"><?=$val->ukuran." ".$val->satuan_ukr;?></td>
                              <?php } ?>
                              <td class="text-sm font-weight-normal"><?=$val->jumlah." ".$val->satuan_jml;?></td>
                              <td class="text-sm font-weight-normal"><?=$val->supplier_bnt;?></td>
                              <td class="text-sm font-weight-normal"><?=$val->ket=="NULL" ? '': $val->ket;?></td>
                          </tr>
                          <?php
                      }
                  }
                  ?>
                  
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
            <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
          </div>
          <?php echo form_open_multipart('import/importbakuin',array('name' => 'spreadsheet')); ?>
          <div class="modal-body">
                <div style="width:100%;display:flex;flex-direction:column;gap:20px;">
                    <label class="form-label">Upload Excel</label>
                    <input class="form-control" placeholder="Upload List" type="file" name="upload_file" id="upload_file" required>
                </div>
                <input type="hidden" name="tipe_data" value="bantu">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalButton" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Upload and Save</button>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>