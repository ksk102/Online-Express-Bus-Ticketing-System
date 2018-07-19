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
	$schid = $_GET['s_id'];
	//echo $schid;
}
else
{
	header('Location:view_schedule.php');
}
//echo $admin_compid;
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
							<p>Filtered Schedules</p>
						</div>
						<hr/>
						<div id="viewschedule-table">
							<table width="740px">
								<tr>
									<th height="40px">Schedule ID</th>
									<th>Time</th>
									<th width="130px">Pick-Up Point</th>
									<th width="130px">Drop-Off Point</th>
									<th>Price</th>
									<?php
										if (substr($sesscustid,0,1)== "A")
										{
											?>
											<th width="50px">Edit</th>
											<th width="50px">Delete</th>
											<?php
										}
									?>
								</tr>
								
								<?php
								$sch_table = "SELECT * from schedule where SCH_TIME='$schid' && COMP_ID='$compid'";
								$sql_sch   = mysqli_query($conn, $sch_table);
								while($row2 = mysqli_fetch_assoc($sql_sch))
								{
									?>
									<tr>
										<?php
										if (substr($sesscustid,0,1)== "A")
										{
											?>
											<td><?php echo "<a href=\"admin_view_schedule_detail.php?sch_id={$row2['SCH_ID']}\">{$row2['SCH_ID']}</a>";?></td>
											<?php
										}
										else if (substr($sesscustid,0,1)== "S")
										{
											?>
											<td><?php echo "<a href=\"staff_view_schedule_detail.php?sch_id={$row2['SCH_ID']}\">{$row2['SCH_ID']}</a>";?></td>
											<?php
										}
										?>
										<?php
										$depart = $row2['SCH_PICK'];
										$arrive = $row2['SCH_DROP'];
										
										$sql_departcityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$depart' group by cityname.city_FULL";
										$result_departarrivecityname	= mysqli_query($conn, $sql_departcityname);
										
										while ($row_city = mysqli_fetch_array($result_departarrivecityname))
										{
											$pickup=$row_city["CITY_FULL"];
										}
										
										$sql_arrivecityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$arrive' group by cityname.city_FULL";
										$result_arrivecityname	= mysqli_query($conn, $sql_arrivecityname);
										
										while ($row_city = mysqli_fetch_array($result_arrivecityname))
										{
											$dropoff=$row_city["CITY_FULL"];
										}
										?>
										
										
										<td height='30px'><?php echo $row2["SCH_TIME"];?></td>
										<td><?php echo $pickup;?></td>
										<td><?php echo $dropoff;?></td>
										<td>RM<?php echo $row2["SCH_PRICE"];?></td>
										<?php
										if (substr($sesscustid,0,1)== "A")
										{
											?>
											<td><?php echo "<a href=\"edit_schedule.php?sch_id={$row2['SCH_ID']}\"><img src='images/icon/signedin/edit.png' width='25px' height='30px'></a>";?></td>
											<td><?php echo "<a href=filter_schedule.php?sch_id=".$row2['SCH_ID']." onclick='return confirmation();'><img src='images/icon/signedin/delete.png' width='25px' height='30px'></a>";?></td>
											<?php
										}
										?>
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
									<a href="view_schedule.php"><input type="submit" name="addbtn" value="Back"></a>
									<?php
								}
								if (substr($sesscustid,0,1)== "S")
								{
									?>
									<a href="staff_view_schedule.php"><input type="submit" name="addbtn" value="Back"></a>
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

<?php
if (isset($_REQUEST["sch_id"]))
{
	//Schedule status
	//0 = Active
	//1 = Inactive
	
	$schid2     = $_REQUEST["sch_id"];
	$sch_table  = "schedule";
	$update_table = "UPDATE $sch_table SET SCH_STATUS='1' where SCH_ID='$schid2'";
	mysqli_query($conn, $update_table);
	header("Refresh:0; url=view_schedule.php");
	mysqli_close($conn);
}
?>