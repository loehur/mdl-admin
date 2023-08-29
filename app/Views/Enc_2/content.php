<div class="row bg-white rounded m-1 pt-2 pb-2">
    <div class="col">
        <div class="row">
            <div class="col">
                <label class="form-label">Text</label>
                <textarea class="form-control" id="text" rows="3"></textarea>
                <button type="button" id="enc" class="btn btn-sm btn-primary float-end mt-1">Encrypt</button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                Result<br>
                <textarea class="form-control" id="result" rows="3" readonly></textarea>
            </div>
        </div>
    </div>
</div>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>

<script>
    $("#enc").click(function() {
        var text = $("#text").val();
        if (text.length == 0) {
            return;
        }
        $.post("<?= $this->BASE_URL . $data['_c'] ?>/enc_", {
                text: text
            },
            function(res) {
                $("#result").val(res);
            })
    })
</script>