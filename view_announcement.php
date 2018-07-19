<?php 
require 'database/db_con.php'; 

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Book Bus Ticket | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/viewannouncement_nlogin.css" rel="stylesheet" type="text/css">
	
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
						<table width="1010px">
								<tr>
									<th height="40px" width="140px">Announcement ID</th>
									<th width="120px">Date</th>
									<th width="120px">Time</th>
									<th width="150px">Expiry</th>
									<th width="450px">Title</th>
								</tr>
								<?php
								
								$per_page=10;
								if (isset($_GET["page"])) {

								$page = $_GET["page"];

								}

								else {

								$page=1;

								}

								// Page will start from 0 and Multiple by Per Page
								$start_from = ($page-1) * $per_page;
								
								//Selecting the data from table but with limit
								$announcement_table = "SELECT * from announcement limit $start_from,$per_page";
								$sql_announcement 	= mysqli_query($conn, $announcement_table);
								
								while($row=mysqli_fetch_assoc($sql_announcement))
								{
									?>
									<tr>
										<td><?php echo "<a href=\"view_announcement_detail.php?ann_id={$row['ANN_ID']}\">{$row['ANN_ID']}</a>";?></td>
										<td height="40px"><?php echo $row["ANN_DATE"];?></td>
										<td><?php echo $row["ANN_TIME"];?></td>
										<td><?php echo $row["ANN_EXPIRY"];?></td>
										<td><?php echo $row["ANN_TITLE"];?></td>
									</tr>
									<?php
								}
								?>
							</table>
							<div id="page-selection">
								<?php
										//Now select all from table
										$query = "select * from announcement";
										$result = mysqli_query($conn, $query);

										// Count the total records
										$total_records = mysqli_num_rows($result);

										//Using ceil function to divide the total records on per page
										$total_pages = ceil($total_records / $per_page);
										
										?>
										<ul>
										<?php
										//Going to first page
										echo "<li style='width:80px;'><a href='view_announcement.php?page=1'>".'First Page'."</a></li> ";

										for ($i=1; $i<=$total_pages; $i++) {

										echo "<li><a href='view_announcement.php?page=".$i."'>".$i."</a></li> ";
										};
										// Going to last page
										echo "<li style='width:80px;'><a href='view_announcement.php?page=$total_pages'>".'Last Page'."</a></li> ";
										?>
										</ul>
							</div>
					</div>
				</div>
			</div>
		
			<?php include 'include/btmnavi.php'; ?>
		</div>
		<script src="popup/js/index.js"></script>
	</body>
</html>
