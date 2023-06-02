<?php foreach ($data['detail'] as $key => $d) { ?>
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
<div class="mb-3">
    <label class="form-label" required>Jumlah</label>
    <input type="number" min="1" value="1" name="jumlah" class="form-control" required>
</div>
<div class="mb-3">
    <label class="form-label" required>Catatan Utama</label>
    <input type="text" name="note" class="form-control">
</div>
<?php foreach ($data['spkNote'] as $key => $d) { ?>
    <div class="mb-3">
        <label class="form-label" required>Catatan <b><?= $this->model('Arr')->get($this->dDvs, "id_divisi", "divisi", $key) ?></b></label>
        <input type="text" name="d-<?= $key ?>" class="form-control">
    </div>
<?php  } ?>

<script>
    $(document).ready(function() {
        $('select.tize').selectize();
    });
</script>