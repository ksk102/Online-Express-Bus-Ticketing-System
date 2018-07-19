<?php
error_reporting(E_ALL);
require 'Database/db_con.php';
require("extra/phpmailertest/PHPMailer_5.2.4/class.phpmailer.php");

	if(isset($_SESSION['sess_uid']))
	{
		$sesscustid  = $_SESSION["sess_uid"];
		if(substr($sesscustid,0,1)== "C")
		{
			header('Location: index.php');
		}
		else if (substr($sesscustid,0,1)== "S")
		{
			header('Location: index.php');
		}
		else if (substr($sesscustid,0,1)== "Q")
		{
			header('Location: index.php');
		}
		else if (substr($sesscustid,0,1)== "A")
		{
			header('Location: index.php');
		}
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Forget Password | BusForAll.com</title>
		
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css"/>
        <link href="css-folder/Signin.css" rel="stylesheet" type="text/css"/>
	</head>
	
	<body>
		<div id="container">
			<?php
				include 'include/header.php';
			?>
			
			<div id="content">
				<div id="main-content">
                	<div id="signin-wrapper">
					<h3>Forget Password</h3>
						<div id="signin-content1">
        					<img src="images/icon/signedin/empty-pic.png">
    						<form name="signin_frm" method="post" action="">
    							<br>Email Address: <br>
    							<input type="email" name="user_email" placeholder="user@user_email.com" size="50" maxlength="45 id="email" autofocus required>
      							<br><input type="submit" name="resetbtn" value="Reset">
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
	$rstcode = md5(uniqid(rand()));
	$email	 = $_POST["user_email"];
	
	$sql_user   = "SELECT * from customer where CUST_EMAIL='$email'";
	$sql_result = mysqli_query($conn, $sql_user);
	$row		= mysqli_fetch_assoc($sql_result);
	
	$sql_staff   = "SELECT * from staff where STAFF_EMAIL='$email'";
	$sql_result2 = mysqli_query($conn, $sql_staff);
	$row2		 = mysqli_fetch_assoc($sql_result2);
	
	$sql_admin   = "SELECT * from admin where ADMIN_EMAIL='$email'";
	$sql_result3 = mysqli_query($conn, $sql_admin);
	$row3		 = mysqli_fetch_assoc($sql_result3);
	
	if($row>0)
	{
		$id			= $row['CUST_ID'];
		$name 		= $row['CUST_NAME'];
		$email		= $row['CUST_EMAIL'];
		$crstcode	= 'C/'.$rstcode;
		$sql_update = "UPDATE customer SET RESET_CODE='$crstcode' where CUST_ID='$id'";
		$result     = mysqli_query($conn, $sql_update);
	}
	else if($row2>0)
	{
		$id			= $row2['STAFF_ID'];
		$name 		= $row2['STAFF_NAME'];
		$email		= $row2['STAFF_EMAIL'];
		$crstcode	= 'S/'.$rstcode;
		$sql_update = "UPDATE staff SET RESET_CODE='$rstcode' where STAFF_ID='$id'";
		$result     = mysqli_query($conn, $sql_update);
	}
	else if($row3>0)
	{
		$id			= $row3['ADMIN_ID'];
		$name 		= $row3['ADMIN_NAME'];
		$email		= $row3['ADMIN_EMAIL'];
		$crstcode	= 'A/'.$rstcode;
		$sql_update = "UPDATE admin SET RESET_CODE='$rstcode' where ADMIN_ID='$id'";
		$result     = mysqli_query($conn, $sql_update);
	}
	else
	{
		//Email doesn't exist
		?>
		<script>
		alert("Email doesn't exist!")
		</script>
		<?php
		exit;
	}
	
	if($result)
	{
		$rstlink = "http://localhost/FYPv12.0.0/reset.php?reset_code=$crstcode";
		$message = "
		<html>
			<body>
				<p>$name,</p>
				<p>We've received a request to reset your password on BusForAll.com</p>
				<p>Click the link below to set a new password:</p>
				<p>$rstlink</p>
				<p>If you did not request to reset your password, you can ignore this message.</p>
				<br/>
				<p>Thanks,</p>
				<p>BusForAll Team</p>
			</body>
		</html>
		";
		
		$mail = new PHPMailer();

		$mail->IsSMTP(); //set mailer to use SMTP
		$mail->SMTPDebug = false;
		$mail->From = "service@busforall.com";
		$mail->FromName = "BusForAll.com";
		$mail->Host = "smtp.gmail.com"; //specif smtp server
		$mail->SMTPSecure= "ssl"; //Used instead of TLS when only POP mail
		$mail->Port = 465; //Used instead of 587 when only POP mail is selected
		$mail->SMTPAuth = true;
		$mail->Username = "tayboonhau@gmail.com"; //SMTP username, (your email)
		$mail->Password = "tbh950427"; //SMTP password, (your password)
		$mail->AddAddress("$email", "$name");
		$mail->AddReplyTo("bryantanhw@gmail.com", "bryantanhw");
		$mail->WordWrap = 50; //set word warp
		//$mail->AddAttachment("C:\\temp\\js-bak.sql"); //add attachments
		//$mail->AddAttachment("c:/temp/11-10-00.zip");

		$mail->IsHTML(true);
		$mail->Subject = "BusForAll.com: Reset Password";
		$mail->Body = "$message";
		
		$alertmsg = "A reset password email has been sent to your email.";

		if($mail->Send()) 
		{
			echo "<script>alert('$alertmsg');</script>";
		}
		else {echo "send mail fail";}
	}
}
?>