<?php if($tipe_data!="all"){ ?> 
<input type="hidden" id="namaSupplierIDModals" value="<?=$tipe_data;?>">
<input type="hidden" id="tipeDataIDModals" value="<?=$tipetext;?>">
<?php } ?>
<div class="container-fluid py-2">
    <input type="hidden" id="openModalButton2">
	  <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header" style="width:100%;display:flex;justify-content:space-between;">
              <div>
                  <h5 class="mb-0">Nota Tagihan <?=$tipe_data=="all" ? 'Tagihan Penerimaan':$tipe_data;?></h5>
                  <p class="text-sm mb-0">
                    Menampilkan Data Tagihan Penerimaan Dari <?=$tipe_data=="all" ? 'Supplier':$tipe_data;?> 
                  </p>
              </div>
              <div style="display:flex;justify-content:flex-end;gap:10px;">
                  <a href="javascript:void(0)" id="openModalButton"><button class="btn btn-primary"><i class="material-symbols-rounded">note_add</i> &nbsp; Input Pembayaran</button></a>
                  <?php if($tipe_data!="all"){ ?>
                  <a href="javascript:void(0)" id="openModalButton23"><button class="btn btn-secondary"><i class="material-symbols-rounded">history</i> &nbsp; Riwayat Pembayaran</button></a><?php } ?>
              </div>
            </div>
            <div class="table-responsive" style="padding:0 15px;">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <?php if($tipe_data=="all"){ ?>
                  <tr>
                    <th>Nama Supplier</th>
                    <th>Total Nota</th>
                    <th>Total Tagihan</th>
                    <th>Total Pembayaran</th>
                    <th>Status</th>
                  </tr>
                  <?php } else { ?>
                  <tr>
                    <th>Nama Supplier</th>
                    <th>Tanggal Nota</th>
                    <th>No Nota/SJ</th>
                    <th>Jumlah Tagihan</th>
                    <th>PPN</th>
                    <th>Total Tagihan</th>
                    <th>Jumlah Pembayaran</th>
                    <th>Status</th>
                  </tr>
                  <?php } ?>
                </thead>
                <tbody>
                <?php 
                  if($inData->num_rows() >0){
                    if($tipe_data=="all"){
                        foreach($inData->result() as $val){
                          $nama_supplier = $val->nama_supplier;
                          $id = $this->data_model->safe_base64_encode($nama_supplier);
                          $jml_nota = $this->data_model->get_byid('pembelian_barang',['nama_supplier'=>$nama_supplier,'nota_asli'=>'Ya'])->num_rows();
                          if($jml_nota>0){
                          //$ttl_tagihan = $this->db->query("SELECT SUM(total_nota) AS ttl FROM pembelian_barang WHERE nama_supplier='$nama_supplier' AND nota_asli='Ya'")->row()->ttl;
                          $total_tagihan = $this->data_model->get_byid('pembelian_barang',['nama_supplier'=>$nama_supplier,'nota_asli'=>'Ya']);
                          $nilai_nota_pajak=0;
                          foreach($total_tagihan->result() as $val2){
                              $_nota = $val2->total_nota;
                              $_ppn = $val2->presentase_pajak;
                              $_nota_ppn = ($_nota * $_ppn) / 100;
                              $_allnota = $_nota + $_nota_ppn;
                              $nilai_nota_pajak += $_allnota;
                          }
                          $ttl_bayar = $this->db->query("SELECT SUM(jumlah_bayar) AS ttl FROM pembayaran_nota WHERE nama_supplier='$nama_supplier'")->row()->ttl;
                          if($nilai_nota_pajak == $ttl_bayar){
                              $status = 'Lunas';
                          } else {
                            if($ttl_bayar > $nilai_nota_pajak){
                              $status = 'Kelebihan Bayar';
                            } else {
                              $status = 'Belum Lunas';
                            } 
                          }
                          if($ttl_bayar == floor($ttl_bayar)){
                            $ttl_bayar = number_format($ttl_bayar,0,',','.');
                          } else {
                            $ttl_bayar = number_format($ttl_bayar,2,',','.');
                          }
                          if($nilai_nota_pajak == floor($nilai_nota_pajak)){
                            $nilai_nota_pajak = number_format($nilai_nota_pajak,0,',','.');
                          } else {
                            $nilai_nota_pajak = number_format($nilai_nota_pajak,2,',','.');
                          }
                          ?>
                            <tr>
                                <td class="text-sm font-weight-normal"><a href="<?=base_url('nota-tagihan/id/'.$id.'/'.$tipeid);?>" style="font-weight:bold;"><?=$nama_supplier;?></a></td>
                                <td class="text-sm font-weight-normal"><?=$jml_nota;?> Nota</td>
                                <td class="text-sm font-weight-normal">Rp. <?=$nilai_nota_pajak;?></td>
                                <td class="text-sm font-weight-normal">Rp. <?=$ttl_bayar;?></td>
                                <td class="text-sm font-weight-normal">
                                    <?php if($status == 'Lunas'){ ?>
                                        <span style="background:green;color:#fff;padding:3px 6px;border-radius:5px;font-size:12px;"><?=$status;?></span>
                                    <?php } else { ?>
                                        <span style="background:red;color:#fff;padding:3px 6px;border-radius:5px;font-size:12px;"><?=$status;?></span>
                                    <?php } ?>
                                </td>
                            </tr>
                          <?php
                          }
                        } //end foreach ke 1
                    } else {
                        $total_bayar = $this->db->query("SELECT SUM(jumlah_bayar) AS ttl FROM pembayaran_nota WHERE nama_supplier='$tipe_data'")->row()->ttl;
                        $total_bayar = intval($total_bayar);
                        $sisa_bayar = $total_bayar;
                        foreach($inData->result() as $val){
                            $nama_supplier = $val->nama_supplier;
                            $id = $this->data_model->safe_base64_encode($nama_supplier);
                            $tgl_masuk = date("d M Y", strtotime($val->tgl_nota));
                            $nilai_nota = $val->total_nota;
                            $persen = ($nilai_nota * $val->presentase_pajak) / 100;
                            $nota_pajak = $nilai_nota + $persen;

                            $show_bayar = 0;
                            if($sisa_bayar > 0){
                                if($sisa_bayar >= $nota_pajak){
                                    $sisa_bayar = $sisa_bayar - $nota_pajak;
                                    $show_bayar = $nota_pajak;
                                    $st = 'Lunas';
                                } else {
                                    $show_bayar = $sisa_bayar;
                                    $sisa_bayar = 0;
                                    $st = 'Belum Lunas';
                                }
                            } else {
                              $st = 'Belum Lunas';
                            }
                            
                            if($nilai_nota == floor($nilai_nota)){
                                $nilai_nota = number_format($nilai_nota,0,',','.');
                            } else {
                                $nilai_nota = number_format($nilai_nota,2,',','.');
                            }
                            if($nota_pajak == floor($nota_pajak)){
                                $nota_pajak = number_format($nota_pajak,0,',','.');
                            } else {
                                $nota_pajak = number_format($nota_pajak,2,',','.');
                            }
                            if($show_bayar == floor($show_bayar)){
                                $show_bayar = number_format($show_bayar,0,',','.');
                            } else {
                                $show_bayar = number_format($show_bayar,2,',','.');
                            }
                            ?>
                            <tr>
                                <td class="text-sm font-weight-normal"><a href="javascript:void(0);" style="font-weight:bold;"><?=$nama_supplier;?></a></td>
                                <td class="text-sm font-weight-normal"><?=$tgl_masuk;?></td>
                                <td class="text-sm font-weight-normal"><?=$val->no_sj;?></td>
                                <td class="text-sm font-weight-normal">Rp. <?=$nilai_nota;?></td>
                                <td class="text-sm font-weight-normal"><?=$val->presentase_pajak;?> %</td>
                                <td class="text-sm font-weight-normal">Rp. <?=$nota_pajak;?></td>
                                <td class="text-sm font-weight-normal">Rp. <?=$show_bayar;?></td>
                                <td class="text-sm font-weight-normal">
                                    <?php if($st=="Lunas"){?>
                                    <span style="background:green;color:#fff;padding:3px 6px;border-radius:5px;font-size:12px;"><?=$st;?></span>
                                    <?php } else { ?>
                                    <span style="background:red;color:#fff;padding:3px 6px;border-radius:5px;font-size:12px;"><?=$st;?></span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php
                            
                        } //end foreach ke 2
                    }
                  }
                  ?>
                </tbody>
              </table>
              <?php
              if($sisa_bayar > 0){
                echo "Terdapat Sisa Pemabayaran Sebesar = <strong>Rp. ".number_format($sisa_bayar,0,',','.')."</strong>";
              }
              ?>
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
          <?php echo form_open_multipart('proses/inputpembayaran',array('name' => 'spreadsheet')); ?>
          <input type="hidden" name="tipeid" value="All">
          <div class="modal-body">
                <?php if($tipe_data=="all"){ ?>
                <div style="width:100%;display:flex;flex-direction:column;">
                    <label class="form-label">Nama Supplier</label>
                    <input class="form-control2" list="listSupplier" placeholder="Masukan Nama Suppllier" type="text" name="sup" id="sup" required>
                    <datalist id="listSupplier">
                        <?php foreach($inData->result() as $val){ ?>
                            <option value="<?=$val->nama_supplier;?>"><?=$val->nama_supplier;?></option>
                        <?php } ?>
                    </datalist>
                </div>
                <?php } else {  ?>
                <div style="width:100%;display:flex;flex-direction:column;">
                    <label class="form-label">Nama Supplier</label>
                    <input class="form-control2" value="<?=$tipe_data;?>" type="text" name="sup" id="sup" readonly>
                </div>
                <?php } ?>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:20px;">
                    <label class="form-label">Tanggal Pembayaran</label>
                    <input class="form-control2" type="date" name="tgl" id="tgl" required>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:20px;">
                    <label class="form-label">Nominal Pembayaran</label>
                    <input class="form-control2" type="text" oninput="formatNumber(this)" placeholder="Masukan Nominal Pembayaran" name="nominal" id="nominal" required>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:20px;">
                    <label class="form-label">Jenis Pembayaran</label>
                    <select name="jnsbyr" id="jnsbyr" class="select-box" required>
                        <option value="">Pilih Jenis Pembayaran</option>
                        <option value="Cash">Cash</option>
                        <option value="Transfer">Transfer</option>
                        <option value="VA">Virtual Account</option>
                    </select>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:20px;">
                    <label class="form-label">Keterangan</label>
                    <textarea class="form-control2" placeholder="Masukan Keterangan / Catatan Penrting" name="textare" id="textare"></textarea>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalButton" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
    <!-- modal -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel23">Riwayat Pembayaran</h5>
          </div>
          <div class="modal-body" id="modalLargeBody">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam ea sed unde quidem distinctio dolor officia, beatae rerum omnis facilis commodi explicabo assumenda ab ex totam, porro iure ipsum voluptas!
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalButton23" data-dismiss="modal">Close</button>
          </div>
          
        </div>
      </div>
    </div>