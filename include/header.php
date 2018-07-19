<?php 

require 'database/db_con.php';
if(isset($_SESSION['sess_uid']))
{
	$userid=$_SESSION["sess_uid"];
	$username = $_SESSION["sess_uname"];
}
?>

<link href="css-folder/header.css" rel="stylesheet" type="text/css"/>
<div id="header">
	<div id="header-left">
		<a href="index.php" target="_self"><img src="images/busforall-logo.jpg" height="100px" weight="190px" alt="logo" title="Home"/></a>
	</div>
	<?php
	if(!isset($_SESSION['login_user']))
	{
	?>
		<div id="header-right">
			<a href="signup.php" target="_self">Sign up</a>
		</div>
		<div id="header-right">
			<div class="links">
				<div id="signin-popup">
					<a href="#signin" data-effect="mfp-zoom-out">Login</a>
				</div>
			</div>
			
		</div>
		<div id="header-navi-wrapper">
			<ul class='header-navi'>
			    <li class='firstnavi <?php if(strpos($_SERVER['REQUEST_URI'],"index.php")){echo "selected";}?>'><a href='index.php'><span>Home</span></a></li>
			   <!--<li class='secondnavi'><a href='#'><span>How to Purchase</span></a></li>-->
			   <li class='thirdnavi <?php if(strpos($_SERVER['REQUEST_URI'],"search_ticket.php")){echo "selected";}?>'><a href='search_ticket.php'><span>Book Ticket</span></a></li>
			   <li class='fourthnavi <?php if((strpos($_SERVER['REQUEST_URI'],"our_partner.php")) || (strpos($_SERVER['REQUEST_URI'],"delima_express_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"kkkl_express_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"trasnasional_express_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"plusliner_express_detail.php"))){echo "selected";}?>'><a href='our_partner.php'><span>Our Partner</span></a></li>
			   <li class='fifthnavi <?php if(strpos($_SERVER['REQUEST_URI'],"about_us.php")){echo "selected";}?>'><a href='about_us.php'><span>About Us</span></a></li>
			   <li class='sixthnavi <?php if(strpos($_SERVER['REQUEST_URI'],"contact_us.php")){echo "selected";}?>'><a href='contact_us.php'><span>Contact Us</span></a></li>
			   <li class='seventhnavi <?php if(strpos($_SERVER['REQUEST_URI'],"FAQ.php")){echo "selected";}?>'><a href='FAQ.php'><span>FAQ</span></a></li>
			</ul>
		</div>
	<?php
	}
	else
	{
	?>
		<div id="header-right" style="margin-left:75px;">
			<a href="logout.php" target="_self" style="margin-left:10px"><img border="0" alt="W3Schools" src="images/icon/Logout-512.png" width="30" height="30">Logout</a>
		</div>
	<?php
	
		if (substr($userid,0,1)== "C")
		{
		?>
			<div id="header-navi-wrapper">
				<ul class='header-navi'>
				   <li class='firstnavi <?php if(strpos($_SERVER['REQUEST_URI'],"index.php")){echo "selected";}?>'><a href='index.php'><span>Home</span></a></li>
				   <li class='secondnavi <?php if((strpos($_SERVER['REQUEST_URI'],"search_ticket.php"))||(strpos($_SERVER['REQUEST_URI'],"search_result.php"))||(strpos($_SERVER['REQUEST_URI'],"chooseseat.php"))||(strpos($_SERVER['REQUEST_URI'],"ticket-summary.php"))||(strpos($_SERVER['REQUEST_URI'],"purchase_summary.php"))){echo "selected";}?>'><a href='search_ticket.php'><span>Book Ticket</span></a></li>
				   <li class='thirdnavi <?php if((strpos($_SERVER['REQUEST_URI'],"user_profile.php"))||(strpos($_SERVER['REQUEST_URI'],"change_password.php"))||(strpos($_SERVER['REQUEST_URI'],"edit_user_profile.php"))){echo "selected";}?>'><a href='user_profile.php'><span><?php echo $username; ?>'s Profile</span></a></li>
				   <li class='fourthnavi <?php if((strpos($_SERVER['REQUEST_URI'],"transaction.php"))||(strpos($_SERVER['REQUEST_URI'],"transaction_detail.php"))){echo "selected";}?>'><a href='transaction.php'><span>Transaction History</span></a></li>
				   <li class='fifthnavi <?php if(strpos($_SERVER['REQUEST_URI'],"contact_us.php")){echo "selected";}?>'><a href='contact_us.php'><span>Contact Us</span></a></li>
				   <li class='sixthnavi <?php if(strpos($_SERVER['REQUEST_URI'],"about_us.php")){echo "selected";}?>'><a href='about_us.php'><span>About Us</span></a></li>
				   <li class='seventhnavi <?php if(strpos($_SERVER['REQUEST_URI'],"faq.php")){echo "selected";}?>'><a href='faq.php'><span>FAQ</span></a></li>
				</ul>
			</div>
		<?php
		}
		else if (substr($userid,0,1)== "S")
		{
		?>
			<div id="header-navi-wrapper">
				<ul class='header-navi'>
				   <li class='firstnavi <?php if(strpos($_SERVER['REQUEST_URI'],"index.php")){echo "selected";}?>'><a href='index.php'><span>Home</span></a></li>
				   <li class='secondnavi <?php if((strpos($_SERVER['REQUEST_URI'],"search_ticket.php"))||(strpos($_SERVER['REQUEST_URI'],"search_result.php"))||(strpos($_SERVER['REQUEST_URI'],"chooseseat.php"))||(strpos($_SERVER['REQUEST_URI'],"ticket-summary.php"))||(strpos($_SERVER['REQUEST_URI'],"purchase_summary.php"))){echo "selected";}?>'><a href='search_ticket.php'><span>Book Ticket</span></a></li>
				   <li class='thirdnavi <?php if((strpos($_SERVER['REQUEST_URI'],"staff_profile.php"))||(strpos($_SERVER['REQUEST_URI'],"change_password.php"))||(strpos($_SERVER['REQUEST_URI'],"edit_staff_profile.php"))){echo "selected";}?>'><a href='staff_profile.php'><span><?php echo $username; ?>'s Profile</span></a></li>
				   <li class='fourthnavi <?php if((strpos($_SERVER['REQUEST_URI'],"transaction.php"))||(strpos($_SERVER['REQUEST_URI'],"transaction_detail.php"))){echo "selected";}?>'><a href='transaction.php'><span>Transaction History</span></a></li>
				   <li class='fifthnavi <?php if((strpos($_SERVER['REQUEST_URI'],"staff_view_schedule.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_schedule.php")) || (strpos($_SERVER['REQUEST_URI'],"staff_view_schedule_detail.php"))){echo "selected";}?>'><a href='staff_view_schedule.php'><span>Schedule</span></a></li>
				   <li class='sixthnavi <?php if((strpos($_SERVER['REQUEST_URI'],"view_company_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"view_bus.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_branch.php")) || (strpos($_SERVER['REQUEST_URI'],"view_bus_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"sales_report.php")) || (strpos($_SERVER['REQUEST_URI'],"view_branch.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_bus.php")) || (strpos($_SERVER['REQUEST_URI'],"view_branch_detail.php"))){echo "selected";}?>'><a href='view_company_detail.php'><span>Company</span></a></li>
				</ul>
			</div>
		<?php
		}
		else if (substr($userid,0,1)== "A")
		{
		?>
			<div id="header-navi-wrapper">
				<ul class='header-navi'>
				  <li class='firstnavi <?php if(strpos($_SERVER['REQUEST_URI'],"index.php")){echo "selected";}?>'><a href='index.php'><span>Home</span></a></li>
				   <li class='secondnavi <?php if((strpos($_SERVER['REQUEST_URI'],"search_ticket.php"))||(strpos($_SERVER['REQUEST_URI'],"search_result.php"))||(strpos($_SERVER['REQUEST_URI'],"chooseseat.php"))||(strpos($_SERVER['REQUEST_URI'],"ticket-summary.php"))||(strpos($_SERVER['REQUEST_URI'],"purchase_summary.php"))){echo "selected";}?>'><a href='search_ticket.php'><span>Book Ticket</span></a></li>
				   <li class='thirdnavi <?php if((strpos($_SERVER['REQUEST_URI'],"admin_profile.php"))||(strpos($_SERVER['REQUEST_URI'],"change_password.php"))||(strpos($_SERVER['REQUEST_URI'],"edit_admin_profile.php"))){echo "selected";}?>'><a href='admin_profile.php'><span><?php echo $username; ?>'s Profile</span></a></li>
				   <li class='fourthnavi <?php if((strpos($_SERVER['REQUEST_URI'],"view_schedule.php"))||(strpos($_SERVER['REQUEST_URI'],"add_schedule.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_schedule.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_route.php")) || (strpos($_SERVER['REQUEST_URI'],"view_route.php")) || (strpos($_SERVER['REQUEST_URI'],"add_route.php")) || (strpos($_SERVER['REQUEST_URI'],"view_route_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"edit_route.php"))||(strpos($_SERVER['REQUEST_URI'],"edit_schedule.php"))){echo "selected";}?>'><a href='view_schedule.php'><span>Schedule</span></a></li>
				   <li class='fifthnavi <?php if((strpos($_SERVER['REQUEST_URI'],"admin_view_announcement.php"))||(strpos($_SERVER['REQUEST_URI'],"admin_view_announcement_detail.php"))||(strpos($_SERVER['REQUEST_URI'],"filter_announcement.php"))||(strpos($_SERVER['REQUEST_URI'],"add_announcement.php"))||(strpos($_SERVER['REQUEST_URI'],"admin_edit_announcement.php"))){echo "selected";}?>'><a href='admin_view_announcement.php'><span>Announcement</span></a></li>
				   <li class='sixthnavi <?php if((strpos($_SERVER['REQUEST_URI'],"add_staff.php")) || (strpos($_SERVER['REQUEST_URI'],"admin_edit_staff_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"view_staff_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"edit_company_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"view_company_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"add_company_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"view_bus.php")) || (strpos($_SERVER['REQUEST_URI'],"view_bus_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"add_bus.php")) || (strpos($_SERVER['REQUEST_URI'],"edit_bus_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"sales_report.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_staff.php")) || (strpos($_SERVER['REQUEST_URI'],"filter_branch.php")) || (strpos($_SERVER['REQUEST_URI'],"view_branch.php")) || (strpos($_SERVER['REQUEST_URI'],"edit_branch_detail.php")) || (strpos($_SERVER['REQUEST_URI'],"add_branch.php"))|| (strpos($_SERVER['REQUEST_URI'],"transaction_detail.php"))|| (strpos($_SERVER['REQUEST_URI'],"transaction.php"))){echo "selected";}?>'><a href='view_staff_detail.php'><span>Company</span></a></li>
				</ul>
			</div>
		<?php
		}
		else if(substr($userid,0,1) =="Q")
		{
			?>
			<div id="header-navi-wrapper">
				<ul class='header-navi'>
				  <li class='firstnavi <?php if(strpos($_SERVER['REQUEST_URI'],"index.php")){echo "selected";}?>'><a href='index.php'><span>Home</span></a></li>
				  <li class='secondnavi <?php if(strpos($_SERVER['REQUEST_URI'],"add_admin.php")){echo "selected";}?>'><a href='add_admin.php'><span>Add Admin</span></a></li>
				</ul>
			</div>
			<?php
		}
	}
	?>
</div>

<?php include 'include/signinpopup.php';?>