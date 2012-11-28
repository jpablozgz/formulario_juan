<?php

define ("DOCUMENT_ROOT", $_SERVER['DOCUMENT_ROOT']);

require_once("../application/models/applicationModel.php");
require_once("../application/models/usersModel.php");

$config=readConfig('../application/configs/config.ini', 'production');

// Initializing variables
$arrayUser=initArrayUser();

if(isset($_GET['action']))
	$action=$_GET['action'];
else 
	$action='select';

switch($action)
{
	case 'update':
		if($_POST)
		{
			$imageName=updateImage($_FILES,$config['uploadDirectory'], $_GET['id']);
			updateToFile($imageName,$config['filename'], $_GET['id']);
			header("Location: users.php?action=select");
			exit();
		}
		else
			$arrayUser=readUser($_GET['id'],$config['filename']);
		// CAUTION: There is no break; here!!!!!!!!!!
	case 'insert':
		if($_POST)
		{
			//TODO: Arreglar entrada acentos (charset form UTF-8)
			$imageName=uploadImage($_FILES,$config['uploadDirectory']);
			$arrayUser = array_merge(initKeyedArrayUser(),$_POST);
			writeToFile($arrayUser,$imageName,$config['filename']);
			//writeToFile($_POST,$imageName,$config['filename']);
			header("Location: users.php?action=select");
			exit();
		}
		else
			$content=renderView($config,"formulario",array('arrayUser'=>$arrayUser));
		break;
	case 'delete':
		if($_POST)
		{
			if($_POST['submit']=='yes')
				deleteUser($config['uploadDirectory'],$_GET['id'],$config['filename']);
			header("Location: users.php?action=select");
			exit();
		}
		else
			$content=renderView($config,"delete",array());
		break;
	case 'select':
		$arrayUsers=readUsersFromFile($config['filename']);
			echo "<pre>";
			print_r($arrayUsers);
			echo "</pre>";
			die;
		$content=renderView($config,"select",array('arrayUsers'=>$arrayUsers));
	default:
		break;
}
include("../application/layouts/layout_admin1.php");
?>