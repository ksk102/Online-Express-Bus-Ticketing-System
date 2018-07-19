<?php
require '../database/db_con.php';

	$sql_trans 	 = "SELECT * from transaction where TRANS_ID = '$_COOKIE[transid]'";
	$result_trans = mysqli_query($conn, $sql_trans);
	$row_trans	 = mysqli_fetch_assoc($result_trans);
	
	$routeid = $row_trans['ROU_ID'];
	$seatno = $row_trans['TRANS_SEATNO'];
	
	$achosenseat = preg_split('/[,]/', $seatno);
	$chosenlength = count($achosenseat);	
	
	for($x=0;$x<$chosenlength;$x++)
	{
		$sql_creserve = "UPDATE seat SET SEAT_STATUS='0' where ROU_ID='$routeid' and SEAT_NO='$achosenseat[$x]'";
		mysqli_query($conn, $sql_creserve);
	}
	
	$sql_ctrans = "DELETE FROM transaction WHERE TRANS_ID = '$_COOKIE[transid]'";
	mysqli_query($conn, $sql_ctrans);
	
	$sql_droute = "SELECT * from route where ROU_ID='$routeid'";
	$result_droute = mysqli_query($conn, $sql_droute);
	$row		 = mysqli_fetch_assoc($result_droute);
	
	$afterrseat = $row['ROU_RSEAT'];
	$bttlrseat = $afterrseat + $chosenlength;
	$update_table	= "UPDATE route SET ROU_RSEAT='$bttlrseat' where ROU_ID='$routeid'";
	mysqli_query($conn, $update_table);
?>
