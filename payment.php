<?php 
require 'database/db_con.php';
date_default_timezone_set("Asia/Kuala_Lumpur");
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

if(isset($_COOKIE['checktrans']))
{
	header('Location: search_ticket.php');
}

$sql_trans 	 = "SELECT * from transaction where TRANS_ID = '$_COOKIE[transid]'";
$result_trans = mysqli_query($conn, $sql_trans);
$row_trans		 = mysqli_fetch_assoc($result_trans);

if($row_trans < 1)
{
	header('Location: search_ticket.php');
}
	
if(isset($_POST["userttl"]))
{
	$transid = $_COOKIE['transid'];
	
	$totalamount = $_POST["userttl"];
	$cookie_name = "transid";
	$cookie_value = $transid;
	setcookie($cookie_name, $cookie_value, time() + (60 * 15 + 5), "/");
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
		<link href="css-folder/payment.css" rel="stylesheet" type="text/css"/>
		
		<style>
			.red { font-size:10pt; font-style:italic; color:red }
		</style>
		
		<script src='popup/js/jquery.min.js'></script>
		<script src='popup/js/jquery.magnific-popup.min.js'></script>
		<script>
		// Javascript code copyright 2009 by Fiach Reid : www.webtropy.com
 		// This code may be used freely, as long as this copyright notice is intact.
		function Calculate(Luhn) {
			
			var sum = 0;
			for (i=0; i<Luhn.length; i++ ) {
				sum += parseInt(Luhn.substring(i,i+1));
			}
			
			var delta = new Array (0, 1, 2, 3, 4, -4, -3, -2, -1, 0);
			for (i=Luhn.length-1; i>=0; i-=2 ) {		
				var deltaIndex = parseInt(Luhn.substring(i, i + 1));
				var deltaValue = delta[deltaIndex];	
				sum += deltaValue;
			}	
		
			var mod10 = sum % 10;
			mod10 = 10 - mod10;	
			
			if (mod10 == 10) {		
				mod10 = 0;
			}
			
			return mod10;
			
		}

		function Validate(Luhn) {
			
			Luhn = Luhn.replace(/\s/g, '');			
			
			var LuhnDigit = parseInt(Luhn.substring(Luhn.length-1, Luhn.length));
			var LuhnLess = Luhn.substring(0,Luhn.length-1);
			
			if (Calculate(LuhnLess) == parseInt(LuhnDigit)) {
				return true;
			}	
			
			return false;

		}			
		
		function validateCreditCard() {
			var toValidate = $("#creditCardNumber").val();
			var result = Validate(toValidate);
			
			if(result == false)
			{
				document.getElementById('validationResult').innerHTML = ' The number is NOT valid!';
				return false;
			}
			else
			{
				document.getElementById('validationResult').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
			//$("#validationResult").text(result ? "The number is valid!" : "The number is NOT valid!").show();
		}
		
		/*
			Javascript credit card number generator 
			Copyright (C) 2006 Graham King graham@darkcoding.net
	
			This program is free software; you can redistribute it and/or
			modify it under the terms of the GNU General Public License
			as published by the Free Software Foundation; either version 2
			of the License, or (at your option) any later version.
	
			This program is distributed in the hope that it will be useful,
			but WITHOUT ANY WARRANTY; without even the implied warranty of
			MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
			GNU General Public License for more details.
	
			You should have received a copy of the GNU General Public License
			along with this program; if not, write to the Free Software
			Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
	
			www.darkcoding.net
		*/
		</script>
		<script>
		function check_type()
		{
			if (document.paymentfrm.cardtype.value == "none")
			{
				document.getElementById('TypeError').innerHTML = ' Please select card type';
				return false;
			}
			else
			{
				document.getElementById('TypeError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';	
				return true;
			}
		}
		
		function check_fname()
		{
			if (document.paymentfrm.cardfname.value == "" || !(isNaN(document.paymentfrm.cardfname.value)) || (/\d/.test(document.paymentfrm.cardfname.value)))
			{
				document.getElementById('fNameError').innerHTML = ' Enter the correct name';		
				return false;
			}
			else
			{
				document.getElementById('fNameError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';	
				return true;
			}
		}
		function check_lname()
		{
			if (document.paymentfrm.cardlname.value == "" || !(isNaN(document.paymentfrm.cardlname.value)) || (/\d/.test(document.paymentfrm.cardlname.value)))
			{
				document.getElementById('lNameError').innerHTML = ' Enter the correct name';		
				return false;
			}
			else
			{
				document.getElementById('lNameError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';	
				return true;
			}
		}
		function check_date()
		{
			
			var d = new Date();
			var n = d.getMonth();
			var thismonth = n+1;
			
			var yd = new Date();
			var yn = d.getFullYear();
			var thisyear = yn;
					
			if (document.paymentfrm.cardmm.value == "none")
			{
				document.getElementById('DateError').innerHTML = ' Please select a month';
				return false;
			}
			else
			{
				if (document.paymentfrm.cardyyyy.value == "none")
				{
					document.getElementById('DateError').innerHTML = ' Please select a year';
					return false;
				}
				else
				{
					if((document.paymentfrm.cardmm.value < thismonth ) && (document.paymentfrm.cardyyyy.value == thisyear))
					{
						document.getElementById('DateError').innerHTML = ' The date is expired';
						return false;
					}
					else
					{
						document.getElementById('DateError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
						return true;
					}
				}
			}
		}
		function check_csc()
		{
			if (document.paymentfrm.cardcsc.value == "" || isNaN(document.paymentfrm.cardcsc.value) || document.paymentfrm.cardcsc.value.length > 3 || document.paymentfrm.cardcsc.value.length < 3)
			{
				document.getElementById('cscError').innerHTML = ' Enter the correct Security Code';		
				return false;
			}
			else
			{
				document.getElementById('cscError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';	
				return true;
			}
		}
		
		function validate()
		{
			if (check_type() && check_fname() && check_lname() && validateCreditCard() && check_date() && check_csc())
			{
				return true;
			}
			else
			{
				alert("Please check your information again");
				return false;
			}
		}
		</script>
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
	</head>
	<body>
    	<body>
    	<div id="container">
			<?php
				include 'include/header.php';
			?>
			<div id="content">
				<div id="main-content" style="padding-top:10px;">
					<p id="main-content-title">Purchase Payment</p>
					<hr/>
					<div>You reservation will be cancelled in <span id="countdown" class="timer">15:00</span> minute(s)</div>
					<?php include 'include/booknavi.php' ?>
					
					<div id="main-content-result">
						<form name="paymentfrm" id="paymentfrm" action="" method="post" onsubmit="return validate();">
							<table border="0px" width="800px">
								<tr>
									<td width="150px" style="text-align:right;padding-right:10px;">Total Amount</td>
									<td><input type="text" name="ttlamount" value="<?php echo $totalamount;?>" readonly class="readonly"/></td>
								</tr>
									<td width="150px" style="text-align:right;padding-right:10px;">Card Type<span class="red">*</span></td>
									<td>
										<select name="cardtype" oninput="check_type();">
											<option value="none">--Select your Card Type--</option>
											<option value="visa">VISA</option>
											<option value="master">MASTERCARD</option>
										</select>
										<span id="TypeError" class="red" style="font-size:9pt">&nbsp;</span>
									</td>
								</tr>
								<tr>
									<td width="200px" style="text-align:right;padding-right:10px;">Cardholder's First Name<span class="red">*</span></td>
									<td><input type="text" name="cardfname" oninput="check_fname();"><span id="fNameError" class="red">&nbsp;</span></td>
								</tr>
								<tr>
									<td width="150px" style="text-align:right;padding-right:10px;">Cardholder's Last Name<span class="red">*</span></td>
									<td><input type="text" name="cardlname" oninput="check_lname();"><span id="lNameError" class="red">&nbsp;</span></td>
								</tr>
								<tr>
									<td width="150px" style="text-align:right;padding-right:10px;">Credit Card Number<span class="red">*</span></td>
									<td><input type="text" name="creditCardNumber" id="creditCardNumber" maxlength="19" oninput="javascript:validateCreditCard();"><span id="validationResult" class="red" style="font-size:8pt"></span></td>
								</tr>
								<tr>
									<td width="150px" style="text-align:right;padding-right:10px;">Expiration Date<span class="red">*</span></td>
									<td>
										<select name="cardmm" style="width:80px;" oninput="check_date();">
											<option value="none">MM</option>
											<option value="01">01</option>
											<option value="02">02</option>
											<option value="03">03</option>
											<option value="04">04</option>
											<option value="05">05</option>
											<option value="06">06</option>
											<option value="07">07</option>
											<option value="08">08</option>
											<option value="09">09</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
										</select>
										
										<span style="font-size:18pt;line-height:25px;"> /</span>
										
										<select name="cardyyyy" style="width:80px;" oninput="check_date();">
											<option value="none">YYYY</option>
											<option value="2015">2015</option>
											<option value="2016">2016</option>
											<option value="2017">2017</option>
											<option value="2018">2018</option>
											<option value="2019">2019</option>
											<option value="2020">2020</option>
											<option value="2021">2021</option>
											<option value="2022">2022</option>
											<option value="2023">2023</option>
											<option value="2024">2024</option>
											<option value="2025">2025</option>
										</select>
										<span id="DateError" class="red"></span>
									</td>
								</tr>
								<tr>
									<td width="150px" style="text-align:right;padding-right:10px;">Security Code (CSC)<span class="red">*</span></td>
									<td><input type="password" name="cardcsc" value="" oninput="check_csc()"><span id="cscError" class="red" style="font-size:7pt;" >&nbsp;</span></td>
								</tr>
							</table>
							<p width="150px" style="text-align:left;padding-right:10px;"><span class="red">* Required field</span></p>
							<div id="confirm-btn">
								<input type="submit" name="confirmbtn" value="Complete Purchase" onclick="needToConfirm = false;"/>
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

<?php
if(isset($_POST["confirmbtn"]))
{
	$transdate = date("Y-m-d");
	$transtime = date("h:i:sa");
	
	$sql_confirmtrans = "UPDATE transaction SET TRANS_DATE='$transdate', TRANS_TIME = '$transtime',TRANS_STATUS='0' where TRANS_ID='$_COOKIE[transid]'";
	mysqli_query($conn, $sql_confirmtrans);
	
	$transid = $_COOKIE['transid'];

	$cookie_name = "tid";
	$cookie_value = $transid;
	setcookie($cookie_name, $cookie_value, time() + (60 * 60 + 24), "/");
	
	header("Location: purchase_summary.php");
}
?>