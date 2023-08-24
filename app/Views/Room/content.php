<!-- Main page content-->
<div class="row m-2 border rounded">
    <div class="col">
        <div class="row">
            <div class="col text-center">
                <h3>
                    <b><?= $_SESSION['user'] ?></b><br>
                    <div class="text-success"><b><?= $data['chip'] ?></b></div>
                </h3>
            </div>
        </div>

    </div>
</div>
<?php foreach ($data['friend'] as $df) { ?>
    <div style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="row m-2 border rounded bayar" data-user="<?= $df['user'] ?>">
        <div class="col">
            <div class="row">
                <div class="col text-center">
                    <h3>
                        <b><?= $df['user'] ?></b><br>
                        <div class="text-success"><b><?= $df['chip'] ?></b></div>
                    </h3>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/scripts.js"></script>

<script>
    $(".bayar").on("click", function(e) {
        var t = $(this).attr('data-user');
        $("input[name=t]").val(t);
    });
</script>