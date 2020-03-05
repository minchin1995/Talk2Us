<?php
  $conn = mysqli_connect('localhost', 'root', '', 'ip');
	if (mysqli_connect_errno()) {
		echo "<p>Connection failed:".mysqli_connect_error()."</p>\n";
	}
?>