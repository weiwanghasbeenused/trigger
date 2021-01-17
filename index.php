<?php

$request = $_SERVER['REQUEST_URI'];
$requestclean = strtok($request,"?");
$uri = explode('/', $requestclean);

if($uri[1] == "admin-manual")
	require_once('views/admin-manual.php');
else{

	require_once("controller/head_controller.php");
	require_once("php/function.php");
	require_once("views/nav.php");

	if(!$uri[1])
	    require_once('views/home.php');
	elseif( ($uri[1] == "upcoming" || $uri[1] == "archive") && count($uri) < 3)
	    require_once('views/listing.php');
	elseif(count($uri) == 4 && $uri[2] == "archive")
	    require_once('controller/archive_controller.php');
	elseif($uri[1] == "resource")
		require_once('controller/resource_controller.php');
	elseif($uri[1] == "about")
		require_once('controller/about_controller.php');
	elseif($uri[1] == "artist-index")
		require_once('controller/artist-index_controller.php');
	else
		require_once('views/404.php');

	require_once("views/foot.php");
}

?>