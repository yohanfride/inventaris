<?php include("header.php") ?>


<div class="section-header">
    <h1>Data Lingkungan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item active"><a href="<?= base_url()?>lingkungan">Data Lingkungan</a></div>
      <div class="breadcrumb-item">Tambah</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Tambah Data Lingkungan</h2>
    <p class="section-lead">Halaman untuk tambah data lingkungan</p>
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0">Form Tambah Lingkungan Baru</h4>
                </div>
                <div class="card-body">
                    <form method="post" class="form-material" enctype="multipart/form-data">
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
                        <div class="form-body">
                            <div class="form-group"id="frm_kodewil" >
                                <label for="role">Wilayah</label>
                                <select class="form-control select2" id="kodewil" name="kodewil" required>
                                    <?php foreach ($wilayah as $d) { ?>
                                    <option value="<?= $d->kode_wilayah.':'.$d->wilayah ?>">[<?= $d->kode_wilayah; ?>] <?= $d->wilayah ?> </option>
                                    <?php } ?>
                                </select>
                                <div class="input-group-append mt-1">
                                  <button type="button" onclick="tambahwilayah();" class="btn btn-primary ml-auto"> <i class="fa fa-plus"></i> Tambah Baru</button>
                                </div>
                            </div> 
                            <div class="form-group" id="frm_kode_wilayah" style="display: none;">
                                <label for="kode_wilayah">Kode Wilayah</label>
                                <div class="input-group ">
                                    <input type="text" class="form-control" id="kode_wilayah" name="kode_wilayah" placeholder="Masukkan Kode Wilayah" required="required" >
                                    <div class="input-group-append">
                                      <button type="button" onclick="batalwilayah();" class="btn btn-primary ml-auto"> <i class="fa fa-times"></i> Batalkan</button>
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group" id="frm_wilayah" style="display: none;">
                                <label for="wilayah">Nama Wilayah</label>
                                <input type="text" class="form-control" id="wilayah" name="wilayah" placeholder="Masukkan Nama Wilayah" required="required" style="text-transform:uppercase" >
                            </div> 
                            <div class="form-group">
                                <label for="kode_lingkungan">Kode Lingkungan</label>
                                <input type="text" class="form-control" id="kode_lingkungan" name="kode_lingkungan" placeholder="Masukkan Kode Lingkungan" required="required" >
                            </div>
                            <div class="form-group">
                                <label for="lingkungan" >Lingkungan</label>
                                <input type="text" class="form-control" id="lingkungan" name="lingkungan" placeholder="Masukkan Nama Lingkungan" required="required" style="text-transform:uppercase" >
                            </div>                                
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success" name="save" value="save"> <i class="fa fa-check"></i> Simpan</button>
                            <a href="<?= base_url()?>lingkungan"><button type="button" class="btn btn-inverse">Batalkan</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("footer.php") ?>
<script type="text/javascript">
    function wilayah(){
        var kw = $("#kodewil").val();
        var myarr = kw.split(":");
        $("#kode_wilayah").val(myarr[0]);
        $("#wilayah").val(myarr[1]);
    }
    function tambahwilayah(){
        $("#kode_wilayah").val(''); 
        $("#wilayah").val('');
        $("#frm_kode_wilayah").css("display","block");
        $("#frm_wilayah").css("display","block");
        $("#frm_kodewil").css("display","none");
    }
    function batalwilayah(){
        wilayah();
        $("#frm_kode_wilayah").css("display","none");
        $("#frm_wilayah").css("display","none");
        $("#frm_kodewil").css("display","block");
    }
    $(document).ready(function() {
        wilayah();
        $("#kodewil").change(function(){
            wilayah();
        });
    });
</script>