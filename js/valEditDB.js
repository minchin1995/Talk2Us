$(document).ready(function() {
	$("#submitDBTop").click(function(e) {
		var topicid = $("#topicid").val();
		var tName = $("#tName").val();
		var cat = $("#category").val();
		var catName = $("#catName").val();

		topicid = $.trim(topicid);
		tName = $.trim(tName);
		catName = $.trim(catName);

		var category = checkCat();
		var topic = checkTName();
		
		if(topic&&category){
			//get original category name
			$.ajax({
				url: 'getDBCat.php',
				type: 'POST',
				dataType: "json",
				data: {
					topicID: topicid
				},
				success: function(data) {
					var oriCat = data.result;
					if((oriCat == cat)||(oriCat == catName)){
						$.ajax({
							url: 'valDBEdit.php',
							type: 'POST',
							dataType: "json",
							data: {
								topicName: tName
							},
							success: function(data) {
								if(data.statusBlog=="error"){
									$("#errorTopicName").html(data.message[0].textBlog);
									$("#tName").addClass('textboxError');
									return false;
								}else{
									$("#errorTopicName").html("");
									$("#tName").removeClass('textboxError');
									$("#dbTopicEditForm").submit();
								}
							},
							error: function(err) {
								$("#errorTopicName").html("Error in editing blog");
								return false;
							}
						});
					}else{
						$("#dbTopicEditForm").submit();
					}
				},
				error: function(err) {
					$("#errorTopicName").html("Error in editing blog");
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
	//clear error
	$("#clearDBTop").click(function() {
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