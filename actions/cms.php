<?php

include('includes/reqs.php');
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
	$deleteable = array();
	$titles = array();
	$images = array();
	$templates = array();

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

		//If the triggerdeletable attribute is set.
		if(isset($cms->{$triggerdeleteable}))
		{
			array_push($deleteable, true);
		} else {
			array_push($deleteable, false);
		}

		//If the defaulttextarea is set to be wysiwyg in the config.php file
		if ($defaulttextarea == $triggerwysiwyg) {
			//If the textarea is not set to be plaintext
			if ($cms->$triggertextarea !== $triggerplaintext) {
				//Push the information (that this textarea is not to be plaintext) to the textarea array
	   		array_push($textarea, $triggerwysiwyg);
	  	}else{
	  		//Push whatever is inserted in the textarea attribute to the array
	  		array_push($textarea, $cms->$triggertextarea);
	  	}
	  	//If the defaulttextarea is set to be plaintext
  	}elseif ($defaulttextarea == $triggerplaintext) {
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

	// Iterate over all templates.
	if($enabletemplates)
	{
		foreach($html->find($triggertemplate) as $template)
		{
			$temparr = array();
			// Iterate over all variables in template.
			foreach($template->find($triggervar) as $var)
			{
				array_push($temparr, "");
			}
			array_push($templates, $temparr);
			$id++;
		}
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
			echo "<div class='col-lg-12'><h3>" . $titles[$id-1];
			//If element is image
			if ($deleteable[$id-1])
			{
				echo ' &nbsp;<small>(<label><input type="checkbox" name="deleteelement[' . $id . ']" value="true"> Delete this element</label>)</small></h3>';
			} else {
				echo '</h3>';
			}
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

		$id = 0;
		$templatei = 0;
		$vari = 0;
		if($enabletemplates)
		{
			foreach($html->find($triggertemplate) as $template)
			{
				$vari = 0;
				//$templatearray = array("templatetitle" => $template->{$triggertitle});
				$templatearray = array();
				echo "<div class='col-lg-12'><h3>".$template->{$triggertitle}."</h3>";
				echo "<a href='#' class='btn btn-success btn-sm' id='tempbutton".$templatei."' onclick='createFromTemplate(".$templatei.");'>Create from template</a><br>&nbsp;<br></div>";

				foreach($template->find("[".$triggervar."]") as $var)
				{
					$vararray = array();
					$vararray['title'] = $var->{$triggertitle};
					// If wyswigy
					if (($var->{$triggertextarea} == $triggerplaintext) ^ ($defaulttextarea != $triggerplaintext)) {
						$vararray['textarea'] = "wysiwyg";

					// If plain
					}else {
						$vararray['textarea'] = "plain";
					}
					if($var->tag == "img")
					{
						$vararray['textarea'] = "image";
					}
					array_push($templatearray, $vararray);
					$vari++;
				}
				//var_dump($template->innertext);
				echo "<script>template".$templatei." = ".json_encode($templatearray)."; template".$templatei."title = '" . $template->{$triggertitle} . "'</script>";
				$id++;
				$templatei++;
				echo "<div class='col-lg-10'><hr></div>";
			}
			echo "<script>numoftemplates = ".$templatei."</script>";
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
			if(isset($_POST['deleteelement'][$id]))
			{
				if($softdelete)
				{
					// Soft delete the element
					$cms->style .= "display: none !important; visibility: hidden !important;"; // Do not display element.
					$cms->class = str_replace($triggerclass, "", $cms->class); // Remove element from system.
				} else {
					// Delete the element
					$cms->outertext = '';					
				}
				// Skip to next foreach iteration.
				continue;
			}
			if ($cms->tag === "img"){
				//If the deletion of old files on new ones uploaded is enabled
				if (file_exists($_FILES['elementid']['tmp_name'][$id])) {
				if ($deleteoldupload === true) {
				unlink($rootpath . substr($cms->src, 1));
				}
				//Move uploaded file from tmp to perm directory
				move_uploaded_file ($_FILES['elementid']['tmp_name'][$id], 
       "" . $rootpath . $uploadpath . $_FILES['elementid']['name'][$id] . "");
				//Set new directory to element on page
				$cms->src = "/" . $uploadpath . $_FILES['elementid']['name'][$id];
				//If is not image
				}
			}else{
				//Change information in element
				$cms->innertext = $_POST['elementid'][$id];
			}
		}

		if($enabletemplates)
		{

			if(isset($_POST['amountofcreatedtemplates']))
			{
			$amountofcreatedtemplates = json_decode($_POST['amountofcreatedtemplates'], true);
			$ilm = 0;
			foreach($amountofcreatedtemplates as $am)
			{
				$templ = $html->find($triggertemplate)[$ilm];
				for ($i = $am; $i > 0; $i--) {
					$newelem = unserialize(serialize($templ)); // Clone the template so we don't modify the original template.
					$amountofvars = count($templ->find("[".$triggervar."]"));
					$amountofvars = $amountofvars - 1;

					for($vi = 0; $vi <= $amountofvars; $vi++)
					{
						$var = $newelem->find("[".$triggervar."]")[$vi];
						$var->class .= $triggerclass;
						if ($var->tag === "img"){
							//If the deletion of old files on new ones uploaded is enabled
							if (file_exists($_FILES['filetemp'.$ilm.'m'.$i.'var'.$vi]['tmp_name'])) {

								//Move uploaded file from tmp to perm directory
								move_uploaded_file ($_FILES['filetemp'.$ilm.'m'.$i.'var'.$vi]['tmp_name'], 
				       			$rootpath . $uploadpath . $_FILES['filetemp'.$ilm.'m'.$i.'var'.$vi]['name']);
								//Set new directory to element on page
								$var->src = "/" . $uploadpath . $_FILES['filetemp'.$ilm.'m'.$i.'var'.$vi]['name'];
								//If is not image
							}
						} else {
							$var->innertext = $_POST['template'.$ilm.'m'.($i)][$vi];
						}
					}

					$newelem = str_get_html($newelem->innertext);
					foreach($newelem->find("[".$triggervar."]") as $var) {
							unset($var->{$triggervar});
					}

					$templ->outertext = $newelem . $templ->outertext;
				}
				$ilm++;
			}
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
<script src="includes/nicedit/nicEdit.js" type="text/javascript"></script>

<!-- Create from template javascript -->
<script type="text/javascript">
	amountofcreatedtemplates = {};
	createFromTemplate = function(id)
	{
		curtemp = JSON.parse(JSON.stringify(window['template'+id]));
		if(typeof amountofcreatedtemplates[id] !== 'undefined')
		{
			amountofcreatedtemplates[id] = amountofcreatedtemplates[id] + 1;
		} else {
			amountofcreatedtemplates[id] = 1;
		}

		button = document.getElementById("tempbutton"+id);
		elem = document.createElement("div");
		elem.class = "col-lg-12";
		elem.id = "tempid" + amountofcreatedtemplates[id];
		elem.innerHTML = "<h3>"+window['template'+id+'title']+" ("+amountofcreatedtemplates[id]+")</h3>";
		//delete curtemp.templatetitle;
		vari = 0;
		wysid = 0;


		if(document.getElementById("amountofcreatedtemplates") !== null)
		{
			document.getElementById('amountofcreatedtemplates').value = JSON.stringify(amountofcreatedtemplates);
		} else {
			elem.innerHTML += "<input type='hidden' name='amountofcreatedtemplates' id='amountofcreatedtemplates' value='"+JSON.stringify(amountofcreatedtemplates)+"'>";
		}

		elem.innerHTML += '<button class="btn btn-link" id="rembut'+id+'m'+amountofcreatedtemplates[id]+'" onclick="deleteFromTemplate('+ id +','+amountofcreatedtemplates[id]+');"">Remove</button>';
		Array.prototype.forEach.call(curtemp, function(obj){
			if(obj.title != false)
			{
				elem.innerHTML += "<h3>" + obj.title + "</h3>";
			}
			if(obj.textarea == "<?php echo $triggerwysiwyg; ?>")
			{
				elem.innerHTML += "<textarea class='editarea wys' id='extraniceditor"+id+"m"+amountofcreatedtemplates[id]+"m"+wysid+"' name='template"+id+"m"+amountofcreatedtemplates[id]+"[" + vari + "]'></textarea><br>";
				wysid = wysid + 1;
			} else if (obj.textarea == "<?php echo $triggerplaintext; ?>")
			{
				elem.innerHTML += "<textarea class='editarea' name='template"+id+"m"+amountofcreatedtemplates[id]+"[" + vari + "]'></textarea><br>";
			} else if (obj.textarea == "image")
			{
				elem.innerHTML += "<br>Upload new image:<br><input type='file' name='filetemp"+id+"m"+amountofcreatedtemplates[id]+"var"+vari+"'></div>";

			}
			vari = vari + 1;
		});

		if(amountofcreatedtemplates[id] > 1)
		{
			prevrem = document.getElementById("rembut"+id+"m"+(amountofcreatedtemplates[id]-1)).disabled = true;
			sibl = document.getElementById("tempid"+(amountofcreatedtemplates[id]-1));
			sibl.parentNode.insertBefore(elem, sibl.nextSibling);

		} else {
			button.parentNode.insertBefore(elem, button.nextSibling);
		}
		for (var i = 0; i < wysid; i++) {
			new nicEditor({buttonList : [<?php echo $wysiwygbuttonconfig?>]}).panelInstance("extraniceditor" + id + "m" + amountofcreatedtemplates[id] + "m" + i);
		}

		
	}

	deleteFromTemplate = function(id, amountof)
	{
		element = document.getElementById("tempid" + amountof);
		element.outerHTML = "";
		delete element;
		if(typeof amountofcreatedtemplates[id] !== 'undefined')
		{
			amountofcreatedtemplates[id] = amountofcreatedtemplates[id] - 1;
		}
		if(amountofcreatedtemplates[id] != 0)
		{
			console.log("rembut"+id+"m"+(amountofcreatedtemplates[id]-1));
			prevrem = document.getElementById("rembut"+id+"m"+(amountofcreatedtemplates[id])).disabled = false;
		}

	}
</script>

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
