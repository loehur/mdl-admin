<?php
$pelanggan_jenis = "";
$id_pelanggan_jenis = $data['id_jenis_pelanggan'];

if ($id_pelanggan_jenis == 1) {
    $pelanggan_jenis = "Umum";
} else {
    $pelanggan_jenis = "Rekanan";
}
?>

<style>
    .selectize-control {
        padding: 0;
    }

    .selectize-input {
        border: none;
    }

    .selectize-input::after {
        visibility: hidden;
    }
</style>

<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4"></div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="card mt-n10">
            <div class="card-header ">Buka Order - <b><?= $pelanggan_jenis ?></b><button type="button" class="float-end btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah</button></div>
            <div class="card-body">
                <form action="<?= $this->BASE_URL ?>Buka_Order/proses/<?= $id_pelanggan_jenis ?>" method="POST">
                    <div class="row pb-2">
                        <div class="col">
                            <label class="form-label">Pelanggan <?= $pelanggan_jenis ?></label>
                            <select class="form-select tize" name="id_pelanggan" required>
                                <option></option>
                                <?php foreach ($data['pelanggan'] as $p) { ?>
                                    <option value="<?= $p['id_pelanggan'] ?>"><?= $p['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label">Customer Service</label>
                            <select class="form-select tize" name="id_karyawan" required>
                                <option></option>
                                <?php foreach ($data['karyawan'] as $k) { ?>
                                    <option value="<?= $k['id_karyawan'] ?>"><?= $k['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col mt-auto">
                            <button type="submit" class="btn btn-primary">Proses</button>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <td class="text-purple text-end">No</td>
                        <td class="text-purple">Produk</td>
                        <td class="text-purple text-end">Harga</td>
                        <td class="text-purple text-end">Jumlah</td>
                        <td class="text-purple text-end">Total</td>
                        <td class="text-purple"></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($data['order'] as $do) {
                        $no++;
                        $id_order_data = $do['id_order_data'];
                        $id_produk = $do['id_produk'];
                        $detail_arr = unserialize($do['produk_detail']);
                        $detail = "";
                        foreach ($detail_arr as $da) {
                            $detail .= $da['detail_name'] . ", ";
                        }

                        foreach ($this->dProduk as $dp) {
                            if ($dp['id_produk'] == $id_produk) {
                                $produk = $dp['produk'];
                            }
                        }

                        $btnSetHarga = '<a href="#" data-bs-toggle="modal" class="tetapkanHarga" data-produk_code="' . $do['produk_code'] . '" data-produk="' . strtoupper($produk) . ' - ' . strtoupper($detail) . '" data-bs-target="#exampleModal1">Tetapkan</a>';
                    ?>
                        <tr>
                            <td class="text-end"><?= $no  ?></td>
                            <td><small><span class="text-nowrap"><?= strtoupper($produk) ?></span><br><span><?= strtoupper($detail) ?></span></small></td>
                            <td class="text-end"><?= ($do['harga'] == 0) ? $btnSetHarga : number_format($do['harga'])  ?></td>
                            <td class="text-end"><?= number_format($do['jumlah']) ?></td>
                            <td class="text-end"><?= number_format($do['harga'] * $do['jumlah']) ?></td>
                            <td><a class="deleteItem" data-id_order="<?= $id_order_data ?>" href="#"><i class="text-danger fa-regular fa-circle-xmark"></i></a></td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Produk - <b><?= $pelanggan_jenis ?></b></h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= $this->BASE_URL ?>Buka_Order/add/<?= $id_pelanggan_jenis ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Produk</label>
                        <select class="form-select tize" name="id_produk" required>
                            <option></option>
                            <?php foreach ($this->dProduk as $dp) { ?>
                                <option value="<?= $dp['id_produk'] ?>"><?= $dp['produk'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div id="detail"></div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b><span class="produk_harga"></span></b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= $this->BASE_URL ?>Buka_Order/add_price/<?= $id_pelanggan_jenis ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" required>Harga</label>
                        <input type="harga" min="1" name="harga" class="form-control" required>
                        <input type="hidden" name="produk_code" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= $this->ASSETS_URL ?>js/selectize.min.js"></script>
<script>
    $(document).ready(function() {
        $('select.tize').selectize();
    });

    $('select.tize').on('change', function() {
        var produk = this.value;
        $("div#detail").load('<?= $this->BASE_URL ?>Buka_Order/load_detail/' + produk);
    });

    $("a.tetapkanHarga").click(function() {
        var produk = $(this).attr("data-produk");
        var produk_code = $(this).attr("data-produk_code");
        $("span.produk_harga").html(produk);
        $("input[name=produk_code").val(produk_code);
    })

    $("a.deleteItem").click(function() {
        var id = $(this).attr("data-id_order");
        $.ajax({
            url: "<?= $this->BASE_URL ?>/Buka_Order/deleteOrder",
            data: {
                id_order: id
            },
            type: "POST",
            success: function(res) {
                if (res == 0) {
                    content();
                } else {
                    alert(res);
                }
            }
        });
    })

    $("form").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: $(this).attr("method"),
            success: function(res) {
                if (res == 0) {
                    content();
                } else {
                    alert(res);
                }
            }
        });
    });
</script>