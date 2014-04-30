<?php
/* ===== Configuration for Slum CMS ===== */

/* Function-based configuration
================== */
$triggerclass = "slum"; //Class that makes elements editable by Slum

/* Text-area
================== */
$triggerplaintext = "plain"; //Keyword to set textarea to plaintext
$triggerwysiwyg = "wysiwyg"; //Keyword to set textarea to WYSIWYG (is default setting)
$defaulttextarea = "wysiwyg"; //Default textarea type - set to "plain" for plaintext textarea
$wysiwygbuttonconfig = "'bold','italic','underline','strikethrough','left','center','right','justify','ol','ul','fontSize','fontFormat','indent','outdent','image','upload','xhtml'"; //Change which buttons appear on the wysiwyg editors (all available options can be found here: http://wiki.nicedit.com/w/page/515/Configuration%20Options)

/* Switches
================== */
$showpath = "false"; //Show path to the page underneath its name

//Less important configurations
$triggertitle = "slumtitle"; //Change the attributename for defining titles (e.g. slumtitle="First column", where slumtitle is triggertitle)
$triggertextarea = "textarea"; //Textarea defining attribute for HTML elements (e.g. textarea="plain", where textarea is the attribute)
$rootpath = $_SERVER['DOCUMENT_ROOT'] . "/"; //Makes all page URLS from webroot instead of relative to the Slum directory
$dbpages = "db/pages.json"; //Path to the database file containing information regarding pages
$dbusers = "db/users.php"; //Path to database file containing information regarding users -- is protected (notice .php extension, if you change it's location or name)


/* Promotional-based configuration
(Change this if you don't want it to say Slum CMS all over.)
================== */
$shortname = "Slum CMS";
$longname = "Simple Lightweight Unbulky Minimalistic Content Management System";
$bothnames = $longname . " (Or just " . $shortname . ")";
?>