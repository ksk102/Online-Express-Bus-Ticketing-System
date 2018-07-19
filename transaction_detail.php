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
			
			$sql_passenger 	 = "SELECT * from customer where CUST_ID = '$sesscustid'";
			$result_passenger = mysqli_query($conn, $sql_passenger);
			$row_passenger	 = mysqli_fetch_assoc($result_passenger);
			
			$passengername = $row_passenger['CUST_NAME'];
			$passengeric = $row_passenger['CUST_IC'];
			$passengerhp = $row_passenger['CUST_PHONE'];
			$passengeremail = $row_passenger['CUST_EMAIL'];
			
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
	if ((substr($sesscustid,0,1)== "S") || (substr($sesscustid,0,1)== "A"))
	{
		$WC_ID=$row_trans['WC_ID'];
		$sql_wc = "SELECT * from walkin where WC_ID = '$WC_ID'";
		$result_wc = mysqli_query($conn, $sql_wc);
		$row_wc		= mysqli_fetch_assoc($result_wc);
		
		$passengername = $row_wc['WC_NAME'];
		$passengeric = $row_wc['WC_IC'];
		$passengerhp = $row_wc['WC_PHONE'];
		$passengeremail = $row_wc['WC_EMAIL'];
	}
}
else
{
	header('Location: transaction.php');
}

$companycode = $row_trans['COMP_ID'];
$sql_companyname		= "SELECT * FROM company WHERE COMP_ID = '$companycode' group by COMP_NAME";
$result_companyname	= mysqli_query($conn, $sql_companyname);
$row_companyname = mysqli_fetch_array($result_companyname);
$company = $row_companyname['COMP_NAME'];

$transid=$trans_id;



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
									<?php
										$sch_id	 	= $row_rou["SCH_ID"];
										$sql_sch   = "SELECT * from schedule where SCH_ID = '$sch_id'";
										$result_sch = mysqli_query($conn, $sql_sch);
										$row_sch	= mysqli_fetch_assoc($result_sch);
										
										$departid = $row_sch['SCH_PICK'];;
										$arriveid = $row_sch['SCH_DROP'];;

										$sql_departcityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$departid' group by cityname.city_FULL";
										$result_departarrivecityname	= mysqli_query($conn, $sql_departcityname);
										$row_departcityname = mysqli_fetch_array($result_departarrivecityname);
										$depart=$row_departcityname["CITY_FULL"];

										$sql_arrivecityname = "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$arriveid' group by cityname.city_FULL";
										$result_arrivecityname	= mysqli_query($conn, $sql_arrivecityname);
										$row_arrivecityname = mysqli_fetch_array($result_arrivecityname);
										$arrive=$row_arrivecityname["CITY_FULL"];

										$route=$depart."<br/>"."-"."<br/>".$arrive;
										$route_pdf = $depart." - ".$arrive;

										$departdate = $row_rou["ROU_DATE"];
										$departtime = new DateTime($row_sch['SCH_TIME']);

										$depart=$departdate."<br/>".$departtime->format('h:i A');
										$depart_pdf = $departdate."   ".$departtime->format('h:i A');

										$seatno = $row_trans['TRANS_SEATNO'];
										$price =  $row_trans['TRANS_PRICE'];
										$platform = $row_rou["ROU_PLATFORM"];
										
										
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
										<td valign="top" width="150px">Seat No</td>
										<td valign="top"><b><?php echo $row_trans["TRANS_SEATNO"];?></b></td>
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
								</table>
								<div id="newannounce-btn" style="margin-left:580px;">
									<input type="submit" name="backbtn" value="Back">
								</div>
							</form>
								<div id="newannounce-btn" style="margin-left:580px;">
									<div id="pdfbtn">
										<form name="passpdf" action="pdf/index.php" method="post">
											<input type="hidden" name="passname" value="<?php echo $passengername; ?>">
											<input type="hidden" name="passic" value="<?php echo $passengeric; ?>">
											<input type="hidden" name="passphone" value="<?php echo $passengerhp; ?>">
											<input type="hidden" name="passemail" value="<?php echo $passengeremail; ?>">
											<input type="hidden" name="passcomp" value="<?php echo $company; ?>">
											<input type="hidden" name="passtrans" value="<?php echo $transid; ?>">
											<input type="hidden" name="passrou" value="<?php echo $route_pdf; ?>">
											<input type="hidden" name="passdepart" value="<?php echo $depart_pdf; ?>">
											<input type="hidden" name="passseat" value="<?php echo $seatno; ?>">
											<input type="hidden" name="passprice" value="<?php echo "RM".$price?>">
											<input type="hidden" name="passplatform" value="<?php echo $platform?>">
											<input type="submit" name="dpdf" value="Download as PDF" style="width:150px;"/>
										</form>
									</div>
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
if(isset($_POST['backbtn']))
{
	header("Location:transaction.php");
}
?>