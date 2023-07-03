<main>
    <?php $total = 0 ?>
    <?php if (count($data['kas']) > 0) { ?>
        <div class="p-2 ms-3 mt-3 me-3 bg-white">
            <div class="row">
                <div class="col">
                    <table class="table table-sm">
                        <tr>
                            <th class="text-end">ID</th>
                            <th>Customer</th>
                            <th>Referensi</th>
                            <th>Tanggal</th>
                            <th class="text-end">Jumlah</th>
                        </tr>
                        <?php
                        $count = 1;
                        $sum = 0;
                        $client_old = 0;
                        $rows = count($data['kas']);
                        $no = 0;
                        $total = 0;
                        foreach ($data['kas'] as $a) {
                            $no += 1;

                            $client = $a['id_client'];
                            $jumlah = $a['jumlah'];
                            $total += $jumlah;

                            if ($client_old == $client) {
                                $count += 1;
                                $sum += $jumlah;
                            }

                            $pelanggan = "Non";
                            foreach ($data['pelanggan'] as $dp) {
                                if ($dp['id_pelanggan'] == $client) {
                                    $pelanggan = $dp['nama'];
                                }
                            }

                        ?>
                            <?php
                            if (($count > 1 && $client_old <> $client)) { ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align="right">Rp<?= number_format($sum) ?></td>
                                    <td></td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <td align="right">#<?= $a['id_kas'] ?></td>
                                <td><?= strtoupper($pelanggan) ?></td>
                                <td><?= $a['ref_transaksi'] ?></td>
                                <td><?= $a['insertTime'] ?></td>
                                <td align="right">Rp<?= number_format($jumlah) ?></td>
                            </tr>

                            <?php
                            if ($client_old <> $client) {
                                $count = 1;
                                $sum = 0;
                            }

                            if (($count > 1 && $no == $rows)) { ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align="right">Rp<?= number_format($sum) ?></td>
                                    <td></td>
                                </tr>
                        <?php }
                            $client_old = $client;
                        } ?>
                    </table>

                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($total > 0) { ?>
        <div class="pt-2 pe-2 pb-0 ms-3 mt-3 me-3 bg-white">
            <div class="row">
                <div class="col">
                    <table class="table table-sm table-borderless mb-2">
                        <tr>
                            <td class="text-end text-success"><button id="setor" class="btn btn-outline-success">Buat Setoran: <b class="ms-2">Total Rp<?= number_format($total) ?></b></button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="pt-2 pe-2 pb-0 ms-3 mt-3 me-3 bg-white">
        <div class="row border-bottom">
            <div class="col ms-2">
                <span class="text-purple">Riwayat Setoran Kasir</span> <small>(Last Five)</small>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-sm table-borderless mb-2 ms-2">
                    <?php foreach ($data['setor'] as $set) {
                        $st_setor = "";
                        switch ($set['status_setoran']) {
                            case 0:
                                $st_setor = "<span class='text-warning'>Finance Checking</span>";
                                break;
                            case 1:
                                $st_setor = "<span class='text-success'>Verified</span>";
                                break;
                        }
                    ?>
                        <tr>
                            <td><?= $set['count'] ?> Transaksi</td>
                            <td><?= $set['ref_setoran'] ?></td>
                            <td class="text-end">Rp<?= number_format($set['jumlah']) ?></td>
                            <td><?= $st_setor ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</main>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>

<script>
    $("button#setor").click(function() {
        $.ajax({
            url: "<?= $this->BASE_URL ?>Setoran/setor",
            data: [],
            type: "POST",
            success: function(result) {
                if (result == 0) {
                    content();
                } else {
                    alert(result);
                }
            },
        });
    });
</script>