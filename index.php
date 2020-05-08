<?php
	require("./config/config.php");

	// logged out
	if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"])
	{
		header("Location: ./login/login.php");
		exit();
	}

	// logged in
	else {

		// switch mode
		if (isset($_GET["change_mode"]) && ($_GET["change_mode"] == "all"	|| $_GET["change_mode"] == "recent"))
		{
			$_SESSION["view_mode"] = $_GET["change_mode"];
		}

		// resolve mode
		if (!isset($_SESSION["view_mode"]))
		{
			$_SESSION["view_mode"] = "all";
		}

		if ($_SESSION["view_mode"] == "all")
		{
			$baseheader = "Location: ./dashboard/book.php";
		}
		else {
			$baseheader = "Location: ./dashboard/book_recent.php";
		}

		//	window.location.href = "<?php echo "../index.php?delete_prayer" . GenerateRecoveryURL_and() . "&prayer_id=" . $_GET["prayer_id"] ";

		// delete prayer
		if (isset($_GET["delete_prayer"]) && $_GET["delete_prayer"] == "true") {
			if (isset($_GET["prayer_id"]) && is_numeric($_GET["prayer_id"])) {

				// connect to db
				$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
				if ($mysqli->connect_errno) {
					echo $mysqli->connect_error;
					$mysqli->close();
					exit();
				}

				$sql = "
				DELETE details
				FROM details
				INNER JOIN prayers
					ON details.detail_id = prayers.detail_id
				WHERE user_id=? AND prayer_id=?;
				";

				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param("ii", $_SESSION["user_id"], $_GET["prayer_id"]);

				if (!$stmt->execute()) {
					$mysqli->close();
					header($baseheader . "?delete_success=false" . GenerateRecoveryURL_and());
					exit();
				}

				if ($mysqli->affected_rows == 0) {
					$mysqli->close();
					header($baseheader . "?delete_success=false" . GenerateRecoveryURL_and());
					exit();
				}
				$mysqli->close();
				header($baseheader . "?delete_success=true" . GenerateRecoveryURL_and());
				exit();
			}
		}
		header($baseheader);
		exit();
	}
?>
<!DOCTYPE html>
<html>
<?php require('head.php')?>
<body>
	<?php require('header.php')?>
	<h1 class="title">PrayerBook UI Shell: 4 Pages</h1>
	<div class="panel">
		<a href="book.php">PrayerBook Dashboard</a>
		<a href="viewprayer.php">View Prayer</a>
		<a href="signup.php">Sign Up</a>
		<a href="login.php">Login</a>
	</div>
</body>
</html>