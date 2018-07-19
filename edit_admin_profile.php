<?php 

require 'Database/db_con.php';

if(isset($_SESSION['sess_uid']))
	{
		$sesscustid  = $_SESSION["sess_uid"];
		if(substr($sesscustid,0,1)== "C")
		{
			header('Location: user_profile.php');
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

$sessadminid = $_SESSION["sess_uid"];

$sql_user	  = "SELECT * from admin where ADMIN_ID = '$sessadminid'";
$result_user = mysqli_query($conn, $sql_user);
$row 		  = mysqli_fetch_assoc($result_user);
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
		<link href="css-folder/editadminprofile.css" rel="stylesheet" type="text/css">
		
		<script type="text/javascript">
		function check_email()
		{
			if (document.myprofile.admin_email.value == "" || !(isNaN(document.myprofile.admin_email.value)) || document.myprofile.admin_email.value.indexOf("@") == -1 || document.myprofile.admin_email.value.indexOf(".com") == -1)
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
			if (document.myprofile.admin_name.value == "" || !(isNaN(document.myprofile.admin_name.value)) || (/\d/.test(document.myprofile.admin_name.value)))
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
		
		function checkctic()
		{
			citi = document.getElementById('admin_ntnlt');
			if (citi.value == "")
			{
				document.getElementById("admin_ic").innerHTML = '<td style="text-align:right;padding-right:10px;"></td><td><input type="text" id="admin_ic0" name="admin_ic0" placeholder="Use for Identity Verfication" value="Please select your nationality" disabled class="disabled"/></td>';		
			}
			
			if (citi.value == "M")
			{
				document.getElementById("admin_ic").innerHTML = '<td style="text-align:right;padding-right:10px;">Identity Card Number</td><td><input type="text" id="admin_ic1" name="admin_ic1" maxlength="12" placeholder="Use for Identity Verfication" oninput="check_ic();"/><span id="IcError" class="red">&nbsp;</span></td>';		
			}

			if (citi.value == "N")
			{
				document.getElementById("admin_ic").innerHTML = '<td style="text-align:right;padding-right:10px;">Passport Number</td><td><input type="text" id="admin_passport1" name="admin_passport1" placeholder="Use for Identity Verfication" oninput="check_pp();"/><span id="PpError" class="red">&nbsp;</span></td>';	
			}
		}
		function check_ic()
		{		
			if (document.myprofile.admin_ic1.value.length < 12 && document.myprofile.admin_ic1.value.length > 0 || document.myprofile.admin_ic1.value.length > 12 || (isNaN(document.myprofile.admin_ic1.value)))
			{
				document.getElementById('IcError').innerHTML = ' Enter the correct IC Number';		
				return false;
			}
			else
			{
				if(document.myprofile.admin_ic1.value == "")
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
		
		function check_pp()
		{		
			if (document.myprofile.admin_passport1.value.length < 8 && document.myprofile.admin_passport1.value.length > 0 || document.myprofile.admin_passport1.value.length > 12 || (isNaN(document.myprofile.admin_passport1.value)))
			{
				document.getElementById('PpError').innerHTML = ' Enter the correct Passport Number';		
				return false;
			}
			else
			{
				if(document.myprofile.admin_passport1.value == "")
				{
					document.getElementById('PpError').innerHTML = '&nbsp;';
				}
				else
				{
					document.getElementById('PpError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';	
				}
				return true;
			}
		}
		/*validation work, but cannot prevent the system to stop store into database, if there is an error*/
		
		function check_phone()
		{
			if (document.myprofile.admin_phone.value == "" || document.myprofile.admin_phone.value.length < 9 || document.myprofile.admin_phone.value.length > 11 || isNaN(document.myprofile.admin_phone.value))
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
			if (document.myprofile.admin_addr_postcode.value.length < 5 && document.myprofile.admin_addr_postcode.value.length > 0 || document.myprofile.admin_addr_postcode.value.length > 5 || isNaN(document.myprofile.admin_addr_postcode.value))
			{
				document.getElementById('PostcodeError').innerHTML = ' Enter the correct Postcode Number';		
				return false;
			}
			else
			{
				if(document.myprofile.admin_addr_postcode.value == "")
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
			if (check_email() && check_name() && check_ic() && check_phone() && check_postcode() && check_pp())
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
							<form name="myprofile" id="myprofile-form" action="" method="post" onsubmit="return validate();">
								<table>
									<tr>
										<td width="120px" style="text-align:right;padding-right:10px;">Email<span class="red">*</span></td>
										<td>
											<input type="email" name="admin_email" placeholder="Your email address" value="<?php echo $row["ADMIN_EMAIL"];?>" oninput="check_email();"/><span id="EmailError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td width="120px" style="text-align:right;padding-right:10px;">Name<span class="red">*</span></td>
										<td>
											<input type="text" name="admin_name" value="<?php echo $row["ADMIN_NAME"];?>" placeholder="Your name" oninput="check_name();"/><span id="NameError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Nationality</td>
										<td>
											<select name="admin_ntnlt" id="admin_ntnlt" onchange="checkctic(),ic_mask()">
												<option value="" <?php if($row["ADMIN_NATION"]==""){echo "selected";} ?>>Select...</option>
												<option value="M" <?php if($row["ADMIN_NATION"]=="M"){echo "selected";} ?>>Malaysian</option>
												<option value="N" <?php if($row["ADMIN_NATION"]=="N"){echo "selected";} ?>>non-Malaysian</option>
											</select>
										</td>
									</tr>
									<tr id="admin_ic">
										<td style="text-align:right;padding-right:10px;"><?php if($row["ADMIN_NATION"]=="M"){echo "Identity Card Number";} else if($row["ADMIN_NATION"]=="N"){echo "Passport Number";}?></td>
										<td><input type="text" <?php if($row["ADMIN_NATION"]==""){echo 'id="admin_ic0" name="admin_ic0" value="Please select your nationality" disabled class="disabled"'; } else if($row["ADMIN_NATION"]=="M"){echo 'id="admin_ic1" name="admin_ic1" maxlength="12" oninput="check_ic();" onfocus="ic_mask();"';} else if($row["ADMIN_NATION"]=="N"){echo 'id="admin_passport1" name="admin_passport1" maxlength="20" oninput="check_pp();"';}?> value="<?php echo $row["ADMIN_IC"];?>" placeholder="Use for Identity Verfication"/><span id="<?php if($row["ADMIN_NATION"]=="M"){echo 'IcError"';} else if($row["ADMIN_NATION"]=="N"){echo 'PpError"';}?> class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Contact Number<span class="red">*</span></td>
										<td>
											<input type="text" name="admin_phone" value="<?php echo $row["ADMIN_PHONE"];?>" placeholder="Your Phone Number" oninput="check_phone();"/><span id="PhoneError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Gender</td>
										<td>
											<select name="admin_gender" size="1">
												<option value="" <?php if($row["ADMIN_GENDER"]==""){echo 'selected';}?>>Select...</option>
												<option value="M" <?php if($row["ADMIN_GENDER"]=="M"){echo 'selected';}?>>Male</option>
												<option value="F" <?php if($row["ADMIN_GENDER"]=="F"){echo 'selected';}?>>Female</option>
											</select>
										</td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Mail Address</td>
										<td><input type="text" name="admin_addr_no" value="<?php echo $row["ADMIN_ADDR_STREET"];?>" placeholder="No.99, Jalan XXX, Taman XXX" style="width:400px;"/><small> (Street)</small></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="admin_addr_city" value="<?php echo $row["ADMIN_ADDR_CITY"];?>" placeholder="Port Dickson" style="width:400px;"/><small> (City)</small></td>
									</tr>
									<tr>
										<td></td>
										<td>
											<select name="admin_addr_state" style="width:400px;">
												<option value="" <?php if($row["ADMIN_ADDR_STATE"]==""){echo "selected";}?>>Select...</option>
												<option value="KUL" <?php if($row["ADMIN_ADDR_STATE"]=="KUL"){echo "selected";}?>>Kuala Lumpur</option>
												<option value="LBN" <?php if($row["ADMIN_ADDR_STATE"]=="LBN"){echo "selected";}?>>Labuan</option>
												<option value="PJY" <?php if($row["ADMIN_ADDR_STATE"]=="PJY"){echo "selected";}?>>Putrajaya</option>
												<option value="JHR" <?php if($row["ADMIN_ADDR_STATE"]=="JHR"){echo "selected";}?>>Johor</option>
												<option value="KDH" <?php if($row["ADMIN_ADDR_STATE"]=="KDH"){echo "selected";}?>>Kedah</option>
												<option value="KTN" <?php if($row["ADMIN_ADDR_STATE"]=="KTN"){echo "selected";}?>>Kelantan</option>
												<option value="MLK" <?php if($row["ADMIN_ADDR_STATE"]=="MLK"){echo "selected";}?>>Malacca</option>
												<option value="NSN" <?php if($row["ADMIN_ADDR_STATE"]=="NSN"){echo "selected";}?>>Negeri Sembilan</option>
												<option value="PHG" <?php if($row["ADMIN_ADDR_STATE"]=="PHG"){echo "selected";}?>>Pahang</option>
												<option value="PRK" <?php if($row["ADMIN_ADDR_STATE"]=="PRK"){echo "selected";}?>>Perak</option>
												<option value="PLS" <?php if($row["ADMIN_ADDR_STATE"]=="PLS"){echo "selected";}?>>Perlis</option>
												<option value="PNG" <?php if($row["ADMIN_ADDR_STATE"]=="PNG"){echo "selected";}?>>Penang</option>
												<option value="SBH" <?php if($row["ADMIN_ADDR_STATE"]=="SBH"){echo "selected";}?>>Sabah</option>
												<option value="SWK" <?php if($row["ADMIN_ADDR_STATE"]=="SWK"){echo "selected";}?>>Sarawak</option>
												<option value="SGR" <?php if($row["ADMIN_ADDR_STATE"]=="SGR"){echo "selected";}?>>Selangor</option>
												<option value="TRG" <?php if($row["ADMIN_ADDR_STATE"]=="TRG"){echo "selected";}?>>Terengganu</option>
											</select>
											<small> (State)</small>
										</td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="admin_addr_postcode" value="<?php if($row["ADMIN_ADDR_POST"]==0){echo "";} else {echo $row["ADMIN_ADDR_POST"];}?>" placeholder="71010" style="width:400px;" oninput="check_postcode();"/><small> (Post Code)</small><span id="PostcodeError" class="red" style="font-size:5.5pt;">&nbsp;</span></td>
									</tr>
								</table>
								<p width="150px" style="text-align:left;padding-right:10px;"><span class="red">* Required field</span></p>
								<div id="edituserprofile-btn">
									<input type="submit" name="confirmbtn" value="Confirm"/>
									<input type="reset" name="cancelbtn" value="Cancel">
								</div>
							</form>
						</div>  
					</div>
				</div>
			</div>
		
			<?php include 'include/btmnavi.php'; ?>
		</div>
		<!--<script>
		function ic_mask()
		{
			$('#admin_ic1', '#myprofile-form')

			.keydown(function (e) {
			var key = e.charCode || e.keyCode || 0;
			$ic = $(this);

			// Auto-format- do not expose the mask as the user begins to type
			if (key !== 8 && key !== 9) {
				if ($ic.val().length === 6) {
					$ic.val($ic.val() + '-');
				}
				if ($ic.val().length === 9) {
					$ic.val($ic.val() + '-');
				}
			}

			// Allow numeric (and tab, backspace, delete) keys only
			/*return (key == 8 || 
						key == 9 ||
						key == 46 ||
						(key >= 48 && key <= 57) ||
						(key >= 96 && key <= 105));	*/
			});
		}
		</script>-->
	</body>
</html>

<?php
if(isset($_POST["confirmbtn"]))
{
	$email		= $_POST["admin_email"];
	$name		= $_POST["admin_name"];
	$nation		= $_POST["admin_ntnlt"];
	if($nation=='M')
	{
		$ic= $_POST["admin_ic1"];
	}
	else if($nation=='N')
	{
		$ic= $_POST["admin_passport1"];
	}
	$phone		= $_POST["admin_phone"];
	$gender		= $_POST["admin_gender"];
	$street		= $_POST["admin_addr_no"];
	$city		= $_POST["admin_addr_city"];
	$state		= $_POST["admin_addr_state"];
	$postcode	= $_POST["admin_addr_postcode"];
	/*
	//Check for numeric and symbol
	$name_symbol= !(preg_match("/^[a-zA-Z ]*$/", $name));
	//Only allow number in IC (XXXXXX-XX-XXXX)
	$ic_valid	= preg_match("/^([0-9]{6}-){1}([0-9]{2}-){1}[0-9]{4}$/", $ic);
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
	*/
	/*if($gender == "M")
	{
		$gender = "Male";
	}
	else if($gender == "F")
	{
		$gender = "Female";
	}*/
	
	?>
		<script>
		if (validate())
		{
			<?php
				
			//Update admin table
			$admin_table	= "admin";
			$update_table	= "UPDATE $admin_table SET ADMIN_EMAIL='$email', ADMIN_NAME='$name', ADMIN_NATION='$nation', ADMIN_IC='$ic', ADMIN_PHONE='$phone', ADMIN_GENDER='$gender', ADMIN_ADDR_STREET='$street', ADMIN_ADDR_CITY='$city', ADMIN_ADDR_STATE='$state', ADMIN_ADDR_POST='$postcode' where ADMIN_ID='$sessadminid'";
			mysqli_query($conn, $update_table);
			if(isset($_SESSION['pic_url']))
			{
				$update_table = "UPDATE $admin_table SET ADMIN_PIC = '$pic_url' where ADMIN_ID='$sessadminid'";
				mysqli_query($conn, $update_table);
			}
			
			header("Location: admin_profile.php");
			//END: Update admin table
							
			mysqli_close($conn);
			?>
			
		}
		</script>
	<?php
}
?>