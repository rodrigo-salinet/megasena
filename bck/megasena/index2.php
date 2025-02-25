<html>
<head>
<title>Resultados MegaSena</title>
<style type="TEXT/CSS">
table {
	border-color: #000000;
	border-style: solid;
	border-width: 1px;	
}
</style>
</head>
<?
$host = 'localhost';
$db = 'megasena';
$usuario = 'root';
$senha = '123456';

$conexao = mysql_connect($host,$usuario,$senha);

@mysql_select_db($db,$conexao);

$sql_tbl_status = "SHOW TABLE STATUS FROM $db";
$tbl_status = mysql_query($sql_tbl_status,$conexao);

/*$sql_resultados = "SELECT * FROM RESULTADOS ORDER BY ID";
$resultados = mysql_query($sql_resultados,$conexao);
$res_total = @mysql_result($resultados,0,'CAPITULO');*/

/*select email, count(email) 
from usuario 
group by email 
having count(email)>1*/
?>
<table>
	<tr>
		<td>Dezena 1:</td>
		<td>Dezena 2:</td>
		<td>Dezena 3:</td>
		<td>Dezena 4:</td>
		<td>Dezena 5:</td>
		<td>Dezena 6:</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td align="center">Rep.</td>
					<td align="center">Res.</td>
				</tr>
<?
$sql_dezena1 = "SELECT COUNT(*), DEZENA1 FROM RESULTADOS GROUP BY DEZENA1 ORDER BY ID";
$dezena1 = mysql_query($sql_dezena1,$conexao);

for ($n = 0; $n < mysql_num_rows($dezena1); $n++) {
?>
				<tr>
					<td align="center"><?=mysql_result($dezena1,$n,'COUNT(*)');?></td>
					<td align="center"><?=mysql_result($dezena1,$n,'DEZENA1');?></td>
				</tr>
<?
}
@mysql_free_result($dezena1);
?>
			</table>
		</td>
		<td>
			<table>
				<tr>
					<td align="center">Rep.</td>
					<td align="center">Res.</td>
				</tr>
<?
$sql_dezena2 = "SELECT COUNT(*), DEZENA2 FROM RESULTADOS GROUP BY DEZENA2 ORDER BY ID";
$dezena2 = mysql_query($sql_dezena2,$conexao);

for ($n = 0; $n < mysql_num_rows($dezena2); $n++) {
?>
				<tr>
					<td align="center"><?=mysql_result($dezena2,$n,'COUNT(*)');?></td>
					<td align="center"><?=mysql_result($dezena2,$n,'DEZENA2');?></td>
				</tr>
<?
}
@mysql_free_result($dezena2);
?>
			</table>
		</td>
		<td>
			<table>
				<tr>
					<td align="center">Rep.</td>
					<td align="center">Res.</td>
				</tr>
<?
$sql_dezena3 = "SELECT COUNT(*), DEZENA3 FROM RESULTADOS GROUP BY DEZENA3 ORDER BY ID";
$dezena3 = mysql_query($sql_dezena3,$conexao);

for ($n = 0; $n < mysql_num_rows($dezena3); $n++) {
?>
				<tr>
					<td align="center"><?=mysql_result($dezena3,$n,'COUNT(*)');?></td>
					<td align="center"><?=mysql_result($dezena3,$n,'DEZENA3');?></td>
				</tr>
<?
}
@mysql_free_result($dezena3);
?>
			</table>
		</td>
		<td>
			<table>
				<tr>
					<td align="center">Rep.</td>
					<td align="center">Res.</td>
				</tr>
<?
$sql_dezena4 = "SELECT COUNT(*), DEZENA4 FROM RESULTADOS GROUP BY DEZENA4 ORDER BY ID";
$dezena4 = mysql_query($sql_dezena4,$conexao);

for ($n = 0; $n < mysql_num_rows($dezena4); $n++) {
?>
				<tr>
					<td align="center"><?=mysql_result($dezena4,$n,'COUNT(*)');?></td>
					<td align="center"><?=mysql_result($dezena4,$n,'DEZENA4');?></td>
				</tr>
<?
}
@mysql_free_result($dezena4);
?>
			</table>
		</td>
		<td>
			<table>
				<tr>
					<td align="center">Rep.</td>
					<td align="center">Res.</td>
				</tr>
<?
$sql_dezena5 = "SELECT COUNT(*), DEZENA5 FROM RESULTADOS GROUP BY DEZENA5 ORDER BY ID";
$dezena5 = mysql_query($sql_dezena5,$conexao);

for ($n = 0; $n < mysql_num_rows($dezena5); $n++) {
?>
				<tr>
					<td align="center"><?=mysql_result($dezena5,$n,'COUNT(*)');?></td>
					<td align="center"><?=mysql_result($dezena5,$n,'DEZENA5');?></td>
				</tr>
<?
}
@mysql_free_result($dezena5);
?>
			</table>
		</td>
		<td>
			<table>
				<tr>
					<td align="center">Rep.</td>
					<td align="center">Res.</td>
				</tr>
<?
$sql_dezena6 = "SELECT COUNT(*), DEZENA6 FROM RESULTADOS GROUP BY DEZENA6 ORDER BY ID";
$dezena6 = mysql_query($sql_dezena6,$conexao);

for ($n = 0; $n < mysql_num_rows($dezena6); $n++) {
?>
				<tr>
					<td align="center"><?=mysql_result($dezena6,$n,'COUNT(*)');?></td>
					<td align="center"><?=mysql_result($dezena6,$n,'DEZENA6');?></td>
				</tr>
<?
}
@mysql_free_result($dezena6);
?>
			</table>
		</td>
	</tr>
</table>
<?
@mysql_free_result($tbl_status);
@mysql_close($conexao);
while(@ob_end_flush());
?>
</html>
<body>
</body>
</html>