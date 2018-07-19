<?php 

require 'Database/db_con.php';

	if(isset($_SESSION['sess_uid']))
	{
		header("Location: index.php");
	}

//Retrieve the last customer ID
$sql_cust	= "SELECT CUST_ID from customer ORDER BY CID DESC LIMIT 1";
$result_sql	= mysqli_query($conn, $sql_cust);
$row		= mysqli_fetch_assoc($result_sql);
$lastcustid	= $row['CUST_ID'];

if($row<1)
{
	$custid_alpa = 'C_';
	$custid_num	 = 0;

	++$custid_num;
	$custid_numext = str_pad($custid_num,2,"0", STR_PAD_LEFT);
	$custidfinal   = $custid_alpa.$custid_numext;
}
else
{
	$custid1	 = preg_split('/_/', $lastcustid);
	$custid_alpa = 'C_';
	$custid_num	 = $custid1[1];

	++$custid_num;
	$custid_numext = str_pad($custid_num,2,"0", STR_PAD_LEFT);
	$custidfinal   = $custid_alpa.$custid_numext;

	//print_r($custid1);
	//print "<br>";
	//echo $custidfinal;
}
//END: Retrieve the last customer ID
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Sign Up | BusForAll.com</title>
		
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css"/>
       <link href="css-folder/Signup.css" rel="stylesheet" type="text/css"/>
		
		<style rel="stylesheet" type="text/css">
		.red { font-size:10pt; font-style:italic; color:red }
		
		#passwordStrength
		{
			height:20px;
			display:block;
			float:left;
			border:1px solid silver;
			border-radius:5px;
			margin-bottom:5px;
			margin-top:2px;
			padding-left:5px;
		}
		#passwordDescription
		{
			font-size:10pt;
		}

		.strength0
		{
			width:230px;
			background:#999;
		}

		.strength1
		{
			width:46px;
			background:#ff0000;
		}

		.strength2
		{
			width:92px;	
			background:#ff5f5f;
		}

		.strength3
		{
			width:138px;
			background:#56e500;
		}

		.strength4
		{
			background:#4dcd00;
			width:184px;
		}

		.strength5
		{
			background:#399800;
			width:230px;
		}
		</style>
		
		<script>
		//Live Validation
		function check_name()
		{
			if (document.signupfrm.cust_name.value == "" || !(isNaN(document.signupfrm.cust_name.value)) || (/\d/.test(document.signupfrm.cust_name.value)))
			{
				document.getElementById('NameError').innerHTML = " Please enter the correct name";
				return false;
			}
			else
			{
				document.getElementById('NameError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		function check_email()
		{
			if (document.signupfrm.cust_email.value == "" || !(isNaN(document.signupfrm.cust_email.value)) || document.signupfrm.cust_email.value.indexOf("@") == -1 || document.signupfrm.cust_email.value.indexOf(".com") == -1)
			{
				document.getElementById('EmailError').innerHTML = ' Enter the correct email';		
				return false;
			}
			else
			{
				document.getElementById('EmailError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		function check_pw()
		{
			if (document.signupfrm.cust_password.value == "")
			{
				document.getElementById('PwError').innerHTML = ' Enter your password';
				return false;
			}
			else
			{
				if (document.signupfrm.cust_password.value.length <4)
				{
					document.getElementById('PwError').innerHTML = ' Password must have minimum 4 characters';
					return false;
				}
				else
				{
					document.getElementById('PwError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
					return true;
				}
			}
		}
		function check_repw()
		{
			if (document.signupfrm.cust_repassword.value == "")
			{
				document.getElementById('RepwError').innerHTML = " Password doesn't match";
				return false;
			}
			else
			{
				if (document.signupfrm.cust_repassword.value !== document.signupfrm.cust_password.value)
				{
					document.getElementById('RepwError').innerHTML = " Password doesn't match";
					return false;
				}
				else
				{
					document.getElementById('RepwError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
					return true;
				}
			}
		}
		function check_ic()
		{		
			if (document.signupfrm.cust_ic.value.length < 12 && document.signupfrm.cust_ic.value.length > 0 || document.signupfrm.cust_ic.value.length > 12 || (isNaN(document.signupfrm.cust_ic.value)) || document.signupfrm.cust_ic.value == "")
			{
				document.getElementById('IcError').innerHTML = ' Enter the correct IC Number';		
				return false;
			}
			else
			{
				document.getElementById('IcError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';	
				return true;
			}
		}
		function check_dob()
		{
			if (document.signupfrm.cust_dob.value == "")
			{
				document.getElementById('DobError').innerHTML = ' Enter your date of birth';
				return false;
			}
			else
			{
				document.getElementById('DobError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		function check_phone()
		{
			if (document.signupfrm.cust_phone.value == "" || document.signupfrm.cust_phone.value.length < 9 || document.signupfrm.cust_phone.value.length > 11 || isNaN(document.signupfrm.cust_phone.value))
			{
				document.getElementById('PhoneError').innerHTML = ' Enter the correct phone number';		
				return false;
			}
			else
			{
				document.getElementById('PhoneError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		function validate()
		{
			if(check_name() && check_email() && check_pw() && check_repw() && check_ic() && check_dob() && check_phone())
			{
				return true;
			}
			else
			{
				alert("Please check your information again");
				return false;
			}
		}
		//END: Live Validation
		</script>
	</head>
	
	<script type="text/javascript">
	//Password Strength Checker
	function passwordStrength(password)
	{
		var desc = new Array();
		desc[0] = "Very Weak";
		desc[1] = "Weak";
		desc[2] = "Better";
		desc[3] = "Medium";
		desc[4] = "Strong";
		desc[5] = "Strongest";

		var score   = 0;

		//if password bigger than 6 give 1 point
		if (password.length > 4) score++;

		//if password has both lower and uppercase characters give 1 point	
		if ( ( password.match(/[a-z]/) ) && ( password.match(/[A-Z]/) ) ) score++;

		//if password has at least one number give 1 point
		if (password.match(/\d+/)) score++;

		//if password has at least one special caracther give 1 point
		if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) )	score++;

		//if password bigger than 12 give another 1 point
		if (password.length > 8) score++;

		document.getElementById("passwordDescription").innerHTML = desc[score];
		document.getElementById("passwordStrength").className = "strength" + score;
	}
	function refreshCaptcha()
	{
		var img = document.images['captchaimg'];
		img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
	}
	//END: Password Strength Checker
	</script>
	
	<body>
		<div id="container">
			<?php
				include 'include/header.php';
			?>
			
			<div id="content">
				<div id="main-content">
					<div id="signup-wrapper">
					  <h3>Create an account</h3>
						<small>If you already have an account, please 
							<span id="signin-popup2">
								<a href="#signin" data-effect="mfp-zoom-out">Sign In</a>
							</span>
						</small>
						<br><br>
							<div id="signup-content">
							<!--Signup Form Start-->
								<form name="signupfrm" method="post" action="signupsendmail.php" onsubmit="return validate();">
									<table width="700px">
									<tr>
										<td width="150px" style="text-align:left;padding-right:10px;"><span class="red">* Required field</span></td>
									</tr>
									<tr>
										<td width="150px" style="text-align:right;padding-right:10px;">Name<span class="red">*</span></td>
										<td><input type="text" name="cust_name" placeholder="Full name as on IC" oninput="check_name();" onblur= "check_name();"><span id="NameError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td width="150px" style="text-align:right;padding-right:10px;">Email<span class="red">*</span></td>
										<td>
											<input type="email" name="cust_email" value="" placeholder="example@email.com" oninput="check_email();" onblur= "check_email();"/><span id="EmailError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Password<span class="red">*</span></td>
										<td><input type="password" name="cust_password" value="" placeholder="Enter new password" onkeyup="passwordStrength(this.value)" oninput="check_pw();"><span id="PwError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Confirm Password<span class="red">*</span></td>
										<td><input type="password" name="cust_repassword" value="" placeholder="Re-enter new password" oninput="check_repw();" onblur="check_repw();"><span id="RepwError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Password Strength</td>
										<td><span id="passwordDescription">Password not entered</span><br/><span id="passwordStrength" class="strength0"></span></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Identity Card Number<span class="red">*</span></td>
										<td><input type="text" name="cust_ic" value="" maxlength="12" placeholder="950101140101" oninput="check_ic();" onblur="check_ic();"><span id="IcError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Date of Birth<span class="red">*</span></td>
										<td><input type="date" name="cust_dob" value="" oninput="check_dob();" onblur="check_dob();"><span id="DobError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Contact Number<span class="red">*</span></td>
										<td>
											<input type="text" name="cust_phone" value="" placeholder="Your Phone Number" oninput="check_phone();" onblur="check_phone();"><span id="PhoneError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Gender</td>
										<td>
											<select name="cust_gender" size="1">
												<option value="M">Male</option>
												<option value="F">Female</option>
											</select>
										</td>
									</tr>
									
									
									<tr>
										<td style="text-align:right;padding-right:10px;">Mail Address</td>
										<td><input type="text" name="cust_addr_no" value="" placeholder="No.99, Jalan XXX, Taman XXX" style="width:400px;"/><small> (Street)</small></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="cust_addr_city" value="" placeholder="Port Dickson" style="width:400px;"/><small> (City)</small></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="cust_addr_state" value="" placeholder="Negeri Sembilan" style="width:400px;"/><small> (State)</small></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="cust_addr_postcode" value="" placeholder="71010" style="width:400px;"/><small> (Post Code)</small></td>					
									</tr>
									<tr>
										<td></td>
										<td><span id="AddrError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td valign="top" style="text-align:right;padding-right:10px;">Validation Code<span class="red">*</span></td>
										<td><img src="phpcaptcha/captcha.php?rand=<?php echo rand();?>" id='captchaimg'><br><input type="text" name="captcha" style="width:115px;"><span id="CaptError" class="red">&nbsp;</span><br>Can't read the image? Click <a href='javascript: refreshCaptcha();'>here</a> to refresh.</td>
									</tr>
								</table>
									<br/><br/>
									<small style="margin-left:310px;">By clicking Create Account, you agree to our <a href="#" target="_blank" class="signin">privacy policy</a>.</small>
									<br>
									<input type="submit" name="signup-btn" value="Create Account"/>
								</form>
								<!--Signup Form End-->
							</div>
					</div>
				</div>
			</div>
			<?php include 'include/btmnavi.php'; ?>
		</div>
		<?php include 'include/popup_jq.php'; ?>
	</body>

</html>

<?php

?>