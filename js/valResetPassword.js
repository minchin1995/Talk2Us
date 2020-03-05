$(document).ready(function() {
	$("#submitReset").click(function(e) {
		var emailReset = $("#emailReset").val();
		emailReset = $.trim(emailReset);

		var email = checkEmailRes();
		var pass = checkPassRes();
		
		if(email&&pass){
			//validate if email exists 
			$.ajax({
				url: 'valForget.php',
				type: 'POST',
				dataType: "json",
				data: {
					email: emailReset,
				},
				success: function(data) {
					$("#errorPassReset").html("");
					$("#errorCPassReset").html("");

					$("#cpasswdReset").removeClass('textboxError');
					$("#passwdReset").removeClass('textboxError');
					if(data.statusFor=="error"){
						$("#errorEmailReset").html("");
						$("#errorEmailExistsRes").html(data.message[0].textFor);
						$("#emailReset").addClass('textboxError');
						return false;
					}else{
						$("#errorEmailExistsRes").html("");
						$("#emailReset").removeClass('textboxError');
						$("#resetPasswordForm").submit();
					}
				},
				error: function(err) {
					console.log(err.responseText);
					$("#errorEmailExistsRes").html("Error");
					return false;
				}
			});
			e.preventDefault();
			return false;
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
	function checkEmailRes(){
		var emailReset = $("#emailReset").val();
		emailReset = $.trim(emailReset);
		
		if (emailReset.length == 0 ){
			$("#errorEmailReset").html("You have not entered an email.");
			$("#emailReset").addClass('textboxError');
			return false;
		} else if (!validateEmail(emailReset)){
			$("#errorEmailReset").html("Please enter a valid email.");
			$("#emailReset").addClass('textboxError');
			return false;
		} else {
			$("#errorEmailReset").html("");
			$("#emailReset").removeClass('textboxError');
			return true;
		}
	}	
	
	//validate password
	function checkPassRes(){
		var passwdReset = $("#passwdReset").val();
		passwdReset = $.trim(passwdReset);
		
		var cpasswdReset = $("#cpasswdReset").val();
		cpasswdReset = $.trim(cpasswdReset);
		
		if (passwdReset.length == 0 ){
			$("#errorPassReset").html("You have not entered a password.");
			$("#passwdReset").addClass('textboxError');
			$("#errorCPassReset").html("");
			$("#cpasswdReset").removeClass('textboxError');
			return false;
		} else if (passwdReset.length > 15 ){
			$("#errorPassReset").html("Password should not be more than 15 character.");
			$("#passwdReset").addClass('textboxError');
			$("#errorCPassReset").html("");
			$("#cpasswdReset").removeClass('textboxError');
			return false;
		} else if (passwdReset.length < 6 ){
			$("#errorPassReset").html("Password should not be less than 6 character.");
			$("#passwdReset").addClass('textboxError');
			$("#errorCPassReset").html("");
			$("#cpasswdReset").removeClass('textboxError');
			return false;
		} else if (cpasswdReset.length == 0 ){
			$("#errorCPassReset").html("You have not entered a confirm password.");
			$("#cpasswdReset").addClass('textboxError');
			$("#errorPassReset").html("");
			$("#passwdReset").removeClass('textboxError');
			return false;
		} else if (passwdReset != cpasswdReset){
			$("#errorPassReset").html("Password and confirm password do not match");
			$("#passwdReset").addClass('textboxError');
			$("#cpasswdReset").addClass('textboxError');
			$("#errorCPassReset").html("");
			return false;
		} else {
			$("#errorPassReset").html("");
			$("#passwdReset").removeClass('textboxError');
			$("#errorCPassReset").html("");
			$("#cpasswdReset").removeClass('textboxError');
			return true;
		}
	}	
	
	//clear error
	$("#clearReset").click(function() {
		$("#errorEmailExistsRes").html("");
		$("#errorEmailReset").html("");
		$("#errorPassReset").html("");
		$("#errorCPassReset").html("");
		
		$("#emailReset").removeClass('textboxError');
		$("#cpasswdReset").removeClass('textboxError');
		$("#passwdReset").removeClass('textboxError');
	});
});