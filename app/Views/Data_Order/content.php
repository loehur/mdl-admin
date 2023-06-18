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
    <div class="row me-2 ms-1 mt-1 pt-2">
        <div class="col-auto"><input type="text" placeholder="Search..." id="myInput" class="form-control form-control-sm"></div>
    </div>
    <!-- Main page content-->
    <small>
        <div class="row me-2 mx-2 mt-2" id="results">
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
                        <div class="results col-md-6 pb-2 px-1">
                            <p class="d-none"><?= strtoupper($pelanggan . substr($ref, -4) . $cs) ?></p>
                            <table class="w-100 bg-white <?= ($dateTime == $today) ? 'border-bottom border-success' : 'border-bottom border-warning' ?>">
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
    </small>
</main>
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>

<script>
    $(document).ready(function() {
        $("#myInput").on("keyup change", function() {
            var filter = $(this).val().toUpperCase(),
                count = 0;

            $('#results div').each(function() {
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                    count++;
                }

            });
        });
    });
</script>