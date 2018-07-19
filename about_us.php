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
		<title>About Us | BusForAll.com</title>
		
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css"/>
		<link href="css-folder/bottom navigation.css" rel="stylesheet" type="text/css"/>
		<link href="css-folder/header.css" rel="stylesheet" type="text/css"/>
		<link href="css-folder/faq.css" rel="stylesheet" type="text/css"/>
		<link href="css-folder/delimaexpress.css" rel="stylesheet" type="text/css"/>
		<link href="css-folder/about_us.css" rel="stylesheet" type="text/css"/>		
		
		<script src="js-folder/index.js" type="text/javascript"></script>
		
		<!-- Start WOWSlider.com HEAD section --> <!-- add to the <head> of your page -->
		<link rel="stylesheet" type="text/css" href="engine0/style.css" />
	<script type="text/javascript" src="engine0/jquery.js"></script><!-- End WOWSlider.com HEAD section -->
	</head>
	<style>
	#content-right
	{
    background-image: url(images/background.png);
    background-position: 110px 80px;
    background-repeat: no-repeat, repeat;
	-webkit-background-size: 500px 500px;
	}
	</style>
	<body>
		<div id="container">
			<?php
				include 'include/header.php';
			?>
			
			<div id="content">
				<?php include 'include/slider.php'; ?>
				
			<div id="content-wrapper">
					

				<div id="content-right">
					<div id="content-right-op">
                	<div id="content-right-op-title">
                	<p>About Us</p>
                    </div>
                    	<div id="content-right-op-content-wrapper">
                        	<div id="content-right-op-content-wrapper2">
                            	<table style="border-left: #cccccc 1px solid; border-right:#cccccc 1px solid" cellspacing="0" cellpadding="0">
					<p>Since Our company start in 18 Ogos 2015, BusForAll Sdn. Bhd. has been dedicating express coach services to passengers. BusForAll Sdn. Bhd. is a fast growing express coach company. 
					In the beginning, we have only double seats of 44-passenger express bus and a few units of factory buses, now we become one of the newest leading and largest companies of public bus transportation in Malaysia.
					BusForAll provides safe, enjoyable and affordable travel. </p>
					
					<p>BusForAll Sdn. Bhd. had hire experienced and well-trained drivers in order to provide our passengers with the safest and most comfortable journey which connects to main cities and channels them to their destinations.
					Besides that, in meeting up to our customers's demands, our top management team has also been serving to its very best by providing our customers service of top quality.</p>
					
					<p>BusForAll Sdn. Bhd. provides a comprehensive range of route services in Malaysia, serving more than 200 destinations, covering all major cities and towns with 1,000 daily departures across Peninsular Malaysia.</p>
					
					<p>Causes of that we are new industry, we are confident to continuously provide you the most reliable and best quality service for all your needs during your journey. 
					Hence, we would constantly improve ourselves to reciprocate the support of our dear customers.</p>
					
					<p>With so much to offer under one brand name, <b>BusForAll</b> is certainly your <b>preferred choice</b>!</p>
								</table>
							</div>
						</div>
				<!--content-right closing div-->
					</div>
				</div>
				<?php include 'include/searchticket.php'; ?>
            </div>
			<?php include 'include/btmnavi.php'; ?>
		</div>
	</body>
</html>