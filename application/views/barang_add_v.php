<?php include("header.php") ?>


<div class="section-header">
    <h1>Data Barang</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item active"><a href="<?= base_url()?>barang<?= (!empty($params))?'/?'.$params:''; ?>">Data Barang</a></div>
      <div class="breadcrumb-item">Tambah</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Tambah Data Barang</h2>
    <p class="section-lead">Halaman untuk tambah data barang</p>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0">Form Tambah Data Barang </h4>
                </div>
                <div class="card-body">
                    <form method="post" class="form-material" enctype="multipart/form-data" >
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
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label for="kode_barang">Kode Barang</label>
                                    <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Masukkan Kode Barang" required="required" value="<?= $kode; ?>">
                                </div>
                                <div class="form-group"id="frm_kodewil" >
                                    <label for="jenis">Jenis</label>
                                    <select class="form-control select2" id="jenis" name="jenis" required>
                                        <?php foreach ($jenis as $d) { ?>
                                        <option value="<?= $d->idjenis?>"><?= $d->jenis ?> </option>
                                        <?php } ?>
                                    </select>
                                </div> 
                                <div class="form-group">
                                    <label for="nama" >Nama Barang</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Barang" required="required">
                                </div>   
                                <div class="form-group">
                                    <label for="nama" >Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah Barang" required="required">
                                </div>    
                                <div class="form-group">
                                    <label for="nama" >Satuan</label>
                                    <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Masukkan Satuan Barang" required="required">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label for="nama" >Lokasi</label>
                                    <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Masukkan Lokasi Barang" required="required">
                                </div>
                                <div class="form-group">
                                    <label for="nama" >Tanggal Input</label>
                                    <input type="text" class="form-control datepicker" id="tanggal" name="tanggal" placeholder="Masukkan Tanggal Input" required="required" value="<?= date('Y-m-d'); ?>">
                                </div>
                                <div class="form-group">
                                  <label>Foto </label>
                                  <input type="file" class="form-control" name="foto" required>
                                </div>
                                <div class="form-group">
                                  <label>Keterangan</label>
                                  <textarea  class="form-control" name="keterangan" style="min-height: 100px;"></textarea>
                                </div>   
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success" name="save" value="save"> <i class="fa fa-check"></i> Simpan</button>
                            <a href="<?= base_url()?>barang<?= (!empty($params))?'/?'.$params:''; ?>"><button type="button" class="btn btn-inverse">Batalkan</button></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>