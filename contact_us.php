<?php 
require 'Database/db_con.php'; 
if(isset($_SESSION['sess_uid']))
{
	$sesscustid  = $_SESSION["sess_uid"];
	if(substr($sesscustid,0,1)== "C")
	{
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
		$result_user = mysqli_query($conn, $sql_user);
		$row		 = mysqli_fetch_assoc($result_user);
}
	?>

<!DOCTYPE html>
<html>
	<head>
		<title>Contact Us | BusForAll.com</title>
		
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css"/>

		<link href="css-folder/delimaexpress.css" rel="stylesheet" type="text/css"/>
		<link href="css-folder/about_us.css" rel="stylesheet" type="text/css"/>			
		
		<script src="js-folder/index.js" type="text/javascript"></script>
		
		<!-- Start WOWSlider.com HEAD section --> <!-- add to the <head> of your page -->
		<link rel="stylesheet" type="text/css" href="engine0/style.css" />
	<script type="text/javascript" src="engine0/jquery.js"></script><!-- End WOWSlider.com HEAD section -->
	</head>
	
	<body>
		<div id="container">
			<?php
				include 'include/header.php';
			?>
			
			<div id="content">
				<?php include 'include/slider.php'; ?>
				
			<div id="content-wrapper">
					
				<?php include 'include/searchticket.php'; ?>
				<div id="content-right">
					<div id="content-right-op">
                	<div id="content-right-op-title">
                	<p>Contact Us</p>
                    </div>
                    	<div id="content-right-op-content-wrapper">
                        	<div id="content-right-op-content-wrapper2">
                            	<table style="border-left: #cccccc 1px solid; border-right:#cccccc 1px solid" cellspacing="0" cellpadding="0">
									<iframe width="670" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com.my/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Melaka+Sentral&amp;aq=&amp;s11=2.2212,102.250057&amp;sspn=2.2212,102.250057&amp;ie=UTF8&amp;hq=&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe><br /><small>

							<div id="delima-detail2">
								<div id="delima-location">
									<img src="images/icon/aboutoperator/location.png" alt=""/>Melaka Sentral Bus Terminal, R1, Jalan Tun Razak, Plaza Melaka Sentral, 75400 Melaka, Malaysia.
								</div>			
								<div id="delima-phone">	
									<img src="images/icon/aboutoperator/19-256.png" alt=""/>+606 283 9333
								</div>
								<div id="fax">
									<img src="images/icon/aboutoperator/fax.png" alt=""/>+606 283 8888
								</div>
								<div id="delima-email">					
									<img src="images/icon/aboutoperator/Email-icon.png" alt=""/>helpdesk@busforall.my
								</div>
								<div id="clock">					
									<img src="images/icon/aboutoperator/clock.png" alt=""/>Our lines are open from: 9.00am to 7.00pm (Every day) excluding public holidays.
								</div>
								</table>

							</div>
							</div>
						</div>
					</div>
				<!--content-right closing div-->
                </div>
				
            </div>
			<?php include 'include/btmnavi.php'; ?>
		</div>
	</body>
</html>