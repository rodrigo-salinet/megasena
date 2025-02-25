<?php
set_time_limit(0);
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$host = '127.0.0.1';
$db = 'megasena';
$usuario = 'root';
$senha = 'magento';
$tbl_concursos = 'sorteios';

$conexao = mysqli_connect($host,$usuario,$senha,$db);
mysqli_set_charset($conexao,"latin1");

$txt_sql_limpar_tbl_concursos = "TRUNCATE `$tbl_concursos`;";
if (!mysqli_query($conexao,$txt_sql_limpar_tbl_concursos)) {
	die("Não foi possível esvaziar a tabela $tbl_concursos. <br/><br/> $txt_sql_limpar_tbl_concursos");
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
$arquivo = "/shared/httpd/megasena/ordem_sorteio.csv";

if (!file_exists($arquivo)) {
	die("Arquivo [$arquivo] não encontrado -> " . dirname(__FILE__));
}

$ponteiro = fopen($arquivo,"r");
$cor = '#ffffff';
$p = 1;
$concurso_atual = 1;
$separador = ',';

while (!feof($ponteiro)) {
	$linha = fgets($ponteiro,4096);
	$linha = trim($linha);
	$valores = explode($separador,$linha);
	$id_concurso = intval($valores[0]);

	$data_sorteio = "";
	$dezena1 = "";
	$dezena2 = "";
	$dezena3 = "";
	$dezena4 = "";
	$dezena5 = "";
	$dezena6 = "";

	if (count($valores) < 8) {
		die("Ops! Faltou algum campo ou separador '$separador' na linha " . $p . ".");
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