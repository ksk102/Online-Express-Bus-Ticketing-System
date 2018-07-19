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

$sessadmid  = $_SESSION["sess_uid"];

$sql_user 	 = "SELECT * from admin where ADMIN_ID = '$sessadmid'";
$result_user = mysqli_query($conn, $sql_user);
$row		 = mysqli_fetch_assoc($result_user);
$admin_comp  = $row['COMP_ID'];

if (isset($_GET['brn_id']))
{
	$brnid		  = $_GET['brn_id'];
	$sql_brn	  = "SELECT * from branch where BRANCH_ID = '$brnid'";
	$result_brn	  = mysqli_query($conn, $sql_brn);
	$row2		  = mysqli_fetch_assoc($result_brn);
}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Edit Branch | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/addbranch.css" rel="stylesheet" type="text/css">
		
		<script>
		function check_name()
		{
			if (document.myprofile.branch_name.value == "" || !(isNaN(document.myprofile.branch_name.value)) || (/\d/.test(document.myprofile.branch_name.value)))
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
		function check_street()
		{
			if (document.myprofile.branch_addr_no.value == "")
			{
				document.getElementById('StreetError').innerHTML = ' Enter street address';		
				return false;
			}
			else
			{
				document.getElementById('StreetError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';	
				return true;
			}
		}
		function check_city()
		{
			if (document.myprofile.branch_addr_city.value == "")
			{
				document.getElementById('CityError').innerHTML = ' Enter city name';		
				return false;
			}
			else
			{
				document.getElementById('CityError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';	
				return true;
			}
		}
		function check_postcode()
		{
			if (document.myprofile.branch_addr_postcode.value.length < 5 && document.myprofile.branch_addr_postcode.value.length > 0 || document.myprofile.branch_addr_postcode.value.length > 5 || isNaN(document.myprofile.branch_addr_postcode.value))
			{
				document.getElementById('PostcodeError').innerHTML = ' Enter the correct postcode';		
				return false;
			}
			else
			{
				if(document.myprofile.branch_addr_postcode.value == "")
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
		function check_phone()
		{
			if (document.myprofile.branch_phone.value == "" || document.myprofile.branch_phone.value.length < 9 || document.myprofile.branch_phone.value.length > 11 || isNaN(document.myprofile.branch_phone.value))
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
			if (check_name() && check_street() && check_city() && check_postcode() && check_phone())
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
					<div id="newprofile-wrapper">
						<div id="newprofile-wrapper-title">
							<p>Edit Branch Detail</p>
							<hr/>
						</div>
						<div id="newprofilefrm">
							<form name="myprofile" action="" method="post" onsubmit="return validate();">
								<table>
									<tr>
										<td width="150px">Branch's ID</td>
										<td>
											<input type="text" name="branch_id" value="<?php echo $row2['BRANCH_ID'];?>" readonly class="readonly"/>
										</td>
									</tr>
									<tr>
										<td width="150px">Branch Name</td>
										<td>
											<input type="text" name="branch_name" value="<?php echo $row2['BRANCH_NAME'];?>" oninput="check_name();">
											<span id="NameError" class="red">&nbsp;</span>
										</td>									
									</tr>
									<tr>
										<td width="150px">Branch Address</td>
										<td><input type="text" name="branch_addr_no" value="<?php echo $row2['BRANCH_ADDR_STREET'];?>" placeholder="No.99, Jalan XXX, Taman XXX" oninput="check_street();" style="width:300px;"/><small> (Street)</small><span id="StreetError" class="red" style="font-size:10pt;">&nbsp;</span></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="branch_addr_city" value="<?php echo $row2['BRANCH_ADDR_CITY'];?>" placeholder="Port Dickson" style="width:300px;" oninput="check_city();"/><small> (City)</small><span id="CityError" class="red" style="font-size:10pt;">&nbsp;</span></td>
									</tr>
									<tr>
										<td></td>
										<td>
											<select name="branch_addr_state" style="width:300px;">
												<option value="none" <?php if($row2['BRANCH_ADDR_STATE']=="none"){echo "selected";}?>>Select...</option>
												<option value="W" <?php if($row2['BRANCH_ADDR_STATE']=="W"){echo "selected";}?>>Kuala Lumpur</option>
												<option value="J" <?php if($row2['BRANCH_ADDR_STATE']=="J"){echo "selected";}?>>Johor</option>
												<option value="K" <?php if($row2['BRANCH_ADDR_STATE']=="K"){echo "selected";}?>>Kedah</option>
												<option value="D" <?php if($row2['BRANCH_ADDR_STATE']=="D"){echo "selected";}?>>Kelantan</option>
												<option value="M" <?php if($row2['BRANCH_ADDR_STATE']=="M"){echo "selected";}?>>Malacca</option>
												<option value="N" <?php if($row2['BRANCH_ADDR_STATE']=="N"){echo "selected";}?>>Negeri Sembilan</option>
												<option value="C" <?php if($row2['BRANCH_ADDR_STATE']=="C"){echo "selected";}?>>Pahang</option>
												<option value="A" <?php if($row2['BRANCH_ADDR_STATE']=="A"){echo "selected";}?>>Perak</option>
												<option value="R" <?php if($row2['BRANCH_ADDR_STATE']=="R"){echo "selected";}?>>Perlis</option>
												<option value="P" <?php if($row2['BRANCH_ADDR_STATE']=="P"){echo "selected";}?>>Penang</option>
												<option value="B" <?php if($row2['BRANCH_ADDR_STATE']=="B"){echo "selected";}?>>Selangor</option>
												<option value="T" <?php if($row2['BRANCH_ADDR_STATE']=="T"){echo "selected";}?>>Terengganu</option>
											</select>
											<small> (State)</small>
										</td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="branch_addr_postcode" value="<?php echo $row2['BRANCH_ADDR_POST'];?>" placeholder="71010" style="width:300px;" oninput="check_postcode();"/><small> (Postcode)</small><span id="PostcodeError" class="red" style="font-size:10pt;">&nbsp;</span></td>										
									</tr>
									<tr>
										<td>Contact Number</td>
										<td>
											<input type="text" name="branch_phone" value="<?php echo $row2['BRANCH_PHONE'];?>" placeholder="Branch's contact number" oninput="check_phone();"/><span id="PhoneError" class="red">&nbsp;</span>
										</td>
									</tr>
								</table>
								<div id="newprofile-btn">
									<input type="submit" name="savebtn" value="Save Changes"/>
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
if(isset($_POST['savebtn']))
{
	$name	  = $_POST['branch_name'];
	$street	  = $_POST['branch_addr_no'];
	$city	  = $_POST['branch_addr_city'];
	$state	  = $_POST['branch_addr_state'];
	$postcode = $_POST['branch_addr_postcode'];
	$phone	  = $_POST['branch_phone'];
	
	?>
	<script>
	if(validate())
	{
		<?php
		$brn_table	  = "branch";
		$update_table = "UPDATE $brn_table SET BRANCH_NAME='$name', BRANCH_ADDR_STREET='$street', BRANCH_ADDR_CITY='$city', BRANCH_ADDR_STATE='$state', BRANCH_ADDR_POST='$postcode', BRANCH_PHONE='$phone' where BRANCH_ID='$brnid'";
		mysqli_query($conn, $update_table);
		header("Location: view_branch.php");
		mysqli_close($conn);	
		?>
	}
	</script>
	<?php
}
?>