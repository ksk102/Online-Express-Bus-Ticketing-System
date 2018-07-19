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
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="shortcut icon" href="images/icon/step/travel.png"/>
		<title>Add Bus | BusForAll.com</title>
		<link href="css-folder/page-wrapper.css" rel="stylesheet" type="text/css">
		<link href="css-folder/addbus.css" rel="stylesheet" type="text/css">
		
		<script type="text/javascript">
		//Live validation
		function check_vrn()
		{
			if (document.newbus.bus_vrn.value == "" || document.newbus.bus_vrn.value.length < 4)
			{
				document.getElementById('VRNError').innerHTML = ' Enter vehicle registration number';		
				return false;
			}
			else
			{
				document.getElementById('VRNError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		
		function check_ttlseat()
		{
			if (document.newbus.bus_ttlseat.value == "" || isNaN(document.newbus.bus_ttlseat.value))
			{
				document.getElementById('TtlseatError').innerHTML = ' Enter the number of seat in bus';		
				return false;
			}
			else
			{
				document.getElementById('TtlseatError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';	
				return true;
			}
		}
		
		function check_type()
		{
			if (document.newbus.bus_type.value == "" || document.newbus.bus_type.value.length < 2)
			{
				document.getElementById('TypeError').innerHTML = ' Enter the type of bus';		
				return false;
			}
			else
			{
				document.getElementById('TypeError').innerHTML = '<span> </span><img src="images/icon/validation/tick.png" alt="Correct" style="width:22px;height:22px;vertical-align:-7px;">';
				return true;
			}
		}
		
		function validate()
		{
			if (check_vrn() && check_ttlseat() && check_type())
			{
				return true;
			}
			else
			{
				alert("Please check your information again");
				return false;
			}
		}
		//END: Live validation
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
					<div id="newbus-wrapper">
						<div id="newbus-wrapper-title">
							<p>Add New Bus</p>
							<hr/>
						</div>
						<div id="newbusfrm">
							<form name="newbus" id="newbus-form" action="" method="post" onsubmit="return validate();">
								<table>
									<tr>
										<td width="150px">Bus VRN<span class="red">*</span></td>
										<td>
											<input type="text" name="bus_vrn" value="" placeholder="Vehicle registration number" oninput="check_vrn();" onblur="check_vrn();"/><span id="VRNError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>Total Seats<span class="red">*</span></td>
										<td>
											<input type="text" name="bus_ttlseat" value="" placeholder="Number of seats" oninput="check_ttlseat();"/><span id="TtlseatError" class="red">&nbsp;</span>
										</td>
									</tr>
									<tr>
										<td>Bus Type<span class="red">*</span></td>
										<td><input type="text" name="bus_type" placeholder="Type of bus" oninput="check_type();"/><span id="TypeError" class="red">&nbsp;</span></td>
									</tr>
									<tr>
										<td>Company ID<span class="red">*</span></td>
										<td><input type="text" name="comp_id" placeholder="Bus company ID" value="<?php echo $row['COMP_ID'];?>" readonly class="readonly"/></td>
									</tr>
								</table>
								<div id="newbus-btn">
									<input type="submit" name="addbtn" value="Add"/>
								</div>
							</form>
						</div>  
					</div>
				</div>
			</div>
		
			<?php include 'include/btmnavi.php'; ?>
		</div>
	</body>
</html>

<?php
if(isset($_POST["addbtn"]))
{
	$vrn		= $_POST["bus_vrn"];
	$ttlseat	= $_POST["bus_ttlseat"];
	$type		= $_POST["bus_type"];
	$buscomp	= $_POST["comp_id"];
	
	?>
	<script>

	
		<?php
		//Check if the bus exist
		$bus_exist		= "SELECT * from bus where BUS_VRN = '$vrn'";
		$result_exist	= mysqli_query($conn, $bus_exist);
		$count			= mysqli_num_rows($result_exist);
		
		if($count>0)
		{
			?>
				alert("This bus already exist");
			<?php
		}
		else
		{
			//Insert into bus table
			$bus_table	= "bus";
			$sql_insert		= "INSERT into " .$bus_table. "(BUS_VRN, BUS_TTLSEAT, BUS_TYPE, BUS_STATUS, COMP_ID)". "VALUES('$vrn', '$ttlseat', '$type', '0', '$buscomp')";
			mysqli_query($conn, $sql_insert);
			//END: Insert into bus table
		
			
			header("Refresh:0");
		}
		mysqli_close($conn);
		?>
		alert('Bus successfully added'); window.location.href='view_bus.php';
	</script>
	<?php
}
?>
