<div class="viewbar">
	<a href="../index.php?change_mode=all" class="view-button plastic <?php echo (($_SESSION["view_mode"] == "all") ? 'depress' : 'elevate btn-elevate') ?> ">
		<ion-icon name="infinite-outline"></ion-icon>
		<p>All</p>
		<div class="select-bar  <?php if ($_SESSION["view_mode"] == "all") echo 'selected' ?>"></div>
	</a>
	<a href="../index.php?change_mode=recent" class="view-button plastic <?php echo (($_SESSION["view_mode"] == "all") ? 'elevate btn-elevate' : 'depress') ?>">
		<ion-icon name="time-outline"></ion-icon>
		<p>Recent</p>
		<div class="select-bar <?php if ($_SESSION["view_mode"] == "recent") echo 'selected' ?>"></div>
	</a>
</div>