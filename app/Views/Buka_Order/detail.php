<?php foreach ($data as $key => $d) { ?>
    <div class="mb-3">
        <label class="form-label"><?= $d['name'] ?></label>
        <select class="form-select tize" name="f-<?= $key ?>" required>
            <option></option>
            <?php foreach ($d['item'] as $i) { ?>
                <option value="<?= $i['id_detail_item'] ?>"><?= strtoupper($i['detail_item']) ?></option>
            <?php } ?>
        </select>
    </div>
<?php  } ?>

<script>
    $(document).ready(function() {
        $('select.tize').selectize();
    });
</script>