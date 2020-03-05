$(document).ready(function() {
	$("#submitDBTopic").click(function(e) {
		var tName = $("#tName").val();
		tName = $.trim(tName);
		
		var cat = checkCat();
		var topic = checkTName();
		var post = checkPost();
		
		if(topic&&post&&cat){
			//check if topic already exists
			$.ajax({
				url: 'valCreateTopic.php',
				type: 'POST',
				dataType: "json",
				data: {
					topicName: tName
				},
				success: function(data) {
					if(data.statusDB=="error"){
						$("#errorTopicName").html(data.message[0].textDB);
						$("#tName").addClass('textboxError');
						return false;
					}else{
						console.log("hello");
						$("#errorTopicName").html("");
						$("#tName").removeClass('textboxError');
						$("#createTopicForm").submit();
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
	
	$("#category").change(function(){
		var cat = $("#category").val();
		
		if(cat == 'catOthers' ){
			$('#displayCat').show();
		} else{
			$('#displayCat').hide();
		}	
	});
	
	//validate category
	function checkCat(){
		var cat = $("#category").val();
		var catName = $("#catName").val();
		catName = $.trim(catName);
		catName = catName.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		if(cat == 'catOthers' ){
			$("#errorCat").html("");
			$("#category").removeClass('textboxError');
			if (catName.length == 0 ){
				$("#errorCatName").html("You have not entered the category.");
				$("#catName").addClass('textboxError');
				return false;
			} else if (catName.length >= 200 ){
				$("#errorCatName").html("Category name should not be more than 200 character.");
				$("#catName").addClass('textboxError');
				return false;
			} else {
				$("#errorCatName").html("");
				$("#catName").removeClass('textboxError');
				return true;
			}
		} else{
			if (cat.length == 0 ){
				$("#errorCat").html("You have not selected the category.");
				$("#category").addClass('textboxError');
				return false;
			} else{
				$("#errorCat").html("");
				$("#category").removeClass('textboxError');
				return true;
			}
		}
	}
	
	//validate topic name
	function checkTName(){
		var tName = $("#tName").val();
		tName = $.trim(tName);
		tName = tName.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		if (tName.length == 0 ){
			$("#errorTopicName").html("You have not entered the topic name.");
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
	}
	
	//validate post
	function checkPost(){
		var post = $("#post").val();
		post = $.trim(post);
		post = post.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
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
	}
	
	//clear error
	$("#clearDBTopic").click(function() {
		$("#errorTopicName").html("");
		$("#errorCat").html("");
		$("#errorCatName").html("");
		$("#errorPost").html("");
		
		$("#tName").removeClass('textboxError');
		$("#category").removeClass('textboxError');
		$("#catName").removeClass('textboxError');
		$("#post").removeClass('textboxError');
		
		$('#displayCat').hide();
	});
});