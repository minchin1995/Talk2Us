$(document).ready(function() {
	//Validate submit blog form when submit is clicked
	$("#postBlog").click(function(e) {
		var title = $("#title").val();
		var content = $("#content").val();
		
		title = $.trim(title);
		content = $.trim(content);
		
		var blogTitle = checkTitle();
		var blogContent = checkContent();
		var category = checkCat();
		
		if(blogTitle&&blogContent&&category){
			//check if blog title already exists
			$.ajax({
				url: 'valBlogPost.php',
				type: 'POST',
				dataType: "json",
				data: {
					title: title,
					content: content
				},
				success: function(data) {
					if(data.statusBlog=="error"){
						$("#blogPostErr").html(data.message[0].textBlog);
						
						$("#title").addClass('textboxError');
						return false;
					}else{
						$("#blogPostErr").html("");

						$("#title").removeClass('textboxError');
						$("#blogPostForm").submit();
					}
				},
				error: function(err) {
					$("#blogPostErr").html("Error in posting blog");
					return false;
				}
			});
			e.preventDefault();
			return false;
		} else{
			return false;
		}
	});
	
	$("#categoryPBlog").change(function(){
		var cat = $("#categoryPBlog").val();
		
		if(cat == 'catOthers' ){
			$('#displayCat').show();
		} else{
			$('#displayCat').hide();
		}	
	});
	//validate category
	function checkCat(){
		var cat = $("#categoryPBlog").val();
		var catName = $("#catName").val();
		catName = $.trim(catName);
		catName = catName.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		if(cat == 'catOthers' ){
			$("#blogcatErr").html("");
			$("#categoryPBlog").removeClass('textboxError');
			if (catName.length == 0 ){
				$("#blogCatNameErr").html("You have not entered the category.");
				$("#catName").addClass('textboxError');
				return false;
			} else if (catName.length >= 200 ){
				$("#blogCatNameErr").html("Category name should not be more than 200 character.");
				$("#catName").addClass('textboxError');
				return false;
			} else {
				$("#blogCatNameErr").html("");
				$("#catName").removeClass('textboxError');
				return true;
			}
		} else{
			if (cat.length == 0 ){
				$("#blogcatErr").html("You have not selected the category.");
				$("#categoryPBlog").addClass('textboxError');
				return false;
			} else{
				$("#blogcatErr").html("");
				$("#categoryPBlog").removeClass('textboxError');
				return true;
			}
		}
	}
	
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
		content = encodeURI(content);
		
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
	//clear error
	$("#clearPostBlog").click(function() {
		$("#blogTitleErr").html("");
		$("#blogContentErr").html("");
		$("#blogcatErr").html("");
		$("#blogCatNameErr").html("");
		$("#blogPostErr").html("");
		
		$("#title").removeClass('textboxError');
		$("#content").removeClass('textboxError');
		$("#categoryPBlog").removeClass('textboxError');
		$("#catName").removeClass('textboxError');
		
		$('#displayCat').hide();
	});
});