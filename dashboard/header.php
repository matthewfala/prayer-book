<div id="header">
	<div class="naming">
		<div class="icon">
			<img src="../images/logo.svg" />
		</div>
		<h1>Prayer Book</h1>
	</div>

	<?php if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]): ?>
	
		<div class="toolbar">
			<a href="./signup.php" class="tool-link">Sign Up</a>
			<a href="./login.php" class="tool-link">Login</a>
		</div>

	<?php else: ?>
		<div class="toolbar">
			<a class="tool-link">Logout</a>
		</div>
	<?php endif; ?>

</div>