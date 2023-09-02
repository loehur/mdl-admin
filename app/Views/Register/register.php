<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= $this->app ?> | Register</title>
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

<body class="bg-light">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container-xl px-1 pt-2 mt-3">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <!-- Basic login form-->
                            <div class="card shadow-lg border-0 rounded-lg mt-1">
                                <div class="card-body login-card-body">
                                    <p class="login-box-msg text-center"><?= $this->app ?> Register</p>
                                    <form action="<?= $this->BASE_URL . $data['_c'] ?>/add" method="post">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-phone"></i></span>
                                            <?php if (isset($_SESSION['otp']) && $_SESSION['otp']['v'] == date('i')) { ?>
                                                <input type="text" name="hp" value="<?= $_SESSION['otp']['hp'] ?>" class="form-control" readonly required>
                                            <?php } else { ?>
                                                <input type="text" name="hp" class="form-control" placeholder="No. Handphone" required>
                                                <span class="input-group-text" id="otp" style="cursor: pointer;"><i class="fa-brands fa-whatsapp me-1"></i>OTP</span>
                                            <?php } ?>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                            <input type="text" name="otp" class="form-control" placeholder="OTP" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
                                            <input type="text" name="nama" class="form-control" placeholder="Nama Pribadi / Nama Usaha" required>
                                        </div>
                                        <div class="row border-top pt-2">
                                            <div class="col">
                                                <button type="submit" id="btnSubmit" class="btn btn-success btn-block">Submit Register</button>
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

<script>
    $("#otp").click(function() {
        var no = $("input[name=hp]").val();
        if (no.length > 0) {
            $("#otp").hide();
            $.post("<?= $this->BASE_URL . $data["_c"] ?>/otp", {
                    hp: no,
                },
                function(res) {
                    location.reload(true);
                });
        }
    })

    $("form").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
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