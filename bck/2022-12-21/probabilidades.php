<?php
set_time_limit(0);
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

// Clear browse cache
// header("Cache-Control: no-cache, must-revalidate");
// header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// header("Content-Type: application/xml; charset=utf-8");

$host = '127.0.0.1';
$db = 'megasena';
$usuario = 'root';
$senha = 'magento';
$tbl_concursos = 'concursos';
$tbl_cidades_ufs = 'cidades_ufs';

$conexao = mysqli_connect($host,$usuario,$senha,$db);
mysqli_set_charset($conexao,"latin1");
?>
<!doctype html>
<html>
<head>
<meta charset="iso-8859-1">
<title>Probabilidades</title>
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

#campos, #exibicao, #buscas {
	background-color: #00ff00;
    position: fixed;
	width: 99%;
	padding: 0px;
	margin: 0px;
	left: 0px;
}

#exibicao {
	top: 0px;
}

#campos {
	top: 80px;
}

#buscas {
	top: 124px;
}

#exibicao td {
	align-content: center;
	height: 80px;
	padding-left: 10px;
	padding-right: 10px;
}

#buscas td {
	padding-left: 10px;
	padding-right: 10px;
	width: 0.47%;
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
}

.cor2 {
	background-color: #00ff00;
	color: #000000;
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
	var id_obj = obj.id; // variável id do obj
	var id_objtmp = id_obj; // variável id temporária do obj
	var txt_obj = obj.value; // variável "texto"/valor do obj
	if (txt_obj != "") {
		obj.value = txt_obj.toUpperCase(); // função tornar MAIÚSCULAS
		txt_obj = obj.value;
	// } else {
	// 	txt_obj = 61;
	}
	var tbl_concursos = document.getElementById('tbl_concursos'); // variável tabela concursos
	var linhas = tbl_concursos.getElementsByTagName('tr'); // variável linhas da tabela concurso
	var exibir = document.getElementById('exibir'); // variável identificador 'exibir'
	var quantificar_resultados = document.getElementById('quantificar_resultados'); // variável identificador 'quantificar_resultados'
	var tag_obj = obj.tagName; // variável <tag> do obj
	var chkbx = "n"; // variável chkbx - checkbox - "n"
	var busca;
	var id_busca = "";  // variável id_busca em branco
	var busca_exata = "n"; // variável busca_exata - "n"
	
	if (tag_obj == "INPUT" || tag_obj == "input") { // verificador de tag do obj
		if (obj.getAttribute('type') == "checkbox" || obj.getAttribute('type') == "CHECKBOX") { // verificador checkbox ou CHECKBOX
			chkbx = "s"; // variável chkbx recebe valor se obj for checkbox ou CHECKBOX
			if (obj.checked == true && obj.parentElement.parentElement.id == "buscas") { // verificador de checkbox marcado e se faz parte da linha <tr> "buscas"
				busca_exata = "s"; // variável busca_exata recebe valor "s" se verificador for positivo
				id_objtmp = obj.id.substr(6,obj.id.length); // variável id_objtmp recebe valor do sexto dígito do identificado do obj
			}
		/*} else {
			id_busca = 'busca' + '_' + obj.id;
			busca = document.getElementById(id_busca);
			if (busca != null) {
				if (busca.checked == true) {
					//busca_exata = "s";
				}
			}*/
		}
	}
	var notificacoes = document.getElementById('notificacoes'); // variável identificador notificacoes
	var achou = "n"; // variável que identificará se outra variável busca_exata for verdadeira
	var achou_coluna = "n"; // variável que identificará se outra variável achou for verdadeira
	var achou_linha = "n"; // variável que identificará se outra variável achou for verdadeira
	var obj_tmp; // variável que receberá id_obj ()
	var txttmp = ""; // variável de texto temporário
	var linha_atual; // variável que receberá a linha atual do marcador [l]
	var id_temp; // variável que receberá o identificador temporário do obj
	var dezenou = "n"; // variável que identificará se o obj é uma dezena ou não
	
	var total_caracteres = 0; // variável que receberá valor do otal de sorteios
	var inicio_sorteio = 0; // variável que recebe valor do "Sorteio" de outra variável
	var dezenas_sorteio = ""; // variável que receberá (em texto) as dezenas sorteadas encontradas em outra variável
	var matriz_sorteio; // variável que receberá as dezenas sorteadas encontradas em outra variável
	var sorteio = []; // variável que receberá texto (em matrizez) dos sorteios encontrados em outra variável
	// var achoutmp = "n"; // *** variável ainda não utilizada ***
	var n_sorteio = 0; // variável que indica a matriz do sorteio encontrado
	var achou_sorteio = "n"; // variável que recebe valor se variável achou_dezena for verdadeira
	var dezenatmp; // variável que receberá temporariamente o id_obj
	var dezenatmp_valor = ""; // variável que receberá temporariamente o valor da variável dezenatmp
	var celulatmp; // variável que receberá temporariamente identificador de célula
	var celulatmp_conteudo = ""; // variável que receberá temporariamente valor da variável celulatmp
	// var campotmp; // *** variável ainda não utilizada ***
	
	// var celtmp; // *** variável ainda não utilizada ***
	// var celtmp1; // *** variável ainda não utilizada ***
	// var celtmp2; // *** variável ainda não utilizada ***
	// var celtmp3; // *** variável ainda não utilizada ***
	// var celtmp4; // *** variável ainda não utilizada ***
	// var celtmp5; // *** variável ainda não utilizada ***
	// var celtmp6; // *** variável ainda não utilizada ***
	var coltmp; // variável que recebe a coluna atual da linha atual do marcador [col]
	var cmptmp; // variável que recebe os campos da coluna da linha "campos"
	var linha_campos = document.getElementById("campos"); // variável que recebe a linha da tabela do indicador "campos"
	var colunas = linha_campos.getElementsByTagName("td"); // variável que recebe as células/colunas da variável linha_campos
	var colunastmp; // variável que recebe temporariamente as células/colunas da linha atual do marcador  [l]
	var coluna_tmp; // variável que recebe temporariamente uma coluna da linha "campos" do marcador  [col]
	var inputtmp; // variável que recebe temporariamente  o primeiro campo da coluna da linha "campos"
	var encontrados = 0; // variável que indica a posição na matriz de sorteios encontrados
	
	// var linha_temp; // *** variável ainda não utilizada ***
	// var id_linha_temp = ""; // *** variável ainda não utilizada ***
	// var achou_obj = "n"; // variável (em teste) que indica se o valor da variável inputtmp.value for verdadeiro
	// var tmp = ""; // *** variável ainda não utilizada ***
	var achou_destaque = "n"; // variável que identifica se coluna/célula do marcador [dstq] atual estiver em destaque
	var colunas_atual; // variável que recebe temporariamente células/colunas dos marcadores [col] e [dstq]
	var data_sorteio = ""; // variável que recebe a data do sorteio do marcador [l]
	//var achou_campo = "n";  // variável (em teste) que indica se o indicador do obj é o mesmo do indicador temporário do marcador [col] (em desuso)
	var achou_dezena = "n"; // variável que indica se o campo temporário éo mesmo da célula/coluna temporária do marcador [dt]
	var dezena_temp; // variável que recebe a dezena temporária do marcador
	var valor_temp = ""; // variável que recebe o valor da dezena temporária do marcador
	var exato = "n"; // variável que indica se o valor da dezena temporária é o mesmo da célula/coluna temporária do marcador
	
	/*if (chkbx == "s") {
		for (var col = 0; col < colunas.length; col++) {
			coltmp = document.getElementById(colunas[col].id);
			cmptmp = coltmp.getElementsByTagName("input");
			inputtmp = cmptmp[0];
			if (inputtmp.value != "") {
				//id_obj = inputtmp.id.toString();
				//txt_obj = inputtmp.value;
				achou_obj = "s";
				col = colunas.length;
			}
			if (obj.id == cmptmp.id) {
				achou_campo = "s";
			}
		}
		if (achou_obj == "n" && achou_campo == "n") {
			//id_obj = "dezena1";
			txt_obj = "";
		}
	}
	//alert(id_obj + " | " + id_objtmp);
	if (id_objtmp != "" && id_obj != id_objtmp) {
		id_obj = id_objtmp;
	}*/
	//alert(id_obj + " | " + id_objtmp);

	// este loop retira os destaques de todas as células antes de fazer a verificação completa
	for (var l = 1; l <= linhas.length; l++) { // função que contabiliza as linhas dos sorteios
		linha_atual = document.getElementById("linha_" + l); // variável que recebe o objeto da linha atual do marcador [l]
		if (linha_atual != null) { // função que valida se a linha atual não for nula
			colunastmp = linha_atual.getElementsByTagName("td"); // variável que recebe temporariamente as células/colunas da linha atual do marcador [l]}
			for (var col = 0; col < colunastmp.length; col++) { // função que contabiliza as células/colunas da linha do marcador [col] atual
				coltmp = document.getElementById(colunastmp[col].id); // aqui seleciona a coluna atual da linha atual
				coluna_tmp = document.getElementById(colunas[col].id); // aqui seleciona uma coluna da linha "campos" do marcador [col]
				cmptmp = coluna_tmp.getElementsByTagName("input"); // aqui seleciona os campos da coluna da linha "campos"
				inputtmp = cmptmp[0]; // aqui seleciona o primeiro campo da coluna da linha "campos"
				coltmp.className = "normal"; // aqui define a classe css " normal" no objeto coltmp
			}
		}
	}

	for (var l = 1; l <= linhas.length; l++) { // função que contabiliza as linhas dos sorteios
		linha_atual = document.getElementById("linha_" + l); // variável que recebe o objeto da linha atual do marcador [l]
		if (linha_atual != null) { // função que valida se a linha atual não for nula
			//linha_atual.style.visibility = "visible"; // ação para exibir linha
			linha_atual.style.display = "table-row"; // ação para exibir linha
			colunastmp = linha_atual.getElementsByTagName("td"); // variável que recebe temporariamente as células/colunas da linha atual do marcador [l]}
			for (var col = 0; col < colunastmp.length; col++) { // função que contabiliza as células/colunas da linha do marcador [col] atual
				coltmp = document.getElementById(colunastmp[col].id); // aqui seleciona a coluna atual da linha atual
				coluna_tmp = document.getElementById(colunas[col].id); // aqui seleciona uma coluna da linha "campos" do marcador [col]
				cmptmp = coluna_tmp.getElementsByTagName("input"); // aqui seleciona os campos da coluna da linha "campos"
				inputtmp = cmptmp[0]; // aqui seleciona o primeiro campo da coluna da linha "campos"
				//alert(inputtmp.id);
				txt_obj = inputtmp.value.trim(); // aqui atribui o valor do input temporário na variável txt_obj
				// if (txt_obj == "") {
				// 	txt_obj = 61;
				// }

				id_obj = inputtmp.id; // aqui atribui o valor do id do objeto temporário na variável id_obj
				achou_ocorrencia = "n"; // aqui define a variável achou_ocorrencia no padrão "n"
				data_sorteio = document.getElementById("data_sorteio_" + l).innerHTML.toString(); // aqui atribui o valor da data de sorteio da linha selecionada na variavel data_sorteio
				achou_linha = "n"; // aqui define a variavel achou_linha no padrao "n"
				id_temp = id_obj + "_" + l; // aqui define a variável id_temp no padráo id_1
				obj_tmp = document.getElementById(id_temp); // aqui define a variável obj_tmp pelo nome da variável id_temp definida na linha de cima
				
				dezenou = "n"; // aqui define a variável dezenou no padrão "n"
				if (obj_tmp.id.search("dezena") >= 0) { // validador se achou o texto "dezena" no id do objeto temporário
					dezenou = "s"; // atribui o valor "s" na variável dezenou, significa que a célula é uma dezena
				}

				if (dezenou == "n") { // validador se achou o valor "n" na variável dezenou
					coltmp.className = "normal"; // aqui define a classe css " normal" no objeto coltmp
				}

				if (txt_obj != "") { // aqui autoriza buscar a coluna atual se houver algo digitado
					//alert(coltmp.id + ".classe: " + coltmp.className);
					//alert(coltmp.id + ".classe: " + coltmp.className);
					//alert("Achou coluna [" + inputtmp.id + "]: " + inputtmp.value + " | achou_linha: " + achou_linha);
					/*for (var d = 1; d <= 6; d++) {
						celtmp = document.getElementById("dezena" + d + "_" + l);
						celtmp.className = "normal";
					}*/
					achou = "n"; // aqui 
					txttmp = obj_tmp.innerHTML.toString();

					// aqui tem que mexer a bagaça !!!

					id_busca = 'busca_' + id_obj;
					busca = document.getElementById(id_busca);
					busca_exata = "n";
					if (busca != null) {
						if (busca.checked == true) {
							busca_exata = "s"; //console.log('passou aqui -> ' + busca.id);
						}
					}

					//alert(id_busca);
					if (busca_exata == "s") {
						if (txttmp == txt_obj) {
							achou = "s";
						}
					} else {
						if (txttmp.search(txt_obj) >= 0) {
							achou = "s"; 
						}
					}
					if (achou == "s") {
						obj_tmp.className = "destaque"; //console.log('passou aqui -> ' + obj_tmp.id);
						//console.log("txttmp: " + txttmp + ", txt_obj: " + txt_obj + ", id_temp: " + id_temp + ", obj_tmp.id: " + obj_tmp.id);
						//alert("txttmp: " + txttmp + ", txt_obj: " + txt_obj + ", id_temp: " + id_temp + ", obj_tmp.id: " + obj_tmp.id);
						achou_coluna = "s";
						achou_linha = "s";
					}

					achou_sorteio = "n";
					if (dezenou == "s") {
						dezenatmp = document.getElementById(id_obj);
						dezenatmp_valor = dezenatmp.value;
						for (var ct = 1; ct <= 6; ct++) {
							celulatmp = document.getElementById("dezena" + ct + "_" + l);
							//alert(celulatmp.id);
							celulatmp_conteudo = celulatmp.innerHTML.toString();
							achou_dezena = "n";
							for (var dt = 1; dt <= 6; dt++) {
								dezena_temp = document.getElementById("dezena" + dt);
								valor_temp = dezena_temp.value;
								if (busca_exata == "s" && dezena_temp.id == id_obj) { // parei aqui
									if (dezenatmp_valor == celulatmp_conteudo) {
										achou_dezena = "s"; //console.log("dezenatmp_valor: " + dezenatmp_valor + ", celulatmp_conteudo: " + celulatmp_conteudo + ", dezena_temp.id: " + dezena_temp.id);
										exato = "s";
										//alert("Achou: [ " + achou_dezena + " ] exatamente [ " + dezenatmp_valor + " ] na célula [ " + celulatmp.id + " ] = " + celulatmp_conteudo)
									} else {
										if (valor_temp != "" && valor_temp == celulatmp_conteudo) {
											achou_dezena = "s"; //console.log("passou aqui");
										}
									}
								} else {
									if (celulatmp_conteudo.search(dezenatmp_valor) >= 0) {
										achou_dezena = "s";
										//alert("Achou: [ " + achou_dezena + " ] qualquer parte [ " + dezenatmp_valor + " ] na célula [ " + celulatmp.id + " ] = " + celulatmp_conteudo)
									} else {
										if (valor_temp != "" && celulatmp_conteudo.search(valor_temp) >= 0) {
											achou_dezena = "s";
										}
									}
								}
							}
							//alert("Busca exata? [ " + busca_exata + " ] - Achou: [ " + achou_dezena + " ] - [ " + dezenatmp_valor + " ] na célula [ " + celulatmp.id + " ] = " + celulatmp_conteudo)
							
							if (achou_dezena == "s") {
								//alert ("achou [" + txt_obj + "] na linha " + l + ", célula " + celulatmp.id + ", dezena " + ct + " do campo " + id_obj);
								//if (exato == "s") {
									achou_sorteio = "s";
									if (sorteio[n_sorteio]) {
										sorteio[n_sorteio] += "," + celulatmp_conteudo;
									} else {
										sorteio[n_sorteio] = "Concurso: " + l + "\nData: " + data_sorteio + "\nSorteio: " + celulatmp_conteudo;
									}
									//alert("Campo: " + dezenatmp_valor + " - Célula: " + celulatmp_conteudo);
									if (busca_exata == "s") {
										for (var dtmp = 1; dtmp <= 6; dtmp++) {
											dezena_dtmp = document.getElementById("dezena" + dtmp);
											valor_dtmp = dezena_dtmp.value;
											if (valor_dtmp == celulatmp.innerHTML.toString()) {
												celulatmp.className = "destaque"; //console.log('passou aqui -> ' + celulatmp.id);
											}
										}
										//console.log("txttmp: " + txttmp + ", txt_obj: " + txt_obj + ", id_temp: " + id_temp + ", celulatmp.id: " + celulatmp.id);
									} else {
										celulatmp.className = "destaque"; //console.log('passou aqui -> ' + celulatmp.id);
									}
								//}
							} else {
								//if (celulatmp.className != "destaque") {
									celulatmp.className = "normal";
								//}
							}
						}
					} else {
						//alert("Campo: " + dezenatmp_valor + " - Célula: " + celulatmp_conteudo);
                        celulatmp.className = "normal";
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
					//alert(coltmp.id + ".classe: " + coltmp.className);
				}
			}
			//alert("achou_linha: " + achou_linha);
		}
		

		if (l == linhas.length) {
			if (achou_coluna == "n") {
				if (notificacoes.checked == true && achou_coluna == "s") {
					console.log("Ops! Valor não encontrado na coluna " + id_obj);
				}
			}
			if (sorteio.length > 0) {
				sorteio.sort();
				for (var s = 0; s < sorteio.length; s++) {
					total_caracteres = sorteio[s].length;
					inicio_sorteio = sorteio[s].search("Sorteio:") + 8;
					dezenas_sorteio = sorteio[s].substring(inicio_sorteio,total_caracteres);
					matriz_sorteio = dezenas_sorteio.split(",");
					if (matriz_sorteio.length > 3 && obj.id != "exibir") {
						if (matriz_sorteio.length == 4) {
							if (notificacoes.checked == true) {
								console.log("Achou QUADRA! \n" + sorteio[s] + 'teste: https://megasena.loc/#concurso_33');
							}
						}
						if (matriz_sorteio.length == 5) {
							if (notificacoes.checked == true) {
								console.log("Achou QUINA! \n" + sorteio[s]);
							}
						}
						if (matriz_sorteio.length == 6) {
							if (notificacoes.checked == true) {
								console.log("Achou SENA! \n" + sorteio[s]);
							}
						}
					}
				}
			}
			if (quantificar_resultados.checked == true) {
				if (notificacoes.checked == true && achou_coluna == "s") {
					console.log("Foram encontradas [ " + encontrados + " ] ocorrências da solicitação { " + obj.value + " } informada.");
				}
			}
		}
	}
	ocultar_exibir_linhas();
}
function ocultar_exibir_linhas() {
	var linhas = tbl_concursos.getElementsByTagName('tr'); // variável linhas da tabela concurso
	var exibir = document.getElementById('exibir'); // variável identificador 'exibir'
	var achou_linha = "n"; // variável que identificará se outra variável achou for verdadeira
	var achou_destaque = "n";
	for (var l = 1; l <= linhas.length; l++) { // função que contabiliza as linhas dos sorteios
		linha_atual = document.getElementById("linha_" + l); // variável que recebe o objeto da linha atual do marcador [l]
		if (linha_atual != null) { // função que valida se a linha atual não for nula
			//linha_atual.style.visibility = "visible"; // ação para exibir linha
			linha_atual.style.display = "table-row"; // ação para exibir linha
			colunastmp = linha_atual.getElementsByTagName("td"); // variável que recebe temporariamente as células/colunas da linha atual do marcador [l]}
			achou_destaque = "n";
			for (var col = 0; col < colunastmp.length; col++) { // função que contabiliza as células/colunas da linha do marcador [col] atual
				coltmp = document.getElementById(colunastmp[col].id); // aqui seleciona a coluna atual da linha atual
				if (coltmp.className == "destaque") {
					achou_destaque = "s";
				}
			}
			if (achou_destaque == "n" && exibir.checked == true) {
				//linha_atual.style.visibility = "hidden"; // ação para ocultar linha
				linha_atual.style.display = "none"; // ação para ocultar linha
			}
		}
	}
}
</script>
</head>
<body>
<?php
$achou = "n";
$dez1_tmp = 0;
$dezena1 = 39;
while ($achou == "n") {
	$dez1_tmp++;
	if (rand(1,60) == $dezena1) {
		$achou = "s";
	}
}

$achou = "n";
$dez2_tmp = 0;
$dezena2 = 17;
while ($achou == "n") {
	$dez2_tmp++;
	if (rand(1,60) == $dezena2) {
		$achou = "s";
	}
}

$achou = "n";
$dez3_tmp = 0;
$dezena3 = 56;
while ($achou == "n") {
	$dez3_tmp++;
	if (rand(1,60) == $dezena3) {
		$achou = "s";
	}
}

$achou = "n";
$dez4_tmp = 0;
$dezena4 = 60;
while ($achou == "n") {
	$dez4_tmp++;
	if (rand(1,60) == $dezena4) {
		$achou = "s";
	}
}

$achou = "n";
$dez5_tmp = 0;
$dezena5 = 26;
while ($achou == "n") {
	$dez5_tmp++;
	if (rand(1,60) == $dezena5) {
		$achou = "s";
	}
}

$achou = "n";
$dez6_tmp = 0;
$dezena6 = 7;
while ($achou == "n") {
	$dez6_tmp++;
	if (rand(1,60) == $dezena6) {
		$achou = "s";
	}
}

echo "Prob1: $dez1_tmp <br> Prob2: $dez2_tmp <br> Prob3: $dez3_tmp <br> Prob4: $dez4_tmp <br> Prob5: $dez5_tmp <br> Prob6: $dez6_tmp";
?>
<script language="javascript" type="text/javascript">
	document.getElementById("mais_sorteados").innerHTML = document.getElementById("todos_sorteios").value;
	document.getElementById("mais_sorteados2").innerHTML = document.getElementById("todos_sorteios2").value;
	document.getElementById("mais_sorteados2").title = document.getElementById("todos_sorteios3").value;
</script>
</body>
</html>
<?php //clearstatcache(); ?>