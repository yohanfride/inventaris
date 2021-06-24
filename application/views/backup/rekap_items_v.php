                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h4 class="card-title text-secondry">Daftar Rekap per Lingkungan</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-body row" id="frm-list">
                            <?php foreach ($list as $d) { ?>
                            <div class="col-lg-6">
                                <div class="card">
                                  <div class="card-body">
                                        <h5 class="text-secondry">Lingkungan : <?= $d->lingkungan ?> [<?= $d->kode_lingkungan ?>] </h5>
                                            <div class="media">
                                                <div class="media-body">
                                                    <div class="media-right text-right mr-1"> Rp. <?= number_format($d->total,0,',','.');  ?></div>
                                                    <div class="media-title" style="">
                                                        Total Nominal Uang
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="media">
                                                <div class="media-body">
                                                    <div class="media-right text-right mr-1"> <?= number_format($d->jumlah_amplop,0,',','.');  ?></div>
                                                    <div class="media-title">
                                                        Jumlah Amplop
                                                    </div>
                                                    <div class="text-muted text-small" style="font-size: 14px;">Tim Penghitung : <span class="text-primary"><?= $d->penghitung; ?></span> </div>
                                                </div>
                                            </div>
                                        <button class="btn btn-danger btn-action float-right mt-2" type="button" onclick="hapus(<?= $d->idrekap_lingkungan ?>);" ><i class="fas fa-trash"></i> Hapus</button>
                                  </div>
                                </div>
                            </div> 
                            <?php } ?>
                        </div>
                    </div>
                </div>    
                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h4 class="card-title text-secondry">Detail Perhitungan</h4>
                        <div class="card-header-action">
                            <h4 class="card-title text-secondry" style="font-size: 18px; font-weight: 700;" >Total Keseluruhan:&nbsp; &nbsp;<span class="float-right" id="total">Rp. <?= number_format($rekap->total,0,',','.');  ?></span> </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-body row" id="frm-list">
                        </div>
                        <div class="form-body row">
                            <?php 
                                for($i=0; $i<count($label_pecahan); $i++){ 
                                    $jumlah = $rekap->pecahan->{$pecahan[$i]};
                                    $total_item = $jumlah * $nilai_pecahan[$i];
                            ?>
                            <div class="media col-lg-3 col-md-4 col-sm-6" style="border-bottom: 1px solid #dddd; margin-bottom: 10px;">
                                <div class="media-body">
                                    <div class="media-right text-right" style="font-size: 14px; ">Rp. <?= number_format($total_item,0,',','.');  ?></div>
                                    <div class="media-title" style="">
                                        Pecahan <?= $label_pecahan[$i]?>
                                        <div class="text-success" style="font-size: 14px; font-weight: 700;">Jumlah : <?= number_format($jumlah,0,',','.');  ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div> 
                    </div>
                </div> 