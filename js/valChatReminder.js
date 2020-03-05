$(document).ready(function() {
	//enable button to proceed if check box is selected
	$(".checkReminder").on('click', function() {
	   if($(this).is(':checked')){
			$("#ok").prop('disabled',false);
		} else {
			$("#ok").prop('disabled',true);
		}
	})
});