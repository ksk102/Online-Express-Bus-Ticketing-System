<?php

require 'Database/db_con.php';

if(!isset($_GET['reset_code']))
{
	header('Location:forgotpw.php');
}
if(isset($_SESSION['sess_uid']))
{
	header("Location: index.php");
}
$rstcode 	= $_GET['reset_code'];
$splitvar	= explode('/', $rstcode);
$usertype	= $splitvar[0];
//print_r($splitvar);

if($usertype == "C")
{
	$update_sql = "UPDATE customer SET CUST_PW='' where RESET_CODE='$rstcode'";
	$result		= mysqli_query($conn, $update_sql);
}
else if($usertype == "S")
{
	$update_sql = "UPDATE staff SET STAFF_PW='' where RESET_CODE='$rstcode'";
	$result		= mysqli_query($conn, $update_sql);
}
else if($usertype == "A")
{
	$update_sql = "UPDATE admin SET ADMIN_PW='' where RESET_CODE='$rstcode'";
	$result		= mysqli_query($conn, $update_sql);
}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Reset Password | BusForAll.com</title>
		
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css"/>
       <link href="css-folder/reset.css" rel="stylesheet" type="text/css"/>
	   
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
	   function check_pw()
		{
			if (document.reset_frm.cust_password.value == "")
			{
				document.getElementById('PwError').innerHTML = ' Enter your password';
				return false;
			}
			else
			{
				if (document.reset_frm.cust_password.value.length <4)
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
			if (document.reset_frm.cust_repassword.value == "")
			{
				document.getElementById('RepwError').innerHTML = " Password doesn't match";
				return false;
			}
			else
			{
				if (document.reset_frm.cust_repassword.value !== document.reset_frm.cust_password.value)
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
			if(check_pw() && check_repw())
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
				<div id="main-content">
                	<div id="signin-wrapper" style="width:600px;">
					<h3 style="width:600px">Reset Password</h3>
						<div id="signin-content1">
    						<form name="reset_frm" method="post" action="" onsubmit="return validate();">
    							<table width="600px">
									<tr>
										<input type="hidden" name="usertype" value="<?php echo $usertype; ?>">
										<td width="130px" style="text-align:right;padding-right:10px;">Password<span class="red">*</span></td>
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
								</table>
      							<input type="submit" name="resetbtn" value="Reset">
							</form>
						</div>
					</div>
				</div>

			<?php include 'include/btmnavi.php'; ?>
			</div>
		</div>
		<?php include 'include/popup_jq.php'; ?>
</body>
</html>

<?php
if(isset($_POST["resetbtn"]))
{
	$password  = $_POST['cust_password'];
	$user_type = $_POST['usertype'];
	$alertmsg  = "You have successfully reset your password, you may now login with your new password.";
	
	if($user_type == "C")
	{
		$sql_update = "UPDATE customer SET RESET_CODE=NULL, CUST_PW='$password' where RESET_CODE='$rstcode'";
		$result 	= mysqli_query($conn, $sql_update);
		//Display alert message and redirect after ok button is pressed
		echo "<script>alert('$alertmsg'); window.location.href='index.php';</script>";	
	}
	else if($user_type == "S")
	{
		$sql_update = "UPDATE staff SET RESET_CODE=NULL, STAFF_PW='$password' where RESET_CODE='$rstcode'";
		mysqli_query($conn, $sql_update);
		echo "<script>alert('$alertmsg'); window.location.href='index.php';</script>";
	}
	else if($user_type == "A")
	{
		$sql_update = "UPDATE admin SET RESET_CODE=NULL, ADMIN_PW='$password' where RESET_CODE='$rstcode'";
		mysqli_query($conn, $sql_update);
		echo "<script>alert('$alertmsg'); window.location.href='index.php';</script>";
	}
}
?>