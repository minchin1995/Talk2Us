$(document).ready(function() {
	//autocomplete while searching for blog
	$("#searchBlog").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: 'searchBlogAuto.php',
				type: 'POST',
				data: {
					term: request.term
				},
				dataType: "json",
				success: function(data) {
					if(data.length>0){
						response( $.map(data, function(item) {
							return {
								label: item.blogName
							}
						}));
					}else{
						response({label: 'No Results', value: ''});
					}
				},
				error: function(err) {
					console.log(err.responseText);
				}
			});		
		}
	});
	
	//clear
	$("#clearSearchBlog").click(function() {
		$("#searchBlog").val('');
	});
});