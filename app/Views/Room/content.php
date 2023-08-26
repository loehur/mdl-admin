<!-- Main page content-->
<?php if (count($data) <> 0) { ?>
    <div class="row m-2 py-3 cek" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal2">
        <div class="col">
            <div class="row">
                <div class="col text-center">
                    <h2>
                        <b><?= ucwords($_SESSION['user']) ?></b><br>
                        <div class="text-success"><b><?= number_format($data['chip']) ?></b></div>
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <?php foreach ($data['friend'] as $df) { ?>
        <div style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="row m-2 py-2 border rounded bayar bg-light" data-user="<?= $df['user'] ?>">
            <div class="col">
                <div class="row">
                    <div class="col text-center">
                        <h3>
                            <b><?= ucwords($df['user']) ?></b><br>
                            <div class="text-primary"><b><?= number_format($df['chip']) ?></b></div>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="row p-5 m-auto" style="max-width: 600px;">
        <div class="col text-center">
            <h3>User not Found</h3>
        </div>
    </div>
<?php } ?>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/scripts.js"></script>

<script>
    $(".bayar").on("click", function(e) {
        var t = $(this).attr('data-user');
        $("input[name=c]").focus();
        $("input[name=t]").val(t);
        $("b#target").html(t.toUpperCase());
    });

    $(".cek").on("click", function(e) {
        $("#mutasi").load("<?= $this->BASE_URL ?>Room/cek");
    });
</script>