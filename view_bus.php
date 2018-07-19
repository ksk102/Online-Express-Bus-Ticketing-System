<?php 

require 'Database/db_con.php';

if(isset($_SESSION['sess_uid']))
{
	$sesscustid  = $_SESSION["sess_uid"];
	if(substr($sesscustid,0,1)== "C")
	{
		header('Location: user_profile.php');
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
	else if (substr($sesscustid,0,1)== "Q")
	{
		header('Location: index.php');
	}
		$result_user = mysqli_query($conn, $sql_user);
		$row		 = mysqli_fetch_assoc($result_user);
		$comp_id 	 = $row['COMP_ID'];
}
else
{
	header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>View Staff | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
        <link href="css-folder/viewbus.css" rel="stylesheet" type="text/css">
		<link href="css-folder/filter.css" rel="stylesheet" type="text/css">
		
		<script src="js-folder/index.js" type="text/javascript"></script>
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
					<div id="viewbus-wrapper">
						<div id="viewbus-wrapper-title">
							<p>View Bus</p>
						</div>
						<div id="viewschedule-wrapper-button">
							<div class="links">
								<div id="filter-popups">
									<p><a href="#schedulefilter" data-effect="mfp-zoom-out" class="filter-button">Filter</a></p>
								</div>
							</div>
						</div>
						<hr/>
						<div id="schedulefilter" class="filter-popup mfp-with-anim mfp-hide">
							<div id="top-filter">
								<div id="content-left">
									<form name="filterfrm" method="get" action="">
										<div id="content-left-title"><p>Filter</p></div>
											<div id="content-left-content-form">
												<div id="content-left-content-form-top">
													<div id="content-left-content-form-top-content">
														<p>BUS VRN</p>
														<input type="text" name="bus_vrn" value=""/>
													</div>
												</div>
												<input type="submit" name="filter" value="Filter"/>
											</div>
									</form>
								</div>
							</div>
						</div>
						
						<div id="viewbus-table">
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
								$bus_table  = "SELECT * from bus where BUS_STATUS=0 && COMP_ID='$comp_id' limit $start_from,$per_page";
								$sql_bus    = mysqli_query($conn, $bus_table);	
							
								while($row2=mysqli_fetch_assoc($sql_bus))
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
										<td height="40px"><?php echo $row2["BUS_TTLSEAT"];?></td>
										<td><?php echo $row2["BUS_TYPE"];?></td>
										<td><?php echo $status;?></td>
										<?php
										if (substr($sesscustid,0,1)== "A")
										{
											?>
											<td><?php echo "<a href=\"admin_edit_bus_detail.php?bus_vrn={$row2['BUS_VRN']}\"><img src='images/icon/signedin/edit.png' width='25px' height='30px'></a>";?></td>
											<td><?php echo "<a href=view_bus.php?bus_vrn=".$row2['BUS_VRN']." onclick='return confirmation();'><img src='images/icon/signedin/delete.png' width='25px' height='30px'></a>";?></td>
											<?php
										}
										?>
									</tr>
									<?php
								}
								?>
								
							</table>
							<div id="page-selection">
								<?php
										//Now select all from table
										$query = "select * from bus";
										$result = mysqli_query($conn, $query);

										// Count the total records
										$total_records = mysqli_num_rows($result);

										//Using ceil function to divide the total records on per page
										$total_pages = ceil($total_records / $per_page);
										
										?>
										<ul>
										<?php
										//Going to first page
										echo "<li style='width:80px;'><a href='view_bus.php?page=1'>".'First Page'."</a></li> ";

										for ($i=1; $i<=$total_pages; $i++) {

										echo "<li><a href='view_bus.php?page=".$i."'>".$i."</a></li> ";
										};
										// Going to last page
										echo "<li style='width:80px;'><a href='view_bus.php?page=$total_pages'>".'Last Page'."</a></li> ";
										?>
										</ul>
							</div>
							<?php
							if (substr($sesscustid,0,1)== "A")
							{
								?>
								<div id="viewbus-btn">
									<a href="add_bus.php"><input type="submit" name="addbtn" value="Add"></a>
								</div>
								<?php
							}
							?>
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
if(isset($_GET['filter']))
{
	$busvrn = $_GET['bus_vrn'];
	header("Location:filter_bus.php?b_vrn=$busvrn");
	exit;
}

if (isset($_REQUEST["bus_vrn"]))
{
	//Bus status
	//0 = Active
	//1 = Inactive
	
	$busvrn 	  = $_REQUEST["bus_vrn"];
	$bus_table    = "bus";
	$update_table = "UPDATE $bus_table SET BUS_STATUS='1' where BUS_VRN='$busvrn'";
	mysqli_query($conn, $update_table);
	header("Location:view_bus.php");
	
}
?>
