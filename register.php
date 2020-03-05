<?php
    ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	echo makePageStart("Talk2Me - Register");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
  
  
<section class="box">
	<div class="container top-content">
<?php
	if(!isset($_SESSION['userID'])){ //if user is not logged in
		
	
?>	
<a href="index.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back</p></a>	
		<h1><strong>Register to Talk2Us</strong></h1>
	
		<div class="formDiv"> 
		
			<div class="formInfo">
			<p>Enter the following details to register:</p>
			<p>* Mandatory fields</p>
			</div>
			
			<form  method="post"  action="register_process.php" id="registerForm">
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">E</span>mail: *</label>
					</div>
					<div class="col-sm-10">
						<input type="text" name="email" id="email" class="form-control textboxWidth" placeholder="Email" accesskey="e">
						<p class="hint">(Valid email format: user@gmail.com)</p>
						<p id="errorEmailReg" style="color: red;"></p>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">U</span>ser name: *</label>
					</div>
					<div class="col-sm-10">
						<input type="text" name="userName" id="userName" class="form-control textboxWidth" placeholder="User name" accesskey="u">
						<p class="hint">(Username is between 6 and 15 characters)</p>
						<p id="errorUNameReg" style="color: red;"></p>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">D</span>ate of Birth: *</label>
					</div>
					<div class="col-sm-10">
						<input type="text" name="dob" id="dob" class="form-control textboxWidth" placeholder="Date of birth" accesskey="d">
						<p class="hint">(You need to be above 18 to use this site)</p>
						<p class="hint">(Format of date: YYYY-MM-DD (Eg: 1999-03-12))</p>
						<p id="errorDobReg" style="color: red;"></p>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">P</span>assword: *</label>
					</div>
					<div class="col-sm-10">	
						<input type="password" name="passwd" id="passwd" class="form-control textboxWidth" placeholder="Password" accesskey="p">
						<p class="hint">(Password is between 6 and 15 characters)</p>
						<p id="errorPwordReg" style="color: red;"></p>
					</div>
				</div>
				
				<div class="space row">
					<div class="col-sm-2">
						<label><span class="red">C</span>onfirm Password: *</label>
					</div>
					<div class="col-sm-10">	
						<input type="password" name="cpasswd" id="cpasswd" class="form-control textboxWidth" placeholder="Confirm Password" accesskey="c">
						<p class="hint">(Repeat password entered)</p>
						<p id="errorCPWordReg" style="color: red;"></p>
					</div>
				</div>

				<div class="space terms">
				<h3>Terms and Conditions</h3>
				<p>These Online Terms of Use govern your access to web sites controlled by Talk2US, including its subsidiaries and affiliates (together referred to as "Talk2US"), which link to these Online Terms of Use (together referred to as “Talk2US Web Sites”). These Online Terms of Use do not apply to Talk2US web sites that do not link to these Online Terms of Use, to residents of the United States, or to third-party web sites to which Talk2US Web Sites may link. Your use of Talk2US Web Sites is subject to these Online Terms of Use and the <a href="privacy.php">Privacy Policy</a>.</p>
		
				<p>Without prejudice to your rights under applicable law, Talk2US reserves the right to amend these Online Terms of Use to reflect technological advancements, legal and regulatory changes and good business practices. If Talk2US changes these Online Terms of Use, an updated version of these Online Terms of Use will reflect those changes and we will notify you of such changes by updating the effective date at the top of these Online Terms of Use. By accessing or using the Talk2US Web Sites, you agree that you have read, understand, and agree to be bound to the current version of these Online Terms of Use which you may view when accessing the Talk2US Web Sites. If you disagree with these Online Terms of Use, or are dissatisfied with the Talk2US Web Sites, your sole and exclusive remedy is to discontinue using this Talk2US Web Site.</p>
				
				<p><span class="subheading">DISCLAIMERS</span><br>
				You acknowledge and agree that:</p>
				<p>Although we strive to provide on the Talk2US Web Sites the latest developments relating to our products and services, and other information about Talk2US, we do not warrant the accuracy, effectiveness and suitability of any information contained in the Talk2US Web Sites. Each person assumes full responsibility and all risks arising from use of the Talk2US Web Sites. The information is presented “AS IS” and may include technical inaccuracies or typographical errors. Talk2US reserves the right to make additions, deletions, or modifications to the information contained on the Talk2US Web Sites at any time without any prior notification.</p>
				<p>a. Talk2US makes no representations or warranties of any kind or nature with respect to the information or content posted on the Talk2US Web Sites. Talk2US hereby disclaims all representations and warranties, whether express or implied, created by law, contract or otherwise, including, without limitation, any warranties of merchantability, fitness for a particular purpose, title or non-infringement. In no event shall Talk2US be liable for any damages of any kind or nature, including, without limitation, direct, indirect, special (including loss of profit) consequential or incidental damages arising from or in connection with the existence or use of the Talk2US Web Sites, and/or the information or content posted on the Talk2US Web Sites, regardless of whether Talk2US has been advised as to the possibility of such damages.</p>
				<p>b. Talk2US is not responsible, and provides no warranty whatsoever, for the accuracy, effectiveness, timeliness and suitability of any information or content obtained from third parties, including any hyperlinks to or from third-party sites. Except as otherwise provided on the Talk2US Web Sites, Talk2US will not edit, censor or otherwise control any content provided by third parties on any bulletin board, chat room or other similar forums posted on the Talk2US Web Sites. Such information should, therefore, be considered as suspect and is not endorsed by Talk2US.</p>
				<p>c. The Talk2US Web Sites may contain forward-looking statements that reflect Talk2US?s current expectation regarding future events and business development. The forward-looking statements involve risks and uncertainties. Actual developments or results could differ materially from those projected and depend on a number of factors including, but not limited to, the success of current research programs, results of pending or future clinical trials, ongoing commercialization of its products, regulatory approvals of pharmaceuticals, validity and enforcement of its patents, the stability of its commercial relationships, and the general economic conditions. Talk2US intends to update the Talk2US Web Sites on a regular basis but assumes no obligation to update any of the content.</p>
				
				<p><span class="subheading">YOUR USE </span><br>
				You understand, acknowledge, and agree to the following:</p>
				<p>a. By using the Talk2US Web Sites, you agree not to disrupt or intercept our electronic information posted on the Talk2US Web Sites or on any of our servers. You also agree not to attempt to circumvent any security features of the Talk2US Web Sites, and to abide by all applicable, local, state, federal and international laws, rules and regulations.</p>
				<p>b. You grant to Talk2US the right to use all content you upload or otherwise transmit to the Talk2US Web Sites, subject to these Online Terms of Use and Talk2US's <a href="privacy.php">Privacy Policy</a> in any manner Talk2US chooses, including, but not limited, to copying, displaying, performing or publishing it in any format whatsoever, modifying it, incorporating it into other material or making a derivative work based on it. To the extent allowed by applicable law you waive any moral rights you may have to content you upload or otherwise transmit to the Talk2US Web Sites (if any).</p>
				<p>c. Except as expressly stated and agreed upon in advance by Talk2US, no confidential relationship shall be established in the event that any user of the Talk2US Web Sites should make any oral, written or electronic communication to Talk2US (such as feedback, questions, comments, suggestions, ideas, etc.). If any Talk2US Web Sites require or request that such information be provided, and that such information contains personal identifying information (e.g., name, address, phone number, email address), Talk2US shall obtain, use and maintain it in a manner consistent with our <a href="privacy.php">Privacy Policy</a>. Otherwise, such communication and any information submitted therewith shall be considered non-confidential, and Talk2US shall be free to reproduce, publish or otherwise use such information for any purposes whatsoever including, without limitation, the research, development, manufacture, use or sale of products incorporating such information. The sender of any information to Talk2US is fully responsible for its content, including its truthfulness and accuracy and its non-infringement of any other person's proprietary or privacy rights.</p>
				
				<p><span class="subheading">PRODUCT LABELING</span><br>
				Product names, descriptions and labeling may be of U.S. origin or of a third country's origin which is not your country of residence. Products may not be available in all countries or may be available under a different brand name, in different strengths, or for different indications. Many of the products listed are available only by prescription through your local healthcare professional. Except as expressly stated and agreed upon in advance by Talk2US, no director, employee, agent, or representative of Talk2US, its subsidiaries and affiliates are engaged in rendering medical advice, diagnosis, treatment or other medical services that in any way create a physician-patient relationship through the Talk2US Web Sites.</p>
				
				<p><span class="subheading">INTELLECTUAL PROPERTY</span><br>
				The information, documents, and related graphics published in the Talk2US Web Sites (the “Information”) are the sole property of Talk2US, except for information provided by third-party providers under contract to Talk2US. Permission to use the Information is granted, provided that (1) the above copyright notice appears on all copies; (2) use of the Information is for informational and non-commercial or personal use only; (3) the Information is not modified in any way; and (4) no graphics available from this Talk2US Web Site are used separate from accompanying text. Talk2US is not responsible for content provided by third-party providers, and you are prohibited from distribution of such material without permission of the owner of the copyright therein. Except as permitted above, no license or right, express or implied, is granted to any person under any patent, trademark or other proprietary right of Talk2US.</p>
				<p>No use of any Talk2US trademark, trade names, trade dress and products in the Talk2US Web Sites may be made without the prior written authorization of Talk2US, except to identify the product or services of the company.</p>
				
				<p><span class="subheading">PRIVACY AND SECURITY</span><br>
				Talk2US is committed to safeguarding your privacy online. We understand the importance of privacy to our customers and visitors to the Talk2US Web Sites. Our use of personally identifiable information is governed by our <a href="privacy.php">Privacy Policy</a> and by accessing and using the Talk2US Web Sites, you agree to be bound by that <a href="privacy.php">Privacy Policy.</a></p>
				<p>You recognize and agree that when submitting your personally identifiable information to the Talk2US Web Sites, while Talk2US has safeguards in place to prevent unauthorized access or interception, there is no absolute guarantee of security. In the unlikely event of an interception or unauthorized access despite our efforts, Talk2US shall not be responsible for such interceptions or unauthorized access, or any direct, indirect, special, incidental, or consequential damages (including lost profits) suffered by a customer or user, even if Talk2US has previously been advised of the possibility of such damages. Talk2US does not warrant, either expressly or implied, that the information provided by any customer shall be free from interception or unauthorized access, and does not provide any implied warranties of merchantability and fitness for a particular purpose. Each customer is responsible for maintaining the confidentiality of his or her own password.</p>
				
				<p><span class="subheading">LIMITATION OF LIABILITY</span><br>
				Talk2US does not assume any liability for the materials, information and opinions provided on, posted to, or otherwise available through, the Talk2US Web Sites. Reliance on these materials, information and opinions is solely at your own risk. Talk2US disclaims any liability for injury or damages resulting from the use of the Talk2US Web Sites, or the content contained thereon.</p>
				<p>The Talk2US Web Sites, the site content, and the products and services provided on or available through the Talk2US Web Sites are provided on an “as is” and “as available” basis, with all faults. In no event shall Talk2US or its vendors, or their respective directors, employees or agents (hereinafter “Talk2US Parties”) be liable for any damages of any kind, under any legal theory, arising out of or in connection with your use of, or inability to use, the Talk2US Web Sites, the site content, any services provided on or through the Talk2US Web Sites or any linked site, including any special, indirect, punitive, incidental, exemplary or consequential damages, including, but not limited to, personal injury, lost profits or damages resulting from delay, interruption in service, viruses, deletion of files or electronic communications, or errors, omissions or other inaccuracies in the Talk2US Web Sites or the site content, whether or not there is negligence by Talk2US and whether or not Talk2US has been advised of the possibility of any such damages.</p>
				<p>You agree that regardless of any applicable law to the contrary, you cannot file a claim or cause of action arising out of or related to the Talk2US Web Sites or these Online Terms of Use more than one (1)?year after such claim or cause of action arose.</p>
				<p>Please be aware that additional legal notices, disclaimers, and other terms and conditions may apply to the Talk2US Web Sites.</p>
				
				<p><span class="subheading">GENERAL</span><br>
				You agree that these Online Terms of Use and the <a href="privacy.php">Privacy Policy</a> describe the entire agreement between us with respect to its subject matter. The Talk2US Web Sites were created and are operated under the laws of the State of Illinois. The laws of the State of Illinois will control the terms provided in these Online Terms and Conditions, to the extent that the laws of the State of Illinois are not overridden by applicably mandatory law, e.g. consumer protection laws applying to you. If a court of competent jurisdiction finds that any provision of these Online Terms of Use is invalid or unenforceable, you agree that the other provisions of these Online Terms of Use will remain in full force and effect.</p>
				</div>
				
				<div class="formBottom">
					<p class="checkbox"><input type="checkbox" name="termsChkbx" id="termsChkbx" value="agreed" />Please agree to the term and conditions</p>
					<p id="errorCheckTerm" style="color: red;"></p>
				</div>
				
				<div class="formBottom">
					
				</div>
				
				<div class="space floatRight">
					<input type="reset" class="button" id="clearReg" value="Clear">
					<input type="submit" class="button" id="submitReg" value="Register">
				</div>
				<br class="clearRight"/>
			</form> 
		</div>
<?php
	}else{
		echo logged();
	}
?>
	</div>
</section>
 
 
 
<?php
	echo makeFooter();
  ?>
