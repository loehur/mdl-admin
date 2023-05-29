<main>
    <!-- Main page content-->
    <div class="row me-2">
        <div class="col-auto p-0 pe-1">
            <div class="container-fluid pt-2 pe-0">
                <div class="card">
                    <small>
                        <table class="table table-sm table-hover mb-0">
                            <tr>
                                <td colspan="5" class="table-danger"><b>Rekap SPK</b></td>
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
    </div>
    <div class="row me-2">
        <?php
        for ($x = 1; $x <= 2; $x++) {
            $c1 = "pe-0";
            $c2 = "p-0";
            if ($x == 1) {
                $c1 = "pe-0";
                $c2 = "p-0";
            } else {
                $c1 = "ps-0";
                $c2 = "pe-0";
            }
        ?>
            <div class="col <?= $c2 ?>">
                <?php foreach ($data['order'][$x] as $data['order_']) { ?>
                    <div class="container-fluid pt-2 <?= $c1 ?>">
                        <div class="card">
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
                                                    <td colspan="5" class="table-info"><b><?= strtoupper($pelanggan)  ?></b><span class="float-end">CS: <?= $cs  ?> [ <?= $do['insertTime'] ?> ]</span></td>
                                                </tr>
                                            <?php }
                                            ?>
                                            <tr>
                                                <td><span class="text-nowrap"><?= ucwords($produk) ?></span><br><span><?= strtoupper($detail) ?></span></td>
                                                <td>
                                                    <?php
                                                    foreach ($divisi as $key => $dvs) {
                                                        if (isset($divisi_arr[$key]['status'])) {
                                                            $karyawan = $this->model('Arr')->get($data['karyawan'], "id_karyawan", "nama", $divisi_arr[$key]['user_produksi']);
                                                            echo '<i class="text-success fa-solid fa-circle-check"></i> ' . $dvs . " (" . $karyawan . ")<br>";
                                                        } else {
                                                            echo $dvs . "<br>";
                                                        }
                                                    }
                                                    ?>
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
            <form action="<?= $this->BASE_URL ?>SPK/updateSPK/<?= $data['id_divisi'] ?>" method="POST">
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

    $("form").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: $(this).attr("method"),
            success: function(res) {
                content();
            },
        });
    });
</script>