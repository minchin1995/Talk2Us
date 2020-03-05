$(document).ready(function() {
	//Validate login form when submit is clicked
	$("#login").click(function() {
		var userName = $("#userName").val();
		var passwd = $("#passwd").val();
		
		userName = $.trim(userName);
		passwd = $.trim(passwd);
		
		var uName = checkUName();
		var pWord = checkPWord();
		var match = checkMatch(userName, passwd);
		
		if(uName&&pWord&&match){
			$("#loginForm").submit();
		} else{
			return false;
		}
	});
	
	//validate username
	function checkUName(){
		var userName = $("#userName").val();
		userName = $.trim(userName);
		
		if (userName.length == 0 ){
			$("#errorUName").html("Please enter a Username.");
			$("#userName").addClass('textboxError');
			return false;
		} else {
			$("#errorUName").html("");
			$("#userName").removeClass('textboxError');
			return true;
		}
	}	
	
	//Validate password
	function checkPWord(){
		var passwd = $("#passwd").val();
		passwd = $.trim(passwd);
		
		if (passwd.length == 0 ){
			$("#errorPasswd").html("Please enter a Password.");
			$("#passwd").addClass('textboxError');
			return false;
		} else {
			$("#errorPasswd").html("");
			$("#passwd").removeClass('textboxError');
			return true;
		}
	}
	
	//validate if password match
	function checkMatch(userName, passwd){
		var userName = $("#userName").val();
		var passwd = $("#passwd").val();
		
		userName = $.trim(userName);
		passwd = $.trim(passwd);
		
		if ((userName.length == 0)||(passwd.length == 0 )){
			$("#matchErr").html("");
		}else{
			$.ajax({
				url: 'valLogin.php',
				type: 'POST',
				dataType: "json",
				data: {
					userName: userName,
					passwd: passwd
				},
				success: function(data) {
					if(data.statusLog=="error"){
						$("#matchErr").html(data.message[0].textLog);
						$("#userName").addClass('textboxError');
						$("#passwd").addClass('textboxError');
						return false;
					}else{
						$("#matchErr").html("");
						$("#userName").removeClass('textboxError');
						$("#passwd").removeClass('textboxError');
						$("#loginForm").submit();
					}
				},
				error: function(err) {
					$("#matchErr").html("Error in logging in");
					return false;
				}
			});
		}
	}
	//clear error
	$("#clearLog").click(function() {
		$("#matchErr").html("");
		$("#errorPasswd").html("");
		$("#errorUName").html("");
		
		$("#userName").removeClass('textboxError');
		$("#passwd").removeClass('textboxError');
	});
});