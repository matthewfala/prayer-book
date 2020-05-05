<div id="header">
	<a href="../index.php" class="naming">
		<div class="icon">
			<img src="../images/logo.svg" />
		</div>
		<h1>Prayer Book</h1>
	</a>

	<?php if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]): ?>
	
		<div class="toolbar">
			<a href="../login/signup.php" class="tool-link">Sign Up</a>
			<a href="../login/login.php" class="tool-link">Login</a>
		</div>

	<?php else: ?>
		<div class="toolbar">
			<a href="../login/logout.php" class="tool-link">Logout</a>
		</div>
	<?php endif; ?>

</div>