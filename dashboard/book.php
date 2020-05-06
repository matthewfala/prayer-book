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

	// recover params from url
	$page = (isset($_GET["page"]) && is_numeric($_GET["page"])) ? $_GET["page"] : 1;
	$search = (isset($_GET["search"]) && !empty($_GET["search"])) ? $_GET["search"] : "";
	$search_like = "%" . $search . "%";

	// assess page limits
	$limit_start = ($page - 1) * PRAYERS_PER_PAGE;
	$limit_count = PRAYERS_PER_PAGE;

	// count prayers
	$sql = "
	SELECT COUNT(prayer_id) AS count
	FROM prayers
	WHERE user_id = " . $_SESSION["user_id"] . ";";

	$results = $mysqli->query($sql);
	if (!$results) {
		echo $mysqli->error;
		exit();
	}

	// count pages
	$row = $results->fetch_assoc();
	$count = $row["count"];

	$dashboard_empty = false;
	if ($count == 0)
	{
		$dashboard_empty = true;
	}
	else
	{
		$pages = ceil($count / PRAYERS_PER_PAGE);

		

		$sql = "
		SELECT prayer_id, date, title, answer_date, circles.name AS circle_abbrev
		FROM prayers
		LEFT JOIN circles
			ON circles.circle_id = prayers.circle_id
		WHERE user_id = " . $_SESSION["user_id"] . "
		AND (title LIKE ?)
		LIMIT ?, ?;";

		

		$stmt = $mysqli->prepare($sql);

		$stmt->bind_param("sii", $search_like, $limit_start, $limit_count);
		if (!$stmt->execute()) {
			echo $mysqli->error;
			$mysqli->close();
			exit();
		}
		$page_results = $stmt->get_result();
		$search_empty = false;
		if($page_results->num_rows == 0) {
			$search_empty = true;
		}
	}

	$mysqli->close();
?>

<!DOCTYPE html>
<html>
<?php require('../config/head.php')?>
<body>
	<?php require('header.php') ?>

	<div class="dashboard">
		<?php require('viewbar.php'); ?>

		<div class="panel">
			<div class="panel-header">
				<h1>All Prayers</h1>
				<a href="addprayer.php" class="panel-button plastic elevate btn-elevate">+</a>
			</div>
			<span class="panel-divider"><hr/></span>
			<div class="panel-content wide-content">
				<div class="panel-content-header">
					
					<div class="search-bar-holder">
						<ion-icon class="search-icon" name="search-circle-outline"></ion-icon>
		  				<input class="plastic depress search-bar" type="text" id="search-bar" name="search" placeholder="Search">
		  			</div>
		  	
				</div>
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
							<?php while($row = $page_results->fetch_assoc()): ?>
								<tr id="<?php echo "prayer-" . $row["prayer_id"]?>" class="prayer-row" onclick="window.location='viewprayer.php?prayer_id=<?php echo $row["prayer_id"] ?>';">
									<td><?php echo $row["date"] ?></td>
									<td><?php echo $row["title"] ?></td>
									<td>
										<?php if($row["answer_date"] == NULL): ?>
											<ion-icon name="square-outline" class="check"></ion-icon>
										<?php else: ?>
											<ion-icon name="checkbox-outline"></ion-icon>
										<? endif; ?>
									</td>
									<td><div class="right-cell"><?php echo $row["circle_abbrev"] ?></div></td>
								</tr>
							<?php endwhile; ?>
						</tbody>
					
					</table>
				</div>
				<div class="centered">
					<div class="page-links">
						<div class="links">
							Page: 
							<?php for ($pageNum = 1; $pageNum <= $pages; ++$pageNum): ?>
								<?php if ($pageNum == $page): ?><span class="link-hgt"><?php endif;?>
								<a href="?page=<?php echo $pageNum ?>"><?php echo $pageNum ?><?php if ($pageNum == $page): ?></span><?php endif;?></a><?php if ($pageNum != $pages): ?>,
								<?php endif; ?>
							<?php endfor; ?>
						</div>
						<span class="panel-divider"><hr/></span>
					</div>
				</div>
				<div class="perpage-select">
					<p>Showing </p>
					<div class="text-input">
						<select class="plastic depress">
							<option value="5">5</option>
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>
						</select>
					</div>
					<p> prayers per page </p>
				</div>


			</div> <!-- #end .panel-content -->
		</div>
	</div>
	<script>
		document.querySelector("#search-bar").addEventListener("change", (e)=>{
			window.location.href="?page=1&search=" + e.target.value
		});
	</script>
	<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
</body>
</html>