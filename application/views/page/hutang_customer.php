<div class="container-fluid py-2">
    
    <input type="hidden" id="openModalButton">
    <input type="hidden" id="openModalButton2">
	  <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header" style="width:100%;display:flex;justify-content:space-between;">
                <div>
                    <h5 class="mb-0">Data Piutang</h5>
                    <p class="text-sm mb-0">
                        Menampilkan Data Piutang Customer
                    </p>
                </div>
                <!-- <div style="display:flex;justify-content:flex-end;gap:10px;">
                  <a href="<=base_url('input/bahan-bantu');?>"><button class="btn btn-primary"><i class="material-symbols-rounded">note_add</i> &nbsp; Input Pembelian</button></a>
                  <a href="<=base_url('nota/bahan-bantu');?>"><button class="btn btn-info"><i class="material-symbols-rounded">payments</i> &nbsp; Nota Pembelian</button></a>
                  <button class="btn btn-primary" id="openModalButton2"><i class="material-symbols-rounded">upload_file</i> &nbsp; Import</button>
                </div> -->
            </div>
            <div class="table-responsive" style="padding:0 15px;">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th style="text-align:left;">Nama Customer</th>
                    <th style="text-align:center;">Jumlah Nota</th>
                    <th style="text-align:left;">Total Tagihan</th>
                    <th>Total Pembayaran</th>
                    <th>Sisa Tagihan</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  if($data_row->num_rows() >0){
                      foreach($data_row->result() as $val){
                          //$tgl_masuk = date("d M Y", strtotime($val->tgl_masuk));
                          $cus = $val->customer;
                          $linkcus = $this->data_model->safe_base64_encode($cus);
                          $jml_nota = $this->db->query("SELECT COUNT(nosj) AS jml FROM data_penjualan WHERE customer='$cus' AND nonota!='null'")->row()->jml;
                          $total_harga = $this->db->query("SELECT SUM(total_harga) AS jml FROM v_penjualan WHERE customer='$cus'")->row()->jml;
                          if(floor($total_harga) != $total_harga){
                                $total_harga2 = number_format($total_harga,2,',','.');
                          } else {
                                $total_harga2 = number_format($total_harga,0,',','.');
                          }
                          $total_bayar = $this->db->query("SELECT SUM(jumlah_bayar) AS jml FROM pembayaran_customer WHERE nama_customer='$cus'")->row()->jml;
                          if(floor($total_bayar) != $total_bayar){
                                $total_bayar2 = number_format($total_bayar,2,',','.');
                          } else {
                                $total_bayar2 = number_format($total_bayar,0,',','.');
                          }
                          $sisa_tagihan = floatval($total_harga) - floatval($total_bayar);
                          if(floor($sisa_tagihan) != $sisa_tagihan){
                                $sisa_tagihan2 = number_format($sisa_tagihan,2,',','.');
                          } else {
                                $sisa_tagihan2 = number_format($sisa_tagihan,0,',','.');
                          }
                          
                          ?>
                          <tr>
                              <td class="text-sm font-weight-normal" style="text-align:left;">
                                <a href="<?=base_url('hutang/customer/'.$linkcus.'');?>" style="color:#046cdb;font-weight:bold;">
                                <?=$cus;?>
                                </a>
                              </td>
                              <td class="text-sm font-weight-normal" style="text-align:center;"><?=number_format($jml_nota);?></td>
                              <td class="text-sm font-weight-normal" style="text-align:left;">Rp. <?=$total_harga2;?></td>
                              <td class="text-sm font-weight-normal" style="text-align:left;">Rp. <?=$total_bayar2;?></td>
                              <td class="text-sm font-weight-normal" style="text-align:left;">Rp. <?=$sisa_tagihan2;?></td>
                              <td class="text-sm font-weight-normal" style="text-align:left;">
                                <?php
                                if($sisa_tagihan > 0){
                                    echo '<span style="background:red;color:#fff;padding:3px 6px;border-radius:5px;font-size:12px;">Belum Lunas</span>';
                                } else {
                                    echo '<span style="background:#06a11e;color:#fff;padding:3px 6px;border-radius:5px;font-size:12px;">Lunas</span>';
                                }
                                ?>
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