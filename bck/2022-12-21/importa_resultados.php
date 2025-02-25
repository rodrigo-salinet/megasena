<?php
set_time_limit(0);
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$host = '127.0.0.1';
$db = 'megasena';
$usuario = 'root';
$senha = 'magento';
$tbl_concursos = 'concursos';
$tbl_cidades_ufs = 'cidades_ufs';

$conexao = mysqli_connect($host,$usuario,$senha,$db);
mysqli_set_charset($conexao,"latin1");

$txt_sql_limpar_tbl_concursos = "TRUNCATE `$tbl_concursos`;";
if (!mysqli_query($conexao,$txt_sql_limpar_tbl_concursos)) {
	die("Não foi possível esvaziar a tabela $tbl_concursos. <br/><br/> $txt_sql_limpar_tbl_concursos");
}

$txt_sql_limpar_tbl_cidadesufs = "TRUNCATE `$tbl_cidades_ufs`;";
if (!mysqli_query($conexao,$txt_sql_limpar_tbl_cidadesufs)) {
	die("Não foi possível esvaziar a tabela $tbl_cidades_ufs. <br/><br/> $txt_sql_limpar_tbl_cidadesufs");
}
?>
<!doctype html>
<html>
<head>
<meta charset="iso-8859-1">
<title>Importação Resultados MegaSena</title>
<style type="text/css">
td {
	text-align: center;
	vertical-align: middle;
	font-family: Gill Sans, Gill Sans MT, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial," sans-serif";
	font-size: 9px;
	/*background-color: #01C000;*/
}
</style>
</head>
<body>
<h2 align="center">TRANSFERINDO RESULTADOS PARA O BANCO DE DADOS</h2>
<?php
$arquivo = "/shared/httpd/megasena/csvfinal.csv";

if (!file_exists($arquivo)) {
	die("Arquivo [$arquivo] não encontrado -> " . dirname(__FILE__));
}

$ponteiro = fopen($arquivo,"r");
$cor = '#ffffff';
$p = 1;
$concurso_atual = 1;

