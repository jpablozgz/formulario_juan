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

/** Update photo in uploads
 * @param array $_FILE Array FILES
 * @param string $uploadDirectory Upload Directory
 * @param int User id
 * @param string $fileName Users filename
 * @return string $image final name
 */
function updateImage($_FILE,$uploadDirectory,$id,$filename)
{
	$arrayUser=readUser($id,$filename);
	$image=$arrayUser[10];
	if(isset($_FILES['photo']['name']))
	{
		//	borrar imagen
		unlink($uploadDirectory."/".$image);
		//	subir imagen nueva
		$image=str_replace("\r", "", $image);
		$image=str_replace("\n", "", $image);
		$image=uploadImage($_FILES);
	}
	return $image;
}

/** Write users to .txt file
 * @param array $arrayUser User array
 * @param string $imageName final image name
 * @param string $fileName Users filename
 */
function writeToFile($arrayUser,$imageName,$filename)
{
	foreach($arrayUser as $key => $value)
	{
		if(is_array($value))
			$value=implode(',',$value);
		
		$arrayUser[$key]=$value;
		
		// Problema: En el campo Description puedo meter retornos de carro.
		// La forma de solucionarlo es utilizar nl2br() para que meta el tag <br> antes de los \n o \r
	}
	$arrayUser[]=$imageName;
	$textUser=implode('|',$arrayUser);
	
	appendUserToFile($textUser, $filename);
}

/** Update user in .txt file
 * @param string $imageName final image name
 * @param string $fileName Users filename
 * @param int $id User id
 */
function updateToFile($imageName,$filename,$id)
{
	// Leer los datos del archivo
	$arrayUsers=readUsersFromFile($filename);
		
	foreach($_POST as $value)
	{
		if(is_array($value))
			$value=implode(',',$value);
		
		$arrayUser[]=$value;
		
		// Problema: En el campo Description puedo meter retornos de carro.
		// La forma de solucionarlo es utilizar nl2br() para que meta el tag <br> antes de los \n o \r
	}
	$arrayUser[]=$imageName;
	$textUser=implode('|',$arrayUser);
	
	$arrayUsers[$id]=$textUser;
	writeUsersToFile($arrayUsers, $filename);
}

/** Read users from file
 * @param string $filename Users filename
 * @return array: Users array
 */
function readUsersFromFile($filename)
{
	// Remove all newline chars ('\n') preceded by a <br /> tag
	$sustituye = array("<br />\n\r", "<br />\r\n", "br />\n");
	$usersText = str_replace($sustituye,"<br />\r",file_get_contents($filename));

	// Remove BOM if exists
	$bom = pack("CCC", 0xef, 0xbb, 0xbf);
	if (0 == strncmp($usersText, $bom, 3))
		$usersText = substr($usersText, 3);
		
	// Segregate users delimited by the newline character ('\')
	$arrayUsers=explode("\n",$usersText);
	
	// Restore all newline chars previously removed and remove the <br /> tags
	foreach ($arrayUsers as $key => $value)
		$arrayUsers[$key] = str_replace("<br />\r","\r\n",$value);
	while(count($arrayUsers)!=0 && str_replace("\r","",end($arrayUsers))=='')
		array_pop($arrayUsers);
			
	return $arrayUsers;
}

/** Append user to file
 * @param string $textUser User text
 * @param string $filename Users filename
 */
function appendUserToFile($textUser, $filename)
{
	$textUser=nl2br($textUser);
	
	file_put_contents($filename,$textUser."\r\n",FILE_APPEND);
}

/** Write users to file
 * @param array $arrayUsers Users array
 * @param string $filename Users filename
 */
function writeUsersToFile($arrayUsers, $filename)
{
	// Precede line feeds with the <br /> tag
	foreach ($arrayUsers as $key => $value)
		$arrayUsers[$key] = nl2br($value);
	// Users segregated by the newline character ('\')
	$textUsers=implode("\r\n",$arrayUsers);
	// Write to file
	file_put_contents($filename,$textUsers."\r\n");
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

/**
 * Initialize user array with keys
 * @return array: User array initialized
 */
function initKeyedArrayUser()
{
	$keys=array('id','name','email','pass','desc','pet','city','coder','languages');
	$arrayUser=array();
	foreach($keys as $key)
		$arrayUser[$key]=NULL;
	return $arrayUser;
}

/**
 * Initialize user array
 * @return array: User array initialized
 */
function initArrayUser()
{
	$arrayUser=array();
	for($i=0;$i<10;$i++)
		$arrayUser[$i]=NULL;
	return $arrayUser;
}

/**
 * Delete user from file and image from directory
 * @param int $id User id
 * @param string $filename Users filename
 */
function deleteUser($uploadDirectory,$id,$filename)
{
	$arrayUser = readUser($id,$filename);
	
	// Delete user photo
	$image = $arrayUser[10];
	$image=str_replace("\r", "", $image);
	$image=str_replace("\n", "", $image);
	unlink($uploadDirectory."/".$image);

	// Deletes the user from the users array
	$arrayUsers=readUsersFromFile($filename);
	unset($arrayUsers[$id]);
	
	// Rewrites the .txt file
	writeUsersToFile($arrayUsers, $filename);
}
?>
