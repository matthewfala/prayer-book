<?php
	require("../config/config.php");
	require "../config/dashguard.php";
?>
<?php
	// connect to db
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		$mysqli->close();
		exit();
	}

	// get circles
	$stmt = $mysqli->prepare("
			SELECT circle_id, name
			FROM circles
			ORDER BY priority ASC;
		");
	
	if (!$stmt->execute()) {
		echo $mysqli->error();
		$mysqli->close();
		exit();
	}
	$circles = $stmt->get_result();
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
				  			<input class="plastic depress" type="date" value="<?php echo date("Y-m-d") ?>" id="date" name="date" placeholder="date"><br><br>
						</div>
					</div>
					<div class="text-package">
						<div class="text-input">
							<label for="sphere">Sphere</label>
				  			<select class="plastic depress" id="sphere" name="sphere" placeholder="sphere">
				  				<?php while($circle = $circles->fetch_assoc()): ?>
					  					<option value="<?php echo $circle["circle_id"]?>" <?php if($circle["circle_id"] == 1) echo "selected" ?>><?php echo $circle["name"]?></option>
					  				<?php endwhile; ?>
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

			</div> <!-- #end .panel-content -->
		</div> <!-- #end .panel -->
	</div>
	<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

</body>
</html>
