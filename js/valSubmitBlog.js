$(document).ready(function() {
	//Validate submit blog form when submit is clicked
	$("#submitBlog").click(function() {
		var title = $("#title").val();
		var content = $("#content").val();
		
		title = $.trim(title);
		content = $.trim(content);
		
		var blogTitle = checkTitle();
		var blogContent = checkContent();
		var match = checkMatch(title, content);
		
		if(blogTitle&&blogContent&&match){
			$("#blogSubmitForm").submit();
		} else{
			return false;
		}
	});
	
	//validate title
	function checkTitle(){
		var title = $("#title").val();
		title = $.trim(title);
		title = title.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		if (title.length == 0 ){
			$("#blogTitleErr").html("You have not entered the title.");
			$("#title").addClass('textboxError');
			return false;
		} else if (title.length >= 200 ){
			$("#blogTitleErr").html("Topic name should not be more than 200 character.");
			$("#title").addClass('textboxError');
			return false;
		} else {
			$("#blogTitleErr").html("");
			$("#title").removeClass('textboxError');
			return true;
		}
	}	
	
	//Validate content
	function checkContent(){
		var content = $("#content").val();
		content = $.trim(content);
		content = content.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");;
		
		if (content.length == 0 ){
			$("#blogContentErr").html("You have not entered a content.");
			$("#content").addClass('textboxError');
			return false;
		} else if (content.length >= 5000 ){
			$("#blogContentErr").html("Message should not be more than 5000 character.");
			$("#content").addClass('textboxError');
			return false;
		} else {
			$("#blogContentErr").html("");
			$("#content").removeClass('textboxError');
			return true;
		}
	}
	
	//validate if blog already exists
	function checkMatch(title, content){
		var title = $("#title").val();
		title = $.trim(title);
		title = title.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");;
		
		var content = $("#content").val();
		content = $.trim(content);
		content = content.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");;
		
		if ((title.length == 0 )||(title.length >= 200 )||(content.length == 0 )||(content.length >= 5000 )){
			$("#blogSubErr").html("");
		}else{
			$.ajax({
				url: 'valBlogSubmit.php',
				type: 'POST',
				dataType: "json",
				data: {
					title: title,
					content: content
				},
				success: function(data) {
					if(data.statusSubBlog=="error"){
						$("#blogSubErr").html(data.message[0].textSubBlog);
						
						$("#title").addClass('textboxError');
						return false;
					}else{
						$("#blogSubErr").html("");

						$("#title").removeClass('textboxError');
						$("#blogSubmitForm").submit();
					}
				},
				error: function(err) {
					$("#matchErr").html("Error in submitting blog");
					return false;
				}
			});
		}
	}
	
	//clear all errors
	$("#clearSubBlog").click(function() {
		$("#blogTitleErr").html("");
		$("#blogContentErr").html("");
		$("#blogSubErr").html("");
		
		$("#title").removeClass('textboxError');
		$("#content").removeClass('textboxError');
	});

});