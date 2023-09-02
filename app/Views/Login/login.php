<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= $this->app ?> | Login</title>
    <link href="<?= $this->ASSETS_URL ?>css/styles.css" rel="stylesheet" />
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
$msg = "";
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}
?>

<body class="bg-info">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container-xl px-4">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <!-- Basic login form-->
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-body login-card-body">
                                    <p class="login-box-msg text-center"><?= $this->app ?> Login</p>
                                    <div id="info" class="text-danger pb-2 float-end"><?= $msg ?></div>
                                    <form action="<?= $this->BASE_URL ?>Login/cek_login" method="post">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1"><i class="fas fa-phone"></i></span>
                                            <?php if (isset($_SESSION['otp_log']) && $_SESSION['otp_log']['v'] == date('i')) { ?>
                                                <input type="text" name="hp" value="<?= $_SESSION['otp_log']['hp'] ?>" class="form-control" readonly required>
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
                                            <input type="text" name="c_" class="form-control" placeholder="Captcha Code" required autocomplete="off">
                                            <span class="input-group-text" id="basic-addon2"> <img class="rounded" src="<?= $this->BASE_URL . $data['_c'] ?>/captcha" alt="captcha" /></span>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <button type="submit" id="btnSubmit" onclick="hide()" class="btn btn-success btn-block">Log In</button>
                                            </div>
                                            <div class="col mt-auto">
                                                <a href='<?= $this->BASE_URL ?>Register' id="btnSubmit" class="float-end"><small>Register</small></a>
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
</script>