<script>
function selectdepart()
{
		var state;
		/*select * from schedule where (substr(SCH_PICK,0,1)) == $state.value;
			row[SCH_PICK]
		
		*/
		state=document.getElementById('searchdepart');
		if(state.value=="JHR")
		{
			document.getElementById("depart").innerHTML='<select id="searchdepartcity" name="searchdepartcity" size="1" onchange="selectarrivecity(this.value)">'+
															'<option value="none" selected>--Select a City--</option>'+		
															'<option value="JBTP">Batu Pahat</option>'+
															'<option value="JJBS">Johor Bahru Sentral</option>'+
															'<option value="JKLU">Kluang</option>'+
															'<option value="JKTT">Kota Tinggi</option>'+
															'<option value="JLRK">Larkin Bus Terminal</option>'+
															'<option value="JMRS">Mersing</option>'+
															'<option value="JMUR">Muar</option>'+															
															'<option value="JPON">Pontian</option>'+															
															'<option value="JSGM">Segamat</option>'+
															'<option value="JTGK">Tangkak</option>'+
															'<option value="JYPG">Yong Peng</option>'+
														'</select>';
														
														/*$("#searchdepartcity").change(function() {
															var pickupcity = (document.getElementById('searchdepartcity').value);
															//alert(pickupcity);
															$.ajax({
																type: "GET",
																url: 'include/departarrive.php',
																data: { pickupcity : pickupcity },
																success: function(data)
																{
																	alert("123");
																}
															});
														});*/
		}
		
		else
		{
			document.getElementById("depart").innerHTML='<p style="color:red; margin-top:-5px;">No available bus route for this state currently</p>';
		}
}

function selectarrive()
{
	var state;
	
		state=document.getElementById('searcharrive');
		if(state.value=="JHR")
		{
			document.getElementById("arrive").innerHTML='<select name="searcharrivecity" size="1">'+
															'<option value="none" selected>--Select a City--</option>'+		
															'<option value="JBP">Batu Pahat</option>'+
															'<option value="JBS">Johor Bahru Sentral</option>'+
															'<option value="JKLU">Kluang</option>'+
															'<option value="JKT">Kota Tinggi</option>'+
															'<option value="JLRK">Larkin Bus Terminal</option>'+
															'<option value="JMRS">Mersing</option>'+
															'<option value="JMUR">Muar</option>'+															
															'<option value="JPT">Pontian</option>'+															
															'<option value="JSGM">Segamat</option>'+
															'<option value="JTGK">Tangkak</option>'+
															'<option value="JYP">Yong Peng</option>'+
														'</select>';
		}
		
		else
		{
			document.getElementById("arrive").innerHTML='<p style="color:red; margin-top:-5px;">No available bus route for this state currently</p>';
		}
}

function selectdepart1()
{
		var state;
	
		state=document.getElementById('searchdepart1');
		if(state.value=="JHR")
		{
			document.getElementById("depart1").innerHTML='<select name="searchdepartcity" size="1">'+
															'<option value="none" selected>--Select a City--</option>'+		
															'<option value="JBP">Batu Pahat</option>'+
															'<option value="JBS">Johor Bahru Sentral</option>'+
															'<option value="JKLU">Kluang</option>'+
															'<option value="JKT">Kota Tinggi</option>'+
															'<option value="JLRK">Larkin Bus Terminal</option>'+
															'<option value="JMRS">Mersing</option>'+
															'<option value="JMUR">Muar</option>'+															
															'<option value="JPT">Pontian</option>'+															
															'<option value="JSGM">Segamat</option>'+
															'<option value="JTGK">Tangkak</option>'+
															'<option value="JYP">Yong Peng</option>'+
														'</select>';
		}
		
		else
		{
			document.getElementById("depart1").innerHTML='<p style="color:red; margin-top:-5px;">No available bus route for this state currently</p>';
		}
}

function selectarrive1()
{
	var state;
	
		state=document.getElementById('searcharrive1');
		if(state.value=="JHR")
		{
			document.getElementById("arrive1").innerHTML='<select name="searcharrivecity" size="1">'+
															'<option value="none" selected>--Select a City--</option>'+		
															'<option value="JBP">Batu Pahat</option>'+
															'<option value="JBS">Johor Bahru Sentral</option>'+
															'<option value="JKLU">Kluang</option>'+
															'<option value="JKT">Kota Tinggi</option>'+
															'<option value="JLRK">Larkin Bus Terminal</option>'+
															'<option value="JMRS">Mersing</option>'+
															'<option value="JMUR">Muar</option>'+															
															'<option value="JPT">Pontian</option>'+															
															'<option value="JSGM">Segamat</option>'+
															'<option value="JTGK">Tangkak</option>'+
															'<option value="JYP">Yong Peng</option>'+
														'</select>';
		}
		
		else
		{
			document.getElementById("arrive1").innerHTML='<p style="color:red; margin-top:-5px;">No available bus route for this state currently</p>';
		}
}
</script>