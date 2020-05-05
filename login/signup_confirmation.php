<?php

require '../config/config.php';

if ( !isset($_POST['email']) || empty($_POST['email'])
	|| !isset($_POST['name']) || empty($_POST['name'])
	|| !isset($_POST['password']) || empty($_POST['password']) ) {
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

	// check if user is already in DB
	$sql_registered = "
	SELECT * FROM users
	WHERE email = ?;";

	$stmt = $mysqli->prepare($sql_registered);
	$stmt->bind_param("s", $_POST["email"]);
	if (!$stmt->execute()) {
		echo "Server error. Please try again later.";
		$mysqli->close();
		exit();
	};

	$res = $stmt->get_result();
	if ($res->num_rows > 0) {
		$error = $_POST["email"] . " is already in use. Please sign up with a different account.";
	}
	else {
		// Hash the password
		$password = hash("sha256", $_POST["password"]);

		// Add a new user: insert into the users table.
		$sql = "
			INSERT INTO users(name, email, password)
			VALUES(?, ?, ?);
		";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("sss", $_POST["name"], $_POST["email"], $password);
		if (!$stmt->execute()) {
			echo "Server error. Please try again later.";
			exit();
		}
		if ($stmt->affected_rows == 0) {
			$error = "Server error. Please try again.";
		}

		// save credentials
		if (!isset($error)) {

			$sql = "
				SELECT user_id, name, email
				FROM users
				WHERE email = ?;
			";

			// get new user id
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param("s", $_POST["email"]);
			if (!$stmt->execute()) {
				echo "Server error. Please try again later.";
				exit();
			}
			$res = $stmt->get_result();
			$row = $res->fetch_assoc();

			$_SESSION["logged_in"] = true;
			$_SESSION["user_id"] = $row["user_id"];
			$_SESSION["user_name"] = $row["name"];
			$_SESSION["user_email"] = $row["email"];
		}
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
					<p>Welcome to your new Prayerbook, <?php echo $_POST["name"]?>.</p>
				</div>
				<div class="button-slot">
					<a href="../index.php" class="glazed-plastic plastic elevate btn-elevate">Go to Dashboard</a>
				</div>
			<?php else: ?>
				<div class="text-package">
					<p><?php echo $error ?></p>
				</div>
				<div class="button-slot">
					<a href="./signup.php" class="glazed-plastic plastic elevate btn-elevate">Try Again</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</body>
</html>