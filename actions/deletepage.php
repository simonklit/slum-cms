	<?php

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

			?>