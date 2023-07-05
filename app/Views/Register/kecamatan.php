<select class="border tize" id="selKec" name="kecamatan" required>
    <option></option>
    <?php
    foreach ($data['data'] as $dk) { ?>
        <option value='<?= $dk['id_kecamatan'] ?>'><?= $dk['kecamatan'] ?></option>
    <?php } ?>
</select>

<script>
    $(document).ready(function() {
        $('select.tize').selectize();
    });

    $('select#selKec').on('change', function() {
        var id = this.value;
        $("div#opKel").html('');
        if (id.length > 0) {
            $("div#opKel").load('<?= $this->BASE_URL . $data['_c'] ?>/load_kelurahan/' + id);
        }
    });
</script>