<?php include("header.php") ?>


<div class="section-header">
    <h1>Rekapitulasi Perhitungan Amplop</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= base_url()?>">Beranda</a></div>
      <div class="breadcrumb-item">Rekapitulasi Perhitungan Amplop</div>
    </div>
</div>

<div class="section-body">
    <h2 class="section-title">Grafik Rekapitulasi Perhitungan Amplop</h2>
    <p class="section-lead">Halaman untuk menampilkan grafik rekapitulasi perhitungan amplop per lingkungan</p>
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
                                    <label>Jenis Data</label>
                                    <select  id="input-option" class="form-control select2" name="option" required>
                                        <option value="user" selected >Data Rekapitulasi per Lingkungan</option>
                                        <option value="umat" <?= ($opt == 'umat')?'selected':''; ?>>Data Perhitungan Amplop per Umat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Wilayah</label>
                                    <select  id="input-wilayah" class="form-control select2" name="wilayah" >
                                        <option  value="" selected> SEMUA </option>
                                        <?php foreach ($wilayah as $d) { ?>
                                        <option  <?= ($wil == $d->kode_wilayah)?'selected':''; ?>   value="<?= $d->kode_wilayah ?>">[<?= $d->kode_wilayah; ?>] <?= $d->wilayah ?> </option>
                                        <?php } ?>
                                    </select>
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
                        <h3 class="card-title">Grafik Rekapitulasi Perhitungan Amplop</h3>
                        <div class="ml-auto">
                          <a target="_blank" href="<?= base_url()?>/grafik/perhitungan/cetak/?<?= $params; ?>" ><button class="btn btn-lg btn-danger btn-round ml-auto">
                            <i class="fa fa-file-pdf"></i>
                            Cetak PDF
                          </button></a>
                          <a target="_blank" href="<?= base_url()?>/excel/perhitungan/?<?= $params; ?>" ><button class="btn btn-lg btn-success btn-round ml-auto">
                            <i class="fa fa-file-excel"></i>
                            Export Excel
                          </button></a>
                        </div>
                    </div>
                    <!-- <div class="mb-2 mt-2">
                        <canvas id="myChart"></canvas>
                    </div> -->
                    <?php for($i=0; $i<count($list); $i++ ){ ?>
                    <div class="mb-2 mt-2">
                        <canvas id="myChart<?= $i; ?>"></canvas>
                    </div>
                    <?php } ?>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- JS Libraies -->
<script src="<?= base_url()?>assets/node_modules/chart.js/dist/Chart.min.js"></script>

<script type="text/javascript">
    function chartjs_init(id, labels,data){
        var ctx = document.getElementById(id).getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: labels,
            datasets: [{
              label: 'Total Nominal',
              data: data,
              borderWidth: 2,
              backgroundColor: '#6777ef',
              borderColor: '#6777ef',
              borderWidth: 2.5,
              pointBackgroundColor: '#ffffff',
              pointRadius: 4
            }]
          },
          options: {
            legend: {
              display: false
            },
            scales: {
              yAxes: [{
                gridLines: {
                  drawBorder: false,
                  color: '#f2f2f2',
                },
                ticks: {
                  beginAtZero: true,
                  max:<?= $max?>,
                  callback: function(value, index, values) {
                      if(parseInt(value) >= 1000){
                        return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                      } else {
                        return 'Rp. ' + value;
                      }
                    }
                }
              }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return "Rp. " + Number(tooltipItem.yLabel).toFixed(0).replace(/./g, function(c, i, a) {
                            return i > 0 && c !== "," && (a.length - i) % 3 === 0 ? "." + c : c;
                        });
                    }
                }
            }
          }
        });        
    }

    $(document).ready(function() {
        // chartjs_init("myChart",["<?= implode('","', $list[0]) ?>"],[<?= implode(',', $item[0]) ?>]);
        <?php for($i=0; $i<count($list); $i++ ){ ?>
            chartjs_init("myChart<?= $i?>",["<?= implode('","', $list[$i]) ?>"],[<?= implode(',', $item[$i]) ?>]);
        <?php } ?>

    } );
</script>
