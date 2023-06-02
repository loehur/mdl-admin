<?php foreach ($data['order'] as $key => $d) { ?>
    <div class="col-md-6">
        <?php
        foreach ($data['pelanggan'] as $p) {
            if ($d['id_pelanggan'] == $p['id_pelanggan']) {
                echo '<i class="text-success fa-solid fa-circle-check"></i> ' . $p['nama'] . " (" . $d['jumlah'] . "x)";
            }
        }
        ?>
    </div>
    </div>
<?php } ?>