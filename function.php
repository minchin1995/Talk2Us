<?php
ob_start();

/*
* Create page
* @param title title of page
*/
function makePageStart($title) {
$pageStartContent = <<<PAGESTART
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>$title</title>

 
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/animate.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/jquery.bxslider.css">
  <link href="css/style.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Caveat" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
  
  <script src="js/jquery-2.1.1.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- =======================================================
    Theme Name: MeFamily
    Theme URL: https://bootstrapmade.com/family-multipurpose-html-bootstrap-template-free/
    Author: BootstrapMade
    Author URL: https://bootstrapmade.com
  ======================================================= -->
</head>

<body>
        
	
PAGESTART;
	$pageStartContent .="\n";
	return $pageStartContent;
	
}

/*
* Create navigation bar
*/
function makeNav($header){

	echo "
	    <nav class=\"navbar navbar-default navbar-fixed-top\">
    <div class=\"container\">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class=\"navbar-header\">
        <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\".navbar-collapse.collapse\">
					<span class=\"sr-only\">Toggle navigation</span>
					<span class=\"icon-bar\"></span>
					<span class=\"icon-bar\"></span>
					<span class=\"icon-bar\"></span>
				</button>
        <a class=\"navbar-brand\" href=\"index.php\"><img src=\"img/logo1.png\" id=\"headerLogo\" alt=\"Talk2Us Logo\" /></a>
      </div>
      <div class=\"navbar-collapse collapse\">
        <div class=\"menu\">
          <ul class=\"nav nav-tabs\" role=\"tablist\">
            <li role=\"presentation\"><a href=\"index.php\">Home</a></li>
            <li role=\"presentation\"><a href=\"aboutUs.php\">About</a></li>
            <li role=\"presentation\"><a href=\"forum.php\">Forum</a></li>
			<li role=\"presentation\"><a href=\"groupSupport.php\">Group</a></li>
            <li role=\"presentation\"><a href=\"blog.php\">Blog</a></li>
            <li role=\"presentation\"><a href=\"chat.php\">Chat</a></li>";
			if (isset($_SESSION['userID'])){
				if ($_SESSION['role'] == "1") {
					echo"<li role=\"presentation\"><a href=\"Admin.php\">Admin</a></li>";
				} 
				echo	"<li role=\"presentation\" class=\"active\"><a href=\"User.php\">".$_SESSION['username']."</a></li>";
				echo	"<li role=\"presentation\" class=\"active\"><a href=\"logout.php\">Log Out</a></li>";
			} else {
				echo"<li role=\"presentation\" class=\"active\"><a href=\"register.php\">Register</a></li>
					<li role=\"presentation\" class=\"active\"><a href=\"login.php\">Log In</a></li>";
			}
			
			
          echo "</ul>
        </div>
      </div>
    </div>
  </nav>";
	
}

/*
* Create to the top button
*/
function makeToTop (){
	echo "<button onclick=\"topFunction()\" id=\"myBtn\" title=\"Go to top\"><i class=\"fa fa-arrow-up fa-1x\"></i></button>";
}

/*
* Create resize font size button
*/
function resizeButtons() {
	
$resizeBtn = <<< RESIZEBTN
<div id="resize-button" class="resize-button">
	<a id="close-div">&laquo;</a>
	<small>Font size:</small>
	<button id="increase" onclick="resizeText(1)">+</button> <br/> <button id="decrease" onclick="resizeText(-1)">-</button>
	</div>
	<script src="js/fontChange.js"></script>
RESIZEBTN;

$resizeBtn .="\n";
return $resizeBtn;

}

