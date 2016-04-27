<?php

			$id = $_GET['id'] - 1; //Get the passed id and subtract i by one since arrays start at 0

			//Use custom function to read dbusers file
			$input = db_read($dbusers);

			//Use custom database write function to write information to the dbusers file
			//db_write($dbusers, $input);
			//echo "<br>The user has been deleted. <a href='action.php?action=manageusers'>Back to Manage Users</a>";
			if (!isset($_POST['username'])) {
?>
<form class="form-inline" role="form" action="" method="post">
					<input type="hidden" value="<?php echo $id ?>" name="id">
						  <div class="form-group">
						    <label class="sr-only" for="name">Username</label>
						    <input type="text" class="form-control" name="username" id="username" value="<?php echo $input[$id]["username"]; ?>">
						  </div>
						  <div class="form-group">
						    <label class="sr-only" for="path">Password</label>
						    <input type="password" class="form-control" name="password" id="password" placeholder="Secret.">
						  </div>
						  <div class="form-group">
						  	<label class="sr-only" for="path">Privileges</label>
						  	<select name="privileges">
						  		<option disabled>Privileges</option>
						  		<?php if (isset($input[$id][priv])) { ?>
						  		<option value="standard">Standard</option>
						  		<option value="root" selected>Root</option>
						  		<?php } else { ?>
						  		<option value="standard" selected>Standard</option>
						  		<option value="root">Root</option>
						  		<?php } ?>
						  	</select>
						  	</div>
						  <button type="submit" class="btn btn-default">Edit</button>
					</form>
<?php
} else {
					$id = $_POST['id'];
					//Set information in variables
					$input[$id]["username"] = $_POST['username'];
					if ($_POST['password'] !== "") {
						$input[$id]["password"] = md5($_POST['password']);
					}

					//If privilege is set to standard
					if ($_POST['privileges'] == "standard") {
						if($input[$id]["priv"] !== "") {
							unset($input[$id]["priv"]);
						}
					//If privilege is set to root
					}elseif ($_POST['privileges'] == "root") {
						if (!isset($input[$id]["priv"])) {
							$input[$id]["priv"] = "root";
						}
					}
					//Use custom database write function to write information to the dbusers file
					db_write($dbusers, $input);
					echo "<br>The user has been edited. <a href='action.php?action=manageusers'>Back to Manage Users</a>";
}
?>