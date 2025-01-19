<?php
session_start();
require_once("engine/config/database.php");
require_once("engine/classes/loader.php"); 

if($_SERVER['REQUEST_URI'] == '/')
{
	$class = "index";
	$url = "profile";
}
else if(substr($_SERVER['REQUEST_URI'], 1,8) == 'profile/') // Пользовательский Раздел
{
	$url = "profile";

	$params = explode("/", substr($_SERVER['REQUEST_URI'], 9));
	if($params[0] == "") $class = "index";
	else if($params[0] == "exit") { session_destroy();exit("<meta http-equiv='refresh' content='0; url= /'>"); }
	else $class = $params[0];
}
else if(substr($_SERVER['REQUEST_URI'], 1,7) == 'donate/') 
{
	$url = "donate";

	$params = explode("/", substr($_SERVER['REQUEST_URI'], 8));
	if($params[0] == "") $class = "index";
	else $class = $params[0];

}

if(file_exists("engine/classes/".$url."/".$class.".php")) {
	include("engine/classes/".$url."/".$class.".php");
	if(class_exists($class)) {
		$obj = new $class;
		$obj->get_body();
	}
	else {
		exit("<meta http-equiv='refresh' content='0; url= /error/404.php'>");
	}
}
else {
	exit("<meta http-equiv='refresh' content='0; url= /error/404.php'>");
}