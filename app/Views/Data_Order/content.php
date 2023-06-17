<style>
    .selectize-control {
        padding: 0;
    }

    .selectize-input {
        border: none;
    }

    .selectize-input::after {
        visibility: hidden;
    }
</style>

<main>
    <!-- Main page content-->
    <div class="row me-2">
        <?php foreach ($data['order'] as $ref => $data['order_']) { ?>
            <div class="col-md-6 px-1 pe-0 ps-0">
                <div class="container-fluid pt-2 pe-0">
                    <div class="card p-0">
                        <small>
                            <table class="table table-sm table-hover mb-0">
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($data['order_'] as $do) {
                                        $no++;
                                        $id = $do['id_order_data'];
                                        $id_order_data = $do['id_order_data'];
                                        $id_produk = $do['id_produk'];

                                        if ($no == 1) {
                                            foreach ($data['pelanggan'] as $dp) {
                                                if ($dp['id_pelanggan'] == $do['id_pelanggan']) {
                                                    $pelanggan = $dp['nama'];
                                                }
                                            }

                                            foreach ($data['karyawan'] as $dp) {
                                                if ($dp['id_karyawan'] == $do['id_penerima']) {
                                                    $cs = $dp['nama'];
                                                }
                                            }
                                    ?>
                                            <tr>
                                                <td colspan="5">
                                                    <table class="w-100 p-0 m-0">
                                                        <tr>
                                                            <td><a href="<?= $this->BASE_URL ?>Data_Operasi/index/<?= $do['id_pelanggan'] ?>"><b><?= strtoupper($pelanggan) ?></a> <span class="text-danger"><?= substr($ref, -4) ?></span></b></td>
                                                            <td style="width: 180px;" class="text-end"><small><?= $cs  ?> [<?= substr($do['insertTime'], 2, -3) ?>]</span></small></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        <?php }
                                        ?>
                                    <?php }

                                    ?>
                                </tbody>
                            </table>
                        </small>
                    </div>
                </div>
            </div>
        <?php
        } ?>
    </div>
</main>

<form action="<?= $this->BASE_URL; ?>Data_Order/ambil_semua" method="POST">
    <div class="modal" id="exampleModal3">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pengambilan Semua</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <label class="form-label">Karyawan</label>
                                <input type="hidden" name="ambil_ref">
                                <select class="form-select tize" name="id_karyawan" required>
                                    <option></option>
                                    <?php foreach ($data['karyawan'] as $k) { ?>
                                        <option value="<?= $k['id_karyawan'] ?>"><?= $k['nama'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <button type="submit" data-bs-dismiss="modal" class="btn btn-primary">Ambil Semua</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>

<form action="<?= $this->BASE_URL; ?>Data_Order/ambil" method="POST">
    <div class="modal" id="exampleModal4">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pengambilan</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <label class="form-label">Karyawan</label>
                                <input type="hidden" name="ambil_id">
                                <select class="form-select tize" name="id_karyawan" required>
                                    <option></option>
                                    <?php foreach ($data['karyawan'] as $k) { ?>
                                        <option value="<?= $k['id_karyawan'] ?>"><?= $k['nama'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <button type="submit" data-bs-dismiss="modal" class="btn btn-primary">Ambil</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>

<form action="<?= $this->BASE_URL; ?>Data_Order/bayar" method="POST">
    <div class="modal" id="exampleModal2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pembayaran</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <label class="form-label">Jumlah Bill (Rp)</label>
                                <input type="number" name="bill" class="form-control bill" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Metode</label>
                                <select name="method" class="form-select metodeBayar" required>
                                    <option value="1">Tunai</option>
                                    <option value="2">Non Tunai</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <label class="form-label">Bayar (Rp) <a class="bayarPas">Bayar Pas (Click)</a></label>
                                <input type="number" name="jumlah" class="form-control dibayar" required>
                                <input type="hidden" name="ref" id="refBayar" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Kembalian (Rp)</label>
                                <input type="number" class="form-control kembalian" readonly>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <button type="submit" data-bs-dismiss="modal" class="btn btn-primary">Bayar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>