<div class="m-2 p-1 bg-white rounded" style="max-width: 500px;">
    <?php
    if ($_SESSION['user']['id_payment'] == "") { ?>
        <span class="set btn btn-sm btn-outline-primary">Set Payment</span>
    <?php
    } else { ?>
        <div class="row">
            <div class="col-auto pe-0">
                <select class="form-select form-select-sm" id="id_cek">
                    <option selected value=""><?= $data['_c'] ?></option>
                    <?php
                    foreach ($data['cabang'] as $v) { ?>
                        <option value="<?= $v['no_user'] ?>"><?= $v['nama'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col ps-1">
                <span class="btn btn-sm border cekKas">Cek Kas</span>
            </div>
        </div>
        <div class="row">
            <div class="col" id="load_kas"></div>
        </div>
    <?php } ?>
</div>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>
<script>
    $(".set").click(function() {
        var no = prompt("Nomor Akun", "");
        if (no.length == 0) {
            return;
        }
        $.post("<?= $this->BASE_URL . $data['_c'] ?>/push", {
                no: no
            },
            function(res) {
                if (res == 1) {
                    var code = prompt("Masukan Kode OTP", "");
                    if (code.length == 0) {
                        return;
                    }
                    $.post("<?= $this->BASE_URL . $data['_c'] ?>/set", {
                            no: no,
                            code: code
                        },
                        function(res) {
                            if (res == 0) {
                                content();
                            } else {
                                alert(res);
                            }
                        })
                } else {
                    alert(res);
                }
            })
    });

    $(".cekKas").click(function() {
        var id = $("#id_cek").val();
        if (id.length > 0) {
            load_kas(id);
        }
    });

    function load_kas(id) {
        $("div#load_kas").load("<?= $this->BASE_URL . $data['_c'] ?>/load_kas/" + id);
    }
</script>