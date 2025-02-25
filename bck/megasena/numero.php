<?
$num_dezena = trim(@$_GET['num_dezena']);
if ($num_dezena == '' or $num_dezena == NULL) {
	$num_dezena = 1;
}
?>
<html>
<head>
<title>Resultados MegaSena - Numero <?=$num_dezena;?></title>
<style type="TEXT/CSS">
table {
	border-collapse: collapse;
}
td {
	border-color: #000000;
	border-style: solid;
	border-width: 1px;	
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
</style>
</head>
<body onLoad="javascript:window.frm_numero.num_dezena.focus();">
<form method="GET" action="numero.php" id="frm_numero" name="frm_numero">
	<INPUT type="TEXT" id="num_dezena" name="num_dezena"></INPUT>
	<INPUT type="SUBMIT" value="Ver"></INPUT>
</form>
<table>
	<tr>
		<td align="center">Ordem:</td>
		<td align="center">Data:</td>
		<td align="center">Dezena 1:</td>
		<td align="center">Dezena 2:</td>
		<td align="center">Dezena 3:</td>
		<td align="center">Dezena 4:</td>
		<td align="center">Dezena 5:</td>
		<td align="center">Dezena 6:</td>
		<td align="center">Acumulada:</td>
	</tr>
<?
$host = 'localhost';
$db = 'megasena';
$usuario = 'root';
$senha = '123456';

$conexao = mysql_connect($host,$usuario,$senha);

@mysql_select_db($db,$conexao);

$sql_resultados = "SELECT * FROM RESULTADOS WHERE DEZENA1=" . $num_dezena . " OR DEZENA2=" . $num_dezena . " OR DEZENA3=" . $num_dezena . " OR DEZENA4=" . $num_dezena . " OR DEZENA5=" . $num_dezena . " OR DEZENA6=" . $num_dezena . " ORDER BY ID";
$tbl_resultados = mysql_query($sql_resultados,$conexao);

$css = 'STYLE="background-color:#DDDDDD;font-weight:bold;"';
for ($n = 0; $n < @mysql_num_rows($tbl_resultados); $n++) {
?>
	<tr>
		<td align="center"><?=$n+1;?></td>
		<td align="center"><?=mysql_result($tbl_resultados,$n,'DATA');?></td>
<?
	$dezena1 = mysql_result($tbl_resultados,$n,'DEZENA1');
	$estilo = '';
	if ($dezena1 == $num_dezena) {
		$estilo = $css;
	}
?>
		<td align="center" <?=$estilo;?>><?=$dezena1;?></td>
<?
	$dezena2 = mysql_result($tbl_resultados,$n,'DEZENA2');
	$estilo = '';
	if ($dezena2 == $num_dezena) {
		$estilo = $css;
	}
?>
		<td align="center" <?=$estilo;?>><?=$dezena2;?></td>
<?
	$dezena3 = mysql_result($tbl_resultados,$n,'DEZENA3');
	$estilo = '';
	if ($dezena3 == $num_dezena) {
		$estilo = $css;
	}
?>
		<td align="center" <?=$estilo;?>><?=$dezena3;?></td>
<?
	$dezena4 = mysql_result($tbl_resultados,$n,'DEZENA4');
	$estilo = '';
	if ($dezena4 == $num_dezena) {
		$estilo = $css;
	}
?>
		<td align="center" <?=$estilo;?>><?=$dezena4;?></td>
<?
	$dezena5 = mysql_result($tbl_resultados,$n,'DEZENA5');
	$estilo = '';
	if ($dezena5 == $num_dezena) {
		$estilo = $css;
	}
?>
		<td align="center" <?=$estilo;?>><?=$dezena5;?></td>
<?
	$dezena6 = mysql_result($tbl_resultados,$n,'DEZENA6');
	$estilo = '';
	if ($dezena6 == $num_dezena) {
		$estilo = $css;
	}
?>
		<td align="center" <?=$estilo;?>><?=$dezena6;?></td>
		<td align="center"><?=mysql_result($tbl_resultados,$n,'ACUMULADA');?></td>
	</tr>
<?
}
@mysql_free_result($tbl_resultados);
?>
	<tr>
		<td align="center" colspan="2">Total:</td>
<?
$sql_total_dezena1 = "SELECT * FROM RESULTADOS WHERE DEZENA1=" . $num_dezena;
$tbl_total_dezena1 = mysql_query($sql_total_dezena1,$conexao);
?>
		<td align="center" style="font-weight: bold;"><?=@mysql_num_rows($tbl_total_dezena1);?></td>
<?
@mysql_free_result($tbl_total_dezena1);
$sql_total_dezena2 = "SELECT * FROM RESULTADOS WHERE DEZENA2=" . $num_dezena;
$tbl_total_dezena2 = mysql_query($sql_total_dezena2,$conexao);
?>
		<td align="center" style="font-weight: bold;"><?=@mysql_num_rows($tbl_total_dezena2);?></td>
<?
@mysql_free_result($tbl_total_dezena2);
$sql_total_dezena3 = "SELECT * FROM RESULTADOS WHERE DEZENA3=" . $num_dezena;
$tbl_total_dezena3 = mysql_query($sql_total_dezena3,$conexao);
?>
		<td align="center" style="font-weight: bold;"><?=@mysql_num_rows($tbl_total_dezena3);?></td>
<?
@mysql_free_result($tbl_total_dezena3);
$sql_total_dezena4 = "SELECT * FROM RESULTADOS WHERE DEZENA4=" . $num_dezena;
$tbl_total_dezena4 = mysql_query($sql_total_dezena4,$conexao);
?>
		<td align="center" style="font-weight: bold;"><?=@mysql_num_rows($tbl_total_dezena4);?></td>
<?
@mysql_free_result($tbl_total_dezena4);
$sql_total_dezena5 = "SELECT * FROM RESULTADOS WHERE DEZENA5=" . $num_dezena;
$tbl_total_dezena5 = mysql_query($sql_total_dezena5,$conexao);
?>
		<td align="center" style="font-weight: bold;"><?=@mysql_num_rows($tbl_total_dezena5);?></td>
<?
@mysql_free_result($tbl_total_dezena5);
$sql_total_dezena6 = "SELECT * FROM RESULTADOS WHERE DEZENA6=" . $num_dezena;
$tbl_total_dezena6 = mysql_query($sql_total_dezena6,$conexao);
?>
		<td align="center" style="font-weight: bold;"><?=@mysql_num_rows($tbl_total_dezena6);?></td>
<? @mysql_free_result($tbl_total_dezena6); ?>
		<td align="center">-</td>
	</tr>
</table>
<? //echo '<PRE>'; print_r($GLOBALS); echo '</PRE>'; exit(); ?>
</body>
</html>
<?
@mysql_close($conexao);
while(@ob_end_flush());
?>