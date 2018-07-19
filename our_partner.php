<?php 

require 'Database/db_con.php';

$comp_table  = "SELECT * from company";
$result_comp = mysqli_query($conn, $comp_table);
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Our Partner | BusForAll.com</title>
		
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css"/>
		<link href="css-folder/our_partner.css" rel="stylesheet" type="text/css"/>
		
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
                	<div id="content-right-op">
                	<div id="content-right-op-title">
                	<p>Our Partner</p>
                    </div>
                    	<div id="content-right-op-content-wrapper">
							<?php 
								while($row = mysqli_fetch_assoc($result_comp))
								{
									?>
									<div id="content-right-op-content-wrapper2">
									<table style="border-left: #cccccc 1px solid; border-right:#cccccc 1px solid" cellspacing="0" cellpadding="0">
										<tr>
											<td colspan="2" height="120" width="160" style="border-left:0px;">
												<?php
													echo '<img height="125" width="250" src="data:image;base64,'.$row['COMP_IMG'].' "> ';
												?>
											</td>
											<td width="600" style="border-left:#cccccc 1px solid; padding-left:35px">
											<div id="opname">
												<div id="op">
													<?php echo "<a href=\"company_detail.php?comp_id={$row['COMP_ID']}\">{$row['COMP_NAME']}</a>";?></a>
												</div>
												<p><?php echo 'Phone:' .$row['COMP_PHONE'];?></p>
												<p><?php echo 'Email:' .$row['COMP_EMAIL'];?></p>
											</div>
											</td>
										</tr>
									 </table>
								</div>
								<?php
								}
							?>
						</div>
						<div id="content-right-op-all">
							<div id="content-right-op-viewall">
									<p><a href="#">View All</a></p>
							</div>
						</div>
                    <!--content-right-our-partner closing div-->
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