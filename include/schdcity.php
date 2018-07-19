<!DOCTYPE html>
<html>
	<body>
		<?php
		$q = strval($_GET['q']);
		require '../database/db_con.php'; 
		$sql_departcity		= "select * from cityname where (SUBSTR(CITY_FOUR,1,1)) = '".$q."' order by CITY_FOUR";
		$result_departcity	= mysqli_query($conn, $sql_departcity);
		
		echo '<option value="none" selected>--Select a City--</option>';
		while ($row = mysqli_fetch_array($result_departcity))
		{
			$departcityfour=$row["CITY_FOUR"];
			
			?>
			<option value="<?php echo $departcityfour; ?>"><?php echo $row["CITY_FULL"]; ?></option>
			<?php
		}
		?>
				
	</body>
</html>