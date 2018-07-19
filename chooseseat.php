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
		else if (substr($sesscustid,0,1)== "Q")
		{
			header('Location: index.php');
		}
		
		$result_user = mysqli_query($conn, $sql_user);
		$row1		 = mysqli_fetch_assoc($result_user);
	}
	else
	{
		$route = $_GET["q"];
		header('Location: login.php?q='.$route);
	}
	
	if(isset($_GET["q"]))
	{
		$route = $_GET["q"];
	}
	else
	{
		header('Location: search_ticket.php');
	}

	$sql_seat = "select * from seat where ROU_ID='$route' and SEAT_STATUS=1";
	$result_seat = mysqli_query($conn, $sql_seat);
	$bookedseat = array();
	
	$sql_freeseat = "select * from seat where ROU_ID='$route' and SEAT_STATUS=0";
	$result_freeseat = mysqli_query($conn, $sql_freeseat);
	$rowcount = mysqli_num_rows($result_freeseat);
	if($rowcount < 1)
	{
		header('Location: search_ticket.php');
	}

	while($row = mysqli_fetch_assoc($result_seat))
	{
		$bookedseat[] = $row['SEAT_NO'];
	}
?>

<html>
	<head>
		<title>Select Seat(s) | BusForAll.com</title>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/chooseseat.css" rel="stylesheet" type="text/css"/>
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
						<p id="main-content-title">Select Seat(s)</p>
						<hr/>
						<?php include 'include/booknavi.php' ?>
					<div id="maincontent">
						<form name="seat-form" id="seat-form" action="ticket-summary.php" method="post" onsubmit="return validation()">
							<div id="holder"> 
								<ul  id="place">
								</ul>    
							</div>
							<div id="seatdes"> 
								<ul id="seatDescription">
									<li style="background:url('images/seatselection/availableseatsicon.png') no-repeat scroll 0 0 transparent;">Available Seat</li>
									<li style="background:url('images/seatselection/bookedseatsicon.png') no-repeat scroll 0 0 transparent;">Booked Seat</li>
									<li style="background:url('images/seatselection/selectedseatsicon.png') no-repeat scroll 0 0 transparent;">Selected Seat</li>
								</ul>
							</div>
							<div id="seatselected">
								<table>
									<tr>
										<td>Seat(s)</td>
										<td>:</td>
										<td><input type="text" name="sseat" id="sseat" readonly style="width:500px;border:none;background-color:white;"></td>
									</tr>
									<tr>
										<td>Child(s)</td>
										<td>:</td>
										<td><input type="number" name="paxqty" id="childqty" disabled="disabled" style="width:60px;padding:2px;" ></td>
									</tr>
						   
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td style="font-size:8pt;font-style:italic;"><span style="color:#FF0000;">Note :</span><br />Please specify how many<br /> children below 12-year-old.</td>
									</tr>
									<input type="hidden" name="routeid" value="<?php echo $route; ?>">
								</table>
							</div>
							<div id="continuebtn">
								<input type="submit" name="confirmbtn" id="confirmbtn" value="Continue"/>
							</div>
						</form>
					</div>
				</div>
			</div>
			<?php include 'include/btmnavi.php'; ?>
		</div>
		<script src="popup/js/index.js"></script>
	</body>
</html>
		<script>
		var settings = {
               rows: 3,
               cols: 10,
               rowCssPrefix: 'row-',
               colCssPrefix: 'col-',
               seatWidth: 35,
               seatHeight: 35,
               seatCss: 'seat',
               selectedSeatCss: 'selectedSeat',
               selectingSeatCss: 'selectingSeat'
           };
		</script>
		<script>
		var init = function (reservedSeat) {
						var str = [], seatNo, className;
						for (i = 0; i < settings.rows; i++) {
							for (j = 0; j < settings.cols; j++) {
								seatNo = (i + j * settings.rows + 1);
								
								className = settings.seatCss + ' ' + settings.rowCssPrefix + i.toString() + ' ' + settings.colCssPrefix + j.toString();
								if ($.isArray(reservedSeat) && $.inArray(seatNo, reservedSeat) != -1) {
									className += ' ' + settings.selectedSeatCss;
								}
								
								//console.log();
								str.push('<li class="' + className + '"' +
										  'style="top:' + (i * settings.seatHeight).toString() + 'px;left:' + (j * settings.seatWidth).toString() + 'px">' +
										  '<a title="' + seatNo + '">' + seatNo + '</a>' +
										  '</li>');
							}
						}
						$('#place').html(str.join(''));
					};
					//case I: Show from starting
					//init();
		 
					//Case II: If already booked
					<?php
					$seatlength = count($bookedseat);
					?>
					var bookedSeats = [
					<?php
					for($i=0;$i<$seatlength;$i++)
					{
					?>
						<?php echo $bookedseat[$i];echo ','; ?>
					<?php
					}
					?>
						];
						init(bookedSeats);
		</script>
		
		<script>
		var count=0;
		var child = 0;
		
		$('.' + settings.seatCss).click(function () {
		
		if ($(this).hasClass(settings.selectedSeatCss)){
			alert('This seat is already reserved');
		}
		else{
			$(this).toggleClass(settings.selectingSeatCss);
			}
			
		if ($(this).hasClass(settings.selectingSeatCss)){
			count++;
				if(count>0)
					$("input[name=paxqty]").removeAttr("disabled");
		}
		else if($(this).hasClass(settings.selectingSeatCss)==false){
			count--;
			if(count<=0)
			{
				$("input[name=paxqty]").prop("disabled",true);
				$("input[name=paxqty]").prop("value",0);
			}
		}
		});
		 
		$('#btnShow').click(function () {
			var str = [];
			$.each($('#place li.' + settings.selectedSeatCss + ' a, #place li.'+ settings.selectingSeatCss + ' a'), function (index, value) {
				str.push($(this).attr('title'));
			});
			alert(str.join(','));
		})
		 
		$('#place').click(function () {
			var str = [], item;
			$.each($('#place li.' + settings.selectingSeatCss + ' a'), function (index, value) {
				item = $(this).attr('title');                   
				str.push(item);                   
			});
			$('#sseat').val(str.join(','));
		})
		
		$("#confirmbtn").click(function(e) {
			child = +$("#childqty").val();
		});
		function validation()
		{
			if(count==0)
			{
				alert("Please select at least one seat to proceed.");
				return false;
			}
			else if(child==count)
			{
				alert("Children must be accompanied by at least 1 adult.");
				return false;
			}
			else if(child>count)
			{
				alert("The children quantity you've enter doesn't match the total seats you've selected.");
				return false;
			}
			else
			{
				return true;
			}
		}
		</script>