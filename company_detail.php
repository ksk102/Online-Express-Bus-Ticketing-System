<?php 

require 'Database/db_con.php';

if (isset($_GET['comp_id']))
{
	$comp_id	 	= $_GET['comp_id'];
	$sql_comp    = "SELECT * from company where COMP_ID = '$comp_id'";
	$result_comp = mysqli_query($conn, $sql_comp);
	$row		 = mysqli_fetch_assoc($result_comp);
	
	if($row < 1)
	{
		header('Location: index.php');
	}
	
	$comp_street	= $row['COMP_ADDR_STREET'];
	$comp_city		= $row['COMP_ADDR_CITY'];
	$comp_state		= $row['COMP_ADDR_STATE'];
	$comp_post		= $row['COMP_ADDR_POST'];

	$comp_fulladdr  = $comp_street.', '.$comp_city.', '.$comp_state.', '.$comp_post;
}
else
{
	header('Location: index.php');
}

$comp_street	= $row['COMP_ADDR_STREET'];
$comp_city		= $row['COMP_ADDR_CITY'];
$comp_state		= $row['COMP_ADDR_STATE'];
$comp_post		= $row['COMP_ADDR_POST'];

$comp_fulladdr  = $comp_street.', '.$comp_city.', '.$comp_state.', '.$comp_post;
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title><?php echo $row['COMP_NAME'];?> | BusForAll.com</title>
		
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css"/>
		<link href="css-folder/delimaexpress.css" rel="stylesheet" type="text/css"/>
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
				
				<div id="content-right">
                	<div id="content-right-delimadetail">
                	<div id="content-right-delimadetail-title">
                	<p><?php echo $row['COMP_NAME'];?></p>
                    </div>
                    	<div id="content-right-delimadetail-content-wrapper">
                        	<div id="content-right-delimadetail-content-wrapper2">
                            	<div id="delima-pic">
                                	<?php
											echo '<img height="140" width="200" src="data:image;base64,'.$row['COMP_IMG'].' "> ';
										?>
                                </div>
                                
                                <p><?php echo $row['COMP_DETAIL'];?></p>
								<div id="delima-detail2">
                                	<div id="delima-location">
                                		<img src="images/icon/aboutoperator/location.png" alt=""/><?php echo $comp_fulladdr;?>
                                    </div>
                                	<div id="delima-phone">
                                		<img src="images/icon/aboutoperator/19-256.png" alt=""/><?php echo $row['COMP_PHONE'];?>
                                    </div>
                                	<div id="delima-email">
                                		<img src="images/icon/aboutoperator/Email-icon.png" alt=""/><?php echo $row['COMP_EMAIL'];?>
                                    </div>
                            	</div>
                            
							</div>
                        </div>
                    <!--content-right-delimadetail closing div-->
                    </div>
                <!--content-right closing div-->
                </div>
				<?php include 'include/searchticket.php'; ?>
                </div>
			
			</div>
			<?php include 'include/btmnavi.php'; ?>
		</div>
</body>
</html>