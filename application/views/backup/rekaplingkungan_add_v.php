<?php include("header.php") ?>


<div class="section-header">
    <h1>Tambah Rekap Lingkungan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item active"><a href="<?= base_url()?>rekaplingkungan<?= (!empty($params))?'/?'.$params:''; ?>">Rekap Lingkungan</a></div>
      <div class="breadcrumb-item">Tambah</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Tambah Rekap Perhitungan Amplop Lingkungan</h2>
    <p class="section-lead">Halaman untuk menambahkan data rekap perhitungan amplop per lingkungan</p>
    <div class="row">
        <div class="col-md-12">
            <form id="frm-hitung" action="<?= base_url(); ?>api/rekaplingkungan/add/"  method="post" action="" class="form-material" enctype="multipart/form-data" >
                <input type="hidden" id="user_id" name="user_id" value="<?= $user_now->id; ?>">
                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h3 class="card-title">Form Tambah</h3>
                    </div>
                    <div class="card-body">
                        <div class="section-title mt-0">Data Lingkungan</div>
                        <div class="form-body row">
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                  <label>Tanggal Pengitungan</label>
                                  <input type="text" id="input-tanggal" name="tanggal" value="<?= $str_date ?>" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Lingkungan</label>
                                    <select class="form-control select2" id="input-lingkungan" name="lingkungan" required>
                                        <?php foreach ($lingkungan as $d) { ?>
                                        <option  <?= ($ling == $d->kode_lingkungan)?'selected':''; ?>   value="<?= $d->kode_lingkungan ?>">[<?= $d->kode_lingkungan; ?>] <?= $d->lingkungan ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group" >
                                    <button id="btn-cari" class="btn btn-primary" type="button" style="margin-top: 30px; width: 100px;"><i class="fa fa-search"></i>  Cari</button>
                                </div>
                            </div>
                        </div>
                        <div id="frm-detail" >
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url()?>assets/node_modules/sweetalert/sweetalert.min.js"></script>
<script src="<?= base_url()?>assets/node_modules/sweetalert/jquery.sweet-alert.custom.js"></script>

<script type="text/javascript">

    $(document).ready(function() {
        $("#btn-cari").click(function(){
            var tanggal = $("#input-tanggal").val();
            var lingkungan = $("#input-lingkungan").val();
            if( tanggal != '' && lingkungan != '' ){
                $.ajax({
                    url: '<?= base_url(); ?>api/rekaplingkungan/cek_rekap_html',
                    data: {'tanggal':tanggal,'lingkungan':lingkungan},
                    type: 'POST',
                    dataType: 'html',
                    beforeSend: function() {
                        $(".btn-cari").attr("disabled", true);
                    },
                    complete: function() {
                        $(".btn-cari").attr("disabled", false);
                    },
                    success: function(hasil) {
                        $('#frm-detail').html(hasil);    
                    }
                });
            } else {
                swal('Tanggal dan Lingkungan Tidak Ada','Silahkan pilih tanggal dan lingkungan terlebih dahulu','warning',{
                    timer:2000
                });       
            }
        });
        
        $("#frm-hitung").submit(function(e) {
            swal('Apakah Data Sudah Benar?',"Pastikan data real dengan data aplikasi sudah sama",'warning',{
                closeOnEsc:false,
                closeOnClickOutside:false,
                buttons: {
                    cancel: "Tidak",
                    confirm: {
                        text: "Ya, Lanjutkan",
                        value: "ya",
                    }
                }
            }).then((value) => { 
                if(value == 'ya'){
                    swal('Tunggu Sebentar..!','Proses sedang berjalan..',{
                        closeOnClickOutside: false,
                        closeOnEsc: false,
                        closeModal:false,
                        buttons:false  
                    });
                    console.log($(this).serialize());
                    $.ajax({
                        url: $(this).attr("action"),
                        // data: $(this).serialize(),
                        type: $(this).attr("method"),
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $(".btn-simpan").attr("disabled", true);
                            $(".btn-update").attr("disabled", true);
                        },
                        complete: function() {
                            $(".btn-simpan").attr("disabled", false);
                            $(".btn-update").attr("disabled", false);
                        },
                        success: function(hasil) {
                            if(hasil.status == 'true'){
                                swal('Proses Rekapitulasi Berhasil Ditambahkan','Proses rekapitulasi amplop per lingkungan berhasil dilakukan','success',{
                                    timer:3000
                                });
                                $('#frm-detail').html(''); 
                            } else {
                                swal('Proses Gagal','Proses rekapitulasi amplop gagal dilakukan','warning');
                            }
                        }
                    }); 
                }
            }); 

             
            e.preventDefault();
        });

    } );
</script>
