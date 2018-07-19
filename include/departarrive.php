<?php 
require 'database/db_con.php'; 

$sql_depart		= "SELECT * from schedule group by (SUBSTR(SCH_PICK,1,1)) order by CASE (SUBSTR(SCH_PICK,1,1)) WHEN 'W' Then 1 WHEN 'J' Then 2 WHEN 'K' Then 3 WHEN 'D' Then 4 WHEN 'M' Then 5 WHEN 'N' Then 6 WHEN 'C' Then 7 WHEN 'A' Then 8 WHEN 'R' Then 9 WHEN 'P' Then 10 WHEN 'B' Then 11 WHEN 'T' Then 12 END";
$result_depart	= mysqli_query($conn, $sql_depart);
$pickup = Array();

while ($row = mysqli_fetch_array($result_depart))
{
    $pickup[] = $row['SCH_PICK'];
}
?>														
<div id="content-left-content-form-top">
	<div id="content-left-content-form-top-content">
		<p>Depart From</p>
			<select name="searchdepart" id="searchdepart" size="1" onchange="selectdepartstate(this.value)">
				<option value="none" selected>--Select a State--</option>
				<?php foreach ($pickup as $value)
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
			</select>
			<select id="searchdepartcity" name="searchdepartcity" size="1" onchange="selectdepartcity(this.value)">
				<option value="none" selected>--Select a City--</option>		
			</select>
			<br/>
	</div>
	<div id="content-left-content-form-top-content">
		<p>Arrive To</p>
			<select id="searcharrive" size="1" onchange="selectarrivestate(this.value)">
				<option value='none' selected>--Select a State--</option>
			</select>
			<select id="searcharrivecity" name="searcharrivecity" size="1" onchange="selectarrivecity(this.value)">
				<option value="none" selected>--Select a City--</option>
			</select>
	</div>
</div>