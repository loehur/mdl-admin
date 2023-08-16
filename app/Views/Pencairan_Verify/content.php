<header class="py-1 mb-2 bg-gradient-primary-to-secondary">
    <div class="container-xl">
        <div class="text-center">
            <h1 class="text-white"><?= $data['_c'] ?></h1>
        </div>
    </div>
</header>

<!-- Main page content-->
<div class="row mx-1">
    <div class="col px-1">
        <?php foreach ($data['pinjaman'] as $dp) {
            foreach ($data['penawaran'] as $dw) {
                if ($dw['id_penawaran'] == $dp['offer_id']) {
                    $rek = "";
                    $bank = ""; ?>
                    <div class="row py-1 ps-3">
                        <div class="col-auto bg-white border">
                            <div class="row pt-2 pb-1">
                                <div class="col-auto line100 pe-0">
                                    <?php if (strlen($dp['struk_path']) == 0) {
                                        echo "...";
                                    } else { ?>
                                        <img style="max-width: 280px;" src="<?= $this->BASE_URL . $dp['struk_path'] ?>" class="img-fluid" alt="...">
                                    <?php } ?>
                                </div>
                                <div class="col-auto line100 pb-1">
                                    <div class="row">
                                        <div class="col text-nowrap pb-2">
                                            <?php $nama = $this->model("M_DB_1")->get_cols_where("user", "nama", "user = '" . $dp['user'] . "'", 0)['nama']; ?>
                                            <b><?= $nama ?></b>
                                        </div>
                                        <div class="col text-end">
                                            #<?= $dp['id_pengajuan'] ?>
                                        </div>
                                    </div>
                                    <div class="row pb-2">
                                        <div class="col">
                                            <small>Jumlah Pinjaman</small><br><b class="text-success">Rp<?= number_format($dp['jumlah']) ?></b>
                                        </div>
                                    </div>
                                    <div class="row mb-1 pb-1">
                                        <div class="col">
                                            <small>Keperluan</small><br><span class="text-primary"><?= strtoupper($dp['tujuan']) ?></span>
                                        </div>
                                    </div>
                                    <div class="row mb-1 pb-1">
                                        <div class="col">
                                            <small>Tenor</small><br><span class="text-primary"><?= $dp['tenor'] ?> Bulan</span>
                                        </div>
                                    </div>
                                    <div class="row border-bottom mb-2 pb-1">
                                        <div class="col">
                                            <small>Bunga</small><br><span class="text-primary"><?= $dw['bunga'] ?>% / Rp<?= number_format($dw['bunga'] * $dp['jumlah'] / 100) ?></span>
                                        </div>
                                    </div>
                                    <?php if (strlen($dp['struk_path']) == 0) { ?>
                                        <div class="row border-bottom mb-2 pb-1">
                                            <div class="col">
                                                <small>Peminjam telah menyetujui penawaran, menunggu pendana memberikan bukti transfer ke:</small><br>
                                                <?php $rek = $this->model("M_DB_1")->get_where_row("user", "user = '" . $dp['user'] . "'");
                                                $bank = $this->model("M_DB_1")->get_cols_where("_bank", "name", "code = '" . $rek['bank'] . "'", 0)['name'];
                                                ?>
                                                <b><span><?= $bank ?> - <?= $rek['rekening'] ?></span></b>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row pb-1">
                                            <div class="col text-success">
                                                <a href="#" class="btn btn-sm btn-outline-primary upload" data-id="<?= $dp['id_pengajuan'] ?>" data-bs-toggle="modal" data-bs-target="#modal_ktp"><small>Ubah Bukti Transfer</small></a>
                                            </div>
                                        </div>
                                        <div class="row border-bottom mb-2 pb-1">
                                            <form action="<?= $this->BASE_URL . $data['_c'] ?>/opsi" class="ajax" method="POST">
                                                <div class="col text-success line100">
                                                    <select class="form-select form-select-sm" name="opsi">
                                                        <option selected>Opsi</option>
                                                        <?php if (strlen($dp['struk_path']) <> 0) { ?>
                                                            <option value="2">Aktifkan</option>
                                                        <?php } ?>
                                                        <option value="6">Batalkan</option>
                                                    </select>
                                                    <input type="hidden" value="<?= $dp['id_pengajuan']  ?>" name="id_pengajuan" />
                                                </div>
                                                <div class="col-auto text-success line100 text-end">
                                                    <button type="submit" data-bs-dismiss="modal" class="btn btn-sm btn-success">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php }
            }
        } ?>
    </div>

    <form action="<?= $this->BASE_URL . $data['_c'] ?>/struk" class="upload" method="POST">
        <div class="modal" id="modal_ktp">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Bukti Pencairan</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="formFileSm" class="form-label mb-0 pb-0">Struk Bukti Pencairan (<span class="text-danger">Max. 10mb</span>)</label>
                                    <input class="form-control form-control-sm" type="file" id="file" name="struk_cair" required />
                                    <input type="hidden" name="id_pengajuan" required />
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <button type="submit" data-bs-dismiss="modal" class="btn btn-primary">Upload</button>
                                    <span id="persen"><b>0</b></span><b> %</b>
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

<script>
    $("form.upload").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        var file = $('#file')[0].files[0];
        formData.append('file', file);

        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
                        $('#persen').html('<b>' + Math.round(percentComplete) + '</b>');
                    }
                }, false);
                return xhr;
            },
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: "application/octet-stream",
            enctype: 'multipart/form-data',

            contentType: false,
            processData: false,

            success: function(res) {
                if (res == 0) {
                    content();
                } else {
                    alert(res);
                }
            },
        });
    });

    $("form.ajax").on("submit", function(e) {
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


    $("a.upload").click(function() {
        var id = $(this).attr("data-id");
        $("input[name=id_pengajuan]").val(id);
    })
</script>