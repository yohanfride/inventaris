<?php include("header.php") ?>


<div class="section-header">
    <h1>Data Pengguna</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item active"><a href="<?= base_url()?>user">Data Pengguna</a></div>
      <div class="breadcrumb-item">Ubah</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Ubah Data Pengguna</h2>
    <p class="section-lead">Halaman untuk mengubah data pengguna</p>
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0">Form Ubah Pengguna</h4>
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
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" required="required" value="<?= $data->username?>" >
                            </div>
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" required="required" value="<?= $data->nama?>" >
                            </div>    
                            <div class="form-group">
                                <label for="role">Level Akun</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="user" <?= ($data->role == 'user')?'selected':''; ?> >Pengguna</option>
                                    <option value="master" <?= ($data->role == 'master')?'selected':''; ?>>Administrator Master</option>
                                </select>
                            </div>                                
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success" name="save" value="save"> <i class="fa fa-check"></i> Simpan</button>
                            <a href="<?= base_url()?>"><button type="button" class="btn btn-inverse">Batalkan</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("footer.php") ?>

