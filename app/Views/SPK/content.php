<main>
    <!-- Main page content-->
    <div class="row me-2">
        <div class="col-md-4 p-0 pe-1">
            <div class="container-fluid pt-2 pe-0">
                <div class="card">
                    <small>
                        <table class="table table-sm table-hover mb-0">
                            <tr>
                                <td colspan="5" class="table-danger">Rekap SPK - <b>Tahap I</b></td>
                            </tr>
                            <?php foreach ($data['recap'] as $r) { ?>
                                <tr>
                                    <td><?= strtoupper($r['spk']) ?></td>
                                    <td><?= $r['jumlah'] ?> Pcs</td>
                                    <td><span class="border rounded px-1 py-1 btn updateSPK" data-order="<?= $r['order'] ?>" data-bs-toggle="modal" data-bs-target="#updateSPK">Update</span></td>
                                </tr>
                            <?php }
                            ?>
                        </table>
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-4 p-0 pe-1">
            <div class="container-fluid pt-2 pe-0">
                <div class="card">
                    <small>
                        <table class="table table-sm table-hover mb-0">
                            <tr>
                                <td colspan="5" class="table-warning">Rekap SPK - <b>Tahap II</b></td>
                            </tr>
                            <?php foreach ($data['recap_2'] as $r) { ?>
                                <tr>
                                    <td><?= strtoupper($r['spk']) ?></td>
                                    <td><?= $r['jumlah'] ?> Pcs</td>
                                    <td><span class="border rounded px-1 py-1 btn updateSPK" data-order="<?= $r['order'] ?>" data-bs-toggle="modal" data-bs-target="#updateSPK2">Update</span></td>
                                </tr>
                            <?php }
                            ?>
                        </table>
                    </small>
                </div>
            </div>
        </div>
        <div class="col-md-4 p-0 pe-1">
            <div class="container-fluid pt-2 pe-0">
                <div class="card">
                    <small>
                        <table class="table table-sm table-hover mb-0">
                            <tr>
                                <td colspan="5" class="table-success">Rekap SPK - <b>Selesai</b></td>
                            </tr>
                            <?php foreach ($data['recap_d'] as $r) { ?>
                                <tr>
                                    <td><?= strtoupper($r['spk']) ?></td>
                                    <td><?= $r['jumlah'] ?> Pcs</td>
                                    <td><span class="border rounded px-1 py-1 btn cekSPK" data-order="<?= $r['order'] ?>" data-bs-toggle="modal" data-bs-target="#cekSPK">Cek</span></td>
                                </tr>
                            <?php }
                            ?>
                        </table>
                    </small>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row me-2">
        <?php
        for ($x = 1; $x <= 2; $x++) { ?>
            <div class="col px-1 pe-0 ps-0">
                <?php foreach ($data['order'][$x] as $data['order_']) { ?>
                    <div class="container-fluid pt-2 pe-0">
                        <div class="card p-0">
                            <small>
                                <table class="table table-sm table-hover mb-0">
                                    <tbody>
                                        <?php

                                        $no = 0;
                                        $total = 0;
                                        foreach ($data['order_'] as $key => $do) {
                                            $no++;
                                            $jumlah = $do['harga'] * $do['jumlah'];
                                            $total += $jumlah;
                                            $id_order_data = $do['id_order_data'];
                                            $id_produk = $do['id_produk'];
                                            $detail_arr = unserialize($do['produk_detail']);
                                            $detail = "";
                                            foreach ($detail_arr as $da) {
                                                $detail .= $da['detail_name'] . ", ";
                                            }

                                            foreach ($this->dProduk as $dp) {
                                                if ($dp['id_produk'] == $id_produk) {
                                                    $produk = $dp['produk'];
                                                }
                                            }

                                            $divisi_arr = unserialize($do['spk_dvs']);
                                            $divisi = [];
                                            foreach ($divisi_arr as $key => $dv) {
                                                foreach ($this->dDvs as $dv_) {
                                                    if ($dv_['id_divisi'] == $key) {
                                                        $divisi[$key] = $dv_['divisi'];
                                                    }
                                                }
                                            }

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
                                                    <td colspan="5" class="table-light">
                                                        <table class="w-100 p-0 m-0">
                                                            <tr>
                                                                <td><b><?= strtoupper($pelanggan)  ?></b></td>
                                                                <td style="width: 180px;" class="text-end"><small><?= $cs  ?> [<?= substr($do['insertTime'], 2, -3) ?>]</span></small></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            <?php }
                                            ?>
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td colspan="10"><span class="text-nowrap text-success"><small><?= ucwords($produk) ?></small></span><br>
                                                        <tr>
                                                        <tr>
                                                            <?php
                                                            foreach ($detail_arr as $da) { ?>
                                                                <td class="pe-1" nowrap>
                                                                    <?= "<small>" . $da['group_name'] . "</small> <br>" . strtoupper($da['detail_name']) ?>
                                                                </td>
                                                            <?php } ?>
                                                        </tr>
                                                    </table>
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            <span class="text-nowrap">
                                                                <small>Catatan Utama</small><br><span><?= $do['note'] ?></span>
                                                            </span>
                                                        </div>
                                                        <div class="col-auto">
                                                            <span class="text-nowrap">
                                                                <small>Catatan Produksi</small><br>
                                                                <span>
                                                                    <?php
                                                                    foreach (unserialize($do['note_spk']) as $ks => $ns) {
                                                                        echo $this->model('Arr')->get($this->dDvs, "id_divisi", "divisi", $ks) . ": " . $ns . ", ";
                                                                    }
                                                                    ?>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><small>
                                                        <?php
                                                        foreach ($divisi as $key => $dvs) {
                                                            if ($divisi_arr[$key]['status'] == 1) {
                                                                $karyawan = $this->model('Arr')->get($data['karyawan'], "id_karyawan", "nama", $divisi_arr[$key]['user_produksi']);
                                                                echo '<i class="fa-solid fa-check text-success"></i> ' . $dvs . " (" . $karyawan . ")<br>";
                                                            } else {
                                                                $spkDone = false;
                                                                echo '<i class="fa-regular fa-circle"></i> ' . $dvs . "<br>";
                                                            }

                                                            if ($divisi_arr[$key]['cm'] == 1) {
                                                                if ($divisi_arr[$key]['cm_status'] == 1) {
                                                                    $karyawan = $this->model('Arr')->get($data['karyawan'], "id_karyawan", "nama", $divisi_arr[$key]['user_cm']);
                                                                    echo '<i class="fa-solid text-success fa-check-double"></i> ' . $dvs . " (" . $karyawan . ")<br>";
                                                                } else {
                                                                    $spkDone = false;
                                                                    echo '<i class="fa-regular fa-circle"></i> ' . $dvs . '<br>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </small>
                                                </td>
                                                <td class="text-end"><?= number_format($do['jumlah']) ?></td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                            </small>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php }
        ?>
    </div>
</main>

<div class="modal fade" id="updateSPK" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update SPK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= $this->BASE_URL ?>SPK/updateSPK/<?= $data['id_divisi'] ?>/1" method="POST">
                <div class="modal-body">
                    <div class="col mb-2">
                        <label class="form-label">User Produksi</label>
                        <select class="form-select tize" name="id_karyawan" required>
                            <option></option>
                            <?php foreach ($data['karyawan'] as $k) { ?>
                                <option value="<?= $k['id_karyawan'] ?>"><?= $k['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col" id="cekUpdate"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Selesai</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="updateSPK2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update SPK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= $this->BASE_URL ?>SPK/updateSPK/<?= $data['id_divisi'] ?>/2" method="POST">
                <div class="modal-body">
                    <div class="col mb-2">
                        <label class="form-label">User Produksi</label>
                        <select class="form-select tize" name="id_karyawan" required>
                            <option></option>
                            <?php foreach ($data['karyawan'] as $k) { ?>
                                <option value="<?= $k['id_karyawan'] ?>"><?= $k['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col" id="cekUpdate"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Selesai</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="cekSPK" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SPK Selesai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= $this->BASE_URL ?>SPK/updateSPK/<?= $data['id_divisi'] ?>" method="POST">
                <div class="modal-body">
                    <div class="col" id="cekSelesai"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Selesai</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/selectize.min.js"></script>
<script>
    $(document).ready(function() {
        $('select.tize').selectize();
    });

    $('span.updateSPK').click(function() {
        var order = $(this).attr("data-order");
        $("div#cekUpdate").load('<?= $this->BASE_URL ?>SPK/load_update/' + order);
    });


    $('span.cekSPK').click(function() {
        var order = $(this).attr("data-order");
        $("div#cekSelesai").load('<?= $this->BASE_URL ?>SPK/load_selesai/' + order);
    });

    $("form").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: $(this).attr("method"),
            success: function(res) {
                if (res == 0) {
                    content();
                } else {
                    alert(res);
                }
            },
        });
    });
</script>