$(document).ready(function() {
	var replacedG;
	var replacedGS;
	
	//change div to textbox for editing. change buttons for editing purposes
	$(".dbButtons").on( "click", ".editGSPost a", function() {
		var postid = $(this).data('postid');
		var content = $('.gsPostContent.'+postid).html();

		replaceGS(postid, content);

		$("#submitEditGS").click(function() {
			var postID = $("#editGSPostID").val();
			var message = $("#editGSMessage").val();
		
			if (message.length == 0 ){
				$("#postGSEditErr").html("You have not entered a message.");
				$("#editGSMessage").addClass('textboxError');
				return false;
			} else if (message.length > 2000 ){
				$("#postGSEditErr").html("Message should not be more than 2000 character.");
				$("#editGSMessage").addClass('textboxError');
				return false;
			} else{
				$("#postGSEditErr").html("");
				$("#editGSMessage").removeClass('textboxError');
				editGSMessage(postID, message);
			}
		});
		
		//clear error
		$("#clearEditGS").click(function() {
			$("#postGSEditErr").html("");
			
			$("#editGSMessage").removeClass('textboxError');
		});
		
		//change back to div from textbox
		$(".quitGSPost").on( "click", "a", function() {
			var postid = $(this).data('postid');
			restoreGS(postid);
		});
	
	});
	
	//replace content div with editing form and edit button with quit button
	function replaceGS(postid, content){
		var formEdit = "<form method=\"post\" class=\"paddingAround editGSForm ";
			formEdit += postid;
			formEdit += "\">";
			formEdit += "<div style=\"visibility:hidden; position:absolute\">";
			formEdit += "<label>Post ID:</label>";
			formEdit += "<input type=\"text\" name=\"postID\" id=\"editGSPostID\" value=";
			formEdit += postid;
			formEdit += " readonly>";
			formEdit += "</div>";
			formEdit += "<div>";
			formEdit += "<label>Message:</label>";
			formEdit += "<textarea name=\"message\" rows=\"5\"  class=\"form-control\" id=\"editGSMessage\" placeholder=\"Message\" style=\"resize: none;\">";
			formEdit += content;
			formEdit += "</textarea>";
			formEdit += "<p class=\"hint\">(Post needs to be less than 2000 characters)</p>";
			formEdit += "<p id=\"postGSEditErr\" style=\"color: red;\"></p>";
			formEdit += "</div>";
			formEdit += "<div class=\"floatRight\">";
			formEdit += "<input type=\"reset\" class=\"button\" id=\"clearEditGS\" value=\"Clear\">";
			formEdit += "<input type=\"button\" class=\"button\" name=\"submit\" id=\"submitEditGS\" value=\"Edit\"/>";
			formEdit += "</div>";
			formEdit += "<br class=\"clearRight\"/>";
			formEdit += "</form>";

		replacedG = $('.gsPostContent.'+postid).replaceWith(formEdit);

		var quitButton = "<div class=\"quitGSPost "; 
			quitButton += postid;
			quitButton += "\">";
			quitButton += "<a class=\"buttonLeft\" data-postid=\"";
			quitButton += postid;
			quitButton += "\">";
			quitButton += "<p>Quit</p>";
			quitButton += "</a>";
			quitButton += "</div>";
			
		replacedGS = $('.editGSPost.'+postid).replaceWith(quitButton);
	}
	
	//restore content div and buttons
	function restoreGS(postid){
		$('.quitGSPost.'+postid).replaceWith(replacedGS);
		$('.editGSForm.'+postid).replaceWith(replacedG);
	}
	
	//edit message
	function editGSMessage(postID, message){
		$.ajax({
				url: 'editGSPost.php',
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