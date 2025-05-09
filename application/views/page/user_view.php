<div class="container-fluid py-2">
      <div class="row">
        <div class="ms-3">
          <h3 class="mb-0 h4 font-weight-bolder">Management</h3>
          <p class="mb-4">
            Data User
          </p>
        </div>
        
      </div>
	  <div class="row">
        <div class="col-12">
            <?php if ($this->session->flashdata('error_messages')): ?>
            <div class="alert alert-danger text-white">
                <?php echo $this->session->flashdata('error_messages'); ?>
            </div>
            <?php endif; ?>

          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Data User</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="col-12 text-end">
                    <a class="btn bg-gradient-grey" href="javascript:;" id="openModalButton234"><i class="material-symbols-rounded text-sm">auto_delete</i>Reset Data</a>
                    <a class="btn bg-gradient-dark" href="javascript:;" id="openModalButton" style="margin-right:20px;"><i class="material-symbols-rounded text-sm">add</i>&nbsp;&nbsp;Add New User</a>
                    
                </div>
                
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="align-middle text-center text-sm">No</th>
                      <th class="">Nama User</th>
                      <th class="text-center">Akses</th>
                      <th class="text-center">Username</th>
                      <th class="text-secondary"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if($datatbl->num_rows() == 0){
                        echo "Tidak ada data";
                    } else {
                        $no=1;
                        foreach($datatbl->result() as $val):
                        $kecilkan = strtolower($val->nama_user);
                        $username = strtolower($val->username);
                        $hak = $val->hak_akses;
                        $id = $val->id_user;
                            ?>
                        <tr>
                            <td class="align-middle text-center text-sm"><?=$no;?></td>
                            <td><?=ucwords($kecilkan);?></td>
                            <td class="align-middle text-center text-sm">
                                <?php 
                                if($hak=="SuperAdmin"){ 
                                  echo '<span class="badge badge-sm bg-gradient-success">Super</span>'; 
                                } else { 
                                  $hak2 = explode(",",$hak);
                                  foreach($hak2 as $hak){
                                  if($hak=="Admin Keuangan"){ echo '<span class="badge badge-sm bg-gradient-success" style="margin:0 3px;">'.$hak.'</span>'; } else {
                                  echo '<span class="badge badge-sm bg-gradient-secondary" style="margin:0 3px;">'.$hak.'</span>'; }
                                  }
                                } 
                                ?>
                            </td>
                            <td class="align-middle text-center"><?=$username;?></td>
                            <td class="align-middle">
                                <a href="javascript:;" onclick="Swal.fire('Maaf fitur sedang dalam pengembangan')" class="text-secondary font-weight-bold text-xs">
                                Edit
                                </a> &nbsp; | &nbsp;
                                <a href="javascript:;" onclick="deletes('Hapus User ?','<?=ucwords($kecilkan);?>','<?=$id;?>','userdata')" class="text-secondary font-weight-bold text-xs" >
                                Delete
                                </a>
                            </td>
                        </tr>
                            <?php $no++;
                        endforeach;
                    }
                    ?>
                    
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
          </div>
          <form id="popupForm" method="post" action="<?=base_url('proses-add-user');?>">
          <div class="modal-body">
                <div class="input-group input-group-outline">
                    <label class="form-label">Nama User</label>
                    <input type="text" class="form-control" name="namauser" id="namauser" required>
                </div>
                <div class="input-group input-group-outline" style="margin-top:30px;">
                    <label class="form-label">Username Login</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>
                <div class="input-group input-group-outline" style="margin-top:30px;">
                    <label class="form-label">Password Login</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <label class="form-label" style="margin-top:30px;">Hak Akses</label>
                <br>
                <div style="width:100%;display:flex;align-items:center;">
                    <div style="width:50%;display:flex;align-items:center;">
                      <input type="checkbox" id="adm1" name="hak[]" value="Admin Keuangan">
                      <label for="adm1">Admin Keuangan</label>
                    </div>
                    <div style="width:50%;display:flex;align-items:center;">
                      <input type="checkbox" id="adm2" name="hak[]" value="Bahan Baku">
                      <label for="adm2">Bahan Baku</label>
                    </div>
                </div>
                <div style="width:100%;display:flex;align-items:center;">
                    <div style="width:50%;display:flex;align-items:center;">
                      <input type="checkbox" id="adm3" name="hak[]" value="Bahan Bantu">
                      <label for="adm3">Bahan Bantu</label>
                    </div>
                    <div style="width:50%;display:flex;align-items:center;">
                      <input type="checkbox" id="adm4" name="hak[]" value="Sparepart">
                      <label for="adm4">Sparepart</label>
                    </div>
                </div>
                <div style="width:100%;display:flex;align-items:center;">
                    <div style="width:50%;display:flex;align-items:center;">
                      <input type="checkbox" id="adm5" name="hak[]" value="Produksi">
                      <label for="adm5">Produksi</label>
                    </div>
                    <div style="width:50%;display:flex;align-items:center;">
                      <input type="checkbox" id="adm6" name="hak[]" value="Penjualan">
                      <label for="adm6">Penjualan</label>
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalButton" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- modal -->
    <div class="modal fade" id="exampleModal234" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel234">RESET DATA</h5>
          </div>
          <form id="popupForm" method="post" action="<?=base_url('proses-reset-data');?>">
          <div class="modal-body">
                <div class="input-group input-group-outline">
                    <label class="form-label">Masukan Kode Password Reset :</label>
                    <input type="password" class="form-control" name="passworde" id="passworde" required>
                </div>
                <br>
                <p>Anda yakin akan mereset aplikasi.? Proses ini akan menghapus semua data termasuk userlogin dan mengembalikan akses login ke default.?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalButton234" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">RESET</button>
          </div>
          </form>
        </div>
      </div>
    </div>