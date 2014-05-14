<?php
/*
== Manage multiple Wikis using ==
* 1 MediaWiki installation
* 1 database (each installation can use different tables by configuring a prefix)
*/

// -- Select the relevant Wiki
$server=@$_SERVER["SERVER_NAME"];
if(!empty($server) && $server!="wiki.trialog.com" && $server!="localhost"){
    switch($server)
    {
        case "wiki.paris-project.org":
            require_once $IP.'/LocalSettings_WikiParis.php';
            break;
        case "wiki.pripare.eu":
            require_once $IP.'/LocalSettings_WikiPripare.php';
            break;
		case "gerontech-aphp.trialog.com":
            require_once $IP.'/LocalSettings_Wikicgaphp.php';
            break;
        default:
            echo 'This domain is not configured.';
            exit(0);
    }
}
else{
    // Default Wiki
    $wikiCode = 'Trialog';
    if (isset($maintenance)) {
    	// Small change to Maintenance.php available
    	if (in_array('hasOption', get_class_methods($maintenance)) && $maintenance->hasOption('wiki')) {
    		$_GET['wiki'] = $maintenance->getOption('wiki', 'Trialog');
    	}
    	// Normal MediaWiki version
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
	$wgScriptPath = $wgScriptPath.'/'.$wikiCode;
	$wgScript = $wgScriptPath;
        $wgWikiAddress = $wgServer.'/'.$wikiCode;
        $wgUsePathInfo	= true;
    }

    // -- Launch the selected wiki configuration
    if(file_exists($IP.'/LocalSettings_Wiki'.$wikiCode.'.php')) {
        require_once ($IP.'/LocalSettings_Wiki'.$wikiCode.'.php');
    }
    // This Wiki doesn't exist: allow the user to create it
    else {
    //	require_once( "$IP/includes/templates/NoLocalSettings.php" );
        // TODO: gérer l'installation du nouveau sub-wiki
        die('No Settings yet! Create the file: '.$IP.'/LocalSettings_Wiki'.$wikiCode.'.php first!'.(isset($maintenance) ? ' Hint: don\'t forget --globals!' : ''));
    }
}
