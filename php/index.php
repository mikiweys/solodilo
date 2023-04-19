<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Galer&iacute;a de im&aacute;genes con zoom lightbox jquery</title>
<link rel="stylesheet" type="text/css" href="lightbox/css/jquery.lightbox-0.5.css"/>
<link rel="stylesheet" type="text/css" href="demo.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="script.js"></script>

</head>

<body>

<div class= "container-fluid text-white">

<header> 
<nav class="bg-dark">
  <div class="container-fluid text-center p-3 text-light">
    <span class="">
      <h1>Fotitos tuyas</h1>
    </span>
  </div>
</nav>
</header>
<h1>Fotitos tuyas</h1>
</div>

<?php
$directory = 'images';

//Si se quiere subir un archivo
if (isset($_POST['nuevaimagen'])) {
	$correcto = true;
	$archivo = $_FILES['archivo']['name'];
	if (isset($archivo)) {
		if ($archivo != "") {
			$tipo = $_FILES['archivo']['type'];
			$tamano = $_FILES['archivo']['size'];
			$temp = $_FILES['archivo']['tmp_name'];
			//Se comprueba si el archivo a cargar es correcto
			if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 2000000))) {
				echo '<div class="error"><b>Error. La extensi�n o el tama�o de los archivos no es correcta.<br/>
				- Se permiten archivos .gif, .jpg, .png. y de 200 kb como m�ximo.</b></div>';
				$correcto = false;
			}
			else {
				//Se comprueba si se guarda correctamente
				if (move_uploaded_file($temp, $directory.'/'.$archivo)) {
					chmod($directory.'/'.$archivo, 0777);
				}
				else {
					echo '<div class="error"><b>Ocurri� alg�n error al subir el fichero. No pudo guardarse.</b></div>';
					$correcto = false;
				}
			}
		}
	}
	if ($correcto)
		echo '<div class="correcto"><b>La imagen se ha subido correctamente.</b></div>';
	echo '<br>';
}

?>

<div id="gallery">
<div >
<?php

$allowed_types=array('jpg','jpeg','gif','png');
$file_parts=array();
$ext='';
$title='';
$i=0;

$dir_handle = @opendir($directory) or die("Hay un error con el directorio de im�genes!");

while ($file = readdir($dir_handle))
{
	if($file=='.' || $file == '..') continue;

	$file_parts = explode('.',$file);
	$ext = strtolower(array_pop($file_parts));

	$title = implode('.',$file_parts);
	$title = htmlspecialchars($title);

	$nomargin='';

	if(in_array($ext,$allowed_types))
	{
		if(($i+1)%3==0) $nomargin='nomargin';

		echo '
		<div class="pic '.$nomargin.'" style="background:url('.$directory.'/'.$file.') no-repeat 50% 50%;">
		<a href="'.$directory.'/'.$file.'" title="'.$title.'" target="_blank">'.$title.'</a>
		</div>';

		$i++;
	}
}

closedir($dir_handle);

?>
</div>
<div class="clear"></div>
</div>

<div id="footer">
	<form action="index.php" method="POST" enctype="multipart/form-data">
		<input class="" type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
		<p1 class="text-light"> Subir una nueva imagen a la galeria </p1> <input name="archivo" id="archivo" type="file" class="text btn btn-danger"/>
		<input type="submit" name="nuevaimagen" value="Subir"/>
	</form>
</div>

</div>

</body>
</html>