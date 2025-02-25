<?
$host = 'localhost';
$db = 'megasena';
$usuario = 'root';
$senha = '123456';

$conexao = mysql_connect($host,$usuario,$senha);

@mysql_select_db($db,$conexao);
?>
<HTML>

<HEAD>
<TITLE>Resultados por Numeros - Ordem de Sorteio - MegaSena</TITLE>
<STYLE TYPE="TEXT/CSS">
body {
	font-family: Arial, Helvetica, sans-serif;
}
table {
	border-collapse: collapse;
}
td {
	border-color: #000000;
	border-style: solid;
	border-width: 1px;
	font-size: 12px;
}
</STYLE>
<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="TEXT/JAVASCRIPT">
function ver_sorteio() {
	var txt_dezena = Array();
	txt_dezena[0] = String(document.getElementById('txt_dezena1').value);
	txt_dezena[1] = String(document.getElementById('txt_dezena2').value);
	txt_dezena[2] = String(document.getElementById('txt_dezena3').value);
	txt_dezena[3] = String(document.getElementById('txt_dezena4').value);
	txt_dezena[4] = String(document.getElementById('txt_dezena5').value);
	txt_dezena[5] = String(document.getElementById('txt_dezena6').value);
	var txt_dezena_ordenada = String(txt_dezena.sort());
	//alert(txt_dezena_ordenada);

	var total = Number(document.getElementById('total').value);
	
	var alerta = 'Jogos sorteados:';
	
	var achou = false;

	for (var s = 1; s <= total; s++) {
		var sorteio_temp = String(document.getElementById('sorteio'+s).value);
		var sorteio_separado = sorteio_temp.split(';');
		var sorteio_ordenado = String(sorteio_separado.sort());
		//alert(sorteio_ordenado);

		var achou_dez1 = false;
		var achou_dez2 = false;
		var achou_dez3 = false;
		var achou_dez4 = false;
		var achou_dez5 = false;
		var achou_dez6 = false;

		/*for (var i = 0; i < 6; i++) {
			if (sorteio_separado[i].valueOf() == txt_dezena1 && achou_dez1 == false && txt_dezena1 != '') {
				achou = true;
				achou_dez1 = true;
			}
			if (sorteio_separado[i].valueOf() == txt_dezena2 && achou_dez2 == false && txt_dezena2 != '') {
				achou = true;
				achou_dez2 = true;
			}
			if (sorteio_separado[i].valueOf() == txt_dezena3 && achou_dez3 == false && txt_dezena3 != '') {
				achou = true;
				achou_dez3 = true;
			}
			if (sorteio_separado[i].valueOf() == txt_dezena4 && achou_dez4 == false && txt_dezena4 != '') {
				achou = true;
				achou_dez4 = true;
			}
			if (sorteio_separado[i].valueOf() == txt_dezena5 && achou_dez5 == false && txt_dezena5 != '') {
				achou = true;
				achou_dez5 = true;
			}
			if (sorteio_separado[i].valueOf() == txt_dezena6 && achou_dez6 == false && txt_dezena6 != '') {
				achou = true;
				achou_dez6 = true;
			}
		}
		
		if (achou == true) {
			//String.fromCharCode(13)
			alerta +=  ' --- ' + String(document.getElementById('sorteio_completo'+s).value);
		}*/
		if (txt_dezena_ordenada == sorteio_ordenado) {
			//String.fromCharCode(13)
			alerta +=  ' --- ' + String(document.getElementById('sorteio_completo'+s).value);
			achou = true;
		} 
	}
	if (achou == true) {
		alert(alerta);
	} else {
		alert("Nao foi encontrado o jogo.");
	}

}
</SCRIPT>
</HEAD>
<BODY>
<FORM NAME="frm_sorteios" ID="frm_sorteios">
	<TABLE>
		<TR>
			<TD><INPUT TYPE="TEXT" NAME="txt_dezena1" ID="txt_dezena1" SIZE="2" MAXLENGTH="2" /></TD>
			<TD><INPUT TYPE="TEXT" NAME="txt_dezena2" ID="txt_dezena2" SIZE="2" MAXLENGTH="2" /></TD>
			<TD><INPUT TYPE="TEXT" NAME="txt_dezena3" ID="txt_dezena3" SIZE="2" MAXLENGTH="2" /></TD>
			<TD><INPUT TYPE="TEXT" NAME="txt_dezena4" ID="txt_dezena4" SIZE="2" MAXLENGTH="2" /></TD>
			<TD><INPUT TYPE="TEXT" NAME="txt_dezena5" ID="txt_dezena5" SIZE="2" MAXLENGTH="2" /></TD>
			<TD><INPUT TYPE="TEXT" NAME="txt_dezena6" ID="txt_dezena6" SIZE="2" MAXLENGTH="2" /></TD>
			<TD><INPUT TYPE="BUTTON" VALUE="Pesquisar" onClick="ver_sorteio();" /></TD>
