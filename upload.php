<?php
/**
   * @package contar_palabras
   * @version   1.0
   * @author    Pabloguti
   * @copyright (C) 2013 Pabloguti
   *
   * @license        Apache License Version 2.0, see LICENSE.md
   * 8/JAN/2012
   *
 */
$status = "";
if ($_POST["action"] == "check") {
  // obtenemos los datos del archivo
	$tamano = $_FILES["archivo"]['size'];
	$tipo = $_FILES["archivo"]['type'];
	$archivo = $_FILES["archivo"]['name'];
	$destino = "files/" . $archivo;
	if ($archivo != "") {
		// guardamos el archivo a la carpeta files

		if (copy($_FILES['archivo']['tmp_name'], $destino)) {
			$status = 1;
		} else {
			$status = "Error al subir el archivo";
		}
	} else {
		$status = "Error al subir archivo";
	}
	if ($status == 1) {
		$fd = fopen($destino, "r");
		/*Abro el archivo que acabo de subir y almaceno su contenido*/
		$contenido = fread($fd, filesize($destino));
		fclose($fd);
		unlink($destino);
		$order = array("\r\n", "\n", "\r");
		$contenido = str_replace($order, " ", $contenido);
		/*Elimino los intros del final de frase */
		$order_punt = array(",", ".", ":", ";", "(", ")", "?", "¿", "¡", "!",'"');
		$contenido = str_replace($order_punt, "", $contenido);
		/*Elimino los signos de puntuación*/
		$contenido = htmlspecialchars_decode($contenido);
		/*Proceso los caracteres HTML*/
		if(isset($_POST["tildes"]))//Si selecciono que me elimine las tildes
		{
			$vocales_tilde = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú");
			$vocales_sin = array("a","e","i","o","u","A","E","I","O","U");
			$contenido = str_replace($vocales_tilde, $vocales_sin, $contenido);
		}
		if(isset($_POST["distinct"]))//Si selecciono que todas minusculas
		{
			$contenido = strtolower($contenido);
		}
		$array_palabras = explode(" ", $contenido);
		/*Separo las palabras por los espacios*/
		$excluidas = explode(",", $_POST["excluidas"]);
		//Meto en un array las palabras excluidas
		
		foreach ($array_palabras as $palabra)/*Recorro todo el array*/
		{
			if (!in_array($palabra, $excluidas)) {//Si la palabra no es de las excluidas
				if (isset($array_final[$palabra])) {//Compruebo si existe ya la palabra
					$array_final[$palabra] = $array_final[$palabra] + 1;
				} else {
					$array_final[$palabra] = 1;
				}
			}
		}
		arsort($array_final);
		//Ordeno los valores
		$i = 0;
		foreach ($array_final as $palabra => $veces) {//Recorro el array
			if ($i < $_POST["show_max"]) {
				echo ($i+1).": La palabra \"" .$palabra . "\" aparece " . $veces . " veces<br/>";
				$i++;
			} else {
				break;
				//Salgo del bucle
			}
		}
		echo "<br/>Se mostraron ".$i." palabras de ".sizeof($array_final) ."<br/>";
	}
	echo "<a href=\"index.php\"> Volver</a>";
}
?>
