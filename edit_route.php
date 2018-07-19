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

$sql_user	 = "SELECT * from admin where ADMIN_ID = '$sessadminid'";
$result_user = mysqli_query($conn, $sql_user);
$row 		 = mysqli_fetch_assoc($result_user);
if(isset($_SESSION['pic_url']))
{
	$pic_url	  = $_SESSION['pic_url'];
}

if (isset($_GET['rou_id']))
{
	$rou_id	 	= $_GET['rou_id'];
	$sql_rou    = "SELECT * from route where ROU_ID = '$rou_id'";
	$result_rou = mysqli_query($conn, $sql_rou);
	$row2		= mysqli_fetch_assoc($result_rou);
	$rou_sch	= $row2['SCH_ID'];
}

$sql_sch 	= "SELECT * from schedule where SCH_ID='$rou_sch'";
$result_sch = mysqli_query($conn, $sql_sch);
$row3		= mysqli_fetch_assoc($result_sch);
?>

<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Edit Route | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/addschedule.css" rel="stylesheet" type="text/css">
	
		<script src="js-folder/index.js" type="text/javascript"></script>
		
		
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
							<p>Edit Route</p>
							<hr/>
						</div>
						<div id="newschedulefrm">
							<form name="addnewschedule" action="" method="post" onsubmit="return validate();">
								<table>
									<tr>
										<td width="150px">Schedule ID</td>
										<td><input type="text" value="<?php echo $row3["SCH_ID"];?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td>Time</td>
										<td><input type="text" value="<?php echo $row3['SCH_TIME'];?>" class="readonly" readonly></td>
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
										<td><input type="text" value="<?php echo $pickup;?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td>Drop-off Point</td>
										<td><input type="text" value="<?php echo $dropoff;?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td>Trip Duration</td>
										<td><input type="text" value="<?php echo $row3['SCH_DURATION'];?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td>Price</td>
										<td><input type="text" value="RM<?php echo $row3['SCH_PRICE'];?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td>Child Price</td>
										<td><input type="text" value="RM<?php echo $row3['SCH_CPRICE'];?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td width="150px">Route ID</td>
										<td><input type="text" value="<?php echo $row2["ROU_ID"];?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td width="150px">Route Date</td>
										<td><input type="date" name="rou_date" value="<?php echo $row2["ROU_DATE"];?>" oninput="check_date();" onblur="check_date();"><span id="DateError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td width="150px">Route Platform</td>
										<td><input type="text" name="rou_platform" value="<?php echo $row2["ROU_PLATFORM"];?>" oninput="check_platform();" onblur="check_platform();"><span id="PlatformError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td width="150px">Remaining Seats</td>
										<td><input type="text" name="rou_seat" value="<?php echo $row2["ROU_RSEAT"];?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td width="150px">Bus VRN</td>
										<td>
											<select id="bus_vrn" name="bus_vrn" oninput="check_vrn();">
												<option value="none" selected>--Select a Bus--</option>
												
												<?php
													$admin_comp=$row['COMP_ID'];
													$sql_bus	  = "SELECT * from bus where COMP_ID = '$admin_comp'";
													$result_bus = mysqli_query($conn, $sql_bus);
													while($row_bus  = mysqli_fetch_assoc($result_bus))
													{
													?>
														<option value="<?php echo $row_bus['BUS_VRN'];?>"<?php if($row_bus['BUS_VRN']==$row2['BUS_VRN']){echo 'selected';} ?>><?php echo $row_bus['BUS_VRN'];?></option>
													<?php
													}
													?>
											</select><span id="VRNError" class="red">&nbsp;</span>
										</td>
									</tr>
									
								</table>
								<div id="newschedule-btn" style="margin-left:540px;">
									<input type="submit" name="savebtn" value="Save Changes">
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
if(isset($_POST["savebtn"]))
{
	$date     = $_POST["rou_date"];
	$platform = $_POST["rou_platform"];
	$seat 	  = $_POST["rou_seat"];
	$vrn 	  = $_POST["bus_vrn"];
	
	//Update route table
	$rou_table 	  = "route";
	$update_table = "UPDATE $rou_table SET ROU_DATE='$date', ROU_PLATFORM='$platform', ROU_RSEAT='$seat', BUS_VRN='$vrn' WHERE ROU_ID='$rou_id'";
	//echo $update_table;
	mysqli_query($conn, $update_table);
	header("Location:view_route.php");
	mysqli_close($conn);

}
?>