<?php
	session_start();
	session_destroy();
?>
<!DOCTYPE html>
<html>
<?php require('../config/head.php')?>
<body>
	<?php require('../dashboard/header.php') ?>

	<div class="mega-image" style=""></div>
	<div class="container signup">
		<h3 class="title">Logout</h3>
		<span class="panel-divider"><hr/></span>

		<div class="confirmation-content plastic elevate">
			<div class="text-package">
				<p>Prayerbook locked. You are now logged out.</p>
			</div>
			<div class="button-slot">
				<a href="../index.php" class="glazed-plastic plastic elevate btn-elevate">Login</a>
			</div>
		</div>
	</div>
</body>
</html>