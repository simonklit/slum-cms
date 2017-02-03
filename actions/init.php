<?php

if($enabletemplates)
{
	mkdir($generateddirname);
	$css = $triggertemplate . " { display: none !important; visibility: hidden !important; }";
	$fp = fopen($generateddirname . "/" . $generatedcssname, 'w');
	fwrite($fp, $css);
	fclose($fp);
}

conf_write(['init' => true]);

?>