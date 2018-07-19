<?php 
require 'database/db_con.php'; 

if (isset($_GET['ann_id']))
{
	$ann_id	 	= $_GET['ann_id'];
	$sql_ann    = "SELECT * from announcement where ANN_ID = '$ann_id'";
	$result_ann = mysqli_query($conn, $sql_ann);
	$row2		= mysqli_fetch_assoc($result_ann);
}
else
{
	header("Location:view_announcement.php");
}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Book Bus Ticket | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/viewannouncementdetail_nlogin.css" rel="stylesheet" type="text/css">
	
	</head>

	<body>
    	<div id="container">
			<?php
				include 'include/header.php';
			?>
        
			<div id="content">
				<div id="search_table">
					<div id="search-table-title">
						<p>View Announcement</p>
						<hr/>
					</div>
										
					<div id="viewannouncement-table">
						<form name="addnewannounce" action="" method="post">
							<table>
								<tr>
									<td valign="top" width="150px">Announcement ID</td>
									<td valign="top"><b><?php echo $row2["ANN_ID"];?></b></td>
								</tr>
								<tr>
									<td valign="top" class="alignright" width="150px">Date</td>
									<td valign="top"><b><?php echo $row2['ANN_DATE'];?></b></td>
								</tr>
								<tr>
									<td valign="top">Time</td>
									<td valign="top"><b><?php echo $row2['ANN_TIME'];?></b></td>
								</tr>
								<tr>
									<td valign="top" width="150px">Expiry Date</td>
									<td valign="top"><b><?php echo date('Y-m-d', strtotime($row2["ANN_EXPIRY"]));?></b></td>
								</tr>
								<tr>
									<td valign="top">Title</td>
									<td valign="top"><b><?php echo $row2['ANN_TITLE'];?></b></td>
								</tr>
								<tr>
									<td valign="top">Content</td>
									<td valign="top"><?php echo $row2['ANN_DETAIL'];?></td>
								</tr>
							</table>
							<div id="newannounce-btn">
								<input type="submit" name="backbtn" value="Back">
							</div>
						</form>
					</div>
				</div>
			</div>
		
			<?php include 'include/btmnavi.php'; ?>
		</div>
		<script src="popup/js/index.js"></script>
	</body>
</html>

<?php
if(isset($_POST['backbtn']))
{
	header("Location:view_announcement.php");
}
?>
