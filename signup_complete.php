<?php

require 'Database/db_con.php';
if(isset($_SESSION['sess_uid']))
	{
		header("Location: index.php");
	}

?>
<!doctype html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Sign Up | BusForAll.com</title>
		
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
						<h3>BusForAll Sign Up Confirmation</h3>
						<form name="signin_frm" method="post" action="">
						<br><br><br>Thank you for signing up. A confirmation email has been send to your email, please follow the instructions in the message to activate your account.<br>
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