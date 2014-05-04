<?php

include('resources/reqs.php');
/* Blank slate
================== */
if ($_SESSION['loggedin'] == "y") {
	//Get page url and load contents
	$page = $rootpath . $_GET['page'];
	$html = file_get_html($page);

	//Set id variable so that we can keep track of elements and update the correct ones with the corresponding info
	$id = 0;
	//Set wysid to keep an independent identifier for textareas to be converted to wysiwygs
	$wysid = 0;

	//Create empty array to store editable elements, information regarding textarea type in and titles in
	$elements = array();
	$textarea = array();
	$titles = array();
	$images = array();

	//Treat information for all found elements with triggerclass and push to arrays
	foreach($html->find('.' . $triggerclass) as $cms) {
		//Push innertext of each element with the triggerclass to elements array
		if ($cms->tag === "img"){
			array_push($elements, "image");
			$images[$id] = $cms->src;
		}else{
			array_push($elements, $cms->innertext);
		}

		//If the triggertitle attribute isn't empty, push it to titles array
		if ($cms->$triggertitle !== ""){
			array_push($titles, $cms->$triggertitle);
		}else{
			//If it is empty (not existing), push an empty entry to array
			array_push($titles, "");
		}
		//If the defaulttextarea is set to be wysiwyg in the config.php file
		if ($defaulttextarea == "wysiwyg") {
			//If the textarea is not set to be plaintext
			if ($cms->$triggertextarea !== $triggerplaintext) {
				//Push the information (that this textarea is not to be plaintext) to the textarea array
	   		array_push($textarea, $triggerwysiwyg);
	  	}else{
	  		//Push whatever is inserted in the textarea attribute to the array
	  		array_push($textarea, $cms->$triggertextarea);
	  	}
	  	//If the defaulttextarea is set to be plaintext
  	}elseif ($defaulttextarea == "plain") {
  		//If the textarea is not set to be wysiwyg
			if ($cms->$triggertextarea !== $triggerwysiwyg) {
				//Push the information (that this textarea is not to be wysiwyg) to the textarea array
	   		array_push($textarea, $triggerplaintext);
	  	}else{
	  		//Push whatever is inserted in the textarea attribute to the array
	  		array_push($textarea, $cms->$triggertextarea);
	  	}
  	}
  	$id++;
	}

	//Reset id
	$id = 0;

	//If page is not sent along as a post (no information is changed yet)
	if (!isset($_POST['page'])) { ?>

		<form action="" method="post" enctype="multipart/form-data">
		<!-- Create hidden input field with page url -->
		<input type="hidden" value="<?php echo $page ?>" name="page" id="page">
		<?php
		//Foreach entry in elements array, echo a textarea to edit it, and +1 the id
		foreach ($elements as $element) {
			$id++;
			//If textarea attribute for corresponding element is not set or set to wysiwyg, echo HTML accordingly and +1 wysid
			echo "<div class='col-lg-12'><h3>" . $titles[$id-1] . "</h3>";
			//If element is image
			if ($element === "image") {
				//Create img element with path to image as src
				echo "<img width='450' src='" . $images[$id-1] . "'>";
				//Create elements for uploading new image
				echo "<br>Upload new image:<br><input type='file' name='elementid[" . $id . "]'></div>";
			}else{
			if ($textarea[$id-1] == $triggerwysiwyg) {
				$wysid++;
				echo "<textarea class='editarea wys' id='niceditor". $wysid. "' name='elementid[" . $id . "]'>" . $element . "</textarea><br></div>";
			//If textarea attribute for corresponding element is set to plain, echo HTML accordingly
			}elseif ($textarea[$id-1] == $triggerplaintext){
				echo "<textarea class='editarea' name='elementid[" . $id . "]'>" . $element . "</textarea><br></div>";
			}
		}
		}
		?>
		<div class='col-lg-12'><input class="btn btn-primary editsubmit" type="submit"></div>
		<?php

	/* Information is sent
	================== */
	}else{
		$id = 0;

		//Get page url and load contents - from hidden input field
		$html = file_get_html($_POST['page']);

		//For each element with triggerclass, set information to the new submitted information by +1 id
		foreach($html->find('.' . $triggerclass) as $cms) {
			$id++;
			//If element is image
			if ($cms->tag === "img"){
				//If the deletion of old files on new ones uploaded is enabled
				if ($deleteoldupload === true) {
				unlink($rootpath . substr($cms->src, 1));
				}
				//Move uploaded file from tmp to perm directory
				move_uploaded_file ($_FILES['elementid']['tmp_name'][$id], 
       "" . $rootpath . $uploadpath . $_FILES['elementid']['name'][$id] . "");
				//Set new directory to element on page
				$cms->src = "/" . $uploadpath . $_FILES['elementid']['name'][$id];
				//If is not image
			}else{
				//Change information in element
				$cms->innertext = $_POST['elementid'][$id];
			}
		}

		//Tidy up final HTML
		$html = fix_newlines_for_clean_html($html);

		//Write to the posted URL
		$fp = fopen($_POST['page'], 'w');
		fwrite($fp, $html);
		fclose($fp);
		echo "<br>The page has been succesfully updated. <a href='index.php'>Go back</a>";
	}
}

?>

<!-- Include nicEdit WYSIWYG editor -->
<script src="resources/nicedit/nicEdit.js" type="text/javascript"></script>



<!-- Turn selected textarea(s) to WYSIWYG -->
<script type="text/javascript">bkLib.onDomLoaded(function() {
	var id = 0;
var elements = document.querySelectorAll('.wys');
Array.prototype.forEach.call(elements, function(el, i){
		id = id + 1;
		var str1 = "niceditor";
		var res = str1.concat(id);
   new nicEditor({buttonList : [<?php echo $wysiwygbuttonconfig?>]}).panelInstance(res);
});
});</script>
</div>
