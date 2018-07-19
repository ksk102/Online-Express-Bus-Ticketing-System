<?php 

require 'Database/db_con.php';

	if(isset($_SESSION['sess_uid']))
	{
		$sesscustid  = $_SESSION["sess_uid"];
		if (substr($sesscustid,0,1)== "Q")
		{
			header('Location: index.php');
		}
	}
	else
	{
		header('Location: index.php');
	}

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
$result_user  = mysqli_query($conn, $sql_user);
$row		  = mysqli_fetch_assoc($result_user);

if(substr($sesscustid,0,1)== "S" || substr($sesscustid,0,1)== "A")
{
	$compid 	  = $row['COMP_ID'];
}
	
if (isset($_GET['a_id']))
{
	$annid = $_GET['a_id'];
	//echo $schid;
}
else
{
	header('Location:view_announcement.php');
}
//echo $admin_compid;
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>View Announcement | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/viewschedule.css" rel="stylesheet" type="text/css">
		<link href="css-folder/filter.css" rel="stylesheet" type="text/css">
		
		<script type="text/javascript">
		function confirmation()
		{
			answer = confirm("Want to delete this record?");
			return answer;
		}
		</script>
	</head>

	<body>
    	<div id="container">
			<?php
				include 'include/header.php';
			?>
        
			<div id="content">
				<div id="content-wrapper">
					<?php include 'include/leftnavi.php'; ?>
					<div id="viewschedule-wrapper">
						<div id="viewschedule-wrapper-title">
							<p>Filtered Announcement</p>
						</div>
						<hr/>
						<div id="viewschedule-table">
							<table width="740px">
								<tr>
									<th height="40px">Announcement ID</th>
									<th width="100px">Date</th>
									<th width="100px">Time</th>
									<th width="130px">Expiry</th>
									<th>Title</th>
								</tr>
								
								<?php
								if(substr($sesscustid,0,1)== "S" || substr($sesscustid,0,1)== "A")
								{
									//Selecting the data from table but with limit
									$ann_table	= "SELECT * from announcement where ANN_DATE='$annid'";
									$sql_ann	= mysqli_query($conn, $ann_table);
									//echo $schid;
								}
								else
								{
									$ann_table	= "SELECT * from announcement where ANN_DATE='$annid'";
									$sql_ann	= mysqli_query($conn, $ann_table);
								}
								
								while($row2		= mysqli_fetch_assoc($sql_ann))
								{
									?>
									<tr>
										<?php
										if (substr($sesscustid,0,1)== "A")
										{
											?>
											<td><?php echo "<a href=\"admin_view_announcement_detail.php?ann_id={$row2['ANN_ID']}\">{$row2['ANN_ID']}</a>";?></td>
											<?php
										}
										else if (substr($sesscustid,0,1)== "S")
										{
											?>
											<td><?php echo "<a href=\"staff_view_announcement_detail.php?ann_id={$row2['ANN_ID']}\">{$row2['ANN_ID']}</a>";?></td>
											<?php
										}
										else
										{
											?>
											<td><?php echo "<a href=\"user_view_announcement_detail.php?ann_id={$row2['ANN_ID']}\">{$row2['ANN_ID']}</a>";?></td>
											<?php
										}
										?>
										<td><?php echo $row2["ANN_DATE"];?></td>
										<td><?php echo $row2["ANN_TIME"];?></td>
										<td><?php echo $row2["ANN_EXPIRY"];?></td>
										<td><?php echo $row2["ANN_TITLE"];?></td>
									</tr>
									<?php
								}
								?>
							</table>
							
							<div id="viewschedule-btn">
							<?php
								if (substr($sesscustid,0,1)== "A")
								{
									?>
									<a href="admin_view_announcement.php"><input type="submit" name="addbtn" value="Back"></a>
									<?php
								}
								if (substr($sesscustid,0,1)== "S")
								{
									?>
									<a href="staff_view_announcement.php"><input type="submit" name="addbtn" value="Back"></a>
									<?php
								}
								?>
							</div>
						</div>  
					</div>
				</div>
			</div>
			<?php include 'include/btmnavi.php'; ?>
		</div>
		<?php include 'include/popup_jq.php'; ?>
	</body>
</html>