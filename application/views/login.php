<!DOCTYPE html>
<html lang="en">
<head>
	<title>Iniciar Sesión</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>public/images/logo/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/plugins/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/plugins/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/plugins/login/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/plugins/login/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/plugins/login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/plugins/login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/plugins/login/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/plugins/login/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/plugins/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/plugins/login/css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100" style="background-image:  url('<?php echo base_url(); ?>public/images/logo/fondo.jpg');">
			<div class="wrap-login100 p-t-85 p-b-20">
				<form class="login100-form validate-form" method="POST" action="#">
					<span class="login100-form-title p-b-70">
						Acceso al Sistema
								<?php
								$mensaje=$this->session->flashdata('mensaje');
								if(isset($mensaje)){ ?>
										<center><span style="color:red; font-size: 12px; font-weight: 700; font-style: italic; }"><?php echo $mensaje ?></span></center>
								<?php
										}
								?>
					<div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate = "Ingrese su Email">
						<input class="input100" type="email" name="email" id="email">
						<span class="focus-input100" data-placeholder="Correo Electrónico"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-50" data-validate="Ingrese su Contraseña">
						<input class="input100" type="password" name="password" id="password">
						<span class="focus-input100" data-placeholder="Contraseña"></span>
					</div>

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							Ingresar
						</button>
					</div>

					<ul class="login-more p-t-190">
						<li class="m-b-8">
							<span class="txt1">
								Recupera tu contraseña
							</span>

							<a href="#" class="txt2">
							<strong>AQUÍ</strong>
							</a>
						</li>
					</ul>
				</form>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>public/plugins/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>public/plugins/login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>public/plugins/login/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo base_url(); ?>public/plugins/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>public/plugins/login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>public/plugins/login/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>public/plugins/login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>public/plugins/login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>public/plugins/login/js/main.js"></script>

</body>
</html>
