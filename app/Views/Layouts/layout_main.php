<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>MDL Admin | <?= $data['title'] ?></title>
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

		.selectize-dropdown-content {
			max-height: 100px;
		}

		.konten {
			margin-bottom: 15px;
			margin-left: 7px;
		}

		.line100 {
			line-height: 100%;
			margin-bottom: 5px;
		}
	</style>
</head>

<?php $t = $data['title']; ?>

<body class="nav-fixed" style="background-color: aliceblue;">
	<nav class="topnav navbar navbar-expand border-bottom bg-light justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
		<button class="border rounded bg-white order-lg-0 mx-2 pt-2 px-2" id="sidebarToggle"><i data-feather="menu"></i></button>
		<span><?= $_SESSION['user']['nama'] ?></span>
		<button class="border rounded ms-auto bg-white order-lg-0 mx-2 pt-2 px-2 logout1">Logout</button>
	</nav>
	<div id="layoutSidenav">
		<div id="layoutSidenav_nav">
			<nav class="sidenav sidenav-light">
				<div class="sidenav-menu">
					<div class="nav accordion" id="accordionSidenav">
						<a class="nav-link <?= (str_contains($t, "Cash -")) ? 'active' : 'collapsed' ?> mt-2" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapse0" aria-expanded="true" aria-controls="collapseNewOrder">
							<div class="nav-link-icon"><i data-feather="credit-card"></i></div>
							Cash
							<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse <?= (str_contains($t, "Cash -")) ? 'show' : '' ?>" id="collapse0" data-bs-parent="#accordionSidenav">
							<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
								<a class="nav-link <?= ($t == "Cash - Laundry") ? 'active' : '' ?>" href="<?= $this->BASE_URL ?>Cash_Laundry">Laundry</a>
								<a class="nav-link <?= ($t == "Cash - Sale") ? 'active' : '' ?>" href="<?= $this->BASE_URL ?>Cash_Sale">Sale</a>
								<a class="nav-link <?= ($t == "Cash - Payment") ? 'active' : '' ?>" href="#">Payment</a>
							</nav>
						</div>

						<a class="nav-link <?= (str_contains($t, "E -")) ? 'active' : 'collapsed' ?> mt-2" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapse0" aria-expanded="true" aria-controls="collapseNewOrder">
							<div class="nav-link-icon"><i data-feather="key"></i></div>
							MDL Encryption
							<div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
						</a>
						<div class="collapse <?= (str_contains($t, "E -")) ? 'show' : '' ?>" id="collapse0" data-bs-parent="#accordionSidenav">
							<nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
								<a class="nav-link <?= ($t == "E - 1 Way") ? 'active' : '' ?>" href="<?= $this->BASE_URL ?>Enc">1 Way</a>
								<a class="nav-link <?= ($t == "E - Enc") ? 'active' : '' ?>" href="<?= $this->BASE_URL ?>Enc_2">Encrypt</a>
								<a class="nav-link <?= ($t == "E - Dec") ? 'active' : '' ?>" href="<?= $this->BASE_URL ?>Dec_2">Decrypt</a>
							</nav>
						</div>
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
	$(".logout1").click(function() {
		$.post("<?= $this->BASE_URL ?>Home/logout",
			function(res) {
				location.reload(true);
			})
	})
</script>