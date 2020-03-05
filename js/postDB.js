$(document).ready(function() {
	var echoM;
	
	//echo content in textbox in case of reply
	$(".replyPost a").click(function() {
        var postid = $(this).data('postid');
		var content = $('.postContent.'+postid).html();
		var uname = $('.postUname.'+postid).html();
		
		var message = $("#message").val();
		message = $.trim(message);
		console.log(uname);
			echoM = "<div>";
			echoM += "Reply to: ";
			echoM += "<span>";
			echoM += uname;
			echoM +="</span> , ";
			echoM += content
			echoM += "</div>";
		
		if (message.length == 0 ){
			$("#message").val(echoM);
		}else{
			alert("Your reply box needs to be empty to reply any messages");
		}
    });
	
	$("#submitPostDB").click(function() {
		var topicID = $("#topicID").val();
		var message = $("#message").val();
		message = $.trim(message);
		message = message.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		//validate message
		if (message.length == 0 ){
			$("#postErr").html("You have not entered a message.");
			$("#message").addClass('textboxError');
			return false;
		} else if (message.length > 2000 ){
			$("#postErr").html("Message should not be more than 2000 character.");
			$("#message").addClass('textboxError');
			return false;
		} else{
			$("#postErr").html("");
			$("#message").removeClass('textboxError');
			var username = $('<div>' + message + '</div>').find('span').text();
			if(username.length > 0){ //if username exists send notification
				notifyUser(username, topicID);
			}
			postMessage(topicID, message); 
		}
		
	});
	
	//post message
	function postMessage(topicID, message){
		$.ajax({
				url: 'createDBPost.php',
				type: 'POST',
				dataType: "json",
				data: {
					topicID: topicID,
					message: message
				},
				success: function(data) {
					console.log(data);
					location.reload();
					return false;
				},
				error: function(err) {
					console.log(err.responseText);
					return false;
				}
			});
	}
	
	//notify users in case of any reply
	function notifyUser(username, topicID){
		$.ajax({
				url: 'notifyUser.php',
				type: 'POST',
				dataType: "json",
				data: {
					topicID: topicID,
					username: username
				},
				success: function(data) {
					console.log(data);
					return false;
				},
				error: function(err) {
					console.log(err.responseText);
					return false;
				}
			});
	}
	
	//clear error
	$("#clearPostDB").click(function() {
		$("#postErr").html("");
		
		$("#message").removeClass('textboxError');
	});
});