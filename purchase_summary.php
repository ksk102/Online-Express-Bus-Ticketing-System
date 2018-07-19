<?php
	setcookie("checktrans", "1", time() + (60 * 60 * 24), "/");
	require 'Database/db_con.php';
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
		header('Location: search_ticket.php');
	}
	if(isset($_COOKIE['tid']))
	{
		$transid = $_COOKIE['tid'];
	}
	else
	{
		header('Location: search_ticket.php');
	}
	
	$sql_usertype 	 = "SELECT * from transaction where TRANS_ID = '$transid' and CUST_ID is not null";
	$result_usertype = mysqli_query($conn, $sql_usertype);
	$row_usertype	 = mysqli_fetch_assoc($result_usertype);
	$userid = $row_usertype['CUST_ID'];
	
	if($row_usertype>0)
	{
		
		$sql_passenger 	 = "SELECT * from customer where CUST_ID = '$userid'";
		$result_passenger = mysqli_query($conn, $sql_passenger);
		$row_passenger	 = mysqli_fetch_assoc($result_passenger);
		
		$passengername = $row_passenger['CUST_NAME'];
		$passengeric = $row_passenger['CUST_IC'];
		$passengerhp = $row_passenger['CUST_PHONE'];
		$passengeremail = $row_passenger['CUST_EMAIL'];
	}
	else
	{
		$sql_usertype 	 = "SELECT * from transaction where TRANS_ID = '$transid'";
		$result_usertype = mysqli_query($conn, $sql_usertype);
		$row_usertype	 = mysqli_fetch_assoc($result_usertype);
		$userid = $row_usertype['WC_ID'];
	
		$sql_passenger 	 = "SELECT * from walkin where WC_ID = '$userid'";
		$result_passenger = mysqli_query($conn, $sql_passenger);
		$row_passenger	 = mysqli_fetch_assoc($result_passenger);
		
		
		$passengername = $row_passenger['WC_NAME'];
		$passengeric = $row_passenger['WC_IC'];
		$passengerhp = $row_passenger['WC_PHONE'];
		$passengeremail = $row_passenger['WC_EMAIL'];
	}
	
	$sql_trans 	 = "SELECT * from transaction where TRANS_ID = '$transid'";
	$result_trans = mysqli_query($conn, $sql_trans);
	$row_trans	 = mysqli_fetch_assoc($result_trans);
	
	$companycode = $row_trans['COMP_ID'];
	$sql_companyname		= "SELECT * FROM company WHERE COMP_ID = '$companycode' group by COMP_NAME";
	$result_companyname	= mysqli_query($conn, $sql_companyname);
	$row_companyname = mysqli_fetch_array($result_companyname);
	
	$routeid = $row_trans['ROU_ID'];
	
	$sql_route		= "SELECT * FROM route WHERE ROU_ID = '$routeid'";
	$result_route	= mysqli_query($conn, $sql_route);
	$row_route = mysqli_fetch_array($result_route);
	
	$schid = $row_route['SCH_ID'];
	$platform = $row_route["ROU_PLATFORM"];
	
	$sql_sch		= "SELECT * FROM schedule WHERE SCH_ID = '$schid'";
	$result_sch	= mysqli_query($conn, $sql_sch);
	$row_sch = mysqli_fetch_array($result_sch);
	
	$company = $row_companyname['COMP_NAME'];
	$departid = $row_sch['SCH_PICK'];;
	$arriveid = $row_sch['SCH_DROP'];;
	
	$sql_departcityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$departid' group by cityname.city_FULL";
	$result_departarrivecityname	= mysqli_query($conn, $sql_departcityname);
	$row_departcityname = mysqli_fetch_array($result_departarrivecityname);
	$depart=$row_departcityname["CITY_FULL"];
	
	$sql_arrivecityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$arriveid' group by cityname.city_FULL";
	$result_arrivecityname	= mysqli_query($conn, $sql_arrivecityname);
	$row_arrivecityname = mysqli_fetch_array($result_arrivecityname);
	$arrive=$row_arrivecityname["CITY_FULL"];
	
	$route=$depart."<br/>"."-"."<br/>".$arrive;
	$route_pdf = $depart." - ".$arrive;
	
	$departdate = $row_route["ROU_DATE"];
	$departtime = new DateTime($row_sch['SCH_TIME']);
	
	$depart=$departdate."<br/>".$departtime->format('h:i A');
	$depart_pdf = $departdate."   ".$departtime->format('h:i A');
	
	$seatno = $row_trans['TRANS_SEATNO'];
	$price =  $row_trans['TRANS_PRICE'];
 ?>
 
 <html>
	<head>
		<title>Route Detail | BusForAll.com</title>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/purchasesummary.css" rel="stylesheet" type="text/css"/>
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
					<p id="main-content-title">Purchase Summary</p>
					<hr/>
					<div id="maincontent">
						<p>Thank you for booking with BusForAll.com!</p>
						<small>Please retain the following ticket information for your records. You are required to present this ticket receipt to bus company representatives in order to board the bus.</small>
						<table id="passengerinfo">
							<tr>
								<th colspan="2">Passenger Information</th>
							</tr>
							<tr>
								<td>Passenger Name</td>
								<td width="650px">: <b><?php echo $passengername; ?></b></td>
							</tr>
							<tr>
								<td>Passenger IC Number</td>
								<td>:  <b><?php echo $passengeric; ?></b></td>
							</tr>
							<tr>
								<td>Passenger Phone Number</td>
								<td>:  <b><?php echo $passengerhp; ?></b></td>
							</tr>
							<tr>
								<td>Passenger Email Address</td>
								<td>:  <b><?php echo $passengeremail; ?></b></td>
							</tr>
						</table>
						
						<table id="routeinfo">
							<tr>
								<th>Company</th>
								<th>Transaction ID</th>
								<th>Route</th>
								<th>Departure Date/Time</th>
								<th>Seat Number</th>
								<th>Platform</th>
								<th>Ticket Price</th>
							</tr>
							<tr>
								<td><?php echo $company; ?></td>
								<td><?php echo $transid; ?></td>
								<td><?php echo $route; ?></td>
								<td><?php echo $depart; ?></td>
								<td><?php echo $seatno; ?></td>
								<td><?php echo $platform; ?></td>
								<td><?php echo "RM".$price?></td>
							</tr>
						</table>
						<div id="pdfbtn">
							<form name="passpdf" action="pdf/index.php" method="post">
								<input type="hidden" name="passname" value="<?php echo $passengername; ?>">
								<input type="hidden" name="passic" value="<?php echo $passengeric; ?>">
								<input type="hidden" name="passphone" value="<?php echo $passengerhp; ?>">
								<input type="hidden" name="passemail" value="<?php echo $passengeremail; ?>">
								<input type="hidden" name="passcomp" value="<?php echo $company; ?>">
								<input type="hidden" name="passtrans" value="<?php echo $transid; ?>">
								<input type="hidden" name="passrou" value="<?php echo $route_pdf; ?>">
								<input type="hidden" name="passdepart" value="<?php echo $depart_pdf; ?>">
								<input type="hidden" name="passseat" value="<?php echo $seatno; ?>">
								<input type="hidden" name="passprice" value="<?php echo "RM".$price?>">
								<input type="hidden" name="passplatform" value="<?php echo $platform?>">
								<input type="submit" name="dpdf" value="Download as PDF">
							</form>
						</div>
						
						<div id="btmcontent">
							<p>Thanks,<br/>
							BusForAll.com Customer Service Team</p>
						</div>
						<div id="disclaimer">
							<li>You are responsible to make sure your selection on express bus, traveling date, time and destination are correct before clicking "Proceed to Payment". Upon receipt of the fare payment and the issuance of the itinerary, the seats are confirmed immediately. Confirmed seats are non-refundable, non-cancellable and non-changeable. For payment by credit card, you are the owner of the credit card and you are fully aware of this payment. </li>
							<li>You are required to present the NRIC/Passport Number/Driving License and electronic receipt to the check-in counter at least 30 minutes before departure to obtain the boarding ticket(s). Failing to do so, passengers may not be allowed to board the bus. Tickets sold are not refundable. The company is not responsible for any loss of goods or property of the passengers and accident during the journey of your itinerary. </li>
							<li>BusForAll.com nor any of its employees, warrants that the functions contained in this website will be uninterrupted or error-free. The entire risk as to the quality and performance of this website is with the user. In no event will BusForAll.com be liable to the user for any damage, including, but not limited to, service interruptions, or any other circumstances beyond our reasonable control, any lost profits, lost savings or other incidental, consequential, punitive, or special damages arising out of the operation of or inability to operate this BusForAll.com website. BusForAll.com will also not be liable to any action carried out by our coach company partners, or any event happens at our partners' side. For instances, BusForAll.com will not be responsible for any sudden change in coaches, schedules, departure date & time, arrival date & time; loss or accident incurred while taking the coach. However, user may feedback to us, and we will take necessary actions to prevent such things from happen again in the future.</li> 
							<li>Your booking is electronically stored in our system and is subject to conditions of contract. Please bring this receipt on your travel in case any third party requires a proof of purchase. You are reminded to have all valid travel documents e.g. visa and passport with you. You may download or print a copy of this electronic ticket receipt on your personal computer to facilitate your travel. This is a computer generated letter and therefore requires no signature.</li>
						</div>
					</div>
				</div>
			</div>
			<?php include 'include/btmnavi.php'; ?>
		</div>
		<script src="popup/js/index.js"></script>
	</body>
</html>