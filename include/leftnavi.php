<?php 

require 'database/db_con.php';
if(isset($_SESSION['sess_uid']))
{
	$userid=$_SESSION["sess_uid"];
}
?>

<link href="css-folder/leftnavi.css" rel="stylesheet" type="text/css">
<link href="profile_picture/css/style.css" rel="stylesheet">
<script src="profile_picture/js/jquery.min.js"></script>
<script src="profile_picture/js/jquery.form.js"></script>

<style>
	.red { font-size:10pt; font-style:italic; color:red }
</style>
		
		<script>
		$(document).on('change', '#image_upload_file', function () {
		var progressBar = $('.progressBar'), bar = $('.progressBar .bar'), percent = $('.progressBar .percent');

		$('#image_upload_form').ajaxForm({
			beforeSend: function() {
				progressBar.fadeIn();
				var percentVal = '0%';
				bar.width(percentVal)
				percent.html(percentVal);
			},
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal = percentComplete + '%';
				bar.width(percentVal)
				percent.html(percentVal);
			},
			success: function(html, statusText, xhr, $form) {		
				obj = $.parseJSON(html);	
				if(obj.status){		
					var percentVal = '100%';
					bar.width(percentVal)
					percent.html(percentVal);
					$("#imgArea>img").prop('src',obj.image_medium);			
				}else{
					alert(obj.error);
				}
			},
			complete: function(xhr) {
				progressBar.fadeOut();			
			}	
		}).submit();		

		});
		</script>


