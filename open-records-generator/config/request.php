<?php
// wrapper class for http post variables
// should this be custom per view? perhaps
class Request
{
	public $page = ''; 	// is this variable even used?
		
	// add, edit, delete, link
	public $submit;
	public $action;
	
	// add, edit
	public $name1;
	// public $deck;
	public $main_two;
	public $qanda;
	public $begin;
	public $end;
	public $url;
	public $rank;
	public $cato;
	public $event_date;
	public $event_time;
	public $location;
	public $website = array();
	public $exhibit = array();
	public $reading = array();
	public $main_one;
	// link
	public $wires_toid;
	
	public $m; // media id
	public $medias; // array
	public $types;
	public $captions;
	public $ranks;
	public $deletes;
	
	public $thumbnail;
	public $reading_fromid;
	public $reading_toid;
	public $uploads;
	
	function __construct()
	{
		$this->page = basename($_SERVER['PHP_SELF'], ".php");
		$vars = array("cato", "name1", "event_date", "event_time", "location", "main_one", "website", "exhibit", "reading", "main_two", "url", "rank", "qanda", "begin", "end", 'deletes','captions', 'submit', 'action','wires_toid','uploads','medias', 'types', 'captions', 'ranks', 'thumbnail','reading_fromid','reading_toid');

		foreach($vars as $v)
			$this->$v = $_POST[$v];
	}
}

?>