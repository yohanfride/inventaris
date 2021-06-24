<?php include("header.php") ?>


<div class="section-header">
    <h1>Data Perhitungan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item">Data Perhitungan</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Data Perhitungan Amplop</h2>
    <p class="section-lead">Halaman untuk manjemen data perhitungan amplop</p>
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
                                    <label for="s">Nama / KK ID</label>
                                    <input type="text" class="form-control" data-name="s" name="s" placeholder="Tulis nama uamt atau KK ID" value="<?= $s?>" >
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="lingkungan">Lingkungan</label>
                                    <select class="form-control select2" id="lingkungan" name="lingkungan" required>
                                        <?php foreach ($lingkungan as $d) { ?>
                                        <option  <?= ($ling == $d->kode_lingkungan)?'selected':''; ?>   value="<?= $d->kode_lingkungan ?>">[<?= $d->kode_lingkungan; ?>] <?= $d->lingkungan ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
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
                        <h3 class="card-title">Data Perhitungan Amplop</h3>
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
                                    <th>Wilayah</th>
                                    <th>Lingkungan</th>
                                    <th>KK ID</th>
                                    <th>Nama</th>
                                    <th class="text-nowrap">Amplop 1</th>
                                    <th class="text-nowrap">Amplop 2</th>
                                    <th class="text-nowrap">Amplop 3</th>
                                    <th class="text-nowrap">Amplop 4</th>
                                    <th class="text-nowrap">Amplop 5</th>
                                    <th class="text-nowrap">Amplop 6</th>
                                    <th class="text-nowrap">Amplop 7</th>
                                    <th class="text-nowrap">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=$offset+1; foreach ($data as $d) { ?>
                                <tr>
                                    <td class="text-nowrap"><?= $no++; ?></td>
                                    <td class="text-nowrap"><?= $d->wilayah ?></td>
                                    <td class="text-nowrap"><?= $d->lingkungan ?></td>
                                    <td class="text-nowrap"><?= $d->kk_id ?></td>
                                    <td><?= $d->nama ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->amplop1,0,',','.');  ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->amplop2,0,',','.');  ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->amplop3,0,',','.');  ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->amplop4,0,',','.');  ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->amplop5,0,',','.');  ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->amplop6,0,',','.');  ?></td>
                                    <td class="text-nowrap">Rp. <?= number_format($d->amplop7,0,',','.');  ?></td>
                                    <td class="text-nowrap">
                                        <?php if( ($d->status_amplop1 != 0) || ($d->status_amplop2 != 0) || ($d->status_amplop3 != 0) || ($d->status_amplop4 != 0) || ($d->status_amplop5 != 0) || ($d->status_amplop6 != 0) || ($d->status_amplop7 != 0)  ){ ?>
                                        <span class="badge badge-success pl-3">Terhitung</span>
                                        <?php } else { ?>
                                        <span class="badge badge-danger pl-3">Belum</span> 
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
    $(document).ready(function() {
        $('.datepicker').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
    } );
</script>
