$(document).ready(function() {
	$("#submitGSRep").click(function() {
		var post = checkPost();
		
		if(post){
			$("#editRepGSForm").submit();
		} else{
			return false;
		}
	});
	//validate post
	function checkPost(){
		var post = $("#post").val();
		post = $.trim(post);
		post = post.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		if (post.length == 0 ){
			$("#errorGSPost").html("You have not entered a post.");
			$("#post").addClass('textboxError');
			return false;
		} else if (post.length >= 2000 ){
			$("#errorGSPost").html("Post should not be more than 2000 character.");
			$("#post").addClass('textboxError');
			return false;
		} else {
			$("#errorGSPost").html("");
			$("#post").removeClass('textboxError');
			return true;
		}
	}
	//clear error
	$("#clearGSRep").click(function() {
		$("#errorGSPost").html("");
		
		$("#post").removeClass('textboxError');
	});
});