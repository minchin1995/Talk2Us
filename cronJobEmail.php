<?php
/*
* Function to send email for forgetting email to login
*
* @param email email address of user
*/
function emailForget($email){
	require 'phpmailer/PHPMailer.php';
	require 'phpmailer/SMTP.php';
	require 'phpmailer/Exception.php';

	$mail = new PHPMailer\PHPMailer\PHPMailer;

	include("database_conn.php");

	$sql = "SELECT DISTINCT username
			FROM user
			WHERE email='$email'";

	$rsEmail = mysqli_query($conn,$sql)
				or die(mysqli_error($conn));
					
	while($row = mysqli_fetch_array($rsEmail))
	{
		$username = $row[0];


	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Host       = "mail.yourdomain.com"; // SMTP server
	$mail->SMTPDebug  = 4;                     // enables SMTP debug information (for testing)
											   // 1 = errors and messages
											   // 2 = messages only
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
	$mail->Username   = "neece205@gmail.com";  // GMAIL username
	$mail->Password   = "g0away1234";            // GMAIL password
	$mail->SetLanguage("en", 'includes/phpMailer/language/');
	$mail->smtpConnect(
		array(
			"ssl" => array(
				"verify_peer" => false,
				"verify_peer_name" => false,
				"allow_self_signed" => true
			)
		)
	);

	$mail->SetFrom('neece205@gmail.com', 'Admin');

	$mail->AddReplyTo("neece205@gmail.com","Admin");

	$mail->Subject    = "Forget Password on Talk2Us";

	$htmlBody = "<p>Hello $username</p>
				
				<p>Please reset your password your password at this link: <a href=\"http://localhost/a1/resetPassword.php\">http://localhost/a1/resetPassword.php</a>.</p>
				
				<p>From: </p>
				<p>Admin </p>
				<p><small>DISCLAIMER: This is an automated e-mail. Do not reply to this address. If you have recieved this message mistakenly, 
				please ignore it. This automated e-mail is created for a school project</small></p>";



	$mail->MsgHTML($htmlBody);
	//$email = $addresses;
	$mail->AddAddress($email, "$username");

	if(!$mail->Send()) {
	  echo "<p>".$mail->ErrorInfo."</p>";
	} else {
	  echo "<p>Message sent!</p>";
	}
	}
} //end of emailForget()

/*
* Email for users to validate their account
*
* @param email email address of user
*/
function emailValidate($email){
	require 'phpmailer/PHPMailer.php';
	require 'phpmailer/SMTP.php';
	require 'phpmailer/Exception.php';

	$mail = new PHPMailer\PHPMailer\PHPMailer;

	include("database_conn.php");

	$sql = "SELECT DISTINCT username
			FROM user
			WHERE email='$email'";

	$rsEmail = mysqli_query($conn,$sql)
				or die(mysqli_error($conn));
					
	while($row = mysqli_fetch_array($rsEmail)){
		$username = $row[0];


		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = "mail.yourdomain.com"; // SMTP server
		$mail->SMTPDebug  = 4;                     // enables SMTP debug information (for testing)
												   // 1 = errors and messages
												   // 2 = messages only
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
		$mail->Username   = "neece205@gmail.com";  // GMAIL username
		$mail->Password   = "g0away1234";            // GMAIL password
		$mail->SetLanguage("en", 'includes/phpMailer/language/');
		$mail->smtpConnect(
			array(
				"ssl" => array(
					"verify_peer" => false,
					"verify_peer_name" => false,
					"allow_self_signed" => true
				)
			)
		);

		$mail->SetFrom('neece205@gmail.com', 'Admin');

		$mail->AddReplyTo("neece205@gmail.com","Admin");

		$mail->Subject    = "Validate Account on Talk2Us";

		$htmlBody = "<p>Hello $username</p>
					
					<p>Please validate your account at this link: <a href=\"http://localhost/a1/validateAcc.php\">http://localhost/a1/validateAcc.php</a>.</p>
					
					<p>From: </p>
					<p>Admin </p>
					<p><small>DISCLAIMER: This is an automated e-mail. Do not reply to this address. If you have recieved this message mistakenly, 
					please ignore it. This automated e-mail is created for a school project</small></p>";



		$mail->MsgHTML($htmlBody);
		//$email = $addresses;
		$mail->AddAddress($email, "$username");

		if(!$mail->Send()) {
		  echo "<p>".$mail->ErrorInfo."</p>";
		} else {
		  echo "<p>Message sent!</p>";
		}
	}
} //end of emailValidate()

/*
* Email for users to send any issues to the admin when contacting them
*
* @param email email address of user
* @param problems problems of user
*/
function emailContact($email, $problems){
	require 'phpmailer/PHPMailer.php';
	require 'phpmailer/SMTP.php';
	require 'phpmailer/Exception.php';

	$mail = new PHPMailer\PHPMailer\PHPMailer;

	include("database_conn.php");

	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Host       = "mail.yourdomain.com"; // SMTP server
	$mail->SMTPDebug  = 4;                     // enables SMTP debug information (for testing)
												   // 1 = errors and messages
												   // 2 = messages only
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
	$mail->Username   = "neece205@gmail.com";  // GMAIL username
	$mail->Password   = "g0away1234";            // GMAIL password
	$mail->SetLanguage("en", 'includes/phpMailer/language/');
	$mail->smtpConnect(
		array(
			"ssl" => array(
				"verify_peer" => false,
				"verify_peer_name" => false,
				"allow_self_signed" => true
			)
		)
	);
		
	$mail->SetFrom($email, "Talk2Us User");

	$mail->AddReplyTo($email, "Talk2Us User");

	$mail->Subject    = "ENQUIRY: $email";

	$htmlBody = "<p>Hello Admin</p>
					
					<p>$problems</p>
					
					<p>From: </p>
					<p>$email </p>
					<p><small>DISCLAIMER: This is an automated e-mail. Do not reply to this address. If you have recieved this message mistakenly, 
					please ignore it. This automated e-mail is created for a school project</small></p>";



	$mail->MsgHTML($htmlBody);
	
	$mail->AddAddress("neece205@gmail.com", "JARVIS NEECE");

	if(!$mail->Send()) {
	  echo "<p>".$mail->ErrorInfo."</p>";
	} else {
	  echo "<p>Message sent!</p>";
	}
	
} //end of emailContact()

