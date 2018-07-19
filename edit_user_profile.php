<?php 
require 'Database/db_con.php';

//To prevent Warning: Cannot modify header information 
ob_start();
//END

	if(isset($_SESSION['sess_uid']))
	{
		$sesscustid  = $_SESSION["sess_uid"];
		if(substr($sesscustid,0,1)== "A")
		{
			header('Location: admin_profile.php');
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

$sql_user 	 = "SELECT * from customer where CUST_ID = '$sesscustid'";
$result_user = mysqli_query($conn, $sql_user);
$row		 = mysqli_fetch_assoc($result_user);

if(isset($_SESSION['pic_url']))
{
	$pic_url	  = $_SESSION['pic_url'];
}

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Edit Profile | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/edituserprofile.css" rel="stylesheet" type="text/css">
		
		<script type="text/javascript">
		function check_email()
		{
			if (document.myprofile.cust_email.value == "" || !(isNaN(document.myprofile.cust_email.value)) || document.myprofile.cust_email.value.indexOf("@") == -1 || document.myprofile.cust_email.value.indexOf(".com") == -1)
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
		
		function check_name()
		{
			if (document.myprofile.cust_name.value == "" || !(isNaN(document.myprofile.cust_name.value)) || (/\d/.test(document.myprofile.cust_name.value)))
			{
				document.getElementById('NameError').innerHTML = ' Enter the correct name';		
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
			if (document.myprofile.cust_ic.value.length < 12 && document.myprofile.cust_ic.value.length > 0 || document.myprofile.cust_ic.value.length > 12 || (isNaN(document.myprofile.cust_ic.value)))
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
			if (document.myprofile.cust_dob.value == "")
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
			if (document.myprofile.cust_phone.value == "" || document.myprofile.cust_phone.value.length < 9 || document.myprofile.cust_phone.value.length > 11 || isNaN(document.myprofile.cust_phone.value))
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
		
		function check_postcode()
		{
			if (document.myprofile.cust_addr_postcode.value.length < 5 && document.myprofile.cust_addr_postcode.value.length > 0 || document.myprofile.cust_addr_postcode.value.length > 5 || isNaN(document.myprofile.cust_addr_postcode.value))
			{
				document.getElementById('PostcodeError').innerHTML = ' Enter the correct Postcode Number';		
				return false;
			}
			else
			{
				document.getElementById('PostcodeError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		
		function validate()
		{
			if (check_email() && check_name() && check_ic() && check_dob() && check_phone() && check_postcode())
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
	</head>

	<body>
    	<div id="container">
			<?php
				include 'include/header.php';
			?>
        
			<div id="content">
				<div id="content-wrapper">
					<?php include 'include/leftnavi.php'; ?>
					<div id="edituserprofile-wrapper">
						<div id="edituserprofile-wrapper-title">
							<p>Edit Profile</p>
							<hr/>
						</div>
						<div id="edituserprofilefrm">
							<form name="myprofile" action="" method="post" onsubmit="return validate();">
								<table>
									<tr>
										<td width="120px" style="text-align:right;padding-right:10px;">Email</td>
										<td>
											<input type="email" name="cust_email" value="<?php echo $row["CUST_EMAIL"];?>" oninput="check_email();"/><span id="EmailError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td width="120px" style="text-align:right;padding-right:10px;">Name</td>
										<td><input type="text" name="cust_name" value="<?php echo $row["CUST_NAME"];?>" oninput="check_name();" placeholder="Full name as on IC"/><span id="NameError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Identity Card Number</td>
										<td><input type="text" name="cust_ic" value="<?php echo $row["CUST_IC"];?>" oninput="check_ic();" maxlength="12" placeholder="Use for Identity Verfication"/>
										<span id="IcError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Date of Birth</td>
										<td><input type="date" name="cust_dob" value="<?php echo $row["CUST_DOB"];?>" oninput="check_dob();" onblur="check_dob();"/><span id="DobError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Contact Number</td>
										<td>
											<input type="text" name="cust_phone" value="<?php echo $row["CUST_PHONE"];?>" oninput="check_phone();" placeholder="Your Phone Number" required/><span id="PhoneError" class="red">&nbsp;</span>
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
										<td><input type="text" name="cust_addr_no" value="<?php echo $row["CUST_ADDR_STREET"];?>" placeholder="No.99, Jalan XXX, Taman XXX" style="width:400px;"/><small> (Street)</small></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="cust_addr_city" value="<?php echo $row["CUST_ADDR_CITY"];?>" placeholder="Port Dickson" style="width:300px;"/><small> (City)</small></td>
									</tr>
									<tr>
										<td></td>
										<td>
											<select name="cust_addr_state" style="width:300px;">
												<option value="" <?php if($row["CUST_ADDR_STATE"]==""){echo "selected";}?>>Select...</option>
												<option value="KUL" <?php if($row["CUST_ADDR_STATE"]=="KUL"){echo "selected";}?>>Kuala Lumpur</option>
												<option value="LBN" <?php if($row["CUST_ADDR_STATE"]=="LBN"){echo "selected";}?>>Labuan</option>
												<option value="PJY" <?php if($row["CUST_ADDR_STATE"]=="PJY"){echo "selected";}?>>Putrajaya</option>
												<option value="JHR" <?php if($row["CUST_ADDR_STATE"]=="JHR"){echo "selected";}?>>Johor</option>
												<option value="KDH" <?php if($row["CUST_ADDR_STATE"]=="KDH"){echo "selected";}?>>Kedah</option>
												<option value="KTN" <?php if($row["CUST_ADDR_STATE"]=="KTN"){echo "selected";}?>>Kelantan</option>
												<option value="MLK" <?php if($row["CUST_ADDR_STATE"]=="MLK"){echo "selected";}?>>Malacca</option>
												<option value="NSN" <?php if($row["CUST_ADDR_STATE"]=="NSN"){echo "selected";}?>>Negeri Sembilan</option>
												<option value="PHG" <?php if($row["CUST_ADDR_STATE"]=="PHG"){echo "selected";}?>>Pahang</option>
												<option value="PRK" <?php if($row["CUST_ADDR_STATE"]=="PRK"){echo "selected";}?>>Perak</option>
												<option value="PLS" <?php if($row["CUST_ADDR_STATE"]=="PLS"){echo "selected";}?>>Perlis</option>
												<option value="PNG" <?php if($row["CUST_ADDR_STATE"]=="PNG"){echo "selected";}?>>Penang</option>
												<option value="SBH" <?php if($row["CUST_ADDR_STATE"]=="SBH"){echo "selected";}?>>Sabah</option>
												<option value="SWK" <?php if($row["CUST_ADDR_STATE"]=="SWK"){echo "selected";}?>>Sarawak</option>
												<option value="SGR" <?php if($row["CUST_ADDR_STATE"]=="SGR"){echo "selected";}?>>Selangor</option>
												<option value="TRG" <?php if($row["CUST_ADDR_STATE"]=="TRG"){echo "selected";}?>>Terengganu</option>
											</select>
											<small> (State)</small>
										</td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="cust_addr_postcode" value="<?php echo $row["CUST_ADDR_POST"];?>" oninput="check_postcode();" placeholder="71010" style="width:300px;"/><small> (Post Code)</small><span id="PostcodeError" class="red" style="font-size:8.5pt;">&nbsp;</span></td>								
									</tr>
									
								</table>
								<div id="edituserprofile-btn">
									<a href="user_profile.php" target="_self>"><input type="submit" name="confirmbtn" value="Confirm"/></a>
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
if(isset($_POST["confirmbtn"]))
{
	$email		= $_POST["cust_email"];
	$name		= $_POST["cust_name"];
	$ic			= $_POST["cust_ic"];
	$dob		= $_POST["cust_dob"];
	$phone		= $_POST["cust_phone"];
	$gender		= $_POST["cust_gender"];
	$street		= $_POST["cust_addr_no"];
	$city		= $_POST["cust_addr_city"];
	$state		= $_POST["cust_addr_state"];
	$postcode	= $_POST["cust_addr_postcode"];
	
	//Check for numeric and symbol
	$name_symbol = !(preg_match("/^[a-zA-Z ]*$/", $name));
	//Only allow number in IC (XXXXXX-XX-XXXX)
	$ic_valid	 = preg_match("/^([0-9]{6}-){1}([0-9]{2}-){1}[0-9]{4}$/", $ic);
	//Check for alphabet in phone number
	$phone_valid = !(is_numeric($phone));
	
	//Age Converter
	$dob_sep	= explode("-", $dob);
	$curMonth	= date("m");
	$curDay		= date("d");
	$curYear	= date("Y");
	$age		= $curYear - $dob_sep[0];

	if($curMonth<$dob_sep[1] || ($curMonth==$dob_sep[1] && $curDay<$dob_sep[2]))
	{
		$age--;
		//echo 'The age is'.$age;
	}
	//END: Age Converter
	
	?>
	<script>
	if (validate())
	{
		<?php
		
		//Update customer table
		$user_table 	= "customer";
		$update_table	= "UPDATE $user_table SET CUST_EMAIL='$email', CUST_NAME='$name', CUST_IC='$ic', CUST_PHONE='$phone', CUST_GENDER='$gender', CUST_AGE='$age', CUST_ADDR_STREET='$street', CUST_ADDR_CITY='$city', CUST_ADDR_STATE='$state', CUST_ADDR_POST='$postcode', CUST_DOB='$dob' where CUST_ID='$sesscustid'";
		mysqli_query($conn, $update_table);
		if(isset($_SESSION['pic_url']))
		{
			$update_table = "UPDATE $user_table SET CUST_PIC = '$pic_url' where CUST_ID='$sesscustid'";
			mysqli_query($conn, $update_table);
		}
		header("Location: user_profile.php");
		//END: Update customer table
	
		mysqli_close($conn);
		?>
	}
	</script>
	<?php
}

?>