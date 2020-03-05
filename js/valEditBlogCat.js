$(document).ready(function() {
	//Validate submit blog form when submit is clicked
	$("#submitBlogCat").click(function(e) {
		var catName = $("#catName").val();
		catName = $.trim(catName);
		catName = catName.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		var category = checkCat();
		
		if(category){
			//check if blog category name already exists
			$.ajax({
				url: 'valBlogEditCat.php',
				type: 'POST',
				dataType: "json",
				data: {
					catName: catName
				},
				success: function(data) {
					if(data.statusSubBlog=="error"){
						$("#errorBlogCatName").html(data.message[0].textSubBlog);
						$("#catName").addClass('textboxError');
						return false;
					}else{
						$("#errorBlogCatName").html("");
						$("#catName").removeClass('textboxError');
						$("#editBlogCatForm").submit();
					}
				},
				error: function(err) {
					$("#errorBlogCatName").html("Error in editing category");
					return false;
				}
			});
			e.preventDefault();
			return false;
		} else{
			return false;
		}
	});
	
	//validate category
	function checkCat(){
		var catName = $("#catName").val();
		catName = $.trim(catName);
		catName = catName.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		if (catName.length == 0 ){
			$("#errorBlogCatName").html("You have not entered the category.");
			$("#catName").addClass('textboxError');
			return false;
		} else if (catName.length >= 200 ){
			$("#errorBlogCatName").html("Category name should not be more than 200 character.");
			$("#catName").addClass('textboxError');
			return false;
		} else {
			$("#errorBlogCatName").html("");
			$("#catName").removeClass('textboxError');
			return true;
		}
	}
	//clear error
	$("#clearBlogCat").click(function() {
		$("#errorBlogCatName").html("");
		
		$("#catName").removeClass('textboxError');
	});
});