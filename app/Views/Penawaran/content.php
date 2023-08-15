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
                            <div class="row pt-2">
                                <div class="col-auto line100">
                                    <?php if (strlen($dp['resi_path']) == 0) {
                                        echo "...";
                                    } else { ?>
                                        <img style="max-width: 280px;" src="<?= $this->BASE_URL . $dp['resi_path'] ?>" class="img-fluid" alt="...">
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
                                    <div class="row border-bottom mb-2 pb-1">
                                        <div class="col">
                                            <small>Bunga</small><br><span class="text-primary"><?= $dw['bunga'] ?>% / Rp<?= number_format($dw['bunga'] * $dp['jumlah'] / 100) ?></span>
                                        </div>
                                    </div>
                                    <div class="row border-bottom mb-2 pb-1">
                                        <div class="col">
                                            <small>Peminjam telah menyetujui penawaran Anda, silahkan transfer ke Rekening berikut:</small><br>
                                            <?php $rek = $this->model("M_DB_1")->get_where_row("user", "user = '" . $dp['user'] . "'");
                                            $bank = $this->model("M_DB_1")->get_cols_where("_bank", "name", "code = '" . $rek['bank'] . "'", 0)['name'];
                                            ?>
                                            <b><span><?= $bank ?> - <?= $rek['rekening'] ?></span></b><br>
                                            Pastikan Nama Rekening sesuai dengan Nama Peminjam
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal_ktp"><small>Upload Resi Pencairan</small></a>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php }
            }
        } ?>
    </div>

    <form action="<?= $this->BASE_URL . $data['_c'] ?>/resi" class="upload" method="POST">
        <div class="modal" id="modal_ktp">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Bukti Pencairan</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="formFileSm" class="form-label mb-0 pb-0">Resi Bukti Pencairan (<span class="text-danger">Max. 10mb</span>)</label>
                                    <input class="form-control form-control-sm" type="file" id="file" name="ktp" required />
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <button type="submit" data-bs-dismiss="modal" class="btn btn-primary" disabled>Upload</button>
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
        var file_kk = $('#file_kk')[0].files[0];
        formData.append('file', file_kk);

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
</script>