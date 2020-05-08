	
<?php if (isset($_GET["edit_success"]) && $_GET["edit_success"] == "true"): ?>
	<div class="toast">Successfully edited prayer</div>
<?php endif; ?>

<?php if (isset($_GET["delete_success"]) && $_GET["delete_success"] == "true"): ?>
	<div class="toast">Deleted prayer</div>
<?php endif; ?>

<?php if (isset($_GET["delete_success"]) && $_GET["delete_success"] == "false"): ?>
	<div class="toast">Delete failed</div>
<?php endif; ?>