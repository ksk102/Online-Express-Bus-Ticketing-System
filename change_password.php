<?php 

require 'Database/db_con.php';

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
	else if (substr($sesscustid,0,1)== "Q")
	{
		header('Location: index.php');
	}
		$result_user = mysqli_query($conn, $sql_user);
		$row		 = mysqli_fetch_assoc($result_user);
}
else
{
	header('Location: index.php');
}

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Change Password | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/changepw.css" rel="stylesheet" type="text/css">
		
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
			width:195px;
			background:#999;
		}

		.strength1
		{
			width:39px;
			background:#ff0000;
		}

		.strength2
		{
			width:78px;	
			background:#ff5f5f;
		}

		.strength3
		{
			width:117px;
			background:#56e500;
		}

		.strength4
		{
			background:#4dcd00;
			width:156px;
		}

		.strength5
		{
			background:#399800;
			width:195px;
		}
		</style>
		
		<script type="text/javascript">
		function check_oldpw()
		{
			if (document.myprofile.user_oldpw.value == "")
			{
				document.getElementById('OldPwError').innerHTML = ' Enter your old password';
				return false;
			}
			else
			{
				document.getElementById('OldPwError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		function check_pw()
		{
			if (document.myprofile.user_pw.value == "")
			{
				document.getElementById('PwError').innerHTML = ' Enter your password';
				return false;
			}
			else
			{
				if (document.myprofile.user_pw.value.length <4)
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
			if (document.myprofile.user_repw.value == "")
			{
				document.getElementById('RepwError').innerHTML = " Password doesn't match";
				return false;
			}
			else
			{
				if (document.myprofile.user_repw.value !== document.myprofile.user_pw.value)
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
		function validate()
		{
			if(check_oldpw() && check_pw() && check_repw())
			{
				return true;
			}
			else
			{
				alert("Please check your information again");
			}
		}
		
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
							<p>Change Password</p>
							<hr/>
						</div>
						<div id="edituserprofilefrm">
							<form name="myprofile" id="myprofile-form" action="" method="post" onsubmit="return validate();">
								<table>
									<tr>
										<td width="150px" style="text-align:right;padding-right:10px;">Old Password<span class="red">*</span></td>
										<td>
											<input type="text" name="user_oldpw" placeholder="Your old password" value="" oninput="check_oldpw();"/><span id="OldPwError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Password<span class="red">*</span></td>
										<td><input type="password" name="user_pw" value="" placeholder="Enter new password" onkeyup="passwordStrength(this.value)" oninput="check_pw();"><span id="PwError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Confirm Password<span class="red">*</span></td>
										<td><input type="password" name="user_repw" value="" placeholder="Re-enter new password" oninput="check_repw();" onblur="check_repw();"><span id="RepwError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Password Strength</td>
										<td><span id="passwordDescription">Password not entered</span><br/><span id="passwordStrength" class="strength0"></span></td>
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
	</body>
</html>

<?php
if(isset($_POST["confirmbtn"]))
{
	$oldpw		= $_POST["user_oldpw"];
	$newpw		= $_POST["user_pw"];
	$alertmsg	= "Please enter the correct old password";
	$alertmsg1	= "Password changed successfully";
	$alertmsg2	= "New password cannot same with old password";
	
	if(substr($sesscustid,0,1)== "C")
	{
		$sql_user 	 = "SELECT * from customer where CUST_ID = '$sesscustid' && CUST_PW='$oldpw'";
		$result_user = mysqli_query($conn, $sql_user);
		$row		 = mysqli_fetch_assoc($result_user);
		if($result_user)
		{
			if($row['CUST_PW'] !== $oldpw)
			{
				echo "<script>alert('$alertmsg');</script>";
			}
			else if($row['CUST_PW'] !== $newpw)
			{
				$update_table = "UPDATE customer SET CUST_PW='$newpw' WHERE CUST_ID='$sesscustid'";
				mysqli_query($conn, $update_table);
				echo "<script>alert('$alertmsg1'); window.location.href='user_profile.php';</script>";
			}
			
			else
			{
				echo "<script>alert('$alertmsg2');</script>";
				exit;
			}
		}
		else
		{
			echo "<script>alert('$alertmsg');</script>";
		}
	}
	else if (substr($sesscustid,0,1)== "S")
	{
		$sql_user 	 = "SELECT * from staff where STAFF_ID = '$sesscustid' && STAFF_PW='$oldpw'";
		$result_user = mysqli_query($conn, $sql_user);
		$row		 = mysqli_fetch_assoc($result_user);
		if($result_user)
		{
			if($row['STAFF_PW'] !== $oldpw)
			{
				echo "<script>alert('$alertmsg');</script>";
			}
			else if($row['STAFF_PW'] !== $newpw)
			{
				$update_table = "UPDATE staff SET STAFF_PW='$newpw' WHERE STAFF_ID='$sesscustid'";
				mysqli_query($conn, $update_table);
				echo "<script>alert('$alertmsg1'); window.location.href='staff_profile.php';</script>";
			}
			else
			{
				echo "<script>alert('$alertmsg2');</script>";
				exit;
			}
		}
		else
		{
			echo "<script>alert('$alertmsg');</script>";
		}
	}
	else if (substr($sesscustid,0,1)== "A")
	{
		$sql_user 	 = "SELECT * from admin where ADMIN_ID = '$sesscustid' && ADMIN_PW='$oldpw'";
		$result_user = mysqli_query($conn, $sql_user);
		$row		 = mysqli_fetch_assoc($result_user);
		if($result_user)
		{
			if($row['ADMIN_PW'] !== $oldpw)
			{
				echo "<script>alert('$alertmsg');</script>";
			}
			else if($row['ADMIN_PW'] !== $newpw)
			{
				$update_table = "UPDATE admin SET ADMIN_PW='$newpw' WHERE ADMIN_ID='$sesscustid'";
				mysqli_query($conn, $update_table);
				echo "<script>alert('$alertmsg1'); window.location.href='admin_profile.php';</script>";
			}
			else
			{
				echo "<script>alert('$alertmsg2');</script>";
				exit;
			}	
		}
		else
		{
			echo "<script>alert('$alertmsg');</script>";
		}
	}
						
	mysqli_close($conn);
}
?>