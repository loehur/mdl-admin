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
                                                                <?php
                                                                if ($do['id_cashier'] > 0) {
                                                                    $cashier = $this->model('Arr')->get($this->dUser, "id_user", "nama", $do['id_cashier']);
                                                                ?>
                                                                    <td style="width: 70px;" class="text-end text-success"><small><i class="fa-sharp fa-regular fa-circle-check"></i> <?= $cashier ?></small></td>
                                                                <?php } else { ?>
                                                                    <td style="width: 70px;" class="text-end text-danger"><small><i class="fa-regular fa-circle-exclamation"></i> Verifying</small></td>
                                                                <?php } ?>
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
                                                </td>
                                                <td><small>
                                                        <?php
                                                        foreach ($divisi as $key => $dvs) {
                                                            if ($divisi_arr[$key]['status'] == 1) {
                                                                $karyawan = $this->model('Arr')->get($data['karyawan'], "id_karyawan", "nama", $divisi_arr[$key]['user_produksi']);
                                                                echo '<i class="text-success fa-solid fa-circle-check"></i> ' . $dvs . "<br>";
                                                                //echo '<i class="text-success fa-solid fa-circle-check"></i> ' . $dvs . " (" . $karyawan . ")<br>";
                                                            } else {
                                                                echo '<i class="fa-regular fa-circle"></i> ' . $dvs . "<br>";
                                                            }
                                                        }
                                                        ?>
                                                    </small>
                                                </td>
                                                <td class="text-end"><?= number_format($do['jumlah']) ?>x</td>
                                                <td class="text-end"><?= number_format($jumlah) ?></td>
                                            </tr>
                                        <?php }
                                        ?>
                                        <tr class="border-top">
                                            <td class="text-end text" colspan="3">
                                                <table class="w-100">
                                                    <tr>
                                                        <?php if ($this->userData['user_tipe'] <= 2 && $do['id_cashier'] == 0) { ?>
                                                            <td class="text-end"><small><span class="kasVerify border btn btn-sm py-1 px-1" data-ref="<?= $do['ref'] ?>">Verifikasi</span></small></td>
                                                        <?php } ?>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="text-end"><b><?= number_format($total) ?></b></td>
                                        </tr>
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

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>

<script>
    $("span.kasVerify").click(function() {
        var ref = $(this).attr("data-ref");
        $.ajax({
            url: "<?= $this->BASE_URL ?>Data_Order/cashier_verify",
            data: {
                ref: ref
            },
            type: "POST",
            success: function(result) {
                if (result == 0) {
                    content();
                } else {
                    alert(result);
                }
            },
        });
    })
</script>