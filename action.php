<!DOCTYPE html>
<html>
<head>
<?php include('includes/core.php'); ?>
<title><?php echo $shortname ?></title>

<!-- Include head file -->
<?php include('includes/head.php'); ?>

</head>
<body>
<?php
//Start session so that we can store data to session
session_start();

//Import minreqs
include('resources/minreqs.php');
?>

<!-- Add universal header and button to go back -->
<div class="col-lg-12"><br>
<span class="h2"><?php echo $shortname ?></span>
<a class="btn adduser" href="index.php">Go back</a>

<?php
//If user is logged in
if ($_SESSION['loggedin'] == "y") {
	//If user is logged in as root
	if ($_SESSION['root'] == "y") {
		//If the action called is managepages (the $_POST will be passed by a form on this page when information has been changed or supplied)
		if ($_GET['action'] == "managepages" OR $_POST['action'] == "managepages") {
				if (!isset($_POST['name'])) {
					?>
					<h2>Add page</h2>
					<div class='col-lg-10'>
					<!-- Form to add new page -->
					<form class="form-inline" role="form" action="" method="post">
					<!-- Hidden input field to tell the file that we are managing pages, after submission -->
					<input type="hidden" value="managepages" name="action">
						  <div class="form-group">
						    <label class="sr-only" for="name">Page name</label>
						    <input type="text" class="form-control" name="name" id="name" placeholder="Page name">
						  </div>
						  <div class="form-group">
						    <label class="sr-only" for="path">Page path (from webroot)</label>
						    <input type="text" class="form-control wide" name="path" id="path" placeholder="Path (from <?php echo $rootpath ?>)">
						  </div>
						  <button type="submit" class="btn btn-default">Add</button>
					</form></div><br><br>
					<h2>Current pages</h2>
					<?php
					//Get pages from json file
					$input = json_decode(file_get_contents($dbpages), true);
					//Iterate over each, displaying a well with delete option for each result
					foreach ($input as $value) {
						echo "<div class='col-lg-3'><div class='well well-lg'>";
						$i++;
						echo "Page: ". $value[page]. "<br>";
						echo "Path: " . $value[path] . "<br>";
						//Do not echo the delete button if only one entry exists
						if (count($input) !== 1) {
							echo "<a class='btn btn-danger btn-xs' href='action.php?action=deletepage&id=" . $i . "' onclick='return confirmAction()'>Delete</a></div></div>";
						}
					}
				}else{
					//Set user passed information in variables
					$name = htmlspecialchars($_POST['name']); //if æ, ø, å and the likes is used, htmlspecialchars makes sure it works
					$path = $_POST['path'];

					//Load current json file and decode it
					$input = json_decode(file_get_contents($dbpages), true);

					//Push new information to the end of the array decoded from json
					array_push($input, Array(page => $name, path => $path));

					//Encode information and place in output variable
					$output = json_format($input);

					//Write information to dbpages file
					$fp = fopen($dbpages, 'w');
					fwrite($fp, stripslashes($output));
					fclose($fp);
					echo "<br>The page has been added. <a href='action.php?action=managepages'>Back to Manage Pages</a>";
				}
		}
		//If the action called is deletepage 
		if ($_GET['action'] == "deletepage") {
			$id = $_GET['id'] - 1; //set id to minus the id that has been passed, because arrays start at 0.

			$input = json_decode(file_get_contents($dbpages), true);

			//Remove the selected id from the array
			unset($input[$id]);

			//Fix integers, so that we don't have integer skips
			$input = array_values($input);

			//Encode information and place in output variable
			$output = json_format($input);

			//Write new information to dbpages file
			$fp = fopen($dbpages, 'w');
			fwrite($fp, $output);
			fclose($fp);
			echo "<br>The page has been deleted. <a href='action.php?action=managepages'>Back to Manage Pages</a>";

		}
		//If the action called is manageusers (the $_POST will be passed by a form on this page when information has been changed or supplied)
		if ($_GET['action'] == "manageusers" OR $_POST['action'] == "manageusers") {
			//If information has not been posted, created a form to post some information
			if (!isset($_POST['username'])) {
					?>
					<h2>Add user</h2>
					<div class='col-lg-10'>
					<form class="form-inline" role="form" action="" method="post">
					<input type="hidden" value="manageusers" name="action">
						  <div class="form-group">
						    <label class="sr-only" for="name">Username</label>
						    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
						  </div>
						  <div class="form-group">
						    <label class="sr-only" for="path">Password</label>
						    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
						  </div>
						  <button type="submit" class="btn btn-default">Add</button>
					</form></div><br><br>
					<h2>Current users</h2>
					<?php
					//Get users from dbusers json file
					$input = json_decode(file_get_contents($dbusers), true);
					//Iterate through each user, displaying in well with delete option
					foreach ($input as $value){
						echo "<div class='col-lg-3'><div class='well well-lg'>";
						$i++;
						echo "Username: ". $value[username]."<br>";
						if ($value[priv] == "root") {
							echo "Privilege: root<br>";
						}else{
							echo "Privilege: standard<br>";
						}
						//Do not echo the delete button if only one entry exists
						if (count($input) !== 1) {
							echo "<a class='btn btn-danger btn-xs' href='action.php?action=deleteuser&id=" . $i . "' onclick='return confirmAction()'>Delete</a></div></div>";
						}
					}
				}else{
					//Set information in variables
					$username = $_POST['username'];
					$password = md5($_POST['password']);

					//Load dbusers json file and decode it
					$input = json_decode(file_get_contents($dbusers), true);

					//Push new information to the end of the array decoded from json
					array_push($input, Array(username => $username, password => $password));

					//Encode information and place in output variable
					$output = json_format($input);

					//Write information to dbusers file
					$fp = fopen($dbusers, 'w');
					fwrite($fp, stripslashes($output));
					fclose($fp);
					echo "<br>The user has been added. <a href='action.php?action=manageusers'>Back to Manage Users</a>";
				}
		}
		//If action called is deleteuser
		if ($_GET['action'] == "deleteuser") {
			$id = $_GET['id'] - 1; //Get the passed id and subtract i by one since arrays start at 0

			//Get the contents of the dbusers json file
			$input = json_decode(file_get_contents($dbusers), true);

			//Remove the selected id from the array
			unset($input[$id]);

			//Fix integers, so that we don't have integer skips
			$input = array_values($input);

			//Encode information and place in output variable
			$output = json_format($input);

			//Write new information to dbusers file
			$fp = fopen($dbusers, 'w');
			fwrite($fp, $output);
			fclose($fp);
			echo "<br>The user has been deleted. <a href='action.php?action=manageusers'>Back to Manage Users</a>";

		}
	}
}
//If action called is login
if ($_GET['action'] == "login") {
	//If password and username has been set
	if(isset($_POST['username'],$_POST['password'])) {
		//Include minreqs
		include('resources/minreqs.php');
		//set information in variables, md5'ing the password
		$password = md5($_POST['password']);
		$username = $_POST['username'];

		//Put information from dbusers json file in array
		$input = json_decode(file_get_contents($dbusers), true);
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
}

//If action called is log out
if ($_GET['action'] == "logout") {
	//If user is logged in
	if($_SESSION['loggedin'] == "y") {
		//Log user out
	session_unset('loggedin');
	//Redirect to index page
	echo "<script>window.location = 'index.php'</script>";
	}
}
?>
</div>
<!-- To add custom text on delete confirmations -->
<script>function confirmAction(){
      var confirmed = confirm("Are you sure you want to delete this?");
      return confirmed;
}</script>
</body>
</html>