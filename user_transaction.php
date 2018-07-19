<?php 
require 'Database/db_con.php'; 

$sesscustid  = $_SESSION["sess_uid"];

$sql_user 	 = "SELECT * from customer where CUST_ID = '$sesscustid'";
$result_user = mysqli_query($conn, $sql_user);
$row		 = mysqli_fetch_assoc($result_user);

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
							<hr/>
						</div>
						<div id="viewtrans-table">
							<table width="770px">
								<tr>
									<th>Transaction ID</th>
									<th height="40px" width="120px">Depart Date</th>
									<th>Depart Time</th>
									<th width="140px">From</th>
									<th width="140px">To</th>
									<th>Quantity</th>
									<th width="90px">Status</th>
								</tr>
								<?php
								
								$transaction_table = "SELECT * from transaction where CUST_ID='$sesscustid'";
								$sql_transaction   = mysqli_query($conn, $transaction_table);
								
								while($row=mysqli_fetch_assoc($sql_transaction))
								{
									?>
									<tr>
										<td><?php echo "<a href=\"user_transaction_detail.php?trans_id={$row['TRANS_ID']}\">{$row['TRANS_ID']}</a>";?></td>
										<td height="40px"><?php echo $row["TRANS_DATE"];?></td>
										<td><?php echo $row["TRANS_TIME"];?></td>
										<td><?php echo $row["TRANS_DFROM"];?></td>
										<td><?php echo $row["TRANS_DTO"];?></td>
										<td><?php echo $row["TRANS_QTT"];?></td>
										<td><?php echo $row["TRANS_STATUS"];?></td>
									</tr>
									<?php
								}
								?>
							</table>
							<div id="page-selection">
								<ul>
									<li style="text-decoration:underline;">1</li>
									<a href="#" target="_self"><li>2</li></a>
									<a href="#" target="_self"><li>3</li></a>
									<a href="#" target="_self"><li>4</li></a>
									<a href="#" target="_self"><li style="border-right:1px solid black;">5</li></a>
									<a href="#" target="_self"><li style="width:80px;">Next Page</li></a>
								</ul>
							</div>
						</div>  
					</div>
				</div>
			</div>
		
			<?php include 'include/btmnavi.php'; ?>
		</div>
	</body>
</html>