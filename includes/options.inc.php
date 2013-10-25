<?php
// I would like to keep this page separate to keep things organised. This will be included in the master file and can be referenced from there
// The variables will be $optNameCammelBack and will always start with $opt to keep tracking them to this file simple

clearstatcache(); // Clear the stats
$lastEdit = stat('includes/options.inc.php');
$lastEdit = $lastEdit['mtime'];
$fileSize = filesize('includes/options.inc.php');

// Get the options from the db, will by default have a false value
$dbTimeStamp = Options::get('modified');
$dbFileSize = Options::get('filesize');

// Force the filesize and modification date to strings to be able to compare it with the DB
settype($lastEdit, 'string');
settype($fileSize, 'string');

$optionsUpdate = false;

// Update version based on the date and / or filesize. This will also work if the db is empty
if (($dbTimeStamp !== $lastEdit)
or ($dbFileSize !== $fileSize))
{

$optionsUpdate = true;   

Options::groupAdd('Website Settings', 'basic website information');
Options::groupAdd('META Data', 'control the Meta Data for the website');
Options::groupAdd('Email Templates', 'variables used in Email Templates');
Options::groupAdd('Miscellaneous', 'general settings page, not editible');
Options::groupAdd('User Settings', "options visible in the user's settings page");

// Set the timestamp and filesize
Options::add('modified', $lastEdit, 'hidden', 'Miscellaneous'); // Do not modify these, they need to be static
Options::add('filesize', $fileSize, 'hidden', 'Miscellaneous'); // Do not modify these, they need to be static

// These would be the options you want to set, it will first
// Site
Options::addOnce('siteName', 'http://www.mysite.co.za', 'input', 'Website Settings');
Options::addOnce('siteLogo', 'assets/img/logo.png', 'input', 'Website Settings');
Options::addOnce('siteIcon', 'assets/img/icon.png', 'input', 'Website Settings');
Options::addOnce('prettyName', '<small>www.</small>MySite<small>.co.za</small>', 'input', 'Website Settings');

// Email Templates
Options::addOnce('emailName', 'www.MySite.co.za', 'input', 'Email Templates');
Options::addOnce('emailInfo','info@mysite.co.za', 'input', 'Email Templates');
Options::addOnce('emailAdmin', 'drpain@mweb.co.za', 'input', 'Email Templates');

// META Data
Options::addOnce('metaAuthor', 'Rudi Strydom', 'input', 'META Data');
Options::addOnce('metaDesc', 'Baseline is a PHP framework. Based on Simple PHP Framework and intgrates with Bootstrap from Twitter to create baseline website.', 'textarea', 'META Data');
Options::addOnce('metaKeyWords', 'Baseline, Simple PHP Framework, Bootstrap from Twitter', 'textarea', 'META Data');
// Facebook meta
Options::addOnce('facebookType', 'website', 'input', 'META Data');
Options::addOnce('facebookUrl', Options::get("siteName"), 'input', 'META Data');
Options::addOnce('facebookImage', Options::get("siteLogo"), 'input', 'META Data');
Options::addOnce('facebookSiteName', Options::get("siteName"), 'input', 'META Data');
Options::addOnce('facebookAdminUsers', '0000000', 'input', 'META Data');
Options::addOnce('facebookTitle', 'FB Page title', 'input', 'META Data');

// User Settings, visible in their Settings.php page. This will be in addition to their email and password
// The values here would be the default settings shown in their console
Options::addOnce('firstName', 'John', 'input', 'User Settings');
Options::addOnce('surname', 'Doe', 'input', 'User Settings');
Options::addOnce('dateOfBirth', '631144800', 'date', 'User Settings');

} 
?>