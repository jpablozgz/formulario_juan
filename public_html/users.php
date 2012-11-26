<?php

require_once("../application/models/applicationModel.php");
require_once("../application/models/usersModel.php");

$config=readConfig('../application/configs/config.ini', 'production');

if(isset($_GET['action']))
	$action=$_GET['action'];
else 
	$action='select';

switch($action)
{
	case 'update':
		if($_POST)
		{
			$imageName=uploadImage($_FILES,$config['uploadDirectory']);
			//TODO: Update file 
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
			writeToFile($imageName,$config['filename']);
			header("Location: users.php?action=select");
			exit();
		}
		else
			include("../application/views/formulario.php");
		break;
	case 'delete':
		break;
	case 'select':
		$arrayUsers=readUsersFromFile($config['filename']);
		include("../application/views/select.php");
	default:
		break;
}
?>