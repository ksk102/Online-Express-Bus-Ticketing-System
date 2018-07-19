<!DOCTYPE html>
<html>
	<body>
		<?php
		$q = strval($_GET['q']);
		require '../database/db_con.php'; 
		$sql_departcity		= "select * from schedule where (SUBSTR(SCH_PICK,1,1)) = '".$q."' group by SCH_PICK order by SCH_PICK";
		$result_departcity	= mysqli_query($conn, $sql_departcity);
		
		echo '<option value="none" selected>--Select a City--</option>';
		while ($row = mysqli_fetch_array($result_departcity))
		{
			$departcityfour=$row["SCH_PICK"];
			
			$sql_departcityname		= "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$departcityfour' group by cityname.city_FULL";
			$result_departcityname	= mysqli_query($conn, $sql_departcityname);
			
			while ($row = mysqli_fetch_array($result_departcityname))
			{
			?>
			<option value="<?php echo $departcityfour; ?>"><?php echo $row["CITY_FULL"]; ?></option>
			<?php
			}
		}
		?>
				
	</body>
</html>