<?php
	
	if (substr($userid,0,1)== "C")
	{
	?>
		<div id='sidenavi'>
		
			<?php 
			if(strpos($_SERVER['REQUEST_URI'],"edit_user_profile.php"))
			{
			?>
				<div id="imgContainer">
					<form enctype="multipart/form-data" action="profile_picture/image_upload_demo_submit.php" method="post" name="image_upload_form" id="image_upload_form">
						<div id="imgArea"><img src='<?php if($row["CUST_PIC"]==""){ echo "profile_picture/img/default.jpg";} else {echo $row["CUST_PIC"];} ?>'/>
							<div class="progressBar">
								<div class="bar"></div>
								<div class="percent">0%</div>
							</div>
							<div id="imgChange"><span>Change Photo</span>
								<input type="file" accept="image/*" name="image_upload_file" id="image_upload_file">
							</div>
						</div>
					</form>
				</div>
			<?php
			}
			else
			{
			?>
				<a href="user_profile.php" target="_self">
					<div id="img-wrapper">
						<img src='<?php if($row["CUST_PIC"]==""){ echo "profile_picture/img/default.jpg";} else {echo $row["CUST_PIC"];} ?>'>
						<p>
						<?php echo $row["CUST_NAME"];?> 
						</p>
					</div>
				</a>
			<?php
			}
			?>
			
			<?php
			if((strpos($_SERVER['REQUEST_URI'],"user_profile.php")) || (strpos($_SERVER['REQUEST_URI'],"edit_user_profile.php")) || (strpos($_SERVER['REQUEST_URI'],"change_password.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_announcement.php")) || (strpos($_SERVER['REQUEST_URI'],"transaction.php")) || (strpos($_SERVER['REQUEST_URI'],"user_view_announcement.php")) || (strpos($_SERVER['REQUEST_URI'],"user_view_announcement_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"staff_profile.php")) || (strpos($_SERVER['REQUEST_URI'],"staff_edit_announcement.php")) || (strpos($_SERVER['REQUEST_URI'],"about_us.php")) || (strpos($_SERVER['REQUEST_URI'],"contact_us.php"))||(strpos($_SERVER['REQUEST_URI'],"transaction_detail.php")))
			{
			?>
			<div id="sidenavi-content">
				<a href="user_profile.php" target="_self"><div id="sidenavi-content-choices" class="first"><img src="images/icon/signedin/view.png"></br>View Profile</div></a>
				<a href="edit_user_profile.php" target="_self"><div id="sidenavi-content-choices" class="second"><img src="images/icon/signedin/edit.png"></br>Edit Profile</div></a>
				<a href="transaction.php" target="_self"><div id="sidenavi-content-choices" class="third"><img src="images/icon/signedin/transaction.png"></br>Transaction History</div></a>
				<a href="search_ticket.php" target="_self"><div id="sidenavi-content-choices" class="fourth"><img src="images/icon/signedin/book.png"></br>Book Ticket</div></a>
				<a href="about_us.php" target="_self"><div id="sidenavi-content-choices" class="fifth"><img src="images/icon/signedin/aboutus.png"></br>About Us</div></a>
				<a href="contact_us.php" target="_self"><div id="sidenavi-content-choices" class="sixth"><img src="images/icon/signedin/contactus.png"></br>Contact Us</div></a>
			</div>
			<?php
			}
			?>
		</div>
	<?php
	}
	else if (substr($userid,0,1)== "S")
	{
	?>
		<div id='sidenavi'>
			<?php 
			if(strpos($_SERVER['REQUEST_URI'],"edit_staff_profile.php"))
			{
			?>
				<div id="imgContainer">
					<form enctype="multipart/form-data" action="profile_picture/image_upload_demo_submit.php" method="post" name="image_upload_form" id="image_upload_form">
						<div id="imgArea"><img src='<?php if($row["STAFF_PIC"]==""){ echo "profile_picture/img/default.jpg";} else {echo $row["STAFF_PIC"];} ?>'/>
							<div class="progressBar">
								<div class="bar"></div>
								<div class="percent">0%</div>
							</div>
							<div id="imgChange"><span>Change Photo</span>
								<input type="file" accept="image/*" name="image_upload_file" id="image_upload_file">
							</div>
						</div>
					</form>
				</div>
			<?php
			}
			else
			{
			?>
				<a href="staff_profile.php" target="_self">
					<div id="img-wrapper">
						<img src='<?php if($row["STAFF_PIC"]==""){ echo "profile_picture/img/default.jpg";} else {echo $row["STAFF_PIC"];} ?>'>
						<p>
						<?php echo $row["STAFF_NAME"];?> 
						</p>
					</div>
				</a>
			<?php
			}
			
			if((strpos($_SERVER['REQUEST_URI'],"staff_view_schedule.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_schedule.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_announcement.php")) || (strpos($_SERVER['REQUEST_URI'],"staff_add_announcement.php")) || (strpos($_SERVER['REQUEST_URI'],"change_password.php")) || (strpos($_SERVER['REQUEST_URI'],"staff_view_announcement.php")) || (strpos($_SERVER['REQUEST_URI'],"staff_view_announcement_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"staff_profile.php")) || (strpos($_SERVER['REQUEST_URI'],"staff_edit_announcement.php")) || (strpos($_SERVER['REQUEST_URI'],"transaction.php")) || (strpos($_SERVER['REQUEST_URI'],"staff_view_schedule_detail.php"))||(strpos($_SERVER['REQUEST_URI'],"transaction_detail.php")))
			{
			?>
			<div id="sidenavi-content">
				<a href="staff_profile.php" target="_self"><div id="sidenavi-content-choices" class="first"><img src="images/icon/signedin/profile.png"></br>View Profile</div></a>
				<a href="transaction.php" target="_self"><div id="sidenavi-content-choices" class="second"><img src="images/icon/signedin/transaction.png"></br>Transaction History</div></a>
				<a href="staff_view_schedule.php" target="_self"><div id="sidenavi-content-choices" class="third"><img src="images/icon/signedin/schedule.png"></br>View Schedule</div></a>
				<a href="search_ticket.php" target="_self"><div id="sidenavi-content-choices" class="fourth"><img src="images/icon/signedin/book.png"></br>Book Ticket</div></a>
				<a href="staff_view_announcement.php" target="_self"><div id="sidenavi-content-choices" class="fifth"><img src="images/icon/signedin/announcement.png"></br>View Announcement</div></a>
				<a href="staff_add_announcement.php" target="_self"><div id="sidenavi-content-choices" class="sixth"><img src="images/icon/signedin/announcement.png"></br>Add Announcement</div></a>
			</div>
			<?php
			}
			else if((strpos($_SERVER['REQUEST_URI'],"view_branch_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"view_bus.php")) || (strpos($_SERVER['REQUEST_URI'],"view_bus_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_bus.php")) || (strpos($_SERVER['REQUEST_URI'],"view_company_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"view_branch.php")) || (strpos($_SERVER['REQUEST_URI'],"view_branch_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_branch.php")) || (strpos($_SERVER['REQUEST_URI'],"sales_report.php")))
			{
			?>
			<div id="sidenavi-content">
				<a href="view_company_detail.php" target="_self"><div id="sidenavi-content-choices" class="first"><img src="images/icon/signedin/company.png"></br>View Company Details</div></a>
				<a href="view_branch.php" target="_self"><div id="sidenavi-content-choices" class="second"><img src="images/icon/signedin/counter.png"></br>View Branch Details</div></a>
				<a href="view_bus.php" target="_self"><div id="sidenavi-content-choices" class="third"><img src="images/icon/signedin/bus.png"></br>View Bus Details</div></a>
				<!--<a href="sales_report.php" target="_self"><div id="sidenavi-content-choices" class="fifth"><img src="images/icon/signedin/report.png"></br>View Sales Report</div></a>-->
			</div>
			
			<?php
			}
			?>
		</div>
	<?php
	}
	else if (substr($userid,0,1)== "A")
	{
	?>
		<div id='sidenavi'>
			<?php 
			if(strpos($_SERVER['REQUEST_URI'],"edit_admin_profile.php"))
			{
			?>
				<div id="imgContainer">
					<form enctype="multipart/form-data" action="profile_picture/image_upload_demo_submit.php" method="post" name="image_upload_form" id="image_upload_form">
						<div id="imgArea"><img src='<?php if($row["ADMIN_PIC"]==""){ echo "profile_picture/img/default.jpg";} else {echo $row["ADMIN_PIC"];} ?>'>
							<div class="progressBar">
								<div class="bar"></div>
								<div class="percent">0%</div>
							</div>
							<div id="imgChange"><span>Change Photo</span>
								<input type="file" accept="image/*" name="image_upload_file" id="image_upload_file">
							</div>
						</div>
					</form>
				</div>
			<?php
			}
			else
			{
			?>
				<a href="admin_profile.php" target="_self">
					<div id="img-wrapper">
						<img src='<?php if($row["ADMIN_PIC"]==""){ echo "profile_picture/img/default.jpg";} else {echo $row["ADMIN_PIC"];} ?>'>
						<p>
						<?php echo $row["ADMIN_NAME"];?> 
						</p>
					</div>
				</a>
			<?php
			}
			if((strpos($_SERVER['REQUEST_URI'],"view_schedule.php")) || (strpos($_SERVER['REQUEST_URI'],"add_announcement.php")) || (strpos($_SERVER['REQUEST_URI'],"admin_view_announcement.php")) || (strpos($_SERVER['REQUEST_URI'],"admin_view_announcement_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"add_schedule.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_route.php")) || (strpos($_SERVER['REQUEST_URI'],"edit_schedule.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_announcement.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_schedule.php")) || (strpos($_SERVER['REQUEST_URI'],"change_password.php"))|| (strpos($_SERVER['REQUEST_URI'],"admin_view_schedule_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"view_route.php")) || (strpos($_SERVER['REQUEST_URI'],"add_route.php")) || (strpos($_SERVER['REQUEST_URI'],"view_route_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"edit_route.php")) || (strpos($_SERVER['REQUEST_URI'],"admin_profile.php")) || (strpos($_SERVER['REQUEST_URI'],"admin_edit_announcement.php")))
			{
			?>
			<div id="sidenavi-content">
				<a href="view_schedule.php" target="_self"><div id="sidenavi-content-choices" class="first"><img src="images/icon/signedin/schedule.png"></br>View Schedules</div></a>
				<a href="add_schedule.php" target="_self"><div id="sidenavi-content-choices" class="second"><img src="images/icon/signedin/schedule.png"></br>Add Schedule</div></a>
				<a href="admin_view_announcement.php" target="_self"><div id="sidenavi-content-choices" class="fifth"><img src="images/icon/signedin/announcement.png"></br>View Announcement</div></a>
				<a href="add_announcement.php" target="_self"><div id="sidenavi-content-choices" class="sixth"><img src="images/icon/signedin/announcement.png"></br>Add Announcement</div></a>
				<a href="view_route.php" target="_self"><div id="sidenavi-content-choices" class="third"><img src="images/icon/signedin/route.png"></br>View Routes</div></a>
			</div>
			<?php
			}
			else if((strpos($_SERVER['REQUEST_URI'],"add_branch.php")) || (strpos($_SERVER['REQUEST_URI'],"add_staff.php")) || (strpos($_SERVER['REQUEST_URI'],"view_branch_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_branch.php")) || (strpos($_SERVER['REQUEST_URI'],"view_bus.php")) || (strpos($_SERVER['REQUEST_URI'],"view_bus_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"edit_bus_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"add_bus.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_bus.php")) || (strpos($_SERVER['REQUEST_URI'],"view_company_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"view_staff_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_staff.php")) || (strpos($_SERVER['REQUEST_URI'],"admin_edit_staff_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"edit_company_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"edit_branch_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"view_branch.php")) || (strpos($_SERVER['REQUEST_URI'],"view_branch_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"add_company_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"sales_report.php"))|| (strpos($_SERVER['REQUEST_URI'],"transaction.php")) || (strpos($_SERVER['REQUEST_URI'],"transaction_detail.php")))
			{
			?>
			<div id="sidenavi-content">
				<a href="view_company_detail.php" target="_self"><div id="sidenavi-content-choices" class="first"><img src="images/icon/signedin/company.png"></br>View Company Details</div></a>
				<a href="view_branch.php" target="_self"><div id="sidenavi-content-choices" class="second"><img src="images/icon/signedin/counter.png"></br>View Branch Details</div></a>
				<a href="view_bus.php" target="_self"><div id="sidenavi-content-choices" class="third"><img src="images/icon/signedin/bus.png"></br>View Bus Details</div></a>
				<a href="view_staff_detail.php" target="_self"><div id="sidenavi-content-choices" class="fourth"><img src="images/icon/signedin/staff.png"></br>View Staff Details</div></a>
				<a href="transaction.php" target="_self"><div id="sidenavi-content-choices" class="fifth"><img src="images/icon/signedin/transaction.png"></br>Transaction History</div></a>
				<!--<a href="sales_report.php" target="_self"><div id="sidenavi-content-choices" class="fifth"><img src="images/icon/signedin/report.png"></br>View Sales Report</div></a>-->
			</div>
			
			<?php
			}
			?>
		</div>
	<?php
	}
?>