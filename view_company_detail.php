<?php 

require 'database/db_con.php';

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
		$comp_id 	 = $row['COMP_ID'];
}
else
{
	header('Location: index.php');
}
	
//Select from company
$company_table  = "SELECT * from company where COMP_ID='$comp_id'";
$result_company = mysqli_query($conn, $company_table);
$row2			= mysqli_fetch_assoc($result_company);

//If no data found redirect to add company detail page
if($row2 <1)
{
	header("Location: add_company_detail.php");
}
//END: If no data found redirect to add company detail page

$comp_street	= $row2['COMP_ADDR_STREET'];
$comp_city		= $row2['COMP_ADDR_CITY'];
$comp_state		= $row2['COMP_ADDR_STATE'];
$comp_post		= $row2['COMP_ADDR_POST'];

$comp_fulladdr  = $comp_street.', '.$comp_city.', '.$comp_state.', '.$comp_post;
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Company Detail | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css"/>
		<link href="css-folder/companydetail.css" rel="stylesheet" type="text/css"/>
		
		<script src="js-folder/index.js" type="text/javascript"></script>
	</head>
	
	<body>
	<div id="container">
			<?php
				include 'include/header.php';
			?>
			
			<div id="content">
				<div id="content-wrapper">
					<?php include 'include/leftnavi.php'; ?>
						<div id="content-right">
							<div id="content-right-companydetail">
								<div id="content-right-companydetail-title">
									<p><?php echo $row2['COMP_NAME'];?></p>
								</div>
									<div id="content-right-companydetail-content-wrapper">
										<div id="content-right-companydetail-content-wrapper2">
											<div id="company-pic">
												<?php
													echo '<img height="250" width="450" src="data:image;base64,'.$row2['COMP_IMG'].' "> ';
												?>
												</div>
											
											<p><?php echo $row2['COMP_DETAIL'];?></p>
											<div id="company-detail2">
												<div id="company-location">
													<img src="images/icon/aboutoperator/location.png" alt=""/><?php echo $comp_fulladdr;?>
												</div>
												<div id="company-phone">
													<img src="images/icon/aboutoperator/19-256.png" alt=""/><?php echo $row2['COMP_PHONE'];?>
												</div>
												<div id="company-email">
													<img src="images/icon/aboutoperator/Email-icon.png" alt=""/><?php echo $row2['COMP_EMAIL'];?>
												</div>
												<?php
												
												if (substr($sesscustid,0,1)== "A")
												{
													?>
													<div id="editcompany-btn">
														<a href="edit_company_detail.php"><input type="button" name="editbtn" value="Edit"/></a>
													</div>
													<?php
												}
												?>					
											</div>
										</div>
									</div>
							<!--content-right-companydetail closing div-->
							</div>
					  <!--content-right closing div-->
					  </div>
              </div>
				<?php include 'include/btmnavi.php'; ?>
			</div>
	</body>
</html>