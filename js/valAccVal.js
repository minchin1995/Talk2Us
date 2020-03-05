$(document).ready(function() {
	$("#submitVal").click(function() {
		var emailVal = $("#emailVal").val();
		emailVal = $.trim(emailVal);

		var email = checkEmailFor();
		var check = checkExists(emailVal);
		
		if(email&&check){
			$("#validateAccForm").submit();
		} else{
			return false;
		}
	});

	function validateEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}
	
	//validate account 
	function checkEmailFor(){
		var emailVal = $("#emailVal").val();
		emailVal = $.trim(emailVal);
		
		if (emailVal.length == 0 ){
			$("#errorEmailVal").html("You have not entered an email.");
			$("#emailVal").addClass('textboxError');
			return false;
		} else if (!validateEmail(emailVal)){
			$("#errorEmailVal").html("Please enter a valid email.");
			$("#emailVal").addClass('textboxError');
			return false;
		} else {
			$("#errorEmailVal").html("");
			$("#emailVal").removeClass('textboxError');
			return true;
		}
	}	
	
	//check if email exists and if account is already validated
	function checkExists(email){
		var emailVal = $("#emailVal").val();
		emailVal = $.trim(emailVal);
		
		if ((emailVal.length == 0 )||(!validateEmail(emailVal))){
			$("#errorEmailExists").html("");
		}else{
			$.ajax({
				url: 'valAccVal.php',
				type: 'POST',
				dataType: "json",
				data: {
					email: emailVal,
				},
				success: function(data) {
					if(data.statusFor=="error"){
						$("#errorEmailVal").html(data.message[0].textFor);
						$("#emailVal").addClass('textboxError');
						return false;
					}else{
						$("#errorEmailVal").html("");
						$("#emailVal").removeClass('textboxError');
						$("#validateAccForm").submit();
					}
				},
				error: function(err) {
					console.log(err.responseText);
					$("#errorEmailVal").html("Error");
					return false;
				}
			});
		}
	}

	$("#clearVal").click(function() {
		$("#errorEmailVal").html("");
		
		$("#emailVal").removeClass('textboxError');
	});

});