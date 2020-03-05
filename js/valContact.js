$(document).ready(function() {
	//validate for unlogged in users
	$("#submitCon").click(function() {
		var email = checkEmailCon();
		var prob = checkProb();

		if(email&&prob){
			$("#contactForm").submit();
		} else{
			return false;
		}
	});
	
	//validation for logged in users
	$("#submitConLog").click(function() {
		var prob = checkProb();
		
		if(prob){
			$("#contactForm").submit();
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
	function checkEmailCon(){
		var emailCon = $("#emailCon").val();
		emailCon = $.trim(emailCon);
		
		if (emailCon.length == 0 ){
			$("#errorEmailCon").html("You have not entered an email.");
			$("#emailCon").addClass('textboxError');
			return false;
		} else if (!validateEmail(emailCon)){
			$("#errorEmailCon").html("Please enter a valid email.");
			$("#emailCon").addClass('textboxError');
			return false;
		} else {
			$("#errorEmailCon").html("");
			$("#emailCon").removeClass('textboxError');
			return true;
		}
	}	
	
	//validate problems
	function checkProb(){
		var problems = $("#problems").val();
		problems = $.trim(problems);
		problems = problems.replace(/"/g, "&34;").replace(/'/g, "&39;").replace(/\n/g, "&#10;").replace(/<br>/g, "&#10;");
		
		if (problems.length == 0 ){
			$("#errorProb").html("You have not entered any problems you which to address.");
			$("#problems").addClass('textboxError');
			return false;
		} if (problems.length > 2000 ){
			$("#errorProb").html("Problems should not be more than 2000 character.");
			$("#problems").addClass('textboxError');
			return false;
		} else {
			$("#errorProb").html("");
			$("#problems").removeClass('textboxError');
			return true;
		}
	}
	
	//clear error
	$("#clearCon").click(function() {
		$("#errorProb").html("");
		$("#errorEmailCon").html("");
		
		$("#message").removeClass('textboxError');
		$("#emailCon").removeClass('textboxError');
	});
});