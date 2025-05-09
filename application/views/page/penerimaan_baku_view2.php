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
                  
                    <a href="<?=base_url('nota-tagihan/all');?>"><button class="btn btn-primary"><i class="material-symbols-rounded">note_add</i> &nbsp; Tagihan</button></a>
                  
                  
              </div>
              <input type="hidden" name="tes" id="openModalButton">
            </div>
            <div class="table-responsive" style="padding:0 15px;">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th style="text-align:left;">Tanggal Masuk</th>
                    <th style="text-align:left;">SJ</th>
                    <th>No Nota</th>
                    <th>Nota Sementara</th>
                    <th>Nama Supplier</th>
                    <th>Jenis Pembelian</th>
                    <th>Nominal</th>
                    <th>Diinput Oleh</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  if($inData->num_rows() >0){
                      foreach($inData->result() as $val){
                          $tgl_masuk = date("d M Y", strtotime($val->tgl_nota));
                          $code = $val->code_input;
                          $id_pembelian = $val->id_pembelian;
                          $nota_asli = $val->nota_asli;
                          if($nota_asli == "Tidak"){
                            $showNota = "Ya";
                          } else {
                            $showNota = "-";
                          }
                          if($val->jenis_pembelian=="Bahan Baku"){ $txuri2 = "bahan-baku";}
                          if($val->jenis_pembelian=="Bahan Bantu"){ $txuri2 = "bahan-bantu";}
                          if($val->jenis_pembelian=="Sparepart"){ $txuri2 = "sparepart";}
                          ?>
                          <tr>
                              <td class="text-sm font-weight-normal" style="text-align:left;"><?=$tgl_masuk;?></td>
                              <td class="text-sm font-weight-normal"><a href="<?=base_url('input/'.$txuri2.'/'.$code);?>" style="color:#0b65bf;"><?=strtoupper($val->no_sj);?></a></td>
                              <?php if($val->nonota=="null"){ echo "<td>-</td>"; } else { ?>
                              <td class="text-sm font-weight-normal"><a href="<?=base_url('input/'.$txuri2.'/'.$code);?>" style="color:#0b65bf;"><?=strtoupper($val->nonota);?></a></td>
                              <?php } ?>
                              <td class="text-sm font-weight-normal"><a href="javascript:void(0);" onclick="updateNotaSementara('<?=$id_pembelian;?>')" style="color:#0b65bf;font-weight:bold;"><?=$showNota;?></a></td>
                              <td class="text-sm font-weight-normal"><?=$val->nama_supplier;?></td>
                              <td class="text-sm font-weight-normal"><?=$val->jenis_pembelian;?></td>
                              <td class="text-sm font-weight-normal"><?=number_format($val->total_nota,0,',','.');?></td>
                              <td class="text-sm font-weight-normal"><?=$val->userlogin;?></td>
                              <td class="text-sm font-weight-normal">
                                
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
            <h5 class="modal-title" id="exampleModalLabel">Update Nota Sementara</h5>
          </div>
          <?php echo form_open_multipart('proses/updatenota',array('name' => 'spreadsheet')); ?>
          <div class="modal-body">
                <div style="width:100%;display:flex;flex-direction:column;">
                    <label class="form-label">SURAT JALAN</label>
                    <input class="form-control2" type="text" name="nonota" id="nonota45" required>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;">
                    <label class="form-label">NO NOTA</label>
                    <input class="form-control2" type="text" name="nonota2" id="nonota452" required>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;">
                    <label class="form-label">TANGGAL NOTA</label>
                    <input class="form-control2" type="date" name="tglnota" id="tglnota23" required>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;">
                    <label class="form-label">NOMINAL NOTA</label>
                    <input class="form-control2"  type="text" name="nominal" id="nominal24" readonly>
                </div>
                <input type="hidden" name="idpembelian" id="idPembelianNota" value="0">
                <br>
                <p><strong>Note:&nbsp;</strong>Update nota ke tanggal nota sebenarnya. Anda tidak diperbolehkan mengubah nominal nota.!!</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalButton" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update Nota</button>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>