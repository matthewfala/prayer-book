<?php
	if (!isset($_SESSION["user_id"]))
	{
		header("Location: ../index.php");
		exit();
	}
	if (!isset($_SESSION["view_mode"]))
	{
		$_SESSION["view_mode"] = "all";
	}
?>