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
        <?php foreach ($data['aktif'] as $dp) {
            $rek = "";
            $bank = "";
            $dw = $this->model("M_DB_1")->get_where_row("penawaran", "id_penawaran = " . $dp['offer_id']);
        ?>
            <div class="row py-1 ps-3">
                <div class="col-auto bg-white border">
                    <div class="row pt-2 pb-1">
                        <div class="col-auto line100 pb-1">
                            <div class="row bg-light">
                                <div class="col text-end border-bottom pb-1">
                                    Pinjaman#<?= $dp['id_pengajuan'] ?>
                                </div>
                            </div>
                            <div class="row pb-1 text-end">
                                <div class="col">
                                    <?php $pinjaman = $dp['jumlah']; ?>
                                    <small>Jumlah Pinjaman</small><br>Rp<?= number_format($pinjaman) ?>
                                </div>
                            </div>
                            <div class="row pb-1 text-end">
                                <div class="col">
                                    <?php $bunga = $dw['bunga'] * $dp['jumlah'] / 100 ?>
                                    <small>Bunga</small><br><span>Rp<?= number_format($bunga) ?></span>
                                </div>
                            </div>
                            <div class="row pb-2 mb-2 border-bottom text-end">
                                <div class="col">
                                    <small>Total Pinjaman</small><br><b><span>Rp<?= number_format($pinjaman + $bunga) ?></span></b>
                                </div>
                            </div>
                            <div class="row pb-1">
                                <div class="col">
                                    <small>Keperluan</small><br><span class="text-primary"><?= strtoupper($dp['tujuan']) ?></span>
                                </div>
                            </div>
                            <div class="row mb-1 pb-1">
                                <div class="col">
                                    <small>Tenor</small><br><span class="text-primary"><?= $dp['tenor'] ?> Bulan</span>
                                </div>
                            </div>
                            <div class="row mb-1 pb-1">
                                <div class="col">
                                    <?php $mulai = substr($dp['activeDate'], 0, 10); ?>
                                    <small>Dimulai pada</small><br><span class="text-primary"><?= date('d-m-Y', strtotime($mulai)) ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <?php $jatem = date('Y-m-d', strtotime('+ ' . $dp["tenor"] . ' months', strtotime($mulai))); ?>
                                    <small>Jatuh tempo pada</small><br><b><span class="text-danger"><?= date('d-m-Y', strtotime($jatem)) ?></span></b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <form action="<?= $this->BASE_URL . $data['_c'] ?>/struk" class="upload" method="POST">
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

    $("a.upload").click(function() {
        var id = $(this).attr("data-id");
        $("input[name=id_pengajuan]").val(id);
    })
</script>