<?php 

require 'Database/db_con.php';
	if(isset($_SESSION['sess_uid']))
	{
		$sesscustid  = $_SESSION["sess_uid"];
		if(substr($sesscustid,0,1)== "C")
		{
			header('Location: user_profile.php');
		}
		else if (substr($sesscustid,0,1)== "A")
		{
			header('Location: admin_profile.php');
		}
		else if (substr($sesscustid,0,1)== "Q")
		{
			header('Location: index.php');
		}
	}
	else
	{
		header('Location: index.php');
	}

$sessstaffid = $_SESSION["sess_uid"];

$sql_staff	  = "SELECT * from staff where STAFF_ID = '$sessstaffid'";
$result_staff = mysqli_query($conn, $sql_staff);
$row 		  = mysqli_fetch_assoc($result_staff);

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>View Announcement | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/viewannouncement.css" rel="stylesheet" type="text/css">
		<link href="css-folder/filter.css" rel="stylesheet" type="text/css">
	</head>

	<body>
    	<div id="container">
			<?php
				include 'include/header.php';
			?>
			
			<div id="content">
				<div id="content-wrapper">
					<?php include 'include/leftnavi.php'; ?>
					<div id="viewannouncement-wrapper">
						<div id="viewannouncement-wrapper-title">
							<p>View Announcement</p>
						</div>
						<div id="viewschedule-wrapper-button">
							<div class="links">
								<div id="filter-popups">
									<p><a href="#schedulefilter" data-effect="mfp-zoom-out" class="filter-button">Filter</a></p>
								</div>
							</div>
						</div>
						<hr/>
						<div id="schedulefilter" class="filter-popup mfp-with-anim mfp-hide">
							<div id="top-filter">
								<div id="content-left">
									<form name="filterfrm" method="get" action="">
										<div id="content-left-title"><p>Filter</p></div>
											<div id="content-left-content-form">
												<div id="content-left-content-form-top">
													<div id="content-left-content-form-top-content">
														<p>Announcement Date</p>
														<input type="date" name="ann_id" value=""/>
													</div>
												</div>
												<input type="submit" name="filter" value="Filter"/>
											</div>
									</form>
								</div>
							</div>
						</div>
						<div id="viewannouncement-table">
							<table width="770px">
								<tr>
									<th height="40px" width="140px">Announcement ID</th>
									<th width="100px">Date</th>
									<th width="100px">Time</th>
									<th width="150px">Expiry</th>
									<th width="250px">Title</th>
								</tr>
								<?php
								
								$per_page=10;
								if (isset($_GET["page"])) {

								$page = $_GET["page"];

								}

								else {

								$page=1;

								}

								// Page will start from 0 and Multiple by Per Page
								$start_from = ($page-1) * $per_page;
								
								//Selecting the data from table but with limit
								$announcement_table = "SELECT * from announcement ORDER BY ANNID DESC limit $start_from,$per_page";
								$sql_announcement 	= mysqli_query($conn, $announcement_table);
								
								while($row=mysqli_fetch_assoc($sql_announcement))
								{
									?>
									<tr>
										<td><?php echo "<a href=\"staff_view_announcement_detail.php?ann_id={$row['ANN_ID']}\">{$row['ANN_ID']}</a>";?></td>
										<td height="40px"><?php echo $row["ANN_DATE"];?></td>
										<td><?php echo $row["ANN_TIME"];?></td>
										<td><?php echo $row["ANN_EXPIRY"];?></td>
										<td><?php echo $row["ANN_TITLE"];?></td>
									</tr>
									<?php
								}
								?>
							</table>
							<div id="page-selection">
								<?php
										//Now select all from table
										$query = "select * from announcement";
										$result = mysqli_query($conn, $query);

										// Count the total records
										$total_records = mysqli_num_rows($result);

										//Using ceil function to divide the total records on per page
										$total_pages = ceil($total_records / $per_page);
										
										?>
										<div id="page-selection">
											<ul>
											<?php
											//Going to first page
											echo "<a href='staff_view_announcement.php?page=1'><li style='width:80px;border-right:1px solid black;'>".'First Page'."</li></a> ";

											for ($i=1; $i<=$total_pages; $i++) {

											echo "<a href='staff_view_announcement.php?page=".$i."'><li>".$i."</li></a> ";
											};
											// Going to last page
											echo "<a href='staff_view_announcement.php?page=$total_pages'><li style='width:80px;border-left:1px solid black;'>".'Last Page'."</li></a> ";
											?>
											</ul>
										</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
			<?php include 'include/btmnavi.php'; ?>
		</div>
		<?php include 'include/popup_jq.php'; ?>
	</body>
</html>

<?php
if(isset($_GET['filter']))
{
	$announcement = $_GET['ann_id'];
	header("Location:filter_announcement.php?a_id=$announcement");
	exit;
}
?>
