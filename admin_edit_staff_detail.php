<?php 

require 'Database/db_con.php';

$sessadmid  = $_SESSION["sess_uid"];
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

if (isset($_GET['staff_id']))
{
	$staff_id	  = $_GET['staff_id'];
	$sql_staff	  = "SELECT * from staff where STAFF_ID = '$staff_id'";
	$result_staff = mysqli_query($conn, $sql_staff);
	$row2		  = mysqli_fetch_assoc($result_staff);
}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Edit Staff | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/addstaff.css" rel="stylesheet" type="text/css">
		
		
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
							<p>Edit Staff Profile</p>
							<hr/>
						</div>
						<div id="newprofilefrm">
							<form name="myprofile" id="myprofile-form" action="" method="post" onsubmit="return validate();">
								<table>
									<tr>
										<td width="150px">Staff ID</td>
										<td>
											<input type="text" name="staff_id" value="<?php echo $row2['STAFF_ID'];?>" readonly class="readonly"/>
										</td>
									</tr>
									<tr>
										<td>Email<span class="red">*</span></td>
										<td>
											<input type="email" name="staff_email" value="<?php echo $row2['STAFF_EMAIL'];?>" placeholder="Your email address" oninput="check_email();"/><span id="EmailError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>Name<span class="red">*</span></td>
										<td><input type="text" name="staff_name" value="<?php echo $row2['STAFF_NAME'];?>" placeholder="Staff's name" oninput="check_name();"/><span id="NameError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td>Contact Number</td>
										<td>
											<input type="text" name="staff_phone" value="<?php echo $row2['STAFF_PHONE'];?>" placeholder="Staff's Contact Number" oninput="check_phone();"/><span id="PhoneError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>Branch<span class="red">*</span></td>
										<td>
											<select id="branch_id" name="branch_id" oninput="check_branch();">
												<option value="none">--Select a Branch--</option>
												<?php
													$compid	  = $row["COMP_ID"];
												
													$sql_branch	  = "SELECT * from branch where COMP_ID = '$compid'";
													$result_branch = mysqli_query($conn, $sql_branch);
													while($row_branch  = mysqli_fetch_assoc($result_branch))
													{
													?>
													<option value="<?php echo $row_branch['BRANCH_ID'];?>"<?php if($row_branch['BRANCH_ID']==$row2['BRANCH_ID']){echo 'selected';} ?>><?php echo $row_branch['BRANCH_NAME'];?></option>
													<?php
													}
													?>
												
											</select><span id="BranchError" class="red">&nbsp;</span>
										</td>
									</tr>
								</table>
								<div id="newprofile-btn">
									<input type="submit" name="addbtn" value="Save Changes"/>
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
	$email		= $_POST["staff_email"];
	$name		= $_POST["staff_name"];
	$phone		= $_POST["staff_phone"];
	$branchid	= $_POST["branch_id"];
		
		//Update staff table
		$staff_table	= "staff";
		$sql_insert		= "UPDATE $staff_table SET STAFF_EMAIL='$email', STAFF_NAME='$name', STAFF_PHONE='$phone', BRANCH_ID='$branchid' where STAFF_ID='$staff_id'";
		mysqli_query($conn, $sql_insert);
		//END: Update staff table
		echo "<script>alert('Staff successfully edited'); window.location.href='view_staff_detail.php';</script>";
		mysqli_close($conn);
}
?>
