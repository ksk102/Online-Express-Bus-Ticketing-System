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
	}
	else
	{
		header('Location: index.php');
	}

$sessadminid = $_SESSION["sess_uid"];

$sql_user	  = "SELECT * from admin where ADMIN_ID = '$sessadminid'";
$result_user  = mysqli_query($conn, $sql_user);
$row 		  = mysqli_fetch_assoc($result_user);
$staff_comp	  = $row['COMP_ID'];
if(isset($_SESSION['pic_url']))
{
	$pic_url	  = $_SESSION['pic_url'];
}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>View Staff | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/viewstaff.css" rel="stylesheet" type="text/css">
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
					
					<div id="viewstaff-wrapper">
						<div id="viewstaff-wrapper-title">
							<p>View Staff</p>
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
														<p>Branch ID</p>
														<input type="text" name="staff_id" value=""/>
													</div>
												</div>
												<input type="submit" name="filter" value="Filter"/>
											</div>
									</form>
								</div>
							</div>
						</div>
						
						<div id="viewstaff-table">
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
								$staff_table = "SELECT * from staff where STAFF_STATUS=0 && COMP_ID='$staff_comp' ORDER BY SID DESC limit $start_from,$per_page";
								$sql_staff	 = mysqli_query($conn, $staff_table);
								
								while($row=mysqli_fetch_assoc($sql_staff))
								{
									?>
									<tr>
										<td><?php echo "<a href=\"admin_view_staff_detail.php?staff_id={$row['STAFF_ID']}\">{$row['STAFF_ID']}</a>";?></td>
										<td height="40px"><?php echo $row["STAFF_EMAIL"];?></td>
										<td><?php echo $row["STAFF_NAME"];?></td>
										<td><?php echo $row["STAFF_PHONE"];?></td>
										<td><?php echo $row["BRANCH_ID"];?></td>
										<td><?php echo "<a href=\"admin_edit_staff_detail.php?staff_id={$row['STAFF_ID']}\"><img src='images/icon/signedin/edit.png' width='25px' height='30px'></a>";?></td>
										<td><?php echo "<a href=view_staff_detail.php?staff_id=".$row['STAFF_ID']." onclick='return confirmation();'><img src='images/icon/signedin/delete.png' width='25px' height='30px'></a>";?></td>                               
									</tr>
									<?php
								}
								?>
								
							</table>
							<div id="page-selection">
								<?php
										//Now select all from table
										$query = "select * from staff";
										$result = mysqli_query($conn, $query);

										// Count the total records
										$total_records = mysqli_num_rows($result);

										//Using ceil function to divide the total records on per page
										$total_pages = ceil($total_records / $per_page);
										
										?>
										<ul>
										<?php
										//Going to first page
										echo "<li style='width:80px;'><a href='view_staff_detail.php?page=1'>".'First Page'."</a></li> ";

										for ($i=1; $i<=$total_pages; $i++) {

										echo "<li><a href='view_staff_detail.php?page=".$i."'>".$i."</a></li> ";
										};
										// Going to last page
										echo "<li style='width:80px;'><a href='view_staff_detail.php?page=$total_pages'>".'Last Page'."</a></li> ";
										?>
										</ul>
							</div>
							<div id="viewstaff-btn">
								<a href="add_staff.php"><input type="submit" name="addbtn" value="Add"></a>
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
	$staffid = $_GET['staff_id'];
	header("Location:filter_staff.php?s_id=$staffid");
	exit;
}

if (isset($_REQUEST["staff_id"]))
{
	//Staff status
	//0 = Active
	//1 = Inactive
	
	$staffid 	  = $_REQUEST["staff_id"];
	$staff_table  = "staff";
	$update_table = "UPDATE $staff_table SET STAFF_STATUS='1' where STAFF_ID='$staffid'";
	mysqli_query($conn, $update_table);
	header("Location:view_staff_detail.php");
}
?>
