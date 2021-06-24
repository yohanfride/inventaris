<?php include("header.php") ?>


<div class="section-header">
    <h1>Data Umat</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item active"><a href="<?= base_url()?>umat<?= (!empty($params))?'/?'.$params:''; ?>">Data Umat</a></div>
      <div class="breadcrumb-item">Ubah</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Ubah Data Umat</h2>
    <p class="section-lead">Halaman untuk mengubah data umat</p>
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0">Form Ubah Data Umat </h4>
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
                                <label for="lingkungan">Lingkungan</label>
                                <select class="form-control select2" id="lingkungan" name="lingkungan" required>
                                    <?php foreach ($lingkungan as $d) { ?>
                                    <option <?= ($data->kode_lingkungan == $d->kode_lingkungan)?'selected':''; ?>  value="<?= $d->kode_lingkungan?>">[<?= $d->kode_lingkungan; ?>] <?= $d->lingkungan ?> </option>
                                    <?php } ?>
                                </select>
                            </div>  
                            <div class="form-group">
                                <label for="kk_id">KK ID</label>
                                <input type="text" class="form-control" id="kk_id" name="kk_id" placeholder="Masukkan KK ID" required="required" value="<?= $data->kk_id?>">
                            </div>
                            <div class="form-group">
                                <label for="nama" >Nama Umat</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Umat" required="required" style="text-transform:uppercase" value="<?= $data->nama?>">
                            </div>                                
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success" name="save" value="save"> <i class="fa fa-check"></i> Simpan</button>
                            <a href="<?= base_url()?>umat<?= (!empty($params))?'/?'.$params:''; ?>"><button type="button" class="btn btn-inverse">Batalkan</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("footer.php") ?>
