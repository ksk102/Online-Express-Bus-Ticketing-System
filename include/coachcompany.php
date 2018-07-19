<!DOCTYPE html>
<html>
	<body>
		<?php
		$q = strval($_GET['q']);
		$p = strval($_GET['p']);
		require '../database/db_con.php'; 
		$sql_company		= "select * from schedule where SCH_DROP = '".$q."' and SCH_PICK = '".$p."' group by COMP_ID order by COMP_ID";
		$result_company	= mysqli_query($conn, $sql_company);
		
		echo '<option value="any">Any Company</option>';
		while ($row = mysqli_fetch_array($result_company))
		{
			$companyid=$row["COMP_ID"];
			
			$sql_companyname		= "SELECT * FROM company,schedule WHERE company.COMP_ID = '$companyid' group by company.COMP_NAME";
			$result_companyname	= mysqli_query($conn, $sql_companyname);
			
			while ($row = mysqli_fetch_array($result_companyname))
			{
			?>
			<option value="<?php echo $companyid; ?>"><?php echo $row['COMP_NAME']; ?></option>
			<?php
			}
		}
		?>
				
	</body>
</html>