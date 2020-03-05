$(document).ready(function() {
	//autocomplete for admins for searching group support
	$("#searchGSAdmin").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: 'searchGSAdminAuto.php',
				type: 'POST',
				data: {
					term: request.term
				},
				dataType: "json",
				success: function(data) {
					if(data.length>0){
						response( $.map(data, function(item) {
							return {
								label: item.sTopicName
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
	//clear error
	$("#clearSearchGSAdmin").click(function() {
		$("#searchGSAdmin").val('');
	});
});