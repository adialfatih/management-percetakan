<div class="container-fluid py-2">
    <?php $_x2 = explode(',',$this->session->userdata('hak')); 
if(in_array($uri3, $_x2) OR in_array('SuperAdmin', $_x2) OR in_array('Admin Keuangan', $_x2)){
  $show = "yes";
} else {
  $show = "no";
}
?>
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
                    <h5 class="mb-0">Pemakaian <?=$uri3;?></h5>
                    <p class="text-sm mb-0">
                        Menampilkan Data Pemakaian <strong><?=$uri3;?></strong>
                    </p>
                </div>
                <div style="display:flex;justify-content:flex-end;gap:10px;">
                  <?php if($show=="yes"){?>
                  <a href="javascript:void(0);" id="openModalButton"><button class="btn btn-primary"><i class="material-symbols-rounded">output</i> &nbsp; Input Pemakaian</button></a>
                  <?php } ?>
                </div>
            </div>
            <?php if($show=="yes"){?>
            <div class="table-responsive" style="padding:0 15px;">
              <table class="table table-flush" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th style="text-align:left;">Tanggal</th>
                    <th>Tujuan Pemakaian</th>
                    <th>Jenis Barang</th>
                    <th>Nama Barang</th>
                    <th>Ukuran</th>
                    <th>Jumlah Pakai</th>
                    <th>Keterangan</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  if($inData->num_rows() >0){
                      foreach($inData->result() as $val){
                          $kode_stok = $val->kode_stok;
                          $id_pakai = $val->id_pakai;
                          $tgl_masuk = date("d M Y", strtotime($val->tgl_pakai));
                          if($val->ukuran=="NULL"){
                              $_ukuran = "";
                          } else {
                              $_ukuran = $val->ukuran;
                          }
                          if($val->satuan_ukuran=="NULL"){
                              $_satuan_ukuran = "";
                          } else {
                              $_satuan_ukuran = $val->satuan_ukuran;
                          }
                          $txt_x = "Pemakaian ".$val->jenis_bahan." ".$val->nama_bahan." sejumlah ".$val->jumlah_pakai." ".$val->satuan_jumlah."";
                          ?>
                          <tr>
                              <td class="text-sm font-weight-normal" style="text-align:left;"><?=$tgl_masuk;?></td>
                              <td class="text-sm font-weight-normal" style="text-align:left;"><?=strtoupper($val->tujuan_pakai);?></td>
                              <td class="text-sm font-weight-normal"><?=$val->jenis_bahan;?></td>
                              <td class="text-sm font-weight-normal"><?=$val->nama_bahan;?></td>
                              <td class="text-sm font-weight-normal"><?=$_ukuran." ".$_satuan_ukuran;?></td>
                              <td class="text-sm font-weight-normal"><?=$val->jumlah_pakai." ".$val->satuan_jumlah;?></td>
                              <td class="text-sm font-weight-normal"><?=$val->ket=="NULL" ? '': $val->ket;?></td>
                              <td><a href="javascript:void(0);" onclick="deletes('Hapus Pemakaian','<?=$txt_x;?>','<?=$id_pakai;?>','<?=$table_view;?>')" style="color:red;"><i class="material-symbols-rounded">delete</i></a></td>
                          </tr>
                          <?php
                      }
                  }
                  ?>
                  
                </tbody>
              </table>
            </div>
            <?php } else { echo '<div class="table-responsive" style="padding:15px;color:red;">Anda tidak memiliki akses kehalaman ini</div>'; } ?>
          </div>
        </div>
      </div>
      
      <!-- modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pemakaian <?=$uri3;?></h5>
          </div>
          <?php echo form_open_multipart('proses/simpanpemakaian',array('name' => 'spreadsheet')); ?>
          <div class="modal-body">
                <div style="width:100%;display:flex;flex-direction:column;">
                    <label style="color:#000;">Tanggal Pemakaian</label>
                    <input class="form-control2" placeholder="Masukan tanggal pemakaian" type="date" name="tgl_pakai" id="tanggalPakai" value="<?=date('Y-m-d');?>" required>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:10px;">
                    <label style="color:#000;">Tujuan</label>
                    <input class="form-control2" list="cektujuan" placeholder="Masukan tujuan pemakaian" type="text" name="tujuan_pakai" id="tujuanPakai" required>
                    <datalist id="cektujuan">
                        <?php foreach($tujuan_pakai->result() as $tj){ echo '<option value="'.strtoupper($tj->tujuan_pakai).'">'; } ?>
                    </datalist>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:10px;">
                    <label style="color:#000;">Jenis <?=$uri3=='Sparepart' ? 'Sparepart':'Bahan';?></label>
                    <input class="form-control2" list="cekJenisBahan" placeholder="Masukan jenis barang" type="text" name="jenisbahan" id="jenisBahan" oninput="cekJenis()" onkeyup="cekJenis()" required>
                    <datalist id="cekJenisBahan">
                        <?php foreach($jenis->result() as $jns){ echo '<option value="'.$jns->jenis_bahan.'">'; } ?>
                    </datalist>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:10px;">
                    <label style="color:#000;">Nama <?=$uri3=='Sparepart' ? 'Sparepart':'Bahan';?></label>
                    <input class="form-control2" list="cekNamaBahan" placeholder="Masukan nama barang" type="text" name="namabahan" id="namaBahan" oninput="cekJenisDanNama()" onkeyup="cekJenisDanNama()" required>
                    <datalist id="cekNamaBahan"></datalist>
                    <small id="load1"></small>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:10px;">
                    <label style="color:#000;">Ukuran</label>
                    <input class="form-control2" list="cekUkuranBahan" placeholder="Masukan ukuran" type="text" name="ukuranbahan" id="ukuranBahan" oninput="cekTotalStok()" onkeyup="cekTotalStok()" required>
                    <datalist id="cekUkuranBahan"></datalist>
                    <small id="load2"></small>
                    <small id="load3"></small>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:10px;">
                    <label style="color:#000;">Jumlah Pakai</label>
                    <input class="form-control2" placeholder="Masukan jumlah pakai" oninput="formatNumber(this)" type="text" name="jumlahpakai" id="jumlahPakai" required>
                </div>
                <div style="width:100%;display:flex;flex-direction:column;margin-top:10px;">
                    <label style="color:#000;">Keterangan</label>
                    <textarea class="form-control2" placeholder="Masukan catatan/keterangan" type="text" name="ketpakai" id="ketPakai"></textarea>
                </div>
                <input type="hidden" name="tipe_out" id="tipeOut" value="<?=$uri3;?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalButton" data-dismiss="modal">Batal</button>
            <button type="submit" id="btnSimpan" class="btn btn-primary" disabled>Simpan</button>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>