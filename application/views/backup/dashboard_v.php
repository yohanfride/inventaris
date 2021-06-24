<?php include("header.php") ?>
		<div class="section-header">
			<h1>Dashboard</h1>
		</div>
		<div class="row">
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1">
					<div class="card-icon bg-primary">
						<i class="far fa-envelope"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4 class="text-primary">Jumlah Amplop Yang Dibagikan</h4>
						</div>
						<div class="card-body">
							<?= number_format($jumlah_amplop,0,',','.');  ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1">
					<div class="card-icon bg-success">
						<i class="far fa-envelope"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4 class="text-success">Jumlah Amplop Yang Telah Dihitung</h4>
						</div>
						<div class="card-body">
							<?= number_format($jumlah_amplop_terhitung,0,',','.');  ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1">
					<div class="card-icon bg-danger">
						<i class="far fa-envelope"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4 class="text-danger">Jumlah Amplop Yang Belum Dihitung</h4>
						</div>
						<div class="card-body">
							<?= number_format($jumlah_amplop - $jumlah_amplop_terhitung,0,',','.');  ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-sm-6 col-12">
				<div class="card card-statistic-1">
					<div class="card-icon bg-info">
						<i class="fas fa-percentage"></i>
					</div>
					<div class="card-wrap">
						<div class="card-header">
							<h4 class="text-info">Persentase</h4>
						</div>
						<div class="card-body">
							<?= number_format($jumlah_amplop_terhitung/$jumlah_amplop*100,2,',','.');  ?> %
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4>Total Nominal Perhitungan Amplop APP </h4>
						<div class="card-header-action">
		                    <h4 class="text-danger" style="font-size: 14px;">Berdasarkan Data Rekapitulasi Amplop Coklat</h4>
		                 </div>
					</div>
					<div class="card-body">
						<canvas id="myChart" ></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<div class="card gradient-bottom">
					<div class="card-header">
						<h4>Perhitungan Amplop Tertinggi</h4>
					</div>
					<div class="card-body top-5-scroll" >
						<ul class="list-unstyled list-unstyled-border">
							<?php foreach($linkungan_tertinggi as $d){ ?>
							<li class="media">
								<div class="media-body">
									<div class="float-right"><div class="font-weight-600 ">Rp. <?= number_format($d->total,0,',','.');  ?></div></div>
									<div class="media-title">[<?= $d->kode_lingkungan ?>] <?= $d->lingkungan ?></div>
									<div class="mt-1">
										<div class="budget-price">
											<div class="budget-price-square bg-primary"
											data-width="<?= number_format( $d->jumlah_terhitung/ $d->jumlah_amplop * 100,2,'.',',');  ?>%"></div>
											<div class="budget-price-label"><?= number_format($d->jumlah_terhitung,0,',','.');  ?></div>
										</div>
										<div class="budget-price">
											<div class="budget-price-square bg-danger" 
											data-width="<?= number_format( ( $d->jumlah_amplop - $d->jumlah_terhitung)/ $d->jumlah_amplop * 100 ,2,'.',',');  ?>%"></div>
											<div class="budget-price-label"><?= number_format( $d->jumlah_amplop - $d->jumlah_terhitung,0,',','.');  ?></div>
										</div>
									</div>
								</div>
							</li>
                            <?php } ?>
						</ul>
					</div>
					<div class="card-footer pt-3 d-flex justify-content-center">
						<div class="budget-price justify-content-center">
							<div class="budget-price-square bg-primary" data-width="20"></div>
							<div class="budget-price-label">Amplop Telah Dihitung</div>
						</div>
						<div class="budget-price justify-content-center">
							<div class="budget-price-square bg-danger" data-width="20"></div>
							<div class="budget-price-label">Amplop Belum Dihitung</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="card gradient-bottom">
					<div class="card-header">
						<h4>Perhitungan Amplop Terendah</h4>
					</div>
					<div class="card-body top-5-scroll" id="">
						<ul class="list-unstyled list-unstyled-border">
							<?php foreach($linkungan_terendah as $d){ ?>
							<li class="media">
								<div class="media-body">
									<div class="float-right"><div class="font-weight-600 ">Rp. <?= number_format($d->total,0,',','.');  ?></div></div>
									<div class="media-title">[<?= $d->kode_lingkungan ?>] <?= $d->lingkungan ?></div>
									<div class="mt-1">
										<div class="budget-price">
											<div class="budget-price-square bg-primary"
											data-width="<?= number_format( $d->jumlah_terhitung/ $d->jumlah_amplop * 100,2,'.',',');  ?>%"></div>
											<div class="budget-price-label"><?= number_format($d->jumlah_terhitung,0,',','.');  ?></div>
										</div>
										<div class="budget-price">
											<div class="budget-price-square bg-danger" 
											data-width="<?= number_format( ( $d->jumlah_amplop - $d->jumlah_terhitung)/ $d->jumlah_amplop * 100 ,2,'.',',');  ?>%"></div>
											<div class="budget-price-label"><?= number_format( $d->jumlah_amplop - $d->jumlah_terhitung,0,',','.');  ?></div>
										</div>
									</div>
								</div>
							</li>
                            <?php } ?>
						</ul>
					</div>
					<div class="card-footer pt-3 d-flex justify-content-center">
						<div class="budget-price justify-content-center">
							<div class="budget-price-square bg-primary" data-width="20"></div>
							<div class="budget-price-label">Amplop Telah Dihitung</div>
						</div>
						<div class="budget-price justify-content-center">
							<div class="budget-price-square bg-danger" data-width="20"></div>
							<div class="budget-price-label">Amplop Belum Dihitung</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 ">
				<div class="col-lg-12">
					<div class="card card-statistic-1">
						<div class="card-icon bg-primary">
							<i class="far fa-user"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4 class="text-success">Jumlah KK (Menerima Amplop)</h4>
							</div>
							<div class="card-body">
								<?= number_format($jumlah_kk,0,',','.');  ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="card card-statistic-1">
						<div class="card-icon bg-success">
							<i class="far fa-user"></i>
						</div>
						<div class="card-wrap">
							<div class="card-header">
								<h4 class="text-danger">Jumlah KK (Telah Dihitung)</h4>
							</div>
							<div class="card-body">
								<?= number_format($jumlah_kk_terhitung,0,',','.');  ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php include("footer.php") ?>
<script src="<?= base_url()?>assets/node_modules/chart.js/dist/Chart.min.js"></script>

<script type="text/javascript">
	function chartjs_init(id){
		var ctx = document.getElementById(id).getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line',
			data: {
			labels: ["<?= implode('","', $label) ?>"],
			datasets: [{
				label: 'Total Nominal',
				data: [<?= implode(',', $item) ?>],
				borderWidth: 5,
				borderColor: '#6777ef',
				backgroundColor: 'transparent',
				pointBackgroundColor: '#fff',
				pointBorderColor: '#6777ef',
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
				      display: false,
				      drawBorder: false,
				    },
				    ticks: {
                      beginAtZero: true,
                      callback: function(value, index, values) {
                          if(parseInt(value) >= 1000){
                            return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                          } else {
                            return 'Rp. ' + value;
                          }
                        }
                    }
				  }],
				  xAxes: [{
				    gridLines: {
				      color: '#fbfbfb',
				      lineWidth: 2
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
        chartjs_init("myChart");
    } );
</script>
