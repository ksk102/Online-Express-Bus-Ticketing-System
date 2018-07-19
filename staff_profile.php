<?php 

require 'Database/db_con.php';

	if(isset($_SESSION['sess_uid']))
	{
		$sesscustid  = $_SESSION["sess_uid"];
		if(substr($sesscustid,0,1)== "C")
		{
			header('Location: user_profile.php');
		}
		else if (substr($sesscustid,0,1)== "A")
		{
			header('Location: admin_profile.php');
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

$sessstaffid = $_SESSION["sess_uid"];

$sql_staff	  = "SELECT * from staff where STAFF_ID = '$sessstaffid'";
$result_staff = mysqli_query($conn, $sql_staff);
$row 		  = mysqli_fetch_assoc($result_staff);

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>My Profile | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/staffprofile.css" rel="stylesheet" type="text/css">
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
							<p>
							<?php
								//Profile Name
								echo $row["STAFF_NAME"];
							?>'s Profile
							</p>
							<hr/>
						</div>
						<div id="newprofilefrm">
							<form name="myprofile" action="" method="">
								<table>
									<tr>
										<td width="150px">Staff's ID</td>
										<td><input type="text" name="staff_id" value="<?php echo $row["STAFF_ID"];?>" readonly class="readonly"/></td>
									</tr>
									
										<td width="150px">Email</td>
										<td>
											<input type="email" name="staff_email" value="<?php echo $row["STAFF_EMAIL"];?>" readonly class="readonly"/>
										</td>
									</tr>
									<tr>
										<td width="150px">Name</td>
										<td><input type="text" name="staff_name" value="<?php echo $row["STAFF_NAME"];?>" readonly class="readonly"/></td>
									</tr>
									<tr>
										<td>Contact Number</td>
										<td>
											<input type="text" name="staff_phone" value="<?php echo $row["STAFF_PHONE"];?>" readonly class="readonly"/>
										</td>
									</tr>
									<tr>
										<td>Branch's ID</td>
										<td>
											<input type="text" name="branch_id" value="KKL/MLK1" readonly class="readonly"/>
										</td>
									</tr>
									<tr>
										<td>Identity Card Number</td>
										<td><input type="text" name="staff_ic" value="<?php echo $row["STAFF_IC"];?>" readonly class="readonly"/></td>
									</tr>
									
									<tr>
										<td>Gender</td>
										<td><input type="text" name="cust_gender" value="<?php echo $row["STAFF_GENDER"];?>"readonly class="readonly"/>
										</td>
									</tr>
									<tr>
										<td>Date of Birth</td>
										<td><input type="date" name="staff_dob" value="<?php echo $row["STAFF_DOB"];?>" readonly class="readonly"/></td>
									</tr>
									<tr>
										<td>Age</td>
										<td>
											<input type="text" name="staff_age" value="<?php echo $row["STAFF_AGE"];?>" readonly class="readonly"/>
										</td>
									</tr>
									<tr>
										<td>Mail Address</td>
										<td><input type="text" name="staff_addr_no" value="<?php echo $row["STAFF_ADDR_STREET"];?>" readonly class="readonly" style="width:400px;"/><small> (Street)</small></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="staff_addr_city" value="<?php echo $row["STAFF_ADDR_CITY"];?>" readonly class="readonly" style="width:400px;"/><small> (City)</small></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="staff_addr_state" value="<?php if($row["STAFF_ADDR_STATE"]==""){echo "";} else if($row["STAFF_ADDR_STATE"]=="KUL"){echo "Kuala Lumpur";} else if($row["STAFF_ADDR_STATE"]=="LBN"){echo "Labuan";} else if($row["STAFF_ADDR_STATE"]=="PJY"){echo "Putrajaya";} else if($row["STAFF_ADDR_STATE"]=="JHR"){echo "Johor";} else if($row["STAFF_ADDR_STATE"]=="KDH"){echo "Kedah";} else if($row["STAFF_ADDR_STATE"]=="KTN"){echo "Kelantan";}else if($row["STAFF_ADDR_STATE"]=="MLK"){echo "Malacca";}else if($row["STAFF_ADDR_STATE"]=="NSN"){echo "Negeri Sembilan";}else if($row["STAFF_ADDR_STATE"]=="PHG"){echo "Pahang";}else if($row["STAFF_ADDR_STATE"]=="PRK"){echo "Perak";}else if($row["STAFF_ADDR_STATE"]=="PLS"){echo "Perlis";}else if($row["STAFF_ADDR_STATE"]=="PNG"){echo "Penang";}else if($row["STAFF_ADDR_STATE"]=="SBH"){echo "Sabah";}else if($row["STAFF_ADDR_STATE"]=="SWK"){echo "Sarawak";}else if($row["STAFF_ADDR_STATE"]=="SGR"){echo "Selangor";}else if($row["STAFF_ADDR_STATE"]=="TRG"){echo "Terengganu";}?>" readonly class="readonly" style="width:400px;"/><small> (State)</small></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="staff_addr_psotcode" value="<?php echo $row["STAFF_ADDR_POST"];?>" readonly class="readonly" style="width:400px;"/><small> (Post Code)</small></td>										
									</tr>
									
								</table>
								<div id="newprofile-btn">
									<a href="change_password.php"><input type="button" name="pwbtn" value="Change Password"/></a>
									<a href="edit_staff_profile.php"><input type="button" name="editbtn" value="Edit"/></a>
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
