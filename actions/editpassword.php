<?php
			//Function for searching in multidimensional arrays
			function searchMulti($id, $array, $needle) {
			   foreach ($array as $key => $val) {
			       if ($val[$needle] === $id) {
			           return $key;
			       }
			   }
			   return null;
			}

			//Use custom function to read dbusers file
			$input = db_read($dbusers);
			//print_r($input);

			//Use custom database write function to write information to the dbusers file
			//db_write($dbusers, $input);
			//echo "<br>The user has been deleted. <a href='action.php?action=manageusers'>Back to Manage Users</a>";
			if (!isset($_POST['password'])) {
				$arrayid = searchMulti($_SESSION['username'], $input, "username");
				?>
<form class="form-inline" role="form" action="" method="post">
					<input type="hidden" value="<?php echo $arrayid ?>" name="id">
						  <div class="form-group">
						    <label class="sr-only" for="name">Username</label>
						    <input type="text" class="form-control" name="username" id="username" value="<?php echo $_SESSION['username']; ?>" disabled>
						  </div>
						  <div class="form-group">
						    <label class="sr-only" for="path">Password</label>
						    <input type="password" class="form-control" name="password" id="password" placeholder="Secret.">
						  </div>
						  <button type="submit" class="btn btn-default">Change password</button>
					</form>
<?php
} else {
					$id = $_POST['id'];
					//Set information in variables
						$input[$id][password] = md5($_POST['password']);

					//Use custom database write function to write information to the dbusers file
					db_write($dbusers, $input);
					echo "<br>Your password has been changed. <a href='index.php'>Back to Dashboard</a>";
}