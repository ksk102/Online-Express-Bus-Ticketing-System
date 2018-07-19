<link href="css-folder/booknavi.css" rel="stylesheet" type="text/css"/>

<div id="book-step">
	<ol class="breadcrumb-body">
		<?php if(strpos($_SERVER['REQUEST_URI'],"search_ticket.php")){echo "<li class='current'>";} else if((strpos($_SERVER['REQUEST_URI'],"search_result.php") || strpos($_SERVER['REQUEST_URI'],"chooseseat.php"))||(strpos($_SERVER['REQUEST_URI'],"payment.php"))||(strpos($_SERVER['REQUEST_URI'],"ticket-summary.php"))){echo "<li class='past'>";} else {echo "<li class='future disable'>";}?>
			<div class="breadcrumb-stage-name">Search Ticket</div>
			<div class="breadcrumb-stage-container">
					<a href="search_ticket.php">
						<div class="breadcrumb-stage">1</div>
					</a>    
				
				<div class="breadcrumb-dots">........</div>
			</div>
		</li>

		<?php if(strpos($_SERVER['REQUEST_URI'],"search_result.php")){echo "<li class='current'>";} else if((strpos($_SERVER['REQUEST_URI'],"chooseseat.php"))||(strpos($_SERVER['REQUEST_URI'],"payment.php"))||(strpos($_SERVER['REQUEST_URI'],"ticket-summary.php"))){echo "<li class='past'>";} else {echo "<li class='future disable'>";}?>
			<div class="breadcrumb-stage-name">Select Bus</div>
			<div class="breadcrumb-stage-container">
					<?php if(strpos($_SERVER['REQUEST_URI'],"search_result.php")){echo "<a style='cursor:pointer;' onclick='reload()'>";} else if(strpos($_SERVER['REQUEST_URI'],"chooseseat.php")){echo "<a style='cursor:pointer;' onclick='goBack()'>";} else if(strpos($_SERVER['REQUEST_URI'],"ticket-summary.php")){echo "<a style='cursor:pointer;' onclick='goBack2()'>";} else if(strpos($_SERVER['REQUEST_URI'],"payment.php")){echo "<a style='cursor:pointer;' onclick='goBack3()'>";} else {echo "<div>";}?>
					<script>
						function goBack() {window.history.back();}
						function goBack2() {window.history.go(-2);}
						function goBack3() {window.history.go(-3);}
						function reload() {location.reload();}
					</script>
						<div class="breadcrumb-stage">2</div>
					<?php if(strpos($_SERVER['REQUEST_URI'],"search_result.php")|| strpos($_SERVER['REQUEST_URI'],"chooseseat.php") || (strpos($_SERVER['REQUEST_URI'],"ticket-summary.php"))||(strpos($_SERVER['REQUEST_URI'],"payment.php"))){echo "</a>";}  else {echo "</div>";}?>
				
				<div class="breadcrumb-dots">........</div>
			</div>
		</li>


		<?php if(strpos($_SERVER['REQUEST_URI'],"chooseseat.php")){echo "<li class='current'>";} else if((strpos($_SERVER['REQUEST_URI'],"payment.php"))||(strpos($_SERVER['REQUEST_URI'],"ticket-summary.php"))){echo "<li class='past'>";} else {echo "<li class='future disable'>";}?>
			<div class="breadcrumb-stage-name">Select Seat(s)</div>
			<div class="breadcrumb-stage-container">
					<?php if(strpos($_SERVER['REQUEST_URI'],"chooseseat.php")){echo "<a style='cursor:pointer;' onclick='reload()'>";} else if(strpos($_SERVER['REQUEST_URI'],"ticket-summary.php")){echo "<a style='cursor:pointer;' onclick='goBack()'>";} else if(strpos($_SERVER['REQUEST_URI'],"payment.php")){echo "<a style='cursor:pointer;' onclick='goBack2()'>";} else {echo "<div>";}?>
					<script>
						function goBack() {window.history.back();}
						function goBack2() {window.history.go(-2);}
						function reload() {location.reload();}
					</script>
						<div class="breadcrumb-stage">3</div>
					<?php if((strpos($_SERVER['REQUEST_URI'],"chooseseat.php"))||(strpos($_SERVER['REQUEST_URI'],"ticket-summary.php"))||(strpos($_SERVER['REQUEST_URI'],"payment.php"))){echo "</a>";} else {echo "</div>";}?>
				
				<div class="breadcrumb-dots">........</div>
			</div>
		</li>


		<?php if(strpos($_SERVER['REQUEST_URI'],"ticket-summary.php")){echo "<li class='current'>";} else if(strpos($_SERVER['REQUEST_URI'],"payment.php")){echo "<li class='past'>";} else {echo "<li class='future disable'>";}?>
			<div class="breadcrumb-stage-name">Summary</div>
			<div class="breadcrumb-stage-container">
					<?php if(strpos($_SERVER['REQUEST_URI'],"ticket-summary.php")){echo "<a style='cursor:pointer;' onclick='reload()'>";} else if(strpos($_SERVER['REQUEST_URI'],"payment.php")){echo "<a style='cursor:pointer;' onclick='goBack()'>";} else {echo "<div>";}?>
					<script>
						function goBack() {window.history.back();}
						function reload() {location.reload();}
					</script>
						<div class="breadcrumb-stage">4</div>
					<?php if((strpos($_SERVER['REQUEST_URI'],"ticket-summary.php"))||(strpos($_SERVER['REQUEST_URI'],"payment.php"))){echo "</a>";} else {echo "</div>";}?>
				<div class="breadcrumb-dots">........</div>
			</div>
		</li>


		<?php if(strpos($_SERVER['REQUEST_URI'],"payment.php")){echo "<li class='current'>";} else {echo "<li class='future disable'>";}?>
			<div class="breadcrumb-stage-name">Payment</div>
			<div class="breadcrumb-stage-container">
					<?php if(strpos($_SERVER['REQUEST_URI'],"payment.php")){echo "<a style='cursor:pointer;' onclick='reload()'>";} else {echo "<div>";}?>
					<script>
						function goBack() {window.history.back();}
						function reload() {location.reload();}
					</script>
						<div class="breadcrumb-stage">5</div>
					<?php if(strpos($_SERVER['REQUEST_URI'],"payment.php")){echo "</a>";} else {echo "</div>";}?>
			</div>
		</li>
	</ol>
</div>