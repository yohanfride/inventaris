<?php include("header.php") ?>


<div class="section-header">
    <h1>Pengembalian Barang</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item active"><a href="<?= base_url()?>peminjaman<?= (!empty($params))?'/?'.$params:''; ?>">Peminjaman Barang</a></div>
      <div class="breadcrumb-item">Pengembalian Barang</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Pengembalian Barang</h2>
    <p class="section-lead">Halaman untuk menambahkan data pengembalian barang</p>
        <input type="hidden" id="user_id" name="user_id" value="<?= $user_now->id; ?>">
        <input type="hidden" id="peminjaman_id" name="peminjaman_id" value="<?= $data->idpeminjaman?>" >
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h3 class="card-title text-secondry">Form Ubah</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-body row">
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                  <label>Tanggal Peminjaman</label>
                                  <input type="text" name="tanggal" value="<?= date_format(date_create($data->tgl_pinjam), 'Y-m-d'); ?>" class="form-control " readonly>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Kode Peminjaman</label>
                                    <input type="text" id="kode" name="kode" class="form-control" required value="<?= $data->kode_peminjaman;?>" readonly>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                  <label>Peminjam</label>
                                  <input type="text" class="form-control" name="peminjam" value="<?= $data->peminjam;?>" readonly>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                  <label>Keterangan</label>
                                  <textarea  class="form-control" name="keterangan" style="min-height: 100px;" readonly><?= $data->keterangan_pinjam;?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 frm-detail" id="frm-item-detail" >
                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h4 class="card-title text-secondry">Daftar Item Peminjaman Barang</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-body row" id="frm-list">
                            <table id="add-row" class="table table-striped table-borderless table-hover " >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Pinjam</th>
                                        <th>Jumlah Kembali</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th style="width: 10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach ($list as $d) { ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td class="text-nowrap"><?= $d->kode_barang ?></td>
                                        <td><?= $d->barang ?></td>
                                        <td><?= number_format($d->jumlah_pinjam,0,',','.');  ?> (<?= $d->satuan ?>)</td>
                                        <td><?= number_format($d->jumlah_kembali,0,',','.');  ?> (<?= $d->satuan ?>)</td>
                                        <td>
                                            <?=  (!empty($d->tgl_kembali))?date_format(date_create($d->tgl_kembali), 'Y-m-d'):'-'; ?>                                        
                                        </td>
                                        <td class="text-nowrap">
                                            <?php if( ($d->status_kembali == 0) ){ ?>
                                            <span class="badge badge-warning pl-3">Belum Dikembalikan</span>
                                            <?php } else { ?>
                                            <span class="badge badge-success pl-3">Telah Dikembalikan</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <div class="form-button-action" style="margin-left: -20px;">
                                                <div class="form-button-action">                                    
                                                    <a onclick="formkembali(<?= $d->id_peminjaman_item ?>);" data-toggle="tooltip" data-original-title="Kembali" >
                                                        <i class="fa fa-sign-in-alt text-warning  mr-2"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="col-md-6">
                <form id="frm-hitung" action="<?= base_url(); ?>peminjaman/kembali_item/"  method="post" >
                
                </form>       
            </div>
        </div>
</div>


<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url()?>assets/node_modules/sweetalert/sweetalert.min.js"></script>
<script src="<?= base_url()?>assets/node_modules/sweetalert/jquery.sweet-alert.custom.js"></script>

<script type="text/javascript">
    function formkembali(id){
         $.ajax({
            url: '<?= base_url(); ?>peminjaman/kembali_form/'+id,
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
                $("#frm-kembali").html("");
                if(hasil == 'error'){
                    swal('Tidak Ada Data','Tidak ada data yang dimaksud','warning');                    
                } else {
                    $("#frm-hitung").html(hasil);
                    $('html, body').animate({
                        scrollTop: $("#frm-hitung").offset().top
                    }, 800, function(){});
                    setTimeout(function(){
                        $('.datepicker').daterangepicker({
                            locale: {format: 'YYYY-MM-DD'},
                            singleDatePicker: true,
                          });
                    },800);
                }
            },
            error:function function_name(argument) {
                swal('Proses Gagal','Coba ulangi lagi','warning');
            }
            });
    }

    $(document).ready(function() {
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
                            if(hasil == 'Jumlah lebih dari peminjaman'){
                                swal('Proses Gagal','Barang yang dikembalikan melebih jumlah peminjaman','warning');
                            } else if(hasil== 'Data gagal ditambahkan'){
                                swal('Proses Gagal','Proses pengembalian barang telah gagal dicatat','warning');
                            } else {
                                swal('Proses Peminjaman Berhasil Diubah','Proses pengembalian barang telah berhasil diubah','success',{
                                    timer:3000
                                });
                                $("#frm-hitung").html("");
                                $("#frm-list").html(hasil);
                                $('html, body').animate({
                                    scrollTop: $("#frm-list").offset().top
                                }, 800, function(){});
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
