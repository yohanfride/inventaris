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
                        <th>Jenis</th>
                        <th>Lokasi</th>
                        <th>Jumlah</th>
                        <th style="width: 10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach ($data as $d) { ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td class="text-nowrap"><?= $d->kode_barang ?></td>
                        <td><?= $d->barang ?></td>
                        <td><?= $d->jenis ?></td>
                        <td><?= $d->lokasi ?></td>
                        <td><?= number_format($d->jumlah_pinjam,0,',','.');  ?> (<?= $d->satuan ?>)</td>
                        <td>
                            <div class="form-button-action" style="margin-left: -20px;">
                                <div class="form-button-action">                                    
                                    <a onclick="hapus(<?= $d->id_peminjaman_item ?>);" data-toggle="tooltip" data-original-title="Hapus" class="btn-delete">
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