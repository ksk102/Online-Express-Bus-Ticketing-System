<?php 

require 'Database/db_con.php';

?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Frequently Asked Question | BusForAll.com</title>
		
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css"/>
		<link href="css-folder/faq.css" rel="stylesheet" type="text/css"/>
	</head>
	
	<body>
		<div id="container">
			<?php
				include 'include/header.php';
			?>
			
			<div id="content">
				<?php include 'include/slider.php'; ?>
				
				<div id="content-wrapper">
						
					<?php include 'include/searchticket.php'; ?>
									
					<div id="content-right">
						<div id="content-right-faq">
							<div id="content-right-faq-title">
								<p>FAQ</p>
							</div>
							<ul id="all-faq">
								<li id="main">
									<div id="faq-title">
										<img src="images/icon/faq/plus-sign-512.png" alt=""/>General
									</div>
									<div id="all-question">
										<ul id="question-list">
											<li>I do not have a printer. Is it a must to take the printout ticket?
											<div id="faq-answer">
												No. It is not compulsory to print out the e-ticket.
											</div>
											</li>
										<!--question-list closing div-->
										</ul>
									</div>
								<!--main closing div-->
								</li>
								<li id="main">
									<div id="faq-title">
										<img src="images/icon/faq/plus-sign-512.png" alt=""/>Payment and Refund
									</div>
									<div id="all-question">
										<ul id="question-list">
											<li>What payment options do you accept?
											<div id="faq-answer">
												Credit and Debit Card (Visa, Mastercard)
											</div>
											</li>
											<li>Does the owner of the credit card, with which the tickets is purchased, need to be one of the passengers?
											<div id="faq-answer">
												No. A passenger can use any card to pay for the ticket, not necessarily his own.
											</div>
											</li>
											<li>Can I get refund on the ticket?
											<div id="faq-answer">
												No. Refund is not applicable once you have comfirm the booking.
											</div>
											</li>
										<!--question-list closing div-->
										</ul>
									</div>
								<!--main closing div-->
								</li>
								<li id="main">
									<div id="faq-title">
										<img src="images/icon/faq/plus-sign-512.png" alt=""/>Manage Booking
									</div>
									<div id="all-question">
										<ul id="question-list">
											<li>I have made my payment, but I did not get my e-ticket from BusForAll.com
											<div id="faq-answer">
												Kindly check your junk mail for the e-ticket. If there is no e-ticket received, kindly contact with us.
											</div>
											</li>
											<li>Do I need to register to make booking in BusForAll?
											<div id="faq-answer">
												Yes. It is compulsory to register in order to make booking.
											<!--question-list closing div-->
											</div>
											</li>
										</ul>
									</div>
								</li>
							<!--all-faq closing div-->
							</ul>
						<!--content-right-faq closing div-->
						</div>
					<!--content-right closing div-->
					</div>
				</div>
			
			</div>
		<?php include 'include/btmnavi.php'; ?>
	</body>
</html>