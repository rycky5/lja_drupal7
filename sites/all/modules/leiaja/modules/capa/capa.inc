<?php
/**
 * Arquivo que conterá as requisições de callback do modulo
 * 
 * @author Alberto Medeiros
 */
define('PATH_COBERTURA', $_SERVER['DOCUMENT_ROOT'].'/sites/default/files/cobertura/');

/**
 * Bloco criado via módulo
 * 
 * @return Thema
 */

module_load_include('inc', 'capa', 'capa.api');

/**
 * 
 */
//interface para obter o html dos blocos a serem usados nas tpl  
function getTemaBloco($arrObj, $nomeTema, $qtde){
  $strHtml = getHtmlBloco($arrObj,$nomeTema,$qtde);
  return $strHtml;
}

function get_nodes_viewsTt($variaveis)
{  
  $arrObjNodes  = getViewCacheTt($variaveis);
  return api_view_block($arrObjNodes,$variaveis);
}

//interface para obter as views do cahce ou setar os resultados em cache
function get_nodes_views($nomeView, $nomeDisplay = NULL)
{ 
  $var['viewname']  = $nomeView;
  if(!empty($nomeDisplay)){$var['view_dispaly'] = $nomeDisplay;}
  $result  = getViews($var);

  return $result;
}

function montagem_capa(){
  
  // Recuperando as capas que podem ser configuradas
  $arrObjCapa = api_get_capa();
  $arrObjBloco = api_list_blocks();
  
  
  $arrVars = array();
  $arrVars["arrObjCapa"] = $arrObjCapa;
  $arrVars["arrObjBloco"] = $arrObjBloco;
  
  
  // Retornando o thema
  return theme("montagem-capa", $arrVars);
  
} 

/**
 * Método que irá realizar a leitura e exibição do bloco informado
 * 
 * @return HTML
 */
function carrega_bloco(){
//  echo '<link rel="stylesheet" type="text/css" href="'.base_path().drupal_get_path("theme", "leiaja").'/css/estilo.css"/>';
//  echo '<link rel="stylesheet" type="text/css" href="'. base_path().drupal_get_path('theme', 'multimidia') .'/css/multimedia.css"/>' ;
  
  // Recuperando os dados do bloco
  $strDelta = (!empty ($_POST["strDelta"])) ? $_POST["strDelta"] : $_GET["strDelta"];
  $strModulo = (!empty ($_POST["strModulo"])) ? $_POST["strModulo"] : 'block';
  
  // Lendo o blocos
  $vBlocos[] = block_load($strModulo,$strDelta);
  
  // Renderizando o bloco
  print render(_block_get_renderable_array(_block_render_blocks($vBlocos)));
  die("aqui karai");
}

/**
 * Método que irá salvar as posições dos blocos no evento de salvar a capa
 * 
 * @return JSON
 */
function salvar_capa(){
  $strMensagem = "Cadastrado com sucesso!";
  $bolRetorno = false;
  
  // Verifico se há alguma postagem pra esta página
  if(!empty ($_POST)){
    // Iniciando uma transação
    $objTransacao = db_transaction();
    try {
      // Criando o array que irá ser passado por parametro
      $arrDados = array();
      $arrDados["arrDadosCapa"] = @$_POST["arrDadosCapa"];
      $arrDados["intIdCapa"]    = (int) @$_POST["intIdCapa"];
      
      api_salvar_capa($arrDados);
      
      $bolRetorno = true;
    } catch (Exception $exc) {
      $objTransacao->rollback();
      $strMensagem =  $exc->getMessage();
      die($strMensagem);
    }
      
  }else{
    $strMensagem = "Nenhuma postagem foi feita pra esta página";
  }
  
  // Criando meu array de retorno
  $arrRetorno = array();
  $arrRetorno["strMensagem"] = $strMensagem;
  $arrRetorno["bolRetorno"] = $bolRetorno;
  
  // Retornando via json
  echo json_encode($arrRetorno);die;
}

function carregar_capa(){
  if(!empty ($_POST)){
    // Setando o identificador da capa
    $intIdCapa = (int) $_POST["intIdCapa"];
    
    try {
        // Listando os blocos pra cada informada
        $arrObjPosicao = api_listar_blocos_por_capa($intIdCapa);
        
        // Percorrendo o array de porições
        foreach($arrObjPosicao as $intPosicao => $objPosicao){
          // Invocando o bloco
          $arrContent =module_invoke($objPosicao->entidade_pai, "block_view", $objPosicao->delta);
          
        ?>
             <li class="noticiaAutomatica cinza noticiaTodos montagemCapa <?= $objPosicao->entidade_pai ?>" rel_delta="<?= $objPosicao->delta ?>" rel_module="<?= $objPosicao->entidade_pai ?>">
                <?php 
                    // Renderizando o bloco
                    print $arrContent['content'];
                ?>
             </li>
        <?php
        }
    } catch (Exception $exc) {
      echo $exc->getMessage();
    }
  }
}
function upload_cobertura(){
  
  if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
        //setando os arquivos permitidos para fazer upload.
        $arrExt = array('jpg','png','gif');
        //verificando o nome do arquivo;
        $strNomeArq = $_FILES['Filedata']["name"];
        //retornando a extensão do arquivo uploadeado;
        $extensao =  strtolower(pathinfo($strNomeArq, PATHINFO_EXTENSION));
        //verificando qual o tipo do arquivo:::
        if(in_array($extensao, $arrExt)):
            // Criando o novo nome do arquivo
            $strNomeArquivo = md5($_FILES['Filedata']['name'] . date("Y-m-d_H:i:s")).".{$extensao}";

            $targetFile =  str_replace('//','/',PATH_COBERTURA) . $strNomeArquivo;

            // Movendo o arquivo
            move_uploaded_file($tempFile,$targetFile);

            // Retornando via json
            echo $strNomeArquivo;
          else:
              echo "erro";
          endif;
  }
}