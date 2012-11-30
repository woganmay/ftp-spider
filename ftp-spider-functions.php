<?php

/**
 * Output functions
 */

function stdout($string, $time='') {
	$n = "$string\n";
	if ($time == 'time') $n = "[".date("H:i:s")."] $n"; 
	echo $n;	
}

function debug($string) {
	global $Options;
	if ($Options['debug']) stdout($string, 'time');
}

/**
 * Check for input parameters
 */
function ftpspider_options() {
	
	$params = getopt("", array("host:", "username:", "password:", "help", "debug", "outputlinks"));
	
	// Required
	$Options['host'] = (isset($params['host'])) ? $params['host'] : false;
	
	// Optional
	$Options['username'] = (isset($params['username'])) ? $params['username'] : false;
	$Options['password'] = (isset($params['password'])) ? $params['password'] : false;
	$Options['debug'] = (isset($params['debug'])) ? true : false;
	$Options['help'] = (isset($params['help'])) ? true : false;
	$Options['outputlinks'] = (isset($params['outputlinks'])) ? true : false;
	
	// Are all the required parameters in?
	if ($Options['host'] == false) {
		return false;
	} else {
		return $Options;
	}
	
}

/**
 * Recursive file listing function
 */

function ftpspider_recurse($connection, $path) {
	global $MasterList, $gNav;
	$list = ftp_nlist($connection, $path);
	
	foreach($list as $file) {
		debug("Inspecting $file");
		if (count(ftp_nlist($connection, $path)) > 0) {
			
			if (!in_array($file, $gNav)) {
				$gNav[] = $file;
				debug("Recursing into $file");
				ftpspider_recurse($connection, $file);
			}
			
		} else {
			$MasterList[] = $file;
		}
	}
} 
