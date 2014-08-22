<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="estilo.css" />
	<title>Hipodromos</title>
</head>
<br />
<?php
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'gacetas');
 
@$conn = mysql_connect (DB_SERVER, DB_USER, DB_PASSWORD);
mysql_select_db (DB_NAME,$conn);
if(!$conn){
	die( "¡Lo sentimos! Parece que hay un problema al conectar con la base de datos.");
}

$url_fecha = $_GET['fecha'];

$hipo=mysql_query("SELECT COUNT(*), fecha, Hipodromo
				FROM data WHERE fecha ='$url_fecha' GROUP BY Hipodromo")or die(mysql_error()); 
	while($row = mysql_fetch_array($hipo)){
		?>
		<p align='left' class="fecha"><? echo $row["Hipodromo"]; ?> <a href="gaceta.php?hipo=<? echo $row["Hipodromo"]; ?>&fecha=<? echo $url_fecha; ?>" class="fecha">ver</a> <a href="comentarios.php?hipo=<? echo $row["Hipodromo"]; ?>&fecha=<? echo $url_fecha; ?>" class="fecha">comentarios</a></p>
	<?
	}
	if (mysql_num_rows($hipo)==0) {
		?>
		<br />
		<p align='center' class="fecha">No se encuentraron registros para este día (<? echo $url_fecha; ?>)<br /><br />
		<a href ="fechas.php" class="fecha">Volver</a></p>
		<?
	}
	mysql_free_result($hipo);

?>
</html>