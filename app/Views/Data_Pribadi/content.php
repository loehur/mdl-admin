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
                switch ($this->userData['v_profil']) {
                    case 0: ?>
                        <span class="text-danger">Belum Terverifikasi</span><br>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_ktp"><small>Upload KTP / KK</small></a>
                    <?php break;
                    case 3: ?>
                        <span class="text-danger">DATA DI TOLAK</span><br>
                        <span><small><?= strtoupper($this->userData['v_note_profil']) ?></small></span>
                        <br>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal_ktp"><small>Upload KTP / KK</small></a>
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
            <div class="col py-1 line100 text-success">
                <img style="max-width: 280px;" src="<?= $this->BASE_URL . $this->userData['ktp_path'] ?>" class="img-fluid" alt="...">
            </div>
            <div class="col py-1 line100 text-success">
                <img style="max-width: 280px;" src="<?= $this->BASE_URL . $this->userData['kk_path'] ?>" class="img-fluid" alt="...">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 py-1 line100"><small><u>NIK:</u></small><br><?= $this->userData['nik'] ?></div>
            <div class="col-md-6 py-1 line100"><small><u>Nama</u></small><br><?= $this->userData['nama'] ?></div>
            <div class="col-md-6 py-1 line100"><small><u>No. Handphone</u></small><br><?= $this->userData['hp'] ?></div>
            <div class="col-md-6 py-1 line100"><small><u>Kontak Darurat</u></small><br><?= $this->userData['darurat'] ?></div>
            <div class="col-md-6 py-1 line100"><small><u>Alamat</u></small><br><?= strtoupper($this->userData['alamat']) ?></div>
            <div class="col-md-6 py-1 line100">
                <small><u>Provinsi</u></small><br>
                <?= strtoupper($this->model("M_DB_1")->get_cols_where("_provinsi", "provinsi", "id_provinsi = '" . $this->userData['provinsi'] . "'", 0)['provinsi']) ?>
            </div>
            <div class="col-md-6 py-1 line100">
                <small><u>Kota/Kabupaten</u></small><br>
                <?= strtoupper($this->model("M_DB_1")->get_cols_where("_kota", "kota", "id_kota = '" . $this->userData['kota'] . "'", 0)['kota']) ?>
            </div>
            <div class="col-md-6 py-1 line100">
                <small><u>Kecamatan</u></small><br>
                <?= strtoupper($this->model("M_DB_1")->get_cols_where("_kecamatan", "kecamatan", "id_kecamatan = '" . $this->userData['kecamatan'] . "'", 0)['kecamatan']) ?>
            </div>
            <div class="col-md-6 py-1 line100">
                <small><u>Kelurahan</u></small><br>
                <?= strtoupper($this->model("M_DB_1")->get_cols_where("_kelurahan", "kelurahan", "id_kelurahan = '" . $this->userData['kelurahan'] . "'", 0)['kelurahan']) ?>
            </div>

        </div>
    </div>

    <form action="<?= $this->BASE_URL . $data['_c'] ?>/ktp" class="upload" method="POST">
        <div class="modal" id="modal_ktp">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Data KTP</h5>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row mb-2">
                                <div class="col">
                                    <label for="formFileSm" class="form-label mb-0 pb-0">KTP (<span class="text-danger">Max. 10mb</span>)</label>
                                    <input class="form-control form-control-sm" type="file" id="file" name="ktp" required />
                                </div>
                                <div class="col">
                                    <label for="formFileSm" class="form-label mb-0 pb-0">KK (<span class="text-danger">Max. 10mb</span>)</label>
                                    <input class="form-control form-control-sm" type="file" id="file_kk" name="kk" required />
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