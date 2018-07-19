<?php 

require 'Database/db_con.php';

	if(isset($_SESSION['sess_uid']))
	{
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
		
		$result_user = mysqli_query($conn, $sql_user);
		$row		 = mysqli_fetch_assoc($result_user);
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
		<title>Transaction History | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/transactionhistory.css" rel="stylesheet" type="text/css">
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
					<div id="viewtrans-wrapper">
						<div id="viewtrans-wrapper-title">
							<p>Transaction History</p>
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
															<p>Transaction Date</p>
															<input type="date" name="brn_id" value=""/>
														</div>
													</div>
													
													<input type="submit" name="filter" value="Filter"/>
												</div>
										</form>
									</div>
								</div>
							</div>
						<div id="viewtrans-table">
							<table width="770px">
								<tr>
									<th width="">Transaction ID</th>
									<th height="50px" width="">Transaction Date</th>
									<th width="">From</th>
									<th width="">To</th>
									<th width="">Depart Date</th>
									<!--<th width="">Return Date</th>-->
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
								
								if(substr($sesscustid,0,1)== "C")
								{
									$transaction_table = "SELECT * from transaction where CUST_ID='$sesscustid' and TRANS_STATUS=0 ORDER BY TRANSID DESC limit $start_from,$per_page";
								}
								else if (substr($sesscustid,0,1)== "S")
								{
									$transaction_table = "SELECT * from transaction where STAFF_ID='$sesscustid' and TRANS_STATUS=0 ORDER BY TRANSID DESC limit $start_from,$per_page";
								}
								else if (substr($sesscustid,0,1)== "A")
								{
									$sql_company 	 = "SELECT * from admin where ADMIN_ID = '$sesscustid'";
									$result_company  = mysqli_query($conn, $sql_company );
									$row_company 	 = mysqli_fetch_assoc($result_company );
									$companyid = $row_company ['COMP_ID'];
									$transaction_table = "SELECT * from transaction where COMP_ID='$companyid' and TRANS_STATUS=0 ORDER BY TRANSID DESC limit $start_from,$per_page";
								}
								
								$sql_transaction   = mysqli_query($conn, $transaction_table);
								
								while($row_transaction=mysqli_fetch_assoc($sql_transaction))
								{
									?>
									<tr>
										<td><?php echo "<a href=\"transaction_detail.php?trans_id={$row_transaction['TRANS_ID']}\">{$row_transaction["TRANS_ID"]}</a>"?></td>
										<td height="40px"><?php echo $row_transaction["TRANS_DATE"];?></td>
										
										<?php
										
										$routeid = $row_transaction["ROU_ID"];
										$routeid2 = $row_transaction["ROU_ID2"];
										
										$route_table = "SELECT * from route where ROU_ID='$routeid'";
										$sql_route   = mysqli_query($conn, $route_table);
										$row_route=mysqli_fetch_assoc($sql_route);
										
										$route_table2 = "SELECT * from route where ROU_ID='$routeid2'";
										$sql_route2   = mysqli_query($conn, $route_table2);
										$row_route2=mysqli_fetch_assoc($sql_route2);
										
										$schid = $row_route["SCH_ID"];
										$schedule_table = "SELECT * from schedule where SCH_ID='$schid'";
										$sql_schedule   = mysqli_query($conn, $schedule_table);
										$row_schedule = mysqli_fetch_assoc($sql_schedule);
										
										$departid = $row_schedule["SCH_PICK"];
										$arriveid	= $row_schedule["SCH_DROP"];
										
										$sql_departcityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$departid' group by cityname.city_FULL";
										$result_departarrivecityname	= mysqli_query($conn, $sql_departcityname);
										$row_departcityname = mysqli_fetch_array($result_departarrivecityname);
										$depart=$row_departcityname["CITY_FULL"];
										
										$sql_arrivecityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$arriveid' group by cityname.city_FULL";
										$result_arrivecityname	= mysqli_query($conn, $sql_arrivecityname);
										$row_arrivecityname = mysqli_fetch_array($result_arrivecityname);
										$arrive=$row_arrivecityname["CITY_FULL"];
										
										$departdate = $row_route["ROU_DATE"];
										$returndate = $row_route2["ROU_DATE"];
										?>
										
										<td><?php echo $depart;?></td>
										<td><?php echo $arrive;?></td>
										<td><?php echo $departdate;?></td>
										<td><?php //if($returndate == ""){echo "One-way-trip";}else{echo $returndate;}?></td>
										
									</tr>
									<?php
								}
								?>
							</table>
							<div id="page-selection">
								<?php
										//Now select all from table
										$query = "select * from branch";
										$result = mysqli_query($conn, $query);

										// Count the total records
										$total_records = mysqli_num_rows($result);

										//Using ceil function to divide the total records on per page
										$total_pages = ceil($total_records / $per_page);
										
										?>
										<ul>
										<?php
										//Going to first page
										echo "<li style='width:80px;'><a href='transaction.php?page=1'>".'First Page'."</a></li> ";

										for ($i=1; $i<=$total_pages; $i++) {

										echo "<li><a href='transaction.php?page=".$i."'>".$i."</a></li> ";
										};
										// Going to last page
										echo "<li style='width:80px;'><a href='transaction.php?page=$total_pages'>".'Last Page'."</a></li> ";
										?>
										</ul>
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
if(isset($_GET['filter']))
{
	$transaction = $_GET['brn_id'];
	header("Location:filter_transaction.php?t_date=$transaction");
	exit;
}
?>