<select class="border tize" id="selKot" name="kota" required>
    <option></option>
    <?php
    foreach ($data['kot'] as $dk) { ?>
        <option value='<?= $dk['id_kota'] ?>'><?= $dk['kota'] ?></option>
    <?php } ?>
</select>

<script>
    $(document).ready(function() {
        $('select.tize').selectize();
    });

    $('select#selKot').on('change', function() {
        var id = this.value;
        $("div#opKec").html('')
        $("div#opKel").html('')
        if (id.length > 0) {
            $("div#opKec").load('<?= $this->BASE_URL . $data['_c'] ?>/load_kecamatan/' + id);
        }
    });
</script>