<?php 

require 'Database/db_con.php';

if(isset($_SESSION['sess_uid']))
	{
		$sesscustid  = $_SESSION["sess_uid"];
		if(substr($sesscustid,0,1)== "C")
		{
			header('Location: user_profile.php');
		}
		else if (substr($sesscustid,0,1)== "S")
		{
			header('Location: staff_profile.php');
		}
		else if (substr($sesscustid,0,1)== "Q")
		{
			header('Location: index.php');
		}
		else if (substr($sesscustid,0,1)== "A")
		{
			$sessadmid  = $_SESSION["sess_uid"];

			$sql_user 	 = "SELECT * from admin where ADMIN_ID = '$sessadmid'";
			$result_user = mysqli_query($conn, $sql_user);
			$row		 = mysqli_fetch_assoc($result_user);
		}
	}
	else
	{
		header('Location: index.php');
	}

if (isset($_GET['ann_id']))
{
	$ann_id	 	= $_GET['ann_id'];
	$sql_ann    = "SELECT * from announcement where ANN_ID = '$ann_id'";
	$result_ann = mysqli_query($conn, $sql_ann);
	$row2		= mysqli_fetch_assoc($result_ann);
}

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>View Announcement | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/viewannouncementdetail.css" rel="stylesheet" type="text/css">
		<link href="css-folder/filter.css" rel="stylesheet" type="text/css">
	</head>

	<body>
    	<div id="container">
			<?php
				include 'include/header.php';
			?>
			
			<div id="content">
				<div id="content-wrapper">
					<?php include 'include/leftnavi.php'; ?>
					<div id="viewannouncement-wrapper">
						<div id="viewannouncement-wrapper-title">
							<p>View Announcement Detail</p>
						</div>
						
						<hr/>
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
										<td valign="top"><b><?php echo $row2['ANN_DETAIL'];?></b></td>
									</tr>
								</table>
								<div id="newannounce-btn">
									<input type="submit" name="editbtn" value="Edit">
									<input type="submit" name="deletebtn" value="Delete">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		
			<?php include 'include/btmnavi.php'; ?>
		</div>
		<?php include 'include/popup_jq.php'; ?>
	</body>
</html>

<?php
if(isset($_POST['editbtn']))
{
	$adminid = $row2['ADMIN_ID'];
	
	if($adminid == $sessadmid)
	{
		$_SESSION['sess_annid'] = $row2['ANN_ID'];
		header("Location: admin_edit_announcement.php");
	}
	else
	{
		?>
		<script>
		alert("Only the poster can edit this announcement")
		</script>
		<?php
	}
}
if(isset($_POST['deletebtn']))
{
	$adminid = $row2['ADMIN_ID'];
	$annid	 = $row2['ANN_ID'];
	
	if($adminid == $sessadmid)
	{
		$delete_sql   	= "DELETE FROM announcement WHERE ANN_ID='$annid'";
		mysqli_query($conn, $delete_sql);
		header("Location: admin_view_announcement.php");
		?>
		<script>
		alert("Anouncement successfully deleted");
		</script>
		<?php
	}
	else
	{
		?>
		<script>
		alert("Only the poster can delete this announcement");
		</script>
		<?php
	}
}

?>
