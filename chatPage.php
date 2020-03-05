<?php
	ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

    require_once("function.php"); // Include header to the page
	
	//connect to database
	include "database_conn.php";

	if(isset($_SESSION['userID'])){
		//get username of user logged in
		$username = $_SESSION['username'];
		//get userID of user logged in
		$userID = $_SESSION['userID'];
		//get role of user when user is logged in
		$accountID = $_SESSION['role'];
		//get the generated username of user
		$usernameGen = $_SESSION['usernameGen'];
	}
	
	echo makePageStart("Talk2Me - Chat");  
	echo makeNav("");
	echo makeToTop();
?>
<section class="box">
	<div class="container top-content">
<?php
	// check if user is logged in
	if (isset($_SESSION['userID'])){
			
?>
<a href="chat.php" class="backButton"><p><i class="fa fa-arrow-circle-left fa-1x"></i> Back to chat</p></a>
		<script id="cid0020000185811533539" data-cfasync="false" async src="//st.chatango.com/js/gz/emb.js" style="width: 100%;height: 500px;">{"handle":"talk2uslivechat","arch":"js","styles":{"a":"000066","b":100,"c":"FFFFFF","d":"FFFFFF","k":"000066","l":"000066","m":"000066","n":"FFFFFF","p":"10","q":"000066","r":100,"fwtickm":1}}</script>

<?php
	} else {
		echo nolog();
	}
?>
	</div>
</section>

<?php
	echo makeFooter();
?>