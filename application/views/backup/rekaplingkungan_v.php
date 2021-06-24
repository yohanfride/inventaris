<?php include("header.php") ?>


<div class="section-header">
    <h1>Rekap Lingkungan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item">Rekap Lingkungan</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Data Rekap Perhitungan Amplop Lingkungan</h2>
    <p class="section-lead">Halaman untuk manjemen data rekap perhitungan amplop per lingkungan</p>
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
                                    <label class="custom-switch pl-1">
                                        <input type="radio" name="option" value="1" class="custom-switch-input input-option" checked>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Semua Data</span>
                                    </label>
                                    <input id="input-all" type="text" value="SEMUA WILAYAH & LINGKUNGAN" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <!-- <label for="lingkungan">Wilayah</label>  -->
                                    <label class="custom-switch pl-1">
                                        <input type="radio" name="option" value="2" class="custom-switch-input input-option" <?= ($wil)?'checked':''; ?> >
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Wilayah</span>
                                    </label>
                                    <select  id="input-wilayah" class="form-control select2" name="wilayah" required>
                                        <?php foreach ($wilayah as $d) { ?>
                                        <option  <?= ($wil == $d->kode_wilayah)?'selected':''; ?>   value="<?= $d->kode_wilayah ?>">[<?= $d->kode_wilayah; ?>] <?= $d->wilayah ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="custom-switch pl-1" >
                                        <input type="radio" name="option" value="3" class="custom-switch-input input-option" <?= ($ling)?'checked':''; ?>>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Lingkungan</span>
                                    </label>
                                    <select class="form-control select2" id="input-lingkungan" name="lingkungan" required>
                                        <?php foreach ($lingkungan as $d) { ?>
                                        <option  <?= ($ling == $d->kode_lingkungan)?'selected':''; ?>   value="<?= $d->kode_lingkungan ?>">[<?= $d->kode_lingkungan; ?>] <?= $d->lingkungan ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                  <label>Tanggal Pecatatan Awal</label>
                                  <input type="text" name="str" value="<?= $str_date ?>" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                  <label>Tanggal Pecatatan Akhir</label>
                                  <input type="text" name="end" value="<?= $end_date ?>" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
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
                        <h3 class="card-title">Data Rekap Perhitungan Amplop</h3>
                        <a href="<?= base_url()?>rekaplingkungan/tambah/" class="ml-auto"><button class="btn btn-primary btn-round ml-auto">
                            <i class="fa fa-plus"></i>
                            Tambah Rekap Baru
                        </button></a>
                    </div>
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
                    <div class="table-responsive mt-3">
                        <table id="add-row" class="table table-striped table-borderless table-hover " >
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Wilayah</th>
                                    <th>Lingkungan</th>
                                    <th>Total</th>
                                    <th>Jumlah Amplop</th>
                                    <th class="text-nowrap">Amplop 1</th>
                                    <th class="text-nowrap">Amplop 2</th>
                                    <th class="text-nowrap">Amplop 3</th>
                                    <th class="text-nowrap">Amplop 4</th>
                                    <th class="text-nowrap">Amplop 5</th>
                                    <th class="text-nowrap">Amplop 6</th>
                                    <th class="text-nowrap">Amplop 7</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=$offset+1; foreach ($data as $d) { ?>
                                <tr>
                                    <td class="text-nowrap"><?= $no++; ?></td>
                                    <td class="text-nowrap"><?= date_format(date_create($d->date_add), 'd/m/Y'); ?></td>
                                    <td class="text-nowrap"><?= $d->wilayah ?></td>
                                    <td class="text-nowrap"><?= $d->lingkungan ?> [<?= $d->kode_lingkungan ?>] </td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->total,0,',','.');  ?></td>
                                    <td class="text-nowrap"><?= number_format($d->jumlah_amplop,0,',','.');  ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->amplop1,0,',','.');  ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->amplop2,0,',','.');  ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->amplop3,0,',','.');  ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->amplop4,0,',','.');  ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->amplop5,0,',','.');  ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->amplop6,0,',','.');  ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->amplop7,0,',','.');  ?></td>
                                    <td class="text-nowrap">
                                        <?php if( ($d->status_simpan == 0) ){ ?>
                                        <span class="badge badge-warning pl-3">Draft</span>
                                        <?php } else if( ($d->status_pakai != 0) ){ ?>
                                        <span class="badge badge-success pl-3">Dipakai</span>
                                        <?php } else { ?>
                                        <span class="badge badge-primary pl-3">Belum Dipakai</span> 
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if( $user_now->role == 'master' || ( $d->status_simpan == 0 && $user_now->id == $d->user_id )  ){ ?>
                                        <div class="form-button-action" style="margin-left: -20px;">
                                            <div class="form-button-action">
                                                <a href="<?= base_url();?>rekaplingkungan/edit/<?= $d->idrekap_lingkungan; ?>" data-toggle="tooltip" data-original-title="Edit"> 
                                                    <i class="fa fa-pencil-alt text-inverse mr-2"></i>
                                                </a>
                                                <a href="<?= base_url();?>rekaplingkungan/delete/<?= $d->idrekap_lingkungan; ?>" data-toggle="tooltip" data-original-title="Hapus" class="btn-delete">
                                                    <i class="fa fa-trash text-danger  mr-2"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <?php } ?>
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
<script src="<?= base_url()?>assets/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>

<script type="text/javascript">
    
    function checked(value){
        if(value == 1){
            $('#input-wilayah').select2("enable", false);
            $('#input-lingkungan').select2("enable", false);
            $("#input-all").prop('disabled', false);
        } else if(value == 2) {
            $('#input-wilayah').select2("enable");
            $('#input-lingkungan').select2("enable", false);
            $("#input-all").prop('disabled', true);
        } else if(value == 3) {
            $('#input-wilayah').select2("enable", false);
            $('#input-lingkungan').select2("enable");
            $("#input-all").prop('disabled', true);
        }
    }

    $(document).ready(function() {
        checked(<?= $opt; ?>)
        $(".input-option").change(function(){
            checked(this.value);
        });
    } );
</script>
