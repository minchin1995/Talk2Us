<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

    require_once("function.php"); // Include header to the page

	echo makePageStart("ImaSuperFan - About Us");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
	
		<h1><strong>About Us</strong></h1>

		<div class="container">
			<div class="col-md-6">
			  <img src="img/work2.gif" alt="Man working" class="img-responsive spaceBottom centerImage" />
			</div>
		
			<div class="col-md-6">
			<h2 class="aboutUsHeader">Work stress</h2>
			  <p>
				 Stress due to work isn't uncommon among Malaysians. In 2015, The Malaysia Health Ministry have found out that those who suffer from mental health problems come from family with lower incomes and the lowest percentage by occupation is actually among employees from the government sector through the National Health and Morbidity Survey (NHMS). An increase can also be found where individual above 16 rose from 11.2 per cent to 29.2 per cent in 2015.
			  </p> 
			  
			  <p>
				 Many do not have an outlet to deal with this extra stress. This is why Talk2Us exists for this reason.
				 To provide an outlet for people to talk about their problems about work and relive their stress. 
			  </p>
			</div>
	  </div>
	  
	<div class="container space">
	<h2 class="aboutUsHeader">Talk2Us Features</h2>
		<p>Features of Talk2Us include:</p>
		<ul>
		<li><span class="bold">Forum</span> - Talk about work stress by posting messages on our forum</li>
		<li><span class="bold">Group support</span> - Users can apply for group support and talk with other users who deal with the same problem.</li>
		<li><span class="bold">Chat</span> - Chat with other users in regards of their problems.</li>
		<li><span class="bold">Blog</span> - Write about your experiences and read about others experiences</li>
		</ul>
	</div>
		
		<div class="container">
			<div class="col-md-6">
			<h2 class="aboutUsHeader">Using Talk2Us</h2>
			 <p>
				To access the features of Talk2Us, one needs to create an account. The creation of an account is free. We only require a user's email to confirm their identity and user's birth date to confirm their date of birth. Please be reminded that this service is only for adults that are age 18 and above.
			</p>
			
			<p>
				For further information, please visit the resources page. We can be contacted through the  <a href="contact.php">contact page</a> on this website or the email <a href="mailto:neece205@gmail.com">neece</a>.
			</p>
			
			<p>
				We hope Malaysians will have by using Talk2Us, Malaysian's can deal with work stress better and lead a healthier life.
				
			</p>
			</div>
			
			<div class="col-md-6">
			  <img src="img/work1.gif" alt="Man working" class="img-responsive spaceBottom centerImage" />
			</div>

	  </div>

	</div>
</section>
 
<?php
	echo makeFooter();
  ?>
