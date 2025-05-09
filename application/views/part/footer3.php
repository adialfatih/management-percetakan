<footer class="footer py-4  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              
            </div>
            <div class="col-lg-6">
              
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  
  <!--   Core JS Files   -->
  <script src="<?=base_url();?>assets/js/core/popper.min.js"></script>
  <script src="<?=base_url();?>assets/js/core/bootstrap.min.js"></script>
  <script src="<?=base_url();?>assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="<?=base_url();?>assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
  <script src="https://cdn.datatables.net/plug-ins/1.13.6/sorting/datetime-moment.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js" integrity="sha256-IW9RTty6djbi3+dyypxajC14pE6ZrP53DLfY9w40Xn4=" crossorigin="anonymous"></script>
  
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
    // flatpickr("#tanggalProduksi", {
    //     dateFormat: "Y-m-d", // Format tanggal
    //     placeholder: "Pilih tanggal" // Placeholder custom
    // }); 

    loadData('0');
    function loadData(id){
        $('#bodyTabel').html('<tr><td colspan="14"><div class="loader"></div></td></tr>');
        $.ajax({
            url:"<?=base_url();?>reports/showDataReport",
            type: "POST",
            data: {"id" : id},
            cache: false,
            success: function(dataResult){
                $('#bodyTabel').html(dataResult);
            }
        });
    }
    function showModals(){
        $('#exampleModal').modal('show');
    }
    function hideModals(){
        $('#exampleModal').modal('hide');
        $('#exampleModal2').modal('hide');
    }
    
    function showData(){
        var tesMonth = document.getElementById("tesMonth").value;
        loadData(tesMonth);
        hideModals();
    }
    function showData23(){
        var tesMonth = document.getElementById("tesMonth2").value;
        document.location.href = "<?=base_url('exportexcel/rekap/');?>"+tesMonth+'';
    }
    function showModal2s(){
        $('#exampleModal2').modal('show');
    }
    </script>
  </script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?=base_url();?>assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>

</html>