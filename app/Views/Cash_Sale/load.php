<div class="mt-2 pt-2">
    <div class="row mb-2">
        <div class="col-auto rounded mt-auto">
            <div class="border-bottom rounded">
                <span class="btn btn-sm text-success tarik">Penarikan <i class="fa-solid fa-wallet"></i> <b><?= number_format($data['saldo']) ?></b></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php foreach ($data['debit_list'] as $dl) { ?>
                <div class="border-bottom">
                    <div class="row">
                        <div class="col-auto">
                            <small>
                                #<?= $dl['id'] ?><br>
                                <?= substr($dl['insertTime'], 5, 11) ?>
                            </small>
                        </div>
                        <div class="col-auto">
                            <small class="text-primary"><?= $dl['keterangan'] ?></small>
                        </div>
                        <div class="col text-end">-<?= number_format($dl['jumlah']) ?></div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>
<script>
    $(".tarik").click(function() {
        var jumlah = prompt("Jumlah");
        if (jumlah.length == 0) {
            alert("Jumlah tidak boleh kosong");
            return;
        }

        var ket = prompt("Keterangan");
        if (ket.length == 0) {
            alert("Keterangan tidak boleh kosong");
            return;
        }

        var id = '<?= $data['id'] ?>';
        $.post("<?= $this->BASE_URL . $data['_c'] ?>/tarik", {
                id: id,
                jumlah: jumlah,
                ket: ket
            },
            function(res) {
                if (res == 0) {
                    load_kas(id)
                } else {
                    alert(res);
                }
            })
    });
</script>