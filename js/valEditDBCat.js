$(document).ready(function() {
	$("#submitDBCat").click(function(e) {
		var catName = $("#catName").val();
		catName = $.trim(catName);
		
		var category = checkCat();

		if(category){
			//check if category already exists
			$.ajax({
				url: 'valDBEditCat.php',
				type: 'POST',
				dataType: "json",
				data: {
					catName: catName
				},
				success: function(data) {
					if(data.statusDB=="error"){
						$("#errorCatName").html(data.message[0].textDB);
						$("#catName").addClass('textboxError');
						return false;
					}else{
						$("#errorCatName").html("");
						$("#catName").removeClass('textboxError');
						$("#dbCatEditForm").submit();
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
	}
	//clear error
	$("#clearDBCat").click(function() {
		$("#errorCatName").html("");
		
		$("#catName").removeClass('textboxError');
	});
});