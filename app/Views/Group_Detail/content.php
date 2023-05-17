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
        <div class="card mt-n10" style="max-width: 500px;">
            <div class="card-header ">Kelompok Detail
                <button type="button" class="float-end btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah</button>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <tbody>
                        <?php
                        foreach ($data as $k => $a) { ?>
                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col">
                                            <span class="text-success"><?= $a['detail_group'] ?></span>
                                        </div>
                                        <div class="col">
                                            <div class="float-end">
                                                <button onclick="chgAction(<?= $a['id_detail_group'] ?>,'<?= $a['detail_group'] ?>')" type="button" class="border rounded bg-white px-2" data-bs-toggle="modal" data-bs-target="#item">+</button>
                                                <button onclick="chgActionMulti(<?= $a['id_detail_group'] ?>,'<?= $a['detail_group'] ?>')" type="button" class="border rounded bg-white" data-bs-toggle="modal" data-bs-target="#itemMulti">++</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-1">
                                        <div class="c">
                                            <small>
                                                <?php
                                                foreach ($data[$k]['item'] as $di) { ?>
                                                    <span class="border px-1 text-nowrap"><?= strtoupper($di['item_name']) ?></span>
                                                <?php }
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Menambah Kelompok Detali</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= $this->BASE_URL ?>Group_Detail/add" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Kelompok Detail</label>
                        <input type="text" name="group" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="item" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Menambah Item <span class="text-success groupDetail"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addItem" action="<?= $this->BASE_URL ?>Group_Detail/add_item" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Item Detail</label>
                        <input type="text" name="item" class="form-control" required>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Bantuan Varian - <small>Pisahkan dengan Koma ( , )</small></label>
                        <input type="text" name="varian" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="itemMulti" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Menambah MULTI <span class="text-success groupDetail"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addItemMulti" action="<?= $this->BASE_URL ?>Group_Detail/add_item_multi" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Item Detail - <small>Pisahkan dengan Koma ( , )</small></label>
                        <input type="text" name="item" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
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
</script>