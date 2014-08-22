<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="estilo.css" />
	<title>Gaceta</title>
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

// funcion para 1/2 1/4 3/4
function cuerpos ($numero){
	$dec = ltrim(($numero - floor($numero)),"0.");
	$ent = floor($numero);
	
	if ($dec == 25){
		$dec = "&frac14;";
	}elseif	($dec == 5){
		$dec = "&frac12;";
	}elseif ($dec == 75) {
		$dec = "&frac34;";
	}else{
		$dec = "";
	}
	
	if ($ent == 0){
		$ent = "";
	}
	return $ent.$dec;
}

// funcion para iniciales en el jinete
function iniciales ($jin){
	$picar = array_filter(explode(" ", $jin));
	$cuantos = count($picar);
	
	switch ($cuantos) {
    case 0:
        $ini0 = "";
		$ini1 = "";
		$ini2 = "";
        break;
    case 1:
        $ini0 = "";
		$ini1 = substr($picar[1],0,1);
		$ini2 = "";
        break;
    case 2:
        $ini0 = $picar[0];
		$ini1 = substr($picar[1],0,1);
		$ini2 = "";
        break;
	 case 3:
        $ini0 = $picar[0];
		$ini1 = substr($picar[2],0,1);
		$ini2 = substr($picar[1],0,1);
        break;
	}
	
	return $ini2." ".$ini1." ".$ini0;
}

