<?php 
require 'database/db_con.php';
date_default_timezone_set("Asia/Kuala_Lumpur");

$transid = $_COOKIE['transid'];

$cookie_name = "tid";
$cookie_value = $transid;
setcookie($cookie_name, $cookie_value, time() + (60 * 60 + 24), "/");

if (isset($_POST["pay"]))
{
	$pssgername = $_POST['username'];
	$pssgeric = $_POST['usernric'];
	$pssgerphone = $_POST['userphone'];
	$pssgeremail = $_POST['useremailA'];
	
	$sql_wc	= "SELECT WC_ID from walkin ORDER BY WCID DESC LIMIT 1";
	$result_wc = mysqli_query($conn, $sql_wc);
	$row_wc		= mysqli_fetch_assoc($result_wc);
	$lastwcid	= $row_wc['WC_ID'];

	if($row_wc<1)
	{
		$wcid_alpa	  = 'WC_';
		$wcid_num	  = 0; //Route ID

		++$wcid_num;
		$wcid_numext = str_pad($wcid_num,2,"0", STR_PAD_LEFT);

		$wcidfinal   = $wcid_alpa.$wcid_numext;
	}
	else
	{
		//Split route ID with _
		$split_wc	  = preg_split('/[_]/', $lastwcid);
		$wcid_alpa	  = 'WC_';
		$wcid_num	  = $split_wc[1]; //Route ID

		++$wcid_num;
		$wcid_numext = str_pad($wcid_num,2,"0", STR_PAD_LEFT);

		$wcidfinal   = $wcid_alpa.$wcid_numext;
	}
	
	$sql_pssger = "INSERT INTO walkin (WC_ID, WC_NAME, WC_IC, WC_PHONE, WC_EMAIL) VALUES ('$wcidfinal', '$pssgername','$pssgeric','$pssgerphone','$pssgeremail')";
	mysqli_query($conn, $sql_pssger);
	
	$transdate = date("Y-m-d");
	$transtime = date("h:i:sa");
	
	$sql_confirmtrans = "UPDATE transaction SET TRANS_DATE='$transdate', TRANS_TIME = '$transtime',TRANS_STATUS='0', WC_ID='$wcidfinal' where TRANS_ID='$_COOKIE[transid]'";
	mysqli_query($conn, $sql_confirmtrans);
	
	$transid = $_COOKIE['transid'];

	$cookie_name = "tid";
	$cookie_value = $transid;
	setcookie($cookie_name, $cookie_value, time() + (60 * 60 + 24), "/");
	
	header('Location: purchase_summary.php');
}
else
{
	header('Location: index.php');
}
?>