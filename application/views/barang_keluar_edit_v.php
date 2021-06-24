<?php include("header.php") ?>


<div class="section-header">
    <h1>Data Barang Keluar</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item active"><a href="<?= base_url()?>barangkeluar<?= (!empty($params))?'/?'.$params:''; ?>">Data Barang Keluar</a></div>
      <div class="breadcrumb-item">Ubah</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Ubah Data Barang Keluar</h2>
    <p class="section-lead">Halaman untuk ubah data barang keluar</p>
    <div class="row">
        <div class="col-md-8">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0">Form Ubah Data Barang Keluar </h4>
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
                        <div class="form-body "> 
                            <div class="form-group"id="frm_kodewil" >
                                <label for="barang">Barang</label>
                                <select class="form-control select2" id="barang" name="barang" required>
                                    <?php foreach ($barang as $d) { ?>
                                    <option <?= ($data->idbarang == $d->idbarang)?'selected':''; ?> value="<?= $d->idbarang?>">[<?= $d->kode_barang ?>] <?= $d->barang ?> </option>
                                    <?php } ?>
                                </select>
                            </div> 
                            <div class="form-group">
                                <label for="nama" >Jumlah</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah Barang Keluar" required="required" value="<?= $data->jumlah_keluar ?>">
                            </div> 
                            <div class="form-group">
                                <label for="nama" >Tanggal Input</label>
                                <input type="text" class="form-control datepicker" id="tanggal" name="tanggal" placeholder="Masukkan Tanggal Input" required="required" value="<?= $data->tanggal_keluar?>">
                            </div>
                            <div class="form-group">
                              <label>Keterangan</label>
                              <textarea  class="form-control" name="keterangan" style="min-height: 100px;"><?= $data->keterangan; ?></textarea>
                            </div>  
                            <input type="hidden" name="barang_old" value="<?= $data->idbarang; ?>"> 
                            <input type="hidden" name="jumlah_old" value="<?= $data->jumlah_keluar; ?>"> 
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