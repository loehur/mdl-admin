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
        <div class="row mx-1 mb-1">
            <?php foreach ($data['pengajuan'] as $du) {
                $id = $du['id_pengajuan'] ?>
                <div class="col text-nowrap border me-1 bg-white" style="max-width: 350px;">
                    <div class="row border-bottom bg-light">
                        <div class="col">
                            <?php $nama = $this->model("M_DB_1")->get_cols_where("user", "nama", "user = '" . $du['user'] . "'", 0)['nama'];
                            $nama = str_replace(['a', 'i', 'u', 'e', 'o', 'A', 'I', 'U', 'E', 'O'], '*', $nama);
                            ?>
                            <b><?= $nama ?></b>
                        </div>
                        <div class="col text-end">
                            #<?= $du['id_pengajuan'] ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-end">
                            <small>Jumlah Pinjaman</small><br><b class="text-success">Rp<?= number_format($du['jumlah']) ?></b>
                        </div>
                    </div>
                    <div class="row border-bottom">
                        <div class="col">
                            <small>Keperluan</small><br><span class="text-primary"><?= strtoupper($du['tujuan']) ?></span>
                        </div>
                    </div>
                    <div class="row border-bottom">
                        <div class="col">
                            <b>1 Pinjaman</b><br>
                            <div class="ps-2">
                                <small>
                                    1 Dalam Penawaran<br>
                                    0 Aktif<br>
                                    0 Lunas Dipercepat<br>
                                    0 Lunas Tepat Waktu<br>
                                    0 Lunas Terlambat<br>
                                    0 Reschedule
                            </div>
                            </small>
                        </div>
                    </div>
                    <div class="row border-bottom">
                        <div class="col">
                            <b>0 Pembayaran</b><br>
                            <div class="ps-2">
                                <small>
                                    0 Dipercepat<br>
                                    0 Tepat Waktu<br>
                                    0 Terlambat<br>
                                    0 Parsial Dipercepat<br>
                                    0 Parsial Tepat Waktu<br>
                                    0 Parsial Terlambat<br>
                            </div>
                            </small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col py-1 pe-1">

                            <?php
                            $penawaran = 0;
                            $penawaran = $this->model("M_DB_1")->count_where("penawaran", "id_pengajuan = '" . $du['id_pengajuan'] . "'") ?>

                            <?= $penawaran ?> Penawaran
                            <?php
                            if ($du['user'] <> $this->userData['user']) { ?>
                                <button class="float-end btn btn-sm btn-success tawarkan" data-id="<?= $du['id_pengajuan'] ?>" data-bs-toggle="modal" data-bs-target="#tawar">Tawarkan</button>
                            <?php }
                            ?>
                        </div>
                    </div>
                    <?php
                    $cek = $this->model("M_DB_1")->count_where("penawaran", "id_pengajuan = " . $id . " AND user = '" . $this->userData['user'] . "'");
                    if ($cek > 0) { ?>
                        <div class="row border-top">
                            <div class="col py-1 pe-1">
                                <?php
                                $bungaAnda = $this->model("M_DB_1")->get_cols_where("penawaran", "bunga", "user = '" . $this->userData['user'] . "'", 0)['bunga'] ?>
                                Penawaran Anda
                                <span class="float-end">Bunga <?= $bungaAnda ?>%</span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <form action="<?= $this->BASE_URL . $data['_c'] ?>/tawar" method="POST">
        <div class="modal" id="tawar">
            <div class="modal-dialog">
                <div class="modal-content bg-success-soft">
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col">
                                <label class="form-label">Bunga (%)</label>
                                <input type="number" min="1" max="100" name="bunga" class="form-control" required />
                                <input type="hidden" name="id_pengajuan" class="form-control" required />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <button type="submit" data-bs-dismiss="modal" class="btn btn-success">Tawarkan</button>
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

    $("button.tawarkan").click(function() {
        var id = $(this).attr("data-id");
        $("input[name=id_pengajuan]").val(id);
    })

    $("a.verifyData").click(function() {
        var user = $(this).attr("data-id");
        if (confirm("Yakin Memverifikasi " + user + "?")) {
            var id = $(this).attr("data-id");
            $.ajax({
                url: "<?= $this->BASE_URL . $data['_c']  ?>/verify",
                data: {
                    user: user
                },
                type: "POST",
                success: function(res) {
                    if (res == 0) {
                        content();
                    } else {
                        alert(res);
                    }
                },
            });
        } else {
            return false;
        }
    })
</script>