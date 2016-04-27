<?php

			$id = $_GET['id'] - 1; //Get the passed id and subtract i by one since arrays start at 0

			//Use custom function to read dbusers file
			$input = json_decode(file_get_contents($dbpages), true);

			//Use custom database write function to write information to the dbusers file
			//db_write($dbusers, $input);
			//echo "<br>The user has been deleted. <a href='action.php?action=manageusers'>Back to Manage Users</a>";
			if (!isset($_POST['name'])) {
?>
					<form class="form-inline" role="form" action="" method="post">
					<!-- Hidden input field to tell the file that we are managing pages, after submission -->
					<input type="hidden" value="<?php echo $id; ?>" name="id">
						  <div class="form-group">
						    <label class="sr-only" for="name">Page name</label>
						    <input type="text" class="form-control" name="name" id="name" value="<?php echo $input[$id]["page"] ?>">
						  </div>
						  <div class="form-group">
						    <label class="sr-only" for="path">Page path (from webroot)</label>
						    <input type="text" class="form-control wide" name="path" id="path" value="<?php echo $input[$id]["path"] ?>">
						  </div>
						  <button type="submit" class="btn btn-default">Edit</button>
					</form>
<?php
} else {
					$id = $_POST['id'];
					//Set information in variables
					$input[$id]["page"] = $_POST['name'];
					$input[$id]["path"] = $_POST['path'];

					//Encode information and place in output variable
					$output = json_format($input);

					//Write information to dbpages file
					$fp = fopen($dbpages, 'w');
					fwrite($fp, stripslashes($output));
					fclose($fp);
					echo "<br>The page has been edited. <a href='action.php?action=managepages'>Back to Manage Pages</a>";
}
?>