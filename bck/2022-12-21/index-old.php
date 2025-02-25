<?php
set_time_limit(0);
setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$_GET['a'] = rand(9999);

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
<title>Jogar Megasena</title>
<link rel="icon" type="image/x-icon" href="/homer.png">
<meta charset="iso-8859-1">
<style type="text/css">
body, td, h1, h2, h3, h4, h5, h6, span, label, input, select, option {
    font-family: Roboto, Myriad Pro, DejaVu Sans Condensed, Helvetica, Arial, sans-serif;
}

body {
    margin: 0px;
    padding: 0px;
}

table {
    table-layout: fixed;
    width: 99.9%;
    padding: 0px;
    margin: 0px;
    border-spacing: 0px;
    border-collapse: collapse;
}

b {
    font-size: 12px;
    background-color: #000;
    color: #fff;
}

label {
    font-size: 9px;
}

td {
    text-align: center;
    vertical-align: middle;
    font-size: 10px;
    border: 3px inset #000;
    padding: 0px;
    margin: 0px;
    word-wrap: break-word;
}

input[type="text"] {
    text-align: center;
    vertical-align: middle;
    background-color: gold;
    font-size: 20px;
    font-weight: bold;
    color: black;
    border: 2px inset #000000;
    width: 89.9%;
    height: 15px;
    line-height: normal;
}

input::placeholder {
    color: darkslategrey;
    vertical-align: text-top;
    font-size: 9px;
    top: 5px;
    padding: 0px;
    line-height: normal;
}

input::-webkit-input-placeholder { /* WebKit browsers */
    line-height: 1.5em;
    vertical-align: top;
}

#col_exibicao {
    width: 10%;
}

#col_quantificar_resultados {
    width: 10%;
}

#col_notificacoes {
    width: 10%;
}

#mais_sorteados {
    width: 10%;
}

#mais_sorteados2 {
    width: 60%;
}

#campos, #exibicao, #buscas {
    position: fixed;
    width: 99.9%;
    padding: 0px;
    margin: 0px;
    left: 0px;
}

#exibicao {
    top: 0px;
    width: 99.9%;
}

#exibicao > td {
    align-content: center;
    height: 30px;
}

#campos {
    top: 31px;
}

#buscas {
    top: 55px;
}

#col_espaco {
    height: 75px;
}

#buscas, #col_exibicao, #col_quantificar_resultados, #col_notificacoes {
    background-color: lightseagreen;
    color: midnightblue;
}

#buscas > td {
    white-space: nowrap;
    width: 0.1%;
    vertical-align: top;
    padding: 0px;
}

#espacamento {
    border: 0px;
    background-color: white;
}

#mais_sorteados {
    background-color: green;
    color: yellow;
}

#mais_sorteados2 {
    background-color: darkred;
    color: white;
    width: auto;
    white-space: nowrap;
}

.cor1 {
    background-color: aquamarine;
    color: #000000;
}

.cor2 {
    background-color: white;
    color: #000000;
}

.destaque {
    background-color: purple;
    color: yellow;
    font-weight: bold;
    padding: 5px;
    font-family: monospace;
    font-size: 12px;
}
</style>

