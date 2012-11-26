<!DOCTYPE html>
<html lang="en">
<head>
<title>Formulario usuarios</title>
<meta name="robots" content="noarchive,noodp,noydir">
<meta name="description" content="Formulario web">
<meta name="keywords" content="Formulario,Web,PHP">
<meta charset="UTF-8" />
</head>
<body>
<form action="?action=insert" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="1"/>
<ul>
<li>Name: <input type="text" name="name" value="<?=isset($arrayUser)?$arrayUser[1]:''?>"/></li>
<li>E-mail: <input type="text" name="email" value="<?=isset($arrayUser)?$arrayUser[2]:''?>"/></li>
<li>Password: <input type="password" name="pass"/></li>
<li>Description: <textarea rows="4" cols="50" name="desc"><?=isset($arrayUser)?$arrayUser[4]:''?></textarea></li>
<li>Pets: <select multiple name="pet[]">
		  <option value="dog"<?=(!isset($arrayUser) || strpos($arrayUser[5],'dog')===FALSE)?'':' selected'; ?>>Dog</option>
		  <option value="cat"<?=(!isset($arrayUser) || strpos($arrayUser[5],'cat')===FALSE)?'':' selected'; ?>>Cat</option>
		  <option value="tiger"<?=(!isset($arrayUser) || strpos($arrayUser[5],'tiger')===FALSE)?'':' selected'; ?>>Tiger</option>
	</select></li>
<li>City: <select name="city">
		  <option value="zgz"<?=(isset($arrayUser) && $arrayUser[6]=='zgz')?' selected':''; ?>>Zaragoza</option>
		  <option value="bcn"<?=(isset($arrayUser) && $arrayUser[6]=='bcn')?' selected':''; ?>>Barcelona</option>
		  <option value="mad"<?=(isset($arrayUser) && $arrayUser[6]=='mad')?' selected':''; ?>>Madrid</option>
	</select></li>
<li>Coder: <input type="radio" name="coder" value="java"<?=(isset($arrayUser) && $arrayUser[7]=='java')?' checked':'';?>/>Java &nbsp;
  			<input type="radio" name="coder" value="php"<?=(isset($arrayUser) && $arrayUser[7]=='php')?' checked':'';?>/>PHP</li>
<li>Languages:<br>
  			<input type="checkbox" name="languages[]" value="en"<?=(!isset($arrayUser) || strpos($arrayUser[8],'en')===FALSE)?'':' checked'; ?>/>English<br>
  			<input type="checkbox" name="languages[]" value="es"<?=(!isset($arrayUser) || strpos($arrayUser[8],'es')===FALSE)?'':' checked'; ?>/>Spanish<br>
			<input type="checkbox" name="languages[]" value="cat"<?=(!isset($arrayUser) || strpos($arrayUser[8],'cat')===FALSE)?'':' checked'; ?>/>Catala<br>
			<input type="checkbox" name="languages[]" value="gal"<?=(!isset($arrayUser) || strpos($arrayUser[8],'gal')===FALSE)?'':' checked'; ?>/>Gallego<br>
			<input type="checkbox" name="languages[]" value="eus"<?=(!isset($arrayUser) || strpos($arrayUser[8],'eus')===FALSE)?'':' checked'; ?>/>Euskera</li>
<li>Photo: <input type="file" name="photo"/>
  		 <?php if(isset($arrayUser[10])):?>
  		 	<img src="uploads/<?=$arrayUser[10];?>" style="width:150px;"/>
  		 <?php endif;?></li>
</ul>
  <input type="submit" value="submit"/>
  <input type="reset" value="reset"/>
</form>
</body>
</html>
