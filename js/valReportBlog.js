$(document).ready(function() {
	$("#submitBlogRep").click(function() {
		var reason = checkReason();
		var comment = checkComment();
		
		if(reason&&comment){
			$("#reportBlogForm").submit();
		} else{
			return false;
		}
	});
	//validate reason
	function checkReason(){
		if ( ! $(".blogReason").is(':checked') ){
			$("#errorBlogReason").html("You have not selected a reason to report blog.");
			$("#blogReason").addClass('textboxError');
			return false;
			
		} else {
			$("#errorBlogReason").html("");
			$("#blogReason").removeClass('textboxError');
			return true;
		}
	}	
	//validate comment
	function checkComment(){
		var comment = $("#blogComment").val();
		comment = $.trim(comment);
		comment = comment.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		if (comment.length != 0 ){
			if (comment.length > 200 ){
				$("#errorBlogComment").html("Comment should not be more than 200 character.");
				$("#blogComment").addClass('textboxError');
				return false;
			} else{
				$("#errorBlogComment").html("");
				$("#blogComment").removeClass('textboxError');
				return true;
			}
		} else {
			$("#errorBlogComment").html("");
			$("#blogComment").removeClass('textboxError');
			return true;
		}
	}
	//clear error
	$("#clearBlogRep").click(function() {
		$("#errorBlogReason").html("");
		$("#errorBlogComment").html("");
		
		$("#blogReason").removeClass('textboxError');
		$("#blogComment").removeClass('textboxError');
	});

});