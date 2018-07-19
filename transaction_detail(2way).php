<?php 

require 'Database/db_con.php';

	if(isset($_SESSION['sess_uid']))
	{
		$sesscustid  = $_SESSION["sess_uid"];
		if(substr($sesscustid,0,1)== "C")
		{
			$sql_user 	 = "SELECT * from customer where CUST_ID = '$sesscustid'";
			
			$trans_id	 	= $_GET['trans_id'];
	
			$sql_transcheck   = "SELECT * from transaction where TRANS_ID = '$trans_id' and CUST_ID='$sesscustid'";
			$result_transcheck = mysqli_query($conn, $sql_transcheck);
			$row_transcheck		= mysqli_fetch_assoc($result_transcheck);
			
			if($row_transcheck['TRANS_ID']<1)
			{
				header('Location: transaction.php');
			}
			
		}
		else if (substr($sesscustid,0,1)== "S")
		{
			$sql_user 	 = "SELECT * from staff where STAFF_ID = '$sesscustid'";
			$trans_id	 	= $_GET['trans_id'];
			
			$sql_transcheck   = "SELECT * from transaction where TRANS_ID = '$trans_id' and STAFF_ID='$sesscustid'";
			$result_transcheck = mysqli_query($conn, $sql_transcheck);
			$row_transcheck		= mysqli_fetch_assoc($result_transcheck);
			
			if($row_transcheck['TRANS_ID']<1)
			{
				header('Location: transaction.php');
			}
		}
		else if (substr($sesscustid,0,1)== "A")
		{
			$sql_user 	 = "SELECT * from admin where ADMIN_ID = '$sesscustid'";
			$trans_id	 	= $_GET['trans_id'];
			
			$sql_company 	 = "SELECT * from admin where ADMIN_ID = '$sesscustid'";
			$result_company  = mysqli_query($conn, $sql_company );
			$row_company 	 = mysqli_fetch_assoc($result_company );
			$companyid = $row_company ['COMP_ID'];
			
			$sql_transcheck   = "SELECT * from transaction where TRANS_ID = '$trans_id' and COMP_ID='$companyid'";
			$result_transcheck = mysqli_query($conn, $sql_transcheck);
			$row_transcheck		= mysqli_fetch_assoc($result_transcheck);
			
			if($row_transcheck['TRANS_ID']<1)
			{
				header('Location: transaction.php');
			}
		}
		
		$result_user = mysqli_query($conn, $sql_user);
		$row		 = mysqli_fetch_assoc($result_user);
	}
	else
	{
		header('Location: index.php');
	}

