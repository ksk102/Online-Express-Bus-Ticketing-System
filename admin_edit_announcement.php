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
		else if (substr($sesscustid,0,1)== "A")
		{
			$sessadmid  = $_SESSION["sess_uid"];

			$sql_user 	 = "SELECT * from admin where ADMIN_ID = '$sessadmid'";
			$result_user = mysqli_query($conn, $sql_user);
			$row		 = mysqli_fetch_assoc($result_user);
		}
	}
	else
	{
		header('Location: index.php');
	}
	
	if(!isset($_SESSION["sess_annid"]))
	{
		header('Location: admin_profile.php');
	}
	else
	{
		$sessannid    = $_SESSION["sess_annid"];
	}

$sql_ann	  = "SELECT * from announcement where ANN_ID = '$sessannid'";
$result_ann   = mysqli_query($conn, $sql_ann);
$row2		  = mysqli_fetch_assoc($result_ann);

date_default_timezone_set("Asia/Kuala_Lumpur");
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Edit Announcement | BusForAll.com</title>
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
							<p>Edit Announcement</p>
							<hr/>
						</div>

						<div id="newannouncefrm">
							<form name="addnewannounce" action="" method="post" onsubmit="return validate();">
								<table>
									<tr>
										<td width="90px" class="alignright">Date</td>
										<td><input type="date" name="acn_date" value="<?php echo $row2["ANN_DATE"];?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td class="alignright">Time</td>
										<td><input type="time" name="acn_time" value="<?php echo $row2["ANN_TIME"];?>" class="readonly" readonly></td>
									</tr>
									<tr>
										<td width="90px" class="alignright">Expiry Date<span class="red">*</span></td>
										<td><input type="date" name="acn_expdate" value="<?php echo date('Y-m-d', strtotime($row2["ANN_EXPIRY"]));?>"><span id="ExpiryError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td class="alignright">Title<span class="red">*</span></td>
										<td><input type="text" name="acn_title" maxlength="50" style="height:25px;width:300px;" value="<?php echo $row2["ANN_TITLE"];?>" placeholder="Enter your title here" oninput="check_title();"><span id="TitleError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td class="alignright">Content<span class="red">*</span></td>
										<td style="padding-left:10px;"><textarea name="acn_content" id="editor1"><?php echo $row2["ANN_DETAIL"];?></textarea><span id="ContentError" class="red">&nbsp;</span></td>
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
									<input type="submit" name="savebtn" value="Save Changes">
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
if(isset($_POST["savebtn"]))
{
	$date	 = $_POST["acn_date"];
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
	if($curexpiry < $curdate || $curexpiry == $curdate)
	{
		?>
		<script>
			document.getElementById('ExpiryError').innerHTML = ' Expiry date cannot earlier or same with current date';
		</script>
		<?php
	}
	else if($content == "")
	{
		?>
		<script>
			document.getElementById('ContentError').innerHTML = ' Please enter the content of the announcement';
		</script>
		<?php
	}
	else
	{
			//Update announcement table
			$ann_table    = "announcement";
			$update_table = "UPDATE $ann_table SET ANN_EXPIRY='$expiry', ANN_TITLE='$title', ANN_DETAIL='$content' where ANN_ID='$sessannid'";
			mysqli_query($conn, $update_table);
			echo "<script>alert('Announcment successfully edited');window.location.href='admin_view_announcement.php';</script>";
			//END: Update announcement table
			mysqli_close($conn);
	}
}

?>