<header class="py-4 mb-3 bg-gradient-primary-to-secondary">
    <div class="container-xl">
        <div class="text-center">
            <h1 class="text-white">Profil - <?= $data['_c'] ?></h1>
        </div>
    </div>
</header>

<!-- Main page content-->
<div class="konten">
    <div class="row">
        <div class="col-auto">
            <table class="table table-sm bg-white mb-2">
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><?= $this->userData['nama'] ?></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td class="text-danger">Belum Terverifikasi<br><a href="#" class="">Lengkapi Data</a></td>
                </tr>
            </table>

            <table class="table table-sm bg-white">
                <tr>
                    <td>No. Handphone</td>
                    <td>:</td>
                    <td><?= $this->userData['hp'] ?></td>
                </tr>
                <tr>
                    <td class="pe-2">Penghasilan/Bulan</td>
                    <td>:</td>
                    <td>Rp<?= number_format($this->userData['penghasilan']) ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?= strtoupper($this->userData['alamat']) ?></td>
                </tr>
                <tr>
                    <td>Provinsi</td>
                    <td>:</td>
                </tr>
                <tr>
                    <td>Kota/Kabupaten</td>
                    <td>:</td>
                </tr>
                <tr>
                    <td>Kecamatan</td>
                    <td>:</td>
                </tr>
                <tr>
                    <td>Kelurahan</td>
                    <td>:</td>
                </tr>
            </table>
        </div>
    </div>
    </main>

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