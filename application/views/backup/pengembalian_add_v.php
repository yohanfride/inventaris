<?php include("header.php") ?>


<div class="section-header">
    <h1>Tambah Penerimaan Amplop</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item active"><a href="<?= base_url()?>pengembalian<?= (!empty($params))?'/?'.$params:''; ?>">Penerimaan Amplop</a></div>
      <div class="breadcrumb-item">Tambah</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Tambah Penerimaan Amplop Lingkungan</h2>
    <p class="section-lead">Halaman untuk menambahkan data penerimaan amplop per lingkungan</p>
    <div class="row">
        <div class="col-md-12">
            <form id="frm-hitung" action="<?= base_url(); ?>api/pengembalian/add/"  method="post" action="" class="form-material" enctype="multipart/form-data" >
                <input type="hidden" id="user_id" name="user_id" value="<?= $user_now->id; ?>">
                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h3 class="card-title">Form Tambah</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-body row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                  <label>Tanggal Penerimaan</label>
                                  <input type="text" id="input-tanggal" name="tanggal" value="<?= $str_date ?>" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Lingkungan</label>
                                    <select class="form-control select2" id="input-lingkungan" name="lingkungan" required>
                                        <?php foreach ($lingkungan as $d) { ?>
                                        <option  <?= ($ling == $d->kode_lingkungan)?'selected':''; ?>   value="<?= $d->kode_lingkungan ?>">[<?= $d->kode_lingkungan; ?>] <?= $d->lingkungan ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                  <label>Jumlah Amplop <span class="text-danger text-right">(Bukan Jumlah KK)</span></label>
                                  <input type="number" class="form-control" name="jumlah" required>
                            </div>
                            <div class="form-group col-md-6">
                                  <label>Penerima</label>
                                  <input type="text" class="form-control" name="penerima" required>
                            </div>
                            <div class="form-group col-md-6">
                              <label>Foto Fisik Amplop  </label><span class="text-info text-right">(Dapat Dikosongkan)</span>
                              <input type="file" class="form-control" name="foto">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success" id="btn-simpan" name="save" value="save"> <i class="fa fa-check"></i> Simpan</button>
                            <a href="<?= base_url()?>pengembalian<?= (!empty($params))?'/?'.$params:''; ?>"><button type="button" class="btn btn-danger">Batalkan</button></a>
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
                                swal('Data Berhasil Ditambahkan','Data Penerimaan Amplop Berhasil Ditambahkan','success',{
                                    timer:3000
                                });
                                setTimeout(function(){
                                    location.reload();
                                },3000); 
                            } else {
                                swal('Proses Gagal','Data pengembalian amplop gagal ditambahkan','warning');
                            }
                        }
                    }); 
                }
            }); 
            e.preventDefault();
        });

    } );
</script>