while (!feof($ponteiro)) {
	$linha = fgets($ponteiro,4096);
	$linha = trim($linha);
	$valores = explode(';',$linha);
	$id_concurso = intval($valores[0]);

	$data_sorteio = "";
	$dezena1 = "";
	$dezena2 = "";
	$dezena3 = "";
	$dezena4 = "";
	$dezena5 = "";
	$dezena6 = "";
	$arrecadacao_total = "";
	$ganhadores_sena = "";
	$rateio_sena = "";
	$ganhadores_quina = "";
	$rateio_quina = "";
	$ganhadores_quadra = "";
	$rateio_quadra = "";
	$acumulado = "";
	$valor_acumulado = "";
	$estimativa_premio = "";
	$acumulado_megadavirada = "";
	$obs = "";

	if (count($valores) <= 21) {
		die("Ops! Faltou algum campo ou separador ';' na linha " . $p . ".");
	}

	//print_r($valores);
	if ($id_concurso != "") {
		$concurso_atual = intval(trim($id_concurso));
		$inserir_campos = "`id`";
		$inserir_valores = $id_concurso;

		$txt_sql_concurso = "SELECT * FROM `$db`.`$tbl_concursos` WHERE `id`=$id_concurso;";
		$sql_concurso = mysqli_query($conexao,$txt_sql_concurso);

		if (mysqli_num_rows($sql_concurso) == 0) {
			$data_sorteio = trim($valores[1]);
			if ($data_sorteio != "") {
				$data_matriz = explode('/',$data_sorteio);
				$data_sorteio = $data_matriz[2] . '-' . $data_matriz[1] . '-' . $data_matriz[0];
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`data_sorteio`";
				$inserir_valores .= "'$data_sorteio'";
			}

			$dezena1 = trim($valores[2]);
			if ($dezena1 != "") {
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`dezena1`";
				$inserir_valores .= "$dezena1";
			}

			$dezena2 = trim($valores[3]);
			if ($dezena2 != "") {
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`dezena2`";
				$inserir_valores .= "$dezena2";
			}

			$dezena3 = trim($valores[4]);
			if ($dezena3 != "") {
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`dezena3`";
				$inserir_valores .= "$dezena3";
			}

			$dezena4 = trim($valores[5]);
			if ($dezena4 != "") {
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`dezena4`";
				$inserir_valores .= "$dezena4";
			}

			$dezena5 = trim($valores[6]);
			if ($dezena5 != "") {
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`dezena5`";
				$inserir_valores .= "$dezena5";
			}

			$dezena6 = trim($valores[7]);
			if ($dezena6 != "") {
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`dezena6`";
				$inserir_valores .= "$dezena6";
			}

			$arrecadacao_total = trim($valores[8]);
			if ($arrecadacao_total != "" && $arrecadacao_total > 0) {
				$arrecadacao_total = str_replace('.','',$arrecadacao_total);
				$arrecadacao_total = str_replace(',','.',$arrecadacao_total);
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`arrecadacao_total`";
				$inserir_valores .= "$arrecadacao_total";
			}

			$ganhadores_sena = trim($valores[9]);
			if ($ganhadores_sena != "" && $ganhadores_sena > 0) {
				$ganhadores_sena = str_replace('.','',$ganhadores_sena);
				$ganhadores_sena = str_replace(',','.',$ganhadores_sena);
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`ganhadores_sena`";
				$inserir_valores .= "$ganhadores_sena";
			}

			$rateio_sena = trim($valores[10]);
			if ($rateio_sena != "" && $rateio_sena > 0) {
				$rateio_sena = str_replace('.','',$rateio_sena);
				$rateio_sena = str_replace(',','.',$rateio_sena);
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`rateio_sena`";
				$inserir_valores .= "$rateio_sena";
			}

			$ganhadores_quina = trim($valores[11]);
			if ($ganhadores_quina != "" && $ganhadores_quina > 0) {
				$ganhadores_quina = str_replace('.','',$ganhadores_quina);
				$ganhadores_quina = str_replace(',','.',$ganhadores_quina);
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`ganhadores_quina`";
				$inserir_valores .= "$ganhadores_quina";
			}

			$rateio_quina = trim($valores[12]);
			if ($rateio_quina != "" && $rateio_quina > 0) {
				$rateio_quina = str_replace('.','',$rateio_quina);
				$rateio_quina = str_replace(',','.',$rateio_quina);
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`rateio_quina`";
				$inserir_valores .= "$rateio_quina";
			}

			$ganhadores_quadra = trim($valores[13]);
			if ($ganhadores_quadra != "" && $ganhadores_quadra > 0) {
				$ganhadores_quadra = str_replace('.','',$ganhadores_quadra);
				$ganhadores_quadra = str_replace(',','.',$ganhadores_quadra);
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`ganhadores_quadra`";
				$inserir_valores .= "$ganhadores_quadra";
			}

			$rateio_quadra = trim($valores[14]);
			if ($rateio_quadra != "" && $rateio_quadra > 0) {
				$rateio_quadra = str_replace('.','',$rateio_quadra);
				$rateio_quadra = str_replace(',','.',$rateio_quadra);
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`rateio_quadra`";
				$inserir_valores .= "$rateio_quadra";
			}

			$acumulado = trim($valores[15]);
			if ($acumulado != "") {
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`acumulado`";
				$inserir_valores .= "'$acumulado'";
			}

			$valor_acumulado = trim($valores[16]);
			if ($valor_acumulado != "" && $valor_acumulado > 0) {
				$valor_acumulado = str_replace('.','',$valor_acumulado);
				$valor_acumulado = str_replace(',','.',$valor_acumulado);
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`valor_acumulado`";
				$inserir_valores .= "$valor_acumulado";
			}

			$estimativa_premio = trim($valores[17]);
			if ($estimativa_premio != "" && $estimativa_premio > 0) {
				$estimativa_premio = str_replace('.','',$estimativa_premio);
				$estimativa_premio = str_replace(',','.',$estimativa_premio);
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`estimativa_premio`";
				$inserir_valores .= "$estimativa_premio";
			}

			$acumulado_megadavirada = trim($valores[18]);
			if ($acumulado_megadavirada != "" && $acumulado_megadavirada > 0) {
				$acumulado_megadavirada = str_replace('.','',$acumulado_megadavirada);
				$acumulado_megadavirada = str_replace(',','.',$acumulado_megadavirada);
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`acumulado_megadavirada`";
				$inserir_valores .= "$acumulado_megadavirada";
			}

			$obs = trim($valores[19]);
			if ($obs != "" && $obs > 0) {
				$obs = str_replace('.','',$obs);
				$obs = str_replace(',','.',$obs);
				if ($inserir_campos != "") {
					$inserir_campos .= ",";
				}
				if ($inserir_valores != "") {
					$inserir_valores .= ",";
				}
				$inserir_campos .= "`obs`";
				$inserir_valores .= "$obs";
			}

			$txt_sql_inserir_concurso = "INSERT INTO `$db`.`$tbl_concursos` ($inserir_campos) VALUES ($inserir_valores);";
			if (mysqli_query($conexao,$txt_sql_inserir_concurso)) {
				$inseriu = "S";
			} else {
				echo "<pre>";
				print_r("Não foi possível inserir o concurso $id_concurso.<br/><br/> $txt_sql_inserir_concurso");
				echo "</pre>";
				die();
			}
		}
		mysqli_free_result($sql_concurso);
	}

	$inserir_campos = "`id_concurso`";
	$inserir_valores = $concurso_atual;

	$cidade = trim($valores[14]);
	if ($cidade != "") {
		if ($inserir_campos != "") {
			$inserir_campos .= ",";
		}
		if ($inserir_valores != "") {
			$inserir_valores .= ",";
		}
		$inserir_campos .= "`cidade`";
		$inserir_valores .= "'$cidade'";
	}

	$uf = trim($valores[15]);
	if ($uf != "") {
		if ($inserir_campos != "") {
			$inserir_campos .= ",";
		}
		if ($inserir_valores != "") {
			$inserir_valores .= ",";
		}
		$inserir_campos .= "`uf`";
		$inserir_valores .= "'$uf'";
	}

	if ($inserir_campos != "" && $inserir_valores != "") {
		$txt_sql_inserir_cidadeuf = "INSERT INTO `$db`.`$tbl_cidades_ufs` ($inserir_campos) VALUES ($inserir_valores);";
		if (!mysqli_query($conexao,$txt_sql_inserir_cidadeuf)) {
			die("Não foi possível inserir a cidade/uf $cidade/$uf.<br/><br/> $txt_sql_inserir_cidadeuf");
		}
	}
	$p++;
}
?>
<h2>DADOS TRANSFERIDOS COM SUCESSO!</h2>
<table width="100%">
	<tr style="background-color: #01C000;">
		<td>Concurso</td>
		<td>Data Sorteio</td>
		<td>Dezena1</td>
		<td>Dezena2</td>
		<td>Dezena3</td>
		<td>Dezena4</td>
		<td>Dezena5</td>
		<td>Dezena6</td>
		<td>Arrecadação Total</td>
		<td>Ganhadores Sena</td>
		<td>Cidade</td>
		<td>UF</td>
		<td>Rateio Sena</td>
		<td>Ganhadores Quina</td>
		<td>Rateio Quina</td>
		<td>Ganhadores Quadra</td>
		<td>Rateio Quadra</td>
		<td>Acumulado</td>
		<td>Valor Acumulado</td>
		<td>Estimativa Prêmio</td>
		<td>Acumulado Mega da Virada</td>
	</tr>
