<?php include("header.php") ?>


<div class="section-header">
    <h1>Tambah Peminjaman Barang</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item active"><a href="<?= base_url()?>peminjaman<?= (!empty($params))?'/?'.$params:''; ?>">Peminjaman Barang</a></div>
      <div class="breadcrumb-item">Tambah</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Tambah Peminjaman Barang</h2>
    <p class="section-lead">Halaman untuk menambahkan data peminjaman barang</p>
    <form id="frm-hitung" action="<?= base_url(); ?>peminjaman/update_billing/"  method="post" action="" class="form-material" enctype="multipart/form-data" >
        <input type="hidden" id="user_id" name="user_id" value="<?= $user_now->id; ?>">
        <input type="hidden" id="peminjaman_id" name="peminjaman_id" >
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
                                  <label>Tanggal Peminjaman</label>
                                  <input type="text" id="tanggal" name="tanggal" value="<?= $str_date ?>" class="form-control datepicker" required>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Kode Peminjaman</label>
                                    <input type="text" id="kode" name="kode" class="form-control" required value="<?= $kode;?>">
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
                        <h4 class="card-title text-secondry">Data Peminjaman Barang</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-body row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="form-group">
                                    <label>Barang</label>
                                    <select class="form-control select2" id="input-barang" required>
                                        <?php foreach ($barang as $d) { ?>
                                        <option   value="<?= $d->idbarang ?>">[<?= $d->kode_barang; ?>] <?= $d->barang ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama" >Jumlah</label>
                                    <input type="number" class="form-control" id="input-jumlah" name="jumlah" placeholder="Keluarkan Jumlah Barang Keluar" >
                                </div> 
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group" >
                                    <button id="btn-cari" class="btn btn-primary float-right" type="button"><i class="fa fa-plus"></i>  Tambahkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 frm-cari" id="frm-item-detail" style="display: none;">
                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h4 class="card-title text-secondry">Daftar Item Peminjaman Barang</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-body row" id="frm-list">
                                        
                        </div>
                    </div>
                </div>    
            </div>

            <div class="col-md-12 frm-cari" style="display: none;">
                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h4 class="card-title text-secondry">Informasi Peminjaman</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-body row">
                            <div class="form-group col-md-6">
                              <label>Peminjam</label>
                              <input type="text" class="form-control" name="peminjam" required>
                            </div>
                            <div class="form-group col-md-6">
                              <label>Keterangan</label>
                              <textarea  class="form-control" name="keterangan" style="min-height: 100px;"></textarea>
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
    function hapus(id){
        swal('Apakah Anda Yakin Menghapus?',"",'warning',{
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
                $.ajax({
                    url: '<?= base_url(); ?>peminjaman/hapus_item/'+id,
                    type: 'POST',
                    data: {},
                    dataType: 'html',
                    beforeSend: function() {
                        $("#btn-tambah").attr("disabled", true);
                    },
                    complete: function() {
                        $("#btn-tambah").attr("disabled", false);
                    },
                    success: function(hasil) {
                        if(hasil == 'error'){
                            swal('Proses Gagal','Proses penghapusan item barang gagal dilakukan','warning');
                            
                        } else {
                            swal('Proses Berhasil','Proses penghapusan item barang berhasil dilakukan','success',{
                                timer:3000
                            });
                            $("#frm-item-detail").html(hasil);
                            $('#frm-detail').html('');
                        }
                    },
                    error:function function_name(argument) {
                        swal('Proses Gagal','Coba ulangi lagi','warning');
                    }
                }); 
            }
        }); 
    }

    $(document).ready(function() {
        $("#btn-make").click(function(){
            swal('Tunggu Sebentar..!','Proses sedang berjalan..',{
                closeOnClickOutside: false,
                closeOnEsc: false,
                closeModal:false,
                buttons:false  
            });
            var tanggal = $("#tanggal").val();
            var kode = $("#kode").val();
            var user_id = $("#user_id").val();
            $.ajax({
                url: '<?= base_url(); ?>peminjaman/buat_billing/',
                type: 'POST',
                data: {'tanggal':tanggal,'kode':kode, 'user_id':user_id},
                dataType: 'json',
                beforeSend: function() {
                    $("#btn-make").attr("disabled", true);
                },
                complete: function() {
                    $("#btn-make").attr("disabled", false);
                },
                error:function function_name(argument) {
                    swal('Proses Gagal','Coba ulangi lagi','warning');
                },
                success: function(hasil) {
                    if(hasil != 'error'){
                        console.log(hasil);
                        $('.frm-cari').css("display","block"); 
                        $("#peminjaman_id").val(hasil);
                        swal('Proses Berhasil','','success',{
                                timer:3000
                            });
                    } else {
                        swal('Proses Gagal','Coba ulangi lagi','warning');
                    }
                }
            }); 
        });

        $("#btn-cari").click(function(){
            var jumlah = $("#input-jumlah").val();
            var barang = $("#input-barang").val();
            var idp = $("#peminjaman_id").val();
            if( jumlah != '' && barang != '' ){
                $.ajax({
                    url: '<?= base_url(); ?>peminjaman/tambah_item/',
                    data: {'jumlah':jumlah,'barang':barang,'peminjaman':idp},
                    type: 'POST',
                    beforeSend: function() {
                        $(".btn-cari").attr("disabled", true);
                    },
                    complete: function() {
                        $(".btn-cari").attr("disabled", false);
                    },
                    success: function(hasil) {
                        if(hasil == 'Data gagal ditambahkan'){
                            swal('Proses Gagal','Proses penambahan item barang gagal dilakukan','warning');
                        } else if(hasil == 'Jumlah lebih dari stok'){
                            swal('Proses Gagal','Jumlah stok barang lebih dari yang akan dipinjam','warning');
                        } else {
                            swal('Proses Berhasil','Proses penambahan item barang berhasil dilakukan','success',{
                                timer:3000
                            });
                            $("#frm-item-detail").html(hasil);
                            $('#frm-detail').html('');
                        }   
                    },
                    error:function (argument) {
                        console.log(argument);
                        swal('Proses Gagal','Coba ulangi lagi','warning');
                    }
                });
            } else {
                swal('Jumlah tidak ada','Silahkan pilih barang dan masukkan jumlah terlebih dahulu','warning',{
                    timer:2000
                });       
            }
        });                

        $("#frm-hitung").submit(function(e) {
            swal('Apakah Data Sudah Benar?',"Pastikan data sesuai",'warning',{
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
                    var idp = $("#peminjaman_id").val();
                    $.ajax({
                        url: $(this).attr("action")+idp,
                        type: $(this).attr("method"),
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $(".btn-simpan").attr("disabled", true);
                            $(".btn-update").attr("disabled", true);
                        },
                        complete: function() {
                            $(".btn-simpan").attr("disabled", false);
                            $(".btn-update").attr("disabled", false);
                        },
                        success: function(hasil) {
                            if(hasil== 'success'){
                                swal('Proses Peminjaman Berhasil Ditambahkan','Proses peminjaman barang telah berhasil dicatat','success',{
                                    timer:3000
                                });
                                setTimeout(function(){
                                    location.reload();
                                },3000); 
                            } else {
                                swal('Proses Gagal','Proses peminjaman barang telah gagal dicatat','warning');
                            }
                        },
                        error:function function_name(argument) {
                            swal('Proses Gagal','Coba ulangi lagi','warning');
                        }
                    }); 
                }
            }); 

             
            e.preventDefault();
        });

    } );
</script>
