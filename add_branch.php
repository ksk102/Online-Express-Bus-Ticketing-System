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
		else if (substr($sesscustid,0,1)== "A")
		{
			$sessadmid  = $_SESSION["sess_uid"];

			$sql_user 	 = "SELECT * from admin where ADMIN_ID = '$sessadmid'";
			$result_user = mysqli_query($conn, $sql_user);
			$row		 = mysqli_fetch_assoc($result_user);
		}
	}
	else
	{
		header('Location: index.php');
	}
$admin_comp  = $row['COMP_ID'];

//Generate branch ID
//Retrieve the last branch ID
$sql_brn    = "SELECT BRANCH_ID from branch ORDER BY BID DESC LIMIT 1";
$result_sql = mysqli_query($conn, $sql_brn);
$row2		= mysqli_fetch_assoc($result_sql);
$lastbrnid  = $row2['BRANCH_ID'];

//If no data in database, generate an id
if($row2<1)
{
	$brnid2		= 'BRN_';
	$brnid_num	= 0;
	
	++$brnid_num;
	$brnid_numext = str_pad($brnid_num,2,"0", STR_PAD_LEFT);

	$brnidfinal	= $brnid2.$brnid_numext;
	
	//echo $brnidfinal;
}
//END: If no data in database, generate an id
else
{
	//Split branch ID with _
	$brnid1	    = preg_split('/[_]/', $lastbrnid);

	$brnid2	 	= 'BRN_';
	$brnid_num  = $brnid1[1]; //Branch ID

	++$brnid_num;
	$brnid_numext = str_pad($brnid_num,2,"0", STR_PAD_LEFT);

	$brnidfinal	= $brnid2.$brnid_numext;
	
	//print_r ($brnid1);
	//echo "<br>";
	//echo $brnidfinal;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Add New Branch | BusForAll.com</title>
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
							<p>Add New Branch</p>
							<hr/>
						</div>
						<div id="newprofilefrm">
							<form name="myprofile" action="" method="post" onsubmit="return validate();">
								<table>
									<tr>
										<td width="150px">Branch's ID</td>
										<td>
											<input type="text" name="branch_id" value="<?php echo $brnidfinal;?>" readonly class="readonly"/>
										</td>
									</tr>
									<tr>
										<td width="150px">Branch Name</td>
										<td>
											<input type="text" name="branch_name" value="" oninput="check_name();">
											<span id="NameError" class="red">&nbsp;</span>
										</td>									
									</tr>
									<tr>
										<td width="150px">Branch Address</td>
										<td><input type="text" name="branch_addr_no" value="" placeholder="No.99, Jalan XXX, Taman XXX" oninput="check_street();" style="width:300px;"/><small> (Street)</small><span id="StreetError" class="red" style="font-size:10pt;">&nbsp;</span></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="branch_addr_city" value="" placeholder="Port Dickson" style="width:300px;" oninput="check_city();"/><small> (City)</small><span id="CityError" class="red" style="font-size:10pt;">&nbsp;</span></td>
									</tr>
									<tr>
										<td></td>
										<td>
											<select name="branch_addr_state" style="width:300px;">
												<option value="none">Select...</option>
												<option value="W">Kuala Lumpur</option>
												<option value="J">Johor</option>
												<option value="K">Kedah</option>
												<option value="D">Kelantan</option>
												<option value="M">Malacca</option>
												<option value="N">Negeri Sembilan</option>
												<option value="C">Pahang</option>
												<option value="A">Perak</option>
												<option value="R">Perlis</option>
												<option value="P">Penang</option>
												<option value="B">Selangor</option>
												<option value="T">Terengganu</option>
											</select>
											<small> (State)</small>
										</td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="branch_addr_postcode" value="" placeholder="71010" style="width:300px;" oninput="check_postcode();"/><small> (Postcode)</small><span id="PostcodeError" class="red" style="font-size:10pt;">&nbsp;</span></td>										
									</tr>
									<tr>
										<td>Contact Number</td>
										<td>
											<input type="text" name="branch_phone" placeholder="Branch's contact number" oninput="check_phone();"/><span id="PhoneError" class="red">&nbsp;</span>
										</td>
									</tr>
								</table>
								<div id="newprofile-btn">
									<input type="submit" name="addbtn" value="Add"/>
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
if(isset($_POST['addbtn']))
{
	$brnid 	  = $_POST['branch_id'];
	$name	  = $_POST['branch_name'];
	$street	  = $_POST['branch_addr_no'];
	$city	  = $_POST['branch_addr_city'];
	$state	  = $_POST['branch_addr_state'];
	$postcode = $_POST['branch_addr_postcode'];
	$phone	  = $_POST['branch_phone'];
	
	$brn_table	  = "branch";
	$insert_table = "INSERT into " .$brn_table. "(BRANCH_ID, BRANCH_NAME, BRANCH_ADDR_STREET, BRANCH_ADDR_CITY, BRANCH_ADDR_STATE, BRANCH_ADDR_POST, BRANCH_PHONE, COMP_ID)". "VALUES('$brnid', '$name', '$street', '$city', '$state', '$postcode', '$phone', '$admin_comp')";
	mysqli_query($conn, $insert_table);
	
	echo "<script>alert('Branch successfully added'); window.location.href='view_branch.php';</script>";
	header("Refresh:0");
	mysqli_close($conn);	
}
?>