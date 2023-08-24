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
<div id="content"></div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= $this->BASE_URL ?>Room/transfer" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Transfer Chip</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input name="c" type="number" class="form-control text-center">
                    <input name="t" type="hidden">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100" data-bs-dismiss="modal">Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/scripts.js"></script>

<script>
    $(document).ready(function() {
        content();
    });

    function content() {
        $("div#content").load('<?= $this->BASE_URL ?><?= $data['page'] ?>/content');
    }

    $("form").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: $(this).attr("method"),
            success: function(res) {
                if (res == 0) {
                    $(this).trigger("reset");
                    content();
                } else {
                    alert(res);
                }
            }
        });
    });

    const interval = setInterval(function() {
        content();
    }, 3000);
</script>