$car=mysql_query("SELECT * FROM data WHERE Hipodromo = '$url_hipo' AND fecha = '$url_fecha' GROUP BY nroCarrera ORDER BY nroCarrera ASC, nroEjemplar ASC")or die(mysql_error()); 
	while($row = mysql_fetch_array($car)){
		$nroCarrera = $row['nroCarrera'];

		?>
		<table width="655" class="principal" align="center">
		<tr><td>
		
		<table width="655" border="0">
		  <tr>
			<td width="100" align="center"><span class="fecha"><? echo $row['fecha']; ?></span><br />
			<span class="numcar"><? echo $nroCarrera; ?></span></td>
			<td width="290"><div class="hip"><strong class="hip"><? echo $row['Hipodromo']; ?></strong><br />
			<? echo $row['serie']; ?><br />
			<? echo $row['hora']; ?></div>
			<div class="distancia"><? echo $row['distancia']; ?>
			<span>metros</span></div>
			</td>
			<td width="265"><? echo $row['apuesta1']; ?><br />
				<? echo $row['apuesta2']; ?>
			</td> 
		  </tr>
		</table>
		<span class="info"><? echo $row['tipoCarrera']; ?></span>

		<table width="655" class="anteriores">
			<tr>
				<th width="15">Nº</th>
				<th width="220">Propietario, Divisa, Ejemplar, Sexo, Pelaje, Edad, Padres y Origen</th>
				<th width="40">Jinete, Ks, Implementos, Prep.</th>
				<th width="10">PP</th>
				<th width="25">Fecha</th>
				<th width="15">Carr. ant.</th>
				<th width="20">Peso</th>
				<th width="20">Dtcia.</th>
				<th width="10">PP</th>
				<th width="20">1000 300m</th>
				<th width="10">Lleg</th>
				<th width="70">Ks, Jinete, Divid</th>
				<th width="60">Ganador</th>
				<th width="20">Cpos</th>
				<th width="40">Serie</th>
				<th width="10">TTC</th>
				<th width="20">Tmpo Gnador</th>
				<th width="20">Tmpo Ejem</th>
				<th width="10"># Ejs</th>
			</tr>
			<?
			
		$datos=mysql_query("SELECT * FROM data WHERE nroCarrera=".$nroCarrera." AND Hipodromo = '$url_hipo' AND fecha = '$url_fecha'")or die(mysql_error()); 
		while($row2 = mysql_fetch_array($datos)){
			$ejemplar = $row2['ejemplar'];
			$e_fecha_u = explode("-", $row2['e_fec_ult']);
			$e_fec_penul = explode("-", $row2['e_fec_penul']);
			$e_fec_antepenul = explode("-", $row2['e_fec_antepenul']);
			$e_fec_anteante = explode("-", $row2['e_fec_anteante']);
			$e_c_ult = cuerpos($row2['e_cpos_ult']);
			$e_c_penul = cuerpos($row2['e_cpos_penul']);
			$e_c_antepenul = cuerpos($row2['e_cpos_antepenul']);
			$e_c_anteante = cuerpos($row2['e_cpos_anteante']);
			$e_jin_ult = iniciales($row2['e_jin_ult']);
			$e_jin_penul = iniciales($row2['e_jin_penul']);
			$e_jin_antepenul = iniciales($row2['e_jin_antepenul']);
			$e_jin_anteante = iniciales($row2['e_jin_anteante']);
			$jinete = iniciales($row2['jinete']);
			$preparador = iniciales($row2['preparador']);
			
			?>
			  <tr class="ant">
				<td class="ant" ><span class="numcar"><? echo $row2['nroEjemplar']; ?></span></td>
				<td class="ant">Stud: '<? echo $row2['propietario']; ?>' -<? echo $row2['divisa']; ?><br /> 
					<span class="numcar"><? echo $ejemplar; ?></span><br />
					<? echo $row2['sexo']; ?>. <? echo $row2['pelaje']; ?>. <? echo $row2['edad']; ?>a.<br />
					p. <? echo $row2['padres']; ?> - <? echo $row2['origen']; ?></td>
				<td class="ant"><? echo $jinete; ?><br /><br />
					<span class="fecha"><b><? echo $row2['kilos']; ?></b></span><br />
					<? echo $row2['implementos']; ?><br />
					<? echo $preparador; ?><br />
				</td>
				<td class="ant"><? echo $row2['pp']; ?></td>
				
				<td><? echo $e_fec_anteante[2]."-".$e_fec_anteante[1]; ?><br />	
					<? echo $e_fec_antepenul[2]."-".$e_fec_antepenul[1]; ?><br />
					<? echo $e_fec_penul[2]."-".$e_fec_penul[1]; ?><br />
					<? echo $e_fecha_u[2]."-".$e_fecha_u[1]; ?>
				</td>
				<td><? echo $row2['e_hip_anteante']; ?><br />
					<? echo $row2['e_hip_antepenul']; ?><br />
					<? echo $row2['e_hip_penul']; ?><br />
					<? echo $row2['e_hip_ult']; ?>
				</td>
				<td><? echo $row2['e_kilos_anteante']; ?><br />
					<? echo $row2['e_kilos_antepenul']; ?><br />
					<? echo $row2['e_kilos_penul']; ?><br />
					<? echo $row2['e_kilos_ult']; ?>
				</td>
				<td><? echo $row2['e_dist_anteante']; ?><br />
					<? echo $row2['e_dist_antepenul']; ?><br />
					<? echo $row2['e_dist_penul']; ?><br />
					<? echo $row2['e_dist_ult']; ?>				
				</td>
				<td><? echo $row2['e_pp_anteante']; ?><br />
					<? echo $row2['e_pp_antepenul']; ?><br />
					<? echo $row2['e_pp_penul']; ?><br />
					<? echo $row2['e_pp_ult']; ?>
				</td>
				<td><? echo $row2['e_300_anteante']; ?>&nbsp;&nbsp;<? echo $row2['e_1000_anteante']; ?><br />
					<? echo $row2['e_300_antepenul']; ?>&nbsp;&nbsp;<? echo $row2['e_1000_antepenul']; ?><br />
					<? echo $row2['e_300_penul']; ?>&nbsp;&nbsp;<? echo $row2['e_1000_penul']; ?><br />
					<? echo $row2['e_300_ult']; ?>&nbsp;&nbsp;<? echo $row2['e_1000_ult']; ?>	
				</td>
				<td><? echo $row2['e_lleg_anteante']; ?><br />
					<? echo $row2['e_lleg_antepenul']; ?><br />
					<? echo $row2['e_lleg_penul']; ?><br />
					<? echo $row2['e_lleg_ult']; ?>
				</td>
				<td><? echo $e_jin_anteante; ?><br />
					<? echo $e_jin_antepenul; ?><br />
					<? echo $e_jin_penul; ?><br />
					<? echo $e_jin_ult; ?>
				</td>
				<td>
					<? echo $row2['e_gana_anteante']; ?><br />
					<? echo $row2['e_gana_antepenul']; ?><br />
					<? echo $row2['e_gana_penul']; ?><br />
					<? echo $row2['e_gana_ult']; ?>			
				</td>
				<td><? echo $e_c_anteante; ?><br />
					<? echo $e_c_antepenul ?><br />
					<? echo $e_c_penul; ?><br />
					<? echo $e_c_ult; ?>					
				</td>
				<td><? echo $row2['e_serie_anteante']; ?><br />
					<? echo $row2['e_serie_antepenul']; ?><br />
					<? echo $row2['e_serie_penul']; ?><br />
					<? echo $row2['e_serie_ult']; ?>
				</td>
				<td>&nbsp;</td>
				<td><? echo $row2['e_tg_anteante']; ?><br />
					<? echo $row2['e_tg_antepenul']; ?><br />
					<? echo $row2['e_tg_penul']; ?><br />
					<? echo $row2['e_tg_ult']; ?>			
				</td>
				<td>&nbsp;</td>
				<td><? echo $row2['e_ejes_anteante']; ?><br />
					<? echo $row2['e_ejes_antepenul']; ?><br />
					<? echo $row2['e_ejes_penul']; ?><br />
					<? echo $row2['e_ejes_ult']; ?>				
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
</html>