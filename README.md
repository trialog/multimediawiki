MultiMediaWiki Extension
========================

An extension to manage several wikis with one MediaWiki installation

Usage
----
Add the following before your other extensions in LocalSettings.php

	$wgMultiMediaWikiServers = array(); // $_SERVER["SERVER_NAME"] => wiki code
	$wgMultiMediaWikiServers['yoursubwiki.domain.com'] = 'wiki1';
	$wgMultiMediaWikiServers['yourotherwiki.domain.com'] = 'wiki2';
	require_once($IP.'/extensions/multimediawiki/MultiMediaWiki.php');

Then add one file per wiki for specific configuration: LocalSettings_WikiWiki1.php and LocalSettings_WikiWiki2.php. ''By default, the table prefix will be "wikiWiki1_" and "wikiWiki2_".''

License
----
This MediaWiki extension has been made by ''TRIALOG'' under the LGPL3+ license. It is a work in progress, not finished but still useful, and every feedbacks are welcome!
