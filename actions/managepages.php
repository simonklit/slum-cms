<?
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
					$i = 0;
					foreach ($input as $value) {
						echo "<div class='col-lg-3'><div class='well well-lg'>";
						$i++;
						echo "Page: ". $value["page"]. "<br>";
						echo "Path: " . $value["path"] . "<br>";
						//Do not echo the delete button if only one entry exists
						if (count($input) !== 1) {
							echo "<a class='btn btn-primary btn-xs' href='action.php?action=editpage&id=" . $i . "'>Edit</a> ";
							echo "<a class='btn btn-danger btn-xs' href='action.php?action=deletepage&id=" . $i . "' onclick='return confirmAction()'>Delete</a></div></div>";
						}else {
							echo "<a class='btn btn-primary btn-xs' href='action.php?action=editpage&id=" . $i . "'>Edit</a></div></div>";
						}
					}
				}else{
					//Set user passed information in variables
					$name = htmlspecialchars($_POST['name']); //if æ, ø, å and the likes is used, htmlspecialchars makes sure it works
					$path = $_POST['path'];

					//Load current json file and decode it
					$input = json_decode(file_get_contents($dbpages), true);

					//Push new information to the end of the array decoded from json
					array_push($input, Array("page" => $name, "path" => $path));

					//Encode information and place in output variable
					$output = json_format($input);

					//Write information to dbpages file
					$fp = fopen($dbpages, 'w');
					fwrite($fp, stripslashes($output));
					fclose($fp);
					echo "<br>The page has been added. <a href='action.php?action=managepages'>Back to Manage Pages</a>";
				}

				?>