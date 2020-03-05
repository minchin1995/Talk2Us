$(document).ready(function() {
	$("#submitGSTopic").click(function(e) {
		var topicName = $("#topicName").val();
		topicName = $.trim(topicName);
		
		var topic = checkTopic();
		
		if(topic){
			//check if group support topic already exists
			$.ajax({
				url: 'valEditGS.php',
				type: 'POST',
				dataType: "json",
				data: {
					topicName: topicName
				},
				success: function(data) {
					if(data.statusGS=="error"){
						$("#errorTNameGS").html(data.message[0].textGS);
						$("#topicName").addClass('textboxError');
						return false;
					}else{
						$("#errorTNameGS").html("");
						$("#topicName").removeClass('textboxError');
						$("#editGSForm").submit();
					}
				},
				error: function(err) {
					$("#errorTNameGS").html("Error in editing group support topic");
					return false;
				}
			});
			e.preventDefault();
			return false;
		} else{
			return false;
		}
	});
	
	//validate topic name
	function checkTopic(){
		var topicName = $("#topicName").val();
		topicName = $.trim(topicName);
		topicName = $.trim(topicName);
		topicName = topicName.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		if (topicName.length == 0 ){
			$("#errorTNameGS").html("You have not entered the topic name.");
			$("#topicName").addClass('textboxError');
			return false;
		} else if (topicName.length >= 200 ){
			$("#errorTNameGS").html("Topic name should not be more than 200 character.");
			$("#topicName").addClass('textboxError');
			return false;
		} else {
			$("#errorTNameGS").html("");
			$("#topicName").removeClass('textboxError');
			return true;
		}
	}
	
	//clear error
	$("#clearGSTopic").click(function() {
		$("#errorTNameGS").html("");
		
		$("#topicName").removeClass('textboxError');
	});
});