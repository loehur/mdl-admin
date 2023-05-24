<?php
$pelanggan_jenis = "";
$id_pelanggan_jenis = $data['id_jenis_pelanggan'];

if ($id_pelanggan_jenis == 1) {
    $pelanggan_jenis = "Umum";
} else {
    $pelanggan_jenis = "Rekanan";
}
?>

<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4">
        <div class="card mt-n10" style="max-width: 500px;">
            <div class="card-header ">Pelanggan <b><?= $pelanggan_jenis ?></b>
                <button type="button" class="float-end btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah</button>
            </div>
            <div class="card-body">

                <?php
                foreach ($data['pelanggan'] as $a) { ?>
                    [ <?= $a['id_pelanggan'] ?> - <?= $a['no_hp'] ?> ] <b><?= $a['nama'] ?></b>
                    <?php
                    if ($id_pelanggan_jenis == 2) { ?>
                        <br><b><?= $a['usaha'] ?></b> - <?= $a['alamat'] ?>
                    <?php }
                    ?>
                    <hr>
                <?php }
                ?>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Menambah Pelanggan <b><?= $pelanggan_jenis ?></b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= $this->BASE_URL ?>Pelanggan/add/<?= $id_pelanggan_jenis ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label" required>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label" required>Nomor Handphone</label>
                        <input type="text" name="hp" class="form-control" required>
                    </div>
                    <?php
                    if ($id_pelanggan_jenis == 2) { ?>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label" required>Nama Usaha</label>
                            <input type="text" name="usaha" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label" required>Alamat Usaha</label>
                            <input type="text" name="alamat" class="form-control" required>
                        </div>
                    <?php }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>

<script>
    $("form").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: $(this).attr("method"),
            success: function(result) {
                if (result == 0) {
                    content();
                } else {
                    alert(result);
                }
            },
        });
    });
</script>