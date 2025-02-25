<?php
set_time_limit(0);
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$host = 'localhost';
$db = 'megasena';
$usuario = 'root';
$senha = 'pullin00';
$tbl_concursos = 'concursos';
$tbl_cidades_ufs = 'cidades_ufs';

$conexao = mysqli_connect($host,$usuario,$senha,$db);
mysqli_set_charset($conexao,"latin1");
?>
<!doctype html>
<html>
<head>
<meta charset="iso-8859-1">
<title>JM</title>
<style type="text/css">
body {
	margin: 0px;
	padding: 0px;
}

table {
    table-layout: fixed;
    width: 98.9%;
	padding: 0px;
	margin: 0px;
	border-spacing: 0px;
	border-collapse: collapse;
	background-color: #000000;
}

b {
	font-size: 12px;
}
#campos, #exibicao {
	background-color: #00ff00;
    position: fixed;
	width: 99%;
	padding: 0px;
	margin: 0px;
}

#campos {
	top: 80px;
	left: 0px;
}

#exibicao, #col_exibicao {
	top: 0px;
	align-content: center;
	height: 80px;
}

#col_exibicao, #mais_sorteados, #mais_sorteados2, #col_busca, #col_quantificar_resultados, #col_notificacoes {
	padding-left: 10px;
	padding-right: 10px;
}

#espacamento {
	border: 0px;
	background-color: #00ff00;
}

td {
	text-align: center;
	vertical-align: middle;
	font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial," sans-serif";
	font-size: 10px;
    border: 1px solid #000;
	padding: 0px;
	margin: 0px;
}

input[type="text"] {
	text-align: center;
	background-color: #E8FF00;
	font-size: 10px;
	font-weight: bold;
	color: #FF0000;
	border: 1px solid #000000;
	width: 99%;
	height: 40px;
}

input::placeholder {
	white-space: normal;
}

.cor1 {
	background-color: #ffffff;
	color: #000000;
	visibility: visible;
}

.cor2 {
	background-color: #00ff00;
	color: #000000;
	visibility: visible;
}
	
.oculto {
	visibility: hidden;
}

.normal {
	background-color: transparent;
	color: #000000;
	font-weight: normal;
}

