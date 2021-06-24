<?php include("header.php") ?>


<div class="section-header">
    <h1>Ubah Password</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item">Ubah Password</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Ubah Password</h2>
    <p class="section-lead">Halaman untuk mengganti password pengguna</p>
    <div class="col-md-8 col-lg-6">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 ">Form Ubah Password</h4>
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="password">Password Baru</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password Baru" required="required"  pattern="(?=.*\d)(?=.*[a-z]).{6,}" title="Harus berisi setidaknya satu angka dan satu huruf besar dan kecil, dan setidaknya 6 karakter atau lebih">
                                </div>
                                <div class="form-group">
                                    <label for="passconf">Tulis Ulang Password Baru</label>
                                    <input type="password" class="form-control" id="passconf" name="passconf" placeholder="Ulangi Password Baru" required="required" >
                                </div>
                                <hr/>
                                <div class="form-group">
                                    <label for="old_password">Password Lama</label>
                                    <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Masukkan Password Lama" required="required">
                                </div>
                            </div>
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


<?php include("footer.php") ?>

            
