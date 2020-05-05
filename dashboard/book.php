<?php
	require("../config/config.php");
?>

<!DOCTYPE html>
<html>
<?php require('../config/head.php')?>
<body>
	<?php require('header.php') ?>

	<div class="dashboard">
		<?php require('viewbar.php');
			ViewBar(true);
		?>

		<div class="panel">
			<div class="panel-header">
				<h1>All Prayers</h1>
				<a href="addprayer.php" class="panel-button plastic elevate btn-elevate">+</a>
			</div>
			<span class="panel-divider"><hr/></span>
			<div class="panel-content wide-content">
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
							<tr>
								<td>4/24/2020</td>
								<td>Short prayer</td>
								<td><ion-icon name="square-outline" class="check"></ion-icon></td>
								<td><div class="right-cell">me</div></td>
							</tr>
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
							<tr>
								<td>4/24/2020</td>
								<td>Short prayer</td>
								<td><ion-icon name="square-outline" class="check"></ion-icon></td>
								<td><div class="right-cell">me</div></td>
							</tr>
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
							<tr>
								<td>4/24/2020</td>
								<td>Short prayer</td>
								<td><ion-icon name="square-outline" class="check"></ion-icon></td>
								<td><div class="right-cell">me</div></td>
							</tr>
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
							<tr>
								<td>4/24/2020</td>
								<td>Short prayer</td>
								<td><ion-icon name="square-outline" class="check"></ion-icon></td>
								<td><div class="right-cell">me</div></td>
							</tr>
						</tbody>
					
					</table>
				</div>
			</div> <!-- #end .panel-content -->
		</div>
	</div>

	<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
</body>
</html>