<?php
/*
 * Manage multiple Wikis using
 * * 1 MediaWiki installation
 * * 1 database (each installation can use different tables by configuring a prefix)
 */
 
// -- Select the relevant Wiki
// Mode 1: by domain name
$wikiCode = '';
$server = @$_SERVER["SERVER_NAME"];
if (! empty($server) && $server != "wiki.trialog.com" && $server != "localhost"
	&& !empty($wgMultiMediaWikiServers) && array_key_exists($server, $wgMultiMediaWikiServers)) {
	$wgServer = 'http://'.$server;
	$wikiCode = $wgMultiMediaWikiServers[$server];
	$wgDBprefix = 'wiki'.$wikiCode.'_'; 
	$wgUsePathInfo = true;
	$wgWikiAddress = $wgServer;
	$wgScriptPath = $wgServer.'/';
	$wgScript = $wgScriptPath;
	$wgLoadScript = '/load'.$wgScriptExtension;
	$wgStylePath = '/skins';
	$wgArticlePath = '/wiki/$1';
	$wgUploadPath = '/images/'.$wikiCode;
	$wgUploadDirectory = $IP.'/images/'.$wikiCode;
	$wgFileCacheDirectory = $wgUploadDirectory.'/cache';
	$wgCacheDirectory = $IP.'/cache/'.$wikiCode;
	$wgLogo = $wgUploadPath.'/logo/wiki.png';
	require_once $IP . '/LocalSettings_Wiki'.ucfirst($wikiCode).'.php';  
}
// Mode 2: by folder name
else {
	// Check maintenance mode for installation process
	if (isset($maintenance)) {
		// Small change to Maintenance.php available
		if (in_array('hasOption', get_class_methods($maintenance)) && $maintenance->hasOption('wiki')) {
		    $_GET['wiki'] = $maintenance->getOption('wiki', 'Trialog');
		}         // Normal MediaWiki version
		else {
		    ob_start();
		    $maintenance->globals();
		    $strGlobals = ob_get_clean();
		    if (preg_match('!--wiki!', $strGlobals)) {
			$_GET['wiki'] = preg_replace('!^.*--wiki\n\s*\[\d+\]\s*=>\s*([a-zA-Z -]+)\s*\n.*$!s', '$1', $strGlobals);
		    }
		}
		$wgShowExceptionDetails = true;
		// if (NULL != $maintenance && NULL != ($options = @$maintenance->getOption("wiki"))) {
		// die('Maintenance!'.$options);
		// $_GET['wiki'] = $options;
		// }
	}
	    
	// Selected Wiki
	if (isset($_GET['wiki']) && null != $_GET['wiki'] && '' != $_GET['wiki']) {
		$wikiCode = htmlentities(trim($_GET['wiki']));
		$wgUsePathInfo = true;
		$wgDBprefix = 'wiki'.lcfirst($wikiCode).'_'; 
		$wgWikiAddress = $wgServer.'/'.$wikiCode;
		$wgSitename = 'Wiki '.ucfirst($wikiCode);
		$wgScriptPath = $wgScriptPath.'/'.$wikiCode;
		$wgScript = $wgScriptPath;
		$wgStylePath = $wgScriptPath.'/skins';
		$wgLoadScript = $wgScriptPath.'/load'.$wgScriptExtension;
		$wgArticlePath = $wgScript.'/$1';
		$wgUploadPath = $wgScriptPath.'/images';
		$wgUploadDirectory = $IP.'/images/'.$wikiCode;
		$wgFileCacheDirectory = $wgUploadDirectory.'/cache';
		$wgCacheDirectory = $IP.'/cache/'.$wikiCode;
		$wgLogo = $wgUploadPath.'/logo/wiki.png';
	}
}

// Launch the selected wiki configuration
if (file_exists($IP . '/LocalSettings_Wiki'.ucfirst($wikiCode).'.php')) {
	require_once($IP . '/LocalSettings_Wiki'.ucfirst($wikiCode).'.php');
}
else {
	die('This wiki doesn\'t exist, sorry!');
}
