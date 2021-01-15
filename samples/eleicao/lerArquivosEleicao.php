<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// Recuperando os parametros postados
$intCenarioAtual      = 1;    // (int) @$_POST["intQtdCenario"];
$intPesquisa          = 9;    // (int) @$_POST["intPesquisa"];
$strNomeArquivo       = (@$_POST["strNomeArquivo"]) ? @$_POST["strNomeArquivo"] : "c";
$strTituloGrafico     = (string) (@$_POST["strTituloGrafico"]) ? @$_POST["strTituloGrafico"] : "Pesquisa Satisfação";
$strSubTituloGrafico  = (string) (@$_POST["strSubTituloGrafico"]) ? @$_POST["strSubTituloGrafico"] : "Pesquisa Satisfação";

// Criando array que receberá os valores
$arrCenarioPesquisaGrafico = array();

// Criando variável que recebera o status de letura do array
$bolLeitura = false;

// setando a pesquisa
$intPesquisaAtual = 1;

// percorrendo a qtd de pesauisa
while($intPesquisaAtual <= $intPesquisa){
  try {
      // Arquivo a ser aberto
      $strArquivo = "csv/c" . $intCenarioAtual . $intPesquisaAtual . ".csv";

      // Validando o arquivo
      if(!file_exists($strArquivo)) throw new Exception ("Erro: O arquivo procurado não existe: " . $strArquivo);

      // Abrindo o arquivo pela pesquisa atual
      $arrArquivo = file($strArquivo);

      foreach($arrArquivo as $intChave => $strLinha){
        // Explodindo a linha
        $arrLinha = explode(";", $strLinha);
          // Caso a linha contenha a palavra base inicia a leitura
          if(trim($arrLinha[0]) == "BASE"){
            $bolLeitura = true;
            continue;
          }

          if($bolLeitura){
              $arrCenarioPesquisaGrafico[$intPesquisaAtual][$arrLinha[0]] = (float) str_replace(",", ".", $arrLinha[1]);
          }

          // Caso a linha contenha a palavra NS/NR finalisa a leitura
          if(trim($arrLinha[0]) == "NS/NR"){
            $bolLeitura = false;
            break;
          }
      }
  } catch (Exception $exc) {  }
  // Decrementando o valor da pesquisa
  $intPesquisaAtual++;
}

$arrArrCandidato = array();
foreach($arrCenarioPesquisaGrafico as $intPesquisa => $arrPesquisaGrafico){
    // Percorrendo o array do candidato
    foreach($arrPesquisaGrafico as $strNomeCandidato => $floPorcentagem){
        $arrArrCandidato[$strNomeCandidato][$intPesquisa] = $floPorcentagem;
   }
}

?>
		
<!-- 1. Add these JavaScript inclusions in the head of your page -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="text/javascript" src="js/highcharts.js"></script>

<script type="text/javascript" src="js/modules/exporting.js"></script>

<script type="text/javascript">

var chart;
$(document).ready(function() {
 
// váriavel que conterá o objeto chart
chart = new Highcharts.Chart({
        chart: {
                renderTo: 'container',
                defaultSeriesType: 'line',
                marginRight: 130,
                marginBottom: 25
        },
        title: {
                text: '<?= utf8_decode($strTituloGrafico) ?>',
                x: -20 //center
        },
        subtitle: {
                text: '<?= utf8_decode($strSubTituloGrafico) ?>',
                x: -20
        },
        xAxis: {
                categories: [
                    <?php
                          $strPesquisa = "";
                          $intPesquisaAtual = 1;
                          while($intPesquisaAtual <= $intPesquisa){
                            $strPesquisa .= "'Pesquisa " . $intPesquisaAtual . "',";
                            $intPesquisaAtual++;
                          }
                          echo substr($strPesquisa, 0, -1);
                    ?>
                ]
        },
        yAxis: {
                title: {
                        text: 'Percentual'
                },
                plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                }]
        },
        tooltip: {
                formatter: function() {
                return '<b>' + this.series.name + '</b><br/>' + this.x + ': '+ this.y + ' %';
                }
        },
        legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
        },
        series: [

          <?php
            // String que contera os dados do grafico
            $strDadosGrafico = "";

            // Realizando a interação pra pegar os candidatos
            foreach($arrArrCandidato as $strNomeCandidato => $arrCandidato){
                // variável que receberá os dados
                $strDados = "[";

                // Caso o candidato não tenha participado de alguma pesquisa
                if(count($arrCandidato) < $intPesquisa){
                      // Realizando um for para cada pequisa
                      for($intI = 1; $intI <= $intPesquisa; $intI++){
                        // Se o usuário participou dessa pesquisa
                        if(isset($arrCandidato[$intI]))
                          $strDados .= $arrCandidato[$intI] . ",";
                        else// se não
                          $strDados .= "null,";
                      }
                  }else{
                    // se o candidato tenha participado de todas as pesquisas
                    foreach($arrCandidato as $key => $floPorcentagem){
                      $strDados .= $floPorcentagem . ",";
                    }
                }

                // Pegando o nome do candidato
                $strNomeCandidato = $strNomeCandidato;

                // Pegando os dados acessiado a ele
                $strDados = substr($strDados, 0, -1) . "]";

                // Concatenando os valores do gráfico
                $strDadosGrafico .= "{
                                      name: ' $strNomeCandidato',
                                      data: $strDados
                                      }," ; 
            }
            // Exibindo os dados para o gráfico
            echo substr($strDadosGrafico, 0, -1);
          ?>
           ]
});
});
</script>
<!-- 3. Add the container -->
<div id="container" style="width: 600px; height: 400px; margin: 0 auto"></div>