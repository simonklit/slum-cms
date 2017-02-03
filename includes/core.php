<?php
include('minreqs.php');
include('config.php');
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
function db_read($path) {
	$open = true;
	include $path;
	return $users;
}

function db_write($path, $array) {
	$content = '<?php if(isset($open) && $open){ $users = ';
	$content .= var_export($array, true);
	$content .= '; }else {echo "Access denied."; header("HTTP/1.1 403 Forbidden"); exit; } ?>';
	$fp = fopen($path, 'w');
	fwrite($fp, $content);
	fclose($fp);
}

function conf_read()
{
	global $dbconf;
	$ar = file_get_contents($dbconf);
	return json_decode($ar, true);
}

function conf_write($array)
{
	global $dbconf;
	$current_confs = conf_read();

	foreach($array as $key => $value)
	{
		$current_confs[$key] = $value;
	}
	//Encode information and place in output variable
	$output = json_format($current_confs);

	//Write information to dbpages file
	$fp = fopen($dbconf, 'w');
	fwrite($fp, stripslashes($output));
	fclose($fp);
}

function checkversion() {
	if (!$_SESSION['checked']){
	$options  = array('http' => array('user_agent'=> $_SERVER['HTTP_USER_AGENT']));
	$context  = stream_context_create($options);
	$tags = json_decode(file_get_contents("https://api.github.com/repos/simonklit/slum-cms/tags", false, $context), true);
	if ($GLOBALS['version'] < $tags[0]["name"]) {
		$_SESSION['checked'] = true;
		$_SESSION['updatemessage'] = "<b>New update available</b>. Download it here: <a href='" . $tags[0]["zipball_url"] . "' target='_blank'>version " . $tags[0]["name"] . " (zip-file)</a> or <a href='" . $tags[0]["tarball_url"] . "' target='_blank'>version " . $tags[0]["name"] . " (tarball)</a><br>";
	}else{
		$_SESSION['checked'] = true;	
	}
	}
}
?>