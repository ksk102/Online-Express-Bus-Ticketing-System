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

//Generate staff ID
//Retrieve the last staff ID
$sql_staff    = "SELECT STAFF_ID from staff ORDER BY SID DESC LIMIT 1";
$result_sql   = mysqli_query($conn, $sql_staff);
$row2		  = mysqli_fetch_assoc($result_sql);
$laststaffid  = $row2['STAFF_ID'];
	
if($row2<1)
{
	$staffid2	  = $row["COMP_ID"];

	$staffid_alpa = 'S_'; //Staff 
	$staffid_comp = $staffid2.'_'; //Company ID
	$staffid_num  = 0; //Staff ID

	++$staffid_num;
	$staffid_numext = str_pad($staffid_num,2,"0", STR_PAD_LEFT);

	$staffidfinal	= $staffid_alpa.$staffid_comp.$staffid_numext;
}	
else
{	
	//Split staff ID with _
	$staffid1	  = preg_split('/[_]/', $laststaffid);
	$staffid2	  = $row["COMP_ID"];

	$staffid_alpa   = 'S_'; //Staff 
	$staffid_comp   = $staffid2.'_'; //Company ID
	$staffid_num    = $staffid1[2]; //Staff ID

	++$staffid_num;
	$staffid_numext = str_pad($staffid_num,2,"0", STR_PAD_LEFT);

	$staffidfinal	= $staffid_alpa.$staffid_comp.$staffid_numext;

	//print_r ($staffid1);	
	//print "<br>";
	//echo $staffid_numext;
	//print "<br>";
	//echo $staffidfinal;
}
//END: Generate staff ID
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Add Staff | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/addstaff.css" rel="stylesheet" type="text/css">
		
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
			width:180px;
			background:#999;
		}

		.strength1
		{
			width:36px;
			background:#ff0000;
		}

		.strength2
		{
			width:72px;	
			background:#ff5f5f;
		}

		.strength3
		{
			width:108px;
			background:#56e500;
		}

		.strength4
		{
			background:#4dcd00;
			width:144px;
		}

		.strength5
		{
			background:#399800;
			width:180px;
		}
		</style>
		
		<script>
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
		//END: Password Strength Checker
		</script>
		
		<script type="text/javascript">
		//Live validation
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
		
		function check_pw()
		{
			if (document.myprofile.staff_password.value == "")
			{
				document.getElementById('PwError').innerHTML = ' Enter the password';
				return false;
			}
			else
			{
				document.getElementById('PwError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		
		function check_repw()
		{
			if (document.myprofile.staff_repassword.value != document.myprofile.staff_password.value || document.myprofile.staff_repassword == "")
			{
				document.getElementById('RepwError').innerHTML = ' Password does not match';
				return false;
			}
			else
			{
				document.getElementById('RepwError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		
		function check_phone()
		{
			if (document.myprofile.staff_phone.value == "" || document.myprofile.staff_phone.value.length < 9 || document.myprofile.staff_phone.value.length > 11 || isNaN(document.myprofile.staff_phone.value))
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
		
		function check_branch()
		{
			if (document.myprofile.branch_id.value == "none")
			{
				document.getElementById('BranchError').innerHTML = ' Enter the correct phone number';		
				return false;
			}
			else
			{
				document.getElementById('BranchError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		
		function validate()
		{
			if (check_email() && check_name() && check_pw() && check_repw() && check_phone() && check_branch())
			{
				return true;
			}
			else
			{
				alert("Please check your information again");
				return false;
			}
		}
		//END: Live validation
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
							<p>Add New Staff</p>
							<hr/>
						</div>
						<div id="newprofilefrm">
							<form name="myprofile" id="myprofile-form" action="" method="post" onsubmit="return validate();">
								<table>
									<tr>
										<td width="150px">Staff ID</td>
										<td>
											<input type="text" name="staff_id" value="<?php echo $staffidfinal;?>" readonly class="readonly"/>
										</td>
									</tr>
									<tr>
										<td>Email<span class="red">*</span></td>
										<td>
											<input type="email" name="staff_email" value="" placeholder="Your email address" oninput="check_email();"/><span id="EmailError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>Name<span class="red">*</span></td>
										<td><input type="text" name="staff_name" placeholder="Staff's name" oninput="check_name();"/><span id="NameError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td>Password<span class="red">*</span></td>
										<td><input type="password" name="staff_password" value="" placeholder="Enter new password" onkeyup="passwordStrength(this.value)" oninput="check_pw();"><span id="PwError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td>Confirm Password<span class="red">*</span></td>
										<td><input type="password" name="staff_repassword" value="" placeholder="Re-enter new password" oninput="check_repw();"><span id="RepwError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td>Password Strength</td>
										<td><span id="passwordDescription">Password not entered</span><br/><span id="passwordStrength" class="strength0"></span></td>
									</tr>
									<tr>
										<td>Contact Number</td>
										<td>
											<input type="text" name="staff_phone" placeholder="Staff's Contact Number" oninput="check_phone();"/><span id="PhoneError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>Branch<span class="red">*</span></td>
										<td>
											<select id="branch_id" name="branch_id" oninput="check_branch();">
												<option value="none" selected>--Select a Branch--</option>
												<?php
													$sql_branch	  = "SELECT * from branch where COMP_ID = '$staffid2'";
													$result_branch = mysqli_query($conn, $sql_branch);
													while($row_branch  = mysqli_fetch_assoc($result_branch))
													{
													?>
														<option value="<?php echo $row_branch['BRANCH_ID'];?>"><?php echo $row_branch['BRANCH_NAME'];?></option>
													<?php
													}
													?>
												
											</select><span id="BranchError" class="red">&nbsp;</span>
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
if(isset($_POST["addbtn"]))
{
	$staffid	= $_POST["staff_id"];
	$email		= $_POST["staff_email"];
	$name		= $_POST["staff_name"];
	$password	= $_POST["staff_password"];
	$repw		= $_POST["staff_repassword"];
	$phone		= $_POST["staff_phone"];
	$branchid	= $_POST["branch_id"];
	
	?>
	<script>

	
		<?php
		//Check if the staff exist
		$staff_exist	= "SELECT * from staff where STAFF_EMAIL = '$email'";
		$result_exist	= mysqli_query($conn, $staff_exist);
		$count			= mysqli_num_rows($result_exist);
		
		if($count>0)
		{
			?>
				alert("This email already exist");
			<?php
		}
		else
		{
			//Insert into staff table
			$staff_table	= "staff";
			$sql_insert		= "INSERT into " .$staff_table. "(STAFF_ID, STAFF_EMAIL, STAFF_NAME, STAFF_PW, STAFF_PHONE, COMP_ID, BRANCH_ID)". "VALUES('$staffid', '$email', '$name', '$password', '$phone', '$staffid2', '$branchid')";
			mysqli_query($conn, $sql_insert);
			//END: Insert into staff table
			?>
				alert("<?php echo 'Staff '.$staffid.' successfully added'; ?>");
			<?php
			header("Refresh:0");
		}
		mysqli_close($conn);
		?>

	</script>
	<?php
}
?>
