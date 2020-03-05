$(document).ready(function() {
	$("#postSubBlog").click(function(e) {
		var title = $("#title").val();
		var content = $("#content").val();
		
		title = $.trim(title);
		content = $.trim(content);

		var category = checkCat();
		
		if(category){
			//check if blog post already exists
			$.ajax({
				url: 'valBlogPostSub.php',
				type: 'POST',
				dataType: "json",
				data: {
					title: title,
					content: content
				},
				success: function(data) {
					if(data.statusSubBlog=="error"){
						$("#blogPostSubErr").html(data.message[0].textSubBlog);
						
						$("#title").addClass('textboxError');
						return false;
					}else{
						$("#blogPostSubErr").html("");

						$("#title").removeClass('textboxError');
						$("#blogPostSubForm").submit();
					}
				},
				error: function(err) {
					$("#blogPostSubErr").html("Error in posting blog");
					return false;
				}
			});
			e.preventDefault();
			return false;
		} else{
			return false;
		}
	});
	
	$("#categoryPBlogSub").change(function(){
		var cat = $("#categoryPBlogSub").val();
		
		if(cat == 'catOthers' ){
			$('#displayCat').show();
		} else{
			$('#displayCat').hide();
		}	
	});
	//validate category
	function checkCat(){
		var cat = $("#categoryPBlogSub").val();
		var catName = $("#catName").val();
		catName = $.trim(catName);
		catName = catName.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		if(cat == 'catOthers' ){
			$("#blogcatErr").html("");
			$("#categoryPBlogSub").removeClass('textboxError');
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
				$("#categoryPBlogSub").addClass('textboxError');
				return false;
			} else{
				$("#blogcatErr").html("");
				$("#categoryPBlogSub").removeClass('textboxError');
				return true;
			}
		}
	}
	//clear error
	$("#clearBlogCat").click(function() {
		$("#blogPostSubErr").html("");
		$("#blogCatNameErr").html("");
		$("#categoryPBlogSub").html("");

		$("#title").removeClass('textboxError');
		$("#catName").removeClass('textboxError');
		$("#categoryPBlogSub").removeClass('textboxError');
		
		$('#displayCat').hide();
	});
});