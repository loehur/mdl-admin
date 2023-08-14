<header class="py-1 mb-2 bg-gradient-primary-to-secondary">
    <div class="text-center">
        <h1 class="text-white"><?= $data['_c'] ?></h1>
    </div>
</header>

<!-- Main page content-->
<div class="row mx-1">
    <div class="col py-1 px-1 bg-white">
        <div class="row mx-1 mb-1">
            <div class="col">
                <?php if ($this->userData['v_profil'] <> 2 || $this->userData['v_bank'] <> 2) { ?>
                    <span class="text-danger">Belum dapat mengajukan pinjaman, sampai KTP dan Rekening Bank terverifikasi</span>
                <?php } else { ?>
                    <?php if (!is_array($data['run'])) { ?>
                        <span><a href="#" class="text-primary reject_" data-bs-target="#modal_reject" data-bs-toggle="modal">Ajukan Pinjaman</a></span>
                    <?php } else { ?>
                        <?php $dr = $data['run'] ?>
                        <b>Dalam Pengajuan</b>
                        <div class="row mb-1">
                            <div class="col-auto">
                                <small>Tujuan</small><br>
                                <?= strtoupper($dr['tujuan']) ?>
                            </div>
                            <div class="col-auto text-end">
                                <small>Jumlah</small><br>
                                Rp<?= number_format($dr['jumlah']) ?>
                            </div>
                            <div class="col-auto text-end">
                                <small>Tenor</small><br>
                                <?= $dr['tenor'] ?> Bulan
                            </div>
                            <div class="col">
                                <small>Status</small><br>
                                <?php
                                $st = "";
                                if (is_array($dr)) {
                                    switch ($dr['st_pinjaman']) {
                                        case 0:
                                            $st = "Admin Checking";
                                            break;
                                        case 1:
                                            $st = "Listing";
                                            break;
                                    }
                                }
                                ?>
                                <?= $st ?>
                            </div>
                        </div>
                        <?php if ($dr['offer_id'] == 0) { ?>
                            <div class="row border-top pt-2">
                                <div class="col text-end">
                                    <b>Penawaran Pendanaan</b>
                                    <?php
                                    $no = 0;
                                    foreach ($data['penawaran'] as $dp) {
                                        $no += 1;
                                        $rate = $dp['bunga'] * $dr['jumlah'] / 100;
                                    ?>
                                        <div class="row">
                                            <div class="col text-end"><?= $no ?>.</div>
                                            <div class="col-auto text-end">Bunga <?= $dp['bunga'] ?>%</div>
                                            <div class="col-auto text-end">Rp <?= number_format($rate) ?></div>
                                            <div class="col-auto text-end"><a href="#" class="terima" data-id="<?= $dp['id_pengajuan'] ?>" data-id_="<?= $dp['id_penawaran'] ?>" data-bunga="<?= $dp['bunga'] ?>">Terima</a></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="row border-top">
                                <div class="col pt-2">
                                    <b class="text-success">Dalam Proses Pencairan <i class="fa-solid fa-circle-check"></i></b><br>
                                    <?php $rate = $this->model("M_DB_1")->get_where_row("penawaran", "id_pengajuan = '" . $dr['id_pengajuan'] . "'") ?>
                                    Pendana akan melakukan Transfer dalam 1x24 Jam, pinjaman akan aktif dengan Bunga <b class="text-success"><?= $rate['bunga'] ?>%</b>
                                </div>
                            </div>
                    <?php }
                    } ?>
                <?php } ?>
            </div>
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

    <form action="<?= $this->BASE_URL . $data['_c'] ?>/add" method="POST">
        <div class="modal" id="modal_reject">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col pe-0">
                                <label class="form-label">Jumlah Pinjaman</label>
                                <input type="number" min="100000" max="10000000" name="jumlah" class="form-control text-end" required />
                            </div>
                            <div class="col">
                                <label class="form-label">Tenor (1-4 Bulan)</label>
                                <input type="number" name="tenor" min="1" max="4" class="form-control text-end" required />
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <label class="form-label">Tujuan Pinjaman</label>
                                <input type="text" name="tujuan" class="form-control" required />
                            </div>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault" required>
                            <label class="form-check-label" for="flexCheckDefault">
                                Dengan ini, saya menyatakan bersedia di hubungi oleh TIM Bantu Pinjam melalui Whatsapp Video Call untuk verifikasi Data, Lokasi dan Lainnya.
                            </label>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <button type="submit" data-bs-dismiss="modal" class="btn btn-primary float-end">Ajukan</button>
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

    $("a.terima").click(function() {
        var bunga = $(this).attr("data-bunga");
        if (confirm("Yakin menerima Pendanaan dengan bunga " + bunga + "% ?")) {
            var id = $(this).attr("data-id");
            var id_ = $(this).attr("data-id_");
            $.ajax({
                url: "<?= $this->BASE_URL . $data['_c']  ?>/terima",
                data: {
                    id: id,
                    id_: id_
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