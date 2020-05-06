<?php
require '../config/config.php';

if ( !isset($_GET['prayer_id']) || empty($_GET['prayer_id']) || !is_numeric($_GET['prayer_id']))
{
	$error = "Invalid prayer id. Please go back and select prayer again.";
}

else {
	// Store user in the database!!!
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		$mysqli->close();
		exit();
	}

	$sql = "
	SELECT date, answer_date, title, description, answer_description, circles.name
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
	if ($stmt->num_rows != 0) {
		$error = "Invalid prayer id. It seems like this is someone else's prayer.";
	}
	else {
		$res = $stmt->get_result();
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
								?>
							</h3>
							<p class="content-text">
								<?php if (isset($row["answer_description"]) && !empty($row["answer_description"])) echo $row["answer_description"]?>
							</p>
						</div>
					<?php endif; ?>
				<? endif; ?>

				<div class="button-pack">
					<?php 
						$backurl = "../dashboard/";
						$backurl .= ($_SESSION["view_mode"] == "all") ? "book.php" : "book_recent.php";

						if ($_SESSION["view_mode"] == "all")
						{
							if (isset($_GET["page"]) || isset($_GET["search"]))
							{
								$backurl .= "?";
							}

							if (isset($_GET["page"])) {
								$backurl .= "page=" . $_GET["page"];
								if (isset($_GET["search"]))
								{
									$backurl .= "&";
								}
							}

							if (isset($_GET["search"])) {
								$backurl .= "search=" . $_GET["search"];
							}
						}

						if (isset($_GET["prayer_id"]) && !empty($_GET["prayer_id"])) {
							$backurl .= "#prayer-" . $_GET["prayer_id"];
						}
					?>
					<button onclick="window.location.href='<?php echo $backurl ?>'" id="back-button" class="glazed-plastic plastic elevate btn-elevate content-button">Back</button>
					<button id="edit-button" class="glazed-plastic plastic elevate btn-elevate content-button">Edit</button>
				</div>
			</div>
		</div>
	</div>
	<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
</body>
</html>
