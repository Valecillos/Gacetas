<?php
define('DB_SERVER', 'localhost');
define('DB_USER', 'carteluo_gacetas');
define('DB_PASSWORD', 'e}07Fb-)9Cfk');
define('DB_NAME', 'carteluo_gacetas');
 
@$conn = mysql_connect (DB_SERVER, DB_USER, DB_PASSWORD);
mysql_select_db (DB_NAME,$conn);
if(!$conn){
	die( "¡Lo sentimos! Parece que hay un problema al conectar con la base de datos.");
}

function errors($error){
	if (!empty($error)){
		$i = 0;
		while ($i < count($error)){
			$showError.= '<div class="msg-error">'.$error[$i].'</div>';
			$i ++;
		}
		return $showError;
	}// close if empty errors
} // close function

// funcion convertir hora
function vene($hora){
	$hora_original = $hora;
	$huso_original = new DateTimeZone('America/Los_Angeles');
	
	$horas = new DateTime($hora_original, $huso_original);
	$huso_local = new DateTimeZone('America/Caracas');
	$horas->setTimeZone($huso_local);
	
	$hora_nueva24 = $horas->format('H:i');
	
	$hora_nueva12 = date("g:i a", strtotime($hora_nueva24));
	
	return $hora_nueva12;
}
// funcion convertir fecha
function fec($fechaX){
	$dia = substr($fechaX, 6, 2);
	$mes = substr($fechaX, 4, 2);
	$anno = substr($fechaX, 0, 4);

	return $dia."/".$mes."/".$anno;
}

