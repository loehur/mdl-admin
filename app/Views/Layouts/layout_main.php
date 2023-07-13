<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Bantu Pinjam | <?= $data['title'] ?></title>
	<link href="<?= $this->ASSETS_URL ?>css/styles.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?= $this->ASSETS_URL ?>css/selectize.bootstrap3.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.min.css" rel="stylesheet" />
	<link rel="icon" type="image/x-icon" href="<?= $this->ASSETS_URL ?>assets/img/favicon.png" />
	<script src="<?= $this->ASSETS_URL ?>js/feather.min.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/fontawesome-free-6.4.0-web/css/all.css" rel="stylesheet">
	<link href="<?= $this->ASSETS_URL ?>plugins/toggle/css/bootstrap-toggle.min.css" rel="stylesheet">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
	<!-- FONT -->

	<?php $fontStyle = "'Titillium Web', sans-serif;" ?>

	<style>
		html {
			height: 100%;
		}

		html .table {
			font-family: <?= $fontStyle ?>;
		}

		html .content {
			font-family: <?= $fontStyle ?>;
		}

		html body {
			font-family: <?= $fontStyle ?>;
		}

		body {
			min-height: 100%;
		}

		.selectize-control {
			padding: 0;
		}

		.selectize-input {
			border: none;
		}

		.selectize-input::after {
			visibility: hidden;
		}

		main {
			margin-bottom: 20px;
			margin-left: 5px;
			margin-right: 5px;
		}
	</style>
</head>

<?php $t = $data['title']; ?>

