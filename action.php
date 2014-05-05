<?php //Start session so that we can store data to session
session_start(); ?>
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

//Import minreqs
include('includes/minreqs.php');
?>

<!-- Add universal header and button to go back -->
<div class="col-lg-12"><br>
<span class="h2"><?php echo $shortname ?></span>
<a class="btn adduser" href="index.php">Go back</a>

<?php
//If user is logged in
if ($_SESSION['loggedin'] == "y") {
	if ($_GET['action'] == "cms") {
		include('actions/cms.php');
	}
	if ($_GET['action'] == "editpassword") {
		include('actions/editpassword.php');
	}
	//If user is logged in as root
	if ($_SESSION['root'] == "y") {
		//If the action called is managepages (the $_POST will be passed by a form on this page when information has been changed or supplied)
		if ($_GET['action'] == "managepages" OR $_POST['action'] == "managepages") {
			include('actions/managepages.php');
		}
		//If the action called is deletepage 
		if ($_GET['action'] == "deletepage") {
			include('actions/deletepage.php');
		}
		//If action called is editpage
		if ($_GET['action'] == "editpage") {
			include('actions/editpage.php');
		}
		//If the action called is manageusers (the $_POST will be passed by a form on this page when information has been changed or supplied)
		if ($_GET['action'] == "manageusers" OR $_POST['action'] == "manageusers") {
			include('actions/manageusers.php');
		}
		//If action called is deleteuser
		if ($_GET['action'] == "deleteuser") {
			include('actions/deleteuser.php');
		}

		//If action called is edituser
		if ($_GET['action'] == "edituser") {
			include('actions/edituser.php');
		}
	}
}
//If action called is login
if ($_GET['action'] == "login") {
	include('actions/login.php');
}

//If action called is log out
if ($_GET['action'] == "logout") {
	include('actions/logout.php');
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