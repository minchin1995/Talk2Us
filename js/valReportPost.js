$(document).ready(function() {
	$("#submitDBRep").click(function() {
		var reason = checkReason();
		var comment = checkComment();
		
		if(reason&&comment){
			$("#reportPostForm").submit();
		} else{
			return false;
		}
	});
	//validate reason
	function checkReason(){
		if ( ! $(".postReason").is(':checked') ){
			$("#errorPostReason").html("You have not selected a reason to report post.");
			$("#postReason").addClass('textboxError');
			return false;
		} else {
			$("#errorPostReason").html("");
			$("#postReason").removeClass('textboxError');
			return true;
		}
	}	
	//validate comment
	function checkComment(){
		var comment = $("#postComment").val();
		comment = $.trim(comment);
		comment = comment.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		if (comment.length != 0 ){
			if (comment.length > 200 ){
				$("#errorPostComment").html("Comment should not be more than 200 character.");
				$("#postComment").addClass('textboxError');
				return false;
			} else{
				$("#errorPostComment").html("");
				$("#postComment").removeClass('textboxError');
				return true;
			}
		} else {
			$("#errorPostComment").html("");
			$("#postComment").removeClass('textboxError');
			return true;
		}
	}
	
	//clear error
	$("#clearDBRep").click(function() {
		$("#errorPostReason").html("");
		$("#errorPostComment").html("");
		
		$("#postReason").removeClass('textboxError');
		$("#postComment").removeClass('textboxError');
	});

});