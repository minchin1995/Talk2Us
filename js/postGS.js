$(document).ready(function() {
	//echo content in textbox in case of reply
	$(".replyGSPost a").click(function() {
        var postid = $(this).data('postid');
		var content = $('.gsPostContent.'+postid).html();
		var uname = $('.postGSUname.'+postid).html();
		
		var message = $("#gsMessage").val();
		message = $.trim(message);
		
		console.log(uname);
		
		var echoM = "<div>";
			echoM += "Reply to: ";
			echoM += "<span>";
			echoM += uname;
			echoM +="</span> , ";
			echoM += content
			echoM += "</div>";
		
		if (message.length == 0 ){
			$("#gsMessage").val(echoM);
		}else{
			alert("Your reply box needs to be empty to reply any messages");
		}
    });

	$("#submitPostGS").click(function() {
		var topicID = $("#topicID").val();
		var message = $("#gsMessage").val();
		message = $.trim(message);
		message = message.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		//validate message
		if (message.length == 0 ){
			$("#postErr").html("You have not entered a message.");
			$("#gsMessage").addClass('textboxError');
			return false;
		} else if (message.length > 2000 ){
			$("#postErr").html("Message should not be more than 2000 character.");
			$("#gsMessage").addClass('textboxError');
			return false;
		} else{
			$("#postErr").html("");
			$("#gsMessage").removeClass('textboxError');
			var username = $('<div>' + message + '</div>').find('span').text();
			if(username.length > 0){
				notifyUserGS(username, topicID);
			}
			postMessage(topicID, message);
		}
		
	});
	
	//post message
	function postMessage(topicID, message){
		$.ajax({
				url: 'createGSPost.php',
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
	function notifyUserGS(username, topicID){
		$.ajax({
				url: 'notifyUserGS.php',
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
	$("#clearPostGS").click(function() {
		$("#postErr").html("");
		
		$("#gsMessage").removeClass('textboxError');
	});
});