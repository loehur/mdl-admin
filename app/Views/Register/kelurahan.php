<select class="border tize" id="selKel" name="kelurahan" required>
    <option></option>
    <?php
    foreach ($data['data'] as $dk) { ?>
        <option value='<?= $dk['id_kelurahan'] ?>'><?= $dk['kelurahan'] ?></option>
    <?php } ?>
</select>

<script>
    $(document).ready(function() {
        $('select.tize').selectize();
    });
</script>