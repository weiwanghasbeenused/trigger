<?php

$request = $_SERVER['REQUEST_URI'];
$requestclean = strtok($request,"?");
$uri = explode('/', $requestclean);

require_once("static/php/function.php");
if($uri[1] == "admin-manual")
	require_once('views/admin-manual.php');
elseif($uri[1] == 'events-manager')
{
	require_once("views/events-manager/head.php");
	if(count($uri) < 4)
		require_once('views/events-manager/browse.php');
	elseif(end($uri) == 'add')
		require_once('views/events-manager/add.php');
	elseif(end($uri) == 'edit')
		require_once('views/events-manager/edit.php');
}
else{

	require_once("views/head.php");
	
	require_once("views/nav.php");

	if(!$uri[1])
	    require_once('views/home.php');
	elseif( ($uri[1] == "upcoming" || $uri[1] == "archive") && count($uri) < 3)
	    require_once('views/listing.php');
	elseif( ($uri[1] == "upcoming" || $uri[1] == "archive") && count($uri) >= 3)
	    require_once('views/detail.php');
	elseif($uri[1] == "about")
		require_once('views/columns.php');
	elseif($uri[1] == "artist-index")
		require_once('views/artist-index.php');
	else
		require_once('views/404.php');

	require_once("views/foot.php");
}

?>