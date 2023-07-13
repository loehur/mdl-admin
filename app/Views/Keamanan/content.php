<header class="py-4 mb-3 bg-gradient-primary-to-secondary">
    <div class="container-xl">
        <div class="text-center">
            <h1 class="text-white">Profil - <?= $data['_c'] ?></h1>
        </div>
    </div>
</header>

<!-- Main page content-->
<div class="konten">
    <div class="row m-0">
        <div class="col-auto bg-white py-2">
            <label class="form-label"><b>Ubah Password</b></label>
            <form id="form" action="<?= $this->BASE_URL . $data['_c'] ?>/updatePass" method="post">
                <div class="row mb-2">
                    <div class="col">
                        <label>Password Lama</label>
                        <input type="password" class="form-control form-control-sm" name="pass" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <label>Password Baru</label>
                        <input type="password" class="form-control form-control-sm" name="pass_" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <label>Ulangi Password Baru</label>
                        <input type="password" class="form-control form-control-sm" name="pass__">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">
                            Update Password
                        </button>
                    </div>
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
            success: function(res) {
                if (res == 0) {
                    alert("Success! New Password Updated!")
                    location.reload(true);
                } else {
                    alert(res);
                }
            }
        });
    });
</script>