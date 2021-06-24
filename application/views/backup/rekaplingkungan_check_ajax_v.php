              <?php if($error){ ?>
                <div class="alert alert-danger alert-dismissible show fade alert-has-icon">
                    <div class="alert-icon"><i class="fa fa-exclamation-triangle"></i></div>
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert"> <span>&times;</span> </button>
                        <div class="alert-title"> Perhatian</div><?= $error?>
                    </div>
                </div>
                <?php } else {?>
              <div class="card card-primary">
                    <div class="card-header">
                        <h4><?= $data->lingkungan?></h4>
                        <div class="card-header-action">
                            <input type="hidden" id="rekaplingkungan" value="<?= $data->idrekap_lingkungan?>">
                            <button type="button" class="btn btn-primary " onclick="tambah()"><span class="fa fa-plus"></span> Tambahkan Ke Amplop</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- <p>Write something here</p> -->
                        <ul class="list-unstyled list-unstyled-border">
                            <li class="media">
                                <div class="media-body">
                                    <div class="media-right text-right mr-1"> Rp. <?= number_format($data->total,0,',','.');  ?></div>
                                    <div class="media-title" style="">
                                        Total Nominal Uang
                                    </div>
                                </div>
                            </li>
                            <li class="media">
                                <div class="media-body">
                                    <div class="media-right text-right mr-1"> <?= number_format($data->jumlah_amplop,0,',','.');  ?></div>
                                    <div class="media-title" >
                                        Jumlah Amplop
                                    </div>
                                    <div class="text-muted text-small" style="font-size: 14px;">Penanggung Jawab : <span class="text-primary"><?= $data->penghitung ?></span> </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php } ?>
