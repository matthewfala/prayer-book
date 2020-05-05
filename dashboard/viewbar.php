
<?php

function ViewBar($isAll) {

	echo '<div class="viewbar">
		<a href="book.php" class="view-button plastic ' . ($isAll ? 'depress' : 'elevate btn-elevate') . '">
			<ion-icon name="infinite-outline"></ion-icon>
			<p>All</p>
			<div class="select-bar selected"></div>
		</a>
		<a href="book_recent.php" class="view-button plastic ' . ($isAll ? 'elevate btn-elevate' : 'depress') . '">
			<ion-icon name="time-outline"></ion-icon>
			<p>Recent</p>
			<div class="select-bar"></div>
		</a>
	</div>
	';
}
?>