/*
* Email to notify users of any reply in forums
*
* @param email email address of user
* @param username username of user
* @param topicID topicid of the post replied to
*/
function emailDB($email, $username, $topicID){
	require 'phpmailer/PHPMailer.php';
	require 'phpmailer/SMTP.php';
	require 'phpmailer/Exception.php';

	$mail = new PHPMailer\PHPMailer\PHPMailer;

	include("database_conn.php");

	$sqlTName = "SELECT DISTINCT topicName
			FROM forumtopic
			WHERE topicID='$topicID'";

	$rsTName = mysqli_query($conn,$sqlTName)
				or die(mysqli_error($conn));
					
	while($row = mysqli_fetch_array($rsTName)){
		$topicName = $row[0];

		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = "mail.yourdomain.com"; // SMTP server
		$mail->SMTPDebug  = 4;                     // enables SMTP debug information (for testing)
												   // 1 = errors and messages
												   // 2 = messages only
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
		$mail->Username   = "neece205@gmail.com";  // GMAIL username
		$mail->Password   = "g0away1234";            // GMAIL password
		$mail->SetLanguage("en", 'includes/phpMailer/language/');
		$mail->smtpConnect(
			array(
				"ssl" => array(
					"verify_peer" => false,
					"verify_peer_name" => false,
					"allow_self_signed" => true
				)
			)
		);

		$mail->SetFrom('neece205@gmail.com', 'Admin');

		$mail->AddReplyTo("neece205@gmail.com","Admin");

		$mail->Subject    = "Someone replied to your post on Talk2Us";

		$htmlBody = "<p>Hello $username</p>
					
					<p>Someone replied to you on: <a href=\"http://localhost/a1/forumTopic.php?topicID=$topicID\">$topicName</a></p>
					
					<p>From: </p>
					<p>Admin </p>
					<p><small>DISCLAIMER: This is an automated e-mail. Do not reply to this address. If you have recieved this message mistakenly, 
					please ignore it. This automated e-mail is created for a school project</small></p>";



		$mail->MsgHTML($htmlBody);
		//$email = $addresses;
		$mail->AddAddress($email, "$username");

		if(!$mail->Send()) {
		  echo "<p>".$mail->ErrorInfo."</p>";
		} else {
		  echo "<p>Message sent!</p>";
		}
	}
} //end of emailDB()

/*
* Email to notify users of any reply in group supports
*
* @param email email address of user
* @param username username of user
* @param topicID topicid of the post replied to
*/
function emailGS($email, $username, $topicID){
	require 'phpmailer/PHPMailer.php';
	require 'phpmailer/SMTP.php';
	require 'phpmailer/Exception.php';

	$mail = new PHPMailer\PHPMailer\PHPMailer;

	include("database_conn.php");

	$sqlTName = "SELECT DISTINCT sTopicName
			FROM supporttopic
			WHERE sTopicID='$topicID'";

	$rsTName = mysqli_query($conn,$sqlTName)
				or die(mysqli_error($conn));
					
	while($row = mysqli_fetch_array($rsTName)){
		$topicName = $row[0];

		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = "mail.yourdomain.com"; // SMTP server
		$mail->SMTPDebug  = 4;                     // enables SMTP debug information (for testing)
												   // 1 = errors and messages
												   // 2 = messages only
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
		$mail->Username   = "neece205@gmail.com";  // GMAIL username
		$mail->Password   = "g0away1234";            // GMAIL password
		$mail->SetLanguage("en", 'includes/phpMailer/language/');
		$mail->smtpConnect(
			array(
				"ssl" => array(
					"verify_peer" => false,
					"verify_peer_name" => false,
					"allow_self_signed" => true
				)
			)
		);

		$mail->SetFrom('neece205@gmail.com', 'Admin');

		$mail->AddReplyTo("neece205@gmail.com","Admin");

		$mail->Subject    = "Someone replied to your post on Talk2Us";

		$htmlBody = "<p>Hello $username</p>
					
					<p>Someone replied to you on: <a href=\"http://localhost/a1/forumTopic.php?topicID=$topicID\">$topicName</a></p>
					
					<p>From: </p>
					<p>Admin </p>
					<p><small>DISCLAIMER: This is an automated e-mail. Do not reply to this address. If you have recieved this message mistakenly, 
					please ignore it. This automated e-mail is created for a school project</small></p>";



		$mail->MsgHTML($htmlBody);
		//$email = $addresses;
		$mail->AddAddress($email, "$username");

		if(!$mail->Send()) {
		  echo "<p>".$mail->ErrorInfo."</p>";
		} else {
		  echo "<p>Message sent!</p>";
		}
	}
} //end of emailDB()
?>