<?php
	ini_set("session.save_path",$_SERVER["DOCUMENT_ROOT"]."/../sessionData");
	session_start();

	require_once("function.php"); // Include header to the page
	
	include "database_conn.php"; //connect to database

	require_once("function.php"); // Include header to the page
	echo makePageStart("Talk2Me - Log In process");  
	echo makeNav("");
	echo makeToTop();
	echo resizeButtons();
?>
  
  
<section class="box">
	<div class="container top-content">
		<div class="processDiv">
  <?php
	if(!isset($_SESSION['userID'])){
	    //obtain username and password entered from login form
        $userName = filter_has_var(INPUT_POST, 'userName') ? $_POST['userName']: null;
        $passWord  = filter_has_var(INPUT_POST, 'passwd') ? $_POST['passwd']: null;

        //trim blank space before and after data
        $userName = trim($userName); 
        $passWord = trim($passWord);

        //Obtain hashed password from database
        $sql = "SELECT passwordHash, userID, accountID, verified, banned, usernameGen
				FROM user
				WHERE userName = ?";
           
		// prepare sql statement
        $stmt = mysqli_prepare($conn, $sql);	
  
        //Bind the $username entered
        mysqli_stmt_bind_param($stmt, "s", $userName);     
		   
		// execute query
        mysqli_stmt_execute($stmt);

        // store password hash obtained in the variable indicated 
		mysqli_stmt_bind_result($stmt, $passWDHash, $userID, $accountID, $verified, $banned, $usernameGen);
        
		//array for errors
		$errorList = array();
		
		//if username is empty
		if (empty($userName)) {
			$errorList[] = "<p>You have not entered the username.</p>\n";
		}
		if (empty ($passWord)) {
			$errorList[] = "<p>You have not entered the password.</p>\n";
		}
		
	    //display errors from array 
	    if (!empty($errorList)) {
			for ($a=0; $a < count($errorList); $a++) {
				echo "$errorList[$a] <br />\n";
			}
		}
		else if (mysqli_stmt_fetch($stmt)) { 
			
			
			if (password_verify($passWord, $passWDHash)) {
				if ($verified ==1){
					if ($banned ==0) {
						//store the username to a session variable
						$_SESSION['username'] 	= $userName;
						$_SESSION['userID'] 	= $userID;
						$_SESSION['role'] 	= $accountID;
						$_SESSION['usernameGen'] 	= $usernameGen;
						
						//log in if password is correct
						$_SESSION['logged-in'] = true;
						echo "<p>User has succesfully logged in!</p>\n";
						if ($_SESSION['role']=="1"){
							header("location: admin.php");
						} else {
							header("location: index.php");
						}
					}
					else {
						$_SESSION['logged-in'] = false;
						echo "<p>Sorry you are banned. Any problems please visit the contact page to contact the admin.</p>\n";
						echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
					}
				} else {
					$_SESSION['logged-in'] = false;
					echo "<p>Please verify your email before proceeding.</p>\n";
					echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
				}
				
			}
			else {
				//error message if password is wrong
				echo "<p>Password is incorrect. Please try again.</p>\n";
				$_SESSION['logged-in'] = false;
				echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
			}
		}
		else {
			//error message if username doesn't exist
			echo "<p>Sorry we don't seem to have that username.</p>";
			echo "<a href=\"index.php\"><p>Return to homepage</p></a>";
		}

		mysqli_stmt_close($stmt); 
		mysqli_close($conn);
	} else {
		echo logged();
	}
	?>
		</div>
	</div>
</section>
 
 
<?php
	echo makeFooter();
  ?>