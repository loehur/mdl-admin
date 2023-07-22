<!-- Main page content-->
<?php foreach ($data as $du) { ?>
    <div class="row border m-1 rounded border">
        <div class="col py-1">
            <img src="<?= $this->BASE_URL . $du['ktp_path'] ?>" class="img-fluid" alt="...">
        </div>
    </div>
    <div class="row border m-1 rounded border">
        <div class="col-md-4 text-nowrap line100">
            <small><u>Nama</u></small><br>
            <?= $du['nama'] ?>
        </div>
        <div class="col-md-4 line100">
            <small><u>Nomor HP</u></small><br>
            <?= $du['hp'] ?>
        </div>
        <div class="col-md-4 line100">
            <small><u>Penghasilan/Bulan</u></small><br>Rp<?= number_format($this->userData['penghasilan']) ?>
        </div>
        <div class="col-md-4 text-nowrap line100">
            <small><u>NIK</u></small><br>
            <?= $du['nik'] ?>
        </div>
        <div class="col-md-4 text-nowrap line100">
            <small><u>Alamat</u></small><br>
            <?= $du['alamat'] ?>
        </div>
        <div class="col-md-4 line100">
            <small><u>Provinsi</u></small><br>
            <?= strtoupper($this->model("M_DB_1")->get_cols_where("_provinsi", "provinsi", "id_provinsi = '" . $this->userData['provinsi'] . "'", 0)['provinsi']) ?>
        </div>
        <div class="col-md-4 line100">
            <small><u>Kota/Kabupaten</u></small><br>
            <?= strtoupper($this->model("M_DB_1")->get_cols_where("_kota", "kota", "id_kota = '" . $this->userData['kota'] . "'", 0)['kota']) ?>
        </div>
        <div class="col-md-4 line100">
            <small><u>Kecamatan</u></small><br>
            <?= strtoupper($this->model("M_DB_1")->get_cols_where("_kecamatan", "kecamatan", "id_kecamatan = '" . $this->userData['kecamatan'] . "'", 0)['kecamatan']) ?>
        </div>
        <div class="col-md-4 line100">
            <small><u>Kelurahan</u></small><br>
            <?= strtoupper($this->model("M_DB_1")->get_cols_where("_kelurahan", "kelurahan", "id_kelurahan = '" . $this->userData['kelurahan'] . "'", 0)['kelurahan']) ?>
        </div>
    </div>
<?php } ?>