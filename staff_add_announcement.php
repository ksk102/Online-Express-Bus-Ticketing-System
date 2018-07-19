<?php 

require 'Database/db_con.php';

	if(isset($_SESSION['sess_uid']))
	{
		$sesscustid  = $_SESSION["sess_uid"];
		if(substr($sesscustid,0,1)== "C")
		{
			header('Location: user_profile.php');
		}
		else if (substr($sesscustid,0,1)== "A")
		{
			header('Location: admin_profile.php');
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

$sessstaffid = $_SESSION["sess_uid"];

$sql_staff	  = "SELECT * from staff where STAFF_ID = '$sessstaffid'";
$result_staff = mysqli_query($conn, $sql_staff);
$row 		  = mysqli_fetch_assoc($result_staff);
$staff_comp	  = $row['COMP_ID'];

date_default_timezone_set("Asia/Kuala_Lumpur");

//Generate announcement ID
//Retrieve the last announcement ID
$sql_ann    = "SELECT ANN_ID from announcement ORDER BY ANNID DESC LIMIT 1";
$result_sql   = mysqli_query($conn, $sql_ann);
$row2		  = mysqli_fetch_assoc($result_sql);
$lastannid  = $row2['ANN_ID'];

if($row2<1)
{
	$annid2	   = 'ANN_';
	$annid_num = 0; //Announcement ID

	++$annid_num;
	$annid_numext = str_pad($annid_num,2,"0", STR_PAD_LEFT);

	$annidfinal	= $annid2.$annid_numext;
}
else
{
	//Split staff ID with _ and 0
	$annid1	   = preg_split('/[_]/', $lastannid);

	$annid2	   = 'ANN_';
	$annid_num = $annid1[1]; //Announcement ID

	++$annid_num;
	$annid_numext = str_pad($annid_num,2,"0", STR_PAD_LEFT);

	$annidfinal	= $annid2.$annid_numext;
	//print_r ($annid1);
	//echo "<br>";
	//echo $annidfinal;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Add Announcement | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/addannouncement.css" rel="stylesheet" type="text/css">
		<script src="ckeditor/ckeditor.js"></script>
		
		<script>
		function check_title()
		{
			if (document.addnewannounce.acn_title.value == "")
			{
				document.getElementById('TitleError').innerHTML = ' Enter the announcement title';
				return false;
			}
			else
			{
				document.getElementById('TitleError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		
		function validate()
		{
			if (check_title())
			{
				return true;
			}
			else
			{
				alert("Please checck your information again");
				return false;
			}
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
					<div id="newannounce-wrapper">
						<div id="newannounce-wrapper-title">
							<p>Add New Announcement</p>
							<hr/>
						</div>

						<div id="newannouncefrm">
							<form name="addnewannounce" action="" method="post">
								<table>
									<tr>
										<td valign="top" width="90px" class="alignright">Date</td>
										<td valign="top"><input type="date" name="acn_date" value="<?php echo date('Y-m-d');?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td valign="top" class="alignright">Time</td>
										<td valign="top"><input type="time" name="acn_time" value="<?php echo date('H:i:s');?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td valign="top" width="90px" class="alignright">Expiry Date<span class="red">*</span></td>
										<td valign="top"><input type="date" name="acn_expdate"><span id="ExpiryError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td valign="top" class="alignright">Title<span class="red">*</span></td>
										<td valign="top"><input type="text" name="acn_title" maxlength="50" style="height:25px;width:300px;" placeholder="Enter your title here" oninput="check_title();"><span id="TitleError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td valign="top" class="alignright">Content<span class="red">*</span></td>
										<td valign="top" style="padding-left:10px;"><textarea name="acn_content" id="editor1"></textarea><span id="ContentError" class="red">&nbsp;</span></td>
										<script>
											CKEDITOR.replace('editor1'); 
											CKEDITOR.config.resize_enabled = false;
											CKEDITOR.config.bodyId = "reserved";
											CKEDITOR.config.toolbar = 
											[
												[ 'Bold', 'Italic', '-','NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ]
											];
											CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
										</script>
									</tr>
								</table>
								<p width="150px" style="text-align:left;padding-right:10px;"><span class="red">* Required field</span></p>
								<div id="newannounce-btn">
									<input type="submit" name="addbtn" value="Add">
									<input type="reset" name="cancelbtn" value="Cancel">
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
if(isset($_POST["addbtn"]))
{
	$date    = $_POST["acn_date"];
	$time    = $_POST["acn_time"];
	$expiry  = $_POST["acn_expdate"];
	$title   = $_POST["acn_title"];
	$content = $_POST["acn_content"];
	
	//Convert to timestamp
	$curdate   = strtotime($date);
	$curexpiry = strtotime($expiry); 
	
	
	if($expiry == "" && $title == "" && $content == "")
	{
		?>
		<script>
			alert("Required field cannot be empty");
		</script>
		<?php
	}
	if($content == "")
	{
		?>
		<script>
			document.getElementById('ContentError').innerHTML = ' Please enter the content of the announcement';
		</script>
		<?php
	}
	else if($curexpiry == "")
	{
		?>
		<script>
			document.getElementById('ExpiryError').innerHTML = ' Expiry date cannot be empty';
		</script>
		<?php
	}
	else if($curexpiry < $curdate || $curexpiry == $curdate || $expiry == "")
	{
		?>
		<script>
			document.getElementById('ExpiryError').innerHTML = ' Expiry date cannot earlier or same with current date';
		</script>
		<?php
	}
	
	else
	{
		//Insert into announcement table
		$ann_table  = "announcement";
		$sql_insert = "INSERT into " .$ann_table. "(ANN_ID, ANN_DATE, ANN_TIME, ANN_EXPIRY, ANN_TITLE, ANN_DETAIL, STAFF_ID, COMP_ID)". "VALUES('$annidfinal', '$date', '$time', '$expiry', '$title', '$content', '$sessstaffid', '$staff_comp')";
		mysqli_query($conn, $sql_insert);
		//END: Insert into announcement table
		
		echo "<script>alert('Announcement successfully added'); window.location.href='staff_view_announcement.php';</script>";
		
		mysqli_close($conn);
	}
}
?>