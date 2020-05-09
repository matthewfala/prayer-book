<?php
	require("../config/config.php");
	require "../config/dashguard.php";

	if ( !isset($_GET['prayer_id']) || empty($_GET['prayer_id']) || !is_numeric($_GET['prayer_id']))
	{
		$error = "Invalid prayer id. Please go back and select prayer again.";
	}

	else {
		// connect to db
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ($mysqli->connect_errno) {
			echo $mysqli->connect_error;
			$mysqli->close();
			exit();
		}

		$sql = "
		SELECT date, answer_date, title, description, answer_description, circle_id
		FROM prayers
		LEFT JOIN details
			ON prayers.detail_id = details.detail_id
		WHERE prayer_id = ? AND user_id = " . $_SESSION["user_id"] . ";";

		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("i", $_GET['prayer_id']);

		if (!$stmt->execute()) {
			echo "Server error. Please try again.";
			$mysqli->close();
			exit();
		}
		$res = $stmt->get_result();
		if ($res->num_rows == 0) {
			$error = "Invalid prayer id. It seems like this is someone else's prayer.";
		}
		else {
			$row = $res->fetch_assoc();

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
		}
		$mysqli->close();
	}
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
				<?php if (isset($error)): ?>
					<h1>Error</h1>
				<?php else: ?>
					<h1>Edit Prayer</h1>
				<?php endif; ?>
				<div class="panel-button plastic elevate minus-button btn-elevate"><p>-</p></div>
			</div>
			<span class="panel-divider"><hr/></span>
			<div class="panel-content wide-content">
				<?php if(isset($error)): ?>
					<h3 class="content-title"><?php echo $error ?></h3>
				<?php else: ?>
					<form action="viewprayer.php?prayer_id=<?php echo $_GET["prayer_id"] . GenerateRecoveryURL_and() ?>" method="post" class="validate-submit input-form plastic elevate">
						<div class="text-package">
							<div class="text-input">
								<label for="title">Title</label>
					  			<input value="<?php echo $row["title"]?>" class="required-input plastic depress" type="text" id="title" name="title" placeholder="title">
							</div>
							<div class="text-input">
								<label for="date">Date</label>
					  			<input class="required-input plastic depress" type="date" value="<?php
					  				$date = new DateTime($row["date"]);
									echo $date->format("Y-m-d")
								?>" id="date" name="date">
							</div>
							<div class="text-input">
								<label for="date">Answer Date</label>
					  			<input class="plastic depress" type="date" <?php 
					  			if (isset($row["answer_date"]) && !empty($row["answer_date"])): ?>value="<?php
					  				$date = new DateTime($row["answer_date"]);
									echo $date->format("Y-m-d")
								?>"<?php endif; ?> id="answer-date" name="answer_date">
							</div>
							<div class="text-input">
								<label for="sphere">Sphere</label>
					  			<select class="plastic depress" id="sphere" name="sphere" placeholder="sphere">
					  				<?php while($circle = $circles->fetch_assoc()): ?>
					  					<option value="<?php echo $circle["circle_id"]?>" <?php if($circle["circle_id"] == $row["circle_id"]) echo "selected" ?>><?php echo $circle["name"]?></option>
					  				<?php endwhile; ?>
					  			</select>
							</div>
						</div>
						<div class="text-package">
							<div class="text-input">
								<label for="description">Description</label>
					  			<textarea id="description" name="description" class="plastic depress" rows="7" cols="40" placeholder="What am I praying about..."><?php echo $row["description"] ?></textarea>
							</div>
							<div class="text-input">
								<label for="answer">Answer</label>
					  			<textarea id="answer" name="answer" class="plastic depress" rows="7" cols="40" placeholder="How has God answered my prayer..."><?php if (isset($row["answer_description"]) && !empty($row["answer_description"])) echo $row["answer_description"] ?></textarea>
							</div>
						</div>
						<input type="hidden" name="update_prayer" value="true">
							
						<div class="button-slot edit-button-slot">
							<input type="submit" value="Update Prayer" class="glazed-plastic plastic elevate btn-elevate">
							<p class="error-message error-hidden">Error message</p>
							<a href="<?php echo "viewprayer.php?prayer_id=" . $_GET["prayer_id"] . GenerateRecoveryURL_and() ?>" class="link-form-button glazed-plastic plastic elevate btn-elevate">Back</a>
						</div>
					</form>
					<br/>
					<div class="mega-image dashboard-image"></div>
					<br/>
				<?php endif; ?>
				
			</div> <!-- #end .panel-content -->
		</div> <!-- #end .panel -->
	</div>

	<script src="../config/validator.js"></script>
	<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>

</body>
</html>
