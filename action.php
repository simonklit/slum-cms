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

<div class="col-lg-12"><br>
<span class="h2"><?php echo $shortname ?></span>
<a class="btn adduser" href="index.php">Go back</a>

<?php

if ($_SESSION['loggedin'] == "y") {
	if ($_SESSION['root'] == "y") {
		if ($_GET['action'] == "managepages" OR $_POST['action'] == "managepages") {
				if (!isset($_POST['name'])) {
					?>
					<h2>Add page</h2>
					<div class='col-lg-10'>

					<form class="form-inline" role="form" action="" method="post">
					<input type="hidden" value="managepages" name="action">
						  <div class="form-group">
						    <label class="sr-only" for="name">Page name</label>
						    <input type="text" class="form-control" name="name" id="name" placeholder="Page name">
						  </div>
						  <div class="form-group">
						    <label class="sr-only" for="path">Page path (from webroot)</label>
						    <input type="text" class="form-control" name="path" id="path" placeholder="Path (from <?php echo $rootpath ?>)">
						  </div>
						  <button type="submit" class="btn btn-default">Add</button>
					</form></div><br><br>
					<h2>Current pages</h2>
					<?php
					$input = json_decode(file_get_contents($dbpages), true);
					foreach ($input as $value) {
						echo "<div class='col-lg-3'><div class='well well-lg'>";
						$i++;
						echo "Page: ". $value[page]. "<br>";
						echo "Path: " . $value[path] . "<br>";
						echo "<a class='btn btn-danger btn-xs' href='action.php?action=deletepage&id=" . $i . "' onclick='return confirmAction()'>Delete</a></div></div>";
					}
				}else{
					//Set information in variables
					$name = htmlspecialchars($_POST['name']);
					$path = $_POST['path'];

					//Load current json file and decode it
					$input = json_decode(file_get_contents($dbpages), true);

					//Push new information to the end of the array decoded from json
					array_push($input, Array(page => $name, path => $path));

					//Encode information and place in output variable
					$output = json_format($input);

					//Display it on page (not required by any means)
					//echo "<pre>" . $output . "</pre>";

					//Write information to podcast.json file
					$fp = fopen($dbpages, 'w');
					fwrite($fp, stripslashes($output));
					fclose($fp);
					echo "The page has been added. <a href='action.php?action=managepages'>Back to Manage Pages</a>";
				}
		}
		if ($_GET['action'] == "deletepage") {
			$id = $_GET['id'] - 1;

			$input = json_decode(file_get_contents($dbpages), true);

			//Put speaker and date for selected entry in variables for complete message
			$name = $input[$id][name];
			$path = $input[$id][path];

			//Remove the selected id from the array
			unset($input[$id]);

			//Fix integers, so that we don't have integer skips
			$input = array_values($input);

			//Encode information and place in output variable
			$output = json_format($input);

			//Write new information to podcast.json file
			$fp = fopen($dbpages, 'w');
			fwrite($fp, $output);
			fclose($fp);
			echo "The page has been deleted. <a href='action.php?action=managepages'>Back to Manage Pages</a>";

		}
		if ($_GET['action'] == "manageusers" OR $_POST['action'] == "manageusers") {
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
					$input = json_decode(file_get_contents($dbusers), true);
					foreach ($input as $value){
						echo "<div class='col-lg-3'><div class='well well-lg'>";
						$i++;
						echo "Username: ". $value[username]."<br>";
						if ($value[priv] == "root") {
							echo "Privilege: root<br>";
						}else{
							echo "Privilege: standard<br>";
						}
						echo "<a class='btn btn-danger btn-xs' href='action.php?action=deleteuser&id=" . $i . "' onclick='return confirmAction()'>Delete</a></div></div>";

					}
				}else{
					//Set information in variables
					$username = $_POST['username'];
					$password = md5($_POST['password']);

					//Load current json file and decode it
					$input = json_decode(file_get_contents($dbusers), true);

					//Push new information to the end of the array decoded from json
					array_push($input, Array(username => $username, password => $password));

					//Encode information and place in output variable
					$output = json_format($input);

					//Display it on page (not required by any means)
					//echo "<pre>" . $output . "</pre>";

					//Write information to podcast.json file
					$fp = fopen($dbusers, 'w');
					fwrite($fp, stripslashes($output));
					fclose($fp);
					echo "<br>The user has been added. <a href='action.php?action=manageusers'>Back to Manage Users</a>";
				}
		}
		if ($_GET['action'] == "deleteuser") {
			$id = $_GET['id'] - 1;

			$input = json_decode(file_get_contents($dbusers), true);

			//Put speaker and date for selected entry in variables for complete message
			$username = $input[$id][username];
			$password = md5($input[$id][password]);

			//Remove the selected id from the array
			unset($input[$id]);

			//Fix integers, so that we don't have integer skips
			$input = array_values($input);

			//Encode information and place in output variable
			$output = json_format($input);

			//Write new information to podcast.json file
			$fp = fopen($dbusers, 'w');
			fwrite($fp, $output);
			fclose($fp);
			echo "<br>The user has been deleted. <a href='action.php?action=manageusers'>Back to Manage Users</a>";

		}
	}
}

if ($_GET['action'] == "login") {
	if(isset($_POST['username'],$_POST['password'])) {
		include('resources/minreqs.php');
		$password = md5($_POST['password']);
		$username = $_POST['username'];

		$input = json_decode(file_get_contents($dbusers), true);
		$id = 0;
		foreach ($input as $value){
		if (in_array($username, $input[$id])) {
	    	if (in_array($password, $input[$id])) {
	    		$_SESSION['loggedin'] = "y";
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

if ($_GET['action'] == "logout") {
	if($_SESSION['loggedin'] == "y") {
	session_unset('loggedin');
	echo "<script>window.location = 'index.php'</script>";
	}
}
?>
</div>
<script>function confirmAction(){
      var confirmed = confirm("Are you sure you want to delete this?");
      return confirmed;
}</script>
</body>
</html>