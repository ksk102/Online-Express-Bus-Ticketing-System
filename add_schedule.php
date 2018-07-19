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

//Generate schedule ID
//Retrieve the last schedule ID
$sql_sch	= "SELECT SCH_ID from schedule ORDER BY SCHID DESC LIMIT 1";
$result_sql = mysqli_query($conn, $sql_sch);
$row2		= mysqli_fetch_assoc($result_sql);
$lastschid	= $row2['SCH_ID'];

if($row2<1)
{
	$schid_alpa	  = "_S_";
	$schid_num	  = 0; //Schedule ID

	++$schid_num;
	$schid_numext = str_pad($schid_num,2,"0", STR_PAD_LEFT);

	$schidfinal   = $admin_comp.$schid_alpa.$schid_numext;
}
else
{
	//Split schedule ID with _
	$split_sch	  = preg_split('/[_]/', $lastschid);
	$schid_alpa	  = "_S_";
	$schid_num	  = $split_sch[2]; //Schedule ID

	++$schid_num;
	$schid_numext = str_pad($schid_num,2,"0", STR_PAD_LEFT);

	$schidfinal   = $admin_comp.$schid_alpa.$schid_numext;
	//print_r ($split_sch);
	//echo "<br>";
	//echo $schidfinal;
}
?>

