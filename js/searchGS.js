$(document).ready(function() {
	//autocomplete while user search for group support
	$("#searchGS").autocomplete({
		source: function( request, response ) {
			$.ajax({
				url: 'searchGSAuto.php',
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
	//clear
	$("#clearSearchGS").click(function() {
		$("#searchGS").val('');
	});
});