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
		else if (substr($sesscustid,0,1)== "A")
		{
			$sessadmid  = $_SESSION["sess_uid"];

			$sql_user 	 = "SELECT * from admin where ADMIN_ID = '$sessadmid'";
			$result_user = mysqli_query($conn, $sql_user);
			$row		 = mysqli_fetch_assoc($result_user);
		}
	}
	else
	{
		header('Location: index.php');
	}

$companycode = $row['COMP_ID'];
$sql_companyname		= "SELECT * FROM company WHERE COMP_ID = '$companycode' group by COMP_NAME";
$result_companyname	= mysqli_query($conn, $sql_companyname);
$row_companyname = mysqli_fetch_array($result_companyname);
$company = $row_companyname['COMP_NAME'];
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>My Profile | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/userprofile.css" rel="stylesheet" type="text/css">
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
								echo $row["ADMIN_NAME"];
							?>'s Profile
							</p>
							<hr/>
						</div>
						<div id="newprofilefrm">
							<form name="myprofile" action="" method="">
								<table>
									<tr>
										<td width="120px" style="text-align:right;padding-right:10px;">Email</td>
										<td>
											<input type="email" name="admin_email" value="<?php echo $row["ADMIN_EMAIL"];?>" readonly class="readonly"/>
										</td>
									</tr>
									<tr>
										<td width="120px" style="text-align:right;padding-right:10px;">Name</td>
										<td><input type="text" name="admin_name" value="<?php echo $row["ADMIN_NAME"];?>" readonly class="readonly"/></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Company</td>
										<td><input type="text" name="admin_company" value="<?php echo $company;?>" readonly class="readonly"/>
										</td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Identity Card Number</td>
										<td><input type="text" name="admin_ic" value="<?php echo $row["ADMIN_IC"];?>" readonly class="readonly"/></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Contact Number</td>
										<td><input type="text" name="admin_phone" value="<?php echo $row["ADMIN_PHONE"];?>" readonly class="readonly"/>
										</td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Gender</td>
										<td><input type="text" name="admin_gender" value="<?php if ($row["ADMIN_GENDER"]=="M" || $row["ADMIN_GENDER"]=="m") {echo "Male";} else if ($row["ADMIN_GENDER"]=="F" || $row["ADMIN_GENDER"]=="f") {echo "Female";} else {echo "Undefied";}?>"readonly class="readonly"/>					
										</td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Mail Address</td>
										<td><input type="text" name="admin_addr_no" value="<?php echo $row["ADMIN_ADDR_STREET"];?>" readonly class="readonly" style="width:400px;"/><small> (Street)</small></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="admin_addr_city" value="<?php echo $row["ADMIN_ADDR_CITY"];?>" readonly class="readonly" style="width:400px;"/><small> (City)</small></td>
									</tr>
												
									<tr>
										<td></td>
										<td><input type="text" name="admin_addr_state" value="<?php if($row["ADMIN_ADDR_STATE"]==""){echo "";} else if($row["ADMIN_ADDR_STATE"]=="KUL"){echo "Kuala Lumpur";} else if($row["ADMIN_ADDR_STATE"]=="LBN"){echo "Labuan";} else if($row["ADMIN_ADDR_STATE"]=="PJY"){echo "Putrajaya";} else if($row["ADMIN_ADDR_STATE"]=="JHR"){echo "Johor";} else if($row["ADMIN_ADDR_STATE"]=="KDH"){echo "Kedah";} else if($row["ADMIN_ADDR_STATE"]=="KTN"){echo "Kelantan";}else if($row["ADMIN_ADDR_STATE"]=="MLK"){echo "Malacca";}else if($row["ADMIN_ADDR_STATE"]=="NSN"){echo "Negeri Sembilan";}else if($row["ADMIN_ADDR_STATE"]=="PHG"){echo "Pahang";}else if($row["ADMIN_ADDR_STATE"]=="PRK"){echo "Perak";}else if($row["ADMIN_ADDR_STATE"]=="PLS"){echo "Perlis";}else if($row["ADMIN_ADDR_STATE"]=="PNG"){echo "Penang";}else if($row["ADMIN_ADDR_STATE"]=="SBH"){echo "Sabah";}else if($row["ADMIN_ADDR_STATE"]=="SWK"){echo "Sarawak";}else if($row["ADMIN_ADDR_STATE"]=="SGR"){echo "Selangor";}else if($row["ADMIN_ADDR_STATE"]=="TRG"){echo "Terengganu";}?>" readonly class="readonly" style="width:400px;"/><small> (State)</small></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="admin_addr_psotcode" value="<?php echo $row["ADMIN_ADDR_POST"];?>" readonly class="readonly" style="width:400px;"/><small> (Post Code)</small></td>										
									</tr>
									
								</table>
								<div id="newprofile-btn">
									<a href="change_password.php"><input type="button" name="pwbtn" value="Change Password"/></a>
									<a href="edit_admin_profile.php"><input type="button" name="editbtn" value="Edit Profile"/></a>
								</div>
							</form>
						</div>  
					</div>
				</div>
			</div>
		
			<?php include 'include/btmnavi.php'; ?>
		</div>
		<?php include 'include/popup_jq.php'; ?>
	</body>
</html>
