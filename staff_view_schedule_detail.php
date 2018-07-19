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

if (isset($_GET['sch_id']))
{
	$sch_id	 	= $_GET['sch_id'];
	$sql_sch    = "SELECT * from schedule where SCH_ID = '$sch_id'";
	$result_sch = mysqli_query($conn, $sql_sch);
	$row2		= mysqli_fetch_assoc($result_sch);
}
else
{
	header('Location: index.php');
}

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>View Schedule | BusForAll.com</title>
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
							<p>View Schedule Detail</p>
						</div>
						<hr/>
						<div id="viewschedule-table">
							<form name="viewschedule" action="" method="post">
								<table>
									<tr>
										<td width="150px">Schedule ID</td>
										<td><b><?php echo $row2["SCH_ID"];?></b></td>
									</tr>
									<tr>
										<td>Time</td>
										<td><b><?php echo $row2['SCH_TIME'];?></b></td>
									</tr>
									<?php
									$depart = $row2['SCH_PICK'];
									$arrive = $row2['SCH_DROP'];
									
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
										<td><b><?php echo $row2['SCH_DURATION'];?></b></td>
									</tr>
									<tr>
										<td>Price</td>
										<td><b>RM<?php echo $row2['SCH_PRICE'];?></b></td>
									</tr>
									<tr>
										<td>Child Price</td>
										<td><b>RM<?php echo $row2['SCH_CPRICE'];?></b></td>
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
