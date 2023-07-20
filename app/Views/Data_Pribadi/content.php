<header class="py-4 mb-2 bg-gradient-primary-to-secondary">
    <div class="container-xl">
        <div class="text-center">
            <h1 class="text-white">Profil - <?= $data['_c'] ?></h1>
        </div>
    </div>
</header>

<!-- Main page content-->
<div class="row ms-1">
    <div class="col bg-white">
        <div class="row">
            <div class="col py-1 line100"><small><u>Status</u></small><br>
                <?php
                switch ($this->userData['v_profil']) {
                    case 0: ?>
                        <span class="text-danger">Belum Terverifikasi</span><br>
                        <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#modal_ktp"><small>Lengkapi Data</small></a>
                    <?php break;
                    case 1: ?>
                        <span class="text-primary">Dalam pengecekan 1x24jam</span><br>
                <?php break;
                } ?>
            </div>
        </div>
        <div class="col py-1 line100 text-success"><small><u>KTP:</u></small><br>
            <img style="max-width: 270px;" src="<?= $this->BASE_URL . $this->userData['ktp_path'] ?>" class="img-fluid" alt="...">
        </div>

        <div class="row">
            <div class="col-md-6 py-1 line100 text-success"><small><u>NIK:</u></small><br><b><?= $this->userData['nik'] ?></b></div>

            <div class="col-md-6 py-1 line100"><small><u>Nama</u></small><br><?= $this->userData['nama'] ?></div>

            <div class="col-md-6 py-1 line100"><small><u>No. Handphone</u></small><br><?= $this->userData['hp'] ?></div>

            <div class="col-md-6 py-1 line100"><small><u>Penghasilan/Bulan</u></small><br>Rp<?= number_format($this->userData['penghasilan']) ?></div>

            <div class="col-md-6 py-1 line100"><small><u>Alamat</u></small><br><?= strtoupper($this->userData['alamat']) ?></div>

            <div class="col-md-6 py-1 line100"><small><u>Provinsi</u></small><br><?= strtoupper($this->userData['provinsi']) ?></div>

            <div class="col-md-6 py-1 line100"><small><u>Kota/Kabupaten</u></small><br><?= strtoupper($this->userData['kota']) ?></div>

            <div class="col-md-6 py-1 line100"><small><u>Kecamatan</u></small><br><?= strtoupper($this->userData['kecamatan']) ?></div>

            <div class="col-md-6 py-1 line100"><small><u>Kelurahan</u></small><br><?= strtoupper($this->userData['kelurahan']) ?></div>

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
                                    <label class="form-label">NIK</label>
                                    <input type="text" class="form-control" name="nik">
                                </div>
                                <div class="col">
                                    <label for="formFileSm" class="form-label">KTP (<span class="text-danger">Max. 10mb</span>)</label>
                                    <input class="form-control form-control-sm" type="file" id="file" name="ktp" required /> [ <span id="persen"><b>0</b></span><b> %</b> ] Upload Progress
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
    </script>