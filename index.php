<?php
	require("./config/config.php");

	// logged out
	if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"])
	{
		header("Location: ./login/login.php");
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
			header("Location: ./dashboard/book.php");
		}
		else {
			header("Location: ./dashboard/book_recent.php");
		}
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