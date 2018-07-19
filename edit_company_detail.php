<?php 

require 'database/db_con.php';
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

$sessadmid  = $_SESSION["sess_uid"];

$sql_user 	 = "SELECT * from admin where ADMIN_ID = '$sessadmid'";
$result_user = mysqli_query($conn, $sql_user);
$row		 = mysqli_fetch_assoc($result_user);
$admin_comp	 = $row['COMP_ID'];

$company_table  = "SELECT * from company where COMP_ID='$admin_comp'";
$result_company = mysqli_query($conn, $company_table);
$row2			= mysqli_fetch_assoc($result_company);
//$comp_street	= $row2['COMP_ADDR_STREET'];
//$comp_city		= $row2['COMP_ADDR_CITY'];
//$comp_state		= $row2['COMP_ADDR_STATE'];
//$comp_post		= $row2['COMP_ADDR_POST'];

//$comp_fulladdr  = $comp_street.', '.$comp_city.', '.$comp_state.', '.$comp_post;
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Edit Company Detail | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css"/>
		<link href="css-folder/editcompanydetail.css" rel="stylesheet" type="text/css"/>
		<script src="ckeditor/ckeditor.js"></script>
		
		<script>
		function check_name()
		{
			if (document.mycompany.comp_name.value == "")
			{
				document.getElementById('NameError').innerHTML = ' Enter company name';
				return false;
			}
			else
			{
				document.getElementById('NameError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		
		function check_phone()
		{
			if (document.mycompany.comp_phone.value == "" || isNaN(document.mycompany.comp_phone.value))
			{
				document.getElementById('PhoneError').innerHTML = ' Enter company phone number';
				return false;
			}
			else
			{
				document.getElementById('PhoneError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		
		function check_email()
		{
			if (document.mycompany.comp_email.value == "" || !(isNaN(document.mycompany.comp_email.value)) || document.mycompany.comp_email.value.indexOf("@") == -1 || document.mycompany.comp_email.value.indexOf(".my") == -1)
			{
				document.getElementById('EmailError').innerHTML = ' Enter the correct email';		
				return false;
			}
			else
			{
				document.getElementById('EmailError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		
		function check_postcode()
		{
			if (document.mycompany.comp_addr_postcode.value.length < 5 && document.mycompany.comp_addr_postcode.value.length > 0 || document.mycompany.comp_addr_postcode.value.length > 5 || isNaN(document.mycompany.comp_addr_postcode.value))
			{
				document.getElementById('PostcodeError').innerHTML = ' <br>&nbsp; Enter the correct Postcode Number';		
				return false;
			}
			else
			{
				if(document.mycompany.comp_addr_postcode.value == "")
				{
					document.getElementById('PostcodeError').innerHTML = '&nbsp;';
				}
				else
				{
					document.getElementById('PostcodeError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';	
				}
				return true;
			}
		}
		
		function validate()
		{
			if (check_name() && check_phone() && check_email() && check_postcode())
			{
				return true;
			}
			else
			{
				alert("Please check your information again");
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
					<div id="editcompany-wrapper">
						<div id="editcompany-wrapper-title">
							<p>Edit Company Detail</p>
							<hr/>
						</div>
						<div id="editcompanyfrm">
							<form name="mycompany" id="mycompany-form" action="" method="post" onsubmit="return validate();" enctype="multipart/form-data">
								<table>
									<tr>
										<td width="138px" style="text-align:right;padding-right:10px;">Company Name<span class="red">*</span></td>
										<td>
											<input type="text" name="comp_name" value="<?php echo $row2["COMP_NAME"];?>" placeholder="Company name" oninput="check_name();" onblur="check_name();"/><span id="NameError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Company Picture</td>
										<td><input type="file" name="comp_pic" style="border:none;"/></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Contact Number<span class="red">*</span></td>
										<td>
											<input type="text" name="comp_phone" value="<?php echo $row2["COMP_PHONE"];?>" placeholder="Company Phone Number" oninput="check_phone();"/><span id="PhoneError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Email<span class="red">*</span></td>
										<td>
											<input type="email" name="comp_email" placeholder="Company email address" value="<?php echo $row2["COMP_EMAIL"];?>" oninput="check_email();" onblur="check_email();"/><span id="EmailError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Company Address<span class="red">*</span></td>
										<td><input type="text" name="comp_addr_no" value="<?php echo $row2["COMP_ADDR_STREET"];?>" placeholder="No.99, Jalan XXX, Taman XXX" style="width:450px;"/><small> (Street)</small></td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="comp_addr_city" value="<?php echo $row2["COMP_ADDR_CITY"];?>" placeholder="Port Dickson" style="width:450px;"/><small> (City)</small></td>
									</tr>
									<tr>
										<td></td>
										<td>
											<select name="comp_addr_state" style="width:450px;">
												<option value="" <?php if($row2["COMP_ADDR_STATE"]==""){echo "selected";}?>>Select...</option>
												<option value="KUL" <?php if($row2["COMP_ADDR_STATE"]=="KUL"){echo "selected";}?>>Kuala Lumpur</option>
												<option value="LBN" <?php if($row2["COMP_ADDR_STATE"]=="LBN"){echo "selected";}?>>Labuan</option>
												<option value="PJY" <?php if($row2["COMP_ADDR_STATE"]=="PJY"){echo "selected";}?>>Putrajaya</option>
												<option value="JHR" <?php if($row2["COMP_ADDR_STATE"]=="JHR"){echo "selected";}?>>Johor</option>
												<option value="KDH" <?php if($row2["COMP_ADDR_STATE"]=="KDH"){echo "selected";}?>>Kedah</option>
												<option value="KTN" <?php if($row2["COMP_ADDR_STATE"]=="KTN"){echo "selected";}?>>Kelantan</option>
												<option value="MLK" <?php if($row2["COMP_ADDR_STATE"]=="MLK"){echo "selected";}?>>Melaka</option>
												<option value="NSN" <?php if($row2["COMP_ADDR_STATE"]=="NSN"){echo "selected";}?>>Negeri Sembilan</option>
												<option value="PHG" <?php if($row2["COMP_ADDR_STATE"]=="PHG"){echo "selected";}?>>Pahang</option>
												<option value="PRK" <?php if($row2["COMP_ADDR_STATE"]=="PRK"){echo "selected";}?>>Perak</option>
												<option value="PLS" <?php if($row2["COMP_ADDR_STATE"]=="PLS"){echo "selected";}?>>Perlis</option>
												<option value="PNG" <?php if($row2["COMP_ADDR_STATE"]=="PNG"){echo "selected";}?>>Penang</option>
												<option value="SBH" <?php if($row2["COMP_ADDR_STATE"]=="SBH"){echo "selected";}?>>Sabah</option>
												<option value="SWK" <?php if($row2["COMP_ADDR_STATE"]=="SWK"){echo "selected";}?>>Sarawak</option>
												<option value="SGR" <?php if($row2["COMP_ADDR_STATE"]=="SGR"){echo "selected";}?>>Selangor</option>
												<option value="TRG" <?php if($row2["COMP_ADDR_STATE"]=="TRG"){echo "selected";}?>>Terengganu</option>
											</select>
											<small> (State)</small></
										</td>
									</tr>
									<tr>
										<td></td>
										<td><input type="text" name="comp_addr_postcode" value="<?php if($row2["COMP_ADDR_POST"]==0){echo "";} else {echo $row2["COMP_ADDR_POST"];}?>" placeholder="71010" style="width:450px;" oninput="check_postcode();"/><small> (Post Code)</small><span id="PostcodeError" class="red" >&nbsp;</span></td>
									</tr>
									<tr>
										<td style="text-align:right;padding-right:10px;">Content<span class="red">*</span></td>
										<td style="padding-left:10px;"><textarea name="comp_content" id="editor1"><?php echo $row2["COMP_DETAIL"];?></textarea></td>
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
								<div id="editcompany-btn">
									<input type="submit" name="savebtn" value="Save Changes"
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
if (isset($_POST["savebtn"]))
{
	//Upload image
	$comp_img= addslashes($_FILES['comp_pic']['tmp_name']);
    $img_name= addslashes($_FILES['comp_pic']['name']);
    $comp_img= file_get_contents($comp_img);
    $comp_img= base64_encode($comp_img);
    //saveimage($name,$image);
	//END: Upload image
	
	$name	  = $_POST["comp_name"];
	$phone	  = $_POST["comp_phone"];
	$email	  = $_POST["comp_email"];
	$street	  = $_POST["comp_addr_no"];
	$city	  = $_POST["comp_addr_city"];
	$state	  = $_POST["comp_addr_state"];
	$postcode = $_POST["comp_addr_postcode"];
	$content  = $_POST["comp_content"];
	
	?>
		<script>
		if (validate())
		{
			<?php
			if($img_name!="")
			{
				//Update company table
				$comp_table   = "company";
				$update_table = "UPDATE $comp_table SET COMP_NAME='$name', COMP_IMGNAME='$img_name', COMP_IMG='$comp_img', COMP_DETAIL='$content', COMP_ADDR_STREET='$street', COMP_ADDR_CITY='$city', COMP_ADDR_STATE='$state', COMP_ADDR_POST='$postcode', COMP_PHONE='$phone', COMP_EMAIL='$email' where COMP_ID='$admin_comp'";
				mysqli_query($conn, $update_table);
				header("Location: view_company_detail.php");
				
				mysqli_close($conn);
			}
			else
			{
				$comp_table   = "company";
				$update_table = "UPDATE $comp_table SET COMP_NAME='$name', COMP_DETAIL='$content', COMP_ADDR_STREET='$street', COMP_ADDR_CITY='$city', COMP_ADDR_STATE='$state', COMP_ADDR_POST='$postcode', COMP_PHONE='$phone', COMP_EMAIL='$email' where COMP_ID='$admin_comp'";
				mysqli_query($conn, $update_table);
				header("Location: view_company_detail.php");
			}
			?>
		}
		</script>
	<?php
}

?>
