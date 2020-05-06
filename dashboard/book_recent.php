<?php
	require "../config/config.php";
	require "../config/dashguard.php";
?>

<!DOCTYPE html>
<html>
<?php require('../config/head.php')?>
<body>
	<?php require('header.php') ?>

	<div class="dashboard">
		<?php require('viewbar.php') ?>

		<div class="panel">
			<div class="panel-header">
				<h1>Recent Prayers</h1>
				<a href="addprayer.php" class="panel-button plastic elevate btn-elevate">+</a>
			</div>
			<span class="panel-divider"><hr/></span>
			
			<div class="panel-content wide-content">
				
				<h3 class="prayer-section-title">Prayers for: Myself</h3>
				<div class="prayers plastic elevate">
					<table>
						<thead>
							<tr>
								<th class="th-date">Date</th>
								<th class="th-desc">Title</th>
								<th class="th-ans">Ans.</th>
								<th class="th-cir"><ion-icon name="list-circle-outline"></ion-icon></th>
							</tr>
						</thead>
						<tbody class="plastic depress">
							<tr class="prayer-row" onclick="window.location='viewprayer.php';">
								<td>4/24/2020</td>
								<td>Prayer for this app.</td>
								<td><ion-icon name="square-outline" class="check"></ion-icon></td>
								<td>me</td>
							</tr>
							<tr>
								<td>4/24/2020</td>
								<td>Prayer for vision.</td>
								<td><ion-icon name="square-outline" class="check"></ion-icon></td>
								<td><div class="right-cell">me</div></td>
							</tr>
							<tr>
								<td>4/24/2020</td>
								<td>A very long prayer title that takes up multiple lines.</td>
								<td><ion-icon name="square-outline" class="check"></ion-icon></td>
								<td><div class="right-cell">me</div></td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- end of prayers -->


				<h3 class="prayer-section-title">Prayers for: Family</h3>
				<div class="prayers plastic elevate">
					<table>
						<thead>
							<tr>
								<th class="th-date">Date</th>
								<th class="th-desc">Title</th>
								<th class="th-ans">Ans.</th>
								<th class="th-cir"><ion-icon name="list-circle-outline"></ion-icon></th>
							</tr>
						</thead>
						<tbody class="plastic depress">
							<tr>
								<td>4/24/2020</td>
								<td>Prayer for this app.</td>
								<td><ion-icon name="square-outline" class="check"></ion-icon></td>
								<td>me</td>
							</tr>
							<tr>
								<td>4/24/2020</td>
								<td>Prayer for vision.</td>
								<td><ion-icon name="square-outline" class="check"></ion-icon></td>
								<td><div class="right-cell">me</div></td>
							</tr>
							<tr>
								<td>4/24/2020</td>
								<td>A very long prayer title that takes up multiple lines.</td>
								<td><ion-icon name="square-outline" class="check"></ion-icon></td>
								<td><div class="right-cell">me</div></td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- end of prayers -->

				<h3 class="prayer-section-title">Prayers for: Church</h3>
				<div class="prayers plastic elevate">
					<table>
						<thead>
							<tr>
								<th class="th-date">Date</th>
								<th class="th-desc">Title</th>
								<th class="th-ans">Ans.</th>
								<th class="th-cir"><ion-icon name="list-circle-outline"></ion-icon></th>
							</tr>
						</thead>
						<tbody class="plastic depress">
							<tr>
								<td>4/24/2020</td>
								<td>Prayer for this app.</td>
								<td><ion-icon name="square-outline" class="check"></ion-icon></td>
								<td>me</td>
							</tr>
							<tr>
								<td>4/24/2020</td>
								<td>Prayer for vision.</td>
								<td><ion-icon name="square-outline" class="check"></ion-icon></td>
								<td><div class="right-cell">me</div></td>
							</tr>
							<tr>
								<td>4/24/2020</td>
								<td>A very long prayer title that takes up multiple lines.</td>
								<td><ion-icon name="square-outline" class="check"></ion-icon></td>
								<td><div class="right-cell">me</div></td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- end of prayers -->

			</div> <!-- #end .panel-content -->
		</div>
	</div>

	<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
</body>
</html>