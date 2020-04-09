<?php

$request = $_SERVER['REQUEST_URI'];
$requestclean = strtok($request,"?");
$uri = explode('/', $requestclean);
// uri: trigger.com/ -> ["",""]

require_once("views/head.php");
require_once("views/nav.php");
// var_dump($uri[1]);
// die();
if(!$uri[1] || (count($uri) == 3 && $uri[2] == "upcoming") || (count($uri) == 3 && $uri[2] == "archive") || (count($uri) == 2 && $uri[1] == "events"))
    require_once('controller/home_controller.php');
elseif(count($uri) == 4 && $uri[2] == "upcoming")
    require_once('controller/upcoming_controller.php');
elseif(count($uri) == 4 && $uri[2] == "archive")
    require_once('controller/archive_controller.php');
elseif($uri[1] == "resource")
	require_once('controller/resource_controller.php');
elseif($uri[1] == "about")
	require_once('controller/about_controller.php');
// else if(count($uri) == 3 && $uri[2] == "upcoming")
//     require_once('views/upcoming_list.php');
// else if(count($uri) == 3 && $uri[2] == "archive")
//     require_once('views/archive_list.php');
require_once("views/foot.php");

?>