#!/usr/bin/php
<?php

/*
 * FTP Spider
 * Wogan May
 */

require_once("ftp-spider-functions.php");

$Options = ftpspider_options();

if (!$Options) {
	stdout("Not all required parameters were provided - at the very least, set the host.");
	die("\n");
}

debug("Starting FTP Spider run");
debug("Connecting to: ".$Options['host']);

$connection = ftp_connect($Options['host']);

if (!$connection) {
	stdout("Error while trying to connect to the specified host");
	die("Terminating\n");
} else {
	
	// If username and password are set, try logging in
	
	if ($Options['username'] && $Options['password']) {
		$login_result = ftp_login($connection, $Options['username'], $Options['password']);
	} else {
		// Anonymous login
		$login_result = ftp_login($connection, "anonymous", "");
	}
	
	
	if (!$login_result) {
		stdout("Error while trying to log into the specified FTP server", 'time');
		die("Terminating\n");
	} else {
		debug("Connected to host");
	}
	
}

// Let's do some stuff!
$MasterList = array();
$gNav = array();
ftpspider_recurse($connection, "/");

debug("Discovered ".count($MasterList)." files");

if ($Options['outputlinks']) {
	// Use ftp://USER:PASS@HOST{LINK}
	foreach($MasterList as $link) {
		echo sprintf("ftp://%s:%s@%s%s\n", $Options['username'], $Options['password'], $Options['host'], $link);
	}
} else {
	// Just dump the link
	foreach($MasterList as $link) {
		echo "$link\n";
	}
}

debug("Disconnecting from host");
ftp_close($connection);
