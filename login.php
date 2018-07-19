<?php 

	require 'Database/db_con.php';
	
	if(isset($_GET['q']))
	{
		$routeid = $_GET["q"];
		
		if(isset($_SESSION['sess_uid']))
		{
			header("Location: chooseseat.php?q=".$routeid);
		}
	}
	else if(isset($_SESSION['sess_uid']))
	{
		header("Location: index.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Sign in | BusForAll.com</title>
		
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css"/>
        <link href="css-folder/Signin.css" rel="stylesheet" type="text/css"/>
		
		<script type="text/javascript">
		function check_email1()
		{
			if (document.signin_frm1.user_email1.value == "" || !(isNaN(document.signin_frm1.user_email1.value)) || document.signin_frm1.user_email1.value.indexOf("@") == -1 || document.signin_frm1.user_email1.value.indexOf(".com") == -1)
			{
				document.getElementById('EmailError1').innerHTML = ' Enter the correct email';		
				return false;
			}
			else
			{
				document.getElementById('EmailError1').innerHTML = '&nbsp;';
				return true;
			}
		}
		
		function check_pw1()
		{
			if (document.signin_frm1.user_pword1.value == "")
			{
				document.getElementById('PwError1').innerHTML = ' Enter your password';
				return false;
			}
			else
			{
				document.getElementById('PwError1').innerHTML = '&nbsp;';
				return true;
			}
		}
		
		function validatelogin1()
		{
			if (check_email1() && check_pw1())
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
				<div id="main-content">
                	<div id="signin-wrapper">
					<h3>Sign In</h3>
						<div id="signin-content1">
        					<img src="images/icon/signedin/empty-pic.png">
    						<form name="signin_frm1" method="post" action="" onsubmit="return validatelogin1();">
    							<br>Email Address: <br>
    							<input type="email" name="user_email1" placeholder="user@user_email.com" size="50" maxlength="45 id="email" autofocus required oninput="check_email1();"/>
								<br/><span id="EmailError1" class="red" >&nbsp;</span>
								<br/>
      							<br>Password: <br>
        						<input type="password" name="user_pword1" placeholder="Your Password" size="20" maxlength="15" oninput="check_pw1();"/>
								<br/><span id="PwError1" class="red">&nbsp;</span>
       					 		<br><input type="submit" name="signinbtn1" value="Sign In">
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
if(isset($_POST["signinbtn1"]))
{
	$email1		= $_POST["user_email1"];
	$password1 	= $_POST["user_pword1"];
	
	//echo $email;
	//echo $password;
	$sql_user1	= "SELECT * from customer where CUST_EMAIL='$email1' and CUST_PW='$password1' and CUST_CFMCODE is NULL";
	$result_sql1	= mysqli_query($conn, $sql_user1);
	
	//Customer
	if($count = mysqli_fetch_assoc($result_sql1))
	{
		$_SESSION["sess_uid"] = $count["CUST_ID"];
		$_SESSION["sess_uname"] = $count["CUST_NAME"];
		if(isset($_GET['q']))
		{
			header("Location: chooseseat.php?q=".$routeid);
		}
		else
		{
			header("Location: index.php");
		}
		$_SESSION['login_user']= $email1;
	}
	//Staff
	$sql_staff1	= "SELECT * from staff where STAFF_EMAIL='$email1' and STAFF_PW='$password1'";
	$result_sql_staff1 = mysqli_query($conn, $sql_staff1);
	
	if($count = mysqli_fetch_assoc($result_sql_staff1))
	{
		$_SESSION["sess_uid"] = $count["STAFF_ID"];
		$_SESSION["sess_uname"] = $count["STAFF_NAME"];
		if(isset($_GET['q']))
		{
			header("Location: chooseseat.php?q=".$routeid);
		}
		else
		{
			header("Location: index.php");
		}
		$_SESSION['login_user']= $email1;
	}
	
	//Admin
	$sql_admin1	= "SELECT * from admin where ADMIN_EMAIL='$email1' and ADMIN_PW='$password1'";
	$result_sql_admin1 = mysqli_query($conn, $sql_admin1);
		
	if($count = mysqli_fetch_assoc($result_sql_admin1))
	{
		$_SESSION["sess_uid"] = $count["ADMIN_ID"];
		$_SESSION["sess_uname"] = $count["ADMIN_NAME"];
		if(isset($_GET['q']))
		{
			header("Location: chooseseat.php?q=".$routeid);
		}
		else
		{
			header("Location: index.php");
		}
		$_SESSION['login_user']= $email1;
	}
	
	else
	{
	?>
		<script type = "text/javascript">
			alert("Invalid Email or Password");
		</script>
	<?php
	}
}
?>