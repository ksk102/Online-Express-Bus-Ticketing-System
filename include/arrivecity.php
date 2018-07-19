<!DOCTYPE html>
<html>
	<body>
		<?php
		$q = strval($_GET['q']);
		$p = strval($_GET['p']);
		require '../database/db_con.php'; 
		$sql_arrivecity		= "select * from schedule where (SUBSTR(SCH_DROP,1,1)) = '".$q."' and SCH_PICK = '".$p."' group by SCH_DROP order by SCH_DROP";
		$result_arrivecity	= mysqli_query($conn, $sql_arrivecity);
		
		echo '<option value="none" selected>--Select a City--</option>';
		while ($row = mysqli_fetch_array($result_arrivecity))
		{
			$arrivecityfour=$row["SCH_DROP"];
			
			$sql_arrivecityname		= "SELECT * FROM cityname,schedule WHERE cityname.CITY_FOUR = '$arrivecityfour' group by cityname.city_FULL";
			$result_arrivecityname	= mysqli_query($conn, $sql_arrivecityname);
			
			while ($row = mysqli_fetch_array($result_arrivecityname))
			{
			?>
			<option value="<?php echo $arrivecityfour; ?>"><?php echo $row["CITY_FULL"]; ?></option>
			<?php
			}
		}
		?>
				
	</body>
</html>