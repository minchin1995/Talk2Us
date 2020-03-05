$(document).ready(function() {
	$("#submitGSRep").click(function() {
		var reason = checkReason();
		var comment = checkComment();
		
		if(reason&&comment){
			$("#reportGSForm").submit();
		} else{
			return false;
		}
	});
	//validate reason
	function checkReason(){
		if ( ! $(".gsReason").is(':checked') ){
			$("#errorGSReason").html("You have not selected a reason to report post.");
			$("#gsReason").addClass('textboxError');
			return false;
		} else {
			$("#errorGSReason").html("");
			$("#gsReason").removeClass('textboxError');
			return true;
		}
	}	
	//validate comment
	function checkComment(){
		var comment = $("#gsComment").val();
		comment = $.trim(comment);
		comment = comment.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		if (comment.length != 0 ){
			if (comment.length > 200 ){
				$("#errorGSComment").html("Comment should not be more than 200 character.");
				$("#gsComment").addClass('textboxError');
				return false;
			} else{
				$("#errorGSComment").html("");
				$("#gsComment").removeClass('textboxError');
				return true;
			}
		} else {
			$("#errorGSComment").html("");
			$("#gsComment").removeClass('textboxError');
			return true;
		}
	}
	//clear error
	$("#clearGSRep").click(function() {
		$("#errorGSReason").html("");
		$("#errorGSComment").html("");
		
		$("#gsReason").removeClass('textboxError');
		$("#gsComment").removeClass('textboxError');
	});

});