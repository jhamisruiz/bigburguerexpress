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
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/single_styles.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/single_responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/datepicker3.css">
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
							<img src="<?= base_url(); ?>public/uploads/logo/<?= $_SESSION['logo_filename'] ?>">
						</div>
						<nav class="navbar">
							<ul class="navbar_menu">
								<li><a href="<?php echo base_url(); ?>pedidos">Pedidos</a></li>
								<li><a href="<?php echo base_url(); ?>productos">Productos</a></li>
								<li>
									<div class="btn-group">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Configuración</a>
											<div class="dropdown-menu">
												<a class="dropdown-item" href="<?php echo base_url(); ?>categorias">Categorías</a>
												<a class="dropdown-item" href="<?php echo base_url(); ?>atributos">Atributos</a>
												<a class="dropdown-item" href="<?php echo base_url(); ?>motorizados">Motorizados</a>
												<a class="dropdown-item" href="<?php echo base_url(); ?>usuarios">Usuarios</a>
												<a class="dropdown-item" href="<?php echo base_url(); ?>empresa">Empresa</a>
											</div>
									</div>
								</li>
								<li>
									<div class="btn-group">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reportes</a>
										  <div class="dropdown-menu">
										    <a class="dropdown-item" href="<?php echo base_url(); ?>reportes">Reporte Diario</a>
										    <a class="dropdown-item" href="<?php echo base_url(); ?>reportes/reportes_mensuales">Reporte Mensual</a>
										    <a class="dropdown-item" href="<?php echo base_url(); ?>reportes/reporte_anual">Reporte Anual</a>
										  </div>
									</div>
								</li>
							</ul>
							<ul class="navbar_user">
								<li><a href="<?php echo base_url(); ?>login/logout"><span class="salir" >Salir</span></a>
								</li>
							</ul>
							<div class="hamburger_container">
								<i class="fa fa-bars" aria-hidden="true"></i>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</div>

	</header>

	<div class="fs_menu_overlay"></div>
	<div class="hamburger_menu">
		<div class="hamburger_close"><i class="fa fa-times" aria-hidden="true"></i></div>
		<div class="hamburger_menu_content text-right">
			<ul class="menu_top_nav">
				<li class="menu_item"><a href="<?php echo base_url(); ?>pedidos">Pedidos</a></li>
				<li class="menu_item"><a href="<?php echo base_url(); ?>productos">Productos</a></li>
				<li class="menu_item"><a href="<?php echo base_url(); ?>categorias">Categorías</a></li>
				<li class="menu_item"><a href="<?php echo base_url(); ?>atributos">Atributos</a></li>
				<li class="menu_item"><a href="<?php echo base_url(); ?>motorizados">Motorizados</a></li>
				<li class="menu_item"><a href="<?php echo base_url(); ?>usuarios">Usuarios</a></li>
				<li class="menu_item"><a href="<?php echo base_url(); ?>empresa">Empresa</a></li>
				<li class="menu_item"><a href="<?php echo base_url(); ?>reportes">Reporte Diario</a></li>
				<li class="menu_item"><a href="<?php echo base_url(); ?>reportes/reportes_mensuales">Reporte Mensual</a></li>
				<li class="menu_item"><a href="<?php echo base_url(); ?>reportes/reporte_anual">Reporte Anual</a></li>
			</ul>
		</div>
	</div>

	<!-- Content -->

	<?php if (isset($page) && $page != '') {
		include $page . '.php';
	} else {
		echo $output;
	} ?>

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
<script src="<?php echo base_url(); ?>public/plugins/Isotope/isotope.pkgd.min.js"></script>
<script src="<?php echo base_url(); ?>public/plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="<?php echo base_url(); ?>public/plugins/easing/easing.js"></script>
<script src="<?php echo base_url(); ?>public/js/custom.js"></script>
<script src="<?php echo base_url(); ?>public/js/sweetalert.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/toastr/toastr.js"></script>
<script src="<?php echo base_url(); ?>public/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>public/js/datepicker-active.js"></script>

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
