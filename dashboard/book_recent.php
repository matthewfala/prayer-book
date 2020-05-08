<?php
	require "../config/config.php";
	require "../config/dashguard.php";

	// Recover prayers
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ($mysqli->connect_errno) {
		echo $mysqli->connect_error;
		$mysqli->close();
		exit();
	}

	// Get spheres
	$sql = "
		SELECT circle_id, name, priority
		FROM circles
		ORDER BY priority ASC;
	";

	$res = $mysqli->query($sql);
	if (!$res) 
	{
		echo $mysqli->error;
		exit();
	}

	// Get prayers per sphere
	$prayerCircles = array();

	while ($circle_row = $res->fetch_assoc())
	{
		$sql = "
		SELECT prayer_id, date, title, answer_date
		FROM prayers
		WHERE user_id = " . $_SESSION["user_id"] . "
		AND circle_id = " . $circle_row["circle_id"] . "
		AND date > ?
		ORDER BY date ASC;";

		$stmt = $mysqli->prepare($sql);

		$date_start = new DateTime();
		date_sub($date_start,date_interval_create_from_date_string(DEFAULT_TIMESPAN_DAYS . " days"));

		$date_start_str = $date_start->format("Y-m-d H:i:s");
		$stmt->bind_param("s", $date_start_str);
		if (!$stmt->execute()) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}
		$results = $stmt->get_result();
		if($results->num_rows == 0) {
			array_push($prayerCircles, array(
				"circle_empty" => true,
				"circle_name" => $circle_row["name"],
			));
		}
		else {
			$circle = array(
				"circle_empty" => false,
				"circle_name" => $circle_row["name"],
				"contents" => array(),
			);

			// fill circle
			while ($prayer_row = $results->fetch_assoc()) {
				array_push($circle["contents"], $prayer_row);
			}
			array_push($prayerCircles, $circle);
		}
	}

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
				<?php foreach($prayerCircles as $circ): ?>
					<h3 class="prayer-section-title">Prayers for: <?php echo $circ["circle_name"] ?></h3>
					<?php if ($circ["circle_empty"]): ?>
						<span class="panel-divider"><hr/></span>
					<?php else: ?>
						<div class="prayers plastic elevate">
							<table>
								<thead>
									<tr>
										<th class="th-date">Date</th>
										<th class="th-desc">Title</th>
										<th class="th-ans">Ans.</th>
									</tr>
								</thead>
								<tbody class="plastic depress">
									<?php foreach($circ["contents"] as $row): ?>
										<tr id="<?php echo "prayer-" . $row["prayer_id"]?>" class="prayer-row" onclick="window.location.href='viewprayer.php?<?php 
											echo "prayer_id=" . $row["prayer_id"];
											?>';">
											<td><?php echo $row["date"] ?></td>
											<td><?php echo $row["title"] ?></td>
											<td>
												<?php if($row["answer_date"] == NULL): ?>
													<ion-icon name="square-outline" class="check"></ion-icon>
												<?php else: ?>
													<ion-icon name="checkbox-outline"></ion-icon>
												<? endif; ?>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
				<!-- end of prayers -->
			</div> <!-- #end .panel-content -->
			<?php require "../config/widgets.php" ?>
		</div>
	</div>
	<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
</body>
</html>