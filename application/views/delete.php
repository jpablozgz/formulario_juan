<!DOCTYPE html>
<html lang="en">
<head>
<title>Confirm delete</title>
<meta name="robots" content="noarchive,noodp,noydir">
<meta name="description" content="Formulario web">
<meta name="keywords" content="Formulario,Web,PHP">
<meta charset="UTF-8" />
</head>
<body>
<p>Delete user?</p>
<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?=$_GET['id']?>"/>
<input type="submit" name="submit" value="si"/>
<input type="submit" name="submit" value="no"/>
</form>
</body>
</html>
