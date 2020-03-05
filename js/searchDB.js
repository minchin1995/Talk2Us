$(document).ready(function() {
	//autocomplete while searching for forum topics
	$("#searchDB").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: 'searchDBAuto.php',
				type: 'POST',
				data: {
					term: request.term
				},
				dataType: "json",
				success: function(data) {
					if(data.length>0){
						response( $.map(data, function(item) {
							return {
								label: item.topicName
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
	$("#clearSearchDB").click(function() {
		$("#searchDB").val('');
	});
});