<?php 

require 'Database/db_con.php';

if(isset($_SESSION['sess_uid']))
{
	$sesscustid  = $_SESSION["sess_uid"];
	if (substr($sesscustid,0,1)== "S")
	{
		$sql_user 	 = "SELECT * from staff where STAFF_ID = '$sesscustid'";
	}
	else if (substr($sesscustid,0,1)== "A")
	{
		$sql_user 	 = "SELECT * from admin where ADMIN_ID = '$sesscustid'";
	}
	else if(substr($sesscustid,0,1)== "C")
	{
		header('Location: user_profile.php');
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
		<title>View Branch | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
        <link href="css-folder/viewbranch.css" rel="stylesheet" type="text/css">
		<link href="css-folder/filter.css" rel="stylesheet" type="text/css">

		
		<script type="text/javascript">
		function confirmation()
		{
			answer = confirm("Want to delete this record?");
			return answer;
		}
		</script>
		
		<style type="text/css">
		.departarrive
		{
			border:1px solid #999999;
			float:left;
			width:330px;
			height:120px;
			margin-top:-1px;
			margin-right:10px;
		}
		</style>
	</head>

	<body>
    	<div id="container">
			<?php
				include 'include/header.php';
			?>
        
			<div id="content">
				<div id="content-wrapper">
					<?php include 'include/leftnavi.php'; ?>
					<div id="viewbranch-wrapper">
						<div id="viewbranch-wrapper-title">
							<p>View Branch</p>
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
															<p>Company ID</p>
															<input type="text" name="brn_id" value=""/>
														</div>
													</div>
													
													<input type="submit" name="filter" value="Filter"/>
												</div>
										</form>
									</div>
								</div>
							</div>
						<div id="viewbranch-table">
							<table width="740px">
								<tr>
									<th height="40px">Branch ID</th>
									<th width="250px">Branch Name</th>
									<th width="180px">Contact Number</th>
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
								$branch_table	= "SELECT * from branch where COMP_ID='$comp_id' ORDER BY BID DESC limit $start_from,$per_page";
								$sql_branch		= mysqli_query($conn, $branch_table);
								
								while($row2=mysqli_fetch_assoc($sql_branch))
								{
									?>
									<tr>
										<td><?php echo "<a href=\"view_branch_detail.php?brn_id={$row2['BRANCH_ID']}\">{$row2['BRANCH_ID']}</a>";?></td>
										<td height="40px"><?php echo $row2['BRANCH_NAME'];?></td>
										<td><?php echo $row2['BRANCH_PHONE'];?></td>
										<?php
										if (substr($sesscustid,0,1)== "A")
										{
											?>
											<td><?php echo "<a href=\"edit_branch_detail.php?brn_id={$row2['BRANCH_ID']}\"><img src='images/icon/signedin/edit.png' width='25px' height='30px'></a>";?></td>
											<td><?php echo "<a href=view_branch.php?brn_id=".$row2['BRANCH_ID']." onclick='return confirmation();'><img src='images/icon/signedin/delete.png' width='25px' height='30px'></a>";?></td>
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
										echo "<li style='width:80px;'><a href='view_branch.php?page=1'>".'First Page'."</a></li> ";

										for ($i=1; $i<=$total_pages; $i++) {

										echo "<li><a href='view_branch.php?page=".$i."'>".$i."</a></li> ";
										};
										// Going to last page
										echo "<li style='width:80px;'><a href='view_branch.php?page=$total_pages'>".'Last Page'."</a></li> ";
										?>
										</ul>
							</div>
							<?php
							if (substr($sesscustid,0,1)== "A")
							{
								?>
								<div id="viewbranch-btn">
									<a href="add_branch.php"><input type="submit" name="addbtn" value="Add"></a>
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
	$branch = $_GET['brn_id'];
	header("Location:filter_branch.php?b_id=$branch");
	exit;
}

if (isset($_REQUEST["brn_id"]))
{	
	$brnid 	  	   = $_REQUEST["brn_id"];
	$delete_sql    = "DELETE from branch where BRANCH_ID='$brnid'";
	mysqli_query($conn, $delete_sql);
	
}
?>