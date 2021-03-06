<?php include("header.php") ?>


<div class="section-header">
    <h1>Data Jenis Barang</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item active"><a href="<?= base_url()?>jenis<?= (!empty($params))?'/?'.$params:''; ?>">Data Jenis Barang</a></div>
      <div class="breadcrumb-item">Ubah</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Tambah Data Jenis Barang</h2>
    <p class="section-lead">Halaman untuk ubah data jenis barang</p>
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0">Form Ubah Data Jenis Barang </h4>
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
                            <div class="form-group">
                                <label for="jenis" >Jenis Barang</label>
                                <input type="text" class="form-control" id="jenis" name="jenis" placeholder="Masukkan Jenis Barang" required="required" value="<?= $data->jenis?>">
                            </div>    
                            <div class="form-group">
                                <label for="jenis" >Keterangan</label>
                                <textarea  class="form-control" name="keterangan" style="min-height: 100px;"><?= $data->keterangan_jenis?></textarea>
                            </div>  

                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success" name="save" value="save"> <i class="fa fa-check"></i> Simpan</button>
                            <a href="<?= base_url()?>jenis<?= (!empty($params))?'/?'.$params:''; ?>"><button type="button" class="btn btn-inverse">Batalkan</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("footer.php") ?>
