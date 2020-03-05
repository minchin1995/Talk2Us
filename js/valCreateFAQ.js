$(document).ready(function() {
	$("#topic").change(function(){
		var topic = $("#topic").val();
		
		if(topic == 'topicOthers' ){
			$('#displayTopic').show();
		} else{
			$('#displayTopic').hide();
		}	
	});
	
	$("#submitFAQ").click(function(e) {
		var question = $("#question").val();
		var answer = $("#answer").val();
		
		question = $.trim(question);
		answer = $.trim(answer);
		
		var ques = checkQ();
		var ans = checkA();
		var topic = checkTopic();
		
		if(ques&&ans&&topic){
			//check if faq exists
			$.ajax({
				url: 'valCreateFAQ.php',
				type: 'POST',
				dataType: "json",
				data: {
					question: question
				},
				success: function(data) {
					if(data.statusFAQ=="error"){
						$("#errorQFAQ").html(data.message[0].textFAQ);
						$("#question").addClass('textboxError');
						return false;
					}else{
						$("#errorQFAQ").html("");
						$("#question").removeClass('textboxError');
						$("#faqForm").submit();
					}
				},
				error: function(err) {
					$("#errorQFAQ").html("Error in creating FAQ");
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
	//validate question
	function checkQ(){
		var question = $("#question").val();
		question = $.trim(question);
		question = question.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		if (question.length == 0 ){
			$("#errorQFAQ").html("Please enter a Question.");
			$("#question").addClass('textboxError');
			return false;
		} else if (question.length > 200 ){
			$("#errorQFAQ").html("Question should not be more than 200 character.");
			$("#question").addClass('textboxError');
			return false;
		} else {
			$("#errorQFAQ").html("");
			$("#question").removeClass('textboxError');
			return true;
		}
	}	
	//validate answer
	function checkA(){
		var answer = $("#answer").val();
		answer = $.trim(answer);
		answer = answer.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		if (answer.length == 0 ){
			$("#errorAFAQ").html("Please enter an answer.");
			$("#answer").addClass('textboxError');
			return false;
		} else if (answer.length > 2000 ){
			$("#errorAFAQ").html("Answer should not be more than 200 character.");
			$("#answer").addClass('textboxError');
			return false;
		} else {
			$("#errorAFAQ").html("");
			$("#answer").removeClass('textboxError');
			return true;
		}
	}
	//validate topic
	function checkTopic(){
		var topic = $("#topic").val();
		var topicName = $("#topicName").val();
		topicName = $.trim(topicName);
		topicName = topicName.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");

		if(topic == 'topicOthers' ){
			$("#errorTFAQ").html("");
			$("#topic").removeClass('textboxError');
			if (topicName.length == 0 ){
				$("#errorTNameFAQ").html("You have not entered the topic.");
				$("#topicName").addClass('textboxError');
				return false;
			} else if (topicName.length > 200 ){
				$("#errorTNameFAQ").html("Topic name should not be more than 200 character.");
				$("#topicName").addClass('textboxError');
				return false;
			} else {
				$("#errorTNameFAQ").html("");
				$("#topicName").removeClass('textboxError');
				return true;
			}
		} else{
			if (topic.length == 0 ){
				$("#errorTFAQ").html("You have not selected the category.");
				$("#topic").addClass('textboxError');
				return false;
			} else{
				$("#errorTFAQ").html("");
				$("#topic").removeClass('textboxError');
				return true;
			}
		}
	}
	//clear error
	$("#clearFAQ").click(function() {
		$("#errorQFAQ").html("");
		$("#errorAFAQ").html("");
		$("#errorTNameFAQ").html("");
		$("#errorTFAQ").html("");
		
		$("#question").removeClass('textboxError');
		$("#answer").removeClass('textboxError');
		$("#topicName").removeClass('textboxError');
		$("#topic").removeClass('textboxError');
		
		$('#displayTopic').hide();
	});

});