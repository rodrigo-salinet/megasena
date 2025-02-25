<html>
<head>
<title>Resultados MegaSena</title>
<style type="TEXT/CSS">
table {
	border-collapse: collapse;
}
td {
	border-color: #000000;
	border-style: solid;
	border-width: 1px;	
}
</style>
</head>
<body>
<?
$host = 'localhost';
$db = 'megasena';
$usuario = 'root';
$senha = '123456';

$conexao = mysql_connect($host,$usuario,$senha);

@mysql_select_db($db,$conexao);

$sql_resultados = "SELECT * FROM RESULTADOS ORDER BY ID";
$tbl_resultados = mysql_query($sql_resultados,$conexao);

$dezena1_mais_repetida = 0;
$dezena1_max = 0;

$dezena2_mais_repetida = 0;
$dezena2_max = 0;

$dezena3_mais_repetida = 0;
$dezena3_max = 0;

$dezena4_mais_repetida = 0;
$dezena4_max = 0;

$dezena5_mais_repetida = 0;
$dezena5_max = 0;

$dezena6_mais_repetida = 0;
$dezena6_max = 0;

for ($n = 0; $n < mysql_num_rows($tbl_resultados); $n++) {
	$data_dezenas[$n] = mysql_result($tbl_resultados,$n,'DATA');
?>
		<input type="HIDDEN" name="hdn_data<?=$n;?>" id="hdn_data<?=$n;?>" value="<?=mysql_result($tbl_resultados,$n,'DATA');?>"></input>
<?
	$num_dezena1[$n] = mysql_result($tbl_resultados,$n,'DEZENA1');
	$sql_dezena1 = "SELECT DEZENA1 FROM RESULTADOS WHERE DEZENA1=" . $num_dezena1[$n];
	$tbl_dezena1 = mysql_query($sql_dezena1,$conexao);
	$total_dezena1[$n] = mysql_num_rows($tbl_dezena1);
	@mysql_free_result($tbl_dezena1);
	if ($n == 0) {
		$dezena1_mais_repetida = $num_dezena1[$n];
		$dezena1_max = $total_dezena1[$n];
	}
	if ($n > 0) {
		if ($total_dezena1[$n] > $dezena1_max) {
			$dezena1_mais_repetida = $num_dezena1[$n];
			$dezena1_max = $total_dezena1[$n];
		}
	}
?>
		<input type="HIDDEN" name="hdn_dezena1_<?=$n;?>" id="hdn_dezena1_<?=$n;?>" value="<?=$num_dezena1[$n];?>"></input>
<?
	$num_dezena2[$n] = mysql_result($tbl_resultados,$n,'DEZENA2');
	$sql_dezena2 = "SELECT DEZENA2 FROM RESULTADOS WHERE DEZENA2=" . $num_dezena2[$n];
	$tbl_dezena2 = mysql_query($sql_dezena2,$conexao);
	$total_dezena2[$n] = mysql_num_rows($tbl_dezena2);
	@mysql_free_result($tbl_dezena2);
	if ($n == 0) {
		$dezena2_mais_repetida = $num_dezena2[$n];
		$dezena2_max = $total_dezena2[$n];
	}
	if ($n > 0) {
		if ($total_dezena2[$n] > $dezena2_max) {
			$dezena2_mais_repetida = $num_dezena2[$n];
			$dezena2_max = $total_dezena2[$n];
		}
	}
?>
		<input type="HIDDEN" name="hdn_dezena2_<?=$n;?>" id="hdn_dezena2_<?=$n;?>" value="<?=$num_dezena2[$n];?>"></input>
<?
	$num_dezena3[$n] = mysql_result($tbl_resultados,$n,'DEZENA3');
	$sql_dezena3 = "SELECT DEZENA3 FROM RESULTADOS WHERE DEZENA3=" . $num_dezena3[$n];
	$tbl_dezena3 = mysql_query($sql_dezena3,$conexao);
	$total_dezena3[$n] = mysql_num_rows($tbl_dezena3);
	@mysql_free_result($tbl_dezena3);
	if ($n == 0) {
		$dezena3_mais_repetida = $num_dezena3[$n];
		$dezena3_max = $total_dezena3[$n];
	}
	if ($n > 0) {
		if ($total_dezena3[$n] > $dezena3_max) {
			$dezena3_mais_repetida = $num_dezena3[$n];
			$dezena3_max = $total_dezena3[$n];
		}
	}
?>
		<input type="HIDDEN" name="hdn_dezena3_<?=$n;?>" id="hdn_dezena3_<?=$n;?>" value="<?=$num_dezena3[$n];?>"></input>
<?
	$num_dezena4[$n] = mysql_result($tbl_resultados,$n,'DEZENA4');
	$sql_dezena4 = "SELECT DEZENA4 FROM RESULTADOS WHERE DEZENA4=" . $num_dezena4[$n];
	$tbl_dezena4 = mysql_query($sql_dezena4,$conexao);
	$total_dezena4[$n] = mysql_num_rows($tbl_dezena4);
	@mysql_free_result($tbl_dezena4);
	if ($n == 0) {
		$dezena4_mais_repetida = $num_dezena4[$n];
		$dezena4_max = $total_dezena4[$n];
	}
	if ($n > 0) {
		if ($total_dezena4[$n] > $dezena4_max) {
			$dezena4_mais_repetida = $num_dezena4[$n];
			$dezena4_max = $total_dezena4[$n];
		}
	}
?>
		<input type="HIDDEN" name="hdn_dezena4_<?=$n;?>" id="hdn_dezena4_<?=$n;?>" value="<?=$num_dezena4[$n];?>"></input>
<?
	$num_dezena5[$n] = mysql_result($tbl_resultados,$n,'DEZENA5');
	$sql_dezena5 = "SELECT DEZENA5 FROM RESULTADOS WHERE DEZENA5=" . $num_dezena5[$n];
	$tbl_dezena5 = mysql_query($sql_dezena5,$conexao);
	$total_dezena5[$n] = mysql_num_rows($tbl_dezena5);
	@mysql_free_result($tbl_dezena5);
	if ($n == 0) {
		$dezena5_mais_repetida = $num_dezena5[$n];
		$dezena5_max = $total_dezena5[$n];
	}
	if ($n > 0) {
		if ($total_dezena5[$n] > $dezena5_max) {
			$dezena5_mais_repetida = $num_dezena5[$n];
			$dezena5_max = $total_dezena5[$n];
		}
	}
?>
		<input type="HIDDEN" name="hdn_dezena5_<?=$n;?>" id="hdn_dezena5_<?=$n;?>" value="<?=$num_dezena5[$n];?>"></input>
<?
	$num_dezena6[$n] = mysql_result($tbl_resultados,$n,'DEZENA6');
	$sql_dezena6 = "SELECT DEZENA6 FROM RESULTADOS WHERE DEZENA6=" . $num_dezena6[$n];
	$tbl_dezena6 = mysql_query($sql_dezena6,$conexao);
	$total_dezena6[$n] = mysql_num_rows($tbl_dezena6);
	@mysql_free_result($tbl_dezena6);
	if ($n == 0) {
		$dezena6_mais_repetida = $num_dezena6[$n];
		$dezena6_max = $total_dezena6[$n];
	}
	if ($n > 0) {
		if ($total_dezena6[$n] > $dezena6_max) {
			$dezena6_mais_repetida = $num_dezena6[$n];
			$dezena6_max = $total_dezena6[$n];
		}
	}
?>
		<input type="HIDDEN" name="hdn_dezena6_<?=$n;?>" id="hdn_dezena6_<?=$n;?>" value="<?=$num_dezena6[$n];?>"></input>
		<input type="HIDDEN" name="hdn_acumulada<?=$n;?>" id="hdn_acumulada<?=$n;?>" value="<?=mysql_result($tbl_resultados,$n,'ACUMULADA');?>"></input>
<?
}
@mysql_free_result($tbl_resultados);
?>
</body>
</html>
<?
@mysql_close($conexao);
while(@ob_end_flush());
?>