<?php
date_default_timezone_set('America/New_York');

// database settings
$db_name = getenv("DATABASE_NAME");
$db_name = $db_name ? $db_name : "open-records-generator";


$models_root = "/Library/WebServer/Documents/trigger.local/open-records-generator/models/";
// $models_root = "/var/www/html/open-records-generator/models/";

$lib_root = "/Library/WebServer/Documents/trigger.local/open-records-generator/lib/";
// $lib_root = "/var/www/html/open-records-generator/lib/";

require_once($models_root."model.php");
require_once($models_root."objects.php");
require_once($models_root."wires.php");
require_once($models_root."media.php");
require_once($models_root."events.php");
require_once($lib_root."lib.php");
require_once($lib_root."url-base.php");

set_include_path($lib_root);
spl_autoload_register(function ($class) {
	$file = strtolower(preg_replace('#\\\|_(?!.+\\\)#','/', $class) . '.php');
	if (stream_resolve_include_path($file))
		require $file;
});

// connect to database (called in head.php)
function db_connect($remote_user) {
	global $adminURLString;
	global $readOnlyURLString;

	$users = array();
	$creds = array();

	if ($adminURLString) {
		// IF YOU ARE USING ENVIRONMENTAL VARIABLES (you should)
		$urlAdmin = parse_url($adminURLString);
		$host = $urlAdmin["host"];
		$dbse = substr($urlAdmin["path"], 1);

		$creds['rw']['db_user'] = $urlAdmin["user"];
		$creds['rw']['db_pass'] = $urlAdmin["pass"];

		$urlReadOnly = parse_url($readOnlyURLString);
		$creds['r']['db_user'] = $urlReadOnly["user"];
		$creds['r']['db_pass'] = $urlReadOnly["pass"];

	} else {
		// IF YOU ARE NOT USING ENVIRONMENTAL VARIABLES
		$host = "localhost";
		$dbse = "trigger_local";

		// full access
		$creds['full']['db_user'] = "root";
		$creds['full']['db_pass'] = "f3f4p4ax";

		// read / write access
		// (can't create / drop tables)
		$creds['rw']['db_user'] = "root";
		$creds['rw']['db_pass'] = "f3f4p4ax";

		// read-only access
		$creds['r']['db_user'] = "root";
		$creds['r']['db_pass'] = "f3f4p4ax";
	}

	// users
	$users["main"] = $creds['rw'];
	$users["guest"] = $creds['r'];
	$users["admin"] = $creds['full'];

	$user = $users[$remote_user]['db_user'];
	$pass = $users[$remote_user]['db_pass'];

	$db = new mysqli($host, $user, $pass, $dbse);
	if($db->connect_errno)
		echo "Failed to connect to MySQL: " . $db->connect_error;
	return $db;
}
?>