<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Add Schedule | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/addschedule.css" rel="stylesheet" type="text/css">
	
		<script>
		function selectschdcity(str) {
			if (str == "") {
				document.getElementById("schdcity").innerHTML = "";
				return;
			} else { 
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest();
				} else {
					// code for IE6, IE5
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("schdcity").innerHTML = xmlhttp.responseText;
					}
				}
				xmlhttp.open("GET","include/schdcity.php?q="+str,true);
				xmlhttp.send();
			}
		}
		
		function selectschacity(str) {
			if (str == "") {
				document.getElementById("schacity").innerHTML = "";
				return;
			} else { 
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest();
				} else {
					// code for IE6, IE5
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("schacity").innerHTML = xmlhttp.responseText;
					}
				}
				xmlhttp.open("GET","include/schdcity.php?q="+str,true);
				xmlhttp.send();
			}
		}
		</script>
		
		<script>
		function check_time()
		{
			if (document.addnewschedule.schtime.value == "")
			{
				document.getElementById('TimeError').innerHTML = ' Enter schedule time';
				return false;
			}
			else
			{
				document.getElementById('TimeError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		function check_price()
		{
			if (document.addnewschedule.ticketprice.value == "" || isNaN(document.addnewschedule.ticketprice.value))
			{
				document.getElementById('PriceError').innerHTML = ' Enter the price of the ticket';
				return false;
			}
			else
			{
				document.getElementById('PriceError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		function check_cprice()
		{
			if (document.addnewschedule.cticketprice.value == "" || isNaN(document.addnewschedule.cticketprice.value))
			{
				document.getElementById('CPriceError').innerHTML = ' Enter the price of the ticket';
				return false;
			}
			else
			{
				document.getElementById('CPriceError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		function check_pick()
		{
			if (document.addnewschedule.schdstate.value == "none")
			{
				document.getElementById('PickError').innerHTML = ' Please select pick-up state';
				return false;
			}
			else
			{
				if (document.addnewschedule.schdcity.value == "none")
				{
					document.getElementById('PickError').innerHTML = ' Please select pick-up city';
					return false;
				}
				else
				{
					document.getElementById('PickError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
					return true;
				}
			}
		}
		function check_drop()
		{
			if (document.addnewschedule.schastate.value == "none")
			{
				document.getElementById('DropError').innerHTML = ' Please select pick-up state';
				return false;
			}
			else
			{
				if (document.addnewschedule.schacity.value == "none")
				{
					document.getElementById('DropError').innerHTML = ' Please select pick-up city';
					return false;
				}
				else
				{
					document.getElementById('DropError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
					return true;
				}
			}
		}
		function check_duration()
		{
			if (document.addnewschedule.duration.value == "")
			{
				document.getElementById('DurationError').innerHTML = ' Please select trip duration';
				return false;
			}
			else
			{
				document.getElementById('DurationError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		function validate()
		{
			if (check_time() && check_price() && check_cprice() && check_pick() && check_drop() && check_duration())
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
							<p>Add New Schedule</p>
							<hr/>
						</div>
						<div id="newschedulefrm">
							<form name="addnewschedule" action="" method="post" onsubmit="return validate();">
								<table>
									<tr>
										<td width="150px">Schedule ID</td>
										<td><input type="text" name="sch_id" value="<?php echo $schidfinal;?>" readonly class="readonly"></td>
									</tr>
									<tr>
										<td>Time</td>
										<td><input type="time" name="schtime" oninput="check_time();" onblur="check_time();"><span id="TimeError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td>Pick-Up Point</td>
										<td>
											<select id="schdstate" name="schdstate" size="1" onchange="selectschdcity(this.value)" onblur="check_pick();">
												<option value="none" selected>--Select a State--</option>
												<option value="W">Kuala Lumpur</option>
												<option value="J">Johor</option>
												<option value="K">Kedah</option>
												<option value="D">Kelantan</option>
												<option value="M">Malacca</option>
												<option value="N">Negeri Sembilan</option>
												<option value="C">Pahang</option>
												<option value="A">Perak</option>
												<option value="R">Perlis</option>
												<option value="P">Pulau Pinang</option>
												<option value="B">Selangor</option>
												<option value="T">Terengganu</option>
											</select>
											<select id="schdcity" name="schdcity" onchange="check_pick();" onblur="check_pick();" size="1">
												<option value="none" selected>--Select a City--</option>		
											</select>
											<span id="PickError" class="red" style="font-size:8.7pt;">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>Drop-Off Point</td>
										<td>
											<select id="schastate" name="schastate" size="1" onchange="selectschacity(this.value)" onblur="check_drop();">
												<option value="none" selected>--Select a State--</option>
												<option value="W">Kuala Lumpur</option>
												<option value="J">Johor</option>
												<option value="K">Kedah</option>
												<option value="D">Kelantan</option>
												<option value="M">Malacca</option>
												<option value="N">Negeri Sembilan</option>
												<option value="C">Pahang</option>
												<option value="A">Perak</option>
												<option value="R">Perlis</option>
												<option value="P">Pulau Pinang</option>
												<option value="B">Selangor</option>
												<option value="T">Terengganu</option>
											</select>
											<select id="schacity" name="schacity" onchange="check_drop();" onblur="check_drop();" size="1">
												<option value="none" selected>--Select a City--</option>		
											</select>
											<span id="DropError" class="red" style="font-size:8.7pt;">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>Price</td>
										<td><input type="text" name="ticketprice" placeholder="Price for this ticket" oninput="check_price();" onblur="check_price();"><span id="PriceError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td>Child Price</td>
										<td><input type="text" name="cticketprice" placeholder="Price for child ticket" oninput="check_cprice();" onblur="check_cprice();"><span id="CPriceError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td>Duration</td>
										<td>
											<select name="duration" onblur="check_duration();">
												<option value="">--Select Travel Duration--</option>
												<option value="1H">1 Hour</option>
												<option value="1H30M">1 Hour 30 Minutes</option>
												<option value="2H">2 Hours</option>
												<option value="2H30M">2 Hours 30 Minutes</option>
												<option value="3H">3 Hours</option>
												<option value="3H30M">3 Hours 30 Minutes</option>
												<option value="4H">4 Hours</option>
												<option value="4H30M">4 Hours 30 Minutes</option>
												<option value="5H">5 Hours</option>
												<option value="5H30M">5 Hours 30 Minutes</option>
												<option value="6H">6 Hours</option>
												<option value="6H30M">6 Hours 30 Minutes</option>
												<option value="7H">7 Hours</option>
												<option value="7H30M">7 Hours 30 Minutes</option>
												<option value="8H">8 Hours</option>
												<option value="8H30M">8 Hours 30 Minutes</option>
												<option value="9H">9 Hours</option>
												<option value="9H30M">9 Hours 30 Minutes</option>
												<option value="10H">10 Hours</option>
												<option value="10H30M">10 Hours 30 Minutes</option>
												<option value="11H">11 Hours</option>
												<option value="11H30M">11 Hours 30 Minutes</option>
												<option value="12H">12 Hours</option>
											</select>
											<span id="DurationError" class="red">&nbsp;</span>
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
	$schedule	= $_POST['sch_id'];
	$time		= $_POST['schtime'];
	$pick_up	= $_POST['schdcity'];
	$drop_off	= $_POST['schacity'];
	$price		= $_POST['ticketprice'];
	$cprice		= $_POST['cticketprice'];
	$duration	= $_POST['duration'];
	
	/*Schedule Status
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
	
	$sch_table 		= "schedule";
	$insert_table	= "INSERT into " .$sch_table. "(SCH_ID, SCH_TIME, SCH_PICK, SCH_DROP, SCH_DURATION, SCH_PRICE, SCH_CPRICE, COMP_ID, SCH_STATUS)". "VALUES('$schedule', '$time', '$pick_up', '$drop_off', '$duration', '$price', '$cprice', '$admin_comp', '$status')";
	mysqli_query($conn, $insert_table);
	echo "<script>alert('Schedule successfully added');</script>";
	header("Refresh:0");
	mysqli_close($conn);
}	
?>
