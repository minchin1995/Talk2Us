$(document).ready(function() {
	$("#submitAssGS").click(function(e) {
		var userID = $("#userID").val();
		var tName = $("#tName").val();
		var topicGS = $("#topic").val();

		userID = $.trim(userID);
		tName = $.trim(tName);
		topicGS = $.trim(topicGS);
		
		var topic = checkTopic();
		var post = checkPost();
		
		var dataObj;
		
		if(topicGS == 'topOthers'){		
			dataObj = {userID: userID,
						topic: tName};
		}else{
			dataObj = {userID: userID,
						topic: topicGS};
		}
		
		if(topic&&post){
			//check if user is assigned to topic already
			$.ajax({
				url: 'valAssignGS.php',
				type: 'POST',
				dataType: "json",
				data: dataObj,
				success: function(data) {
					if(data.statusGS=="error"){
						if(topicGS == 'topOthers' ){
							$("#errorTopicName").html(data.message[0].textGS);
							$("#tName").addClass('textboxError');
						}else{
							$("#errorTop").html(data.message[0].textGS);
							$("#topic").addClass('textboxError');
						}
						return false;
					}else{
						$("#errorTop").html("");
						$("#errorTopicName").html("");
						$("#topic").removeClass('textboxError');
						$("#tName").removeClass('textboxError');
						$("#assignGSForm").submit();
					}
				},
				error: function(err) {
					console.log(err.responseText);
					return false;
				}
			});
			e.preventDefault();
			return false;
		} else{
			return false;
		}
	});
	
	//validate topic
	function checkTopic(){
		var topic = $("#topic").val();
		var tName = $("#tName").val();
		tName = $.trim(tName);
		tName = tName.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		if(topic == 'topOthers' ){
			$("#errorTop").html("");
			$("#topic").removeClass('textboxError');
			if (tName.length == 0 ){
				$("#errorTopicName").html("You have not entered the topic.");
				$("#tName").addClass('textboxError');
				return false;
			} else if (tName.length >= 200 ){
				$("#errorTopicName").html("Topic name should not be more than 200 character.");
				$("#tName").addClass('textboxError');
				return false;
			} else {
				$("#errorTopicName").html("");
				$("#tName").removeClass('textboxError');
				return true;
			}
		} else{
			if (topic.length == 0 ){
				$("#errorTop").html("You have not selected the category.");
				$("#topic").addClass('textboxError');
				return false;
			} else{
				$("#errorTop").html("");
				$("#topic").removeClass('textboxError');
				return true;
			}
		}
	}
	
	//validate post
	function checkPost(){
		var topic = $("#topic").val();
		var post = $("#post").val();
		post = $.trim(post);
		post = post.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		if(topic == 'topOthers' ){
			if (post.length == 0 ){
				$("#errorPost").html("You have not entered a post.");
				$("#post").addClass('textboxError');
				return false;
			} else if (post.length >= 2000 ){
				$("#errorPost").html("Post should not be more than 2000 character.");
				$("#post").addClass('textboxError');
				return false;
			} else {
				$("#errorPost").html("");
				$("#post").removeClass('textboxError');
				return true;
			}
		} else{
			$("#errorPost").html("");
			$("#post").removeClass('textboxError');
			return true;
		}
	}
	
	$("#topic").change(function(){
		var topic = $("#topic").val();
		
		if(topic == 'topOthers' ){
			$('#displayTop').show();
			$('#displayPost').show();
		} else{
			$('#displayTop').hide();
			$('#displayPost').hide();
		}	
	});
	
	//clear error
	$("#clearAssGS").click(function() {
		$("#errorTopicName").html("");
		$("#errorTop").html("");
		$("#errorPost").html("");
		
		$("#tName").removeClass('textboxError');
		$("#topic").removeClass('textboxError');
		$("#post").removeClass('textboxError');
		
		$('#displayTop').hide();
		$('#displayPost').hide();
	});
	
});