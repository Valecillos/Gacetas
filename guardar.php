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

/*
$comentario = $_POST['comentario'];
$id = $_POST['id'];

mysql_query("UPDATE data SET comentario = '$comentario' WHERE id = '$id';)")or die(mysql_error());
*/

// DATABASE: Clean data before use
function clean($value){
	return mysql_real_escape_string($value);
}

/*
 * FORM PARSING
 */

// FORM: Variables were posted
if (count($_POST)){
	// Prepare form variables for database
	foreach($_POST as $column => $value)
		${$column} = clean($value);

	// Perform MySQL UPDATE
	$result = mysql_query("UPDATE data SET ".$col."='".$val."'
		WHERE ".$w_col."='".$w_val."'")
		or die ('Unable to update row.');
}

?>