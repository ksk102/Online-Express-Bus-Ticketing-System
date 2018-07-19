<?php 

require 'Database/db_con.php';

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>BusForAll.com | Book Your Book Ticket Online Now!</title>
		
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css"/>
		<link href="css-folder/index-design.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" type="text/css" href="creativebuttons/css/component.css" />
	</head>
	
	<body>
		<div id="container">
			<?php
				include 'include/header.php';
			?>
			<div id="content">
				<?php include 'include/slider.php'; ?>
				<div id="main-content">
					<div id="content-right">
						<div id="content-right-announcement">
							<section class="color-1">
								<?php
								if(!isset($_SESSION['login_user']))
								{
								?>
									<p>
										<a href="view_announcement.php" target="_self"><button class="btn btn-4 btn-4a icon-arrow-right" style="font-family:Arial;">Announcement</button></a>
									</p>
								<?php
								}
								else if (substr($userid,0,1)== "C")
								{
								?>
									<p>
										<a href="user_view_announcement.php" target="_self"><button class="btn btn-4 btn-4a icon-arrow-right" style="font-family:Arial;">Announcement</button></a>
									</p>
								<?php
								}
								else if (substr($userid,0,1)== "S")
								{
								?>
									<p>
										<a href="staff_view_announcement.php" target="_self"><button class="btn btn-4 btn-4a icon-arrow-right" style="font-family:Arial;">Announcement</button></a>
									</p>
								<?php
								}
								else if (substr($userid,0,1)== "A")
								{
								?>
									<p>
										<a href="admin_view_announcement.php" target="_self"><button class="btn btn-4 btn-4a icon-arrow-right" style="font-family:Arial;">Announcement</button></a>
									</p>
								<?php
								}
								else if (substr($userid,0,1)== "Q")
								{
								?>
									<p>
										<a href="view_announcement.php" target="_self"><button class="btn btn-4 btn-4a icon-arrow-right" style="font-family:Arial;">Announcement</button></a>
									</p>
								<?php
								}
								?>
							</section>
								<?php
								if(!isset($_SESSION['login_user']))
								{
								?>
									<div id="content-right-announcement-content-wrapper">
									<?php 
										$announcement_table = "SELECT * from announcement ORDER BY ANNID DESC limit 5";
										$sql_announcement   = mysqli_query($conn, $announcement_table);
										
										while($row=mysqli_fetch_assoc($sql_announcement))
										{
											?>
											<div id="content-right-announcement-content-wrapper2">
												<div id="content-right-announcement-content">
													<p><?php echo "<a href=\"view_announcement_detail.php?ann_id={$row['ANN_ID']}\">{$row['ANN_TITLE']}</a>";?></p>		
												</div>
												<div id="content-right-announcement-by">
													<small><?php echo $row["ANN_DATE"];?> | <?php echo $row["COMP_ID"];?> Admin</small>
												</div>
											</div>
											<?php
										}
									?>
								</div>
								<?php
								}
								else if (substr($userid,0,1)== "C")
								{
								?>
								<div id="content-right-announcement-content-wrapper">
									<?php 
										$announcement_table = "SELECT * from announcement ORDER BY ANNID DESC limit 5";
										$sql_announcement   = mysqli_query($conn, $announcement_table);
										
										while($row=mysqli_fetch_assoc($sql_announcement))
										{
											?>
											<div id="content-right-announcement-content-wrapper2">
												<div id="content-right-announcement-content">
													<p><?php echo "<a href=\"user_view_announcement_detail.php?ann_id={$row['ANN_ID']}\">{$row['ANN_TITLE']}</a>";?></p>		
												</div>
												<div id="content-right-announcement-by">
													<small><?php echo $row["ANN_DATE"];?> | <?php echo $row["COMP_ID"];?> Admin</small>
												</div>
											</div>
											<?php
										}
									?>
								</div>
								<?php
								}
								else if (substr($userid,0,1)== "S")
								{
								?>
								<div id="content-right-announcement-content-wrapper">
									<?php 
										$announcement_table = "SELECT * from announcement ORDER BY ANNID DESC limit 5";
										$sql_announcement   = mysqli_query($conn, $announcement_table);
										
										while($row=mysqli_fetch_assoc($sql_announcement))
										{
											?>
											<div id="content-right-announcement-content-wrapper2">
												<div id="content-right-announcement-content">
													<p><?php echo "<a href=\"staff_view_announcement_detail.php?ann_id={$row['ANN_ID']}\">{$row['ANN_TITLE']}</a>";?></p>		
												</div>
												<div id="content-right-announcement-by">
													<small><?php echo $row["ANN_DATE"];?> | <?php echo $row["COMP_ID"];?> Admin</small>
												</div>
											</div>
											<?php
										}
									?>
								</div>
								<?php
								}
								else if (substr($userid,0,1)== "A")
								{
								?>
								<div id="content-right-announcement-content-wrapper">
									<?php 
										$announcement_table = "SELECT * from announcement ORDER BY ANNID DESC limit 5";
										$sql_announcement   = mysqli_query($conn, $announcement_table);
										
										while($row=mysqli_fetch_assoc($sql_announcement))
										{
											?>
											<div id="content-right-announcement-content-wrapper2">
												<div id="content-right-announcement-content">
													<p><?php echo "<a href=\"admin_view_announcement_detail.php?ann_id={$row['ANN_ID']}\">{$row['ANN_TITLE']}</a>";?></p>		
												</div>
												<div id="content-right-announcement-by">
													<small><?php echo $row["ANN_DATE"];?> | <?php echo $row["COMP_ID"];?> Admin</small>
												</div>
											</div>
											<?php
										}
									?>
								</div>
								<?php
								}
								else if (substr($userid,0,1)== "Q")
								{
									?>
									<div id="content-right-announcement-content-wrapper">
									<?php 
									$announcement_table = "SELECT * from announcement ORDER BY ANNID DESC limit 5";
									$sql_announcement   = mysqli_query($conn, $announcement_table);
									
									while($row=mysqli_fetch_assoc($sql_announcement))
									{
										?>
										<div id="content-right-announcement-content-wrapper2">
											<div id="content-right-announcement-content">
												<p><?php echo "<a href=\"view_announcement_detail.php?ann_id={$row['ANN_ID']}\">{$row['ANN_TITLE']}</a>";?></p>		
											</div>
											<div id="content-right-announcement-by">
												<small><?php echo $row["ANN_DATE"];?> | <?php echo $row["COMP_ID"];?> Admin</small>
											</div>
										</div>
										<?php
									}
									?>
									</div>
									<?php
								}
								?>
						</div>
					</div>
					<?php include 'include/searchticket.php'; ?>
				</div>
			</div>
			<?php include 'include/btmnavi.php'; ?>
		</div>
	</body>
</html>