.destaque {
	background-color: #FF0004;
	color: #F8FF00;
	font-weight: bold;
}
</style>
<script language="javascript" type="text/javascript">
function verificar(obj) {
	var txt_obj = obj.value;
	if (txt_obj != "") {
		obj.value = txt_obj.toUpperCase();
		txt_obj = obj.value;
	}
	var tbl_concursos = document.getElementById('tbl_concursos');
	var linhas = tbl_concursos.getElementsByTagName('tr');
	var exibir = document.getElementById('exibir');
	var quantificar_resultados = document.getElementById('quantificar_resultados');
	var busca = document.getElementById('busca');
	var notificacoes = document.getElementById('notificacoes');
	var achou = "n";
	var achou_coluna = "n";
	var achou_linha = "n";
	var obj_tmp;
	var txttmp = "";
	var linha_atual;
	var id_temp;
	var dezenou = "n";
	
	var total_caracteres = 0;
	var inicio_sorteio = 0;
	var dezenas_sorteio = "";
	var matriz_sorteio;
	var sorteio = [];
	var achoutmp = "n";
	var n_sorteio = 0;
	var achou_sorteio = "n";
	var dezenatmp;
	var dezenatmp_valor = "";
	var celulatmp;
	var celulatmp_conteudo = "";
	var campotmp;
	var classe = "cor1";
	
	var celtmp;
	var celtmp1;
	var celtmp2;
	var celtmp3;
	var celtmp4;
	var celtmp5;
	var celtmp6;
	var id_obj = obj.id;
	var coltmp;
	var cmptmp;
	var linha_campos = document.getElementById(linhas[0].id);
	var colunas = linha_campos.getElementsByTagName("td");
	var inputtmp;
	var encontrados = 0;
	
	var linha_temp;
	var id_linha_temp = "";
	var achou_obj = "n";
	var tmp = "";
	var achou_destaque = "n";
	var colunas_atual;
	var data_sorteio = "";
	
	if (id_obj == "exibir" || id_obj == "quantificar_resultados" || id_obj == "busca" || id_obj == "notificacoes") {
		txt_obj = "";
		for (var col = 0; col < colunas.length; col++) {
			coltmp = document.getElementById(colunas[col].id);
			cmptmp = coltmp.getElementsByTagName("input");
			inputtmp = cmptmp[0];
			if (inputtmp.value != "") {
				id_obj = inputtmp.id.toString();
				txt_obj = inputtmp.value;
				achou_obj = "s";
				col = colunas.length;
			}
		}
		if (achou_obj == "n") {
			id_obj = "dezena1";
		}
	}
	
	for (var l = 1; l <= linhas.length; l++) {
		linha_atual = document.getElementById("linha_" + l);
		if (linha_atual != null) {
			achou_ocorrencia = "n";
			data_sorteio = document.getElementById("data_sorteio_" + l).innerHTML.toString();
			achou_linha = "n";
			id_temp = id_obj + "_" + l;
			obj_tmp = document.getElementById(id_temp);
			for (var d = 1; d <= 6; d++) {
				celtmp = document.getElementById("dezena" + d + "_" + l);
				celtmp.className = "normal";
			}
			achou = "n";
			//txttmp = obj_tmp.firstChild.nodeValue.toString();
			txttmp = obj_tmp.innerHTML.toString();
			dezenou = "n";
			if (obj_tmp.id.search("dezena") >= 0) {
				dezenou = "s";
			}
			if (busca.checked == true) {
				if (txttmp == txt_obj && txt_obj != "") {
					achou = "s";
				}
			} else {
				if (txttmp.search(txt_obj) >= 0 && txt_obj != "") {
					achou = "s";
				}
			}
			if (achou == "s") {
				obj_tmp.className = "destaque";
				achou_coluna = "s";
				achou_linha = "s";
			} else {
				obj_tmp.className = "normal";
			}
			
			achou_sorteio = "n";
			for (var dt = 1; dt <= 6; dt++) {
				somar = "n";
				dezenatmp = document.getElementById("dezena" + dt);
				dezenatmp_valor = dezenatmp.value;
				
				achoutmp = "n";
				for (var cp = 1; cp <= 6; cp++) {
					campotmp = document.getElementById("dezena" + cp);
					if (campotmp.value == dezenatmp_valor && cp != dt) {
						achoutmp = "s";
					}
				}
				if (dezenatmp_valor != "" && achoutmp == "n") {
					for (var ct = 1; ct <= 6; ct++) {
						celulatmp = document.getElementById("dezena" + ct + "_" + l);
						//celulatmp_conteudo = celulatmp.firstChild.nodeValue.toString();
						celulatmp_conteudo = celulatmp.innerHTML.toString();
						if (dezenatmp_valor == celulatmp_conteudo) {
							achou_sorteio = "s";
							//alert ("achou [" + txt_obj + "] na linha " + l + ", célula " + celulatmp.id + ", dezena " + ct + " do campo " + id_obj);
							if (sorteio[n_sorteio]) {
								sorteio[n_sorteio] += "," + celulatmp_conteudo;
							} else {
								sorteio[n_sorteio] = "Concurso: " + l + "\nData: " + data_sorteio + "\nSorteio: " + celulatmp_conteudo;
							}
							celulatmp.className = "destaque";
						}
					}
				}
			}
			if (achou_sorteio == "s") {
				n_sorteio++;
				achou_linha = "s";
				encontrados++;
			}
			achou_destaque = "n";
			colunas_atual = linha_atual.getElementsByTagName("td");
			for (var dstq = 0; dstq < colunas_atual.length; dstq++) {
				if (colunas_atual[dstq].className == "destaque") {
					achou_destaque = "s";
				}
			}
			if (achou_destaque == "s") {
				achou_linha = "s";
			}
			if (exibir.checked == true) {
				if (achou_linha == "s") {
					linha_atual.className = classe; // ação para exibir
				} else {
					linha_atual.className = "oculto"; // ação para ocultar
				}
			} else {
				linha_atual.className = classe; // ação para exibir
			}
		}
		//alert("Marcado? " + exibir.checked + " \n id_linha: " + linha_atual.id  + " \n Achou linha? " + achou_linha);
		if (l == linhas.length && txt_obj != "") {
			if (achou_coluna == "n" && obj.id != "exibir") {
				if (notificacoes.checked == true) {
					alert("Ops! Valor não encontrado na coluna " + id_obj);
				}
			}
			if (sorteio.length > 0 && dezenou == "s") {
				sorteio.sort();
				for (var s = 0; s < sorteio.length; s++) {
					total_caracteres = sorteio[s].length;
					inicio_sorteio = sorteio[s].search("Sorteio:") + 8;
					dezenas_sorteio = sorteio[s].substring(inicio_sorteio,total_caracteres);
					matriz_sorteio = dezenas_sorteio.split(",");
					if (matriz_sorteio.length > 3 && obj.id != "exibir") {
						if (matriz_sorteio.length == 4) {
							if (notificacoes.checked == true) {
								alert("Achou QUADRA! \n" + sorteio[s]);
							}
						}
						if (matriz_sorteio.length == 5) {
							if (notificacoes.checked == true) {
								alert("Achou QUINA! \n" + sorteio[s]);
							}
						}
						if (matriz_sorteio.length == 6) {
							if (notificacoes.checked == true) {
								alert("Achou SENA! \n" + sorteio[s]);
							}
						}
					}
				}
			}
			if (quantificar_resultados.checked == true) {
				if (notificacoes.checked == true) {
					alert("Foram encontradas [" + encontrados + "] ocorrências da solicitação {" + txt_obj + "} informada.")
				}
			}
		}
		if (classe == "cor1") {
			classe = "cor2";
		} else {
			classe = "cor1";
		}
	}
}
</script>
</head>
<body>
<form action="jogar.php" method="post" id="frm_jogar" name="frm_jogar">
<table width="100%" id="tbl_concursos">
	<tr id="campos">
		<td id="col_concurso">
			<input type="text" maxlength="4" name="concurso" id="concurso" placeholder="Concurso" onKeyUp="verificar(this)"/>
		</td>
		<td id="col_data_sorteio">
			<input type="text" maxlength="10" name="data_sorteio" id="data_sorteio" placeholder="Data Sorteio" onKeyUp="verificar(this)"/>
		</td>
		<td id="col_dezena1">
			<input type="text" maxlength="2" name="dezena1" id="dezena1" placeholder="1ª Dezena" onKeyUp="return verificar(this)"/>
		</td>
		<td id="col_dezena2">
			<input type="text" maxlength="2" name="dezena2" id="dezena2" placeholder="2ª Dezena" onKeyUp="return verificar(this)"/>
		</td>
		<td id="col_dezena3">
			<input type="text" maxlength="2" name="dezena3" id="dezena3" placeholder="3ª Dezena" onKeyUp="return verificar(this)"/>
		</td>
		<td id="col_dezena4">
			<input type="text" maxlength="2" name="dezena4" id="dezena4" placeholder="4ª Dezena" onKeyUp="return verificar(this)"/>
		</td>
		<td id="col_dezena5">
			<input type="text" maxlength="2" name="dezena5" id="dezena5" placeholder="5ª Dezena" onKeyUp="return verificar(this)"/>
		</td>
		<td id="col_dezena6">
			<input type="text" maxlength="2" name="dezena6" id="dezena6" placeholder="6ª Dezena" onKeyUp="return verificar(this)"/>
		</td>
		<td id="col_arrecadacao_total">
			<input type="text" maxlength="15" name="arrecadacao_total" id="arrecadacao_total" placeholder="Arrecadação Total" onKeyUp="verificar(this)"/>
		</td>
		<td id="col_ganhadores_sena">
			<input type="text" maxlength="4" name="ganhadores_sena" id="ganhadores_sena" placeholder="Ganhadores Sena" onKeyUp="verificar(this)"/>
		</td>
		<td id="col_cidade">
			<input type="text" maxlength="255" name="cidade" id="cidade" placeholder="Cidade" onKeyUp="verificar(this)"/>
		</td>
		<td id="col_uf">
			<input type="text" maxlength="2" name="uf" id="uf" placeholder="UF" onKeyUp="verificar(this)"/>
		</td>
		<td id="col_rateio_sena">
			<input type="text" maxlength="15" name="rateio_sena" id="rateio_sena" placeholder="Rateio Sena" onKeyUp="verificar(this)"/>
		</td>
		<td id="col_ganhadores_quina">
			<input type="text" maxlength="4" name="ganhadores_quina" id="ganhadores_quina" placeholder="Ganhadores Quina" onKeyUp="verificar(this)"/>
		</td>
		<td id="col_rateio_quina">
			<input type="text" maxlength="15" name="rateio_quina" id="rateio_quina" placeholder="Rateio Quina" onKeyUp="verificar(this)"/>
		</td>
		<td id="col_ganhadores_quadra">
			<input type="text" maxlength="4" name="ganhadores_quadra" id="ganhadores_quadra" placeholder="Ganhadores Quadra" onKeyUp="verificar(this)"/>
		</td>
		<td id="col_rateio_quadra">
			<input type="text" maxlength="15" name="rateio_quadra" id="rateio_quadra" placeholder="Rateio Quadra" onKeyUp="verificar(this)"/>
		</td>
		<td id="col_acumulado">
			<input type="text" maxlength="3" name="acumulado" id="acumulado" placeholder="Acumulado" onKeyUp="verificar(this)"/>
		</td>
		<td id="col_valor_acumulado">
			<input type="text" maxlength="15" name="valor_acumulado" id="valor_acumulado" placeholder="Valor Acumulado" onKeyUp="verificar(this)"/>
		</td>
		<td id="col_estimativa_premio">
			<input type="text" maxlength="15" name="estimativa_premio" id="estimativa_premio" placeholder="Estimativa Prêmio" onKeyUp="verificar(this)"/>
		</td>
		<td id="col_acumulado_megadavirada">
			<input type="text" maxlength="15" name="acumulado_megadavirada" id="acumulado_megadavirada" placeholder="Mega da Virada" onKeyUp="verificar(this)"/>
		</td>
	</tr>
	<tr id="exibicao">
		<td id="col_exibicao">
			<input type="checkbox" name="exibir" id="exibir" onChange="verificar(this)"/><br/>
			<label for="exibir">Exibir somente digitados?</label>
		</td>
		<td id="col_busca">
			<input type="checkbox" name="busca" id="busca" onChange="verificar(this)"/><br/>
			<label for="busca">Busca exata?</label>
		</td>
		<td id="col_quantificar_resultados">
			<input type="checkbox" name="quantificar_resultados" id="quantificar_resultados" onChange="verificar(this)"/><br/>
			<label for="quantificar_resultados">Quantificar resultados?</label>
		</td>
		<td id="col_notificacoes">
			<input type="checkbox" name="notificacoes" id="notificacoes" onChange="verificar(this)"/><br/>
			<label for="notificacoes">Exibir notificações?</label>
		</td>
		<td id="mais_sorteados"></td>
		<td id="mais_sorteados2"></td>
	</tr>
	<tr id="espacamento"><td colspan="21" style="height: 130px;" id="col_espaco"></td></tr>
