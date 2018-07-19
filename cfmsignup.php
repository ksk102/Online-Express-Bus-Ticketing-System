<?php

require 'Database/db_con.php';

	if(!isset($_SESSION['cfm_code']))
	{
		header('Location: index.php');
	}	


$cfm_code 	= $_GET['cfm_code'];
$update_sql = "UPDATE customer SET CUST_CFMCODE=NULL WHERE CUST_CFMCODE='$cfm_code'";
$result		= mysqli_query($conn, $update_sql) or die(mysqli_error());

if($result)
{
	?>
	<html>
		<head>
			<link rel="shortcut icon" href="images/icon/step/travel.png"/>
			<title>Account Activation | BusForAll.com</title>
			
			<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css"/>
			<link href="css-folder/cfmsignin.css" rel="stylesheet" type="text/css"/>
		</head>
		
		<body>
			<div id="container">
				<?php
					include 'include/header.php';
				?>
				
				<div id="content">
					<div id="main-content">
						<div id="signin-wrapper">
							<div id="signin-content1">
							<h3>Account Activation</h3>
							<form name="signin_frm" method="post" action="">
							<p><img src="images/icon/signupvalidation/green_tick_wobg.png"></p>
							<br>Your account has been successfully activated. <a href="login.php">Login</a> now<br>
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
}
else
{
	echo "Some error occur.";
}


?>

