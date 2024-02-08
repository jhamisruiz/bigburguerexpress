<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Big Burguer - Carta Online</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Sanguchería Express">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>public/images/logo/favicon.png">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/bootstrap4/bootstrap.min.css">
	<link href="<?php echo base_url(); ?>public/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"
		  type="text/css">
	<link rel="stylesheet" type="text/css"
		  href="<?php echo base_url(); ?>public/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
	<link rel="stylesheet" type="text/css"
		  href="<?php echo base_url(); ?>public/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
	<link rel="stylesheet" type="text/css"
		  href="<?php echo base_url(); ?>public/plugins/OwlCarousel2-2.2.1/animate.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/js/toastr/build/toastr.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/main_styles.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/style.css">

	<script src="<?php echo base_url(); ?>public/js/jquery-3.2.1.min.js"></script>

	<script>
		site_url = '<?php echo site_url(); ?>';
		base_url = '<?php echo base_url(); ?>';
	</script>

	<?php
	if (isset($css_files)) {
		foreach ($css_files as $file) {
			$last_update = filemtime(str_replace(base_url(), "", $file));
			echo "<link rel='stylesheet' href='$file?v=$last_update' type='text/css'/>\n";
		}
	}
	?>

</head>

<body>

<div class="super_container">

	<!-- Header -->

	<header class="header trans_300">

		<!-- Main Navigation -->

		<div class="main_nav_container">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-right">
						<div class="logo_container">
							<a href="<?php echo base_url(); ?>order">
								<img
									src="<?php echo base_url(); ?>public/uploads/logo/<?= $_SESSION['logo_filename'] ?>">
							</a>
						</div>
						<nav class="navbar">
							<ul class="navbar_user">
								<li class="checkout">
									<a href="<?php echo base_url(); ?>order/checkout">
										<i class="fa fa-shopping-cart" aria-hidden="true"></i>
										<span id="checkout_items"
											  class="checkout_items"><?php if (isset($_SESSION['carrito'])) {
												echo sizeof($_SESSION['carrito']);
											} else {
												echo "0";
											} ?></span>
									</a>
								</li>
								<li class="verCarrito">
									<a href="<?php echo base_url(); ?>order/checkout">
										<span class="btn btn-warning" style="color:#000000">Finalizar Compra</span>
									</a>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</header>

	<!-- Content -->
	<!-- Slider -->
	<div style="height:60px">
	</div>
	<!-- New Arrivals -->

	<?php if (isset($page) && $page != '') {
		include $page . '.php';
	} else {
		echo $output;
	} ?>


	<!-- Benefit -->

	<div class="benefit">
		<div class="container">
			<div class="row benefit_row">
				<div class="col-lg-3 benefit_col">
					<div class="benefit_item d-flex flex-row align-items-center">
						<div class="benefit_icon"><i class="fa fa-motorcycle" aria-hidden="true"></i></div>
						<div class="benefit_content">
							<h6>Costo de Envío</h6>
							<p>S/ <?= $_SESSION['precio_delivery'] ?> en todos sus pedidos</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 benefit_col">
					<div class="benefit_item d-flex flex-row align-items-center">
						<div class="benefit_icon"><i class="fa fa-money" aria-hidden="true"></i></div>
						<div class="benefit_content">
							<h6>Recibe y pague</h6>
							<p>cuando se entregue su pedido</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 benefit_col">
					<div class="benefit_item d-flex flex-row align-items-center">
						<div class="benefit_icon"><i class="fa fa-undo" aria-hidden="true"></i></div>
						<div class="benefit_content">
							<h6>Delivery Rápido</h6>
							<p>como se merece</p>
						</div>
					</div>
				</div>
				<div class="col-lg-3 benefit_col">
					<div class="benefit_item d-flex flex-row align-items-center">
						<div class="benefit_icon"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
						<div class="benefit_content">
							<h6>Horario de Reparto</h6>
							<p><?= $_SESSION['horario_entrada'] ?> - <?= $_SESSION['horario_salida'] ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<br>
<br>

	<!-- Footer -->

	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="footer_nav_container">
						<div class="cr">©2020 Todos los derechos reservados.</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>


<script src="<?php echo base_url(); ?>public/css/bootstrap4/popper.js"></script>
<script src="<?php echo base_url(); ?>public/css/bootstrap4/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>public/plugins/Isotope/isotope.js"></script>
<script src="<?php echo base_url(); ?>public/plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="<?php echo base_url(); ?>public/plugins/easing/easing.js"></script>
<script src="<?php echo base_url(); ?>public/js/custom.js"></script>
<script src="<?php echo base_url(); ?>public/js/sweetalert.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/toastr/toastr.js"></script>

<?php
if (isset($js_files)) {
	foreach ($js_files as $file) {
		$last_update = filemtime(str_replace(base_url(), "", $file));
		echo "<script src='$file?v=$last_update'></script>\n";
	}
}
?>

</body>

</html>
