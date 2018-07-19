<?php 
if(isset($_GET['q']))
{
	require 'database/db_con.php';
	
	$route = $_GET["q"];

	$sql_route = "select * from route where ROU_ID='$route'";
	$result_route = mysqli_query($conn, $sql_route);
	$row		 = mysqli_fetch_assoc($result_route);
	
	$count=0;
	if($row<1)
	{
		header('Location: search_ticket.php');
	}
	
	$scheduleid = $row['SCH_ID'];
	
	$sql_schedule = "select * from schedule where SCH_ID='$scheduleid'";
	$result_schedule = mysqli_query($conn, $sql_schedule);
	$row_schedule	 = mysqli_fetch_assoc($result_schedule);
	
	$departtime = new DateTime($row_schedule["SCH_TIME"]);
	$arrivetime = new DateTime($row_schedule["SCH_TIME"]);
	$arrivetime->add(new DateInterval('PT'.$row_schedule["SCH_DURATION"]));
	
	$depart = $row_schedule["SCH_PICK"];
	$arrive = $row_schedule["SCH_DROP"];
	
	$sql_departcityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$depart' group by cityname.city_FULL";
	$result_departarrivecityname	= mysqli_query($conn, $sql_departcityname);
	$row_departcityname = mysqli_fetch_array($result_departarrivecityname);
	$pickup=$row_departcityname["CITY_FULL"];
	
	$sql_arrivecityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$arrive' group by cityname.city_FULL";
	$result_arrivecityname	= mysqli_query($conn, $sql_arrivecityname);
	$row_arrivecityname = mysqli_fetch_array($result_arrivecityname);
	$dropoff=$row_arrivecityname["CITY_FULL"];
	
	$companyid=$row["COMP_ID"];
	$sql_companyname		= "SELECT * FROM company WHERE COMP_ID = '$companyid' group by COMP_NAME";
	$result_companyname	= mysqli_query($conn, $sql_companyname);
	$row_companyname = mysqli_fetch_array($result_companyname);
}
else
{
	header('Location: index.php');
}
?>

<html>
	<head>
		<title>Route Detail | BusForAll.com</title>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/routedetail.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="js_folder/jquery-1.8.3.js"></script>
		
		<script src='popup/js/jquery.min.js'></script>
		<script src='popup/js/jquery.magnific-popup.min.js'></script>
	</head>
	<body>
		<div id="container">
			<?php
				include 'include/header.php';
			?>
			<div id="content">
				<div id="main-content" style="padding-top:10px;">
					<p id="main-content-title">Route Detail</p>
					<hr/>
					<div id="maincontent">
						<form name="myprofile" action="" method="">
							<table  style="margin-left:20px;">
								<tr>
									<td>Route ID</td>
									<td>
										<input type="text" name="rou_id" value="<?php echo $row["ROU_ID"];?>" readonly class="readonly"/>
									</td>
								</tr>
								<tr>
									<td>Depart Date</td>
									<td><input type="text" name="rou_date" value="<?php echo $row["ROU_DATE"];?>" readonly class="readonly"/></td>
								</tr>
								<tr>
									<td>Depart Time</td>
									<td><input type="text" name="sch_time" value="<?php echo $departtime->format('h:i A');?>" readonly class="readonly"/></td>
								</tr>
								<tr>
									<td>Arrive Time <br/><small>(Estimated)</small></td>
									<td><input type="text" name="sch_arrivetime" value="<?php echo $arrivetime->format('h:i A');?>" readonly class="readonly"/></td>
								</tr>
								<tr>
									<td>Pick Up</td>
									<td><input type="text" name="sch_pick" value="<?php echo $pickup;?>" readonly class="readonly"/></td>
								</tr>
								<tr>
									<td>Drop off</td>
									<td><input type="text" name="sch_pick" value="<?php echo $dropoff;?>" readonly class="readonly"/></td>
								</tr>
							</table>
							<table style="margin-left:375px;margin-top:-550px;">
								<tr>
									<td>Adult Price</td>
									<td><input type="text" name="sch_pick" value="<?php echo 'RM'.$row_schedule["SCH_PRICE"];;?>" readonly class="readonly"/></td>
								</tr>
								<tr>
									<td>Child Price <br/><small>(below 12-year-old)</small></td>
									<td><input type="text" name="sch_pick" value="<?php echo 'RM'.$row_schedule["SCH_CPRICE"];;?>" readonly class="readonly"/></td>
								</tr>
								<tr>
									<td>Trip Duration</td>
									<td><input type="text" name="sch_duration" value="<?php echo $row_schedule['SCH_DURATION'];?>" readonly class="readonly"/></td>
								</tr>
								<tr>
									<td>Bus Platform</td>
									<td><input type="text" name="rou_platform" value="<?php echo $row["ROU_PLATFORM"];?>" readonly class="readonly"/></td>
								</tr>
								<tr>
									<td>Remaining Seat(s)</td>
									<td><input type="text" name="rou_rseat" value="<?php echo $row["ROU_RSEAT"];?>" readonly class="readonly"/></td>
								</tr>
								<tr>
									<td>Bus Number</td>
									<td><input type="text" name="bus_vrn" value="<?php echo $row["BUS_VRN"];?>" readonly class="readonly"/>
									</td>
								</tr>
								<tr>
									<td>Operate by</td>
									<td><input type="text" name="bus_vrn" value="<?php echo $row_companyname['COMP_NAME'];?>" readonly class="readonly"/>
									</td>
								</tr>								
							</table>
						</form>
					</div>
				</div>
			</div>
			<?php include 'include/btmnavi.php'; ?>
		</div>
		<script src="popup/js/index.js"></script>
	</body>
</html>