                <div class="card">
                    <div class="card-header" style="padding-bottom: 0px;">
                        <h4 class="card-title text-secondry">Data Peminjaman Barang</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-body row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="form-group">
                                    <label for="nama" >Barang</label>
                                    <input type="text" class="form-control" id="input-barang" name="barang" value="<?= '['.$data->kode_barang.'] '.$data->barang ?>" readonly>
                                </div> 
                                <div class="form-group">
                                    <label for="nama" >Jumlah Pinjam</label>
                                    <input type="number" class="form-control" id="input-jumlah-pinjam" name="jumlah_pinjam" value="<?= $data->jumlah_pinjam ?>" readonly>
                                </div> 
                                <div class="form-group">
                                    <label for="nama" >Jumlah Kembali</label>
                                    <input type="number" class="form-control" id="input-jumlah-kembali" name="jumlah" value="<?= $data->jumlah_kembali ?>" required>
                                </div>
                                <div class="form-group">
                                  <label>Tanggal Pengembalian</label>
                                  <input type="text" id="tanggal" name="tanggal" value="<?= date('Y-m-d'); ?>" class="form-control datepicker" required>
                                </div>
                                <input type="hidden" id="item_peminjaman" name="item_peminjaman" value="<?= $data->id_peminjaman_item ?>" >
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group" >
                                    <button class="btn btn-primary float-right" type="submit"><i class="fa fa-check"></i>  Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