if (isset($_POST['upfile'])){
	if (file_exists($_FILES["uploaded"]["tmp_name"])){
	
	// check fields are not empty

	if (!$error){
		$handle = fopen($_FILES["uploaded"]["tmp_name"], "r");
		//$data = fgetcsv($handle, 1000, ",");
	
		while (($data = fgetcsv($handle, 50000, ",",'"',"¬")) !== FALSE){
			$fecha = fec($data[1]);	
			mysql_query("INSERT INTO uprogramas(programa, fecha) VALUES(
			'".mysql_real_escape_string($data[0])."',
			'$fecha')")or die(mysql_error());
			$ultimoidid=mysql_insert_id();

			//echo $ultimoidid;
			
			$edad = date("y")-$data[45];
			$hora = vene($data[1417]);
			$distancia = round(($data[5]/1.09144)-10, -1);

			$padres = $data[51]. " - ".$data[53];
			$kilos = round($data[50]*0.4535, 1, PHP_ROUND_HALF_UP);
			
			$e_dist_ult = round(($data[315]/1.09144)-10, -1);
			$e_dist_penul = round(($data[316]/1.09144)-10, -1);
			$e_dist_antepenul = round(($data[317]/1.09144)-10, -1);
			$e_dist_anteante = round(($data[318]/1.09144)-10, -1);
			if ($e_dist_ult <= 0){
				$e_dist_ult2 = 0;
			}else{
				$e_dist_ult2 = $e_dist_ult;
			}
			if ($e_dist_penul <= 0){
				$e_dist_penul2 = 0;
			}else{
				$e_dist_penul2 = $e_dist_penul;
			}
			if ($e_dist_antepenul <= 0){
				$e_dist_antepenul2 = 0;
			}else{
				$e_dist_antepenul2 = $e_dist_antepenul;
			}
			if ($e_dist_anteante <= 0){
				$e_dist_anteante2 = 0;
			}else{
				$e_dist_anteante2 = $e_dist_anteante;
			}
				
			$e_kilos_ult = round($data[505]*0.4535, 1, PHP_ROUND_HALF_UP);
			$e_kilos_penul = round($data[506]*0.4535, 1, PHP_ROUND_HALF_UP);
			$e_kilos_antepenul = round($data[507]*0.4535, 1, PHP_ROUND_HALF_UP);
			$e_kilos_anteante = round($data[508]*0.4535, 1, PHP_ROUND_HALF_UP);
			
			$e_div_ult = ($data[515]*2)+2;
			$e_div_penul = ($data[516]*2)+2;
			$e_div_antepenul = ($data[517]*2)+2;
			$e_div_anteante = ($data[518]*2)+2;
			
			for ($c=0; $c < 1; $c++){
				//only run if the first column if not equal to firstname
				//if($data[0] !='firstname'){
				mysql_query("INSERT INTO data(
				idPrograma,
				Hipodromo,
				fecha,
				hora,
				nroCarrera,
				nroEjemplar,
				posicion,
				tipoCarrera,
				serie,
				premio,
				reglas,
				distancia,
				propietario,
				divisa,
				ejemplar,
				sexo,
				pelaje,
				edad,
				padres,
				origen,
				jinete,
				kilos,
				implementos,
				preparador,
				pp,
				e_fec_ult,
				e_fec_penul,
				e_fec_antepenul,
				e_fec_anteante,
				e_hip_ult,
				e_hip_penul,
				e_hip_antepenul,
				e_hip_anteante,
				e_dist_ult,
				e_dist_penul,
				e_dist_antepenul,
				e_dist_anteante,
				e_pp_ult,
				e_pp_penul,
				e_pp_antepenul,
				e_pp_anteante,
				e_300_ult,
				e_300_penul,
				e_300_antepenul,
				e_300_anteante,
				e_1000_ult,
				e_1000_penul,
				e_1000_antepenul,
				e_1000_anteante,
				e_lleg_ult,
				e_lleg_penul,
				e_lleg_antepenul,
				e_lleg_anteante,
				e_kilos_ult,
				e_kilos_penul,
				e_kilos_antepenul,
				e_kilos_anteante,
				e_jin_ult,
				e_jin_penul,
				e_jin_antepenul,
				e_jin_anteante,
				e_div_ult,
				e_div_penul,
				e_div_antepenul,
				e_div_anteante,
				e_gana_ult,
				e_gana_penul,
				e_gana_antepenul,
				e_gana_anteante,
				e_cpos_ult,
				e_cpos_penul,
				e_cpos_antepenul,
				e_cpos_anteante,
				e_serie_ult,
				e_serie_penul,
				e_serie_antepenul,
				e_serie_anteante,
				e_tg_ult,
				e_tg_penul,
				e_tg_antepenul,
				e_tg_anteante,
				e_ejes_ult,
				e_ejes_penul,
				e_ejes_antepenul,
				e_ejes_anteante,
				apuesta1,
				apuesta2
				) VALUES(
				'$ultimoidid',
				'".mysql_real_escape_string($data[0])."',
				'$fecha',
				'$hora',
				'$data[2]',
				'$data[42]',
				'$data[3]',
				'$data[224]',
				'$data[10]',
				'$data[11]',
				'$data[15]',
				'$distancia',
				'".mysql_real_escape_string($data[38])."',
				'".mysql_real_escape_string($data[39])."',
				'".mysql_real_escape_string($data[44])."',
				'$data[48]',
				'$data[49]',
				'$edad',
				'".mysql_real_escape_string($padres)."',
				'$data[56]',
				'$data[32]',
				'$kilos',
				'$data[57]',
				'$data[27]',
				'$data[3]',
				'$data[255]',
				'$data[256]',
				'$data[257]',
				'$data[258]',
				'$data[275]',
				'$data[276]',
				'$data[277]',
				'$data[278]',
				'$e_dist_ult2',
				'$e_dist_penul2',
				'$e_dist_antepenul2',
				'$e_dist_anteante2',
				'$data[355]',
				'$data[356]',
				'$data[357]',
				'$data[358]',
				'$data[565]',
				'$data[566]',
				'$data[567]',
				'$data[568]',
				'$data[575]',
				'$data[576]',
				'$data[577]',
				'$data[578]',
				'$data[615]',
				'$data[616]',
				'$data[617]',
				'$data[618]',
				'$e_kilos_ult',
				'$e_kilos_penul',
				'$e_kilos_antepenul',
				'$e_kilos_anteante',
				'$data[1065]',
				'$data[1066]',
				'$data[1067]',
				'$data[1068]',
				'$e_div_ult',
				'$e_div_penul',
				'$e_div_antepenul',
				'$e_div_anteante',
				'".mysql_real_escape_string($data[405])."',
				'".mysql_real_escape_string($data[406])."',
				'".mysql_real_escape_string($data[407])."',
				'".mysql_real_escape_string($data[408])."',
				'$data[735]',
				'$data[736]',
				'$data[737]',
				'$data[738]',
				'$data[535]',
				'$data[536]',
				'$data[537]',
				'$data[538]',
				'$data[1035]',
				'$data[1036]',
				'$data[1037]',
				'$data[1038]',
				'$data[345]',
				'$data[346]',
				'$data[347]',
				'$data[348]',
				'$data[239]',
				'$data[240]'
				)")or die(mysql_error());
			}
		}
		
		/*
		for ($i=0; $i < 10; $i++){
			$fecha = 255 + $i;
			$carreraAnterior = 295 + $i;
			$pesoEjemplar = 505 + $i;
			$distancia = 315 + $i;
			$pp = 355 + $i;
			$v300100300100 = 355 + $i;
			$posicionLlegada;
			$kgJineteDivisa;
			$nombreEjemplarGanador;
			$cuerpos;
			$serie;
			$ttc;
			$tiempoGanador;
			$tiempoEjemplar;
			$nrParticiantes;

			//only run if the first column if not equal to firstname
			//if($data[0] !='firstname'){
			mysql_query("INSERT INTO anteriores(
			fecha,
			carreraAnterior,
			pesoEjemplar,
			distancia,
			pp,
			300100,
			posicionLlegada,
			kgJineteDivisa,
			nombreEjemplarGanador,
			cuerpos,
			serie,
			ttc,
			tiempoGanador,
			tiempoEjemplar,
			nrParticiantes
			)VALUES(
			'$data[0]',
			'$data[1]',
			'$data[2]',
			'$data[224]',
			'substr($data[224], -11, 4)',
			'$data[11]',
			'$data[16]',
			'round(($data[5]/1.0936))',
			'$data[38]',

			'$data[44]',
			'$data[44]',
			'$data[48]',
			'$data[49]',
			'date("y")-$data[45]'
			")or die(mysql_error());
		}
		*/
	}
	fclose($handle);
	?>
	<div class='success' id='message'>Archivo CSV/DRF importado</div>
	<?
	}else{
	?>
		<div class='success' id='message'>No has seleccionado un archivo CSV/DRF</div>
	<?
	}
}// end no error
//}//close if isset upfile

$er = errors($error);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Importar Archivo CSV/DRF</title>
</head>

<body>
<h3>Importar Archivo CSV/DRF</h3>
<? echo $er; ?>
<form enctype="multipart/form-data" action="" method="post">
	<input name="uploaded" type="file" maxlength="20" accept=".csv, .drf" /><input type="submit" name="upfile" value="Subir">
</form>
</body>
</html>