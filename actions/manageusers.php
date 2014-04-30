			<?php
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
						  <div class="form-group">
						  	<label class="sr-only" for="path">Privileges</label>
						  	<select name="privileges">
						  		<option disabled>Privileges</option>
						  		<option value="standard">Standard</option>
						  		<option value="root">Root</option>
						  	</select>
						  	</div>
						  <button type="submit" class="btn btn-default">Add</button>
					</form></div><br><br>
					<h2>Current users</h2>
					<?php
					//Get users from dbusers json file
					$input = db_read($dbusers);
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
							echo "<a class='btn btn-primary btn-xs' href='action.php?action=edituser&id=" . $i . "'>Edit</a> ";
							echo "<a class='btn btn-danger btn-xs' href='action.php?action=deleteuser&id=" . $i . "' onclick='return confirmAction()'>Delete</a></div></div>";
						}else {
							echo "<a class='btn btn-primary btn-xs' href='action.php?action=edituser&id=" . $i . "'>Edit</a></div></div>";
						}
					}
				}else{
					//Set information in variables
					$username = $_POST['username'];
					$password = md5($_POST['password']);
					$privilege = $_POST['privileges'];

					//Use custom function to read dbusers file
					$input = db_read($dbusers);

					//If privilege is set to standard
					if ($privilege == "standard") {
						array_push($input, Array(username => $username, password => $password));
					//If privilege is set to root
					}elseif ($privilege == "root") {
						array_push($input, Array(username => $username, password => $password, priv => $privilege));
					}

					//Use custom database write function to write information to the dbusers file
					db_write($dbusers, $input);

					echo "<br>The user has been added. <a href='action.php?action=manageusers'>Back to Manage Users</a>";
				}

				?>