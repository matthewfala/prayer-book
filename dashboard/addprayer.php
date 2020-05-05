<!DOCTYPE html>
<html>
<?php require('../config/head.php')?>
<body>
	<?php require('header.php') ?>

	<div class="mega-image"></div>
	<div class="container addprayer">
		<h3 class="title">Add Prayer</h3>
		<span class="panel-divider"><hr/></span>
		<form class="input-form plastic elevate">
			<div class="text-package">
				<div class="text-input">
					<label for="title">Title</label>
		  			<input class="plastic depress" type="text" id="title" name="title" placeholder="title"><br><br>
				</div>
				<div class="text-input">
					<label for="Date">Date</label>
		  			<input class="plastic depress" type="text" id="date" name="date" placeholder="date"><br><br>
				</div>
			</div>
			<div class="text-package">
				<div class="text-input">
					<label for="sphere">Sphere</label>
		  			<input class="plastic depress" type="text" id="sphere" name="sphere" placeholder="sphere"><br><br>
				</div>
				<div class="text-input">
					<label for="decription">Description</label>
		  			<textarea id="decription" name="description" class="plastic depress" rows="10" cols="40" placeholder="What am I praying about..."></textarea>
				</div>
			</div>
			<div class="button-slot">
				<input type="submit" value="Log Prayer" class="glazed-plastic plastic elevate btn-elevate">
				<p class="error-message">Error message</p>
				<input type="submit" value="Back" class="glazed-plastic plastic elevate btn-elevate">
			</div>
		</form>
	</div>
</body>
</html>
