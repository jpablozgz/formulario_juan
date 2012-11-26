<?php

/** Upload photo in uploads
 * @param array $_FILE Array FILES
 * @param string $uploadDirectory Upload Directory
 * @return string $image final name
 */
function uploadImage($_FILE,$uploadDirectory)
{
	$destination = $uploadDirectory."/".$_FILE['photo']['name'];
	$filename = $_FILE['photo']['tmp_name'];
	
	$path_parts = pathinfo($destination);
	$name=$path_parts['basename'];
	
	$i=0;
	while(in_array($name,scandir($uploadDirectory)))
	{
		$i++;	
		$name=$path_parts['filename']."_".$i.".".$path_parts['extension'];
	}
	
	$destination = $uploadDirectory."/".$name;
	move_uploaded_file($filename, $destination);
	return $name;
}

/** Write users to .txt file
 * @param string $imageName final image name
 * @param string $fileName Users filename
 */
function writeToFile($imageName,$filename)
{
	foreach($_POST as $value)
	{
		if(is_array($value))
			$value=implode(',',$value);
		
		$arrayUser[]=$value;
		
		// Problema: En el campo Description puedo meter retornos de carro.
		// La forma de solucionarlo es utilizar nl2br() para que meta el tag <br> antes de los \n o \r
	}
	$arrayUser[]=$imageName;
	$textUser=nl2br(implode('|',$arrayUser));
	
	file_put_contents("users.txt",$textUser."\r\n",FILE_APPEND);
}

/** Read users from file
 * @param string $filename Users filename
 * @return array: Users array
 */
function readUsersFromFile($filename)
{
	// Remove all newline chars ('\n') preceded by a <br /> tag
	$usersText = str_replace("<br />\n\r","<br />\r",file_get_contents($filename));
	$usersText = str_replace("<br />\r\n","<br />\r",$usersText);
	$usersText = str_replace("<br />\n","<br />\r",$usersText);
	// Users segregated by the newline character ('\')
	$arrayUsers=explode("\n",$usersText);
	// Restore all newline chars previously removed and remove the <br /> tags
	foreach ($arrayUsers as $key => $value)
		$arrayUsers[$key] = str_replace("<br />\r","\r\n",$value);
	
	return $arrayUsers;
}

/**
 * Read user from file to array
 * @param int $id Usr id
 * @param string $filename Users filename
 * @return string: 
 */
function readUser($id,$filename)
{
	// Leer los usuarios
	$arrayUsers=readUsersFromFile($filename);
	// Mostrar los datos del usuario ID
	$arrayUser=$arrayUsers[$_GET['id']];
	$arrayUser=explode("|",$arrayUser);
	return($arrayUser);

}
?>
