<?php foreach ($data['order'] as $key => $d) { ?>
    <div class="col-md-6">
        <div class="form-check">
            <input class="form-check-input" name="cek[]" type="checkbox" value="<?= $key ?>">
            <label class="form-check-label">
                <?php
                foreach ($data['pelanggan'] as $p) {
                    if ($d['id_pelanggan'] == $p['id_pelanggan']) {
                        echo strtoupper($p['nama']) . " (" . $d['jumlah'] . "x)";
                    }
                }
                ?>
            </label>
        </div>
    </div>
<?php } ?>