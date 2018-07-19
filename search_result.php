<?php 

require 'database/db_con.php';

if (isset($_GET["search"]))
{
	$depart = $_GET["searchdepartcity"];
	$arrive = $_GET["searcharrivecity"];
	$departdate= $_GET["onedepartdate"];
	date_default_timezone_set("Asia/Kuala_Lumpur");
	
	if(!isset($_GET["searchdepartcity"]) || !isset($_GET["searcharrivecity"]) || !isset($_GET["seatno"]) || !isset($_GET["onedepartdate"]))
	{
		header('Location: search_ticket.php');
	}
	
	if($departdate == date("Y-m-d"))
	{
		$timenow = date("h:i:sa");
		$time_sql = "schedule.SCH_TIME > '$timenow' and";
	}
	else
	{
		$time_sql = "";
	}
	$departtimefrom = '00:00:00';
	$departtimearrive = '23:59:59';
	$coachcomp = "IS NOT NULL";
	
	if(isset($_GET["time"]))
	{
		if($_GET["time"]=='none')
		{
			$departtimefrom = '00:00:00';
			$departtimearrive = '23:59:59';
		}
		else if($_GET["time"]=='M')
		{
			$departtimefrom = '00:00:00';
			$departtimearrive = '11:59:59';
		}
		else if($_GET["time"]=='A')
		{
			$departtimefrom = '12:00:00';
			$departtimearrive = '18:59:59';
		}
		else if($_GET["time"]=='E')
		{
			$departtimefrom = '19:00:00';
			$departtimearrive = '23:59:59';
		}
	}
	if(isset($_GET["time"]))
	{
		if($_GET["coach_co"] == "any")
		{
			$coachcomp = "IS NOT NULL";
		}
		else
		{
			$coachcomp = "=".'"'.$_GET["coach_co"].'"';
		}
	}
	
	$seat= $_GET["seatno"];
	$sql = "select * from schedule inner join route on route.sch_id=schedule.sch_id where schedule.SCH_PICK = '$depart' and schedule.SCH_DROP ='$arrive' and route.ROU_DATE = '$departdate' and schedule.COMP_ID $coachcomp and route.ROU_RSEAT >= $seat and route.ROU_RSEAT>0 and $time_sql schedule.SCH_TIME between '$departtimefrom' and '$departtimearrive'";
	$result = mysqli_query($conn, $sql);
} 
else
{
	header('Location: search_ticket.php');
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Search Result | BusForAll.com</title>
        <link rel="shortcut icon" href="images/icon/step/travel.png"/>
        <link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css"/>
		<link href="css-folder/search-result.css" rel="stylesheet" type="text/css"/>
		
		<script src='popup/js/jquery.min.js'></script>
		<script src='popup/js/jquery.magnific-popup.min.js'></script>
		
		<style type="text/css">
		.departarrive
		{
			border:1px solid #999999;
			float:left;
			width:330px;
			height:190px;
			margin-top:-1px;
		}
		
		table tr td
		{
			text-align:center;
		}
		</style>
	</head>

	<body>
    	<div id="container">
			<?php
				include 'include/header.php';
			?>
			<div id="content">
				<!--<div id="content-left">
					<form name="searchfrm" method="" action="">
						<div id="content-left-title"><p>Search Bus Ticket</p></div>
							<div id="content-left-trip">
								<div id="content-left-trip-navi">
									<ul>
										<li style="color:#444444;background-color:white;">One Way Trip</li>
									</ul>
								</div>
								<div id="content-left-trip-navi">
									<ul>
										<a href="#"><li>Round Trip</li></a>
									</ul>
								</div>
							</div>
							<div id="content-left-content-form">
								<div class="departarrive">
									<div id="content-left-content-form-top-content">
										<p>Depart From</p>
											<select id="seacrhdepart" size="1" onchange="selectdepart()">
												<option value="none" selected>--Select a State--</option>
												<optgroup label="Central Region">
													<option value="KUL">Kuala Lumpur</option>
													<option value="NSN">Negeri Sembilan</option>
													<option value="SGR">Selangor</option>
												</optgroup>
												<optgroup label="Southern Region">
													<option value="JHR">Johor</option>
													<option value="MLK">Malacca</option>
												</optgroup>
												<optgroup label="Northern Region">
													<option value="KDH">Kedah</option>
													<option value="PRK">Perak</option>
													<option value="PLS">Perlis</option>
													<option value="PNG">Pulau Pinang</option>
												</optgroup>
												<optgroup label="East Coast Region">
													<option value="KTN">Kelantan</option>
													<option value="PHG">Pahang</option>
													<option value="TRG">Terengganu</option>
												</optgroup>
											</select>
									</div>
										<div id="content-left-content-form-top-content">
											<div style="margin-top:45px;">
											<span id="depart"></span>
											</div>
										</div>
									<div id="content-left-content-form-top-content">
										<p>Arrive To</p>
											<select id="seacrharrive" size="1" onchange="selectarrive()">
											<option value="none" selected>--Select a State--</option>
											<optgroup label="Central Region">
												<option value="KUL">Kuala Lumpur</option>
												<option value="NSN">Negeri Sembilan</option>
												<option value="SGR">Selangor</option>
											</optgroup>
											<optgroup label="Southern Region">
												<option value="JHR">Johor</option>
												<option value="MLK">Malacca</option>
											</optgroup>
											<optgroup label="Northern Region">
												<option value="KDH">Kedah</option>
												<option value="PRK">Perak</option>
												<option value="PLS">Perlis</option>
												<option value="PNG">Pulau Pinang</option>
											</optgroup>
											<optgroup label="East Coast Region">
												<option value="KTN">Kelantan</option>
												<option value="PHG">Pahang</option>
												<option value="TRG">Terengganu</option>
											</optgroup>
										</select>
									</div>
									<div id="content-left-content-form-top-content">
										<div style="margin-top:45px;">
										<span id="arrive"></span>
										</div>
									</div>
								</div>
								<div id="content-left-content-form-top">
									<div id="content-left-content-form-top-content">
										<p>Departure Date</p>
											<input type="date" name="departdate"/>
									</div>
								</div>
								<div id="content-left-content-form-top">
									<div id="content-left-content-form-top-content">
										<p>Between</p>
											<input type="time" name="time" value="00:00"/>
									</div>
									<div id="content-left-content-form-top-content">
										<p>To</p>
											<input type="time" name="time" value="23:59"/>
									</div>
								</div>
								<div id="content-left-content-form-top">
									<div id="content-left-content-form-top-content">
										<p>Number of Seat</p>
										<select name="seatno">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
										</select>
									</div>
								</div>
								<div id="content-left-content-form-top">
									<div id="content-left-content-form-top-content">
										<p>Bus Operator</p>
											<select name="busoperator">
												<option value="All">All</option>
												<option value="KKKL">KKKL</option>
												<option value="MayangSari">Mayang Sari</option>
												<option value="Maharani">Maharani</option>
												<option value="CityExpress">City Express</option>
												<option value="Transnational">Transnational</option>
											</select>
									</div>
								</div>
								<input type="button" name="search" value="Search"/>
							</div>
					</form>
				</div>-->
				<!--<a name="Search-Result"></a>-->
				<div id="main-content" style="padding-top:10px;">
					<p id="main-content-title">Search Result</p>
					<hr/>
					<?php include 'include/booknavi.php' ?>
					
					
					<?php
					
						$sql_departcityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$depart' group by cityname.city_FULL";
						$result_departarrivecityname	= mysqli_query($conn, $sql_departcityname);
						
						while ($row = mysqli_fetch_array($result_departarrivecityname))
						{
							$pickup=$row["CITY_FULL"];
						}
						
						$sql_arrivecityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$arrive' group by cityname.city_FULL";
						$result_arrivecityname	= mysqli_query($conn, $sql_arrivecityname);
						
						while ($row = mysqli_fetch_array($result_arrivecityname))
						{
							$dropoff=$row["CITY_FULL"];
						}
					?>
					<?php echo $pickup ." to ". $dropoff . " (" . $departdate . ")" ?>
					<div id="main-content-result">
						<table border="0px" width="800px">
							<?php
							$rowcount = mysqli_num_rows($result);
							if ($rowcount == 0)
								echo "No records found";
							else
							{
								?>
									<tr>
										<th height="40px" width="180px">Operator</th>
										<th width="90px">Depart</th>
										<th width="90px">Arrive <br/>(Estimated)</th>
										<th width="">Pick up</th>
										<th width="">Drop off</th>
										<th width="90px" >Price</th>
										<th width="90px"></th>
									</tr>
								<?php
								while($row = mysqli_fetch_assoc($result))
								{
									$routeid = $row['ROU_ID'];
									$price = $row["SCH_PRICE"];
									
									$companyid=$row["COMP_ID"];
									$sql_companyname		= "SELECT * FROM company WHERE COMP_ID = '$companyid' group by COMP_NAME";
									$result_companyname	= mysqli_query($conn, $sql_companyname);
									
									$arrivetime = new DateTime($row["SCH_TIME"]);
									$arrivetime->add(new DateInterval('PT'.$row["SCH_DURATION"]));
									$departtime = new DateTime($row["SCH_TIME"]);
									?>
									
									<tr>
									<?php
									while ($row = mysqli_fetch_array($result_companyname))
									{
									?>
										<td height="80px"><a href="company_detail.php?comp_id=<?php echo $companyid ?>" target="_blank"><?php echo '<img width="120px" height="43px" src="data:image;base64,'.$row['COMP_IMG'].' "> ';?><br/><?php echo $row['COMP_NAME']; ?></a></td>
									<?php
									}
									?>
										<td><?php echo $departtime->format('h:i A'); ?></td>
										<td><?php echo $arrivetime->format('h:i A'); ?></td>
										<td><?php echo $pickup; ?></a></td>
										<td><?php echo $dropoff; ?></a></td>
										
										<td><?php echo "RM",$price; ?></td>
										<td><a href="chooseseat.php?q=<?php echo $routeid; ?>"><input type="button" name="selected" value="Select"></a><br/><small><a href="route_detail.php?q=<?php echo $routeid; ?>" target="_blank">Detail</a></small></td>
									</tr>
									<?php
								}
							}
							?>
							<!--<tr>
								<td height="80px"><a href="#" target="_self"><img src="images/bus-operator/kkkl.jpg" width="120px" height="43px"/><br/>KKKL Express</a></td>
								<td>04:45 PM</td>
								<td>06:45 PM</td>
								<td><a href="#" target="_self">Terminal Larkin</a></td>
								<td><a href="#" target="_self">Terminal Muar</a></td>
								
								<td>RM16.70</td>
								<td><input type="button" name="selected" value="Select"><br/><small><a href="#">Detail</a></small></td>
							</tr>-->
						</table>
					</div>
				</div>
			</div>
			
			<?php include 'include/btmnavi.php'; ?>
		</div>
		<script src="popup/js/index.js"></script>
	</body>
</html>
