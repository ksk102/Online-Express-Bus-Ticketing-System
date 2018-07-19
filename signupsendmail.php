<?php
error_reporting(E_ALL);
require 'Database/db_con.php';
require("extra/phpmailertest/PHPMailer_5.2.4/class.phpmailer.php");

//Retrieve the last customer ID
$sql_cust	= "SELECT CUST_ID from customer ORDER BY CID DESC LIMIT 1";
$result_sql	= mysqli_query($conn, $sql_cust);
$row		= mysqli_fetch_assoc($result_sql);
$lastcustid	= $row['CUST_ID'];

if($row<1)
{
	$custid_alpa = 'C_';
	$custid_num	 = 0;

	++$custid_num;
	$custid_numext = str_pad($custid_num,2,"0", STR_PAD_LEFT);
	$custidfinal   = $custid_alpa.$custid_numext;
}
else
{
	$custid1	 = preg_split('/_/', $lastcustid);
	$custid_alpa = 'C_';
	$custid_num	 = $custid1[1];

	++$custid_num;
	$custid_numext = str_pad($custid_num,2,"0", STR_PAD_LEFT);
	$custidfinal   = $custid_alpa.$custid_numext;

	//print_r($custid1);
	//print "<br>";
	//echo $custidfinal;
}
//END: Retrieve the last customer ID

if(isset($_POST["signup-btn"]))
{
	$name		= $_POST["cust_name"];
	$email		= $_POST["cust_email"];
	$pw			= $_POST["cust_password"];
	$repw		= $_POST["cust_repassword"];
	$ic			= $_POST["cust_ic"];
	$dob		= $_POST["cust_dob"];
	$phone		= $_POST["cust_phone"];
	$gender		= $_POST["cust_gender"];
	$street		= $_POST["cust_addr_no"];
	$city		= $_POST["cust_addr_city"];
	$state		= $_POST["cust_addr_state"];
	$postcode	= $_POST["cust_addr_postcode"];
	$captcha	= $_POST["captcha"];
	$cfm_code   = md5(uniqid(rand()));
	

	/*//Check for numeric and symbol
	$name_symbol= !(preg_match("/^[a-zA-Z ]*$/", $name));
	//Check for password length 
	$pwlen		= strlen($pw);
	//Only allow number in IC (XXXXXX-XX-XXXX)
	$ic_valid	= preg_match("/^([0-9]{6}-){1}([0-9]{2}-){1}[0-9]{4}$/", $ic);*/
	
	
	if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha']) != 0)
	{
		echo "<script>alert('Validation code error!'); window.location.href='signup.php';</script>";
	}
	
	else
	{
		$sql_exist		= "SELECT * from customer where CUST_EMAIL = '$email'";
		$result_exist	= mysqli_query($conn, $sql_exist);
		$count			= mysqli_num_rows($result_exist);

		//Age Converter
		$dob_sep	= explode("-", $dob);
		$curMonth	= date("m");
		$curDay		= date("d");
		$curYear	= date("Y");
		$age		= $curYear - $dob_sep[0];

		if($curMonth<$dob_sep[1] || ($curMonth==$dob_sep[1] && $curDay<$dob_sep[2]))
		{
			$age--;
			//echo 'The age is'.$age;
		}
		//END: Age Converter

		if($count>0)
		{
			echo "<script>alert('Email already exist!'); window.location.href='signup.php';</script>";
		}
		else
		{
			if($gender == "M")
			{
				$gender = "Male";
			}
			else if($gender == "F")
			{
				$gender = "Female";
			}
			//Insert into customer table
			$cust_table	= "customer";
			$sql_insert	= "INSERT into " .$cust_table. "(CUST_ID, CUST_EMAIL, CUST_PW, CUST_NAME, CUST_PHONE, CUST_GENDER, CUST_AGE, CUST_IC, CUST_ADDR_STREET, CUST_ADDR_CITY, CUST_ADDR_STATE, CUST_ADDR_POST, CUST_DOB, CUST_CFMCODE)". "VALUES('$custidfinal', '$email', '$pw', '$name', '$phone', '$gender', '$age', '$ic', '$street', '$city', '$state', '$postcode', '$dob', '$cfm_code')";
			$result		= mysqli_query($conn, $sql_insert);
			//END: Insert into customer table
			
			if($result)
			{
				$cfmlink = "http://localhost/FYPv12.0.0/cfmsignup.php?cfm_code=$cfm_code";
				$message = "
				<html>
					<body>
						<p>Hi, ".$name."</p>
						<p>Thanks for signing up!</p>
						<p>Your account has been created, you can login with the following credential after you activate your account.</p>
						<br/>
						<p>--------------------------------------------------------------------------------------------</p>
						<p>Login email : $email</p>
						<p>Password	   : $pw</p?
						<p>--------------------------------------------------------------------------------------------</p>
						<p>Please click the link below to verify and activate your account.</p>
						<p>$cfmlink</p>
						<br/>
						<p>We hope you enjoy BusForAll.com</p>
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
				$mail->Subject = "Welcome to BusForAll.com, please activate your account";
				$mail->Body = "$message";
				
				$alertmsg = "Thank you ".$name.". Your registration is successful.";

				if($mail->Send()) 
				{
					echo "<script>alert('$alertmsg');</script>";
					header("Location:signup_complete.php");
				}
				else {echo "send mail fail";}
			}
			
		}
		mysqli_close($conn);
	}
}



?>