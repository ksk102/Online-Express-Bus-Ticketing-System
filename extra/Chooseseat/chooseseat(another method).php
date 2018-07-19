<html>

	<head>
		<!--must have-->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>

		<script>
		$(document).ready(function(e) {
			var count=0;
		var seatcount=0;
		var adult;
			$('#seatselect .valid').toggle(
			function(){$(this).fadeTo('medium',0.35,function(){
				count++;
				seatcount=0;
				if(count>0)
					$("input[name=paxqty]").removeAttr("disabled");
				var a = $(this).attr('id');
				var c = $(this).attr('class');
				if(c=="gs valid")
				{
					$(this).append("<input type='hidden' name='seat' class='gseat' value='"+ a +"'>");
				}
				else if(c=="rs valid")
				{
					$(this).append("<input type='hidden' name='seat' class='rseat' value='"+ a +"'>");
				}
				$('#sseat').empty();
				total = $("input[type=hidden]").length;
				x=$("input[type=hidden]").serializeArray();
				$.each(x, function(i, field){
					seatcount++;
					if(i===total-1)
					$('#sseat').append(field.value);
					else
					$('#sseat').append(field.value + ',');
				});
			})},
			function(){$(this).fadeTo('medium',1,function(){
				count--;
				seatcount--;
				if(count<=0)
					$("input[name=paxqty]").prop("disabled",true);
				$(this).find('input').remove();
				$('#sseat').empty();
				total = $("input[type=hidden]").length;
				x=$("input[type=hidden]").serializeArray();
				$.each(x, function(i, field){
					if(i===total-1)
					$('#sseat').append(field.value);
					else
					$('#sseat').append(field.value + ',');
				});
				});
			});
			$("#next3").click(function(e) {
				var i = 0; var num=0;
				x=$("input[name=seat]").serializeArray();
				$.each(x, function(i, field){
					i=i+1;
					num=i;
					$('#tt').append(field.name + i + "=" + field.value + "&");
				});
				var iptnm = $.find("input[type=hidden]").length;
				$("#iptnm2").val(iptnm);
				var b = $("#tt").text()+"nm="+num;
				$("#tt2").val(b);
				
				var checkseat = $.find('input[type=hidden]').length;
				if(checkseat==0)
				{
					alert("Please select at least 1 seat to proceed.");
				}
				else
				{
					var adult = +$("#adultqty").val();
					
					if((adult)!=seatcount)
					{
						alert("The adult quantity you've enter doesn't match the total seats you've selected.");
					}
					else if((adult)==seatcount)
					{
						if(adult!='' )
						{
							adult2 = adult;
							
						}
						else if(adult=='' )
						{
							adult2 = 0;
							
						}
						else if(adult!='')
						{
							adult2 = adult;
							
						}
						else if(adult==0)
						{
							adult2 = seatcount;
							
						}
										alert("Your seat has confirm.");
						$.ajax({
								type:"POST",
								url:"updatesession2.php",
								data:{adult:adult2},
								success: function(data){
									var tseat = $("#sseat").text();
									$.ajax({
										type:'POST',
										url:"updatesession.php",
										data:"totalseat="+tseat,
										success: function(data){
											if(data==1)
											{
												var det = $("#tt2").val();


											}
										}
									});
								}
						});
					}
				}
			});
			
		});
		</script>


		<style type="text/css">
			table
			{
			font-family:arial narrow;
			font-size:17px;
			margin-left:50px;
			margin-right:5px;
			margin-top:40px;
			margin-bottom:50px;
			border-collapse:collapse;

			}

			table th
			{
			background:#262626;
			color:#FFA319;
			padding:10px;
			}

			table td
			{
			background:#FFD699;
			text-align:center;
			}
		</style>

	</head>
<body>
   	<div id="left">
		<table id="seatselect">
			<?php 
			$i=$_SESSION["scheid"];
			$bus=mysql_query("select * from bus,schedule where bus.bus_id= schedule.bus_id and schedule_id =$i");
			$rows=mysql_fetch_assoc($bus);
			$busno =$rows["bus_car_no"];

			$result = mysql_query("select * from seat where bus_car_no='$busno' and schedule_id=$i");

			$seat=array();
			$seatm=array();
			while($row=mysql_fetch_assoc($result))
			{
				$s=$row['seats'];
				$seat[]=$s;
			}
										
			$seatno=1;
			$count=1;
			while($seatno<=30)
			{
				if($count>3)
				{
					echo "</tr><tr>";
					$count=1;
				}
				$class='gs valid';
				foreach($seat as $st)
				{
					if($st==$seatno)
					$class='gs booked';
				}
				foreach($seatm as $stm)
											{
												if($stm==$seatno)
													$class='maintenance';
											}
					echo "<td align='center' class='".$class."' id='".$seatno."'>".$seatno."</td>";
					if($seatno==1 || $seatno==4 || $seatno==7 || $seatno==10 || $seatno==13 || $seatno==16 || $seatno==19 || $seatno==22 || $seatno==25 || $seatno==28)
					{
						echo "<td width='15' style='background:transparent;'></td>";
					}
						$count++;
						$seatno++;
			}
			?>
        </table>
    </div>
                            
	<div id="right">
		<form name="add" method="POST" action="">
			<table>
				<tr>
					<td>Seat(s)</td>
					<td>:</td>
					<td id="sseat"></td>
				</tr>
				<tr>
					<td>Adult</td>
					<td>:</td>
					<td><input type="number" name="paxqty" id="adultqty" disabled="disabled" style="width:60px;padding:2px;" ></td>
				</tr>
	   
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td style="font-size:8pt;font-style:italic;"><span style="color:#FF0000;">Note :</span><br />Please specify how many<br /> adult and children.</td>
				</tr>
			</table>
		</form>
	</div>
</body>

</html>
