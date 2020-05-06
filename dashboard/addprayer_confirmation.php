<?php

require '../config/config.php';

if ( !isset($_POST['title']) || empty($_POST['title'])
	|| !isset($_POST['date']) || empty($_POST['date'])
	|| !isset($_POST['sphere']) || empty($_POST['sphere'])
) {
	$error = "Please fill out all required fields.";
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
	INSERT INTO details(description)
	VALUES(?);
	";
	$stmt = $mysqli->prepare($sql);
	$description = ((isset($_POST["description"]) && !empty($_POST["description"])) ? $_POST["description"] : NULL);
	$stmt->bind_param("s", $description);

	if (!$stmt->execute()) {
		echo "Server error. Please try again.";
		$mysqli->close();
		exit();
	}

	$details_id = $stmt->insert_id;

	// check if user is already in DB
	$sql = "
	INSERT INTO prayers(date, title, detail_id, circle_id, user_id)
	VALUES(?, ?, ?, ?, ?);
	";

	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ssiii", $_POST["date"],
		$_POST["title"],
		$details_id,
		$_POST["sphere"],
		$_SESSION["user_id"]);
	if (!$stmt->execute()) {
		echo $mysqli->error;
		echo "Server error. Please try again later.";
		$mysqli->close();
		exit();
	}
	if ($mysqli->affected_rows == 0) {
		$error = "There was a problem adding your prayer, please try again.";
	}

	// Close credentials
	$mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<?php require('../config/head.php')?>
<body>
	<?php require('../dashboard/header.php') ?>

	<div class="mega-image" style=""></div>
	<div class="container signup">
		<h3 class="title">Signup</h3>
		<span class="panel-divider"><hr/></span>

		<div class="confirmation-content plastic elevate">
			<?php if (!isset($error)): ?>
				<div class="text-package">
					<p>Successfully added prayer, <?php echo $_POST["title"]?>, to book.</p>
				</div>
				<div class="button-slot">
					<a href="../index.php" class="glazed-plastic plastic elevate btn-elevate">Back to Dashboard</a>
				</div>
			<?php else: ?>
				<div class="text-package">
					<p><?php echo $error ?></p>
				</div>
				<div class="button-slot">
					<a href="./addprayer.php" class="glazed-plastic plastic elevate btn-elevate">Try Again</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</body>
</html>