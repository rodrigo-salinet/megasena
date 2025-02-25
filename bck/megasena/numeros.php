<html>
<head>
<title>Total de Resultados por Número</title>
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
		<td align="center">Número:</td>
		<td align="center">Sorteios:</td>
	</tr>

<?
$host = 'localhost';
$db = 'megasena';
$usuario = 'root';
$senha = '123456';

$conexao = mysql_connect($host,$usuario,$senha);

@mysql_select_db($db,$conexao);

for ($n = 1; $n <= 60; $n++) {
?>
<?
	$sql_sorteios = "SELECT * FROM RESULTADOS WHERE DEZENA1=" . $n . " OR DEZENA2=" . $n . " OR DEZENA3=" . $n . " OR DEZENA4=" . $n . " OR DEZENA5=" . $n . " OR DEZENA6=" . $n . " ORDER BY ID";
	$tbl_sorteios = mysql_query($sql_sorteios,$conexao);
?>
	<tr>
		<td align="center"><?=$n;?></td>
		<td align="center"><?=mysql_num_rows($tbl_sorteios);?></td>
	</tr>
<?
	@mysql_free_result($tbl_sorteios);
}
?>
</table>
</body>
</html>
<?
@mysql_close($conexao);
while(@ob_end_flush());
?>