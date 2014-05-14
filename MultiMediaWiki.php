<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @license LGPL3
 * @link https://github.com/trialog/multimediawiki
 * @author Olivier Maridat
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}
// Extension credits for Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'MultiMediaWiki',
	'descriptionmsg' => 'multimediawiki-desc',
	'version' => 1.0,
	'url' => 'https://github.com/trialog/multimediawiki',
    'license-name' => 'https://github.com/trialog/multimediawiki/blob/master/LICENSE',
	'author' => array(
		'Olivier Maridat'
	),
);

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['MultiMediaWikiSettings'] = $dir . '/MultiMediaWikiSettings.body.php';
$wgExtensionMessagesFiles['MultiMediaWiki'] = $dir . 'MultiMediaWiki.i18n.php';
