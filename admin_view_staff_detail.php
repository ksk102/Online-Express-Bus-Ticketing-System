<?php 

require 'Database/db_con.php';

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
	}
	else
	{
		header('Location: index.php');
	}

$sessadmid  = $_SESSION["sess_uid"];

$sql_user 	 = "SELECT * from admin where ADMIN_ID = '$sessadmid'";
$result_user = mysqli_query($conn, $sql_user);
$row		 = mysqli_fetch_assoc($result_user);

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
		<title>View Staff Detail | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/addstaff.css" rel="stylesheet" type="text/css">
		
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
							<p>View Staff Profile</p>
							<hr/>
						</div>
						<div id="newprofilefrm">
							<form name="myprofile" id="myprofile-form" action="" method="post">
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
											<input type="email" name="staff_email" value="<?php echo $row2['STAFF_EMAIL'];?>" placeholder="Your email address" readonly class="readonly"/>
										</td>
									</tr>
									<tr>
										<td>Name<span class="red">*</span></td>
										<td><input type="text" name="staff_name" value="<?php echo $row2['STAFF_NAME'];?>" placeholder="Staff's name" readonly class="readonly"/></td>
									</tr>
									<tr>
										<td>Contact Number</td>
										<td>
											<input type="text" name="staff_phone" value="<?php echo $row2['STAFF_PHONE'];?>" placeholder="Staff's Contact Number" readonly class="readonly"/>
										</td>
									</tr>
									<tr>
										<td>Branch's ID<span class="red">*</span></td>
										<td><input type="text" name="branch_id" value="<?php echo $row2['BRANCH_ID'];?>" placeholder="Staff assigned branch" readonly class="readonly"/></td>
									</tr>
								</table>
								
							</form>
						</div>  
					</div>
				</div>
			</div>
		
			<?php include 'include/btmnavi.php'; ?>
		</div>
	</body>
</html>