<?php
$txt_sql_concursos = "SELECT * FROM `$db`.`$tbl_concursos` ORDER BY `id` ASC;";
$sql_concursos = mysqli_query($conexao,$txt_sql_concursos);
$num_linhas = mysqli_num_rows($sql_concursos);

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
	$arrecadacao_total = $concurso['arrecadacao_total'];
	$ganhadores_sena = $concurso['ganhadores_sena'];
	$rateio_sena = $concurso['rateio_sena'];
	$ganhadores_quina = $concurso['ganhadores_quina'];
	$rateio_quina = $concurso['rateio_quina'];
	$ganhadores_quadra = $concurso['ganhadores_quadra'];
	$rateio_quadra = $concurso['rateio_quadra'];
	$acumulado = $concurso['acumulado'];
	$valor_acumulado = $concurso['valor_acumulado'];
	$estimativa_premio = $concurso['estimativa_premio'];
	$acumulado_megadavirada = $concurso['acumulado_megadavirada'];
?>
	<tr style="background-color: <?php echo $cor; ?>;">
		<td><?php echo $id_concurso; ?></td>
		<td><?php echo $data_matriz[2] . "/" . $data_matriz[1] . "/" . $data_matriz[0]; ?></td>
		<td><?php echo $dezena1; ?></td>
		<td><?php echo $dezena2; ?></td>
		<td><?php echo $dezena3; ?></td>
		<td><?php echo $dezena4; ?></td>
		<td><?php echo $dezena5; ?></td>
		<td><?php echo $dezena6; ?></td>
		<td>R$<?php echo number_format($arrecadacao_total,2,",","."); ?></td>
		<td><?php echo $ganhadores_sena; ?></td>
<?php
	$txt_sql_cidades_ufs = "SELECT * FROM `$db`.`$tbl_cidades_ufs` WHERE `id_concurso`=$id_concurso ORDER BY `UF` ASC;";
	$sql_cidades_ufs = mysqli_query($conexao,$txt_sql_cidades_ufs);
	$cidades = "";
	$ufs = "";
	while ($cidades_ufs = mysqli_fetch_array($sql_cidades_ufs)) {
		$cidade_atual = $cidades_ufs['cidade'];
		if ($cidade_atual != "") {
			$cidades .= "[$cidade_atual]<br/>";
		}
		$uf_atual = $cidades_ufs['uf'];
		if ($uf_atual != "") {
			$ufs .= "[$uf_atual]<br/>";
		}
	}
?>
		<td><?php echo $cidades; ?></td>
		<td><?php echo $ufs; ?></td>
		<td>R$<?php echo number_format($rateio_sena,2,",","."); ?></td>
		<td><?php echo $ganhadores_quina; ?></td>
		<td>R$<?php echo number_format($rateio_quina,2,",","."); ?></td>
		<td><?php echo $ganhadores_quadra; ?></td>
		<td>R$<?php echo number_format($rateio_quadra,2,",","."); ?></td>
		<td><?php echo $acumulado; ?></td>
		<td>R$<?php echo number_format($valor_acumulado,2,",","."); ?></td>
		<td>R$<?php echo number_format($estimativa_premio,2,",","."); ?></td>
		<td>R$<?php echo number_format($acumulado_megadavirada,2,",","."); ?></td>
	</tr>
<?php
	if ($cor == '#ffffff') {
		$cor = '#01C000';
	} else {
		$cor = '#ffffff';
	}
}
?>
</table>
</body>
</html>