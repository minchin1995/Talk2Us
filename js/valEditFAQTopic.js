$(document).ready(function() {
	$("#submitFAQTopic").click(function(e) {
		var topicName = $("#topicName").val();
		topicName = $.trim(topicName);
		topicName = topicName.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		//validate topic name
		if (topicName.length == 0 ){
			$("#errorTNameFAQ").html("You have not entered a topic name.");
			$("#topicName").addClass('textboxError');
			return false;
		} else if (topicName.length > 200 ){
			$("#errorTNameFAQ").html("Topic name should not be more than 200 character.");
			$("#topicName").addClass('textboxError');
			return false;
		} else {
			$.ajax({
				url: 'valEditFAQTopic.php',
				type: 'POST',
				dataType: "json",
				data: {
					topicName: topicName
				},
				success: function(data) {
					if(data.statusFAQ=="error"){
						$("#errorTNameFAQ").html(data.message[0].textFAQ);
						$("#topicName").addClass('textboxError');
						return false;
					}else{
						$("#errorTNameFAQ").html("");
						$("#topicName").removeClass('textboxError');
						$("#faqTopicForm").submit();
					}
				},
				error: function(err) {
					console.log(err.responseText);
					return false;
				}
			});
		}

		e.preventDefault();
		return false;
	});
	
	//clear error
	$("#clearFAQTopic").click(function() {
		$("#errorTNameFAQ").html("");
		
		$("#topicName").removeClass('textboxError');
	});
});