<!DOCTYPE html>
<html>
<?php require('../config/head.php')?>
<body>
	<?php require('../dashboard/header.php') ?>

	<div class="mega-image" style=""></div>
	<div class="container signup">
		<h3 class="title">Signup</h3>
		<span class="panel-divider"><hr/></span>

		<form class="input-form plastic elevate">
			<div class="text-package">
				<div class="text-input">
					<label for="name">Name</label>
		  			<input class="plastic depress" type="text" id="name" name="name" placeholder="name">
				</div>
			</div>
			<div class="text-package" id="password-pair">
				<div class="text-input">
					<label for="password">Password</label>
		  			<input class="plastic depress" type="password" id="password" name="password" placeholder="password">
				</div>
				<div class="text-input">
					<label for="confirm">Retype Password</label>
		  			<input class="plastic depress" type="password" id="confirm" name="confirm" placeholder="retype password">
				</div>
			</div>
			<div class="button-slot">
				<input type="submit" value="Create Account" class="glazed-plastic plastic elevate btn">
				<p class="error-message">Error message</p>
			</div>
		</form>
	</div>
</body>
</html>