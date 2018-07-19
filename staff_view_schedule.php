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

$sessstaffid  = $_SESSION["sess_uid"];

$sql_staff	  = "SELECT * from staff where STAFF_ID = '$sessstaffid'";
$result_staff = mysqli_query($conn, $sql_staff);
$row 		  = mysqli_fetch_assoc($result_staff);
$staff_compid = $row['COMP_ID'];
if(isset($_SESSION['pic_url']))
{
	$pic_url	  = $_SESSION['pic_url'];
}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>View Schedules | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/viewschedule.css" rel="stylesheet" type="text/css">
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
					<div id="viewschedule-wrapper">
						<div id="viewschedule-wrapper-title">
							<p>View Schedules</p>
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
															<p>Schedule Time</p>
															<input type="time" name="sch_id" value=""/>
														</div>
													</div>
													
													<input type="submit" name="filter" value="Filter"/>
												</div>
										</form>
									</div>
								</div>
							</div>				
						<div id="viewschedule-table">
							<table width="740px">
								<tr>
									<th height="40px" width="160px">Schedule ID</th>
									<th width="120px">Time</th>
									<th width="140px">Pick-Up Point</th>
									<th width="140px">Drop-Off Point</th>
									<th>Price</th>
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
								$schedule_table = "SELECT * from schedule where COMP_ID='$staff_compid' ORDER BY SCHID DESC limit $start_from,$per_page";
								$sql_schedule 	= mysqli_query($conn, $schedule_table);
								
								while($row=mysqli_fetch_assoc($sql_schedule))
								{
									?>
									<?php
									$depart = $row['SCH_PICK'];
									$arrive = $row['SCH_DROP'];
									
									$sql_departcityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$depart' group by cityname.city_FULL";
									$result_departarrivecityname	= mysqli_query($conn, $sql_departcityname);
									
									while ($row_city = mysqli_fetch_array($result_departarrivecityname))
									{
										$pickup=$row_city["CITY_FULL"];
									}
									
									$sql_arrivecityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$arrive' group by cityname.city_FULL";
									$result_arrivecityname	= mysqli_query($conn, $sql_arrivecityname);
									
									while ($row_city = mysqli_fetch_array($result_arrivecityname))
									{
										$dropoff=$row_city["CITY_FULL"];
									}
									?>
									<tr>
										<td><?php echo "<a href=\"staff_view_schedule_detail.php?sch_id={$row['SCH_ID']}\">{$row['SCH_ID']}</a>";?></td>
										<td height="40px"><?php echo $row["SCH_TIME"];?></td>
										<td><?php echo $pickup;?></td>
										<td><?php echo $dropoff;?></td>
										<td>RM<?php echo $row["SCH_PRICE"];?></td>
									</tr>
									<?php
								}
								?>
							</table>
							<div id="page-selection">
								<?php
										//Now select all from table
										$query = "select * from schedule";
										$result = mysqli_query($conn, $query);

										// Count the total records
										$total_records = mysqli_num_rows($result);

										//Using ceil function to divide the total records on per page
										$total_pages = ceil($total_records / $per_page);
										
										?>
										<ul>
										<?php
										//Going to first page
										echo "<li style='width:80px;'><a href='staff_view_schedule.php?page=1'>".'First Page'."</a></li> ";

										for ($i=1; $i<=$total_pages; $i++) {

										echo "<li><a href='staff_view_schedule.php?page=".$i."'>".$i."</a></li> ";
										};
										// Going to last page
										echo "<li style='width:80px;'><a href='staff_view_schedule.php?page=$total_pages'>".'Last Page'."</a></li> ";
										?>
										</ul>
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
	$schedule = $_GET['sch_id'];
	header("Location:filter_schedule.php?s_id=$schedule");
	exit;
}
?>
