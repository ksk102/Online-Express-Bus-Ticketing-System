<link href="css-folder/chooseseat.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.8.3.js"></script>
<div id="signin" class="signin-popup mfp-with-anim mfp-hide">
<div id="test-popup" class="announcement-popup mfp-with-anim mfp-hide">
<div id="maincontent">
	<div id="holder"> 
		<ul  id="place">
		</ul>    
	</div>
	<div id="seatdes"> 
		<ul id="seatDescription">
			<li style="background:url('images/seatselection/availableseatsicon.png') no-repeat scroll 0 0 transparent;">Available Seat</li>
			<li style="background:url('images/seatselection/bookedseatsicon.png') no-repeat scroll 0 0 transparent;">Booked Seat</li>
			<li style="background:url('images/seatselection/selectedseatsicon.png') no-repeat scroll 0 0 transparent;">Selected Seat</li>
		</ul>
	</div>
	<div id="seatselected">
		<table>
			<tr>
				<td>Seat(s)</td>
				<td>:</td>
				<td id="sseat"></td>
			</tr>
			<tr>
				<td>Child(s)</td>
				<td>:</td>
				<td><input type="number" name="paxqty" id="adultqty" disabled="disabled" style="width:60px;padding:2px;" ></td>
			</tr>
   
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="font-size:8pt;font-style:italic;"><span style="color:#FF0000;">Note :</span><br />Please specify how many<br /> children below 12-year-old.</td>
			</tr>
		</table>
	</div>
	<div id="continuebtn">
		<input type="submit" name="confirmbtn" value="Continue"/>
	</div>
</div>
</div>
</div>

<script>
var settings = {
	   rows: 3,
	   cols: 10,
	   rowCssPrefix: 'row-',
	   colCssPrefix: 'col-',
	   seatWidth: 35,
	   seatHeight: 35,
	   seatCss: 'seat',
	   selectedSeatCss: 'selectedSeat',
	   selectingSeatCss: 'selectingSeat'
   };
</script>
<script>
var init = function (reservedSeat) {
				var str = [], seatNo, className;
				for (i = 0; i < settings.rows; i++) {
					for (j = 0; j < settings.cols; j++) {
						seatNo = (i + j * settings.rows + 1);
						
						className = settings.seatCss + ' ' + settings.rowCssPrefix + i.toString() + ' ' + settings.colCssPrefix + j.toString();
						if ($.isArray(reservedSeat) && $.inArray(seatNo, reservedSeat) != -1) {
							className += ' ' + settings.selectedSeatCss;
						}
						
						//console.log();
						str.push('<li class="' + className + '"' +
								  'style="top:' + (i * settings.seatHeight).toString() + 'px;left:' + (j * settings.seatWidth).toString() + 'px">' +
								  '<a title="' + seatNo + '">' + seatNo + '</a>' +
								  '</li>');
					}
				}
				$('#place').html(str.join(''));
			};
			//case I: Show from starting
			//init();
 
			//Case II: If already booked
			var bookedSeats = [5, 10, 25];
			init(bookedSeats);
</script>

<script>
var count=0;
var adult = +$("#adultqty").val();

$('.' + settings.seatCss).click(function () {

if ($(this).hasClass(settings.selectedSeatCss)){
	alert('This seat is already reserved');
}
else{
	$(this).toggleClass(settings.selectingSeatCss);
	}
	
if ($(this).hasClass(settings.selectingSeatCss)){
	count++;
		if(count>0)
			$("input[name=paxqty]").removeAttr("disabled");
}
else if($(this).hasClass(settings.selectingSeatCss)==false){
	count--;
	if(count<=0)
		$("input[name=paxqty]").prop("disabled",true);
}
});
 
$('#btnShow').click(function () {
	var str = [];
	$.each($('#place li.' + settings.selectedSeatCss + ' a, #place li.'+ settings.selectingSeatCss + ' a'), function (index, value) {
		str.push($(this).attr('title'));
	});
	alert(str.join(','));
})
 
$('#place').click(function () {
	var str = [], item;
	$.each($('#place li.' + settings.selectingSeatCss + ' a'), function (index, value) {
		item = $(this).attr('title');                   
		str.push(item);                   
	});
	$('#sseat').html(str.join(','));
	
})
</script>