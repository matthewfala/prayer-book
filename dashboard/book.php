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

	// init session
	if (!isset($_SESSION["perpage"])) {
		$_SESSION["perpage"] = PRAYERS_PER_PAGE;
	}

	// recover params from url
	$page = (isset($_GET["page"]) && is_numeric($_GET["page"])) ? $_GET["page"] : 1;
	$search = (isset($_GET["search"]) && !empty($_GET["search"])) ? $_GET["search"] : "";
	$search_like = "%" . $search . "%";
	$perpage = $_SESSION["perpage"];

	// update session
	if (isset($_GET["perpage"]) && is_numeric($_GET["perpage"]))
	{
		$_SESSION["perpage"] = $_GET["perpage"];
		$perpage = $_SESSION["perpage"];
	}

	// count prayers
	$sql = "
		SELECT COUNT(prayer_id) AS count
		FROM prayers
		WHERE user_id = " . $_SESSION["user_id"] . "
		AND (title LIKE ?)";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("s", $search_like);
	if (!$stmt->execute()) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}
	$results = $stmt->get_result();
	$row = $results->fetch_assoc();
	$count = $row["count"];

	// get persist tag
	$persist_tag = "";
	if (isset($_GET["page"]) && !empty($_GET["page"])) {
		$persist_tag .= "page=" . $_GET["page"] . "&";
	}
	$search_on = false;
	if (isset($_GET["search"]) && !empty($_GET["search"])) {
		$persist_tag .= "search=" . $_GET["search"] . "&";
		$search_on = true;
	}

	$dashboard_empty = false;
	if ($count == 0)
	{
		$dashboard_empty = true;
	}
	else
	{
		// count pages
		$pages = ceil($count / $perpage);

		// assess page limits
		$limit_start = ($page - 1) * $perpage;
		$limit_count = $perpage;

		$sql = "
		SELECT prayer_id, date, title, answer_date, circles.name AS circle_abbrev
		FROM prayers
		LEFT JOIN circles
			ON circles.circle_id = prayers.circle_id
		WHERE user_id = " . $_SESSION["user_id"] . "
		AND (title LIKE ?)
		ORDER BY date DESC, prayer_id DESC
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

				<?php if($dashboard_empty && !isset($_GET["search"])): ?>

				<?php else: ?>

					<div class="panel-content-header">
						
						<div class="search-bar-holder">
							<ion-icon class="search-icon" name="search-circle-outline"></ion-icon>
			  				<input value="<?php echo $search ?>" class="plastic depress search-bar" type="text" id="search-bar" name="search" placeholder="Search">
			  			</div>
			  	
					</div>

					<?php if($dashboard_empty): ?>
						<h5 class="no-results">No results.</h5>
					<?php else: ?>
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
										<tr id="<?php echo "prayer-" . $row["prayer_id"]?>" class="prayer-row" onclick="window.location.href='viewprayer.php?<?php 
											echo $persist_tag . "prayer_id=" . $row["prayer_id"];
											?>';">
											<td><?php 
												$date_form = new DateTime($row["date"]);
												echo $date_form->format("n/j/Y")
											?></td>
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
										<a href="?page=<?php
										echo $pageNum;
										if ($search_on) {
											echo "&search=" . $search;
										}
										?>"><?php echo $pageNum ?><?php if ($pageNum == $page): ?></span><?php endif;?></a><?php if ($pageNum != $pages): ?>,
										<?php endif; ?>
									<?php endfor; ?>
								</div>
								<span class="panel-divider"><hr/></span>
							</div>
						</div>
					<?php endif; ?>
					<div class="perpage-select">
						<p>Showing </p>
						<div class="text-input">
							<select id="perpage-select" class="plastic depress">
								<? foreach (PERPAGE_OPTIONS as $val): ?>
									<option value="<?php echo $val?>" <?php if ($val==$perpage) echo "selected"?>><?php echo $val?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<p> prayers per page </p>
					</div>

				<?php endif ?> <!-- Not dashboard empty !-->
			</div> <!-- #end .panel-content -->
			<?php require "../config/widgets.php" ?>
		</div>
	</div>
	<script>
		document.querySelector("#search-bar").addEventListener("change", (e)=>{
			window.location.href="?page=1&search=" + e.target.value
		});

		document.querySelector("#perpage-select").addEventListener("change", (e)=>{
			window.location.href="?perpage="
			+ e.target.value
			+ "&page=<?php
				echo $page . (isset($_GET["search"]) ? "search=".$search : "")
				?>"
		});
	</script>
	<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
</body>
</html>