</head>
<body>
<form id="frm_jogar" name="frm_jogar">
    <table id="tbl_concursos">
        <tr id="exibicao">
            <td id="col_exibicao">
                <input type="checkbox" name="exibir" id="exibir" onChange="megasena.ocultarExibirLinhas()"/>
                <label for="exibir">Ver só destaques</label>
            </td>
            <td id="col_quantificar_resultados">
                <input type="checkbox" name="quantificar_resultados" id="quantificar_resultados" onChange="megasena.quantificarDestaques()"/>
                <label for="quantificar_resultados">Ver qtd destaques</label>
            </td>
            <td id="col_notificacoes">
                <input type="checkbox" name="notificacoes" id="notificacoes" onChange="megasena.buscaNaColuna(this)" checked />
                <label for="notificacoes">Ver no console</label>
            </td>
            <td id="mais_sorteados"></td>
            <td id="mais_sorteados2" colspan="18"></td>
        </tr>
        <tr id="campos">
            <td id="col_concurso">
                <input type="text" maxlength="4" name="concurso" id="concurso" placeholder="Concurso" onKeyUp="megasena.buscaNaColuna(this)"/>
            </td>
            <td id="col_data_sorteio">
                <input type="text" maxlength="10" name="data_sorteio" id="data_sorteio" placeholder="Data" onKeyUp="megasena.buscaNaColuna(this)"/>
            </td>
            <td id="col_dezena1">
                <input type="text" maxlength="2" name="dezena1" id="dezena1" placeholder="Dezena1" onKeyUp="megasena.localizarDezenas()"/>
            </td>
            <td id="col_dezena2">
                <input type="text" maxlength="2" name="dezena2" id="dezena2" placeholder="Dezena2" onKeyUp="megasena.localizarDezenas()"/>
            </td>
            <td id="col_dezena3">
                <input type="text" maxlength="2" name="dezena3" id="dezena3" placeholder="Dezena3" onKeyUp="megasena.localizarDezenas()"/>
            </td>
            <td id="col_dezena4">
                <input type="text" maxlength="2" name="dezena4" id="dezena4" placeholder="Dezena4" onKeyUp="megasena.localizarDezenas()"/>
            </td>
            <td id="col_dezena5">
                <input type="text" maxlength="2" name="dezena5" id="dezena5" placeholder="Dezena5" onKeyUp="megasena.localizarDezenas()"/>
            </td>
            <td id="col_dezena6">
                <input type="text" maxlength="2" name="dezena6" id="dezena6" placeholder="Dezena6" onKeyUp="megasena.localizarDezenas()"/>
            </td>
            <td id="col_arrecadacao_total">
                <input type="text" maxlength="15" name="arrecadacao_total" id="arrecadacao_total" placeholder="Arrecadação" onKeyUp="megasena.buscaNaColuna(this)"/>
            </td>
            <td id="col_ganhadores_sena">
                <input type="text" maxlength="4" name="ganhadores_sena" id="ganhadores_sena" placeholder="Sena" onKeyUp="megasena.buscaNaColuna(this)"/>
            </td>
            <td id="col_cidade">
                <input type="text" maxlength="255" name="cidade" id="cidade" placeholder="Cidade" onKeyUp="megasena.buscaNaColuna(this)"/>
            </td>
            <td id="col_uf">
                <input type="text" maxlength="2" name="uf" id="uf" placeholder="UF" onKeyUp="megasena.buscaNaColuna(this)"/>
            </td>
            <td id="col_rateio_sena">
                <input type="text" maxlength="15" name="rateio_sena" id="rateio_sena" placeholder="Rateio" onKeyUp="megasena.buscaNaColuna(this)"/>
            </td>
            <td id="col_ganhadores_quina">
                <input type="text" maxlength="4" name="ganhadores_quina" id="ganhadores_quina" placeholder="Quina" onKeyUp="megasena.buscaNaColuna(this)"/>
            </td>
            <td id="col_rateio_quina">
                <input type="text" maxlength="15" name="rateio_quina" id="rateio_quina" placeholder="Rateio" onKeyUp="megasena.buscaNaColuna(this)"/>
            </td>
            <td id="col_ganhadores_quadra">
                <input type="text" maxlength="4" name="ganhadores_quadra" id="ganhadores_quadra" placeholder="Quadra" onKeyUp="megasena.buscaNaColuna(this)"/>
            </td>
            <td id="col_rateio_quadra">
                <input type="text" maxlength="15" name="rateio_quadra" id="rateio_quadra" placeholder="Rateio" onKeyUp="megasena.buscaNaColuna(this)"/>
            </td>
            <td id="col_acumulado">
                <input type="text" maxlength="3" name="acumulado" id="acumulado" placeholder="Acumulado" onKeyUp="megasena.buscaNaColuna(this)"/>
            </td>
            <td id="col_valor_acumulado">
                <input type="text" maxlength="15" name="valor_acumulado" id="valor_acumulado" placeholder="Valor" onKeyUp="megasena.buscaNaColuna(this)"/>
            </td>
            <td id="col_estimativa_premio">
                <input type="text" maxlength="15" name="estimativa_premio" id="estimativa_premio" placeholder="Estimativa" onKeyUp="megasena.buscaNaColuna(this)"/>
            </td>
            <td id="col_acumulado_megadavirada">
                <input type="text" maxlength="15" name="acumulado_megadavirada" id="acumulado_megadavirada" placeholder="MegaVirada" onKeyUp="megasena.buscaNaColuna(this)"/>
            </td>
        </tr>
        <tr id="buscas">
            <td id="col_busca_concurso">
                <input type="checkbox" name="busca_concurso" id="busca_concurso" onChange="megasena.buscaNaColuna(this)" checked/>
                <label for="busca_concurso">Exato?</label>
            </td>
            <td id="col_busca_data_sorteio">
                <input type="checkbox" name="busca_data_sorteio" id="busca_data_sorteio" onChange="megasena.buscaNaColuna(this)"/>
                <label for="busca_data_sorteio">Exato?</label>
            </td>
            <td id="col_busca_dezena1">
                <input type="checkbox" name="busca_dezena1" id="busca_dezena1" onChange="megasena.localizarDezenas()" checked/>
                <label for="busca_dezena1">Exato?</label>
            </td>
            <td id="col_busca_dezena2">
                <input type="checkbox" name="busca_dezena2" id="busca_dezena2" onChange="megasena.localizarDezenas()" checked/>
                <label for="busca_dezena2">Exato?</label>
            </td>
            <td id="col_busca_dezena3">
                <input type="checkbox" name="busca_dezena3" id="busca_dezena3" onChange="megasena.localizarDezenas()" checked/>
                <label for="busca_dezena3">Exato?</label>
            </td>
            <td id="col_busca_dezena4">
                <input type="checkbox" name="busca_dezena4" id="busca_dezena4" onChange="megasena.localizarDezenas()" checked/>
                <label for="busca_dezena4">Exato?</label>
            </td>
            <td id="col_busca_dezena5">
                <input type="checkbox" name="busca_dezena5" id="busca_dezena5" onChange="megasena.localizarDezenas()" checked/>
                <label for="busca_dezena5">Exato?</label>
            </td>
            <td id="col_busca_dezena6">
                <input type="checkbox" name="busca_dezena6" id="busca_dezena6" onChange="megasena.localizarDezenas()" checked/>
                <label for="busca_dezena6">Exato?</label>
            </td>
            <td id="col_busca_arrecadacao_total">
                <input type="checkbox" name="busca_arrecadacao_total" id="busca_arrecadacao_total" onChange="megasena.buscaNaColuna(this)"/>
                <label for="busca_arrecadacao_total">Exato?</label>
            </td>
            <td id="col_busca_ganhadores_sena">
                <input type="checkbox" name="busca_ganhadores_sena" id="busca_ganhadores_sena" onChange="megasena.buscaNaColuna(this)" checked/>
                <label for="busca_ganhadores_sena">Exato?</label>
            </td>
            <td id="col_busca_cidade">
                <input type="checkbox" name="busca_cidade" id="busca_cidade" onChange="megasena.buscaNaColuna(this)"/>
                <label for="busca_cidade">Exato?</label>
            </td>
            <td id="col_busca_uf">
                <input type="checkbox" name="busca_uf" id="busca_uf" onChange="megasena.buscaNaColuna(this)"/>
                <label for="busca_uf">Exato?</label>
            </td>
            <td id="col_busca_rateio_sena">
                <input type="checkbox" name="busca_rateio_sena" id="busca_rateio_sena" onChange="megasena.buscaNaColuna(this)"/>
                <label for="busca_rateio_sena">Exato?</label>
            </td>
            <td id="col_busca_ganhadores_quina">
                <input type="checkbox" name="busca_ganhadores_quina" id="busca_ganhadores_quina" onChange="megasena.buscaNaColuna(this)" checked/>
                <label for="busca_ganhadores_quina">Exato?</label>
            </td>
            <td id="col_busca_rateio_quina">
                <input type="checkbox" name="busca_rateio_quina" id="busca_rateio_quina" onChange="megasena.buscaNaColuna(this)"/>
                <label for="busca_rateio_quina">Exato?</label>
            </td>
            <td id="col_busca_ganhadores_quadra">
                <input type="checkbox" name="busca_ganhadores_quadra" id="busca_ganhadores_quadra" onChange="megasena.buscaNaColuna(this)" checked/>
                <label for="busca_ganhadores_quadra">Exato?</label>
            </td>
            <td id="col_busca_rateio_quadra">
                <input type="checkbox" name="busca_rateio_quadra" id="busca_rateio_quadra" onChange="megasena.buscaNaColuna(this)"/>
                <label for="busca_rateio_quadra">Exato?</label>
            </td>
            <td id="col_busca_acumulado">
                <input type="checkbox" name="busca_acumulado" id="busca_acumulado" onChange="megasena.buscaNaColuna(this)"/>
                <label for="busca_acumulado">Exato?</label>
            </td>
            <td id="col_busca_valor_acumulado">
                <input type="checkbox" name="busca_valor_acumulado" id="busca_valor_acumulado" onChange="megasena.buscaNaColuna(this)"/>
                <label for="busca_valor_acumulado">Exato?</label>
            </td>
            <td id="col_busca_estimativa_premio">
                <input type="checkbox" name="busca_estimativa_premio" id="busca_estimativa_premio" onChange="megasena.buscaNaColuna(this)"/>
                <label for="busca_estimativa_premio">Exato?</label>
            </td>
            <td id="col_busca_acumulado_megadavirada">
                <input type="checkbox" name="busca_acumulado_megadavirada" id="busca_acumulado_megadavirada" onChange="megasena.buscaNaColuna(this)"/>
                <label for="busca_acumulado_megadavirada">Exato?</label>
            </td>
        </tr>
        <tr id="espacamento">
            <td colspan="21" id="col_espaco">&nbsp;</td>
        </tr>
    <?php
        $txt_sql_concursos = "SELECT * FROM `$db`.`$tbl_concursos` ORDER BY `id` DESC;";
        // $txt_sql_concursos = "SELECT * FROM `$db`.`$tbl_concursos` ORDER BY `id` DESC LIMIT 10;";
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
                    break;
                }
            }

            $achou = "n";
            $dez2_tmp = 0;
            while ($achou == "n") {
                $dez2_tmp++;
                if (rand(1,60) == $dezena2) {
                    $achou = "s";
                    break;
                }
            }
            
            $achou = "n";
            $dez3_tmp = 0;
            while ($achou == "n") {
                $dez3_tmp++;
                if (rand(1,60) == $dezena3) {
                    $achou = "s";
                    break;
                }
            }
            
            $achou = "n";
            $dez4_tmp = 0;
            while ($achou == "n") {
                $dez4_tmp++;
                if (rand(1,60) == $dezena4) {
                    $achou = "s";
                    break;
                }
            }
            
            $achou = "n";
            $dez5_tmp = 0;
            while ($achou == "n") {
                $dez5_tmp++;
                if (rand(1,60) == $dezena5) {
                    $achou = "s";
                    break;
                }
            }
            
            $achou = "n";
            $dez6_tmp = 0;
            while ($achou == "n") {
                $dez6_tmp++;
                if (rand(1,60) == $dezena6) {
                    $achou = "s";
                    break;
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

        $mais_sorteados = "Mais Sorteadas:<br/>";
        $mais_sorteados2 = "Menos Sorteadas:<br/>";

        $d = 1;
        foreach ($sorteio as $dezenna => $key) {
            if ($d <= 6) {
                $mais_sorteados .= "<b title='$key x'>" . $dezenna . "</b> ";
            }
            if ($d > 6) {
                $mais_sorteados2 .= "<b title='$key x'>" . $dezenna . "</b> ";
            }
            $d++;
        }

        $sorteio_ordenado = $sorteio;

        ksort($sorteio_ordenado);

        $mais_sorteados3 = "Dezenas sorteadas em ordem crescente:\n | ";
        foreach ($sorteio_ordenado as $dezennas => $key) {
            $mais_sorteados3 .= $dezennas . " ($key x) ";
        }

    ?>

    <input type="hidden" id="todos_sorteios" name="todos_sorteios" value="<?php echo $mais_sorteados; ?>" />
    <input type="hidden" id="todos_sorteios2" name="todos_sorteios2" value="<?php echo $mais_sorteados2; ?>" />
    <input type="hidden" id="todos_sorteios3" name="todos_sorteios3" value="<?php echo $mais_sorteados3; ?>" />

</form>

<!-- Aqui contém a classe verify a qual cria todos os métodos utilizados no processamento de cada evento / digitação nos campos -->
<script>
    /**
     * @const esta declaração de variável define qualquer variável estática (imutável, uma vez atribuído um valor a ela, este não pode ser alterado) do ambiente/interface, não sendo possível ser atribuída função na mesma, não podendo ser declarada sem valor definido.
     * @var esta declaração de variável define qualquer variável (modificável) do ambiente/interface, podendo ser atribuída função na mesma, podendo ser declarada sem valor definido.
     * @let esta declaração de variável define qualquer variável que estiver dentro de um bloco qualquer (método, if, for, while, etc...), sendo a mesma removida da memória na finalização do respectivo bloco a qual estiver inserida, não sendo possível ser atribuída função nnesta declaração (let), podendo ser declarada sem valor definido.
     */

    /**
     * Aqui são definidas as variáveis estáticas do ambiente.
     */
    const tbl_concursos = document.getElementById('tbl_concursos'); // variável tabela concursos
    const linhas = tbl_concursos.getElementsByTagName('tr'); // variável linhas da tabela concurso
    const exibir = document.getElementById('exibir'); // variável identificador 'exibir'
    const quantificar_resultados = document.getElementById('quantificar_resultados'); // variável identificador 'quantificar_resultados'
    const notificacoes = document.getElementById('notificacoes'); // variável identificador notificacoes
    const linha_campos = document.getElementById("campos"); // variável que recebe a linha da tabela do indicador "campos"
    const colunas = linha_campos.getElementsByTagName("td"); // variável que recebe as células/colunas da variável linha_campos

    const input_dezena1 = document.getElementById("dezena1"); // variável que recebe o campo input dezena1
    const input_dezena2 = document.getElementById("dezena2"); // variável que recebe o campo input dezena2
    const input_dezena3 = document.getElementById("dezena3"); // variável que recebe o campo input dezena3
    const input_dezena4 = document.getElementById("dezena4"); // variável que recebe o campo input dezena4
    const input_dezena5 = document.getElementById("dezena5"); // variável que recebe o campo input dezena5
    const input_dezena6 = document.getElementById("dezena6"); // variável que recebe o campo input dezena6

    const exato_dezena1 = document.getElementById("busca_dezena1"); // variável que recebe o campo input dezena1
    const exato_dezena2 = document.getElementById("busca_dezena2"); // variável que recebe o campo input dezena2
    const exato_dezena3 = document.getElementById("busca_dezena3"); // variável que recebe o campo input dezena3
    const exato_dezena4 = document.getElementById("busca_dezena4"); // variável que recebe o campo input dezena4
    const exato_dezena5 = document.getElementById("busca_dezena5"); // variável que recebe o campo input dezena5
    const exato_dezena6 = document.getElementById("busca_dezena6"); // variável que recebe o campo input dezena6

    /**
     * Aqui são definidas as variáveis globais do ambiente.
     */
    var obj;
    var destacar_celulas = [];
    var destacar_celulas_coluna = [];

    /**
     * Aqui é definida a classe verify e métodos derivados
     */
    class verify {
        constructor (obj) {
            this.obj = obj;
        }

        /**
         * retorna o id do objeto
         * @obj
         */
        getObjId(obj) {
            return obj.id;
        }

        /**
         * retorna o nome do objeto
         * @obj
         */
        getObjName(obj) {
            return obj.name;
        }

        /**
         * retorna o valor do objeto
         * @obj
         */
        getObjValue(obj) {
            return (obj.value.trim()) ?? false; // Nullish Coalescing Operator (??)
        }

        /**
         * retorna as linhas de tabela tblObj
         * @tblObj
         */
        getTableRows(tblObj) {
            if (this.getTagName(tblObj) === 'table') { // valida antes se a tag do obj é table
                return tblObj.getElementsByTagName('tr');
            }
            return false; // retorna false no caso da tag do obj não ser table
        }

        /**
         * retorna o nome da tag do objeto em letras minúsculas
         * @obj
         */
        getTagName (obj) {
            return obj.tagName.toLowerCase();
        }

        /**
         * retorna verdadeiro se a tag do objeto for input
         * @obj
         */
        isInput(obj) {
            let objTagName = this.getTagName(obj); // getTagName retorna texto em minúsculo
            return (objTagName == "input") ? true : false;
        }

        /**
         * retorna o texto innerHTML de qualquer objeto em string
         * @obj
         */
        getInnerHTML(obj) {
            return obj.innerHTML.toString();
        }

        /**
         * retorna o texto do obj
         * @obj
         */
        getText (obj) {
            let objValue = this.getObjValue(obj);
            let objInnerHTML = this.getInnerHTML(obj);
            if (objValue) {
                return objValue;
            } else if (objInnerHTML) {
                return objInnerHTML;
            }
            return false;
        }

        /**
         * retorna o type (tipo) do obj em minúscula
         * @obj
         */
        getType(obj) {
            return obj.getAttribute('type').toLowerCase() ?? false;
        }

        /**
         * este método tem por objetivo remover todas as classe "destaque" de css
         */
        removerDestaques() {
            let linha_atual;
            let colunastmp;
            let coltmp;

            // este loop retira os destaques de todas as células antes de fazer a verificação completa
            for (var l = 4; l < linhas.length; l++) { // função que contabiliza as linhas dos sorteios
                linha_atual = document.getElementById(linhas[l].id); // variável que recebe o objeto da linha atual do marcador [l]
                if (linha_atual != null) { // função que valida se a linha atual não for nula
                    colunastmp = linha_atual.getElementsByTagName("td"); // variável que recebe temporariamente as células/colunas da linha atual do marcador [l]}
                    for (var col = 0; col < colunastmp.length; col++) { // função que contabiliza as células/colunas da linha do marcador [col] atual
                        coltmp = document.getElementById(colunastmp[col].id); // aqui seleciona a coluna atual da linha atual
                        if (coltmp.id.indexOf("dezena") > -1) {
                            coltmp.classList.remove("destaque");
                        }
                    }
                }
            }            
        }

        /**
         * este método tem por objetivo remover todas as classe "destaque" de css da respectiva coluna do obj atual
         */
        removerDestaquesColuna(obj) {
            let linha_tmp;
            let celula_tmp;
            let input_tmp = document.getElementById(obj.id);
            let colunas_tmp;

            if (this.getType(input_tmp) == "checkbox")  {
                input_tmp = document.getElementById(obj.id.replace("busca_",""));
            }

            // este loop retira os destaques de todas as células antes de fazer a verificação completa
            for (var l = 4; l < linhas.length; l++) { // função que contabiliza as linhas dos sorteios
                linha_tmp = document.getElementById(linhas[l].id); // variável que recebe o objeto da linha atual do marcador [l]
                if (linha_tmp != null) { // função que valida se a linha atual não for nula
                    colunas_tmp = linha_tmp.getElementsByTagName("td");
                    celula_tmp = document.getElementById(input_tmp.id + "_" + colunas_tmp[0].innerHTML); // variável que recebe temporariamente as células/colunas da linha atual do marcador [l]
                    celula_tmp.classList.remove("destaque");
                }
            }
        }

        /**
         * este método tem por objetivo adicionar em todas as células definidas na matriz estacar_celulas" a classe "destaque" de css
         */
        adicionarDestaques() {
            // este loop adiciona os destaques de todas as células inseridas na matriz "destacar_celulas"
            for (let d = 0; d < destacar_celulas.length; d++) { // função que contabiliza os índices da matriz "destacar_celulas"
                document.getElementById(destacar_celulas[d]).className = "destaque"; // aqui define a classe css "destaque" no índice da matriz "destacar_celulas" do marcador [d]
            }            
        }

        /**
         * este método tem por objetivo adicionar em todas as células definidas na matriz estacar_celulas" a classe "destaque" de css
         */
        adicionarDestaquesColuna() {
            // este loop adiciona os destaques de todas as células inseridas na matriz "destacar_celulas"
            for (let d = 0; d < destacar_celulas_coluna.length; d++) { // função que contabiliza os índices da matriz "destacar_celulas"
                document.getElementById(destacar_celulas_coluna[d]).className = "destaque"; // aqui define a classe css "destaque" no índice da matriz "destacar_celulas" do marcador [d]
            }            
        }

        /**
         * este método tem por objetivo exibir as linhas <tr> que tiverem alguma célula <td> com a classe css "destaque", no caso da opção "Exibir somente encontrados" estiver selecionada, consequentemente ocultando as linhas <tr> que tiverem todas as célula <td> que não tiverem a classe css "destaque".
         */
        ocultarExibirLinhas() {
            let achou_linha = "n"; // variável que identificará se outra variável achou for verdadeira
            let achou_destaque = "n";
            let linha_atual;
            let colunastmp;
            let coltmp;

            for (var l = 4; l < linhas.length; l++) { // função que contabiliza as linhas dos sorteios
                linha_atual = document.getElementById(linhas[l].id); // variável que recebe o objeto da linha atual do marcador [l]
                if (linha_atual != null) { // função que valida se a linha atual não for nula
                    linha_atual.style.display = "table-row"; // ação para exibir linha
                    colunastmp = linha_atual.getElementsByTagName("td"); // variável que recebe temporariamente as células/colunas da linha atual do marcador [l]}
                    achou_destaque = "n";
                    for (var col = 0; col < colunastmp.length; col++) { // função que contabiliza as células/colunas da linha do marcador [col] atual
                        coltmp = document.getElementById(colunastmp[col].id); // aqui seleciona a coluna atual da linha atual
                        if (coltmp.className == "destaque") {
                            achou_destaque = "s";
                        }
                    }
                    if (achou_destaque == "n" && exibir.checked == true && this.inputsVazios() == false) {
                        linha_atual.style.display = "none"; // ação para ocultar linha
                    }
                }
            }
        }

        /**
         * este método tem por objetivo localizar as 6 dezenas de acordo com o que estiver digitado nos campos Dezena1, Dezena2, Dezena3, Dezena4, Dezena5, e Dezena6.
         */
        localizarDezenas() {
            console.clear();

            let celula_dezena_tmp;
            let input_dezena_tmp;
            let exato_dezena_tmp;
            let posicao_encontrada_tmp;
            let linha_tmp;
            let str_celula_dezena_tmp;
            let str_input_dezena_tmp;
            let celula_concurso_tmp;
            let colunas_tmp;

            destacar_celulas = [];
            destacar_celulas.length = 0;

            for (let lin = 4; lin < linhas.length; lin++) { // loop que contabiliza as linhas dos sorteios do marcador [lin]
                linha_tmp = document.getElementById(linhas[lin].id); // variável que recebe o objeto da linha atual do marcador [lin]

                if (linha_tmp != null) { // função que valida se a linha atual não for nula
                    colunas_tmp = linha_tmp.getElementsByTagName("td");
                    celula_concurso_tmp = document.getElementById(colunas_tmp[0].id);

                    for (let dez = 1; dez <= 6; dez++) { // loop que contabiliza as 6 células/colunas da linha do marcador [dez]
                        celula_dezena_tmp = document.getElementById("dezena" + dez + "_" + celula_concurso_tmp.innerHTML); // variável que recebe o objeto da celula atual do marcador [dez] e do celula_concurso_tmp.innerHTML

                        for (let dez_tmp = 1; dez_tmp <= 6; dez_tmp++) { // loop que contabiliza os 6 campos/inputs do marcador [dez_tmp]

                            input_dezena_tmp = document.getElementById("dezena" + dez_tmp); // variável que recebe o objeto do campo/input da dezena temporária do marcador [dez_tmp]
                            exato_dezena_tmp = document.getElementById("busca_dezena" + dez_tmp); // variável que recebe o objeto do checkbox "exato" da dezena do marcador [dez_tmp]

                            if (input_dezena_tmp.value.trim() != "") { // valida se há algum caracter/valor digitado no campo/input da dezena temporária do marcador [dez_tmp]

                                if (exato_dezena_tmp.checked == true) { // valida se a opção do checkbox "exato" está selecionada da dezena do marcador [dez_tmp]

                                    if (input_dezena_tmp.value.trim() == celula_dezena_tmp.innerHTML.trim()) { // valida se o valor digitado no input temporário é exatamente igual à célula de dezena do marcador [dez_tmp]
                                        if (destacar_celulas.findIndex((element) => element == celula_dezena_tmp.id) < 0) { // valida se não encontrou algum id de célula já adicionado no índice da matriz "destacar_celulas"
                                            destacar_celulas.push(celula_dezena_tmp.id); // adiciona o id da célula no índice da matriz "destacar_celulas"
                                        }
                                    }
                                } else { // valida se a opção do checkbox "exato" NÃO está selecionada da dezena do marcador [dez_tmp]
                                    str_celula_dezena_tmp = celula_dezena_tmp.innerHTML.toString().trim();
                                    str_input_dezena_tmp = input_dezena_tmp.value.toString().trim();
                                    posicao_encontrada_tmp = str_celula_dezena_tmp.indexOf(str_input_dezena_tmp, -7);
                                    if (posicao_encontrada_tmp >= 0) {
                                        if (destacar_celulas.findIndex((element) => element == celula_dezena_tmp.id) < 0) { // valida se não encontrou algum id de célula já adicionado no índice da matriz "destacar_celulas"
                                            destacar_celulas.push(celula_dezena_tmp.id); // adiciona o id da célula no índice da matriz "destacar_celulas"
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            this.removerDestaques();
            this.adicionarDestaques();
            this.ocultarExibirLinhas();
            this.buscaSena();
            this.buscaQuina();
            this.buscaQuadra();
            this.quantificarDestaques();
        }

        /**
         * Este método tem por finalidade identificar todos os inputs da linha #campos e retornar true se todos os campos estiverem vazios
         */
        inputsVazios() {
            let input_vazio = true;
            let input_tmp;

            for (let i = 0; i < colunas.length; i++) {
                input_tmp = colunas[i].getElementsByTagName("input")[0];
                if (input_tmp && input_tmp.value.trim() != "") {
                    input_vazio = false;
                }
            }
            return input_vazio;
        }

        /**
         * Este método tem por finalidade buscar o valor digitado na coluna respectiva
         */
        buscaNaColuna(obj) {
            console.clear();
            destacar_celulas_coluna = [];
            destacar_celulas_coluna.length = 0;

            let input_tmp = document.getElementById(obj.id);
            if (this.getType(input_tmp) == "checkbox")  {
                input_tmp = document.getElementById(obj.id.replace("busca_",""));
            }

            if (this.getTagName(input_tmp) == "input" && input_tmp.value.trim() != "") {
                let celula_concurso_tmp;
                let colunas_tmp;
                let linha_tmp;
                let celula_tmp;
                let str_celula_tmp;
                let str_input_tmp;
                let posicao_encontrada_tmp;
                let exato_tmp = document.getElementById("busca_" + obj.id); // variável que recebe o objeto do checkbox "exato" do respectivo campo/coluna
                if (this.getType(obj) == "checkbox") {
                    exato_tmp = document.getElementById(obj.id); // variável que recebe o objeto do checkbox "exato" do respectivo campo/coluna
                }

                for (let lin = 4; lin < linhas.length; lin++) { // loop que contabiliza as linhas dos sorteios do marcador [lin]
                    linha_tmp = document.getElementById(linhas[lin].id); // variável que recebe o objeto da linha atual do marcador [lin]
                    colunas_tmp = linha_tmp.getElementsByTagName("td");
                    celula_concurso_tmp = document.getElementById(colunas_tmp[0].id);

                    if (linha_tmp != null && input_tmp.value.trim() != "") { // função que valida se a linha atual não for nula
                        celula_tmp = document.getElementById(input_tmp.id + "_" + celula_concurso_tmp.innerHTML); // variável que recebe o objeto da celula atual do celula_concurso_tmp.innerHTML

                        if (exato_tmp.checked == true) { // valida se a opção do checkbox "exato" está selecionada da dezena do marcador [dez_tmp]
                            if (input_tmp.value.trim() == celula_tmp.innerHTML.trim()) { // valida se o valor digitado no input temporário é exatamente igual à célula de dezena do marcador [dez_tmp]
                                if (destacar_celulas_coluna.findIndex((element) => element == celula_tmp.id) < 0) { // valida se não encontrou algum id de célula já adicionado no índice da matriz "destacar_celulas_coluna"
                                    destacar_celulas_coluna.push(celula_tmp.id); // adiciona o id da célula no índice da matriz "destacar_celulas_coluna"
                                }
                            }
                        } else { // valida se a opção do checkbox "exato" NÃO está selecionada do respectivo campo/coluna
                            str_celula_tmp = celula_tmp.innerHTML.toString().trim();
                            str_input_tmp = input_tmp.value.toString().trim();
                            posicao_encontrada_tmp = str_celula_tmp.indexOf(str_input_tmp, -7);
                            if (posicao_encontrada_tmp >= 0) {
                                if (destacar_celulas_coluna.findIndex((element) => element == celula_tmp.id) < 0) { // valida se não encontrou algum id de célula já adicionado no índice da matriz "destacar_celulas_coluna"
                                    destacar_celulas_coluna.push(celula_tmp.id); // adiciona o id da célula no índice da matriz "destacar_celulas_coluna"
                                }
                            }
                        }
                    }
                }
            }

            this.removerDestaquesColuna(obj);
            this.adicionarDestaquesColuna();
            this.ocultarExibirLinhas();
            this.quantificarDestaques();
        }

        /**
         * Este método tem por finalidade buscar o sorteio de sena, conforme 6 dezenas digitadas ou encontradas
         */
        buscaSena() {
            let linha_tmp;
            let celula_dezena1_tmp;
            let celula_dezena2_tmp;
            let celula_dezena3_tmp;
            let celula_dezena4_tmp;
            let celula_dezena5_tmp;
            let celula_dezena6_tmp;
            let celulas_tmp = [];
            let dezenas = [];
            let celula_concurso_tmp;
            let colunas_tmp;

            for (let lin = 4; lin < linhas.length; lin++) { // loop que contabiliza as linhas dos sorteios do marcador [lin]
                linha_tmp = document.getElementById(linhas[lin].id); // variável que recebe o objeto da linha atual do marcador [lin]

                if (linha_tmp != null) {
                    colunas_tmp = linha_tmp.getElementsByTagName("td");
                    celula_concurso_tmp = document.getElementById(colunas_tmp[0].id);
                    celula_dezena1_tmp = document.getElementById("dezena1_" + celula_concurso_tmp.innerHTML);
                    celula_dezena2_tmp = document.getElementById("dezena2_" + celula_concurso_tmp.innerHTML);
                    celula_dezena3_tmp = document.getElementById("dezena3_" + celula_concurso_tmp.innerHTML);
                    celula_dezena4_tmp = document.getElementById("dezena4_" + celula_concurso_tmp.innerHTML);
                    celula_dezena5_tmp = document.getElementById("dezena5_" + celula_concurso_tmp.innerHTML);
                    celula_dezena6_tmp = document.getElementById("dezena6_" + celula_concurso_tmp.innerHTML);

                    if (celula_dezena1_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena1_tmp.id);
                        dezenas.push(celula_dezena1_tmp.innerHTML);
                    }
                    if (celula_dezena2_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena2_tmp.id);
                        dezenas.push(celula_dezena2_tmp.innerHTML);
                    }
                    if (celula_dezena3_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena3_tmp.id);
                        dezenas.push(celula_dezena3_tmp.innerHTML);
                    }
                    if (celula_dezena4_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena4_tmp.id);
                        dezenas.push(celula_dezena4_tmp.innerHTML);
                    }
                    if (celula_dezena5_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena5_tmp.id);
                        dezenas.push(celula_dezena5_tmp.innerHTML);
                    }
                    if (celula_dezena6_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena6_tmp.id);
                        dezenas.push(celula_dezena6_tmp.innerHTML);
                    }

                    if (celulas_tmp.length == 6) {
                        console.log("Achou sena (" + dezenas.toString() + ") no concurso " + celula_concurso_tmp.innerHTML);
                    }

                    celulas_tmp = [];
                    celulas_tmp.length = 0;
                    dezenas = [];
                    dezenas.length = 0;
                }
            }
        }

        /**
         * Este método tem por finalidade buscar o sorteio de quina, conforme 5 dezenas digitadas ou encontradas
         */
        buscaQuina() {
            let linha_tmp;
            let celula_dezena1_tmp;
            let celula_dezena2_tmp;
            let celula_dezena3_tmp;
            let celula_dezena4_tmp;
            let celula_dezena5_tmp;
            let celula_dezena6_tmp;
            let celulas_tmp = [];
            let dezenas = [];
            let celula_concurso_tmp;
            let colunas_tmp;

            for (let lin = 4; lin < linhas.length; lin++) { // loop que contabiliza as linhas dos sorteios do marcador [lin]
                linha_tmp = document.getElementById(linhas[lin].id); // variável que recebe o objeto da linha atual do marcador [lin]
                if (linha_tmp != null) {
                    colunas_tmp = linha_tmp.getElementsByTagName("td");
                    celula_concurso_tmp = document.getElementById(colunas_tmp[0].id);
                    celula_dezena1_tmp = document.getElementById("dezena1_" + celula_concurso_tmp.innerHTML);
                    celula_dezena2_tmp = document.getElementById("dezena2_" + celula_concurso_tmp.innerHTML);
                    celula_dezena3_tmp = document.getElementById("dezena3_" + celula_concurso_tmp.innerHTML);
                    celula_dezena4_tmp = document.getElementById("dezena4_" + celula_concurso_tmp.innerHTML);
                    celula_dezena5_tmp = document.getElementById("dezena5_" + celula_concurso_tmp.innerHTML);
                    celula_dezena6_tmp = document.getElementById("dezena6_" + celula_concurso_tmp.innerHTML);

                    if (celula_dezena1_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena1_tmp.id);
                        dezenas.push(celula_dezena1_tmp.innerHTML);
                    }
                    if (celula_dezena2_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena2_tmp.id);
                        dezenas.push(celula_dezena2_tmp.innerHTML);
                    }
                    if (celula_dezena3_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena3_tmp.id);
                        dezenas.push(celula_dezena3_tmp.innerHTML);
                    }
                    if (celula_dezena4_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena4_tmp.id);
                        dezenas.push(celula_dezena4_tmp.innerHTML);
                    }
                    if (celula_dezena5_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena5_tmp.id);
                        dezenas.push(celula_dezena5_tmp.innerHTML);
                    }
                    if (celula_dezena6_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena6_tmp.id);
                        dezenas.push(celula_dezena6_tmp.innerHTML);
                    }

                    if (celulas_tmp.length == 5) {
                        console.log("Achou quina (" + dezenas.toString() + ") no concurso " + celula_concurso_tmp.innerHTML);
                    }

                    celulas_tmp = [];
                    celulas_tmp.length = 0;
                    dezenas = [];
                    dezenas.length = 0;
                }
            }
        }

        /**
         * Este método tem por finalidade buscar o sorteio de quadra, conforme 4 dezenas digitadas ou encontradas
         */
        buscaQuadra() {
            let linha_tmp;
            let celula_dezena1_tmp;
            let celula_dezena2_tmp;
            let celula_dezena3_tmp;
            let celula_dezena4_tmp;
            let celula_dezena5_tmp;
            let celula_dezena6_tmp;
            let celulas_tmp = [];
            let dezenas = [];
            let celula_concurso_tmp;
            let colunas_tmp;

            for (let lin = 4; lin < linhas.length; lin++) { // loop que contabiliza as linhas dos sorteios do marcador [lin]
                linha_tmp = document.getElementById(linhas[lin].id); // variável que recebe o objeto da linha atual do marcador [lin]
                if (linha_tmp != null) {
                    colunas_tmp = linha_tmp.getElementsByTagName("td");
                    celula_concurso_tmp = document.getElementById(colunas_tmp[0].id);
                    celula_dezena1_tmp = document.getElementById("dezena1_" + celula_concurso_tmp.innerHTML);
                    celula_dezena2_tmp = document.getElementById("dezena2_" + celula_concurso_tmp.innerHTML);
                    celula_dezena3_tmp = document.getElementById("dezena3_" + celula_concurso_tmp.innerHTML);
                    celula_dezena4_tmp = document.getElementById("dezena4_" + celula_concurso_tmp.innerHTML);
                    celula_dezena5_tmp = document.getElementById("dezena5_" + celula_concurso_tmp.innerHTML);
                    celula_dezena6_tmp = document.getElementById("dezena6_" + celula_concurso_tmp.innerHTML);

                    if (celula_dezena1_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena1_tmp.id);
                        dezenas.push(celula_dezena1_tmp.innerHTML);
                    }
                    if (celula_dezena2_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena2_tmp.id);
                        dezenas.push(celula_dezena2_tmp.innerHTML);
                    }
                    if (celula_dezena3_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena3_tmp.id);
                        dezenas.push(celula_dezena3_tmp.innerHTML);
                    }
                    if (celula_dezena4_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena4_tmp.id);
                        dezenas.push(celula_dezena4_tmp.innerHTML);
                    }
                    if (celula_dezena5_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena5_tmp.id);
                        dezenas.push(celula_dezena5_tmp.innerHTML);
                    }
                    if (celula_dezena6_tmp.classList.contains("destaque") == true) {
                        celulas_tmp.push(celula_dezena6_tmp.id);
                        dezenas.push(celula_dezena6_tmp.innerHTML);
                    }

                    if (celulas_tmp.length == 4) {
                        console.log("Achou quadra (" + dezenas.toString() + ") no concurso " + celula_concurso_tmp.innerHTML);
                    }

                    celulas_tmp = [];
                    celulas_tmp.length = 0;
                    dezenas = [];
                    dezenas.length = 0;
                }
            }
        }

        /**
         * Este método tem por finalidade exibir no console.log a quantidade de células destacadas
         */
        quantificarDestaques() {
            let class_destaques = document.getElementsByClassName("destaque");
            if (quantificar_resultados.checked == true && class_destaques.length > 0) {
                console.log("Foram encontradas " + class_destaques.length + " células destacadas.");
            }
        }
    }

    /**
     * esta variável estática "megasena" recebe a classe "verify", que por sua vez atribui todos os métodos derivados da mesma classe, desta forma iniciando a chamada da classe "verify" para uso em todas as tags <> (objetos DOM) desta página
     */
    const megasena = new verify(obj);

    document.getElementById("mais_sorteados").innerHTML = document.getElementById("todos_sorteios").value.trim();
    document.getElementById("mais_sorteados2").innerHTML = document.getElementById("todos_sorteios2").value.trim();
    document.getElementById("mais_sorteados2").title = document.getElementById("todos_sorteios3").value.trim();

    window.history.pushState("object or string", "Title", "/?a=" + parseInt(Math.random() * 9999));
</script>
</body>
</html>