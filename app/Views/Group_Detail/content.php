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
                <button type="button" class="float-end btn btn-outline-primary mx-2" data-bs-toggle="modal" data-bs-target="#exampleModalLink">Tambah Link</button>
                <button type="button" class="float-end btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah</button>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <tbody>
                        <?php
                        foreach ($data as $k => $a) {
                        ?>
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
                                                    <span class="border px-1 text-nowrap"><?= strtoupper($di['detail_item']) ?></span>
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
                <h5 class="modal-title" id="exampleModalLabel">Menambah Kelompok Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= $this->BASE_URL ?>Group_Detail/add" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kelompok Detail</label>
                        <input type="text" name="group" required class="form-control">
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

<div class="modal fade" id="exampleModalLink" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Menambah LINK Kelompok Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= $this->BASE_URL ?>Group_Detail/add/1" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kelompok Detail</label>
                        <input type="text" name="group" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link Kelompok Detail</label>
                        <select class="form-select tize" name="id_detail_group" required>
                            <option></option>
                            <?php foreach ($data as $d) { ?>
                                <option value="<?= $d['id_detail_group'] ?>"><?= $d['detail_group'] ?></option>
                            <?php } ?>
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
                        <label for="exampleInputEmail1" class="form-label">Varian - <small>Pisahkan dengan Koma ( , )</small></label>
                        <input type="text" name="varian" class="form-control">
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
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>
<script src="<?= $this->ASSETS_URL ?>js/selectize.min.js"></script>

<script>
    $(document).ready(function() {
        $('select.tize').selectize();
    });

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