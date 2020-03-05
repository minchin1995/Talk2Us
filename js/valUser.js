$(document).ready(function() {
	//Validate login form when submit is clicked
	$("#updateUser").click(function(e) {
		var emailU = $("#email").val();
		var userName = $("#userName").val();
		var genUname = $("#genUname").val();
		var passwd = $("#passwd").val();
		var cpasswd = $("#cpasswd").val();
		var dob = $("#dob").val();
		
		emailU = $.trim(emailU);
		userName = $.trim(userName);
		genUname = $.trim(genUname);
		passwd = $.trim(passwd);
		cpasswd = $.trim(cpasswd);
		dob = $.trim(dob);
		
		var uname = checkUName();
		var email = checkEmailReg();
		var pass = checkPassReg();
		var dobC = checkDOB();

		if(email&&dobC&&pass&&uname){
			if ((userName.length == 0)&&(emailU.length == 0)){
				$("#editUserForm").submit();
			}else {
				$.ajax({
					url: 'getUser.php',
					type: 'POST',
					dataType: "json",
					data: {
						genUname: genUname
					},
					success: function(data) {
						console.log(data);
						var oriUname = data.result;
						var oriMail = data.result2;
						
						if((oriUname == userName)&&(oriMail == emailU)&&(passwd.length == 0)&&(cpasswd.length == 0)&&(dob.length == 0)){
							$("#errorNone").html("There is nothing to edit.");
							return false;
						}else if((oriUname == userName)&&(oriMail == emailU)){
							$("#editUserForm").submit();
						}else if((oriUname != userName)&&(oriMail != emailU)&&(userName.length != 0)&&(emailU.length != 0)){
							$("#errorNone").html("");
							//validate if username and email already exists
							$.ajax({
								url: 'valUser1.php',
								type: 'POST',
								dataType: "json",
								data: {
									username: userName,
									email: emailU
								},
								success: function(data) {
									if(data.statusU=="errorU"){
										$("#errorEmailU").html("");
										$("#email").removeClass('textboxError');
										$("#errorUNameU").html(data.message[0].textU);
										$("#userName").addClass('textboxError');
										return false;
									}else if(data.statusU=="errorM"){
										$("#errorUNameU").html("");
										$("#userName").removeClass('textboxError');
										$("#errorEmailU").html(data.message[0].textU);
										$("#email").addClass('textboxError');
										return false;
									}else if(data.statusU=="error"){
										$("#errorEmailU").html("");
										$("#email").removeClass('textboxError');
										$("#errorUNameU").html(data.message[0].textU);
										$("#userName").addClass('textboxError');
										return false;
									}else{
										$("#errorUNameU").html("");
										$("#errorEmailU").html("");
										$("#userName").removeClass('textboxError');
										$("#email").removeClass('textboxError');
										$("#editUserForm").submit();
									}
								},
								error: function(err) {
									$("#errorUNameU").html("Error in editing users");
									return false;
								}
							});
						}else if((oriUname != userName)&&(oriMail == emailU)&&(userName.length != 0)){
							$("#errorNone").html("");
							//validate if username already exists
							$.ajax({
								url: 'valUser2.php',
								type: 'POST',
								dataType: "json",
								data: {
									username: userName
								},
								success: function(data) {
									console.log(data);
									if(data.statusU=="error"){
										$("#errorEmailU").html("");
										$("#email").removeClass('textboxError');
										$("#errorUNameU").html(data.message[0].textU);
										$("#userName").addClass('textboxError');
										return false;
									}else{
										$("#errorUNameU").html("");
										$("#errorEmailU").html("");
										$("#userName").removeClass('textboxError');
										$("#email").removeClass('textboxError');
										$("#editUserForm").submit();
									}
								},
								error: function(err) {
									$("#errorUNameU").html("Error in editing user");
									return false;
								}
							});
						}else if((oriUname == userName)&&(oriMail != emailU)&&(emailU.length != 0)){
							$("#errorNone").html("");
							//valdiate if email already exists
							$.ajax({
								url: 'valUser3.php',
								type: 'POST',
								dataType: "json",
								data: {
									email: emailU
								},
								success: function(data) {
									if(data.statusU=="error"){
										$("#errorUNameU").html("");
										$("#userName").removeClass('textboxError');
										$("#errorEmailU").html(data.message[0].textU);
										$("#email").addClass('textboxError');
										return false;
									}else{
										$("#errorUNameU").html("");
										$("#errorEmailU").html("");
										$("#userName").removeClass('textboxError');
										$("#email").removeClass('textboxError');
										$("#editUserForm").submit();
									}
								},
								error: function(err) {
									$("#errorUNameU").html("Error in editing user");
									return false;
								}
							});
						}
					},
					error: function(err) {
						$("#errorUNameU").html("Error in editing user.");
						return false;
					}
				});
			} 
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
	function checkEmailReg(){
		var email = $("#email").val();
		email = $.trim(email);
		
		if (email.length != 0 ){ 
			 if (!validateEmail(email)){
				$("#errorEmailU").html("Please enter a valid email.");
				$("#email").addClass('textboxError');
				return false;
			} else {
				$("#errorEmailU").html("");
				$("#email").removeClass('textboxError');
				return true;
			}
		} else {
			$("#errorEmailU").html("");
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
		
		if (passwd.length != 0 ){
			if (passwd.length > 15 ){
				$("#errorPwordU").html("Password should not be more than 15 character.");
				$("#passwd").addClass('textboxError');
				$("#errorCPWordU").html("");
				$("#cpasswd").removeClass('textboxError');
				return false;
			} else if (passwd.length < 6 ){
				$("#errorPwordU").html("Password should not be less than 6 character.");
				$("#passwd").addClass('textboxError');
				$("#errorCPWordU").html("");
				$("#cpasswd").removeClass('textboxError');
				return false;
			} else if (cpasswd.length == 0 ){
				$("#errorCPWordU").html("You have not entered a confirm password.");
				$("#cpasswd").addClass('textboxError');
				$("#errorPwordU").html("");
				$("#passwd").removeClass('textboxError');
				return false;
			} else if (passwd != cpasswd){
				$("#errorPwordU").html("Password and confirm password do not match");
				$("#passwd").addClass('textboxError');
				$("#cpasswd").addClass('textboxError');
				$("#errorCPWordU").html("");
				return false;
			} else {
				$("#errorPwordU").html("");
				$("#passwd").removeClass('textboxError');
				$("#errorCPWordU").html("");
				$("#cpasswd").removeClass('textboxError');
				return true;
			}
		} else {
			$("#errorPwordU").html("");
			$("#passwd").removeClass('textboxError');
			$("#errorCPWordU").html("");
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
		
		if (userName.length != 0 ){
			if (userName.length > 15 ){
				$("#errorUNameU").html("Username should not be more than 15 character");
				$("#userName").addClass('textboxError');
				return false;
			} else if (userName.length < 6 ){
				$("#errorUNameU").html("Username should not be less than 6 character.");
				$("#userName").addClass('textboxError');
				return false;
			}  else if (!validateUname(userName)){
				$("#errorUNameU").html("Username format is wrong.");
				$("#userName").addClass('textboxError');
				return false;
			} else {
				$("#errorUNameU").html("");
				$("#userName").removeClass('textboxError');
				return true;
			}
		} else {
			$("#errorUNameU").html("");
			$("#userName").removeClass('textboxError');
			return true;
		}
	}	
	
	function validateDOB(dob) {
	  var regex = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
	  return regex.test(dob);
	}
	
	//validate date of borth
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
			
		if (dob.length != 0 ){
			if (!validateDOB(dob)){ 
				$("#errorDobU").html("Date of birth format is wrong.");
				$("#dob").addClass('textboxError');
				return false;
			} else if (dob>output){
				$("#errorDobU").html("You have to be older than 18 years old.");
				$("#dob").addClass('textboxError');
				return false;
			} else {
				$("#errorDobU").html("");
				$("#dob").removeClass('textboxError');
				return true;
			}
		} else {
			$("#errorDobU").html("");
			$("#dob").removeClass('textboxError');
			return true;
		}
	}
	
	//clear all errors
	$("#clearUser").click(function() {
		$("#errorEmailU").html("");
		$("#errorUNameU").html("");
		$("#errorDobU").html("");
		$("#errorPwordU").html("");
		$("#errorCPWordU").html("");
		$("#errorNone").html("");
		
		$("#email").removeClass('textboxError');
		$("#userName").removeClass('textboxError');
		$("#dob").removeClass('textboxError');
		$("#passwd").removeClass('textboxError');
		$("#cpasswd").removeClass('textboxError');
	});
});