<?php
include('config.php');

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
?>