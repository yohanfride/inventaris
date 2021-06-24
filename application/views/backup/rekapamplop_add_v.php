<?php include("header.php") ?>


<div class="section-header">
    <h1>Tambah Rekap Amplop Coklat</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item active"><a href="<?= base_url()?>rekap<?= (!empty($params))?'/?'.$params:''; ?>">Rekap Amplop</a></div>
      <div class="breadcrumb-item">Tambah</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Tambah Rekap Perhitungan Amplop Coklat</h2>
    <p class="section-lead">Halaman untuk menambahkan data rekap perhitungan amplop coklat</p>
    <form id="frm-hitung" action="<?= base_url(); ?>api/rekap/update/"  method="post" action="" class="form-material" enctype="multipart/form-data" >
        <input type="hidden" id="user_id" name="user_id" value="<?= $user_now->id; ?>">
        <input type="hidden" id="kodeamplop" name="kodeamplop" >
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h3 class="card-title text-secondry">Form Tambah</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-body row">
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                  <label>Tanggal Perhitungan</label>
                                  <input type="text" id="tanggal" name="tanggal" value="<?= $str_date ?>" class="form-control datepicker" required>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Nama / Kode Amplop Coklat</label>
                                    <input type="text" id="nama" name="nama" value="" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group" >
                                    <button id="btn-make" class="btn btn-primary" type="button" style="margin-top: 30px; width: 100px;"><i class="fa fa-plus"></i>  Buat</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 frm-cari" style="display: none;">
                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h4 class="card-title text-secondry">Data Rekap Amplop per Lingkungan</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-body row">
                            <div class="col-lg-5 col-sm-12">
                                <div class="form-group">
                                  <label>Tanggal Rekap</label>
                                  <input type="text" id="input-tanggal" value="<?= $str_date ?>" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-lg-7 col-sm-12">
                                <div class="form-group">
                                    <label>Lingkungan</label>
                                    <select class="form-control select2" id="input-lingkungan" required>
                                        <?php foreach ($lingkungan as $d) { ?>
                                        <option   value="<?= $d->kode_lingkungan ?>">[<?= $d->kode_lingkungan; ?>] <?= $d->lingkungan ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group" >
                                    <button id="btn-cari" class="btn btn-primary float-right" type="button" style="width: 100px;"><i class="fa fa-search"></i>  Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6" id="frm-detail">


            </div>
            <div class="col-md-12 frm-cari" id="frm-item-detail" style="display: none;">
                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h4 class="card-title text-secondry">Daftar Rekap per Lingkungan</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-body row" id="frm-list">
                                        
                        </div>
                    </div>
                </div>    
                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h4 class="card-title text-secondry">Detail Perhitungan</h4>
                        <div class="card-header-action">
                            <h4 class="card-title text-secondry" style="font-size: 18px; font-weight: 700;" >Total Keseluruhan:&nbsp; &nbsp;<span class="float-right" id="total">Rp. 0</span> </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-body row" id="frm-list">
                        </div>
                        <div class="form-body row">
                            <?php for($i=0; $i<count($label_pecahan); $i++){  ?>
                            <div class="media col-lg-3 col-md-4 col-sm-6" style="border-bottom: 1px solid #dddd; margin-bottom: 10px;">
                                <div class="media-body">
                                    <div class="media-right text-right" style="font-size: 14px; ">Rp. 0</div>
                                    <div class="media-title" style="">
                                        Pecahan <?= $label_pecahan[$i]?>
                                        <div class="text-success" style="font-size: 14px; font-weight: 700;">Jumlah : 0</div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div> 
                    </div>
                </div>    
            </div>

            <div class="col-md-12 frm-cari" style="display: none;">
                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h4 class="card-title text-secondry">Informasi Amplop Coklat</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-body row">
                            <div class="form-group col-md-6">
                              <label>Tim Penanggung Jawab</label>
                              <input type="text" class="form-control" name="penghitung" required>
                            </div>
                            <div class="form-group col-md-6">
                              <label>Foto Fisik Amplop Coklat</label>
                              <input type="file" class="form-control" name="foto" required>
                            </div>
                            <div class="form-group col-md-6">
                              <label>Catatan</label>
                              <textarea  class="form-control" name="catatan" style="min-height: 100px;"></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status Simpan Data</label>
                                <div class="form-group">
                                    <label class="custom-switch pl-1 mr-5">
                                        <input type="radio" name="simpan" value="1" class="custom-switch-input input-option" checked>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Simpan Data</span>
                                    </label>    
                                    <label class="custom-switch pl-1">
                                        <input type="radio" name="simpan" value="0" class="custom-switch-input input-option" >
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Draft Data</span>
                                    </label> 
                                </div>
                            </div>
                        </div>
                        <div class="form-actions frm-input-hide">
                            <button type="submit" class="btn btn-success" id="btn-simpan" name="save" value="save"> <i class="fa fa-check"></i> Simpan</button>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url()?>assets/node_modules/sweetalert/sweetalert.min.js"></script>
<script src="<?= base_url()?>assets/node_modules/sweetalert/jquery.sweet-alert.custom.js"></script>

<script type="text/javascript">
    function tambah(){
        swal('Apakah Anda Yakin Menambahkan Rekap Lingkungan?',"Pastikan bentuk fisik uang rekap amplop lingkungan sudah siap",'warning',{
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
                var kodeamplop = $("#kodeamplop").val();
                var rekaplingkungan = $("#rekaplingkungan").val();
                $.ajax({
                    url: '<?= base_url(); ?>api/rekap/add_lingkungan_html/',
                    type: 'POST',
                    data: {'rekaplingkungan':rekaplingkungan,'rekapid':kodeamplop},
                    dataType: 'html',
                    beforeSend: function() {
                        $("#btn-tambah").attr("disabled", true);
                    },
                    complete: function() {
                        $("#btn-tambah").attr("disabled", false);
                    },
                    success: function(hasil) {
                        if(hasil == 'error'){
                            swal('Proses Gagal','Proses penambahan rekapitulasi amplop gagal dilakukan','warning');
                            
                        } else {
                            swal('Proses Berhasil','Proses penambahan rekapitulasi amplop berhasil dilakukan','success',{
                                timer:3000
                            });
                            $("#frm-item-detail").html(hasil);
                             $('#frm-detail').html('');
                        }
                    }
                }); 
            }
        }); 
    }

    function hapus(id){
        swal('Apakah Anda Yakin Menghapus Rekap Lingkungan?',"Proses akan menghubah perhitungan",'warning',{
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
                var kodeamplop = $("#kodeamplop").val();
                var rekaplingkungan = id;
                $.ajax({
                    url: '<?= base_url(); ?>api/rekap/delete_lingkungan_html/',
                    type: 'POST',
                    data: {'rekaplingkungan':rekaplingkungan,'rekapid':kodeamplop},
                    dataType: 'html',
                    beforeSend: function() {
                        $("#btn-tambah").attr("disabled", true);
                    },
                    complete: function() {
                        $("#btn-tambah").attr("disabled", false);
                    },
                    success: function(hasil) {
                        if(hasil == 'error'){
                            swal('Proses Gagal','Proses penghapusan rekapitulasi amplop gagal dilakukan','warning');
                            
                        } else {
                            swal('Proses Berhasil','Proses penghapusan rekapitulasi amplop berhasil dilakukan','success',{
                                timer:3000
                            });
                            $("#frm-item-detail").html(hasil);
                             $('#frm-detail').html('');
                        }
                    }
                }); 
            }
        }); 
    }

    $(document).ready(function() {
        $("#btn-make").click(function(){
            swal('Apakah Data Real Telah Siap?',"Pastikan bentuk fisik uang rekap amplop tiap lingkungan sudah siap",'warning',{
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
                    var tanggal = $("#tanggal").val();
                    var nama = $("#nama").val();
                    var user_id = $("#user_id").val();
                    $.ajax({
                        url: '<?= base_url(); ?>api/rekap/add/',
                        type: 'POST',
                        data: {'tanggal':tanggal,'nama':nama, 'user_id':user_id},
                        dataType: 'json',
                        beforeSend: function() {
                            $("#btn-make").attr("disabled", true);
                        },
                        complete: function() {
                            $("#btn-make").attr("disabled", false);
                        },
                        success: function(hasil) {
                            if(hasil.status == 'true'){
                                console.log(hasil);
                                $('.frm-cari').css("display","block"); 
                                swal('Proses Pembuatan Rekap Amplop Coklat Berhasil','Proses pembuatan rekapitulasi amplop coklat telah berhasil dilakukan, silahkan menambahkan data rekapitulasi amplop per lingkungan','success',{
                                    timer:3000
                                });
                                $("#kodeamplop").val(hasil.rekap.idrekap_amplop);
                            } else {
                                swal('Proses Gagal','Proses rekapitulasi amplop gagal dilakukan','warning');
                            }
                        }
                    }); 
                }
            }); 
        });

        $("#btn-cari").click(function(){
            var tanggal = $("#input-tanggal").val();
            var lingkungan = $("#input-lingkungan").val();
            if( tanggal != '' && lingkungan != '' ){
                $.ajax({
                    url: '<?= base_url(); ?>api/rekaplingkungan/get_rekap_html',
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
                        // console.log(hasil);
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
                    var kodeamplop = $("#kodeamplop").val();
                    $.ajax({
                        url: $(this).attr("action")+kodeamplop,
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
                                swal('Proses Rekapitulasi Berhasil Ditambahkan','Proses rekapitulasi amplop coklat berhasil dilakukan','success',{
                                    timer:3000
                                });
                                setTimeout(function(){
                                    location.reload();
                                },3000); 
                            } else {
                                swal('Proses Gagal','Proses rekapitulasi amplop coklat gagal dilakukan','warning');
                            }
                        }
                    }); 
                }
            }); 

             
            e.preventDefault();
        });

    } );
</script>
