<?php include("header.php") ?>


<div class="section-header">
    <h1>Data Lingkungan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item">Data Lingkungan</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Data Lingkungan</h2>
    <p class="section-lead">Halaman untuk manajemen data lingkungan</p>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <h3 class="card-title">Data Lingkungan</h3>
                        <a href="<?= base_url()?>lingkungan/tambah/" class="ml-auto"><button class="btn btn-primary btn-round ml-auto">
                            <i class="fa fa-plus"></i>
                            Tambah Lingkungan Baru
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
                                    <th>Kode Wilayah</th>
                                    <th>Wilayah</th>
                                    <th>Kode Lingkungan</th>
                                    <th>Lingkungan</th>
                                    <th>Jumlah KK</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $d) { ?>
                                <tr>
                                    <td><?= $d->kode_wilayah ?></td>
                                    <td><?= $d->wilayah ?></td>
                                    <td><?= $d->kode_lingkungan ?></td>
                                    <td><?= $d->lingkungan ?></td>
                                    <td><?= $d->jumlah_kk ?></td>
                                    <td>
                                        <div class="form-button-action" style="margin-left: -20px;">
                                            <div class="form-button-action">
                                                <a href="<?= base_url();?>lingkungan/edit/<?= $d->kode_lingkungan; ?>" data-toggle="tooltip" data-original-title="Edit"> 
                                                    <i class="fa fa-pencil-alt text-inverse mr-2"></i>
                                                </a>
                                                <a href="<?= base_url();?>lingkungan/delete/<?= $d->kode_lingkungan; ?>" data-toggle="tooltip" data-original-title="Hapus" class="btn-delete">
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
            </div>
        </div>
    </div>
</div>


<?php include("footer.php") ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#add-row').DataTable();
    } );
</script>
