<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

    require_once("function.php"); // Include header to the page

	echo makePageStart("ImaSuperFan - Terms and Conditions");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
<section class="box">
	<div class="container top-content">
	
		<h1><strong>Privacy Policy</strong></h1>

		<p>
		Talk2US is committed to protect the privacy and security of any personal data that Company may provide through the forms/surveys posted on-line. Personal data includes information that can be linked or directed to a specific individual for example name, address, phone number or email address. Should Talk2Us asks the Company to provide certain information by which an individual/personnel can be identified when using this website, then the Company can be assured that it will only be used for such purpose it is requested.
		</p>

 
		<p>
		In accordance with Personal Data Protection Act 2010 of Malaysia (PDPA), any personal data provided by the Company shall be protected according to the Act and Talk2US shall not be held liable nor responsible for any information and/or contents in this Form/surveys that has been revealed and/or abused at large and/or already within public knowledge and for any risks and/or occurrences by publishing any of the contents and informationgiven herein. All the information provided by the Company is for the utilization of Talk2US and its verified strategic partners.
		</p>
 
		<p>
		Request for access to and correction of any information submitted can be directed to us at neece205@gmail.com
		 </p>

		<p>Your Privacy</p>

		<p>This site is to explain the privacy policy which includes the use and the protection of information submitted by the visitor. If you make any transaction or send e-mails which contain personal information, this information may be shared with other public agencies to help us to provide better and effective service</p>

		<p>Information gathered</p>
		<p>
		No personal data will be collected while browsing this website unless information provided by you through e-mails or online application.
		</p>
		
		<p>What will happen if I were to make links to other website?</p>
		<p>
		The website has links to other websites. The privacy policy is only applicable for this website. Other websites linked may have their own Privacy Policy which differs from our policy and users are advised to read through and understand the Privacy Policy for every website visited.
		</p>
		<p>
		Amendments Policy
		</p>
		<p>
		If the Privacy Policy is amended, the amendments will be updated for this website. While browsing through this website, you will be noted with the relevant information gathered, the way that the information is used depending on the situation, and how the information is shared with others.
		</p>
	</div>
</section>
 
<?php
	echo makeFooter();
  ?>