<?php
$txt_sql_concursos = "SELECT * FROM `$db`.`$tbl_concursos` ORDER BY `id` ASC;";
//$txt_sql_concursos = "SELECT * FROM `$db`.`$tbl_concursos` ORDER BY `id` ASC LIMIT 2;";
$sql_concursos = mysqli_query($conexao,$txt_sql_concursos);
$num_linhas = mysqli_num_rows($sql_concursos);
$classe = "cor1";

$todos_sorteios = "";

while ($concurso = mysqli_fetch_array($sql_concursos)) {
	$id_concurso = $concurso['id'];
	
	$data_sorteio = $concurso['data_sorteio'];
	$data_matriz = explode('-',$data_sorteio);
	$data_sorteio = $data_matriz[2] . "/" . $data_matriz[1] . "/" . $data_matriz[0];
	
	$dezena1 = $concurso['dezena1'];
	$dezena2 = $concurso['dezena2'];
	$dezena3 = $concurso['dezena3'];
	$dezena4 = $concurso['dezena4'];
	$dezena5 = $concurso['dezena5'];
	$dezena6 = $concurso['dezena6'];
	
	$achou = "n";
	$dez1_tmp = 0;
	while ($achou == "n") {
		$dez1_tmp++;
		if (rand(1,60) == $dezena1) {
			$achou = "s";
		}
	}

	$achou = "n";
	$dez2_tmp = 0;
	while ($achou == "n") {
		$dez2_tmp++;
		if (rand(1,60) == $dezena2) {
			$achou = "s";
		}
	}
	
	$achou = "n";
	$dez3_tmp = 0;
	while ($achou == "n") {
		$dez3_tmp++;
		if (rand(1,60) == $dezena3) {
			$achou = "s";
		}
	}
	
	$achou = "n";
	$dez4_tmp = 0;
	while ($achou == "n") {
		$dez4_tmp++;
		if (rand(1,60) == $dezena4) {
			$achou = "s";
		}
	}
	
	$achou = "n";
	$dez5_tmp = 0;
	while ($achou == "n") {
		$dez5_tmp++;
		if (rand(1,60) == $dezena5) {
			$achou = "s";
		}
	}
	
	$achou = "n";
	$dez6_tmp = 0;
	while ($achou == "n") {
		$dez6_tmp++;
		if (rand(1,60) == $dezena6) {
			$achou = "s";
		}
	}

	$todos_sorteios .= ",$dezena1,$dezena2,$dezena3,$dezena4,$dezena5,$dezena6";
	$arrecadacao_total = 0;
	if ($concurso['arrecadacao_total'] != "") {
		$arrecadacao_total = $concurso['arrecadacao_total'];
	}
	$ganhadores_sena = 0;
	if ($concurso['ganhadores_sena'] != "") {
		$ganhadores_sena = $concurso['ganhadores_sena'];
	}
	$rateio_sena = 0;
	if ($concurso['rateio_sena'] != "") {
		$rateio_sena = $concurso['rateio_sena'];
	}
	$ganhadores_quina = 0;
	if ($concurso['ganhadores_quina'] != "") {
		$ganhadores_quina = $concurso['ganhadores_quina'];
	}
	$rateio_quina = 0;
	if ($concurso['rateio_quina'] != "") {
		$rateio_quina = $concurso['rateio_quina'];
	}
	$ganhadores_quadra = 0;
	if ($concurso['ganhadores_quadra'] != "") {
		$ganhadores_quadra = $concurso['ganhadores_quadra'];
	}
	$rateio_quadra = 0;
	if ($concurso['rateio_quadra'] != "") {
		$rateio_quadra = $concurso['rateio_quadra'];
	}
	$acumulado = "---";
	if ($concurso['acumulado'] != "") {
		$acumulado = $concurso['acumulado'];
	}
	$valor_acumulado = 0;
	if ($concurso['valor_acumulado'] != "") {
		$valor_acumulado = $concurso['valor_acumulado'];
	}
	$estimativa_premio = 0;
	if ($concurso['estimativa_premio'] != "") {
		$estimativa_premio = $concurso['estimativa_premio'];
	}
	$acumulado_megadavirada = 0;
	if ($concurso['acumulado_megadavirada'] != "") {
		$acumulado_megadavirada = $concurso['acumulado_megadavirada'];
	}
?>
	<tr class="<?php echo $classe; ?>" id="linha_<?php echo $id_concurso; ?>">
		<td id="concurso_<?php echo $id_concurso; ?>"><?php echo $id_concurso; ?></td>
		<td id="data_sorteio_<?php echo $id_concurso; ?>"><?php echo $data_matriz[2] . "/" . $data_matriz[1] . "/" . $data_matriz[0]; ?></td>
		<td id="dezena1_<?php echo $id_concurso; ?>" title="<?php echo $dez1_tmp; ?>"><?php echo $dezena1; ?></td>
		<td id="dezena2_<?php echo $id_concurso; ?>" title="<?php echo $dez2_tmp; ?>"><?php echo $dezena2; ?></td>
		<td id="dezena3_<?php echo $id_concurso; ?>" title="<?php echo $dez3_tmp; ?>"><?php echo $dezena3; ?></td>
		<td id="dezena4_<?php echo $id_concurso; ?>" title="<?php echo $dez4_tmp; ?>"><?php echo $dezena4; ?></td>
		<td id="dezena5_<?php echo $id_concurso; ?>" title="<?php echo $dez5_tmp; ?>"><?php echo $dezena5; ?></td>
		<td id="dezena6_<?php echo $id_concurso; ?>" title="<?php echo $dez6_tmp; ?>"><?php echo $dezena6; ?></td>
		<td id="arrecadacao_total_<?php echo $id_concurso; ?>">R$<?php echo number_format($arrecadacao_total,2,",","."); ?></td>
		<td id="ganhadores_sena_<?php echo $id_concurso; ?>"><?php echo $ganhadores_sena; ?></td>
<?php
	$txt_sql_cidades_ufs = "SELECT * FROM `$db`.`$tbl_cidades_ufs` WHERE `id_concurso`=$id_concurso ORDER BY `UF` ASC;";
	$sql_cidades_ufs = mysqli_query($conexao,$txt_sql_cidades_ufs);
	$cidades = "";
	$ufs = "";
	while ($cidades_ufs = mysqli_fetch_array($sql_cidades_ufs)) {
		$cidade_atual = $cidades_ufs['cidade'];
		if ($cidade_atual != "") {
			$cidades .= "[$cidade_atual]<br/>";
		} else {
			$cidades .= "[---]<br/>";
		}
		$uf_atual = $cidades_ufs['uf'];
		if ($uf_atual != "") {
			$ufs .= "[$uf_atual]<br/>";
		} else {
			$ufs .= "[---]<br/>";
		}
	}
?>
		<td id="cidade_<?php echo $id_concurso; ?>"><?php echo $cidades; ?></td>
		<td id="uf_<?php echo $id_concurso; ?>"><?php echo $ufs; ?></td>
		<td id="rateio_sena_<?php echo $id_concurso; ?>">R$<?php echo number_format($rateio_sena,2,",","."); ?></td>
		<td id="ganhadores_quina_<?php echo $id_concurso; ?>"><?php echo $ganhadores_quina; ?></td>
		<td id="rateio_quina_<?php echo $id_concurso; ?>">R$<?php echo number_format($rateio_quina,2,",","."); ?></td>
		<td id="ganhadores_quadra_<?php echo $id_concurso; ?>"><?php echo $ganhadores_quadra; ?></td>
		<td id="rateio_quadra_<?php echo $id_concurso; ?>">R$<?php echo number_format($rateio_quadra,2,",","."); ?></td>
		<td id="acumulado_<?php echo $id_concurso; ?>"><?php echo $acumulado; ?></td>
		<td id="valor_acumulado_<?php echo $id_concurso; ?>">R$<?php echo number_format($valor_acumulado,2,",","."); ?></td>
		<td id="estimativa_premio_<?php echo $id_concurso; ?>">R$<?php echo number_format($estimativa_premio,2,",","."); ?></td>
		<td id="acumulado_megadavirada_<?php echo $id_concurso; ?>">R$<?php echo number_format($acumulado_megadavirada,2,",","."); ?></td>
	</tr>
<?php
	if ($classe == "cor1") {
		$classe = "cor2";
	} else {
		$classe = "cor1";
	}
}
?>
</table><br/>
<?php
$todos_sorteios = explode(',',$todos_sorteios);