<?
$sql_todos_resultados = "SELECT * FROM RESULTADOS ORDER BY ID";
$tbl_todos_resultados = mysql_query($sql_todos_resultados,$conexao);

$css = 'STYLE="background-color:#DDDDDD;font-weight:bold;"';
for ($s = 0; $s < @mysql_num_rows($tbl_todos_resultados); $s++) {
?>
			<INPUT TYPE="HIDDEN" NAME="sorteio<?=$s+1;?>" ID="sorteio<?=$s+1;?>" VALUE="<?=@mysql_result($tbl_todos_resultados,$s,'DEZENA1') . ';' . @mysql_result($tbl_todos_resultados,$s,'DEZENA2') . ';' . @mysql_result($tbl_todos_resultados,$s,'DEZENA3') . ';' . @mysql_result($tbl_todos_resultados,$s,'DEZENA4') . ';' . @mysql_result($tbl_todos_resultados,$s,'DEZENA5') . ';' . @mysql_result($tbl_todos_resultados,$s,'DEZENA6');?>" />
			<INPUT TYPE="HIDDEN" NAME="sorteio_completo<?=$s+1;?>" ID="sorteio_completo<?=$s+1;?>" VALUE="<?='Data: ' . @mysql_result($tbl_todos_resultados,$s,'DATA') . '; Dezena 1: ' . @mysql_result($tbl_todos_resultados,$s,'DEZENA1') . '; Dezena 2: ' . @mysql_result($tbl_todos_resultados,$s,'DEZENA2') . '; Dezena 3: ' . @mysql_result($tbl_todos_resultados,$s,'DEZENA3') . '; Dezena 4: ' . @mysql_result($tbl_todos_resultados,$s,'DEZENA4') . '; Dezena 5: ' . @mysql_result($tbl_todos_resultados,$s,'DEZENA5') . '; Dezena 6: ' . @mysql_result($tbl_todos_resultados,$s,'DEZENA6') . '; Premio Acumulado: ' . @mysql_result($tbl_todos_resultados,$s,'ACUMULADA') . '.';?>" />
<? } ?>
			<INPUT TYPE="HIDDEN" NAME="total" ID="total" VALUE="<?=@mysql_num_rows($tbl_todos_resultados);?>" />
<? @mysql_free_result($tbl_todos_resultados); ?>
		</TR>
	</TABLE>
