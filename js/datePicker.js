$(document).ready(function() {
	//datepicker
	$( "#dob" ).datepicker({
		dateFormat: 'yy-mm-dd',
		maxDate: "-18y", //fix
		minDate: "-82y", 
		changeMonth: true,
		changeYear: true,
		yearRange: "-82y:-18y" 
	});
});