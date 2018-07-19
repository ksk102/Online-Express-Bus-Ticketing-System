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
	$schid	 		= $_GET['s_id'];
	//echo $schid;
}
else
{
	header('Location:view_route.php');
}
//echo $admin_compid;
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>View Route | BusForAll.com</title>
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
							<p>Filtered Route</p>
						</div>
						<hr/>
						<div id="viewschedule-table">
							<table width="740px">
								<tr>
									<th height="40px">Route ID</th>
									<th>Route Date</th>
									<th width="130px">Route Platform</th>
									<th width="130px">Reserved Seats</th>
									<th>Bus VRN</th>
									<th width="50px">Edit</th>
									<th width="50px">Delete</th>
								</tr>
								
								<?php
								$schedule_table	= "SELECT * from route where ROU_DATE='$schid' && COMP_ID='$compid' && ROU_STATUS='0' limit 14";
								$sql_schedule	= mysqli_query($conn, $schedule_table);
								while($row2		= mysqli_fetch_assoc($sql_schedule))
								{
									?>
									<tr>
											<td><?php echo "<a href=\"view_route_detail.php?rou_id={$row2['ROU_ID']}\">{$row2['ROU_ID']}</a>";?></td>
											<td><?php echo $row2["ROU_DATE"];?></td>
											<td><?php echo $row2["ROU_PLATFORM"];?></td>
											<td><?php echo $row2["ROU_RSEAT"];?></td>
											<td><?php echo $row2["BUS_VRN"];?></td>
											<td><?php echo "<a href=\"edit_route.php?rou_id={$row2['ROU_ID']}\"><img src='images/icon/signedin/edit.png' width='25px' height='30px'></a>";?></td>
											<td><?php echo "<a href=filter_route.php?rou_id=".$row2['ROU_ID']." onclick='return confirmation();'><img src='images/icon/signedin/delete.png' width='25px' height='30px'></a>";?></td>
									</tr>
									<?php
								}
								?>
							</table>
							
							<div id="viewschedule-btn">
								<a href="view_route.php"><input type="submit" name="addbtn" value="Back"></a>
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
if (isset($_REQUEST["rou_id"]))
{
	//Schedule status
	//0 = Active
	//1 = Inactive
	
	$rouid2       = $_REQUEST["rou_id"];
	$rou_table    = "route";
	$update_table = "UPDATE $rou_table SET ROU_STATUS='1' where ROU_ID='$rouid2'";
	mysqli_query($conn, $update_table);
	header("Refresh:0; url=view_route.php");
	mysqli_close($conn);
}
?>