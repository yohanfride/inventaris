 <!-- Footer.php -->
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2021 <div class="bullet"></div> Develop By <a target="_blank" href="https://deltadigitalid.com/">Delta Digital ID</a>
        </div>
        <div class="footer-right">
          v.1.0.0
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="<?= base_url()?>assets/js/jquery-3.3.1.min.js"></script>
  <script src="<?= base_url()?>assets/js/popper.min.js"></script>
  <script src="<?= base_url()?>assets/js/bootstrap.min.js"></script>
  <script src="<?= base_url()?>assets/js/jquery.nicescroll.min.js"></script>
  <script src="<?= base_url()?>assets/js/moment.min.js"></script>

  <!-- JS Libraies -->
  <script src="<?= base_url()?>assets/node_modules/jquery-sparkline/jquery.sparkline.min.js"></script>
  <script src="<?= base_url()?>assets/node_modules/chart.js/dist/Chart.min.js"></script>
  <script src="<?= base_url()?>assets/node_modules/summernote/dist/summernote-bs4.js"></script>
  <script src="<?= base_url()?>assets/node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
  <script src="<?= base_url()?>assets/node_modules/select2/dist/js/select2.full.min.js"></script>
  <script src="<?= base_url()?>assets/node_modules/prismjs/prism.js"></script>
  
  <!-- This is data table -->
  <script src="<?= base_url()?>assets/node_modules/datatables/DataTables-1.10.23/js/jquery.dataTables.min.js"></script>

  <!-- Template JS File -->
  <script src="<?= base_url()?>assets/js/scripts.js"></script>
  <script src="<?= base_url()?>assets/js/custom.js"></script>

  <script>
      $('.btn-delete').click(function(){
          return confirm('Apakah anda yakin menghapus item ini?');          
      });
  </script>

  <!-- Page Specific JS File -->
  <!-- <script src="<?= base_url()?>assets/js/page/index.js"></script> -->
</body>
</html>
