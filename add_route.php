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
		else if (substr($sesscustid,0,1)== "A")
		{
			$sessadmid  = $_SESSION["sess_uid"];

			$sql_user 	 = "SELECT * from admin where ADMIN_ID = '$sessadmid'";
			$result_user = mysqli_query($conn, $sql_user);
			$row		 = mysqli_fetch_assoc($result_user);
		}
	}
	else
	{
		header('Location: index.php');
	}
$admin_comp	  = $row['COMP_ID'];
if(isset($_SESSION['pic_url']))
{
	$pic_url	  = $_SESSION['pic_url'];
}

if(isset($_GET['sch_id']))
{
	$sch_id 	= $_GET['sch_id'];
	$sql_sch	= "SELECT * from schedule where SCH_ID='$sch_id'";
	$result_sch = mysqli_query($conn, $sql_sch);
	$row1		= mysqli_fetch_assoc($result_sch);
	$compid		= $row1['COMP_ID'];
}

//Generate route ID
//Retrieve the last route ID
$sql_rou	= "SELECT ROU_ID from route ORDER BY ROUTEID DESC LIMIT 1";
$result_sql = mysqli_query($conn, $sql_rou);
$row2		= mysqli_fetch_assoc($result_sql);
$lastrouid	= $row2['ROU_ID'];

if($row2<1)
{
	$rouid_alpa	  = 'R_';
	$rouid_num	  = 0; //Route ID

	++$rouid_num;
	$rouid_numext = str_pad($rouid_num,2,"0", STR_PAD_LEFT);

	$rouidfinal   = $rouid_alpa.$rouid_numext;
	//echo $rouidfinal;
}
else
{
	//Split route ID with _
	$split_rou	  = preg_split('/[_]/', $lastrouid);
	$rouid_alpa	  = 'R_';
	$rouid_num	  = $split_rou[1]; //Route ID

	++$rouid_num;
	$rouid_numext = str_pad($rouid_num,2,"0", STR_PAD_LEFT);

	$rouidfinal   = $rouid_alpa.$rouid_numext;
	//print_r ($split_rou);
	//echo "<br>";
	//echo $rouidfinal;
}
?>

