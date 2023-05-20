<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="card mt-n10" style="max-width: 600px;">
            <div class="card-header ">Produk
                <button type="button" class="float-end btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah</button>
            </div>
            <div class="card-body">
                <small>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Detail</th>
                                <th>Divisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data['produk'] as $a) {
                                $detail = "";
                                foreach (unserialize($a['produk_detail']) as $pd) {
                                    foreach ($data['detail'] as $d) {
                                        if ($pd == $d['id_detail_group'])
                                            $detail .= $d['detail_group'] . ", ";
                                    }
                                }

                                $divisi = "";
                                foreach (unserialize($a['divisi']) as $pd) {
                                    foreach ($data['divisi'] as $d) {
                                        if ($pd == $d['id_divisi'])
                                            $divisi .= $d['divisi'] . ", ";
                                    }
                                }
                            ?>
                                <tr>
                                    <td>
                                        <?= $a['produk'] ?>
                                    </td>
                                    <td>
                                        <?= $detail ?>
                                    </td>
                                    <td>
                                        <?= $divisi ?>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                </small>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Menambah Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= $this->BASE_URL ?>Produk/add" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama Produk</label>
                        <input type="text" name="produk" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Detail yang diperlukan</label>
                        <select class="form-select" name="detail[]" multiple aria-label="multiple select example" required>
                            <?php foreach ($data['detail'] as $d) { ?>
                                <option value="<?= $d['id_detail_group'] ?>"><?= $d['detail_group'] ?></option>
                            <?php  }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Divisi yg bertugas</label>
                        <select class="form-select" name="divisi[]" multiple aria-label="multiple select example" required>
                            <?php foreach ($data['divisi'] as $d) { ?>
                                <option value="<?= $d['id_divisi'] ?>"><?= $d['divisi'] ?></option>
                            <?php  }
                            ?>
                        </select>
                    </div>
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
    var addItemAction = $("form#addItem").attr('action');
    var addItemMultiAction = $("form#addItemMulti").attr('action');

    function chgAction(id_detail_group, group) {
        var newAction = addItemAction + "/" + id_detail_group;
        $('form#addItem').attr('action', newAction);
        $('span.groupDetail').html(group);
    }

    function chgActionMulti(id_detail_group, group) {
        var newAction = addItemMultiAction + "/" + id_detail_group;
        $('form#addItemMulti').attr('action', newAction);
        $('span.groupDetail').html(group);
    }

    $("form").on("submit", function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: $(this).attr("method"),
            success: function(res) {
                content();
            },
        });
    });
</script>