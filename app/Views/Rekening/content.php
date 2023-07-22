<header class="py-1 mb-2 bg-gradient-primary-to-secondary">
    <div class="container-xl">
        <div class="text-center">
            <h1 class="text-white"><?= $data['_c'] ?></h1>
        </div>
    </div>
</header>

<!-- Main page content-->
<div class="row mx-1">
    <div class="col bg-white py-1 px-1">
        <div class="row">
            <div class="col line100 border-bottom pb-1"><small><u>Status</u></small><br>
                <?php
                switch ($this->userData['v_bank']) {
                    case 0: ?>
                        <span class="text-danger">Belum Terverifikasi</span><br>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_ktp"><small>Update Rekening</small></a>
                    <?php break;
                    case 3: ?>
                        <span class="text-danger">Rekening Bank di Tolak</span><br>
                        <span><small><?= strtoupper($this->userData['v_note_bank']) ?></small></span>
                        <br>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_ktp"><small>Update Rekening</small></a>
                    <?php break;
                    case 2: ?>
                        <span class="text-success"><b>TERVERIFIKASI</b></span>
                    <?php break;
                    case 1: ?>
                        <span class="text-primary">DALAM PENGECEKAN 1X24 JAM</span><br>
                <?php break;
                } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 py-1 line100">
                <small><u>Bank</u></small><br>
                <?php if (strlen($this->userData['bank']) > 0) {
                    echo strtoupper($this->model("M_DB_1")->get_cols_where("_bank", "name", "code = '" . $this->userData['bank'] . "'", 0)['name']);
                } else {
                    echo "";
                } ?>

            </div>
            <div class="col-md-6 py-1 line100">
                <small><u>Rekening</u></small><br>
                <?= $this->userData['rekening'] ?>
            </div>

        </div>
    </div>

    <form action="<?= $this->BASE_URL . $data['_c'] ?>/update" class="upload" method="POST">
        <div class="modal" id="modal_ktp">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Rekening</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row mb-2">
                                <div class="col">
                                    <label class="form-label mb-0 pb-0">Bank</label>
                                    <select class="border tize" name="bank" required>
                                        <option></option>
                                        <div>
                                            <?php foreach ($data['bank'] as $pr) { ?>
                                                <option value="<?= $pr['code'] ?>"><?= $pr['name'] ?></option>
                                            <?php } ?>
                                        </div>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <label class="form-label">No. Rekening</label>
                                    <input type="text" class="form-control" name="rek">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <button type="submit" data-bs-dismiss="modal" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/selectize.min.js"></script>
<script>
    $(document).ready(function() {
        $('select.tize').selectize();
    });

    $("form").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: $(this).attr("method"),
            success: function(res) {
                if (res == 0) {
                    content();
                } else {
                    alert(res);
                }
            }
        });
    });
</script>