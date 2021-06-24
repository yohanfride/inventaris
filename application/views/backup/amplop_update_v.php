<?php include("header.php") ?>


<div class="section-header">
    <h1>Perhitungan Amplop</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item">Perhitungan Amplop</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Perhitungan Amplop</h2>
    <p class="section-lead">Halaman untuk memasukan perhitungan per amplop</p>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0">Form Perhitungan Amplop </h4>
                </div>
                <div class="card-body">
                    <form id="frm-hitung" method="post" action="<?= base_url() ?>api/umat/update_amplop/" class="form-material" enctype="multipart/form-data" novalidate="">
                        <?php if($error){ ?>
                        <div class="alert alert-danger alert-dismissible show fade alert-has-icon">
                            <div class="alert-icon"><i class="fa fa-exclamation-triangle"></i></div>
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert"> <span>&times;</span> </button>
                                <div class="alert-title"> Perhatian</div><?= $error?>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if($success){ ?>
                        <div class="alert alert-success alert-dismissible show fade alert-has-icon">
                            <div class="alert-icon"><i class="fa fa-check"></i></div>
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert"> <span>&times;</span> </button>
                                <div class="alert-title"> Sukses</div><?= $success?>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="form-body row">
                            <div class="col-md-6">
                                <div class="section-title mt-0">Data Umat</div>
                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <label for="kk_id">KK ID</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="kk_id" name="kk_id" placeholder="Masukkan KK ID" required="required" >
                                            <div class="input-group-append">
                                              <button class="btn btn-primary" type="button" id="scan-qr"> <i class="fa fa-qrcode"></i> Scan QR</button>
                                            </div>
                                            <div class="invalid-feedback">
                                              Masukkan KK ID
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="nama" >Amplop Ke:</label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                              <button class="btn btn-primary" type="button" onclick="kurang_amplop();" style="border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;"> <i class="fa fa-minus"></i></button>
                                            </div>
                                            <input type="text" class="form-control text-center " id="amplop" name="amplop" placeholder="No. Amplop" required="required">
                                            <div class="input-group-append">
                                              <button class="btn btn-primary" type="button" onclick="tambah_amplop();"> <i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback">
                                          Masukkan Nomor Amplop
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" id="btn-cari" class="btn btn-primary" style="width: 150px;"> <i class="fa fa-search"></i> Cari</button>
                                </div>
                            </div>
                            <div class="col-md-6  frm-input-hide" style="display: none;">
                                <div class="section-title mt-0" id="list-title">Data Amplop <span class="badge badge-success pl-3 float-right">Terhitung</span></div>
                                <ul class="list-unstyled list-unstyled-border">
                                    <li class="media">
                                      <a href="#" class="d-none d-md-block">
                                        <img class="mr-3 rounded" width="50" src="<?= base_url() ?>assets/img/avatar/avatar-1.png" alt="product">
                                      </a>
                                      <div class="media-body">
                                        <div class="media-right text-right">
                                            <span id="list-amplop">Amplop xxx</span> <br/>
                                            Rp. <span id="list-nominal">xxx</span>
                                        </div>
                                        <div class="media-left" style="font-weight: 600;">
                                            <span class="text-success" id="list-nama">xx</span>
                                            <div class="text-small fw-bold"><span style="width: 100px;">LINGKUNGAN :</span><span class="ml-1" id="list-lingkungan">xxx</span> </div>
                                            <div class="text-small fw-bold"><span style="width: 100px;">WILAYAH :</span> <span class="ml-1" id="list-wilayah">xxx</span> </div>
                                            <div class="text-primary fw-bold"><span style="width: 100px; margin-top: 20px;">TOTAL KESELURUHAN KK :</span> Rp. <span class="ml-1" id="list-totalamplop">xxx</span> </div>
                                        </div>                                        
                                      </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-12  frm-input-hide" style="display: none;">
                                <div class="section-title mt-0">Perhitungan Amplop</div>
                                <div class="row">
                                    <?php for($i=0; $i<count($pecahan); $i++){ ?>
                                    <div class="form-group col-lg-2 col-md-4 col-6">
                                        <label for="input-<?= $pecahan[$i] ?>" ><?= $label_pecahan[$i] ?></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                              <button class="btn btn-primary" type="button" onclick="kurang('<?= $pecahan[$i] ?>');" style="border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem;"> <i class="fa fa-minus"></i></button>
                                            </div>
                                            <input type="number"  class="form-control text-center input-pecahan" id="input-<?= $pecahan[$i] ?>" name="<?= $pecahan[$i] ?>" value="0" required="required" >
                                            <div class="input-group-append">
                                              <button class="btn btn-primary" type="button" onclick="tambah('<?= $pecahan[$i] ?>');"> <i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-6 frm-input-hide" style="display: none;">
                                <div class="section-title mt-0">Total Uang</div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input type="text" class="form-control text-center" id="input-total" required="required" value="Rp. 0" style="font-size: 18px;font-weight: 700;" readonly="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions frm-input-hide" style="display: none;">
                            <input type="hidden" id="user_id" name="user_id" value="<?= $user_now->id; ?>">
                            <input type="hidden" id="input-tipe" name="tipe" value="">
                            <button type="submit" class="btn btn-success" id="btn-simpan" name="save" value="save"> <i class="fa fa-check"></i> Simpan</button>
                            <button type="submit" class="btn btn-warning" id="btn-update" name="update" value="save"> <i class="fa fa-pencil-alt"></i> Update</button>
                            <button type="button" id="btn-batal" class="btn btn-danger">Batalkan Perhitungan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/js/html5-qrcode/html5-qrcode.min.js"></script>
<script src="<?= base_url()?>assets/node_modules/sweetalert/sweetalert.min.js"></script>
<script src="<?= base_url()?>assets/node_modules/sweetalert/jquery.sweet-alert.custom.js"></script>

<button id="btnmodal" alt="default" data-toggle="modal" data-target="#responsive-modal" class="model_img img-responsive" style="display: none;" ></button>
<div id="responsive-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> <!-- tabindex="-1"  -->
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form-pengurangan" method="post" class="form-material" action="<?= base_url()?>bahan/api_pengurangan">
                <div class="modal-header">
                    <h4 id="modal-title">Scan QR Code</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12 mb-1">
                        <div id="qr-reader" style="width:100%"></div>
                    </div>
                    <div class="form-group col-md-10 col-sm-12 ml-auto mr-auto text-center">
                        <label>Perangkat Kamera</label>
                        <select class="form-control" id="camera">
                            <option value="#">kamera tidak terdeteksi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button id="start" type="button" class="btn btn-success frm-ajax waves-effect waves-light"><i class="fa fa-camera"></i> Hidupkan Kamera</button>
                    <button id="stop" type="button" class="btn btn-danger frm-ajax waves-effect" data-dismiss="modal"><i class="fa fa-stop-circle"></i> Matikan Kamera</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var curr_kk_id = "";
    Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator) {
      var n = this,
          decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
          decSeparator = decSeparator == undefined ? "." : decSeparator,
          thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
          sign = n < 0 ? "-" : "",
          i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
          j = (j = i.length) > 3 ? j % 3 : 0;
      return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
    };

    function hitung(){
        var pecahan = ['100k','50k','20k','10k','5k','2k','1k','1000r','500r','200r','100r'];
        var nominal = [100000,50000,20000,10000,5000,2000,1000,1000,500,200,100];
        var total = 0;
        for(i=0; i<pecahan.length; i++){
            total += parseInt($("#input-"+pecahan[i]).val()) * nominal[i];
        }
        $("#input-total").val("Rp. "+total.formatMoney(0,'.',','));
    }

    function tambah(id){
        var jmlh = parseInt($("#input-"+id).val());
        jmlh = jmlh + 1;
        $("#input-"+id).val(jmlh);
        hitung();
    }

    function kurang(id){
        var jmlh = parseInt($("#input-"+id).val());
        jmlh = jmlh - 1;
        if(jmlh<0) jmlh = 0;
        $("#input-"+id).val(jmlh);
        hitung();
    }

    function tambah_amplop(){       
        var jmlh = parseInt($("#amplop").val());
        if(!$("#amplop").val()) jmlh = 0;
        jmlh = jmlh + 1;
        if(jmlh>7) jmlh = 7;
        $("#amplop").val(jmlh);
    }

    function kurang_amplop(){
        var jmlh = parseInt($("#amplop").val());
        if(!$("#amplop").val()) jmlh = 0;
        jmlh = jmlh - 1;
        if(jmlh<1) jmlh = 1;
        $("#amplop").val(jmlh);
    }


    $(document).ready(function() {
        $(".input-pecahan").keyup(function(){
            if(!this.value){
                this.value = '0';
            }
            var val = parseInt(this.value);
            if(val<0){
                this.value = '0';
            }
            hitung();
        });

        $("#scan-qr").click(function(){
            $("#btnmodal").click();
            setTimeout(function(){
                $("#start").click();
            }, 500);
        });

        $("#btn-cari").click(function(){
            var pecahan = ['100k','50k','20k','10k','5k','2k','1k','1000r','500r','200r','100r'];
            var kk_id = $("#kk_id").val();
            var amplop = $("#amplop").val();
            if( kk_id != '' && amplop != '' ){
                if(kk_id!=curr_kk_id){
                    $(".input-pecahan").val("0");
                    curr_kk_id = kk_id;
                    hitung();
                }
                $.ajax({
                    url: '<?= base_url(); ?>api/umat/detail_amplop/',
                    data: {'kk_id':kk_id,'amplop':amplop},
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: function() {
                        $(".btn-cari").attr("disabled", true);
                    },
                    complete: function() {
                        $(".btn-cari").attr("disabled", false);
                    },
                    success: function(hasil) {
                        if(hasil.status == 'true'){
                            console.log(hasil.umat);
                            var data = hasil.umat;
                            $("#list-nama").html(data.nama);
                            $("#list-wilayah").html(data.wilayah);
                            $("#list-lingkungan").html(data.lingkungan);
                            $("#list-amplop").html('AMPLOP '+data.amplop);
                            $("#list-nominal").html(parseInt(data.nominal).formatMoney(0,'.',','));
                            $("#list-totalamplop").html(parseInt(data.totalamplop).formatMoney(0,'.',','));                            
                            var status = data.status_amplop;
                            if(status == 0){
                                $("#input-tipe").val('tambah');
                                $("#btn-update").css('display','none');
                                $("#btn-batal").css('display','none');
                                $("#btn-simpan").css('display','inline-block');
                                $("#list-title").html('Data Amplop <span class="badge badge-danger pl-3 float-right">Belum Terhitung</span>')
                            } else {
                                $("#input-tipe").val('update');
                                $("#btn-simpan").css('display','none');
                                $("#btn-update").css('display','inline-block');
                                $("#btn-batal").css('display','inline-block');
                                $("#list-title").html('Data Amplop <span class="badge badge-success pl-3 float-right">Terhitung</span>')
                                for(i=0; i<pecahan.length; i++){
                                    $("#input-"+pecahan[i]).val(data.pecahan[pecahan[i]]);
                                }
                                hitung();
                            }
                            $(".frm-input-hide").css('display','block');

                        } else {
                            swal('KK ID dan Amplop Tidak Terdaftar','Silahkan cek KK ID dan Nomor Amplop','warning',{
                                timer:2000
                            });  
                            $(".frm-input-hide").css('display','none');
                        }
                    }
                });                
            } else {
                swal('KK ID dan Amplop Tidak Lengkap','Silahkan isi KK ID dan Nomor Amplop terlebih dahulu','warning',{
                    timer:2000
                });       
            }
        });


        $("#frm-hitung").submit(function(e) {
            $.ajax({
                url: $(this).attr("action"),
                data: $(this).serialize(),
                type: $(this).attr("method"),
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
                    $("#frm-hitung").removeClass('was-validate');
                    if(hasil.status == 'true'){
                        var tipe = $("#input-tipe").val();
                        if(tipe == 'tambah'){
                            swal('Proses Perhitungan Berhasil','Proses perhitungan amplop berhasil dilakukan','success',{
                                timer:1200
                            });
                        } else {
                            swal('Proses Update Berhasil','Proses update amplop berhasil dilakukan','success',{
                                timer:1200
                            });
                        }
                        $(".frm-input-hide").css('display','none');
                    } else {
                        swal('Proses Gagal','Proses update amplop gagal dilakukan','warning');
                    }
                }
            }); 
            e.preventDefault();
        });

        $("#btn-batal").click(function(){
            swal('Apakah Anda Yakin Membatalkan Proses Perhitungan?',"Proses pembatalan perhitungan dilakukan, maka data akan dihapus secara permanen",'warning',{
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
                        url: '<?= base_url("") ?>api/umat/batal_amplop/',
                        data: {kk_id:$("#kk_id").val(),amplop:$("#amplop").val(),user_id:$("#user_id").val()},
                        type: 'POST',
                        dataType: 'json',
                        beforeSend: function() {
                            $(".btn-batal").attr("disabled", true);
                        },
                        complete: function() {
                            $(".btn-batal").attr("disabled", false);
                        },
                        success: function(hasil) {
                            $("#frm-hitung").removeClass('was-validate');
                            if(hasil.status == 'true'){
                                swal('Proses Pembatalan Berhasil','Proses pembatalan perhitungan amplop berhasil dilakukan','success',{
                                    timer:3000
                                });
                                $(".frm-input-hide").css('display','none');
                            } else {
                                swal('Proses Gagal','Proses pembatalan perhitungan amplop gagal dilakukan','warning');
                            }        
                        }
                    }); 
                }
            });        
        });
    
    });   
    function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === "complete"
            || document.readyState === "interactive") {
            // call on next available tick
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    docReady(function () {
        const html5QrCode = new Html5Qrcode("qr-reader");
        
        function start(cameraId){
            html5QrCode.start(cameraId,{
                fps: 10,qrbox: 250
            },qrCodeMessage => {
                var myarr = qrCodeMessage.split('.');
                $("#kk_id").val(myarr[0]+"."+myarr[1]);
                $("#amplop").val(myarr[2]);
                stop();
                $("#btnmodal").click();
                $("#btn-cari").click();
            },errorMessage => {
            }).catch(err => {
            });
        }

        function stop(){
            html5QrCode.stop().then(ignore => {
              console.log("QR Code scanning stopped.");
            }).catch(err => { 
              console.log("Unable to stop scanning.");
            });
        }

        Html5Qrcode.getCameras().then(devices => {
            console.log(devices); ///Camera ID   
            var listcamera = "";             
            if (devices && devices.length) {
                for(i=0; i<devices.length; i++){
                    if(devices[i].label != 'XSplit VCam')
                        listcamera+='<option value="'+devices[i].id+'">'+devices[i].label+'</option>';
                }
                $("#camera").html(listcamera);
                // var cameraId = devices[0].id;   
                // start(cameraId);            
            }
        }).catch(err => {
            console.log(err);  
        });

        $("#stop").click(function(){
            stop();
        });

        $("#start").click(function(){
            stop();
            var cameraId = $("#camera").val();
            start(cameraId);
        });

        $('#responsive-modal').on('hidden.bs.modal', function () {
            stop();
        });
    });

</script>