if (isset($_GET['trans_id']))
{	
	$sql_trans   = "SELECT * from transaction where TRANS_ID = '$trans_id'";
	$result_trans = mysqli_query($conn, $sql_trans);
	$row_trans		= mysqli_fetch_assoc($result_trans);
}
else
{
	header('Location: transaction.php');
}

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>View Announcement | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/transactiondetail.css" rel="stylesheet" type="text/css">
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
							<p>View Transaction Detail</p>
						</div>
						<hr/>
						<div id="viewannouncement-table">
							<form name="transactionfrm" action="" method="post">
								<table>
									<tr>
										<td valign="top" width="170px">Transaction ID</td>
										<td valign="top"><b><?php echo $row_trans["TRANS_ID"];?></b></td>
									</tr>
									<tr>
										<td valign="top" width="150px">Transaction Date</td>
										<td valign="top"><b><?php echo $row_trans["TRANS_DATE"];?></b></td>
									</tr>
									<tr>
										<td valign="top" width="150px">Transaction Time</td>
										<td valign="top"><b><?php echo $row_trans["TRANS_TIME"];?></b></td>
									</tr>
									<?php
										$rou_id	 	= $row_trans["ROU_ID"];
										$sql_rou   = "SELECT * from route where ROU_ID = '$rou_id'";
										$result_rou = mysqli_query($conn, $sql_rou);
										$row_rou	= mysqli_fetch_assoc($result_rou);
									?>
									<tr>
										<td valign="top" width="150px">Depart Date</td>
										<td valign="top"><b><?php echo $row_rou["ROU_DATE"];?></b></td>
									</tr>
									<?php
										$rou_id2	= $row_trans["ROU_ID2"];
										$sql_rou2   = "SELECT * from route where ROU_ID = '$rou_id2'";
										$result_rou2 = mysqli_query($conn, $sql_rou2);
										$row_rou2	= mysqli_fetch_assoc($result_rou2);
									?>
									<tr>
										<td valign="top" width="150px">Return Date</td>
										<td valign="top"><b><?php if($rou_id2==""){echo "<i style='font-size:10pt'>Not Applicable</i>";}else {echo $row_rou2["ROU_DATE"];}?></b></td>
									</tr>
									<?php
										$sch_id	 	= $row_rou["SCH_ID"];
										$sql_sch   = "SELECT * from schedule where SCH_ID = '$sch_id'";
										$result_sch = mysqli_query($conn, $sql_sch);
										$row_sch	= mysqli_fetch_assoc($result_sch);
										
										$sch_id2 	= $row_rou2["SCH_ID"];
										$sql_sch2   = "SELECT * from schedule where SCH_ID = '$sch_id2'";
										$result_sch2 = mysqli_query($conn, $sql_sch2);
										$row_sch2	= mysqli_fetch_assoc($result_sch2);
										
										$departid = $row_sch["SCH_PICK"];
										$arriveid	= $row_sch["SCH_DROP"];
										
										$sql_departcityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$departid' group by cityname.city_FULL";
										$result_departarrivecityname	= mysqli_query($conn, $sql_departcityname);
										$row_departcityname = mysqli_fetch_array($result_departarrivecityname);
										$depart=$row_departcityname["CITY_FULL"];
										
										$sql_arrivecityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$arriveid' group by cityname.city_FULL";
										$result_arrivecityname	= mysqli_query($conn, $sql_arrivecityname);
										$row_arrivecityname = mysqli_fetch_array($result_arrivecityname);
										$arrive=$row_arrivecityname["CITY_FULL"];
									?>
									<tr>
										<td valign="top" width="150px">Pick Up Point</td>
										<td valign="top"><b><?php echo $depart;?></b></td>
									</tr>
									<tr>
										<td valign="top" width="150px">Drop Off Point</td>
										<td valign="top"><b><?php echo $arrive;?></b></td>
									</tr>
									<tr>
										<td valign="top" width="150px">Depart Time</td>
										<td valign="top"><b><?php echo $row_sch['SCH_TIME'];;?></b></td>
									</tr>
									<tr>
										<td valign="top" width="150px">Return Time</td>
										<td valign="top"><b><?php if($row_trans["TRANS_SEATNO2"]==""){echo "<i style='font-size:10pt'>Not Applicable</i>";}else {echo $row_sch2['SCH_TIME'];}?></b></td>
									</tr>
									<tr>
										<td valign="top" width="150px">Seat No</td>
										<td valign="top"><b><?php echo $row_trans["TRANS_SEATNO"];?></b></td>
									</tr>
									<tr>
										<td valign="top" width="150px">Seat No (Return Trip)</td>
										<td valign="top"><b><?php if($row_trans["TRANS_SEATNO2"]==""){echo "<i style='font-size:10pt'>Not Applicable</i>";}else {$row_trans["TRANS_SEATNO2"];}?></b></td>
									</tr>
									<tr>
										<td valign="top" width="150px">Adult No.</td>
										<td valign="top"><b><?php echo $row_trans["TRANS_ADULT"];?></b></td>
									</tr>
									<tr>
										<td valign="top" width="150px">Child No.</td>
										<td valign="top"><b><?php echo $row_trans["TRANS_CHILD"];?></b></td>
									</tr>
									<tr>
										<td valign="top" width="150px">Price</td>
										<td valign="top"><b><?php echo "RM".$row_trans["TRANS_PRICE"];?></b></td>
									</tr>
									<tr>
										<td valign="top" width="150px">Price (Return Trip)</td>
										<td valign="top"><b><?php if($row_trans["TRANS_SEATNO2"]==""){echo "<i style='font-size:10pt'>Not Applicable</i>";}else {echo $row_trans["TRANS_PRICE2"];}?></b></td>
									</tr>
								</table>
								<div id="newannounce-btn" style="margin-left:480px;">
									<a href="pdf/index.php?transid=<?php echo $row_trans['TRANS_ID'];?>" target="_blank"><input type="button" name="pdfbtn" value="Download as PDF"></a>
									<input type="submit" name="backbtn" value="Back">
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
if(isset($_POST['backbtn']))
{
	header("Location:transaction.php");
}
?>