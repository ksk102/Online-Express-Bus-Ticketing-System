<?php 

require 'Database/db_con.php';

?>		
		
	<link rel='stylesheet prefetch' href='popup/css/popup.css'>
	<link rel='stylesheet prefetch' href='popup/css/popup1.css'>
	<link href="css-folder/signin-popup.css" rel="stylesheet" type="text/css"/>
	
	<script type="text/javascript">
	/*function check()
	{
		email = document.signin_frm.user_email.value;
		pw	  = document.signin_frm.user_pw.value;
	
		if (email == "")
		{
			alert("Please enter your email");
			return false;
		}
		else if(pw =="")
		{
			alert("Please enter your password");
			return false;
		}
		else
		{
			return true;
		}
	}*/
	function check_emailz()
	{
		if (document.signin_frm.user_email.value == "" || !(isNaN(document.signin_frm.user_email.value)) || document.signin_frm.user_email.value.indexOf("@") == -1 || document.signin_frm.user_email.value.indexOf(".com") == -1)
		{
			document.getElementById('EmailErrorz').innerHTML = ' Enter the correct email';		
			return false;
		}
		else
		{
			document.getElementById('EmailErrorz').innerHTML = '&nbsp;';
			return true;
		}
	}
	
	function check_pwz()
	{
		if (document.signin_frm.user_pword.value == "")
		{
			document.getElementById('PwErrorz').innerHTML = ' Enter your password';
			return false;
		}
		else
		{
			document.getElementById('PwErrorz').innerHTML = '&nbsp;';
			return true;
		}
	}
	
	function validatelogin()
	{
		if (check_emailZ() && check_pw())
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


		<style rel="stylesheet" type="text/css">
		#signinpopup #login
		{
			background-image:url(images/icon/login/email.png);
			background-repeat:no-repeat;
			background-position:5px;
			padding-left:25px;
		}
		#signinpopup #pword
		{
			background-image:url(images/icon/login/lock.png);
			background-repeat:no-repeat;
			background-position:5px;
			padding-left:25px;
		}
		
		.red
		{
			color:red;
		}
		</style>
		
		<div id="signin" class="signin-popup mfp-with-anim mfp-hide">
			<div id="signinpopup">
				<div id="signin-content">
					<form name="signin_frm" action="" method="post" onsubmit="return validatelogin();">
						<br>Email</br>
						<input type="email" name="user_email" placeholder="user@user.com" size="50" maxlength="40" id="login" oninput="check_emailz();" required autofocus="autofocus"/>
						<br/><span id="EmailErrorz" class="red">&nbsp;</span>
						<br/>
						<br>Password <br>
						<input type="Password" name="user_pword" placeholder="Your Password" size="30" maxlength="20" title="One uppercase letter, one lowercase letter and followed by four digit" id="pword" oninput="check_pwz();"/>
						<br/><span id="PwErrorz" class="red">&nbsp;</span>
						<br/>
						<br/>
						<!--<input type="checkbox" name="keepsignedin" value="keepsignedin" style="width:15px; height:15px;"/><span style="font-size:11pt;">Keep me signed in</span>
						<br/>-->
						<input type="submit" name="signin-btn" value="Sign in"/>
						
						<p><a href="forgotpw.php" class="problem">Forget password?</a></p>
						<p style="font-size:9.5pt;">Don't have an account? <a href="signup.php" class="problem">Sign up now</a></p>
					</form>
				</div>
			</div>
		</div>
		
<?php
if(isset($_POST["signin-btn"]))
{
	$email		= $_POST["user_email"];
	$password 	= $_POST["user_pword"];
	
	//echo $email;
	//echo $password;
	$sql_user	= "SELECT * from customer where CUST_EMAIL='$email' and CUST_PW='$password' and CUST_CFMCODE is NULL";
	$result_sql	= mysqli_query($conn, $sql_user);
	
	//Customer
	if($count = mysqli_fetch_assoc($result_sql))
	{
		$_SESSION["sess_uid"] = $count["CUST_ID"];
		$_SESSION["sess_uname"] = $count["CUST_NAME"];
		header("Location: index.php");
		$_SESSION['login_user']= $email;
	}
	//Staff
	$sql_staff	= "SELECT * from staff where STAFF_EMAIL='$email' and STAFF_PW='$password'";
	$result_sql_staff = mysqli_query($conn, $sql_staff);
	
	if($count = mysqli_fetch_assoc($result_sql_staff))
	{
		$_SESSION["sess_uid"] = $count["STAFF_ID"];
		$_SESSION["sess_uname"] = $count["STAFF_NAME"];
		header("Location: index.php");
		$_SESSION['login_user']= $email;
	}
	
	//Admin
	$sql_admin	= "SELECT * from admin where ADMIN_EMAIL='$email' and ADMIN_PW='$password'";
	$result_sql_admin = mysqli_query($conn, $sql_admin);
		
	if($count = mysqli_fetch_assoc($result_sql_admin))
	{
		$_SESSION["sess_uid"] = $count["ADMIN_ID"];
		$_SESSION["sess_uname"] = $count["ADMIN_NAME"];
		header("Location: index.php");
		$_SESSION['login_user']= $email;
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