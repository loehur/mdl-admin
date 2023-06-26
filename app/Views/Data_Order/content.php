<?php $modeView = $data['parse'] ?>
<main>
    <div class="p-2 ms-3 mt-3 me-3 bg-white">
        <div class="row mb-1">
            <div class="col-auto pe-0">
                <input type="text" placeholder="Search..." id="myInput" class="form-control form-control-sm">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form id="main">
                    <div class="d-flex align-items-start align-items-end pt-1">
                        <div class="ps-0 pe-1">
                            <?php $outline = ($modeView == 0) ? "" : "outline-" ?>
                            <a href="<?= $this->BASE_URL ?>Data_Order/index/0" type="button" class="btn btn-sm btn-<?= $outline ?>primary">
                                Terkini
                            </a>
                            <?php $outline = "outline-" ?>
                        </div>
                        <div class="ps-0 pe-1">
                            <?php $outline = ($modeView == 1) ? "" : "outline-" ?>
                            <a href="<?= $this->BASE_URL ?>Data_Order/index/1" type="button" class="btn btn-sm btn-<?= $outline ?>success">
                                >1 Minggu
                            </a>
                            <?php $outline = "outline-" ?>
                        </div>
                        <div class="ps-0 pe-1">
                            <?php $outline = ($modeView == 2) ? "" : "outline-" ?>
                            <a href="<?= $this->BASE_URL ?>Data_Order/index/2" type="button" class="btn btn-sm btn-<?= $outline ?>info">
                                >1 Bulan
                            </a>
                            <?php $outline = "outline-" ?>
                        </div>
                        <div class="ps-0 pe-1">
                            <?php $outline = ($modeView == 3) ? "" : "outline-" ?>
                            <a href="<?= $this->BASE_URL ?>Data_Order/index/3" type="button" class="btn btn-sm btn-<?= $outline ?>secondary">
                                >1 Tahun
                            </a>
                            <?php $outline = "outline-" ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Main page content-->
    <small>
        <div class="ms-1 mt-2 me-1">
            <div class="row row-cols-2 mx-2 mt-2">
                <?php foreach ($data['order'] as $ref => $data['order_']) { ?>
                    <?php
                    $no = 0;
                    foreach ($data['order_'] as $do) {
                        $no++;
                        $id = $do['id_order_data'];
                        $id_order_data = $do['id_order_data'];
                        $id_produk = $do['id_produk'];
                        $dateTime = substr($do['insertTime'], 0, 10);
                        $today = date("Y-m-d");

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
                            <div class="col px-1">
                                <table class="w-100 mb-1 target bg-white <?= ($dateTime == $today) ? 'border-bottom border-success' : 'border-bottom border-warning' ?>">
                                    <tr>
                                        <td class="p-1"><span class="text-danger"><?= substr($ref, -4) ?></span> <a href="<?= $this->BASE_URL ?>Data_Operasi/index/<?= $do['id_pelanggan'] ?>"><b><?= strtoupper($pelanggan) ?></a></b></td>
                                        <td class="p-1 text-end"><small><?= $cs  ?> [<?= substr($do['insertTime'], 2, -3) ?>]</small></td>
                                    </tr>
                                </table>
                            </div>
                        <?php }
                        ?>
                    <?php }

                    ?>
                <?php
                } ?>
            </div>
        </div>
    </small>
</main>
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>

<script>
    $("#myInput").on("keyup", function() {
        var input = this.value;
        var filter = input.toLowerCase();

        var nodes = document.getElementsByClassName('target');
        for (i = 0; i < nodes.length; i++) {
            if (nodes[i].innerText.toLowerCase().includes(filter)) {
                nodes[i].style.display = "block";
            } else {
                nodes[i].style.display = "none";
            }
        }
    });
</script>