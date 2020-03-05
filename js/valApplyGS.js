$(document).ready(function() {
	$("#submitAppGS").click(function() {
		var reason = $("#reason").val();
		reason = $.trim(reason);
		reason = reason.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		//validate reason
		if (reason.length == 0 ){
			$("#errorReaGS").html("You have not entered a reason.");
			$("#reason").addClass('textboxError');
			return false;
		} else if (reason.length > 200 ){
			$("#errorReaGS").html("Reason should not be more than 200 character.");
			$("#reason").addClass('textboxError');
			return false;
		} else {
			$("#errorReaGS").html("");
			$("#reason").removeClass('textboxError');
			$("#applyGSForm").submit();
		}
	});
	
	//clear error
	$("#clearAppGS").click(function() {
		$("#errorReaGS").html("");
		
		$("#reason").removeClass('textboxError');
	});
});