$sorteio = array();
foreach ($todos_sorteios as $sorteios) {
	if (trim($sorteios) != "") {
		if (isset($sorteio[$sorteios])) {
			$sorteio[$sorteios] = intval($sorteio[$sorteios]) + 1;
		} else {
			$sorteio[$sorteios] = 1;
		}
	}
}

arsort($sorteio);

$mais_sorteados = "Dezenas mais sorteadas:<br/> | ";
$mais_sorteados2 = "Dezenas menos sorteadas:<br/> | ";

$d = 1;
foreach ($sorteio as $dezenna => $key) {
	if ($d <= 6) {
		$mais_sorteados .= "<b>" . $dezenna . "</b> (" . $key . "x) | ";
	}
	if ($d > 6) {
		$mais_sorteados2 .= "<b>" . $dezenna . "</b> (" . $key . "x) | ";
	}
	$d++;
}

$sorteio_ordenado = $sorteio;

ksort($sorteio_ordenado);

$mais_sorteados3 = "Dezenas sorteadas em ordem crescente:\n | ";
foreach ($sorteio_ordenado as $dezennas => $key) {
	$mais_sorteados3 .= $dezennas . " (" . $key . "x) | ";
}

?>
<input type="hidden" id="todos_sorteios" name="todos_sorteios" value="<?php echo $mais_sorteados; ?>" />
<input type="hidden" id="todos_sorteios2" name="todos_sorteios2" value="<?php echo $mais_sorteados2; ?>" />
<input type="hidden" id="todos_sorteios3" name="todos_sorteios3" value="<?php echo $mais_sorteados3; ?>" />
</form>
<script language="javascript" type="text/javascript">
	document.getElementById("mais_sorteados").innerHTML = document.getElementById("todos_sorteios").value;
	document.getElementById("mais_sorteados2").innerHTML = document.getElementById("todos_sorteios2").value;
	document.getElementById("mais_sorteados2").title = document.getElementById("todos_sorteios3").value;
</script>
</body>
</html>