<?php 
require 'database/db_con.php'; 
if(isset($_SESSION['sess_uid']))
{
	$sesscustid  = $_SESSION["sess_uid"];
	if(substr($sesscustid,0,1)== "C")
	{
		$sql_user 	 = "SELECT * from customer where CUST_ID = '$sesscustid'";
	}
	else if (substr($sesscustid,0,1)== "S")
	{
		$sql_user 	 = "SELECT * from staff where STAFF_ID = '$sesscustid'";
	}
	else if (substr($sesscustid,0,1)== "A")
	{
		$sql_user 	 = "SELECT * from admin where ADMIN_ID = '$sesscustid'";
	}
	
	$result_user = mysqli_query($conn, $sql_user);
	$row1		 = mysqli_fetch_assoc($result_user);
}
else
{
	header('Location: login.php');
}

$chosenseat = $_POST["sseat"];

if($chosenseat=="")
{
	header('Location: search_ticket.php');
}
else if(isset($_COOKIE['checktrans']))
{
	header('Location: search_ticket.php');
}
else
{
	
	$achosenseat = preg_split('/[,]/', $chosenseat);
	if($_POST["paxqty"] != 0)
	{
		$nochild = $_POST["paxqty"];
	}
	else
	{
		$nochild = 0;
	}
	$chosenlength = count($achosenseat);
	$route = $_POST["routeid"];
	
	$totalseats = $chosenlength;
	$adultseats = $totalseats - $nochild;
	
	
	for($x=0;$x<$chosenlength;$x++)
	{
		$update_table	= "UPDATE seat SET SEAT_STATUS='1' where ROU_ID='$route' and SEAT_NO='$achosenseat[$x]'";
		mysqli_query($conn, $update_table);
	}
	
	$sql_route = "SELECT * from route where ROU_ID='$route'";
	$result_route = mysqli_query($conn, $sql_route);
	$row		 = mysqli_fetch_assoc($result_route);
	
	$ttlrseat = $row['ROU_RSEAT'];
	$attlrseat = $ttlrseat - $chosenlength;
	$update_table	= "UPDATE route SET ROU_RSEAT='$attlrseat' where ROU_ID='$route'";
	mysqli_query($conn, $update_table);
	
	if(substr($sesscustid,0,1)== "C")
	{
		$usertype = "CUST_ID";
		$uservalue = $row1["CUST_ID"];
	}
	else if (substr($sesscustid,0,1)== "S")
	{
		$usertype = "STAFF_ID";
		$uservalue = $row1["STAFF_ID"];
	}
	else if (substr($sesscustid,0,1)== "A")
	{
		$usertype = "ADMIN_ID";
		$uservalue = $row1["ADMIN_ID"];
	}
	
	$sql_transid = "SELECT TRANS_ID from transaction ORDER BY TRANSID DESC LIMIT 1";
	$result_transid = mysqli_query($conn, $sql_transid);
	$row_transid	= mysqli_fetch_assoc($result_transid);
	$lastschid	= $row_transid['TRANS_ID'];

	if($row_transid<1)
	{
		$transidfinal   = 100001;
	}
	else
	{
		$transid_num	  = $lastschid;
		++$transid_num;
		$transidfinal   = $transid_num;
	}
	
	$cookie_name = "transid";
	$cookie_value = $transidfinal;
	setcookie($cookie_name, $cookie_value, time() + (60 * 15 + 5), "/");
	
	$tid = $transidfinal;
	
	$sql_trip = "SELECT * from route inner join schedule on route.SCH_ID=schedule.SCH_ID where route.ROU_ID='$route'";
	$result_trip = mysqli_query($conn, $sql_trip);
	$row		 = mysqli_fetch_assoc($result_trip);
	
	$companyid = $row['COMP_ID'];
	
	$sql_trans = "INSERT INTO transaction (TRANS_ID, TRANS_QTT, TRANS_STATUS, TRANS_SEATNO, TRANS_ADULT, TRANS_CHILD, $usertype, ROU_ID, COMP_ID) VALUES ('$transidfinal', '$totalseats', '1', '$chosenseat', '$adultseats', '$nochild', '$uservalue', '$route', '$companyid')";
	mysqli_query($conn, $sql_trans);
	
	$sql_departcityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$row[SCH_PICK]' group by cityname.city_FULL";
	$result_departarrivecityname	= mysqli_query($conn, $sql_departcityname);
	$row_departcityname = mysqli_fetch_array($result_departarrivecityname);
	$pickup=$row_departcityname["CITY_FULL"];
	
	$sql_arrivecityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$row[SCH_DROP]' group by cityname.city_FULL";
	$result_arrivecityname	= mysqli_query($conn, $sql_arrivecityname);
	$row_arrivecityname = mysqli_fetch_array($result_arrivecityname);
	$dropoff=$row_arrivecityname["CITY_FULL"];
	
	$arrivetime = new DateTime($row["SCH_TIME"]);
	$arrivetime->add(new DateInterval('PT'.$row["SCH_DURATION"]));
	$departtime = new DateTime($row["SCH_TIME"]);
	
	$companyid=$row["COMP_ID"];
	$sql_companyname		= "SELECT * FROM company WHERE COMP_ID = '$companyid' group by COMP_NAME";
	$result_companyname	= mysqli_query($conn, $sql_companyname);
	$row_companyname = mysqli_fetch_array($result_companyname);
	$companyname = $row_companyname['COMP_NAME'];
	
	$totalprice = ($adultseats*$row['SCH_PRICE'])+($nochild*$row['SCH_CPRICE']);
	$newtotalprice = number_format($totalprice,2);
	
	$sql_updatetrans = "UPDATE transaction SET TRANS_PRICE='$totalprice' where TRANS_ID='$transidfinal'";
	mysqli_query($conn, $sql_updatetrans);
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Summary of Purchase Detail | BusForAll.com</title>
        <link rel="shortcut icon" href="images/icon/step/travel.png"/>
        <link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/ticketsummary.css" rel="stylesheet" type="text/css"/>
		
		<script src='popup/js/jquery.min.js'></script>
		<script src='popup/js/jquery.magnific-popup.min.js'></script>
		
		<style type="text/css">
		.what
		{
			color:#999999;
			font-weight:normal;
		}
		</style>
		
		<script>
			var needToConfirm = true;
			
			window.addEventListener("beforeunload", function() {
				if (needToConfirm)
				{
					/*var myWindow = window.open("include/userclose.php", "blank_", "width=200, height=100");*/
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.open("GET", "include/userclose.php", true);
					xmlhttp.send();
					//event.returnValue = "You reservation will be cancelled";
				}
			});

		</script>
		<script>
		var seconds = 60*15;

		function secondPassed() {
			var minutes = Math.round((seconds - 30) / 60);
			var remainingSeconds = seconds % 60;
			if (remainingSeconds < 10) {
				remainingSeconds = "0" + remainingSeconds;
			}
			if (minutes < 10){
				minutes = "0" + minutes;
			}
			document.getElementById('countdown').innerHTML = minutes + ":" + remainingSeconds;
			if (seconds == 0) {
				clearInterval(countdownTimer);
				window.location = "index.php";
			} else {
				seconds--;
			}
		}
		var countdownTimer = setInterval('secondPassed()', 1000);
		</script>
		<script>
		function check_name()
		{
			if (document.paymentdetail.username.value == "" || !(isNaN(document.paymentdetail.username.value)) || (/\d/.test(document.paymentdetail.username.value)))
			{
				document.getElementById('NameError').innerHTML = '<span> </span><img src="images/icon/validation/wrong.png" alt="Wrong" style="width:22px;height:22px;vertical-align:-7px;">';		
				return false;
			}
			else
			{
				document.getElementById('NameError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';	
				return true;
			}
		}
		function check_ic()
		{		
			if (document.paymentdetail.usernric.value == "" || document.paymentdetail.usernric.value.length != 12 || (isNaN(document.paymentdetail.usernric.value)))
			{
				document.getElementById('IcError').innerHTML = '<span> </span><img src="images/icon/validation/wrong.png" alt="Wrong" style="width:22px;height:22px;vertical-align:-7px;">';		
				return false;
			}
			else
			{
				document.getElementById('IcError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';	
				return true;
			}
		}
		function check_phone()
		{
			if (document.paymentdetail.userphone.value == "" || document.paymentdetail.userphone.value.length < 9 || document.paymentdetail.userphone.value.length > 11 || isNaN(document.paymentdetail.userphone.value))
			{
				document.getElementById('PhoneError').innerHTML = '<span> </span><img src="images/icon/validation/wrong.png" alt="Wrong" style="width:22px;height:22px;vertical-align:-7px;">';		
				return false;
			}
			else
			{
				document.getElementById('PhoneError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		function check_emailA()
		{
			if (document.paymentdetail.useremailA.value == "" || !(isNaN(document.paymentdetail.useremailA.value)) || document.paymentdetail.useremailA.value.indexOf("@") == -1 || document.paymentdetail.useremailA.value.indexOf(".com") == -1)
			{
				document.getElementById('EmailErrorA').innerHTML = '<span> </span><img src="images/icon/validation/wrong.png" alt="Wrong" style="width:22px;height:22px;vertical-align:-7px;">';		
				return false;
			}
			else
			{
				document.getElementById('EmailErrorA').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		
		function validation()
		{
			if(check_name() && check_ic() && check_phone() && check_emailA())
			{
				if (document.paymentdetail.agree.checked)
				{
					return true;
				}
				else
				{
					alert("Please accept our term and conditions to proceed");
					return false;
				}
			}
			else
			{
				alert("Please check your information again");
				return false;
			}
		}
		</script>
	</head>

	<body onbeforeunload="return userclose()">
    	<div id="container">
			<?php
				include 'include/header.php';
			?>
			<div id="content">
				<div id="content-wrapper">
					<div id="main-content">
						<div id="main-content-title">
							<p>Summary of Purchase Details</p>
							<hr/>
						</div>
						<div>You reservation will be cancelled in <span id="countdown" class="timer">15:00</span> minute(s)</div>
						<?php include 'include/booknavi.php' ?>
						<div id="main-content-left">
							<p id="main-content-left-title">Trip</p>
							<div id="main-content-left-content">
								<div id="main-content-left-content-wrapper">
										<p>From
										<br/><span class="what"><?php echo $pickup; ?></span></p>
										<p>To
										<br/><span class="what"><?php echo $dropoff; ?></p>
								</div>
								<div id="main-content-left-content-wrapper">
									<p>Departure Date
									<br/><span class="what"><?php echo $row['ROU_DATE']; ?></p>
								</div>
								<div id="main-content-left-content-wrapper">
									<p>Depart
									<br/><span class="what"><?php echo $departtime->format('h:i A'); ?></p>
									<p>Arrive (Estimate)
									<br/><span class="what"><?php echo $arrivetime->format('h:i A'); ?></p>
								</div>
								<div id="main-content-left-content-wrapper">
									<p>Platform
									<br/><span class="what"><?php echo $row['ROU_PLATFORM']; ?></p>
									<p>Bus Number
									<br/><span class="what"><?php echo $row['BUS_VRN']; ?></p>
								</div>
								<div id="main-content-left-content-wrapper">
									<p>Bus Operator
									<br/><span class="what"><?php echo $companyname; ?></p>
									<p>Seat No.
									<br/><span class="what"><?php echo $chosenseat; ?></p>
								</div>
								<div id="main-content-left-content-wrapper">
									<p>Adult Ticket
									<br/><span class="what"><?php echo $adultseats ?></p>
									<p>Price per Ticket
									<br/><span class="what"><?php echo 'RM'.$row['SCH_PRICE']; ?></p>
								</div>
								<div id="main-content-left-content-wrapper">
									<p>Child Ticket
									<br/><span class="what"><?php echo $nochild; ?></p>
									<p>Price per Ticket
									<br/><span class="what"><?php echo 'RM'.$row['SCH_CPRICE']; ?></p>
								</div>
							</div>
						</div>
						<div id="main-content-right">
							<p id="main-content-right-title">Payment Details</p>
							<div id="main-content-right-content">
								<form name="paymentdetail" action="<?php if(substr($sesscustid,0,1)== "C"){echo 'payment.php';} else{echo 'walkinpayment.php';}?>" method="post" onsubmit="return validation()">
								<table width="300px">
									<tr>
										<td>Name</td>
										<td>
											<input type="text" name="username" value="<?php if(substr($sesscustid,0,1)== "C"){echo $row1["CUST_NAME"];}?>"<?php if(substr($sesscustid,0,1)== "C"){echo 'readonly class="readonly"';}?> <?php if((substr($sesscustid,0,1)== "S")||(substr($sesscustid,0,1)== "A")){echo 'placeholder="Customer Name"';}?> oninput="check_name();"/>
											<span id="NameError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>NRIC</td>
										<td><input type="text" name="usernric" value="<?php if(substr($sesscustid,0,1)== "C"){echo $row1["CUST_IC"];}?>"<?php if(substr($sesscustid,0,1)== "C"){echo 'readonly class="readonly"';}?> <?php if((substr($sesscustid,0,1)== "S")||(substr($sesscustid,0,1)== "A")){echo 'placeholder="Customer IC Number"';}?> oninput="check_ic();"/>
										<span id="IcError" class="red">&nbsp;</span></td>
										
									</tr>
									<tr>
										<td>Mobile Number</td>
										<td><input type="text" name="userphone" value="<?php if(substr($sesscustid,0,1)== "C"){echo $row1["CUST_PHONE"];}?>"<?php if(substr($sesscustid,0,1)== "C"){echo 'readonly class="readonly"';}?> <?php if((substr($sesscustid,0,1)== "S")||(substr($sesscustid,0,1)== "A")){echo 'placeholder="Customer Phone Number"';}?> oninput="check_phone();"/>
										<span id="PhoneError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td>Email Address</td>
										<td><input type="text" name="useremailA" value="<?php if(substr($sesscustid,0,1)== "C"){echo $row1["CUST_EMAIL"];}?>"<?php if(substr($sesscustid,0,1)== "C"){echo 'readonly class="readonly"';}?> <?php if((substr($sesscustid,0,1)== "S")||(substr($sesscustid,0,1)== "A")){echo 'placeholder="Customer Email Address"';}?> oninput="check_emailA();">
										<span id="EmailErrorA" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td>Total</td>
										<td><input type="text" name="userttl" value="<?php echo 'RM'.$newtotalprice; ?>" readonly class="readonly"></td>
									</tr>
									
									<input type="hidden" name="tid" value="<?php echo $tid; ?>"/>
								</table>
								<small><input type="checkbox" name="agree" value="agree">I agree to the <a href="#" target="_blank">booking terms & conditions</a>.<br/>
								Please done your payment within 15 minutes, after the 'Proceed to Payment' clicked.</small>
								<input type="submit" name="pay" value="Proceed to Payment" onclick="needToConfirm = false;">
								</form>
								<div id="un"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include 'include/btmnavi.php'; ?>
		</div>
		<script src="popup/js/index.js"></script>
	</body>
</html>