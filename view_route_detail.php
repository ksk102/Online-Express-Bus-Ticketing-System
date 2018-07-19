<?php 

require 'Database/db_con.php';
	if(isset($_SESSION['sess_uid']))
	{
		$sesscustid  = $_SESSION["sess_uid"];
		if(substr($sesscustid,0,1)== "C")
		{
			header('Location: user_profile.php');
		}
		else if (substr($sesscustid,0,1)== "S")
		{
			header('Location: staff_profile.php');
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

$sessadminid = $_SESSION["sess_uid"];

$sql_staff	  = "SELECT * from admin where ADMIN_ID = '$sessadminid'";
$result_staff = mysqli_query($conn, $sql_staff);
$row 		  = mysqli_fetch_assoc($result_staff);

if (isset($_GET['rou_id']))
{
	$rou_id	 	= $_GET['rou_id'];
	$sql_rou    = "SELECT * from route where ROU_ID = '$rou_id'";
	$result_rou = mysqli_query($conn, $sql_rou);
	$row2		= mysqli_fetch_assoc($result_rou);
	$rou_sch	= $row2['SCH_ID'];
}
else
{
	header('Location: index.php');
}

$sql_sch 	= "SELECT * from schedule where SCH_ID='$rou_sch'";
$result_sch = mysqli_query($conn, $sql_sch);
$row3		= mysqli_fetch_assoc($result_sch);

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>View Route Detail | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/viewscheduledetail.css" rel="stylesheet" type="text/css">
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
							<p>View Route Detail</p>
						</div>
						<hr/>
						<div id="viewschedule-table">
							<form name="viewschedule" action="" method="post">
								<table style="height:550px;">
									<tr>
										<td width="150px">Route ID</td>
										<td><b><?php echo $row2["ROU_ID"];?></b></td>
									</tr>
									<tr>
										<td width="150px">Route Date</td>
										<td><b><?php echo $row2["ROU_DATE"];?></b></td>
									</tr>
									<tr>
										<td width="150px">Route Platform</td>
										<td><b><?php echo $row2["ROU_PLATFORM"];?></b></td>
									</tr>
									<tr>
										<td width="150px">Reserved Seats</td>
										<td><b><?php echo $row2["ROU_RSEAT"];?></b></td>
									</tr>
									<tr>
										<td width="150px">Bus VRN</td>
										<td><b><?php echo $row2["BUS_VRN"];?></b></td>
									</tr>
									<tr>
										<td width="150px">Schedule ID</td>
										<td><b><?php echo $row3["SCH_ID"];?></b></td>
									</tr>
									<tr>
										<td>Time</td>
										<td><b><?php echo $row3['SCH_TIME'];?></b></td>
									</tr>
									<?php
									$depart = $row3['SCH_PICK'];
									$arrive = $row3['SCH_DROP'];
									
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
										<td width="150px">Pick-up Point</td>
										<td><b><?php echo $pickup;?></b></td>
									</tr>
									<tr>
										<td>Drop-off Point</td>
										<td><b><?php echo $dropoff;?></b></td>
									</tr>
									<tr>
										<td>Trip Duration</td>
										<td><b><?php echo $row3['SCH_DURATION'];?></b></td>
									</tr>
									<tr>
										<td>Price</td>
										<td><b>RM<?php echo $row3['SCH_PRICE'];?></b></td>
									</tr>
									<tr>
										<td>Child Price</td>
										<td><b>RM<?php echo $row3['SCH_CPRICE'];?></b></td>
									</tr>
								</table>
							</form>
						</div>
					</div>
				</div>
			</div>
		
			<?php include 'include/btmnavi.php'; ?>
		</div>
		<?php include 'include/popup_jq.php'; ?>
	</body>
</html>
