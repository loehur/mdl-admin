<header class="py-1 mb-2 bg-gradient-primary-to-secondary">
    <div class="container-xl">
        <div class="text-center">
            <h1 class="text-white"><?= $data['_c'] ?></h1>
        </div>
    </div>
</header>

<!-- Main page content-->
<div class="row mx-1">
    <div class="col py-1 px-1">
        <div class="row">
            <?php foreach ($data['pinjaman'] as $du) { ?>
                <div class="col-auto bg-white border ms-2">
                    <div class="row">
                        <div class="col text-nowrap line100">
                            <?php $nama = $this->model("M_DB_1")->get_cols_where("user", "nama", "user = '" . $du['user'] . "'", 0)['nama']; ?>
                            Peminjam:<br>
                            <?= strtoupper($nama) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-nowrap line100">
                            Jumlah Pinjaman:<br>
                            Rp<?= number_format($du['jumlah']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col line100">
                            Tujuan:<br>
                            <?= strtoupper($du['tujuan']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-nowrap">
                            <span><a href="#" class="text-danger user" data-id="<?= $du['user'] ?>" data-bs-target="#modal_user" data-bs-toggle="modal">Opsi</a></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <form action="<?= $this->BASE_URL . $data['_c'] ?>/cek" method="POST">
        <div class="modal" id="modal_cek">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-0" id="cek"></div>
                </div>
            </div>
        </div>
    </form>

    <form action="<?= $this->BASE_URL . $data['_c'] ?>/submit" method="POST">
        <div class="modal" id="modal_user">
            <div class="modal-dialog">
                <div class="modal-content bg-primary-soft">
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col">
                                <label class="form-label">Opsi</label>
                                <select class="form-select" name="opsi">
                                    <option selected>Pilih salah satu</option>
                                    <option value="1">Izinkan Listing</option>
                                    <option value="6">Tolak Pengajuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label class="form-label">Catatan (Opsional)</label>
                                <input name="user" value="" type="hidden">
                                <input type="text" name="note" class="form-control" />
                                <input type="hidden" name="note" class="form-control" />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <button type="submit" data-bs-dismiss="modal" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>

<script>
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

    $("a.user").click(function() {
        var user = $(this).attr("data-id");
        $("input[name=user]").val(user);
    })
</script>