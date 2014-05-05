<!DOCTYPE html>
<html lang="en">
<head>
<?php session_start(); include('includes/head.php'); include('includes/core.php'); ?>
<title><?php echo $shortname ?></title>
</head>
<body>
<div class="col-lg-12">
<h2><?php echo $shortname ?>  <?php if ($showversion == true) { echo '<span class="h5">ver. ' . $version .'</span>'; } ?>
</h2>
<?php

if($_SESSION['loggedin'] == "y") {
	echo "<div class='col-lg-12'>" . $_SESSION['updatemessage'];
	echo "<span class='h2'>Pages</span>";
	if ($_SESSION['root'] == "y") { echo '<a class="btn adduser" href="action.php?action=managepages">Manage pages</a><a class="btn adduser" href="action.php?action=logout">Log out</a></div>'; }else{ echo '<a class="btn adduser" href="action.php?action=editpassword">Change password</a><a class="btn adduser" href="action.php?action=logout">Log out</a></div>'; }
	include('includes/minreqs.php');

	$input = json_decode(file_get_contents($dbpages), true);
	foreach ($input as $value){
		echo "<div class='col-lg-3'><div class='well well-lg'>";
		$i++;
		echo "Page: ". $value[page]. "<br>";
		if ($showpath == "true") {
		echo "Path: " . $value[path] . "<br>";
		}
		echo '<a href="action.php?action=cms&page='. $value[path] . '">Edit page</a></div></div>';
	}

	//If a root-user is logged in, display information regarding users, and link to add a new user
	if ($_SESSION['root'] == "y") {
		echo "<div class='col-lg-12'><span class='h2'>Users</span>";
		echo '<a class="btn adduser" href="action.php?action=manageusers">Manage users</a></div>';
		$input = db_read($dbusers);
		foreach ($input as $value){
			echo "<div class='col-lg-3'><div class='well well-lg'>";
			$i++;
			echo "Username: ". $value[username]. "<br>";
			if ($value[priv] == "root") {
				echo "Privilege: root</div></div>";
			}else{
				echo "Privilege: standard</div></div>";
			}
		}
	}
}else{
	?>
	<form class="form-inline" role="form" action="action.php?action=login" method="post">
	  <div class="form-group">
	    <label class="sr-only" for="username">Username</label>
	    <input type="text" class="form-control" name="username" id="username" placeholder="Username">
	  </div>
	  <div class="form-group">
	    <label class="sr-only" for="password">Password</label>
	    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
	  </div>
	  <button type="submit" class="btn btn-default">Sign in</button>
	</form>
	</div>
	<?php
}
?>
</body>
</html>