<?php include("header.php") ?>


<div class="section-header">
    <h1>Edit Rekap Lingkungan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item active"><a href="<?= base_url()?>rekaplingkungan<?= (!empty($params))?'/?'.$params:''; ?>">Rekap Lingkungan</a></div>
      <div class="breadcrumb-item">Edit</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Edit Rekap Perhitungan Amplop Lingkungan</h2>
    <p class="section-lead">Halaman untuk mengubah data rekap perhitungan amplop per lingkungan</p>
    <div class="row">
        <div class="col-md-12">
            <form id="frm-hitung" action="<?= base_url(); ?>api/rekaplingkungan/update/<?= $data->idrekap_lingkungan?>"  method="post" action="" class="form-material" enctype="multipart/form-data" >
                <input type="hidden" id="user_id" name="user_id" value="<?= $user_now->id; ?>">
                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h3 class="card-title">Form Edit</h3>
                    </div>
                    <div class="card-body">
                        <div class="section-title mt-0">Data Lingkungan</div>
                        <div class="form-body row">
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                  <label>Tanggal Pengitungan</label>
                                  <input type="text" id="input-tanggal" name="tanggal" value="<?= $data->date_add ?>" class="form-control datepicker" readonly>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Lingkungan</label>
                                    <input type="text" id="input-nanamalingkungan" name="nanamalingkungan" value="<?= $data->lingkungan ?>" class="form-control" readonly>
                                    <input type="hidden" id="input-lingkungan" name="lingkungan" value="<?= $data->kode_lingkungan ?>" class="form-control" >
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group" >
                                    <button id="btn-cari" class="btn btn-primary" type="button" style="margin-top: 30px;"><i class="fa fa-sync"></i>  Perbaharui</button>
                                </div>
                            </div>
                        </div>
                        <div id="frm-detail" >
                            <div class="row pd-2 pb-2">
                                <div class="col-md-6">
                                    <div class="section-title mt-0">Jumlah Amplop Terhitung</div>
                                    <h5 ><span class="badge badge-primary"><?= $data->jumlah_amplop ?></span> Amplop </h5>
                                    <br/>
                                    <div class="section-title mt-0">Total Nominal per Amplop</div>
                                    <ul class="list-unstyled list-unstyled-border">
                                        <?php for($i=0; $i<7; $i++){ ?>
                                        <li class="media" <?= ($i==6)?'style="border-bottom: 3px solid #6777ef;"':''; ?> >
                                          <div class="media-body">
                                            <div class="media-right text-right">Rp. <?= number_format($data->{'amplop'.($i+1)},0,',','.');  ?></div>
                                            <div class="media-title">TOTAL AMPLOP <?= $i+1 ?></div>
                                          </div>
                                        </li>
                                        <?php } ?>
                                        <li class="media">
                                          <div class="media-body">
                                            <div class="media-right text-right"  style="font-weight: 700;"> Rp. <?= number_format($data->total,0,',','.');  ?></div>
                                            <div class="media-title text-primary"  style="font-weight: 700;">TOTAL NOMINAL UANG</div>
                                          </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <div class="section-title mt-0">Total Nominal per Pecahan</div>
                                    <ul class="list-unstyled ">
                                        <?php 
                                        $total = 0;
                                        for($i=0; $i<count($label_pecahan); $i++){ 
                                            $jumlah = $data->pecahan_amplop->{$pecahan[$i]};
                                            $total_item = $jumlah * $nilai_pecahan[$i];
                                            $total+=$total_item;
                                        ?>
                                        <li class="media" <?= ($i==count($label_pecahan) - 1 )?'style="border-bottom: 3px solid #6777ef;"':''; ?> >
                                          <div class="media-body">
                                            <div class="media-right text-right">Rp. <?= number_format($total_item,0,',','.');  ?></div>
                                            <div class="media-title" style="">
                                                Pecahan <?= $label_pecahan[$i]?>
                                                <div class="text-success" style="font-size: 14px; font-weight: 700;">Jumlah : <?= number_format($jumlah,0,',','.');  ?></div>
                                            </div>
                                            
                                          </div>
                                        </li>
                                        <?php } ?>
                                        <li class="media">
                                          <div class="media-body mt-2">
                                            <div class="media-right text-right"  style=" font-weight: 700;"> Rp. <?= number_format($total,0,',','.');  ?> </div>
                                            <div class="media-title text-primary"  style=" font-weight: 700;">TOTAL NOMINAL UANG</div>
                                          </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>     
                        </div>
                        <div class="section-title mt-0">Informasi Perhitungan</div>
                        <div class="form-body row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                  <label>Tim Penghitung</label>
                                  <input type="text" class="form-control" name="penghitung" value="<?= $data->penghitung; ?>" required>
                                </div>         
                                <div class="form-group">
                                  <label>Update Foto Fisik Perhitungan</label>
                                  <input type="file" class="form-control" name="foto" >
                                </div>                       
                                <div class="form-group">
                                    <label>Status Simpan Data</label>
                                    <div class="form-group">
                                        <label class="custom-switch pl-1 mr-5">
                                            <input type="radio" name="simpan" value="1" class="custom-switch-input input-option" <?= ($data->status_simpan == 1)?"checked":''; ?> >
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Simpan Data</span>
                                        </label>    
                                        <label class="custom-switch pl-1">
                                            <input type="radio" name="simpan" value="0" class="custom-switch-input input-option" <?= ($data->status_simpan == 0)?"checked":''; ?>>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Draft Data</span>
                                        </label> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>Foto Fisik Perhitungan</label>
                                    <div class="chocolat-parent">
                                        <a href="<?= base_url().$data->foto; ?>" class="chocolat-image" title="Just an example">
                                            <div data-crop-image="285">
                                                <img alt="image" src="<?= base_url().$data->foto; ?>" class="img-fluid">
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions frm-input-hide">
                            <button type="submit" class="btn btn-warning" id="btn-simpan" name="save" value="save"> <i class="fa fa-pencil-alt"></i> Update</button>
                            <a href="<?= base_url()?>rekaplingkungan<?= (!empty($params))?'/?'.$params:''; ?>"><button type="button" class="btn btn-secondary">Kembali</button></a>
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
<script src="<?= base_url()?>assets/node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

<script type="text/javascript">

    $(document).ready(function() {
        $("#btn-cari").click(function(){
            var tanggal = $("#input-tanggal").val();
            var lingkungan = $("#input-lingkungan").val();
            if( tanggal != '' && lingkungan != '' ){
                $.ajax({
                    url: '<?= base_url(); ?>api/rekaplingkungan/cek_rekap_html',
                    data: {'tanggal':tanggal,'lingkungan':lingkungan,'update':'true'},
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
            swal('Apakah Anda Yakin Mengubah?',"Pastikan data real dengan data aplikasi sudah sama",'warning',{
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
                                swal('Proses Update Rekapitulasi Berhasil Ditambahkan','Proses rekapitulasi amplop per lingkungan berhasil dilakukan','success',{
                                    timer:3000
                                });
                                setTimeout(function(){
                                    location.reload();
                                },3000);
                            } else {
                                swal('Proses Gagal','Proses update rekapitulasi gagal dilakukan','warning');
                            }
                        }
                    }); 
                }
            }); 
             
            e.preventDefault();
        });

    } );
</script>
