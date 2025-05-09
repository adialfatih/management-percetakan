<div class="container-fluid py-2">
    <?php $cus = strtolower($cus);?>
    <input type="hidden" id="openModalButton5">
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
                    <h5 class="mb-0">Data Piutang <?=ucwords($cus);?></h5>
                    <p class="text-sm mb-0">
                        Menampilkan Data Piutang Customer <strong><?=strtoupper($cus);?></strong>
                    </p>
                </div>
                <div style="display:flex;justify-content:flex-end;gap:10px;">
                  <a href="javascript:void(0);" id="openModalButton"><button class="btn btn-info"><i class="material-symbols-rounded">payments</i> &nbsp; Input Pembayaran</button></a>
                  <a href="javascript:void(0);" id="openModalButton1234" onclick="showCustomerBayar('<?=strtoupper($cus);?>')"><button class="btn btn-secondary"><i class="material-symbols-rounded">history</i> &nbsp; Riwayat Pembayaran</button></a>
                </div>
            </div>
            <div class="table-responsive" style="padding:0 15px;">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th style="text-align:left;">Tanggal Nota</th>
                    <th style="text-align:left;">Surat Jalan</th>
                    <th style="text-align:left;">No Nota</th>
                    <th style="text-align:left;">Customer</th>
                    <th style="text-align:left;">Nominal Nota</th>
                    <th style="text-align:left;">Pembayaran</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  if($data_row->num_rows() >0){
                      $now_bayar = $total_bayar;
                      foreach($data_row->result() as $val){
                        $tgl_masuk = date("d M Y", strtotime($val->tgl_jual));
                        $cd = $val->code_penjualan;
                        $nonota = $val->nonota;
                        if($nonota=="null"){} else {
                        $nominal_nota = $this->db->query("SELECT SUM(total_harga) AS ttl FROM data_penjualan_detil WHERE code_penjualan='$cd'")->row()->ttl;
                        if(floor($nominal_nota) != $nominal_nota){
                            $nominal_nota2 = number_format($nominal_nota,2,',','.');
                        } else {
                            $nominal_nota2 = number_format($nominal_nota,0,',','.');
                        }
                        if(floatval($now_bayar) >= floatval($nominal_nota)){
                            $dibayarkan = $nominal_nota;
                            $dibayarkan2 = $nominal_nota2;
                            $now_bayar = $now_bayar - $nominal_nota;
                        } else {
                            $dibayarkan = $now_bayar;
                            if(floor($dibayarkan) != $dibayarkan){
                                $dibayarkan2 = number_format($dibayarkan,2,',','.');
                            } else {
                                $dibayarkan2 = number_format($dibayarkan,0,',','.');
                            }
                            $now_bayar = 0;
                        }
                        $sisa_tagihan = $nominal_nota - $dibayarkan;
                          ?>
                          <tr>
                              <td class="text-sm font-weight-normal" style="text-align:left;">
                                <a href="javascript:void(0);" style="color:#046cdb;font-weight:bold;">
                                <?=$tgl_masuk;?>
                                </a>
                              </td>
                              <td class="text-sm font-weight-normal" style="text-align:left;"><?=strtoupper($val->nosj);?></td>
                              <td class="text-sm font-weight-normal" style="text-align:left;"><?=strtoupper($nonota);?></td>
                              <td class="text-sm font-weight-normal" style="text-align:left;"><?=strtoupper($val->customer);?></td>
                              <td class="text-sm font-weight-normal" style="text-align:left;">Rp. <?=$nominal_nota2;?></td>
                              <td class="text-sm font-weight-normal" style="text-align:left;">Rp. <?=$dibayarkan2;?></td>
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
                      } //end foreach
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
            <h5 class="modal-title" id="exampleModalLabel">Input Pembayaran</h5>
          </div>
          <?php echo form_open_multipart('simpan/pembayarancustomer',array('name' => 'spreadsheet')); ?>
          <div class="modal-body">
                <div style="width:100%;display:flex;flex-direction:column;">
                    <label class="form-label">Customer</label>
                    <input class="form-control2" value="<?=strtoupper($cus);?>" type="text" name="upload_file" id="upload_file" readonly>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:10px;">
                    <label class="form-label">Tanggal Bayar</label>
                    <input class="form-control2" value="<?=date("Y-m-d");?>" type="text" name="tglBayar" id="tanggalProduksi" required>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:10px;">
                    <label class="form-label">Nominal Bayar</label>
                    <input class="form-control2" placeholder="Masukan Nominal Pembayaran" type="text" name="nominal" id="nominal" oninput="formatNumber(this)" required>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:10px;">
                    <label class="form-label">Metode Pembayaran</label>
                    <input class="form-control2" list="metodeBayar" placeholder="Masukan Metode Pembayaran" type="text" name="metode" id="metode" required>
                    <datalist id="metodeBayar">
                      <option value="Tunai">
                      <option value="Transfer">
                      <option value="Virtual Account">
                    </datalist>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:10px;">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control2" placeholder="Masukan Keterangan" name="ket" id="ket"></textarea>
                    
                </div>
                <input type="hidden" name="tipe_data" value="bantu">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalButton" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
    <!-- modal -->
    <div class="modal fade" id="exampleModal234" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel23">Riwayat Pembayaran</h5>
          </div>
          <div class="modal-body" id="modalLargeBody2">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam ea sed unde quidem distinctio dolor officia, beatae rerum omnis facilis commodi explicabo assumenda ab ex totam, porro iure ipsum voluptas!
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalButton23" data-dismiss="modal">Close</button>
          </div>
          
        </div>
      </div>
    </div>