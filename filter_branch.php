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

if (isset($_GET['b_id']))
{
	$brnid	 		= $_GET['b_id'];
	//echo $schid;
}
else
{
	header('Location:view_branch.php');
}
//echo $admin_compid;
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>View Branch | BusForAll.com</title>
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
							<p>Filtered Branch</p>
						</div>
						<hr/>
						<div id="viewschedule-table">
							<table width="740px">
								<tr>
									<th height="40px">Branch ID</th>
									<th width="250px">Branch Name</th>
									<th width="180px">Contact Number</th>
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
								$branch_table	= "SELECT * from branch where COMP_ID='$brnid'";
								$sql_branch		= mysqli_query($conn, $branch_table);
								while($row2		= mysqli_fetch_assoc($sql_branch))
								{
									?>
									<tr>
										<td><?php echo "<a href=\"view_branch_detail.php?brn_id={$row2['BRANCH_ID']}\">{$row2['BRANCH_ID']}</a>";?></td>
										<td><?php echo $row2["BRANCH_NAME"];?></td>
										<td><?php echo $row2["BRANCH_PHONE"];?></td>
										<?php
										if (substr($sesscustid,0,1)== "A")
										{
											?>
											<td><?php echo "<a href=\"edit_branch_detail.php?brn_id={$row2['BRANCH_ID']}\"><img src='images/icon/signedin/edit.png' width='25px' height='30px'></a>";?></td>
											<td><?php echo "<a href=filter_branch.php?brn_id=".$row2['BRANCH_ID']." onclick='return confirmation();'><img src='images/icon/signedin/delete.png' width='25px' height='30px'></a>";?></td>
											<?php
										}
										?>
									</tr>
									<?php
								}
								?>
							</table>
							
							<div id="viewschedule-btn">
							
								<a href="view_branch.php"><input type="submit" name="addbtn" value="Back"></a>
							
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
if (isset($_REQUEST["brn_id"]))
{
	$brnid 	  	= $_REQUEST["brn_id"];
	$delete_sql = "DELETE from branch where BRANCH_ID='$brnid'";
	mysqli_query($conn, $delete_sql);
	header("Refresh:0; url=view_branch.php");
	mysqli_close($conn);
}
?>