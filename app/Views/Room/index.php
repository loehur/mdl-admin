<!-- Main page content-->

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Chip</title>
    <link href="<?= $this->ASSETS_URL ?>css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>css/selectize.bootstrap3.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.min.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="<?= $this->ASSETS_URL ?>assets/img/favicon.png" />
    <script src="<?= $this->ASSETS_URL ?>js/feather.min.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/fontawesome-free-6.4.0-web/css/all.css" rel="stylesheet">
    <link href="<?= $this->ASSETS_URL ?>plugins/toggle/css/bootstrap-toggle.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
    <!-- FONT -->

    <?php $fontStyle = "'Titillium Web', sans-serif;" ?>

    <style>
        html {
            height: 100%;
        }

        html .table {
            font-family: <?= $fontStyle ?>;
        }

        html .content {
            font-family: <?= $fontStyle ?>;
        }

        html body {
            font-family: <?= $fontStyle ?>;
        }

        body {
            min-height: 100%;
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

        .selectize-dropdown-content {
            max-height: 100px;
        }

        .konten {
            margin-bottom: 15px;
            margin-left: 7px;
        }

        .line100 {
            line-height: 100%;
            margin-bottom: 5px;
        }
    </style>
</head>
<div class="row p-2 mt-4 m-auto" style="max-width: 500px;">
    <div class="col">
        <div class="mb-2">
            <label class="form-label">User Login</label>
            <input type="text" class="form-control" id="user">
        </div>
        <button type="submit" class="btn btn-primary w-100 login">Login</button>
    </div>
</div>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/scripts.js"></script>

<script>
    $(".login").on("click", function(e) {
        var user = $("input#user").val();
        window.location.href = "<?= $this->BASE_URL ?>Room/i/" + user;
    });
</script>