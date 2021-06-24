<?php include("header.php") ?>


<div class="section-header">
    <h1>Data Barang</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item">Data Barang</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Data Barang</h2>
    <p class="section-lead">Halaman untuk manajemen data barang</p>
    <div class="row">
        <div class="col-md-12">
            <form  method="get" action="" class="form-material">
                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h3 class="card-title">Form Pencarian Data</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="s">Kode Barang / Nama Barang</label>
                                    <input type="text" class="form-control" data-name="s" name="s" placeholder="Tulis Kode/Nama Barang" value="<?= $s?>" >
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="lingkungan">Jenis</label>
                                    <select class="form-control select2" id="jenis" name="jenis" >
                                        <option  value=""> Semua Jenis </option>
                                        <?php foreach ($jenis as $d) { ?>
                                        <option  <?= ($jns == $d->idjenis)?'selected':''; ?>   value="<?= $d->idjenis ?>"> <?= $d->jenis ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="lingkungan">Lokasi</label>
                                    <select class="form-control select2" id="lokasi" name="lokasi" >
                                        <option  value=""> Semua Lokasi </option>
                                        <?php foreach ($lokasi as $d) { ?>
                                        <option  <?= ($lks == $d->lokasi)?'selected':''; ?>   value="<?= $d->lokasi ?>"> <?= $d->lokasi ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="lingkungan">Status Barang</label>
                                    <select class="form-control select2" id="status" name="status" >
                                        <option value="" >Semua Status</option>
                                        <option value="1" <?= ($status == '1')?'selected':''; ?> >Aktif</option>
                                        <option value="0" <?= ($status == '0')?'selected':''; ?>>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4  col-md-6 col-sm-6">
                                <div class="form-group" >
                                    <button class="btn btn-primary" type="submit" style="margin-top: 30px; width: 100px;"><i class="fa fa-search"></i>  Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>                              
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <h3 class="card-title">Data Barang</h3>
                        <a href="<?= base_url()?>barang/tambah/" class="ml-auto"><button class="btn btn-primary btn-round ml-auto">
                            <i class="fa fa-plus"></i>
                            Tambah Barang Baru
                        </button></a>
                    </div>
                    <div class="table-responsive mt-3">
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
                        <table id="add-row" class="table table-striped table-borderless table-hover " >
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jenis</th>
                                    <th>Lokasi</th>
                                    <th>Jumlah</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=$offset+1; foreach ($data as $d) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $d->kode_barang ?></td>
                                    <td><?= $d->barang ?></td>
                                    <td><?= $d->jenis ?></td>
                                    <td><?= $d->lokasi ?></td>
                                    <td><?= number_format($d->jumlah,0,',','.');  ?> (<?= $d->satuan ?>)</td>
                                    <td>
                                        <div class="form-button-action" style="margin-left: -20px;">
                                            <div class="form-button-action">
                                                <a href="<?= base_url();?>barang/edit/<?= $d->idbarang; ?>" data-toggle="tooltip" data-original-title="Edit"> 
                                                    <i class="fa fa-pencil-alt text-inverse mr-2"></i>
                                                </a>
                                                <a href="<?= base_url();?>barang/delete/<?= $d->idbarang; ?>" data-toggle="tooltip" data-original-title="Hapus" class="btn-delete">
                                                    <i class="fa fa-trash text-danger  mr-2"></i>
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
                <div class="card-footer">
                    <div class="d-lg-flex align-items-center mb-2">
                        <h6 class="card-title">Jumlah Data: <?= $jmldata?></h6>
                        <div class="text-right ml-auto">
                            <?= $paginator; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("footer.php") ?>

<script type="text/javascript">
    $(document).ready(function() {

    } );
</script>
