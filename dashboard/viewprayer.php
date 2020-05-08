<?php
require '../config/config.php';
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

	// handle updates
	if (isset($_POST["update_prayer"]) && !empty($_POST["update_prayer"])) {
		if (isset($_POST["title"]) && !empty($_POST["title"])
			&& isset($_POST["date"]) && !empty($_POST["date"])
			&& isset($_POST["sphere"]) && !empty($_POST["sphere"]))
		{
			$answer_date_set = isset($_POST["answer_date"]) && !empty($_POST["answer_date"]) ? $_POST["answer_date"] : NULL;
			$answer_date_set = isset($_POST["answer"]) && !empty($_POST["answer"]) ? $_POST["answer"] : NULL;
			$answer_date_set = isset($_POST["description"]) && !empty($_POST["description"]) ? $_POST["description"] : NULL;

			$sql = "
			UPDATE prayers
			SET date = ?, answer_date = ?, title = ?, circle_id = ?
			WHERE user_id = ? AND prayer_id = ?;
			";

			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param("sssiii", $_POST["date"], $_POST["answer_date"], $_POST["title"], $_POST["sphere"], $_SESSION["user_id"], $_GET["prayer_id"]);

			if (!$stmt->execute()) {
				echo "Server error. Please try again.";
				$mysqli->close();
				exit();
			}

			$not_updated = ($mysqli->affected_rows == 0);

			$sql = "
			UPDATE details, prayers
			SET description = ?, answer_description = ?
			WHERE details.detail_id = prayers.detail_id AND user_id = ? AND prayer_id = ?;
			";

			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param("ssii", $_POST["description"], $_POST["answer"], $_SESSION["user_id"], $_GET["prayer_id"]);

			if (!$stmt->execute()) {
				echo "Server error. Please try again.";
				$mysqli->close();
				exit();
			}

			if ($not_updated && $mysqli->affected_rows == 0) {
				header("Location: editprayer.php?prayer_id=" . $_GET['prayer_id'] . "&edit_error=true" . GenerateRecoveryURL_and());
			}

			// redirect to self
			header("Location: ?prayer_id=" . $_GET['prayer_id'] . "&edit_success=true" . GenerateRecoveryURL_and());
		}
		else {
			header("Location: editprayer.php?prayer_id=" . $_GET['prayer_id'] . "&edit_error=true" . GenerateRecoveryURL_and());
		}
	}

	$sql = "
	SELECT date, answer_date, title, description, answer_description, circles.name AS circle
	FROM prayers
	LEFT JOIN details
		ON prayers.detail_id = details.detail_id
	LEFT JOIN circles
		ON prayers.circle_id = circles.circle_id
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
	}
	$mysqli->close();
}
?>
<!DOCTYPE html>
<html>
<?php require('../config/head.php')?>
<body>
	<?php require('header.php') ?>
	<div class="dashboard prayer-view">
		<?php require('viewbar.php') ?>

		<div class="panel">
			<div class="panel-header">
				<?php if (isset($error)): ?>
					<h1>Error</h1>
				<?php else: ?>
					<h1><?php echo $row["title"]?></h1>
				<?php endif; ?>
				<div class="panel-button plastic elevate minus-button btn-elevate"><p>-</p></div>
			</div>
			<span class="panel-divider"><hr/></span>

			<div class="panel-content">
				<?php if(isset($error)): ?>
					<h3 class="content-title"><?php echo $error ?></h3>
				<?php else: ?>
					<div class="content-area" />
						<div class="prayer-content">
							<h3 class="content-title">Circle: </h3>
							<p class="content-text"><?php echo $row["circle"]?></p>
						</div>

						<div class="prayer-content">
							<h3 class="content-title">Prayer: <?php 
							$date = new DateTime($row["date"]);
							echo $date->format("F d, Y")
							?></h3>
							<p class="content-text"><?php if (isset($row["description"]) && !empty($row["description"])) echo $row["description"]?></p>
						</div>

						<?php if((isset($row["answer_date"]) && !empty($row["answer_date"]))
							|| (isset($row["answer_description"]) && !empty($row["answer_description"]))): ?>
							<div class="prayer-content">
								<h3 class="content-title">
									<?php
									if (isset($row["answer_date"]) && !empty($row["answer_date"])){

										$date_ans = new DateTime($row["answer_date"]);
										echo "Answered: " .  $date_ans->format("F d, Y");
									}
									else if (isset($row["answer_description"]) && !empty($row["answer_description"]))
									{
										echo "Answer:";
									}
									?>
								</h3>
								<p class="content-text">
									<?php if (isset($row["answer_description"]) && !empty($row["answer_description"])) echo $row["answer_description"]?>
								</p>
							</div>
						</div> <!-- #end .content-area -->
					<?php endif; ?>
				<? endif; ?>

				<div class="button-pack">
					<?php
						$backurl = "../dashboard/";
						$backurl .= ($_SESSION["view_mode"] == "all") ? "book.php" : "book_recent.php";
					?>
					<button onclick="window.location.href='<?php echo $backurl . GenerateRecoveryURL() . "#prayer-" . $_GET["prayer_id"] ?>'" id="back-button" class="glazed-plastic plastic elevate btn-elevate content-button">Back</button>
					<?php if(!isset($error)): ?>
						<button onclick="window.location.href='<?php echo "editprayer.php?prayer_id=" . $_GET["prayer_id"] . GenerateRecoveryURL_and() ?>'" id="edit-button" class="glazed-plastic plastic elevate btn-elevate content-button">Edit</button>
					<?php endif; ?>
				</div>
			</div>
			<?php if (isset($_GET["edit_success"]) && $_GET["edit_success"] == "true"): ?>
				<div class="toast">Successfully edited prayer</div>
			<?php endif; ?>
		</div> <!-- #end .panel -->
	</div>

	<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
</body>
</html>
