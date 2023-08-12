<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>P2P Lending | Register</title>
    <link href="<?= $this->ASSETS_URL ?>css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>css/selectize.bootstrap3.min.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="<?= $this->ASSETS_URL ?>assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/fontawesome-free-6.4.0-web/css/all.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
    <!-- FONT -->

    <?php $fontStyle = "'Titillium Web', sans-serif;" ?>

    <style>
        html .table {
            font-family: <?= $fontStyle ?>;
        }

        html .content {
            font-family: <?= $fontStyle ?>;
        }

        html body {
            font-family: <?= $fontStyle ?>;
        }

        @media print {
            p div {
                font-family: <?= $fontStyle ?>;
                font-size: 14px;
            }
        }

        .selectize-control {
            padding: 0;
        }

        .selectize-input {
            border: none;
        }

        .selectize-input::after {
            visibility: hidden;
        }

        html {
            height: 100%;
            background-color: #F4F4F4;
        }

        body {
            min-height: 100%;
        }
    </style>

</head>
<?php
$failed = "";

if (is_array($data)) {
    if (isset($data['failed'])) {
        $failed = $data['failed'];
    }
}
?>

<body class="bg-light">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container-xl px-1 pt-2">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <!-- Basic login form-->
                            <div class="card shadow-lg border-0 rounded-lg mt-1">
                                <div class="card-body login-card-body">
                                    <p class="login-box-msg text-center">Bantu Pinjam Register</p>
                                    <div id="info" class="text-danger pb-2 float-end"><?= $failed ?></div>
                                    <form action="<?= $this->BASE_URL . $data['_c'] ?>/add" method="post">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                                            <input type="email" name="user" class="form-control" placeholder="Email" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                            <input type="password" name="pass" minlength="5" class="form-control" placeholder="Buat Password" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                            <input type="password" name="pass_" class="form-control" placeholder="Ulangi Password" required>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col">
                                                Nama Lengkap
                                                <input type="text" name="nama" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col pe-0">
                                                Nomor Induk KTP (NIK)
                                                <input type="text" name="nik" class="form-control" required>
                                            </div>
                                            <div class="col">
                                                Kontak Darurat
                                                <input type="text" name="darurat" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col pe-0">
                                                <label class="form-label mb-0 pb-0">Provinsi</label>
                                                <select class="border tize" id="selProv" name="prov" required>
                                                    <option></option>
                                                    <div>
                                                        <?php foreach ($data['prov'] as $pr) { ?>
                                                            <option value="<?= $pr['id_provinsi'] ?>"><?= $pr['provinsi'] ?></option>
                                                        <?php } ?>
                                                    </div>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label class="form-label mb-0 pb-0">Kota/Kabupaten</label>
                                                <div id="opKot"></div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col pe-0">
                                                <label class="form-label mb-0 pb-0">Kecamatan</label>
                                                <div id="opKec"></div>
                                            </div>
                                            <div class="col">
                                                <label class="form-label mb-0 pb-0">Kelurahan</label>
                                                <div id="opKel"></div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col pe-0">
                                                Alamat
                                                <input type="text" name="alamat" class="form-control" required>
                                            </div>
                                            <div class="col">
                                                Nomor Handphone
                                                <input type="text" name="hp" class="form-control" required>
                                            </div>
                                        </div>

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
                                            <div class="col">
                                                <label class="form-label mb-0 pb-0">No. Rekening</label>
                                                <input type="text" class="form-control" name="rek" required>
                                            </div>
                                        </div>

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

                                        <div class="row border-top pt-2">
                                            <div class="col">
                                                <button type="submit" id="btnSubmit" onclick="hide()" class="btn btn-success btn-block">Submit Register</button>
                                                <span id="persen"><b>0</b></span><b> %</b>
                                            </div>
                                            <div class="col mt-auto">
                                                <a href='<?= $this->BASE_URL ?>Login' id="btnSubmit" class="float-end"><small>Login</small></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/selectize.min.js"></script>
<script>
    $(document).ready(function() {
        $('select.tize').selectize();
    });

    $('select#selProv').on('change', function() {
        var id_provinsi = this.value;
        $("div#opKot").html('')
        $("div#opKec").html('')
        $("div#opKel").html('')
        if (id_provinsi.length > 0) {
            $("div#opKot").load('<?= $this->BASE_URL . $data['_c'] ?>/load_kota/' + id_provinsi);
        }
    });

    $("form").on("submit", function(e) {
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
                    alert("Register Success! Redirect to Login Page")
                    location.href = "<?= $this->BASE_URL ?>Login";
                } else {
                    alert(res);
                }
            },
        });
    });
</script>