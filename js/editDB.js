$(document).ready(function() {
	var replaced;
	var replacedB;
	//change div to textbox for editing. change buttons for editing purposes
	$(".dbButtons").on( "click", ".editPost a", function() {
		var postid = $(this).data('postid');
		var content = $('.postContent.'+postid).html();
		
		replace(postid, content);

		$("#submitEditDB").click(function() {
			var postID = $("#editPostID").val();
			var message = $("#editMessage").val();
		
			if (message.length == 0 ){
				$("#postEditErr").html("You have not entered a message.");
				$("#editMessage").addClass('textboxError');
				return false;
			} else if (message.length > 2000 ){
				$("#postEditErr").html("Message should not be more than 2000 character.");
				$("#editMessage").addClass('textboxError');
				return false;
			} else{
				$("#postEditErr").html("");
				$("#editMessage").removeClass('textboxError');
				editMessage(postID, message);
			}
		});
		
		//clear error
		$("#clearEditDB").click(function() {
			$("#postEditErr").html("");
			
			$("#editMessage").removeClass('textboxError');
		});
		
		//change back to div from textbox
		$(".quitPost").on( "click", "a", function() {
			var postid = $(this).data('postid');
			restore(postid);
		});
	
	});
	
	//replace content div with editing form and edit button with quit button
	function replace(postid, content){
		var formEdit = "<form method=\"post\" class=\"paddingAround editForm ";
			formEdit += postid;
			formEdit += "\">";
			formEdit += "<div style=\"visibility:hidden; position:absolute\">";
			formEdit += "<label>Post ID:</label>";
			formEdit += "<input type=\"text\" name=\"postID\" id=\"editPostID\" value=";
			formEdit += postid;
			formEdit += " readonly>";
			formEdit += "</div>";
			formEdit += "<div>";
			formEdit += "<label>Message:</label>";
			formEdit += "<textarea name=\"message\" rows=\"5\"  class=\"form-control\" id=\"editMessage\" placeholder=\"Message\" style=\"resize: none;\">";
			formEdit += content;
			formEdit += "</textarea>";
			formEdit += "<p class=\"hint\">(Post needs to be less than 2000 characters)</p>";
			formEdit += "<p id=\"postEditErr\" style=\"color: red;\"></p>";
			formEdit += "</div>";
			formEdit += "<div class=\"floatRight\">";
			formEdit += "<input type=\"reset\" class=\"button\" id=\"clearEditDB\" value=\"Clear\">";
			formEdit += "<input type=\"button\" class=\"button\" name=\"submit\" id=\"submitEditDB\" value=\"Edit\"/>";
			formEdit += "</div>";
			formEdit += "<br class=\"clearRight\"/>";
			formEdit += "</form>";

		replaced = $('.postContent.'+postid).replaceWith(formEdit);

		var quitButton = "<div class=\"quitPost "; 
			quitButton += postid;
			quitButton += "\">";
			quitButton += "<a class=\"buttonLeft\" data-postid=\"";
			quitButton += postid;
			quitButton += "\">";
			quitButton += "<p>Quit</p>";
			quitButton += "</a>";
			quitButton += "</div>";
			
		replacedB = $('.editPost.'+postid).replaceWith(quitButton);
	}
	
	//restore content div and buttons
	function restore(postid){
		$('.quitPost.'+postid).replaceWith(replacedB);
		$('.editForm.'+postid).replaceWith(replaced);
	}
	
	//edit message
	function editMessage(postID, message){
		$.ajax({
				url: 'editDBPost.php',
				type: 'POST',
				dataType: "json",
				data: {
					postID: postID,
					message: message
				},
				success: function(data) {
					console.log(data);
					location.reload();
					return false;
				},
				error: function(err) {
					console.log(err.responseText);
					return false;
				}
			});
	}
	
});