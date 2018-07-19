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

if (isset($_GET['b_vrn']))
{
	$busvrn	 	= $_GET['b_vrn'];
	//echo $schid;
}
else
{
	header('Location:view_bus.php');
}
//echo $admin_compid;
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>View Bus | BusForAll.com</title>
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
							<p>Filtered Bus</p>
						</div>
						<hr/>
						<div id="viewschedule-table">
							<table width="740px">
								<tr>
									<th height="40px">Bus VRN</th>
									<th>Total Seats</th>
									<th>Type</th>
									<th>Status</th>
									<?php
										if (substr($sesscustid,0,1)== "A")
										{
											?>
											<th>Edit</th>
											<th>Delete</th>
											<?php
										}
									?>
								</tr>
								
								<?php
								$bus_table	= "SELECT * from bus where BUS_VRN='$busvrn' && COMP_ID='$compid'";
								$sql_bus	= mysqli_query($conn, $bus_table);
								
								while($row2 = mysqli_fetch_assoc($sql_bus))
								{
									$bus_status = $row2["BUS_STATUS"];
									if($bus_status=='0')
									{
										$status="Active";
									}
									else if($bus_status=='1')
									{
										$status="Inactive";
									}
									?>
									<tr>
										<td><?php echo $row2["BUS_VRN"];?></td>
										<td><?php echo $row2["BUS_TTLSEAT"];?></td>
										<td><?php echo $row2["BUS_TYPE"];?></td>
										<td><?php echo $status;?></td>
										
										<?php
										if (substr($sesscustid,0,1)== "A")
										{
											?>
											<td><?php echo "<a href=\"admin_edit_bus_detail.php?bus_vrn={$row2['BUS_VRN']}\"><img src='images/icon/signedin/edit.png' width='25px' height='30px'></a>";?></td>
											<td><?php echo "<a href=filter_bus.php?bus_vrn=".$row2['BUS_VRN']." onclick='return confirmation();'><img src='images/icon/signedin/delete.png' width='25px' height='30px'></a>";?></td>
											<?php
										}
										?>
									</tr>
									<?php
								}
								?>
							</table>
							
							<div id="viewschedule-btn">
								<a href="view_bus.php"><input type="submit" name="addbtn" value="Back"></a>
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
if (isset($_REQUEST["bus_vrn"]))
{
	//Schedule status
	//0 = Active
	//1 = Inactive
	
	$busvrn2     = $_REQUEST["bus_vrn"];
	$bus_table  = "bus";
	$update_table = "UPDATE $bus_table SET BUS_STATUS='1' where BUS_VRN='$busvrn2'";
	mysqli_query($conn, $update_table);
	header("Refresh:0; url=view_bus.php");
}
?>