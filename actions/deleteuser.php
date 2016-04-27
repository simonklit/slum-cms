<?php
			$id = $_GET['id'] - 1; //Get the passed id and subtract i by one since arrays start at 0

			//Use custom function to read dbusers file
			$input = db_read($dbusers);

			//Remove the selected id from the array
			unset($input[$id]);

			//Fix integers, so that we don't have integer skips
			$input = array_values($input);

			//Use custom database write function to write information to the dbusers file
			db_write($dbusers, $input);
			echo "<br>The user has been deleted. <a href='action.php?action=manageusers'>Back to Manage Users</a>";
?>