<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Add Route | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/addroute.css" rel="stylesheet" type="text/css">
	
		<script>
		function check_date()
		{
			if (document.addnewschedule.rou_date.value == "")
			{
				document.getElementById('DateError').innerHTML = ' Enter route date';
				return false;
			}
			else
			{
				document.getElementById('DateError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		function check_platform()
		{
			if (document.addnewschedule.rou_platform.value == "")
			{
				document.getElementById('PlatformError').innerHTML = ' Please enter route platform';
				return false;
			}
			else
			{
				document.getElementById('PlatformError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		function check_vrn()
		{
			if (document.addnewschedule.bus_vrn.value == "none")
			{
				document.getElementById('VRNError').innerHTML = ' Please enter bus vehicle registration number';
				return false;
			}
			else
			{
				document.getElementById('VRNError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		function validate()
		{
			if (check_date() && check_platform() && check_vrn())
			{
				return true;
			}
			else
			{
				alert("Please check your entered information");
				return false;
			}
		}
		</script>
	</head>

	<body>
    	<div id="container">
			<?php
				include 'include/header.php';
			?>
        
			<div id="content">
				<div id="content-wrapper">
					<?php include 'include/leftnavi.php'; ?>
					<div id="newschedule-wrapper">
						<div id="newschedule-wrapper-title">
							<p>Add New Route</p>
							<hr/>
						</div>
						<div id="newschedulefrm">
							<form name="addnewschedule" action="" method="post" onsubmit="return validate();">
								<table>
									<tr>
										<td width="150px">Schedule ID</td>
										<td><input type="text" name="sch_id" value="<?php echo $row1['SCH_ID'];?>" readonly class="readonly"></td>
									</tr>
									<tr>
										<td>Time</td>
										<td><input type="time" value="<?php echo $row1['SCH_TIME'];?>" class="readonly" readonly</td>
									</tr>
									
									<?php
									$depart = $row1['SCH_PICK'];
									$arrive = $row1['SCH_DROP'];
									
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
										<td>Pick-Up Point</td>
										<td><input type="text" value="<?php echo $pickup;?>" class="readonly" readonly</td>
									</tr>
									<tr>
										<td>Drop-Off Point</td>
										<td><input type="text" value="<?php echo $dropoff;?>" class="readonly" readonly</td>
									</tr>
									<tr>
										<td>Price</td>
										<td><input type="text" value="RM<?php echo $row1['SCH_PRICE'];?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td>Child Price</td>
										<td><input type="text" value="RM<?php echo $row1['SCH_CPRICE'];?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td>Duration</td>
										<td><input type="text" value="<?php echo $row1['SCH_DURATION'];?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td width="150px">Route ID</td>
										<td><input type="text" name="rou_id" value="<?php echo $rouidfinal;?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td width="150px">Route Date</td>
										<td><input type="date" name="rou_date" value="" oninput="check_date();" onblur="check_date();"><span id="DateError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td width="150px">Route Platform</td>
										<td><input type="text" name="rou_platform" value="" oninput="check_platform();" onblur="check_platform();"><span id="PlatformError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td width="150px">Bus VRN</td>
										<td>
											<select id="bus_vrn" name="bus_vrn" oninput="check_vrn();">
												<option value="none" selected>--Select a Bus--</option>
												
												<?php
													$sql_bus	  = "SELECT * from bus where COMP_ID = '$admin_comp'";
													$result_bus = mysqli_query($conn, $sql_bus);
													while($row_bus  = mysqli_fetch_assoc($result_bus))
													{
													?>
														<option value="<?php echo $row_bus['BUS_VRN'];?>"><?php echo $row_bus['BUS_VRN'];?></option>
													<?php
													}
													?>
											</select><span id="VRNError" class="red">&nbsp;</span>
										</td>
									</tr>
								</table>
								<div id="newschedule-btn">
									<input type="submit" name="addbtn" value="Add">
									<input type="reset" name="cancelbtn" value="Cancel">
								</div>
							</form>
						</div>  
					</div>
				</div>
			</div>
		
			<?php include 'include/btmnavi.php'; ?>
		</div>
	</body>
</html>

<?php
if(isset($_POST['addbtn']))
{
	$schedule  = $_POST['sch_id'];
	$route	   = $_POST['rou_id'];
	$date	   = $_POST['rou_date'];
	$platform  = $_POST['rou_platform'];
	$vrn	   = $_POST['bus_vrn'];
	$alertmsg  = "Route successfully added";
	
	/*Route Status
	0 = Active
	1 = Inactive
	*/
	$status		= 0;
	
	/*echo $schedule;
	echo "<br>";
	echo $time;
	echo "<br>";
	echo $pick_up;
	echo "<br>";
	echo $drop_off;
	echo "<br>";
	echo $price;
	echo "<br>";
	echo $duration;*/
	
	$rou_table 		= "route";
	$insert_table	= "INSERT into " .$rou_table. "(ROU_ID, ROU_DATE, ROU_PLATFORM, ROU_RSEAT, BUS_VRN, SCH_ID, COMP_ID, ROU_STATUS)". "VALUES('$route', '$date', '$platform', '30', '$vrn', '$schedule', '$compid', '0')";
	//echo $insert_table;
	$result			= mysqli_query($conn, $insert_table);
	if($result)
	{
		for($i=1;$i<31;$i++)
		{
			$seat_table    = "seat";
			$insert_table2 = "INSERT into " .$seat_table. "(SEAT_NO, SEAT_STATUS, BUS_VRN, ROU_ID)". "VALUES('$i', '0', '$vrn', '$route')";
			mysqli_query($conn, $insert_table2);
		}
		echo "<script>alert('$alertmsg'); window.location.href='view_schedule.php';</script>";		
		header("Refresh:0");
		mysqli_close($conn);
	}
}	
?>
