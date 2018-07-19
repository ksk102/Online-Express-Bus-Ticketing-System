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

if (isset($_GET['sch_id']))
{
	$sch_id	 	= $_GET['sch_id'];
	$sql_sch    = "SELECT * from schedule where SCH_ID = '$sch_id'";
	$result_sch = mysqli_query($conn, $sql_sch);
	$row2		= mysqli_fetch_assoc($result_sch);
}

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>View Schedule | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/viewscheduledetail.css" rel="stylesheet" type="text/css">
		<style>
		#newroute-btn
		{
			width:220px;
			margin-left:650px;
		}
		#newroute-btn input[type="submit"]
		{
			border:2px solid black;
			border-radius:5px;
			width:100px;
			padding-left:5px;
			margin-top:50px;
			margin-bottom:15px;
			height:25px;
		}

		#newroute-btn input[type="submit"]:hover
		{
			background-color:#eeeeee;
		}
		</style>
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
										<td><input type="text" value="<?php echo $row2["SCH_ID"];?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td>Time</td>
										<td><input type="text" value="<?php echo $row2['SCH_TIME'];?>" class="readonly" readonly></td>
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
										<td><input type="text" value="<?php echo $pickup;?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td>Drop-off Point</td>
										<td><input type="text" value="<?php echo $dropoff;?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td>Trip Duration</td>
										<td><input type="text" value="<?php echo $row2['SCH_DURATION'];?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td>Price</td>
										<td><input type="text" value="RM<?php echo $row2['SCH_PRICE'];?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td>Child Price</td>
										<td><input type="text" value="RM<?php echo $row2['SCH_CPRICE'];?>" class="readonly" readonly></td>
									</tr>
								</table>
								<div id="newroute-btn">
									<input type="submit" name="addbtn" value="Add Route">
								</div>
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

<?php
if(isset($_POST['addbtn']))
{
	$schid = $row2["SCH_ID"];
	header("Location: add_route.php?sch_id=$schid");
	
}

?>
