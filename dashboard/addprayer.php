<?php
	require("../config/config.php");
?>

<!DOCTYPE html>
<html>
<?php require('../config/head.php')?>
<body>
	<?php require('header.php') ?>

	<div class="dashboard">
		<?php require('viewbar.php');?>

		<div class="panel add-prayer">
			<div class="panel-header">
				<h1>Add Prayer</h1>
			</div>
			<span class="panel-divider"><hr/></span>
			<div class="panel-content wide-content">
				<form action="addprayer_confirmation.php" method="post" class="input-form plastic elevate">
					<div class="text-package">
						<div class="text-input">
							<label for="title">Title</label>
				  			<input class="plastic depress" type="text" id="title" name="title" placeholder="title"><br><br>
						</div>
						<div class="text-input">
							<label for="date">Date</label>
				  			<input class="plastic depress" type="text" id="date" name="date" placeholder="date"><br><br>
						</div>
					</div>
					<div class="text-package">
						<div class="text-input">
							<label for="sphere">Sphere</label>
				  			<select class="plastic depress" id="sphere" name="sphere" placeholder="sphere">
				  				<option value="1" selected>Myself</option>
				  				<option value="2">Family</option>
				  				<option value="3">Church</option>
				  			</select><br><br>
						</div>
						<div class="text-input">
							<label for="decription">Description</label>
				  			<textarea id="decription" name="description" class="plastic depress" rows="10" cols="40" placeholder="What am I praying about..."></textarea>
						</div>
					</div>
					<div class="button-slot">
						<input type="submit" value="Log Prayer" class="glazed-plastic plastic elevate btn-elevate">
						<p class="error-message">Error message</p>
						<a href="../index.php" class="link-form-button glazed-plastic plastic elevate btn-elevate">Back</a>
					</div>
				</form>
				<br/>
				<div class="mega-image dashboard-image"></div>

			</div>

		</div>
	</div>
	<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

</body>
</html>
