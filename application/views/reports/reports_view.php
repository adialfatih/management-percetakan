<div class="container-fluid py-2">
    
    <input type="hidden" id="openModalButton">
	  <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- Card header -->
            <div class="card-header" style="width:100%;display:flex;justify-content:space-between;">
              <div>
                  <h5 class="mb-0">Laporan Keuangan</h5>
                  <p class="text-sm mb-0">
                    Menampilkan Laporan Keuangan Laba dan Rugi (Gain & Loss)
                  </p>
              </div>
              <div style="display:flex;justify-content:flex-end;gap:10px;">
                  <button class="btn btn-primary" id="openModalButton2" onclick="showModals()"><i class="material-symbols-rounded">search</i> &nbsp; Filter</button>
                  <button class="btn btn-success" id="openModalButton6" onclick="showModal2s()"><i class="material-symbols-rounded">download</i> &nbsp; Download Excel</button>
              </div>
            </div>
            <div class="table-responsive" style="padding:15px;min-height:400px;">
              <table class="table table-bordered table-hover" id="myTable">
                <thead class="thead-light">
                  <tr>
                    <th style="text-align:left;" rowspan="2">Tanggal</th>
                    <th>Listrik</th>
                    <th>Bahan Baku</th>
                    <th>Bahan Bantu</th>
                    <th>Sparepart</th>
                    <th>Susut Invest</th>
                    <th>Biaya Pemeliharaan</th>
                    <th>Cadangan THR</th>
                    <th>MAN Power</th>
                    <th>Lain<sup>2</sup></th>
                    <th>Pengeluaran</th>
                    <th>Produksi</th>
                    <th>G/L</th>
                    <th>AKM G/L</th>
                  </tr>
                </thead>
                <tbody id="bodyTabel"></tbody>
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
            <h5 class="modal-title" id="exampleModalLabel">Filter Bulan</h5>
          </div>
          <?php echo form_open_multipart('import/importbakuin',array('name' => 'spreadsheet')); ?>
          <div class="modal-body">
                <div style="width:100%;display:flex;flex-direction:column;">
                    <label class="form-label">Tampilkan Bulan</label>
                    <input class="form-control2" type="month" name="tesMonth" id="tesMonth">
                </div>
                <input type="hidden" name="tipe_data" value="baku">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalButton" onclick="hideModals()" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="showData()">Submit</button>
          </div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
      <!-- modal -->
      <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Download Excel</h5>
          </div>
          
          <div class="modal-body">
                <div style="width:100%;display:flex;flex-direction:column;">
                    <label class="form-label">Download Bulan</label>
                    <input class="form-control2" type="month" name="tesMonth2" id="tesMonth2">
                </div>
                <input type="hidden" name="tipe_data" value="baku">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="closeModalButton" onclick="hideModals()" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" onclick="showData23()">Download</button>
          </div>
          
        </div>
      </div>
    </div>