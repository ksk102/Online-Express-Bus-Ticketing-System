<?php 

require 'Database/db_con.php';

?>

<!--<php
if(isset($_POST["signin-btn"]))
{
	if(isset($_POST["keepsignedin"]))
	{
		setcookie("unm",$_POST["user_email"],time()+3600);
		setcookie("pwd",$_POST["user_pword"],time()+3600);
	}
	
}
	
?>
-->
<!DOCTYPE html>
<html>
	<head>
		<title>Sign in | BusForAll.com</title>
		
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css"/>
		<link href="css-folder/bottom navigation.css" rel="stylesheet" type="text/css"/>
		<link href="css-folder/header.css" rel="stylesheet" type="text/css"/>
        <link href="css-folder/Signin.css" rel="stylesheet" type="text/css"/>
		<link rel='stylesheet prefetch' href='popup/css/popup.css'>
		<link rel='stylesheet prefetch' href='popup/css/popup1.css'>
		<link href="css-folder/signin-popup.css" rel="stylesheet" type="text/css"/>
		
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
		</style>
		
		
	</head>
	
	<script type="text/javascript">
	function check()
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
	}
	</script>
	
	<body>
		<div id="container">
			<div id="header">
				<div id="header-left">
					<a href="index.php" target="_self"><img src="images/busforall-logo.jpg" height="100px" weight="190px" alt="logo" title="Home"/></a>					                    </a>
				</div>
				<div id="header-right">
					<a href="signup.php" target="_self">Sign up</a>
				</div>
				<div id="header-right">
					<div class="links">
						<div id="signin-popup">
							<a href="#signin" data-effect="mfp-zoom-out">Login</a>
						</div>
					</div>
				</div>
				<div id="header-navi-wrapper">
					<ul class='header-navi'>
					   <li class='firstnavi'><a href='index.php'><span>Home</span></a></li>
					   <li class='secondnavi'><a href='#'><span>How to Purchase</span></a></li>
					   <li class='thirdnavi'><a href='#'><span>Book Ticket</span></a></li>
					   <li class='fourthnavi'><a href='Our%20Partner.html'><span>Our Partner</span></a></li>
					   <li class='fifthnavi'><a href='#'><span>About Us</span></a></li>
					   <li class='sixthnavi'><a href='#'><span>Contact Us</span></a></li>
					   <li class='seventhnavi'><a href='FAQ.html'><span>FAQ</span></a></li>
					</ul>
				</div>
			</div>
			
			<div id="content">
				<div id="main-content">
                	<div id="signin-wrapper">
					<h3>Sign In</h3>
						<div id="signin-content1">
        					<img src="images/icon/signedin/empty-pic.png">
    						<form name="signin_frm" method="post" action="" onsubmit="return check();">
    							<br>Email Address: <br>
    							<input type="email" name="user_email" placeholder="user@user_email.com" size="50" maxlength="45 id="email" autofocus required>
      							<br>Password: <br>
        						<input type="password" name="user_pw" placeholder="Your Password" size="20" maxlength="15">  
       					 		<br><input type="submit" name="signinbtn" value="Sign In">
							</form>
						</div>
					</div>
				</div>

			<div id="btm-navi">
				<div id="btm-navi-menu">
					<ul>
						<li><a href="index.php" target="_blank">Home</a></li>
						<li><a href="#" target="_blank">How to Purchase</a></li>
						<li><a href="#" target="_blank">Book Ticket</a></li>
						<li><a href="Our%20Partner.html" target="_blank">Our Partner</a></li>
						<li><a href="#" target="_blank">About Us</a></li>
						<li><a href="#" target="_blank">Contact Us</a></li>
						<li><a href="FAQ.html" target="_blank">FAQ</a></li>
					</ul>
				</div>
				<div id="btm-navi-left">
					<ul>
						<li><a href="#" target="_blank">Terms of Use</a> |</li>
						<li><a href="#" target="_blank">Privacy Policy</a> |</li>
						<li><a href="#" target="_blank">Career</a> |</li>
						<li><a href="#" target="_blank">Advertise</a></li>
					</ul>
				</div>
				<div id="btm-navi-btm">
					<small>Copyright 2015. All Rights Reserved.</small>
				</div>
			</div>
		</div>
		<div id="signin" class="signin-popup mfp-with-anim mfp-hide">
			<div id="signinpopup">
				<div id="signin-content">
					<form name="signin_frm" action="" method="post">
						<br>Email</br>
						<input type="email" name="user_email" <!--value="<php echo $_COOKIE["unm"] ?>" -->placeholder="user@user.com" size="50" maxlength="40" id="login" autofocus required/>
						<br>Password <br>
						<input type="Password" name="user_pword" <!--value="<php echo $_COOKIE["pwd"] ?>"--> placeholder="Your Password" size="30" maxlength="20" title="One uppercase letter, one lowercase letter and followed by four digit" id="pword"/>
						<br/>
						<input type="checkbox" name="keepsignedin" value="keepsignedin" style="width:15px; height:15px;"/><span style="font-size:11pt;">Keep me signed in</span>
						<br/>
						<input type="submit" name="signin-btn" value="Sign in"/>
					
						<p><a href="#" class="problem">Forget password?</a></p>
						<p style="font-size:9.5pt;">Don't have an account? <a href="signup.php" class="problem">Sign up now</a></p>
					</form>
				</div>
			</div>
		</div>
		<!-- pop up-->
		<script src='popup/js/jquery.min.js'></script>
		<script src='popup/js/jquery.magnific-popup.min.js'></script>
		<script src="popup/js/index.js"></script>
		<!--end of pop up-->
</body>
</html>

<?php
if(isset($_POST["signinbtn"]))
{
	$email		= $_POST["user_email"];
	$password 	= $_POST["user_pw"];
	
	//echo $email;
	//echo $password;
	$sql_user	= "SELECT * from customer where CUST_EMAIL='$email' and CUST_PW='$password'";
	$result_sql	= mysqli_query($conn, $sql_user);
	
	//Customer
	if($count = mysqli_fetch_assoc($result_sql))
	{
		$_SESSION["sess_custid"] = $count["CUST_ID"];
		header("Location: user_profile.php");
	}
	//Staff
	else if($count != mysqli_fetch_assoc($result_sql))
	{
		$sql_staff	= "SELECT * from staff where STAFF_EMAIL='$email' and STAFF_PW='$password'";
		$result_sql_staff = mysqli_query($conn, $sql_staff);
		
		if($count = mysqli_fetch_assoc($result_sql_staff))
		{
			$_SESSION["sess_staffid"] = $count["STAFF_ID"];
			header("Location: staff_profile.php");
		}
	}
	/*//Admin
	else if($count != mysqli_fetch_assoc($result_sql_staff))
	{
		$sql_admin	= "SELECT * from admin where ADMIN_EMAIL='$email' and ADMIN_PW='$password'";
		$result_sql_admin = mysqli_query($conn, $sql_admin);
		
		if($count = mysqli_fetch_assoc($result_sql_admin))
		{
			$_SESSION["sess_adminid"] = $count["ADMIN_ID"];
			header("Location: "];
		}
	}*/
	else
	{
	?>
		<script type = "text/javascript">
			alert("Invalid Email or Password");
		</script>
	<?php
	}
	mysqli_close($conn);
}

?>