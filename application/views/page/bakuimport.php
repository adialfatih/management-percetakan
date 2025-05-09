<div class="container-fluid py-2">
    <div class="row">
      <div style="width:100%;display:flex;justify-content:flex-end;gap:10px;">
        <button class="btn btn-secondary"><i class="material-symbols-rounded">note_add</i> &nbsp; Barang Masuk</button>
        <a href="<?=base_url('bahan-baku/masuk/import');?>"><button class="btn btn-primary" id="openModalButton2"><i class="material-symbols-rounded">upload_file</i> &nbsp; Import</button></a>
      </div>
    </div>
    <input type="hidden" id="openModalButton">
	  <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <h5 class="mb-0">Management</h5>
              <p class="text-sm mb-0">
                Data Bahan Baku Masuk
              </p>
            </div>
           
                <div class="modal-body">
                        <div style="width:100%;display:flex;flex-direction:column;gap:10px;">
                            <label class="form-label">Upload Excel</label>
                            <input style="width:350px;" placeholder="Upload List" type="file" name="upload_file" required>
                        </div>
                        
                    
                </div>
                <button type="submit" class="btn btn-primary">Save changes</button>
           
          </div>
        </div>
      </div>
      
      