<?php $x = explode(' / ', $page); 
$ses_hak = $this->session->userdata('hak');
$xses = explode(",",$ses_hak);
?>
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
                  <h5 class="mb-0">Data Stok <?=$x[1];?></h5>
                  <p class="text-sm mb-0">
                    Menampilkan Data <strong><?=$x[1];?></strong>
                  </p>
              </div>
              <div style="display:flex;justify-content:flex-end;gap:10px;">
                  <button class="btn btn-primary" id="openModalButton"><i class="material-symbols-rounded">upload_file</i> &nbsp; Import</button>
              </div>
            </div>
            <div class="table-responsive" style="padding:0 15px;">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th>Jenis Barang</th>
                    <th>Nama Barang</th>
                    <th>Ukuran</th>
                    <th>Stok</th>
                    <?php if(in_array('Admin Keuangan',$xses) OR in_array('SuperAdmin',$xses) ){ ?>
                    <th>Harga Satuan</th>
                    <th>Edit Harga</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  if($inData->num_rows() >0){
                      foreach($inData->result() as $val){
                          $id_stok = $val->id_stok;
                          $jumlah_stok = $val->jumlah_stok;
                          $ukuran = $val->ukuran!='NULL' ? $val->ukuran:'';
                          $sat_ukr = $val->satuan_ukr!='NULL' ? $val->satuan_ukr:'';
                          if(intval($jumlah_stok) > 0){
                            $harga_satuan2 = $val->harga_satuan;
                            if(floor($val->harga_satuan) != $val->harga_satuan){
                                $harga_satuan2 = number_format($val->harga_satuan,2,',','.');
                            } else {
                                $harga_satuan2 = number_format($val->harga_satuan,0,',','.');
                            }
                          ?>
                          <tr>
                              <td class="text-sm font-weight-normal"><?=$val->jenis_bahan;?></td>
                              <td class="text-sm font-weight-normal"><?=$val->nama_bahan=="NULL" ? '':$val->nama_bahan;?></td>
                              <td class="text-sm font-weight-normal"><?=$ukuran." ".$sat_ukr;?></td>
                              <td class="text-sm font-weight-normal"><?=number_format($val->jumlah_stok,0,',','.');?> <?=$val->satuan_jml;?></td>
                              <?php if(in_array('Admin Keuangan',$xses) OR in_array('SuperAdmin',$xses) ){ ?>
                              <td class="text-sm font-weight-normal">Rp. <?=$harga_satuan2;?></td>
                              <td class="text-sm font-weight-normal"><a href="javascript:;" onclick="changeHarga('<?=$id_stok;?>')" style="<?=$harga_satuan2>0 ?'':'color:red;';?>">Edit</a></td>
                              <?php } ?>
                          </tr>
                          <?php
                          }
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
              <h5 class="modal-title" id="exampleModalLabel">Import <?=$x[1];?></h5>
            </div>
            <?php echo form_open_multipart('import/importbakuin',array('name' => 'spreadsheet')); ?>
            <div class="modal-body">
                  <div style="width:100%;display:flex;flex-direction:column;gap:20px;">
                      <label class="form-label">Upload Excel Stok <?=$x[1];?></label>
                      <input class="form-control" placeholder="Upload List" type="file" name="upload_file" id="upload_file" required>
                  </div>
                  <input type="hidden" name="tipe_data" value="<?=$x[1];?>">
            </div>
            <div class="modal-footer">
              <a href="<?=base_url('uploads/format-data-to-import-stok.xlsx');?>" download><button type="button" class="btn btn-success"><i class="material-symbols-rounded">download</i>Template</button></a>
              <button type="button" class="btn btn-secondary" id="closeModalButton" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-info">Upload & Simpan</button>
            </div>
            <?php echo form_close();?>
          </div>
        </div>
      </div>
      <!-- modal -->
      <div class="modal fade" id="exampleModal266" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Update Harga</h5>
            </div>
            <?php echo form_open_multipart('updateharga',array('name' => 'spreadsheet')); ?>
            <div class="modal-body">
                  <div style="width:100%;display:flex;flex-direction:column;">
                     
                      <input class="form-control2" placeholder="Masukan Harga" type="text" oninput="formatNumber(this)" name="harg" id="harg" required>
                  </div>
                  <span>
                    <strong>Note:</strong> Proses ini hanya akan merubah harga pada stok. Tidak akan merubah harga pada pembelian.
                  </span>
                  <input type="hidden" name="id" value="0" id="idStokUpdate">
                  <input type="hidden" name="tipe_data" value="<?=$x[1];?>">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" onclick="thisDismis()" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-info">Update</button>
            </div>
            <?php echo form_close();?>
          </div>
        </div>
      </div>