	<?php
	//If password and username has been set
	if(isset($_POST['username'],$_POST['password'])) {
		//Include minreqs
		include('includes/minreqs.php');
		//set information in variables, md5'ing the password
		$password = md5($_POST['password']);
		$username = $_POST['username'];

		//Put information from dbusers json file in array
		$input = db_read($dbusers);
		//Set id for the foreach loop to identify the proper entries
		$id = 0;
		//Iterate over each entry in dbusers file
		foreach ($input as $value){
			//If the username is in the dbusers file
		if (in_array($username, $input[$id])) {
			//If the password is in the dbusers file, at the same id as the username
	    	if (in_array($password, $input[$id])) {
	    		//Set session to loggedin
	    		$_SESSION['loggedin'] = "y";
	    		$_SESSION['username'] = $username;
	    		//If the priv value is set to root, mark user as root privileged
	    		if ($value[priv] == "root") {
	    			$_SESSION['root'] = "y";
	    		}
	    		//Redirect to index when script is complete
					echo "<script>window.location = 'index.php'</script>";
	    	}else {
	    		echo "Password was incorrect.";
	    	}
		}else{
			echo "Username was incorrect.";
		}
		$id++;
		}
	}
	?>