<?php
//If user is logged in
	if($_SESSION['loggedin'] == "y") {
		//Log user out
	session_unset('loggedin');
	//Redirect to index page
	echo "<script>window.location = 'index.php'</script>";
	}
	?>