<body class="nav-fixed" style="background-color: aliceblue;">
	<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
		<button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0 pt-3" id="sidebarToggle"><i data-feather="menu"></i></button>
		<ul class="navbar-nav align-items-center ms-auto ms">
			<!-- User Dropdown-->
			<li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
				<a class="btn rounded btn-transparent-dark dropdown-toggle border" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<b><small><?= strtoupper($this->userData['nama']) ?></small></b>
				</a>
				<div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
					<h6 class="dropdown-header d-flex align-items-center">
						<div class="dropdown-user-details">
							<div class="dropdown-user-details-name"><?= $this->userData['nama'] ?></div>
						</div>
					</h6>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="<?= $this->BASE_URL ?>Login/logout">
						<div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
						Logout
					</a>
				</div>
			</li>
		</ul>
	</nav>
	<div id="layoutSidenav">
		<div id="layoutSidenav_nav">
			<nav class="sidenav shadow-right sidenav-light">
				<div class="sidenav-menu">
					<div class="nav accordion" id="accordionSidenav">
						<?php if (in_array($this->userData['user_tipe'], $this->pClient)) { ?>
							<div class="sidenav-menu-heading pb-0">Marketplace</div>
							<a class="nav-link <?= (str_contains($t, "Pinjaman")) ? 'active' : 'collapsed' ?> mt-2" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapse0" aria-expanded="true" aria-controls="collapseNewOrder">
								<div class="nav-link-icon"><i data-feather="user"></i></div>
								Marketplace
								<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
							</a>
							<div class="collapse <?= (str_contains($t, "Marketplace")) ? 'show' : '' ?>" id="collapse0" data-bs-parent="#accordionSidenav">
								<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
									<a class="nav-link <?= ($t == "Marketplace - Penawaran") ? 'active' : '' ?>" href="#">Dalam Penawaran</a>
									<a class="nav-link <?= ($t == "Marketplace - Terpenuhi") ? 'active' : '' ?>" href="#">Terpenuhi</a>
								</nav>
							</div>

							<div class="sidenav-menu-heading pb-0">Client Menu</div>
							<a class="nav-link <?= (str_contains($t, "Pinjaman")) ? 'active' : 'collapsed' ?> mt-2" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapseNewOrder">
								<div class="nav-link-icon"><i data-feather="user"></i></div>
								Pinjaman
								<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
							</a>
							<div class="collapse <?= (str_contains($t, "Pinjaman")) ? 'show' : '' ?>" id="collapse1" data-bs-parent="#accordionSidenav">
								<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
									<a class="nav-link <?= ($t == "Pinjaman - Pengajuan") ? 'active' : '' ?>" href="#">Pengajuan</a>
									<a class="nav-link <?= ($t == "Pinjaman - Riwayat Pengajuan") ? 'active' : '' ?>" href="#">Riwayat Pengajuan</a>
									<a class="nav-link <?= ($t == "Pinjaman - Riwayat Pinjaman") ? 'active' : '' ?>" href="#">Riwayat Pinjaman</a>
								</nav>
							</div>
							<a class="nav-link <?= (str_contains($t, "Pendanaan")) ? 'active' : 'collapsed' ?> mt-2" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="true" aria-controls="collapseNewOrder">
								<div class="nav-link-icon"><i data-feather="user"></i></div>
								Pendanaan
								<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
							</a>
							<div class="collapse <?= (str_contains($t, "Pendanaan")) ? 'show' : '' ?>" id="collapse2" data-bs-parent="#accordionSidenav">
								<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
									<a class="nav-link <?= ($t == "Pendanaan - Portfolio") ? 'active' : '' ?>" href="#">Portfolio</a>
									<a class="nav-link <?= ($t == "Pendanaan - Riwayat Pendanaan") ? 'active' : '' ?>" href="#">Riwayat Pendanaan</a>
								</nav>
							</div>
							<a class="nav-link <?= (str_contains($t, "Profil")) ? 'active' : 'collapsed' ?> mt-2" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseProfil" aria-expanded="true" aria-controls="collapseProfil">
								<div class="nav-link-icon"><i data-feather="user"></i></div>
								Profil
								<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
							</a>
							<div class="collapse <?= (str_contains($t, "Profil")) ? 'show' : '' ?>" id="collapseProfil" data-bs-parent="#accordionSidenav">
								<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
									<a class="nav-link <?= ($t == "Profil - Data Pribadi") ? 'active' : '' ?>" href="<?= $this->BASE_URL ?>Data_Pribadi">Data Pribadi</a>
									<a class="nav-link <?= ($t == "Profil - Rekening") ? 'active' : '' ?>" href="#">Rekening</a>
									<a class="nav-link <?= ($t == "Profil - Keamanan") ? 'active' : '' ?>" href="<?= $this->BASE_URL ?>Keamanan">Keamanan</a>
								</nav>
							</div>
						<?php } ?>
						<?php if (in_array($this->userData['user_tipe'], $this->pAdmin)) { ?>
							<div class="sidenav-menu-heading pb-0">Admin Panel</div>
							<a class="nav-link <?= (str_contains($t, "Admin")) ? 'active' : 'collapsed' ?> mt-2" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseA" aria-expanded="true" aria-controls="collapseNewOrder">
								<div class="nav-link-icon"><i data-feather="user"></i></div>
								Approval
								<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
							</a>
							<div class="collapse <?= (str_contains($t, "Admin")) ? 'show' : '' ?>" id="collapseA" data-bs-parent="#accordionSidenav">
								<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
									<a class="nav-link <?= ($t == "Admin - Verify") ? 'active' : '' ?>" href="#">User Verification</a>
									<a class="nav-link <?= ($t == "Admin - Pengajuan") ? 'active' : '' ?>" href="#">Pengajuan Pinjaman</a>
									<a class="nav-link <?= ($t == "Admin - Pendanaan") ? 'active' : '' ?>" href="#">Pencairan Pendanaan</a>
								</nav>
							</div>
						<?php } ?>
					</div>
				</div>
				<!-- Sidenav Footer-->
				<div class="sidenav-footer">
					<div class="sidenav-footer-content">
						<div class="sidenav-footer-subtitle">Logged in as:</div>
						<div class="sidenav-footer-title"><?= $this->userData['nama'] ?></div>
					</div>
				</div>
			</nav>
		</div>
		<div id="layoutSidenav_content">
			<main>
				<div id="content"></div>
			</main>
		</div>
	</div>
	<script src="<?= $this->ASSETS_URL ?>plugins/bootstrap-5.1/bootstrap.bundle.min.js"></script>
	<script src="<?= $this->ASSETS_URL ?>js/scripts.js"></script>
</body>

</html>

<script src="<?= $this->ASSETS_URL ?>js/jquery-3.7.0.min.js"></script>

<script>
	$("a#sync").click(function(e) {
		e.preventDefault();
		sync();
	});

	function sync() {
		$.ajax({
			url: $("a#sync").attr('href'),
			type: "GET",
			success: function() {
				location.reload(true);
			},
		});
	}

	$("a.sync").click(function(e) {
		e.preventDefault();
		$.ajax({
			url: $(this).attr('href'),
			type: "GET",
			success: function() {
				sync();
			},
		});
	});

	var time = new Date().getTime();
	$(document.body).bind("mousemove keypress", function(e) {
		time = new Date().getTime();
	});

	function refresh() {
		if (new Date().getTime() - time >= 420000)
			window.location.reload(true);
		else
			setTimeout(refresh, 10000);
	}
	setTimeout(refresh, 10000);
</script>