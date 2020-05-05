<?php

require '../config/config.php';

if (isset($_POST['email']) && !empty($_POST['email'])
	&& isset($_POST['password']) && !empty($_POST['password'])) {

	// validate user
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		$mysqli->close();
		exit();
	}

	// verify credentials
	$password = hash("sha256", $_POST["password"]);

	$sql = "
		SELECT user_id, name, email
		FROM users
		WHERE email = ? AND password = ?;
	";

	// get new user id
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("ss", $_POST["email"], $password);
	if (!$stmt->execute()) {
		echo "Server error. Please try again.";
		exit();
	}
	$res = $stmt->get_result();

	if ($res->num_rows > 0) {
		$row = $res->fetch_assoc();
		$_SESSION["logged_in"] = true;
		$_SESSION["user_id"] = $row["user_id"];
		$_SESSION["user_name"] = $row["name"];
		$_SESSION["user_email"] = $row["email"];
		header("Location: ../index.php");
	}
	else {
		$error = "Incorrect username or password.";
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

	<div class="mega-image"></div>
	<div class="container signup">
		<h3 class="title">Login</h3>
		<span class="panel-divider"><hr/></span>

		<form action="#" method="POST" class="input-form plastic elevate">
			<div class="text-package">
				<div class="text-input">
					<label for="email">Email</label>
		  			<input class="plastic depress" type="text" id="email" name="email" placeholder="email">
				</div>
			</div>
			<div class="text-package">
				<div class="text-input">
					<label for="password">Password</label>
		  			<input class="plastic depress" type="password" id="password" name="password" placeholder="password">
				</div>
			</div>
			<div class="button-slot">
				<input type="submit" value="Login" class="glazed-plastic plastic elevate btn-elevate">
				<?php if (isset($error)): ?>
					<p class="error-message"><?php echo $error ?></p>
				<?php endif; ?>
			</div>
		</form>
	</div>
</body>
</html>