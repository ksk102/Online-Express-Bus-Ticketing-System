<?php

require 'Database/db_con.php';
if(isset($_SESSION['sess_uid']))
{
	$sesscustid  = $_SESSION["sess_uid"];
	if(substr($sesscustid,0,1)== "C")
	{
		header('Location: user_profile.php');
		$sql_user 	 = "SELECT * from customer where CUST_ID = '$sesscustid'";
	}
	else if (substr($sesscustid,0,1)== "S")
	{
		$sql_user 	 = "SELECT * from staff where STAFF_ID = '$sesscustid'";
	}
	else if (substr($sesscustid,0,1)== "A")
	{
		$sql_user 	 = "SELECT * from admin where ADMIN_ID = '$sesscustid'";
	}
	else if (substr($sesscustid,0,1)== "Q")
	{
		header('Location: index.php');
	}
	$result_user = mysqli_query($conn, $sql_user);
	$row		 = mysqli_fetch_assoc($result_user);
}
else
{
	header('Location: index.php');
}


if (isset($_GET['brn_id']))
{
	$brnid		  = $_GET['brn_id'];
	$sql_brn	  = "SELECT * from branch where BRANCH_ID = '$brnid'";
	$result_brn	  = mysqli_query($conn, $sql_brn);
	$row2		  = mysqli_fetch_assoc($result_brn);
	$brnstate	  = $row2['BRANCH_ADDR_STATE'];
	
	if($brnstate=='W')
	{
		$state = "Kuala Lumpur";
	}
	else if($brnstate=='J')
	{
		$state = "Johor";
	}
	else if($brnstate=='K')
	{
		$state = "Kedah";
	}
	else if($brnstate=='D')
	{
		$state = "Kelantan";
	}
	else if($brnstate=='M')
	{
		$state = "Malacca";
	}
	else if($brnstate=='N')
	{
		$state = "Negeri Sembilan";
	}
	else if($brnstate=='C')
	{
		$state = "Pahang";
	}
	else if($brnstate=='A')
	{
		$state = "Perak";
	}
	else if($brnstate=='R')
	{
		$state = "Perlis";
	}
	else if($brnstate=='P')
	{
		$state = "Penang";
	}
	else if($brnstate=='B')
	{
		$state = "Selangor";
	}
	else if($brnstate=='T')
	{
		$state = "Terengganu";
	}
}
else
{
	header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>View Branch Detail | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/addbranch.css" rel="stylesheet" type="text/css">
		
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
							<p>View Branch Detail</p>
							<hr/>
						</div>
						<div id="newprofilefrm">
							<form name="myprofile" action="" method="post" onsubmit="return validate();">
								<table>
									<tr>
										<td width="150px">Branch's ID</td>
										<td>
											<input type="text" name="branch_id" value="<?php echo $row2['BRANCH_ID'];?>" readonly class="readonly"/>
										</td>
									</tr>
									<tr>
										<td width="150px">Branch Name</td>
										<td>
											<input type="text" name="branch_name" value="<?php echo $row2['BRANCH_NAME'];?>" readonly class="readonly">
										</td>									
									</tr>
									<tr>
										<td width="150px">Branch Address</td>
										<td><input type="text" name="branch_addr_no" value="<?php echo $row2['BRANCH_ADDR_STREET'];?>" placeholder="No.99, Jalan XXX, Taman XXX" readonly class="readonly" style="width:450px;"/><small> (Street)</small></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="branch_addr_city" value="<?php echo $row2['BRANCH_ADDR_CITY'];?>" placeholder="Port Dickson" style="width:300px;" readonly class="readonly"/><small> (City)</small></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="branch_addr_state" value="<?php echo $state;?>" style="width:300px;" readonly class="readonly"><small> (State)</small>	
										</td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="branch_addr_postcode" value="<?php echo $row2['BRANCH_ADDR_POST'];?>" placeholder="71010" style="width:300px;" readonly class="readonly"/><small> (Postcode)</small>
										</td>										
									</tr>
									<tr>
										<td>Contact Number</td>
										<td>
											<input type="text" name="branch_phone" value="<?php echo $row2['BRANCH_PHONE'];?>" placeholder="Branch's contact number" readonly class="readonly"/>
										</td>
									</tr>
								</table>
								<div id="newprofile-btn">
									<input type="submit" name="backbtn" value="Back"/>
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

<?php
if(isset($_POST['backbtn']))
{
	header("Location:view_branch.php");
}
?>