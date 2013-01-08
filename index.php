<!DOCTYPE HTML>
<html lang="es-ES">
  <head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Formulario subir archivo</title>
	</head>
	<body>
		<h1>Script para contar palabras de un archivo</h1>
		<form action="upload.php" method="post" enctype="multipart/form-data">
			Número de palabras a mostrar:<input name="show_max" type="number" value="50"><br/>
			Archivo a analizar:<input name="archivo" type="file" size="35" /><br/>
			Palabras excluidas:<br/>
			<textarea name="excluidas" rows="4" cols="50">si,no,que,del,la,las,el,ellos,los,lo,a,ante,bajo,con,contra,de,desde,durante,hacia,hasta,para,por,segun,sin,sobre,tras,entonces</textarea><br/>
			<input type="checkbox" name="distinct" value="1">Elimina mayúsculas/minúsculas<br/>
			<input type="checkbox" name="tildes" value="1">Elimina tildes<br>
			<input name="enviar" type="submit" value="Enviar" />
			<input name="action" type="hidden" value="check" />
		</form>
	</body>
</html>
