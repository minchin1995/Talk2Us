$(document).ready(function() {
	$("#submitReg").click(function(e) {
		var emailReg = $("#email").val();
		emailReg = $.trim(emailReg);
		
		var userName = $("#userName").val();
		userName = $.trim(userName);
		
		var uname = checkUName();
		var email = checkEmailReg();
		var pass = checkPassReg();
		var dob = checkDOB();
		var term = checkTerm();
		
		if(email&&dob&&pass&&uname&&term){
			//validate if email or username already exists
			$.ajax({
				url: 'valRegister.php',
				type: 'POST',
				dataType: "json",
				data: {
					email: emailReg,
					userName: userName,
				},
				success: function(data) {
					if(data.statusReg=="errorEmail"){
						$("#errorEmailReg").html(data.message[0].textReg);
						$("#email").addClass('textboxError');
						return false;
					}else if(data.statusReg=="errorUname"){
						$("#errorUNameReg").html(data.message[0].textReg);
						$("#userName").addClass('textboxError');
						return false;
					}else{
						$("#errorEmailReg").html("");
						$("#errorUNameReg").html("");
						$("#email").removeClass('textboxError');
						$("#userName").removeClass('textboxError');
						$("#registerForm").submit();
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
			$("#errorEmailReg").html("You have not entered an email.");
			$("#email").addClass('textboxError');
			return false;
		} else if (!validateEmail(email)){
			$("#errorEmailReg").html("Please enter a valid email.");
			$("#email").addClass('textboxError');
			return false;
		} else {
			$("#errorEmailReg").html("");
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
			$("#errorPwordReg").html("You have not entered a password.");
			$("#passwd").addClass('textboxError');
			$("#errorCPWordReg").html("");
			$("#cpasswd").removeClass('textboxError');
			return false;
		} else if (passwd.length > 15 ){
			$("#errorPwordReg").html("Password should not be more than 15 character.");
			$("#passwd").addClass('textboxError');
			$("#errorCPWordReg").html("");
			$("#cpasswd").removeClass('textboxError');
			return false;
		} else if (passwd.length < 6 ){
			$("#errorPwordReg").html("Password should not be less than 6 character.");
			$("#passwd").addClass('textboxError');
			$("#errorCPWordReg").html("");
			$("#cpasswd").removeClass('textboxError');
			return false;
		} else if (cpasswd.length == 0 ){
			$("#errorCPWordReg").html("You have not entered a confirm password.");
			$("#cpasswd").addClass('textboxError');
			$("#errorPwordReg").html("");
			$("#passwd").removeClass('textboxError');
			return false;
		} else if (passwd != cpasswd){
			$("#errorPwordReg").html("Password and confirm password do not match");
			$("#passwd").addClass('textboxError');
			$("#cpasswd").addClass('textboxError');
			$("#errorCPWordReg").html("");
			return false;
		} else {
			$("#errorPwordReg").html("");
			$("#passwd").removeClass('textboxError');
			$("#errorCPWordReg").html("");
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
			$("#errorUNameReg").html("Please enter a Username.");
			$("#userName").addClass('textboxError');
			return false;
		} else if (userName.length > 15 ){
			$("#errorUNameReg").html("Username should not be more than 15 character");
			$("#userName").addClass('textboxError');
			return false;
		} else if (userName.length < 6 ){
			$("#errorUNameReg").html("Username should not be less than 6 character.");
			$("#userName").addClass('textboxError');
			return false;
		}  else if (!validateUname(userName)){
			$("#errorUNameReg").html("Username format is wrong.");
			$("#userName").addClass('textboxError');
			return false;
		} else {
			$("#errorUNameReg").html("");
			$("#userName").removeClass('textboxError');
			return true;
		}
	}	
	
	function validateDOB(dob) {
	  var regex = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
	  return regex.test(dob);
	}
	
	//validate date of birth
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
			
		if (dob.length == 0 ){
			$("#errorDobReg").html("Please enter a date of birth.");
			$("#dob").addClass('textboxError');
			return false;
		} else if (!validateDOB(dob)){ 
			$("#errorDobReg").html("Date of birth format is wrong.");
			$("#dob").addClass('textboxError');
			return false;
		} else if (dob>output){
			$("#errorDobReg").html("You have to be older than 18 years old.");
			$("#dob").addClass('textboxError');
			return false;
		} else {
			$("#errorDobReg").html("");
			$("#dob").removeClass('textboxError');
			return true;
		}
	}
	//validate terms and conditions checkbox
	function checkTerm(){
		if ($('#termsChkbx').is(':checked')) {
			$("#errorCheckTerm").html("");
			return true;
		}else{
			$("#errorCheckTerm").html("You have not checked the terms and conditions box.");
			return false;
		}
	}
	//clear error
	$("#clearReg").click(function() {
		$("#errorEmailReg").html("");
		$("#errorUNameReg").html("");
		$("#errorDobReg").html("");
		$("#errorPwordReg").html("");
		$("#errorCPWordReg").html("");
		$("#errorCheckTerm").html("");
		
		$("#email").removeClass('textboxError');
		$("#userName").removeClass('textboxError');
		$("#dob").removeClass('textboxError');
		$("#passwd").removeClass('textboxError');
		$("#cpasswd").removeClass('textboxError');
	});
});