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
                                                <td class="text-end"><?= number_format($do['jumlah']) ?>x <?= number_format($do['harga'])  ?></td>
                                                <td class="text-end"><?= number_format($jumlah) ?></td>
                                            </tr>
                                        <?php }
                                        ?>
                                        <tr class="border-top">
                                            <td class="text-end text" colspan="3"><b>Total</b></td>
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