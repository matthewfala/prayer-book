
<!DOCTYPE html>
<html>
<?php require('../config/head.php')?>
<body>
	<?php require('header.php') ?>
	<div class="dashboard prayer-view">
		<?php require('viewbar.php') ?>

		<div class="panel">
			<div class="panel-header">
				<h1>Prayer Title</h1>
				<div class="panel-button plastic elevate minus-button btn-elevate"><p>-</p></div>
			</div>
			<span class="panel-divider"><hr/></span>

			<div class="panel-content">
				<div class="prayer-content">
					<h3 class="content-title">Description</h3>
					<p class="content-text">Lorem ip-sum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</p>
				</div>

				<div class="content">
					<h3 class="content-title">Answered: March 12, 2020</h3>
					<p class="content-text">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
				</div>

				<div class="button-pack">
					<button id="back-button" class="glazed-plastic plastic elevate btn-elevate content-button">Back</button>
					<button id="edit-button" class="glazed-plastic plastic elevate btn-elevate content-button">Edit</button>
				</div>
			</div>
		</div>
	</div>
	<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
</body>
</html>
