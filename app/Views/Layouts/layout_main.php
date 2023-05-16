<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Orins | <?= $data['title'] ?></title>
	<link href="<?= $this->ASSETS_URL ?>css/styles.css" rel="stylesheet" />
	<link rel="icon" type="image/x-icon" href="<?= $this->ASSETS_URL ?>assets/img/favicon.png" />
	<script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="<?= $this->ASSETS_URL ?>plugins/fontawesome-free-6.4.0-web/css/all.css" rel="stylesheet">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
	<!-- FONT -->

	<?php $fontStyle = "'Titillium Web', sans-serif;" ?>

	<style>
		html .table {
			font-family: <?= $fontStyle ?>;
		}

		html .content {
			font-family: <?= $fontStyle ?>;
		}

		html body {
			font-family: <?= $fontStyle ?>;
		}

		@media print {
			p div {
				font-family: <?= $fontStyle ?>;
				font-size: 14px;
			}
		}

		html {
			height: 100%;
			background-color: #F4F4F4;
		}

		body {
			min-height: 100%;
		}
	</style>

</head>

<?php $t = $data['title']; ?>

<body class="nav-fixed">
	<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
		<button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>
		<a class="navbar-brand pe-3 ps-4 ps-lg-2" id="sync" href="<?= $this->BASE_URL ?>Log/sync"><?= strtoupper($this->userData['nama_toko']) ?></a>
		<?php if ($this->userData['user_tipe'] == 0) { ?>
			<div class="dropdown">
				<button class="btn btn-icon btn-transparent-dark dropdown-toggle border" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
					<i class="fa-solid fa-repeat"></i>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
					<?php
					foreach ($this->dToko as $dt) { ?>
						<li><a class="dropdown-item sync" href="<?= $this->BASE_URL ?>Log/change_toko/<?= $dt['id_toko'] ?>"><?= $dt['nama_toko'] ?></a></li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
		<ul class="navbar-nav align-items-center ms-auto">
			<!-- User Dropdown-->
			<li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
				<a class="btn btn-icon btn-transparent-dark dropdown-toggle border" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<b><?= strtoupper(substr($this->userData['nama'], 0, 2)) ?></b>
				</a>
				<div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
					<h6 class="dropdown-header d-flex align-items-center">
						<div class="dropdown-user-details">
							<div class="dropdown-user-details-name"><?= $this->userData['nama'] ?></div>
						</div>
					</h6>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#!">
						<div class="dropdown-item-icon"><i data-feather="settings"></i></div>
						Account
					</a>
					<a class="dropdown-item" href="<?= $this->BASE_URL ?>Login_99/logout">
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
						<!-- Sidenav Menu Heading (Account)-->
						<!-- * * Note: * * Visible only on and above the sm breakpoint-->
						<div class="sidenav-menu-heading">User Menu</div>
						<!-- Sidenav Accordion (Dashboard)-->
						<a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDashboards" aria-expanded="true" aria-controls="collapseDashboards">
							<div class="nav-link-icon"><i data-feather="plus-square"></i></div>
							SPK
							<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse" id="collapseDashboards" data-bs-parent="#accordionSidenav">
							<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
								<a class="nav-link" href="#">Buat Baru</a>
								<a class="nav-link" href="#">Dalam Proses</a>
								<a class="nav-link" href="#">Tuntas</a>
							</nav>
						</div>
						<div class="sidenav-menu-heading">Admin Panel</div>
						<a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseFlowsUser" aria-expanded="false" aria-controls="collapseFlows">
							<div class="nav-link-icon"><i data-feather="user"></i></div>
							Orins User
							<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse" id="collapseFlowsUser" data-bs-parent="#accordionSidenav">
							<nav class="sidenav-menu-nested nav">
								<a class="nav-link" href="#">Staf Kasir</a>
								<a class="nav-link" href="#">Staf Oprasional</a>
							</nav>
						</div>
						<a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseFlows" aria-expanded="false" aria-controls="collapseFlows">
							<div class="nav-link-icon"><i data-feather="user"></i></div>
							Karyawan
							<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse" id="collapseFlows" data-bs-parent="#accordionSidenav">
							<nav class="sidenav-menu-nested nav">
								<a class="nav-link" href="#">Aktif</a>
								<a class="nav-link" href="#">Tidak Aktif</a>
							</nav>
						</div>
						<a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseFlows2" aria-expanded="false" aria-controls="collapseFlows">
							<div class="nav-link-icon"><i data-feather="database"></i></div>
							Pengaturan Produksi
							<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse" id="collapseFlows2" data-bs-parent="#accordionSidenav">
							<nav class="sidenav-menu-nested nav">
								<a class="nav-link" href="#">Divisi</a>
								<a class="nav-link" href="#">Kelompok Detail</a>
								<a class="nav-link" href="#">Jenis Item</a>
								<a class="nav-link" href="#">Jenis Order</a>
							</nav>
						</div>

						<?php if ($this->userData['user_tipe'] == 0) { ?>
							<!-- MASTER PANEL -->
							<div class="sidenav-menu-heading">Master Panel</div>
							<a class="nav-link <?= (str_contains($t, "Toko")) ? 'active' : 'collapsed' ?>" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseToko" aria-expanded="false" aria-controls="collapseFlows">
								<div class="nav-link-icon"><i data-feather="server"></i></div>
								Toko
								<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
							</a>
							<div class="collapse <?= (str_contains($t, "Toko")) ? 'show' : '' ?>" id="collapseToko" data-bs-parent="#accordionSidenav">
								<nav class="sidenav-menu-nested nav">
									<a class="nav-link <?= ($t == "Daftar Toko") ? 'active' : '' ?>" href="<?= $this->BASE_URL ?>Toko_Daftar">Daftar Toko</a>
									<a class="nav-link <?= ($t == "Admin Orins Toko") ? 'active' : '' ?>" href="<?= $this->BASE_URL ?>Toko_Admin">Admin Orins Toko</a>
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
				<div id="content">

				</div>
			</main>
			<footer class="footer-admin mt-auto footer-light">
				<div class="container-xl px-4">
					<div class="row">
						<div class="col-md-6 small">Copyright &copy; LG</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
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
</script>