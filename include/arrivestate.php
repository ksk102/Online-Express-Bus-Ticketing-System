<!DOCTYPE html>
<html>
	<body>
		<?php
		$q = strval($_GET['q']);
		require '../database/db_con.php'; 
		$sql_arrive		= "Select * from schedule where SCH_PICK = '".$q."' group by (SUBSTR(SCH_DROP,1,1)) order by CASE (SUBSTR(SCH_DROP,1,1)) WHEN 'W' Then 1 WHEN 'J' Then 2 WHEN 'K' Then 3 WHEN 'D' Then 4 WHEN 'M' Then 5 WHEN 'N' Then 6 WHEN 'C' Then 7 WHEN 'A' Then 8 WHEN 'R' Then 9 WHEN 'P' Then 10 WHEN 'B' Then 11 WHEN 'T' Then 12 END";
		$result_arrive	= mysqli_query($conn, $sql_arrive);

		echo "<option value='none' selected>--Select a State--</option>";
		$dropoff = Array();
		while ($row = mysqli_fetch_array($result_arrive))
		{
			$dropoff[] = $row['SCH_DROP'];
		}
		?>
		<?php foreach ($dropoff as $value)
		{
		?>
		<?php if (substr($value,0,1)== "W"){echo '<option value="W">Kuala Lumpur</option>';}?>
		<?php if (substr($value,0,1)== "J"){echo '<option value="J">Johor</option>';}?>
		<?php if (substr($value,0,1)== "K"){echo '<option value="K">Kedah</option>';}?>
		<?php if (substr($value,0,1)== "D"){echo '<option value="D">Kelantan</option>';}?>
		<?php if (substr($value,0,1)== "M"){echo '<option value="M">Malacca</option>';}?>
		<?php if (substr($value,0,1)== "N"){echo '<option value="N">Negeri Sembilan</option>';}?>
		<?php if (substr($value,0,1)== "C"){echo '<option value="C">Pahang</option>';}?>
		<?php if (substr($value,0,1)== "A"){echo '<option value="A">Perak</option>';}?>
		<?php if (substr($value,0,1)== "R"){echo '<option value="R">Perlis</option>';}?>
		<?php if (substr($value,0,1)== "P"){echo '<option value="P">Pulau Pinang</option>';}?>
		<?php if (substr($value,0,1)== "B"){echo '<option value="B">Selangor</option>';}?>
		<?php if (substr($value,0,1)== "T"){echo '<option value="T">Terengganu</option>';}?>
		<?php
		}
		?>
	</body>
</html>