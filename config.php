<?php
/* ===== Configuration for Slum CMS ===== */

/* Function-based configuration
================== */
$triggerclass = "slum"; //Class that makes elements editable by Slum

/* Uploads
================== */
$uploadpath = "img/"; //Path from webroot that images should be uploaded to - do not prepend a /. But do append.
$deleteoldupload = true; //Delete old file when new one is uploaded in its place

/* Text-area
================== */
$triggerplaintext = "plain"; //Keyword to set textarea to plaintext
$triggerwysiwyg = "wysiwyg"; //Keyword to set textarea to WYSIWYG (is default setting)
$defaulttextarea = "wysiwyg"; //Default textarea type - set to "plain" for plaintext textarea
$wysiwygbuttonconfig = "'bold','italic','underline','strikethrough','left','center','right','justify','ol','ul','fontSize','fontFormat','indent','outdent','xhtml'"; //Change which buttons appear on the wysiwyg editors (all available options can be found here: http://wiki.nicedit.com/w/page/515/Configuration%20Options)

/* Switches
================== */
$showpath = false; //Show path to the page underneath its name
$showversion = true; //Show version number on index page
$checkversion = true; //Check for new version of Slum CMS on login (only for root users).

//Less important configurations
$triggertitle = "slumtitle"; //Change the attributename for defining titles (e.g. slumtitle="First column", where slumtitle is triggertitle)
$triggertextarea = "textarea"; //Textarea defining attribute for HTML elements (e.g. textarea="plain", where textarea is the attribute)
$rootpath = $_SERVER['DOCUMENT_ROOT'] . "/"; //Makes all page URLS from webroot instead of relative to the Slum directory
$dbpages = "db/pages.json"; //Path to the database file containing information regarding pages
$dbusers = "db/users.php"; //Path to database file containing information regarding users -- is protected (notice .php extension, if you change it's location or name)
$version = "0.3.2"; //Version number of current release

/* Promotional-based configuration
(Change this if you don't want it to say Slum CMS all over.)
================== */
$shortname = "Slum CMS";
$longname = "Simple Lightweight Unbulky Minimalistic Content Management System";
$bothnames = $longname . " (Or just " . $shortname . ")";
?>
