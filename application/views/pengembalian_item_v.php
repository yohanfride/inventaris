                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h4 class="card-title text-secondry">Daftar Item Peminjaman Barang</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-body row" id="frm-list">
                            <table id="add-row" class="table table-striped table-borderless table-hover " >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Pinjam</th>
                                        <th>Jumlah Kembali</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th style="width: 10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach ($list as $d) { ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td class="text-nowrap"><?= $d->kode_barang ?></td>
                                        <td><?= $d->barang ?></td>
                                        <td><?= number_format($d->jumlah_pinjam,0,',','.');  ?> (<?= $d->satuan ?>)</td>
                                        <td><?= number_format($d->jumlah_kembali,0,',','.');  ?> (<?= $d->satuan ?>)</td>
                                        <td>
                                            <?=  (!empty($d->tgl_kembali))?date_format(date_create($d->tgl_kembali), 'd/m/Y'):'-'; ?>                                        
                                        </td>
                                        <td class="text-nowrap">
                                            <?php if( ($d->status_kembali == 0) ){ ?>
                                            <span class="badge badge-warning pl-3">Belum Dikembalikan</span>
                                            <?php } else { ?>
                                            <span class="badge badge-success pl-3">Telah Dikembalikan</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <div class="form-button-action" style="margin-left: -20px;">
                                                <div class="form-button-action">                                    
                                                    <a onclick="formkembali(<?= $d->id_peminjaman_item ?>);" data-toggle="tooltip" data-original-title="Kembali" >
                                                        <i class="fa fa-sign-in-alt text-warning  mr-2"></i>
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