</FORM>
<BR />
<TABLE>
<?
$numeros_sorteios = array();
$numero = array();
$s = 1;
for ($n = 1; $n <= 60; $n++) {
	$sql_sorteios = "SELECT * FROM RESULTADOS WHERE DEZENA1=" . $n . " OR DEZENA2=" . $n . " OR DEZENA3=" . $n . " OR DEZENA4=" . $n . " OR DEZENA5=" . $n . " OR DEZENA6=" . $n . " ORDER BY ID";
	$tbl_sorteios = mysql_query($sql_sorteios,$conexao);
	$num_dezena = $n;
	$numeros_sorteios[$n-1] = @mysql_num_rows($tbl_sorteios);
?>
	<TR>
		<TD>
			<TABLE WIDTH="100%">
				<TR>
					<TD ALIGN="center">Numero: <STRONG><?=$n;?></STRONG></TD>
					<TD ALIGN="center"> Sorteios: <STRONG><A NAME="<?=$numeros_sorteios[$n-1];?>"><?=$numeros_sorteios[$n-1];?></A></STRONG></TD>
				</TR>
			</TABLE>
		</TD>
	</TR>
	<TR>
		<TD>
			<TABLE>
				<TR>
					<TD ALIGN="center">Ordem:</TD>
					<TD ALIGN="center">Data:</TD>
					<TD ALIGN="center">Dezena 1:</TD>
					<TD ALIGN="center">Dezena 2:</TD>
					<TD ALIGN="center">Dezena 3:</TD>
					<TD ALIGN="center">Dezena 4:</TD>
					<TD ALIGN="center">Dezena 5:</TD>
					<TD ALIGN="center">Dezena 6:</TD>
					<TD ALIGN="center">Acumulada:</TD>
					<TD ALIGN="center">Jogo Repetido:</TD>
				</TR>
<?
	$sql_resultados = "SELECT * FROM RESULTADOS WHERE DEZENA1=" . $num_dezena . " OR DEZENA2=" . $num_dezena . " OR DEZENA3=" . $num_dezena . " OR DEZENA4=" . $num_dezena . " OR DEZENA5=" . $num_dezena . " OR DEZENA6=" . $num_dezena . " ORDER BY ID";
	$tbl_resultados = mysql_query($sql_resultados,$conexao);
	
	$css = 'STYLE="background-color:#DDDDDD;font-weight:bold;"';
	for ($i = 0; $i < @mysql_num_rows($tbl_resultados); $i++) {
?>
				<TR>
					<TD ALIGN="center"><?=$i+1;?></TD>
					<TD ALIGN="center"><?=@mysql_result($tbl_resultados,$i,'DATA');?></TD>
<?
		$dezena1 = @mysql_result($tbl_resultados,$i,'DEZENA1');
		$estilo = '';
		if ($dezena1 == $num_dezena) {
			$estilo = $css;
		}
?>
					<TD ALIGN="center" <?=$estilo;?>><?=$dezena1;?></TD>
<?
		$dezena2 = @mysql_result($tbl_resultados,$i,'DEZENA2');
		$estilo = '';
		if ($dezena2 == $num_dezena) {
			$estilo = $css;
		}
?>
					<TD ALIGN="center" <?=$estilo;?>><?=$dezena2;?></TD>
<?
		$dezena3 = @mysql_result($tbl_resultados,$i,'DEZENA3');
		$estilo = '';
		if ($dezena3 == $num_dezena) {
			$estilo = $css;
		}
?>
					<TD ALIGN="center" <?=$estilo;?>><?=$dezena3;?></TD>
<?
		$dezena4 = @mysql_result($tbl_resultados,$i,'DEZENA4');
		$estilo = '';
		if ($dezena4 == $num_dezena) {
			$estilo = $css;
		}
?>
					<TD ALIGN="center" <?=$estilo;?>><?=$dezena4;?></TD>
<?
		$dezena5 = @mysql_result($tbl_resultados,$i,'DEZENA5');
		$estilo = '';
		if ($dezena5 == $num_dezena) {
			$estilo = $css;
		}
?>
					<TD ALIGN="center" <?=$estilo;?>><?=$dezena5;?></TD>
<?
		$dezena6 = @mysql_result($tbl_resultados,$i,'DEZENA6');
		$estilo = '';
		if ($dezena6 == $num_dezena) {
			$estilo = $css;
		}
?>
					<TD ALIGN="center" <?=$estilo;?>><?=$dezena6;?></TD>
					<TD ALIGN="center"><?=mysql_result($tbl_resultados,$i,'ACUMULADA');?></TD>
<?
		$dezenas = array(@mysql_result($tbl_resultados,$i,'DEZENA1'),@mysql_result($tbl_resultados,$i,'DEZENA2'),@mysql_result($tbl_resultados,$i,'DEZENA3'),@mysql_result($tbl_resultados,$i,'DEZENA4'),@mysql_result($tbl_resultados,$i,'DEZENA5'),@mysql_result($tbl_resultados,$i,'DEZENA6'));
		array_multisort($dezenas,SORT_ASC,SORT_NUMERIC);

		$repetido = "NAO";
		for ($t = 0; $t < @mysql_num_rows($tbl_todos_resultados); $t++) {
			$dezenas_temp = array(@mysql_result($tbl_resultados,$t,'DEZENA1'),@mysql_result($tbl_resultados,$t,'DEZENA2'),@mysql_result($tbl_resultados,$t,'DEZENA3'),@mysql_result($tbl_resultados,$t,'DEZENA4'),@mysql_result($tbl_resultados,$t,'DEZENA5'),@mysql_result($tbl_resultados,$t,'DEZENA6'));
			array_multisort($dezenas_temp,SORT_ASC,SORT_NUMERIC);
			if (array_values($dezenas) == array_values($dezenas_temp)) {
				$repetido = "SIM";
			}
		}
?>
					<TD ALIGN="center"><?=$repetido;?></TD>
				</TR>
<?	} ?>
				<TR>
					<TD ALIGN="center" COLSPAN="2">Total:</TD>
<?
		$sql_total_dezena1 = "SELECT * FROM RESULTADOS WHERE DEZENA1=" . $num_dezena;
		$tbl_total_dezena1 = mysql_query($sql_total_dezena1,$conexao);
?>
					<TD ALIGN="center" STYLE="font-weight: bold;"><?=@mysql_num_rows($tbl_total_dezena1);?></TD>
<?
		@mysql_free_result($tbl_total_dezena1);
		$sql_total_dezena2 = "SELECT * FROM RESULTADOS WHERE DEZENA2=" . $num_dezena;
		$tbl_total_dezena2 = mysql_query($sql_total_dezena2,$conexao);
?>
					<TD ALIGN="center" STYLE="font-weight: bold;"><?=@mysql_num_rows($tbl_total_dezena2);?></TD>
<?
		@mysql_free_result($tbl_total_dezena2);
		$sql_total_dezena3 = "SELECT * FROM RESULTADOS WHERE DEZENA3=" . $num_dezena;
		$tbl_total_dezena3 = mysql_query($sql_total_dezena3,$conexao);
?>
					<TD ALIGN="center" STYLE="font-weight: bold;"><?=@mysql_num_rows($tbl_total_dezena3);?></TD>
<?
		@mysql_free_result($tbl_total_dezena3);
		$sql_total_dezena4 = "SELECT * FROM RESULTADOS WHERE DEZENA4=" . $num_dezena;
		$tbl_total_dezena4 = mysql_query($sql_total_dezena4,$conexao);
?>
					<TD ALIGN="center" STYLE="font-weight: bold;"><?=@mysql_num_rows($tbl_total_dezena4);?></TD>
<?
		@mysql_free_result($tbl_total_dezena4);
		$sql_total_dezena5 = "SELECT * FROM RESULTADOS WHERE DEZENA5=" . $num_dezena;
		$tbl_total_dezena5 = mysql_query($sql_total_dezena5,$conexao);
?>
					<TD ALIGN="center" STYLE="font-weight: bold;"><?=@mysql_num_rows($tbl_total_dezena5);?></TD>
<?
		@mysql_free_result($tbl_total_dezena5);
		$sql_total_dezena6 = "SELECT * FROM RESULTADOS WHERE DEZENA6=" . $num_dezena;
		$tbl_total_dezena6 = mysql_query($sql_total_dezena6,$conexao);
?>
					<TD ALIGN="center" STYLE="font-weight: bold;"><?=@mysql_num_rows($tbl_total_dezena6);?></TD>
					<TD ALIGN="center">-</TD>
				</TR>
			</TABLE>
		</TD>
	</TR>
<?
	@mysql_free_result($tbl_total_dezena6);
	@mysql_free_result($tbl_resultados);
	@mysql_free_result($tbl_sorteios);
}
?>
</TABLE>
<BR />
Maior numero de resultados: <STRONG><A HREF="#<?=max($numeros_sorteios);?>"><?=max($numeros_sorteios);?></A></STRONG><BR />
Menor numero de resultados: <STRONG><A HREF="#<?=min($numeros_sorteios);?>"><?=min($numeros_sorteios);?></A></STRONG>
<? //echo '<PRE>'; print_r($GLOBALS); echo '</PRE>'; exit(); ?>
</BODY>
</HTML>
<?
@mysql_close($conexao);
while(@ob_end_flush());
?>