<?
$num_dezena = trim(@$_GET['num_dezena']);
$dezena = trim(@$_GET['dezena']);
?>
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
<table>
	<tr>
		<td align="center">Data:</td>
		<td align="center">Dezena <?=$dezena;?>:</td>
		<td align="center">Acumulada:</td>
	</tr>

<?
$host = 'localhost';
$db = 'megasena';
$usuario = 'root';
$senha = '123456';

$conexao = mysql_connect($host,$usuario,$senha);

@mysql_select_db($db,$conexao);

$campo = "DEZENA" . $dezena;
$sql_resultados = "SELECT * FROM RESULTADOS WHERE " . $campo  . "=" . $num_dezena . " ORDER BY ID";
$tbl_resultados = mysql_query($sql_resultados,$conexao);

for ($n = 0; $n < mysql_num_rows($tbl_resultados); $n++) {
?>
	<tr>
		<td align="center"><?=mysql_result($tbl_resultados,$n,'DATA');?></td>
		<td align="center"><?=mysql_result($tbl_resultados,$n,$campo);?></td>
		<td align="center"><?=mysql_result($tbl_resultados,$n,'ACUMULADA');?></td>
	</tr>
<?
}
@mysql_free_result($tbl_resultados);
?>
</table>
</body>
</html>
<?
@mysql_close($conexao);
while(@ob_end_flush());
?>