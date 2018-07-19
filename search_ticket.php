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
		$row		 = mysqli_fetch_assoc($result_user);
}

setcookie("checktrans", "", time() - (60 * 60 * 24 * 30), "/");
setcookie("tid", "", time() - (60 * 60 * 24 * 30), "/");
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Book Bus Ticket | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/search_ticket.css" rel="stylesheet" type="text/css">
		
		<script src='popup/js/jquery.min.js'></script>
		<script src='popup/js/jquery.magnific-popup.min.js'></script>
		
		<link rel="stylesheet" type="text/css" href="datepicker/easyui.css">
		<script type="text/javascript" src="datepicker/jquery.easyui.min.js"></script>
		
		<link rel="stylesheet" type="text/css" href="creativebuttons/css/indextab.css" />
		<script>
		$(function(){
            $('#datepicker').datebox().datebox('calendar').calendar({
                validator: function(date){
                    var now = new Date();
                    var d1 = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                    var d2 = new Date(now.getFullYear(), now.getMonth(), now.getDate()+90);
                    return d1<=date && date<=d2;
                }
            });
        });
		
		
		
		var vardepartcity="";
		
		function selectdepartcity(str) {
			if (str == "") {
				document.getElementById("searcharrive").innerHTML = "";
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
						document.getElementById("searcharrive").innerHTML = xmlhttp.responseText;
					}
				}
				xmlhttp.open("GET","include/arrivestate.php?q="+str,true);
				xmlhttp.send();
				vardepartcity = str;
			}
		}
		function selectdepartstate(str) {
			if (str == "") {
				document.getElementById("searchdepartcity").innerHTML = "";
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
						document.getElementById("searchdepartcity").innerHTML = xmlhttp.responseText;
					}
				}
				xmlhttp.open("GET","include/departcity.php?q="+str,true);
				xmlhttp.send();
			}
		}
		
		function selectarrivestate(str) {
			if (str == "") {
				document.getElementById("searcharrivecity").innerHTML = "";
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
						document.getElementById("searcharrivecity").innerHTML = xmlhttp.responseText;
					}
				}
				xmlhttp.open("GET","include/arrivecity.php?q="+str+"&p="+vardepartcity,true);
				xmlhttp.send();
			}
		}
		
		function selectarrivecity(str) {
			if (str == "") {
				document.getElementById("coach_co").innerHTML = "";
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
						document.getElementById("coach_co").innerHTML = xmlhttp.responseText;
					}
				}
				xmlhttp.open("GET","include/coachcompany.php?q="+str+"&p="+vardepartcity,true);
				xmlhttp.send();
			}
		}
		</script>
		<script>
		function validate()
		{	
			var departstate = document.getElementById("searchdepart");
			var selectedValue3 = departstate.options[departstate.selectedIndex].value;
			var arrivestate = document.getElementById("searcharrive");
			var selectedValue4 = arrivestate.options[arrivestate.selectedIndex].value;			
			var arrivecity = document.getElementById("searcharrivecity");
			var selectedValue = arrivecity.options[arrivecity.selectedIndex].value;
			var departcity = document.getElementById("searchdepartcity");
			var selectedValue2 = departcity.options[departcity.selectedIndex].value;
			
			Date.prototype.yyyymmdd = function() {
				var yyyy = this.getFullYear().toString();
				var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
				var dd  = this.getDate().toString();
				return yyyy +'-'+ (mm[1]?mm:"0"+mm[0]) +'-'+ (dd[1]?dd:"0"+dd[0]); // padding
			};

			d = new Date();
			d.yyyymmdd();			
			
			if (selectedValue3 == "none")
			{
				alert("Please select a depart state first to continue...");
				return false;
			}
			else if (selectedValue2 == "none")
			{
				alert("Please select a depart city first to continue...");
				return false;
			}
			else if (selectedValue4 == "none")
			{
				alert("Please select a arrive state first to continue...");
				return false;
			}
			else if (selectedValue == "none")
			{
				alert("Please select a arrive city first to continue...");
				return false;
			}
			else if (document.searchfrm.onedepartdate.value == "" )
			{
				alert("Please select a date first to continue...");
				return false;
			}
			else if (document.searchfrm.onedepartdate.value < (d.yyyymmdd()))
			{
				alert("The date is not valid");
				return false;
			}
			else
			{
				return true;
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
				<div id="search_table">
					<div id="search-table-title">
						<p>Search Ticket</p>
						<hr/>
					</div>
					<?php include 'include/booknavi.php' ?>
					<form name="searchfrm" method="GET" action="search_result.php" onsubmit="return validate();">
						<section class="tabs">
							<input id="tab-1" type="radio" name="radio-set" class="tab-selector-1" checked="checked" />
							<label for="tab-1" class="tab-label-1">One Way Trip</label>
					
							<!--<input id="tab-2" type="radio" name="radio-set" class="tab-selector-2" />
							<label for="tab-2" class="tab-label-2">Round Trip</label>-->
						
							<div class="clear-shadow"></div>
							
							<div class="content">
								<div class="content-1">
									<div id="content-left-content-form">
										<?php include 'include/departarrive.php' ?>
									
										<div id="content-left-content-form-top">
											<div id="content-left-content-form-top-content">
												<div id="date_time">
												<p>Departure Date</p>
													<input name="onedepartdate" id="datepicker" data-options="formatter:myformatter,parser:myparser"/>
													<script type="text/javascript">
														function myformatter(date){
															var y = date.getFullYear();
															var m = date.getMonth()+1;
															var d = date.getDate();
															return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
														}
														function myparser(s){
															if (!s) return new Date();
															var ss = (s.split('-'));
															var y = parseInt(ss[0],10);
															var m = parseInt(ss[1],10);
															var d = parseInt(ss[2],10);
															if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
																return new Date(y,m-1,d);
															} else {
																return new Date();
															}
														}
													</script>
												</div>
												<div id="date_time">
													<p>Depart Time</p>
													<select name="time" id="time" size="1">
														<option value="none">Any Time</option>
														<option value="M">Morning</option>
														<option value="A">Afternoon</option>
														<option value="E">Evening</option>
													</select>
												</div>
											</div>
										</div>
										<div id="search-ticket-group">
											
												<div id="content-left-content-form-top-content">
													<p>Coach Company</p>
													<select name="coach_co" id="coach_co">
														<option value='any'>Any Company</option>
													</select>
												</div>
											
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
														<option value="11">11</option>
														<option value="12">12</option>
														<option value="13">13</option>
														<option value="14">14</option>
														<option value="15">15</option>
														<option value="16">16</option>
														<option value="17">17</option>
														<option value="18">18</option>
														<option value="19">19</option>
														<option value="20">20</option>
														<option value="21">21</option>
														<option value="22">22</option>
														<option value="23">23</option>
														<option value="24">24</option>
														<option value="25">25</option>
														<option value="26">26</option>
														<option value="27">27</option>
														<option value="28">28</option>
														<option value="29">29</option>
														<option value="30">30</option>
													</select>
												</div>
											
										</div>
										<input type="submit" name="search" value="Search" style="float:right" class="btn-search"/></a>
									</div>
								</div>
					</form>
					<form name="searchfrm2" method="GET" action="" onsubmit="">
								<div class="content-2">
									<div id="content-left-content-form">
										<?php include 'include/departarrive2.php' ?>
											<div id="content-left-content-form-top">
												<div id="content-left-content-form-top-content">
													<div id="date_time">
													<p>Departure Date</p>
														<input type="date" name="departdate"/>
													</div>
													<div id="date_time">
														<p>Depart Time</p>
														<select name="time2" id="time2">
															<option value="">Any Time</option>
															<option value="M">Morning</option>
															<option value="A">Afternoon</option>
															<option value="E">Evening</option>
														</select>
													</div>
													<div id="date_time">
													<p>Return Date</p>
														<input type="date" name="returndate"/>
													</div>
													<div id="date_time">
														<p>Return Time</p>
														<select name="time2return" id="time2return">
															<option value="">Any Time</option>
															<option value="M">Morning</option>
															<option value="A">Afternoon</option>
															<option value="E">Evening</option>
														</select>
													</div>
												</div>
											</div>
											<div id="search-ticket-group">
												
													<div id="content-left-content-form-top-content">
														<p>Coach Company</p>
														<select name="coach_co2" id="coach_co2">
															<option value="">Any Company</option>
															<option value="KKL">KKKL</option>
															<option value="DEL">Delima</option>
															<option value="MYS">Mayang Sari</option>
															<option value="TRA">Trasnational</option>
														</select>
													</div>
												
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
											
											<input type="submit" name="search" value="Search" style="float:right" class="btn-search"/></a>
										
									</div>
								</div>
							</div>
						</section>
					</form>
				</div>
				<div id="disclaimer">
					<small>Most of the trips were set up only 1 month in advance.<br/><i>Morning (12 midnight - 11:59AM), Afternoon (12:00PM - 6:59PM), Evening (7:00PM - 11:59PM)</i></small>
				</div>
			</div>
		
			<?php include 'include/btmnavi.php'; ?>
		</div>
		<script src="popup/js/index.js"></script>
	</body>
</html>
