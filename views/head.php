<?
// path to config file
$config = $_SERVER['DOCUMENT_ROOT']."/open-records-generator/config/config.php";
require_once($config);

// specific to this 'app'
$config_dir = $root."/config/";

$db = db_connect("guest");

$oo = new Objects();
$mm = new Media();
$ww = new Wires();
$uu = new URL();
$rr = new Request();

// self
if($uu->id)
    $item = $oo->get($uu->id);
else
    $item = $oo->get(0);
$name = ltrim(strip_tags($item["name1"]), ".");

// document title
$item = $oo->get($uu->id);
$title = $item["name1"];
$site_name = "Trigger";
if ($title)
    $title = $site_name." | ".strip_tags($title);
else
    $title = $site_name;
?><!DOCTYPE html>
<html>
<head>
	<title><? echo $site_name ;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Sets whether a web application runs in full-screen mode. -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="trigger">
    <!-- Sets the style of the status bar for a web application. -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="/style/exe.css">
    <script type = "text/javascript" src = "/scripts/var.js"></script>

</head>
<body>
