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
$result_user  = mysqli_query($conn, $sql_user);
$row		  = mysqli_fetch_assoc($result_user);
$compid 	  = $row['COMP_ID'];

if (isset($_GET['s_id']))
{
	$staffid = $_GET['s_id'];
}
else
{
	header('Location:view_staff_detail.php');
}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>View Schedules | BusForAll.com</title>
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
							<p>Filtered Staff</p>
						</div>
						<hr/>
						<div id="viewschedule-table">
							<table width="740px">
								<tr>
									<th height="40px">Staff's ID</th>
									<th>Email</th>
									<th>Name</th>
									<th>Contact Number</th>
									<th>Branch's ID</th>
									<th>Edit</th>
									<th>Delete</th>
								</tr>
								
								<?php
								//Selecting the data from table but with limit
								$staff_table = "SELECT * from staff where BRANCH_ID='$staffid' && COMP_ID='$compid'";
								$sql_staff	 = mysqli_query($conn, $staff_table);
								//echo $schid;
								
								while($row2 = mysqli_fetch_assoc($sql_staff))
								{
									?>
									<tr>
										<td><?php echo "<a href=\"admin_view_staff_detail.php?staff_id={$row2['STAFF_ID']}\">{$row2['STAFF_ID']}</a>";?></td>
										<td><?php echo $row2["STAFF_EMAIL"];?></td>
										<td><?php echo $row2["STAFF_NAME"];?></td>
										<td><?php echo $row2["STAFF_PHONE"];?></td>
										<td><?php echo $row2["BRANCH_ID"];?></td>
											<?php
										if (substr($sesscustid,0,1)== "A")
										{
											?>
											<td><?php echo "<a href=\"admin_edit_staff_detail.php?staff_id={$row2['STAFF_ID']}\"><img src='images/icon/signedin/edit.png' width='25px' height='30px'></a>";?></td>
											<td><?php echo "<a href=filter_staff.php?staff_id=".$row2['STAFF_ID']." onclick='return confirmation();'><img src='images/icon/signedin/delete.png' width='25px' height='30px'></a>";?></td>
											<?php
										}
										?>
									</tr>
									<?php
								}
								?>
							</table>
							
							<div id="viewschedule-btn">
								<a href="view_staff_detail.php"><input type="submit" name="addbtn" value="Back"></a>
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

