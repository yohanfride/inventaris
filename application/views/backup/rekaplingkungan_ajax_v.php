                            
                        <?php if($error){ ?>
                        <div class="alert alert-danger alert-dismissible show fade alert-has-icon">
                            <div class="alert-icon"><i class="fa fa-exclamation-triangle"></i></div>
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert"> <span>&times;</span> </button>
                                <div class="alert-title"> Perhatian</div><?= $error?>
                            </div>
                        </div>
                        <?php } else {?>
                            <div class="row pd-2 pb-2">
                                <div class="col-md-6">
                                    <div class="section-title mt-0">Jumlah Amplop Terhitung</div>
                                    <h5 ><span class="badge badge-primary"><?= $data->jumlah_amplop ?></span> Amplop </h5>
                                    <br/>
                                    <div class="section-title mt-0">Total Nominal per Amplop</div>
                                    <ul class="list-unstyled list-unstyled-border">
                                        <?php for($i=0; $i<7; $i++){ ?>
                                        <li class="media" <?= ($i==6)?'style="border-bottom: 3px solid #6777ef;"':''; ?> >
                                          <div class="media-body">
                                            <div class="media-right text-right">Rp. <?= number_format($data->amplop['amplop'.($i+1)],0,',','.');  ?></div>
                                            <div class="media-title">TOTAL AMPLOP <?= $i+1 ?></div>
                                          </div>
                                        </li>
                                        <?php } ?>
                                        <li class="media">
                                          <div class="media-body">
                                            <div class="media-right text-right"  style="font-weight: 700;"> Rp. <?= number_format($data->total,0,',','.');  ?></div>
                                            <div class="media-title text-primary"  style="font-weight: 700;">TOTAL NOMINAL UANG</div>
                                          </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <div class="section-title mt-0">Total Nominal per Pecahan</div>
                                    <ul class="list-unstyled ">
                                        <?php 
                                        $total = 0;
                                        for($i=0; $i<count($label_pecahan); $i++){ 
                                            $jumlah = $data->pecahan[$pecahan[$i]];
                                            $total_item = $jumlah * $nilai_pecahan[$i];
                                            $total+=$total_item;
                                        ?>
                                        <li class="media" <?= ($i==count($label_pecahan) - 1 )?'style="border-bottom: 3px solid #6777ef;"':''; ?> >
                                          <div class="media-body">
                                            <div class="media-right text-right">Rp. <?= number_format($total_item,0,',','.');  ?></div>
                                            <div class="media-title" style="">
                                                Pecahan <?= $label_pecahan[$i]?>
                                                <div class="text-success" style="font-size: 14px; font-weight: 700;">Jumlah : <?= number_format($jumlah,0,',','.');  ?></div>
                                            </div>
                                            
                                          </div>
                                        </li>
                                        <?php } ?>
                                        <li class="media">
                                          <div class="media-body mt-2">
                                            <div class="media-right text-right"  style=" font-weight: 700;"> Rp. <?= number_format($total,0,',','.');  ?> </div>
                                            <div class="media-title text-primary"  style=" font-weight: 700;">TOTAL NOMINAL UANG</div>
                                          </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="section-title mt-0">Informasi Perhitungan</div>
                            <div class="form-body row">
                                <div class="form-group col-md-6">
                                  <label>Tim Penghitung</label>
                                  <input type="text" class="form-control" name="penghitung" required>
                                </div>
                                <div class="form-group col-md-6">
                                  <label>Foto Fisik Perhitungan</label>
                                  <input type="file" class="form-control" name="foto" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Status Simpan Data</label>
                                    <div class="form-group">
                                        <label class="custom-switch pl-1 mr-5">
                                            <input type="radio" name="simpan" value="1" class="custom-switch-input input-option" checked>
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Simpan Data</span>
                                        </label>    
                                        <label class="custom-switch pl-1">
                                            <input type="radio" name="simpan" value="0" class="custom-switch-input input-option" >
                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">Draft Data</span>
                                        </label> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions frm-input-hide">
                                <button type="submit" class="btn btn-success" id="btn-simpan" name="save" value="save"> <i class="fa fa-check"></i> Simpan</button>
                                <button type="button" id="btn-batal" class="btn btn-danger">Batalkan Perhitungan</button>
                            </div>
                        <?php } ?>
