$(document).ready(function() {
	$("#submitForget").click(function() {
		var emailForget = $("#emailForget").val();
		emailForget = $.trim(emailForget);

		var email = checkEmailFor();
		var check = checkExists(emailForget);
		
		if(email&&check){
			$("#forgetPasswordForm").submit();
		} else{
			return false;
		}
	});
	//email format
	function validateEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}
	//validate email
	function checkEmailFor(){
		var emailForget = $("#emailForget").val();
		emailForget = $.trim(emailForget);
		
		if (emailForget.length == 0 ){
			$("#errorEmailForget").html("You have not entered an email.");
			$("#emailForget").addClass('textboxError');
			return false;
		} else if (!validateEmail(emailForget)){
			$("#errorEmailForget").html("Please enter a valid email.");
			$("#emailForget").addClass('textboxError');
			return false;
		} else {
			$("#errorEmailForget").html("");
			$("#emailForget").removeClass('textboxError');
			return true;
		}
	}	
	//validate if email exists
	function checkExists(email){
		var emailForget = $("#emailForget").val();
		emailForget = $.trim(emailForget);
		
		if ((emailForget.length == 0 )||(!validateEmail(emailForget))){
			$("#errorEmailExists").html("");
		}else{
			$.ajax({
				url: 'valForget.php',
				type: 'POST',
				dataType: "json",
				data: {
					email: emailForget,
				},
				success: function(data) {
					if(data.statusFor=="error"){
						$("#errorEmailExists").html(data.message[0].textFor);
						$("#emailForget").addClass('textboxError');
						return false;
					}else{
						$("#errorEmailExists").html("");
						$("#emailForget").removeClass('textboxError');
						$("#forgetPasswordForm").submit();
						return false;
					}
				},
				error: function(err) {
					console.log(err.responseText);
					$("#errorEmailExists").html("Error");
					return false;
				}
			});
		}
	}
	//clear error
	$("#clearForget").click(function() {
		$("#errorEmailExists").html("");
		$("#errorEmailForget").html("");
		
		$("#emailForget").removeClass('textboxError');
	});

});