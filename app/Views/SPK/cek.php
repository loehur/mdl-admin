<main>
    <div class="row"></div>
    <?php foreach ($data['order'] as $ref => $data['order_']) { ?>
        <div class="col py-2">
            <div class="container-fluid">
                <div class="card">
                    <small>
                        <table class="table table-sm">
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
                                                        <td><span class="text-danger"><?= substr($ref, -4) ?></span> <b><?= strtoupper($pelanggan) ?></b></td>
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
        </div>
    <?php } ?>
    </div>
</main>