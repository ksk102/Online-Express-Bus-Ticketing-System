<?php 

require 'database/db_con.php';

if (isset($_GET["search"]))
{
	$depart = $_GET["searchdepartcity"];
	$arrive = $_GET["searcharrivecity"];
	if($_GET["departdate"]!="")
	{
		$departdate= $_GET["departdate"];
	}
	else
	{
		$departdate= $_GET["onedepartdate"];
	}
	$seat= $_GET["seatno"];
	$sql = "select * from schedule where SCH_PICK = '$depart' and SCH_DROP ='$arrive'";
	$result = mysqli_query($conn, $sql);
	$result1 = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Search Result | BusForAll.com</title>
        <link rel="shortcut icon" href="images/icon/step/travel.png"/>
        <link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css"/>
		<link href="css-folder/search-result.css" rel="stylesheet" type="text/css"/>
		
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
		
		<script src="js-folder/index.js" type="text/javascript"></script>
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
					$row1 = mysqli_fetch_assoc($result1);
					if($row1["SCH_PICK"]=="JLRK")
					{
						$pickup="Larkin Terminal";
					}
					if($row1["SCH_DROP"]=="JMUR")
					{
						$dropoff="Muar Terminal";
					}
					if($row1["SCH_DROP"]=="JLRK")
					{
						$dropoff="Larkin Terminal";
					}
					if($row1["SCH_PICK"]=="JMUR")
					{
						$pickup="Muar Terminal";
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
										<th>Depart</th>
										<th>Arrive <br/>(Estimated)</th>
										<th>Pick up</th>
										<th>Drop off</th>
										
										<th>Price</th>
										<th></th>
									</tr>
								<?php
								while($row = mysqli_fetch_assoc($result))
								{
									$arrivetime = new DateTime($row["SCH_TIME"]);
									$arrivetime->add(new DateInterval('PT'.$row["SCH_DURATION"]));
									$arrivetime->add(new DateInterval('PT'.$row["SCH_RESTTIME"]));
									$departtime = new DateTime($row["SCH_TIME"]);
									?>
									
									<tr>
										<td height="80px"><a href="#" target="_self"><img src="images/bus-operator/kkkl.jpg" width="120px" height="43px"/><br/><?php echo "picture"; ?></a></td>
										<td><?php echo $departtime->format('h:i A'); ?></td>
										<td><?php echo $arrivetime->format('h:i A'); ?></td>
										<td><a href="#" target="_self"><?php echo $pickup; ?></a></td>
										<td><a href="#" target="_self"><?php echo $dropoff; ?></a></td>
										
										<td><?php echo "RM",$row["SCH_PRICE"]; ?></td>
										<td>
											<div class="links">
												<div id="inline-popups">
													<a href="#test-popup" data-effect="mfp-zoom-out"><input type="button" name="selected" value="Select"></a>
												</div>
											</div>
											<br/>
											<small><a href="#">Detail</a></small>
										</td>
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
					<div id="page-selection">
						<ul>
							<li style="text-decoration:underline;">1</li>
							<a href="#" target="_self"><li>2</li></a>
							<a href="#" target="_self"><li>3</li></a>
							<a href="#" target="_self"><li>4</li></a>
							<a href="#" target="_self"><li style="border-right:1px solid black;">5</li></a>
							<a href="#" target="_self"><li style="width:80px;">Next Page</li></a>
						</ul>
					</div>
					<?php include 'include/selectseat.php' ?>
				</div>
			</div>
			<?php include 'include/btmnavi.php'; ?>
		</div>
		<?php include 'include/popup_jq.php'; ?>
	</body>
</html>
