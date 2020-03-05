$(document).ready(function() {
	$("#addAdmin").click(function(e) {
		var emailAd = $("#email").val();
		emailAd = $.trim(emailAd);
		
		var userName = $("#userName").val();
		userName = $.trim(userName);
		
		var uname = checkUName();
		var email = checkEmailReg();
		var pass = checkPassReg();
		var dob = checkDOB();
		
		if(email&&dob&&pass&&uname){
			//validate if username and email already exists
			$.ajax({
				url: 'valRegister.php',
				type: 'POST',
				dataType: "json",
				data: {
					email: emailAd,
					userName: userName,
				},
				success: function(data) {
					if(data.statusReg=="errorEmail"){
						$("#errorEmailA").html(data.message[0].textReg);
						$("#email").addClass('textboxError');
						return false;
					}else if(data.statusReg=="errorUname"){
						$("#errorUNameA").html(data.message[0].textReg);
						$("#userName").addClass('textboxError');
						return false;
					}else{
						$("#errorEmailA").html("");
						$("#errorUNameA").html("");
						$("#email").removeClass('textboxError');
						$("#userName").removeClass('textboxError');
						$("#createAdminForm").submit();
					}
				},
				error: function(err) {
					console.log(err.responseText);
					return false;
				}
			});
			e.preventDefault();
			return false;
		} else{
			return false;
		}
	});

	function validateEmail(email) {
	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  return regex.test(email);
	}
	
	//validate email
	function checkEmailReg(){
		var email = $("#email").val();
		email = $.trim(email);
		
		if (email.length == 0 ){
			$("#errorEmailA").html("You have not entered an email.");
			$("#email").addClass('textboxError');
			return false;
		} else if (!validateEmail(email)){
			$("#errorEmailA").html("Please enter a valid email.");
			$("#email").addClass('textboxError');
			return false;
		} else {
			$("#errorEmailA").html("");
			$("#email").removeClass('textboxError');
			return true;
		}
	}	
	
	//validate password
	function checkPassReg(){
		var passwd = $("#passwd").val();
		passwd = $.trim(passwd);
		
		var cpasswd = $("#cpasswd").val();
		cpasswd = $.trim(cpasswd);
		
		if (passwd.length == 0 ){
			$("#errorPwordA").html("You have not entered a password.");
			$("#passwd").addClass('textboxError');
			$("#errorCPWordA").html("");
			$("#cpasswd").removeClass('textboxError');
			return false;
		} else if (passwd.length > 15 ){
			$("#errorPwordA").html("Password should not be more than 15 character.");
			$("#passwd").addClass('textboxError');
			$("#errorCPWordA").html("");
			$("#cpasswd").removeClass('textboxError');
			return false;
		} else if (passwd.length < 6 ){
			$("#errorPwordA").html("Password should not be less than 6 character.");
			$("#passwd").addClass('textboxError');
			$("#errorCPWordA").html("");
			$("#cpasswd").removeClass('textboxError');
			return false;
		} else if (cpasswd.length == 0 ){
			$("#errorCPWordA").html("You have not entered a confirm password.");
			$("#cpasswd").addClass('textboxError');
			$("#errorPwordA").html("");
			$("#passwd").removeClass('textboxError');
			return false;
		} else if (passwd != cpasswd){
			$("#errorPwordA").html("Password and confirm password do not match");
			$("#passwd").addClass('textboxError');
			$("#cpasswd").addClass('textboxError');
			$("#errorCPWordA").html("");
			return false;
		} else {
			$("#errorPwordA").html("");
			$("#passwd").removeClass('textboxError');
			$("#errorCPWordA").html("");
			$("#cpasswd").removeClass('textboxError');
			return true;
		}
	}	
	
	function validateUname(userName) {
	  var regex = /^[a-zA-Z0-9_.-]*$/;
	  return regex.test(userName);
	}
	
	//validate username
	function checkUName(){
		var userName = $("#userName").val();
		userName = $.trim(userName);
		
		if (userName.length == 0 ){
			$("#errorUNameA").html("Please enter a Username.");
			$("#userName").addClass('textboxError');
			return false;
		} else if (userName.length > 15 ){
			$("#errorUNameA").html("Username should not be more than 15 character");
			$("#userName").addClass('textboxError');
			return false;
		} else if (userName.length < 6 ){
			$("#errorUNameA").html("Username should not be less than 6 character.");
			$("#userName").addClass('textboxError');
			return false;
		}  else if (!validateUname(userName)){
			$("#errorUNameA").html("Username format is wrong.");
			$("#userName").addClass('textboxError');
			return false;
		} else {
			$("#errorUNameA").html("");
			$("#userName").removeClass('textboxError');
			return true;
		}
	}	
	
	function validateDOB(dob) {
	  var regex = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
	  return regex.test(dob);
	}
	
	// validate date of birth
	function checkDOB(){
		var dob = $("#dob").val();
		dob = $.trim(dob);
		
		var d = new Date();

		var month = d.getMonth()+1;
		var day = d.getDate();
		var year = d.getFullYear()-18;
		
		var output = year + '-' +
			(month<10 ? '0' : '') + month + '-' +
			(day<10 ? '0' : '') + day;
			
		console.log(output);
		console.log(dob);

		if (dob.length == 0 ){
			$("#errorDobA").html("Please enter a date of birth.");
			$("#dob").addClass('textboxError');
			return false;
		} else if (!validateDOB(dob)){ 
			$("#errorDobA").html("Date of birth format is wrong.");
			$("#dob").addClass('textboxError');
			return false;
		} else if (dob>output){
			$("#errorDobA").html("You have to be older than 18 years old.");
			$("#dob").addClass('textboxError');
			return false;
		} else {
			$("#errorDobA").html("");
			$("#dob").removeClass('textboxError');
			return true;
		}
	}
	//clear error
	$("#clearAdmin").click(function() {
		$("#errorEmailA").html("");
		$("#errorUNameA").html("");
		$("#errorDobA").html("");
		$("#errorPwordA").html("");
		$("#errorCPWordA").html("");
		
		$("#email").removeClass('textboxError');
		$("#userName").removeClass('textboxError');
		$("#dob").removeClass('textboxError');
		$("#passwd").removeClass('textboxError');
		$("#cpasswd").removeClass('textboxError');
	});
});