/*
* Create footer of page
*/
function makeFooter() {
$footContent = <<< FOOT
<footer>
    <div class="inner-footer">
      <div class="container">
        <div class="row">
		
		<div class="col-md-4 f-contact greyText">
            <h3 class="widgetheading">Contact Us</h3>
            <a href="mailto:neece205@gmail.com">
              <p><i class="fa fa-envelope"></i>neece205@gmail.com</p>
            </a>
			 <a href="#">
				<p><i class="fa fa-facebook fa-1x"></i> Talk2Us</p>
			</a>
			<a href="contact.php">
				<p><i class="fa fa-envelope fa-1x"></i> Contact us on this site</p>
			</a>
          </div>
		  
          <div class="col-md-4 l-posts greyText">
            <ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="aboutUs.php">About</a></li>
				<li><a href="forum.php">Forum</a></li>
				<li><a href="groupSupport.php">Group Support</a></li>
				<li><a href="blog.php">Blog</a></li>
            </ul>
          </div>
		  
		  <div class="col-md-4 l-posts greyText">
            <ul>
              <li><a href="chat.php">Chat</a></li>
              <li><a href="terms.php">Terms and Conditions</a></li>
              <li><a href="privacy.php">Privacy Policy</a></li>
              <li><a href="faq.php">FAQ</a></li>
              <li><a href="resources.php">More Resources</a></li>
            </ul>
          </div>
          
        </div>
      </div>
    </div>

    <div class="last-div">
      <div class="container">
        <div class="row">
          <div class="copyright">
            &copy; 2018 Talk2Us
            <div class="credits">
              <!--
                All the links in the footer should remain intact.
                You can delete the links only if you purchased the pro version.
                Licensing information: https://bootstrapmade.com/license/
                Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=MeFamily
              -->
              <a href="https://bootstrapmade.com/">Bootstrap Themes</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
          </div>
		  
        </div>
      </div>
    </div>
  </footer>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

  
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <script src="js/wow.min.js"></script>
  <script src="js/jquery.easing.1.3.js"></script>
  <script src="js/jquery.bxslider.min.js"></script>
  <script src="js/jquery.isotope.min.js"></script>
  <script src="js/fancybox/jquery.fancybox.pack.js"></script>
  <script src="js/functions.js"></script>
  
  <!-- Login -->
  <script src="js/valLogin.js"></script>
  <script src="js/valPasswordForget.js"></script>
  <script src="js/valResetPassword.js"></script>
  
  <!-- Register -->
  <script src="js/valRegister.js"></script>
  <script src="js/valAccVal.js"></script>
  
  <!-- Contact -->
  <script src="js/valContact.js"></script>
  
  <!-- User -->
  <script src="js/valUser.js"></script>
  
  <!-- Admin -->
  <script src="js/table.js"></script>
  <script src="js/valAddAdmin.js"></script>
  
  <!-- Chat -->
  <script src="js/valChatReminder.js"></script>
  
  <!-- Blog -->
  <script src="js/valSubmitBlog.js"></script>
  <script src="js/valPostBlog.js"></script>
  <script src="js/valPostBlogSub.js"></script>
  <script src="js/valEditBlogCat.js"></script>
  <script src="js/valEditBlogPost.js"></script>
  <script src="js/valReportBlog.js"></script>
  <script src="js/searchBlog.js"></script>
  
  <!-- FAQ -->
  <script src="js/faq.js"></script>
  <script src="js/valCreateFAQ.js"></script>
  <script src="js/valEditFAQTopic.js"></script>
  <script src="js/valEditFAQ.js"></script>

  <!-- Forum -->
  <script src="js/postDB.js"></script>
  <script src="js/editDB.js"></script>
  <script src="js/valEditDBCat.js"></script>
  <script src="js/valEditDB.js"></script>
  <script src="js/valCreateTopic.js"></script> 
  <script src="js/searchDB.js"></script>
  <script src="js/valReportPost.js"></script>
 
  <!-- Group Support -->
  <script src="js/postGS.js"></script>
  <script src="js/searchGS.js"></script>
  <script src="js/searchGSAdmin.js"></script>
  <script src="js/valAssignGS.js"></script>
  <script src="js/valReportGS.js"></script>
  <script src="js/editGS.js"></script>
  <script src="js/valApplyGS.js"></script>
  <script src="js/valEditGS.js"></script>
  
  <!-- Report -->
   <script src="js/valRepDB.js"></script>
   <script src="js/valRepGS.js"></script>
   
   <script src="js/chat.js"></script>
   
  <script src="js/toTopButton.js"></script>  
  <script src="js/datePicker.js"></script>  
  
  <script>
    wow = new WOW({}).init();
  </script>

</body>

</html>
FOOT;

$footContent .="\n";
return $footContent;


}

/*
* Error message for object not existing
* @param name the object that does not exists
*/
function noexist ($name){
	echo "<p>There are no $name here</p>";
}

/*
* Error message for user not logging 
*/
function nolog (){
	echo "<p>Please log in to view page.</p>";
	echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
}

/*
* Error message for user already logged in
*/
function logged (){
	echo "<p>You are already logged in.</p>";
	echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
}

/*
* Error message for wrong role
*/
function wronglog ($name){
	echo "<p>Only $name can view this page.</p>";
	echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
}

/*
* Error message for already reporting a post or blog
*/
function alreadyReport ($name){
	echo "<p>You have already reported this $name.</p>";
}
?>