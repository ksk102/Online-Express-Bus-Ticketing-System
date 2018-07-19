<?php 

require 'Database/db_con.php';

if(isset($_SESSION['sess_uid']))
	{
		$sesscustid  = $_SESSION["sess_uid"];
		if(substr($sesscustid,0,1)== "C")
		{
			header('Location: user_profile.php');
		}
		else if (substr($sesscustid,0,1)== "A")
		{
			header('Location: admin_profile.php');
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

$sessstaffid = $_SESSION["sess_uid"];

$sql_staff	  = "SELECT * from staff where STAFF_ID = '$sessstaffid'";
$result_staff = mysqli_query($conn, $sql_staff);
$row 		  = mysqli_fetch_assoc($result_staff);
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
		<link href="css-folder/editstaffprofile.css" rel="stylesheet" type="text/css">
		
		<script type="text/javascript">
		function check_email()
		{
			if (document.myprofile.staff_email.value == "" || !(isNaN(document.myprofile.staff_email.value)) || document.myprofile.staff_email.value.indexOf("@") == -1 || document.myprofile.staff_email.value.indexOf(".com") == -1)
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
			if (document.myprofile.staff_name.value == "" || !(isNaN(document.myprofile.staff_name.value)) || (/\d/.test(document.myprofile.staff_name.value)))
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
			if (document.myprofile.staff_ic.value.length < 12 && document.myprofile.staff_ic.value.length > 0 || document.myprofile.staff_ic.value.length > 12 || (isNaN(document.myprofile.staff_ic.value)))
			{
				document.getElementById('IcError').innerHTML = ' Enter the correct IC Number';		
				return false;
			}
			else
			{
				if(document.myprofile.staff_ic.value == "")
				{
					document.getElementById('IcError').innerHTML = '&nbsp;';
				}
				else
				{
					document.getElementById('IcError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';	
				}
				return true;
			}
		}
		
		function check_dob()
		{
			if (document.myprofile.staff_dob.value == "")
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
			if (document.myprofile.staff_phone.value == "" || document.myprofile.staff_phone.value.length < 10 || document.myprofile.staff_phone.value.length > 11 || isNaN(document.myprofile.staff_phone.value))
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
			if (document.myprofile.staff_addr_postcode.value.length < 5 && document.myprofile.staff_addr_postcode.value.length > 0 || document.myprofile.staff_addr_postcode.value.length > 5 || isNaN(document.myprofile.staff_addr_postcode.value))
			{
				document.getElementById('PostcodeError').innerHTML = ' Enter the correct Postcode Number';		
				return false;
			}
			else
			{
				if(document.myprofile.staff_addr_postcode.value == "")
				{
					document.getElementById('PostcodeError').innerHTML = '&nbsp;';
				}
				else
				{
					document.getElementById('PostcodeError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';	
				}
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
											<input type="email" name="staff_email" value="<?php echo $row["STAFF_EMAIL"];?>" oninput="check_email();"/><span id="EmailError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td width="120px" style="text-align:right;padding-right:10px;">Name</td>
										<td><input type="text" name="staff_name" value="<?php echo $row["STAFF_NAME"];?>" placeholder="Full name as on IC" oninput="check_name();"/><span id="NameError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Identity Card Number</td>
										<td><input type="text" name="staff_ic" value="<?php echo $row["STAFF_IC"];?>" maxlength="12" placeholder="Use for Identity Verfication" oninput="check_ic();"/><span id="IcError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Date of Birth</td>
										<td><input type="date" name="staff_dob" value="<?php echo $row["STAFF_DOB"];?>" oninput="check_dob();"/><span id="DobError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Contact Number</td>
										<td>
											<input type="text" name="staff_phone" value="<?php echo $row["STAFF_PHONE"];?>" placeholder="Your Phone Number" oninput="check_phone();"/><span id="PhoneError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Gender</td>
										<td>
											<select name="staff_gender" size="1">
												<option value="" <?php if($row["STAFF_GENDER"]==""){echo 'selected';}?>>Select...</option>
												<option value="M" <?php if($row["STAFF_GENDER"]=="M"){echo 'selected';}?>>Male</option>
												<option value="F" <?php if($row["STAFF_GENDER"]=="F"){echo 'selected';}?>>Female</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Mail Address</td>
										<td><input type="text" name="staff_addr_no" value="<?php echo $row["STAFF_ADDR_STREET"];?>" placeholder="No.99, Jalan XXX, Taman XXX" style="width:400px;"/><small> (Street)</small></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="staff_addr_city" value="<?php echo $row["STAFF_ADDR_CITY"];?>" placeholder="Port Dickson" style="width:400px;"/><small> (City)</small></td>
									</tr>
									<tr>
										<td></td>
										<td><select name="staff_addr_state" style="width:400px;">
												<option value="" <?php if($row["STAFF_ADDR_STATE"]==""){echo "selected";}?>>Select...</option>
												<option value="KUL" <?php if($row["STAFF_ADDR_STATE"]=="KUL"){echo "selected";}?>>Kuala Lumpur</option>
												<option value="LBN" <?php if($row["STAFF_ADDR_STATE"]=="LBN"){echo "selected";}?>>Labuan</option>
												<option value="PJY" <?php if($row["STAFF_ADDR_STATE"]=="PJY"){echo "selected";}?>>Putrajaya</option>
												<option value="JHR" <?php if($row["STAFF_ADDR_STATE"]=="JHR"){echo "selected";}?>>Johor</option>
												<option value="KDH" <?php if($row["STAFF_ADDR_STATE"]=="KDH"){echo "selected";}?>>Kedah</option>
												<option value="KTN" <?php if($row["STAFF_ADDR_STATE"]=="KTN"){echo "selected";}?>>Kelantan</option>
												<option value="MLK" <?php if($row["STAFF_ADDR_STATE"]=="MLK"){echo "selected";}?>>Malacca</option>
												<option value="NSN" <?php if($row["STAFF_ADDR_STATE"]=="NSN"){echo "selected";}?>>Negeri Sembilan</option>
												<option value="PHG" <?php if($row["STAFF_ADDR_STATE"]=="PHG"){echo "selected";}?>>Pahang</option>
												<option value="PRK" <?php if($row["STAFF_ADDR_STATE"]=="PRK"){echo "selected";}?>>Perak</option>
												<option value="PLS" <?php if($row["STAFF_ADDR_STATE"]=="PLS"){echo "selected";}?>>Perlis</option>
												<option value="PNG" <?php if($row["STAFF_ADDR_STATE"]=="PNG"){echo "selected";}?>>Penang</option>
												<option value="SBH" <?php if($row["STAFF_ADDR_STATE"]=="SBH"){echo "selected";}?>>Sabah</option>
												<option value="SWK" <?php if($row["STAFF_ADDR_STATE"]=="SWK"){echo "selected";}?>>Sarawak</option>
												<option value="SGR" <?php if($row["STAFF_ADDR_STATE"]=="SGR"){echo "selected";}?>>Selangor</option>
												<option value="TRG" <?php if($row["STAFF_ADDR_STATE"]=="TRG"){echo "selected";}?>>Terengganu</option>
											</select><small> (State)</small></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="staff_addr_postcode" value="<?php echo $row["STAFF_ADDR_POST"];?>" placeholder="71010" style="width:400px;" oninput="check_postcode();"/><small> (Post Code)</small><span id="PostcodeError" class="red" style="font-size:5.5pt;">&nbsp;</span></td>
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
	$email		= $_POST["staff_email"];
	$name		= $_POST["staff_name"];
	$ic			= $_POST["staff_ic"];
	$dob		= $_POST["staff_dob"];
	$phone		= $_POST["staff_phone"];
	$gender		= $_POST["staff_gender"];
	$street		= $_POST["staff_addr_no"];
	$city		= $_POST["staff_addr_city"];
	$state		= $_POST["staff_addr_state"];
	$postcode	= $_POST["staff_addr_postcode"];
	
	/*//Check for numeric and symbol
	$name_symbol= !(preg_match("/^[a-zA-Z ]*$/", $name));
	//Only allow number in IC (XXXXXX-XX-XXXX)
	$ic_valid	= preg_match("/^([0-9]{6}-){1}([0-9]{2}-){1}[0-9]{4}$/", $ic);
	//Check for alphabet in phone number
	$phone_valid = !(is_numeric($phone));*/
	
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
	
	/*if($ic == "" || $ic_valid =="TRUE")
	{
		//$error_ic = "Please enter your IC number";
	?>
		<script>
			document.getElementById('IcError').innerHTML = ' * Please enter your IC number';
		</script>
	<?php
	}*/
	?>
	<script>
	if (validate())
	{
		<?php
		//Update staff table
		$staff_table	= "staff";
		$update_table	= "UPDATE $staff_table SET STAFF_EMAIL='$email', STAFF_NAME='$name', STAFF_IC='$ic', STAFF_DOB='$dob', STAFF_AGE='$age', STAFF_PHONE='$phone', STAFF_GENDER='$gender', STAFF_ADDR_STREET='$street', STAFF_ADDR_CITY='$city', STAFF_ADDR_STATE='$state', STAFF_ADDR_POST='$postcode' where STAFF_ID='$sessstaffid'";
		mysqli_query($conn, $update_table);
		if(isset($_SESSION['pic_url']))
		{
			$update_table = "UPDATE $staff_table SET STAFF_PIC = '$pic_url' where STAFF_ID='$sessstaffid'";
			mysqli_query($conn, $update_table);
		}
		header("Location: staff_profile.php");
		//END: Update staff table
	
		mysqli_close($conn);
		?>
	}
	</script>
	<?php
}
?>