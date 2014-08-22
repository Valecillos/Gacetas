<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="estilo.css" />
<title>Comentarios</title>
	<script type="text/javascript">
	// JQUERY: Plugin "autoSumbit"
	(function($) {
		$.fn.autoSubmit = function(options) {
			return $.each(this, function() {
				// VARIABLES: Input-specific
				var input = $(this);
				var column = input.attr('name');
	
				// VARIABLES: Form-specific
				var form = input.parents('form');
				var method = form.attr('method');
				var action = form.attr('action');

				// VARIABLES: Where to update in database
				var where_val = form.find('#where').val();
				var where_col = form.find('#where').attr('name');
	
				// ONBLUR: Dynamic value send through Ajax
				input.bind('blur', function(event) {
					// Get latest value
					var value = input.val();
					// AJAX: Send values
					$.ajax({
						url: action,
						type: method,
						data: {
							val: value,
							col: column,
							w_col: where_col,
							w_val: where_val
						},
						cache: false,
						timeout: 10000,
						success: function(data) {
							// Alert if update failed
							if (data) {
								alert(data);
							}
							// Load output into a P
							else {
								$('#notice').text('Actualizado');
								$('#notice').fadeOut().fadeIn();
							}
						}
					});
					// Prevent normal submission of form
					return false;
				})
			});
		}
	})(jQuery);
	// JQUERY: Run .autoSubmit() on all INPUT fields within form
	$(function(){
		$('#ajax-form INPUT').autoSubmit();
	});
	</script>
</head>
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

$url_hipo = $_GET['hipo'];
$url_fecha = $_GET['fecha'];

//echo "url: ".$url_hipo. " ".$url_fecha;

$car=mysql_query("SELECT nroCarrera, fecha FROM data WHERE Hipodromo = '$url_hipo' AND fecha = '$url_fecha' GROUP BY nroCarrera ORDER BY nroCarrera ASC, nroEjemplar ASC")or die(mysql_error()); 
	while($row = mysql_fetch_array($car)){
		$nroCarrera = $row['nroCarrera'];

		?>
		<table width="465" class="principal" align="center">
		<tr><td>
		
		<table width="465" border="0">
		  <tr>
			<td width="465"><span class="fecha"><? echo $row['fecha']; ?></span><br />
			<span class="numcar">Carrera Nº<? echo $nroCarrera; ?></span></td>
		  </tr>
		</table>

		<table width="465" class="anteriores">
			<tr>
				<th width="15">Nº</th>
				<th width="150">Ejemplar</th>
				<th width="300">Comentario</th>
			</tr>
			<?
			
		$datos=mysql_query("SELECT nroEjemplar, ejemplar, id, comentario FROM data WHERE nroCarrera=".$nroCarrera." AND Hipodromo = '$url_hipo' AND fecha = '$url_fecha'")or die(mysql_error()); 
		while($row2 = mysql_fetch_array($datos)){
				
			?>
			  <tr class="ant">
				<td class="ant" align="center" ><span class="numcar"><? echo $row2['nroEjemplar']; ?></span></td>
				<td class="ant"><span class="numcar"><? echo $row2['ejemplar']; ?></span></td>
				<td class="ant" align="left">
				<form id="ajax-form" class="autosubmit" method="POST" action="guardar.php">
				<input name="comentario" type="text" id="comentario" value="<? echo $row2['comentario']; ?>" size="50">
				<input name="id" type="hidden" id="where" value="<? echo $row2['id']; ?>">
				</form>
				</td>
			<?
		}
		?>
		  </tr>
			</table>
		</td></tr>
		</table>
		<?
	}
?>
<p id="notice" style="color: #00CC33"></p>
</html>
