<div class="container-fluid py-2">
    
    <input type="hidden" id="openModalButton">
	  <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header" style="width:100%;display:flex;justify-content:space-between;">
              <div>
                  <h5 class="mb-0">Nota Pembelian <?=$tipeuri;?></h5>
                  <p class="text-sm mb-0">
                    Menampilkan data pembelian / penerimaan <?=strtolower($tipeuri);?>
                  </p>
              </div>
              <div style="display:flex;justify-content:flex-end;gap:10px;">
                  <?php if($tipeuri=="Bahan Baku"){ ?>
                    <a href="<?=base_url('nota-tagihan/bahan-baku');?>"><button class="btn btn-primary"><i class="material-symbols-rounded">note_add</i> &nbsp; Tagihan</button></a>
                  <?php } elseif($tipeuri=="Bahan Bantu"){ ?>
                    <a href="<?=base_url('nota-tagihan/bahan-bantu');?>"><button class="btn btn-primary"><i class="material-symbols-rounded">note_add</i> &nbsp; Tagihan</button></a>
                  <?php } else { ?>
                    <a href="<?=base_url('nota-tagihan/sparepart');?>"><button class="btn btn-primary"><i class="material-symbols-rounded">note_add</i> &nbsp; Tagihan</button></a>
                  <?php } ?>
                  
              </div>
              <input type="hidden" name="tes" id="openModalButton">
            </div>
            <div class="table-responsive" style="padding:0 15px;">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th>Tanggal Masuk</th>
                    <th>No Nota/SJ</th>
                    <th>Nota Sementara</th>
                    <th>Nama Supplier</th>
                    <th>Nominal</th>
                    <th>Diinput Oleh</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  if($inData->num_rows() >0){
                      foreach($inData->result() as $val){
                          $tgl_masuk = date("d M Y", strtotime($val->tgl_nota));
                          $code = $val->code_input;
                          $nota_asli = $val->nota_asli;
                          if($nota_asli == "Tidak"){
                            $showNota = "Ya";
                          } else {
                            $showNota = "-";
                          }
                          ?>
                          <tr>
                              <td class="text-sm font-weight-normal"><?=$tgl_masuk;?></td>
                              <td class="text-sm font-weight-normal"><a href="<?=base_url('input/'.$txuri.'/'.$code);?>" style="color:#0b65bf;"><?=strtoupper($val->no_sj);?></a></td>
                              <td class="text-sm font-weight-normal"><?=$showNota;?></td>
                              <td class="text-sm font-weight-normal"><?=$val->nama_supplier;?></td>
                              <td class="text-sm font-weight-normal"><?=number_format($val->total_nota,0,',','.');?></td>
                              <td class="text-sm font-weight-normal"><?=$val->userlogin;?></td>
                              <td class="text-sm font-weight-normal">
                                <a href="<?=base_url('input/'.$txuri.'/'.$code);?>">
                                <i class="material-symbols-rounded" style="color:green;cursor:pointer;">open_in_new</i></a>
                                <a href="javascript:void(0);" onclick="deletes('Delete Nota','<?=$val->no_sj;?>','<?=$code;?>','pembelian_barang')">
                                <i class="material-symbols-rounded" style="color:red;cursor:pointer;">delete</i></a>
                              </td>
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