<?php

//Incluindo o arquivo integracao_nova_capa.api.inc
module_load_include('inc', 'integracao_nova_capa', 'integracao_nova_capa.api');

//Funcao que vai retornar um json com as noticias
function getNoticias() {

    $numeroDeItens = (isset($_POST['numeroDeItens']) && !empty($_POST['numeroDeItens'])) ? $_POST['numeroDeItens'] : 100;
    $caderno = (isset($_POST['caderno']) && !empty($_POST['caderno'])) ? $_POST['caderno'] : 'all';

    $json = api_getNoticias($numeroDeItens, $caderno);

    //Declarando quem vai ter acesso a requisicao
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Credentials: true");

    print $json;
    die;
}

//Funcao que vai gerar os jsons para o mobile
function gerarJson() {

    $json = api_gerarJson();
}

//Funcao que vai retornar um json com a noticia montada para capa
function montarNoticia() {

    $nid = $_POST['nid'];

    $json = api_montarNoticia($nid);

    //Declarando quem vai ter acesso a requisicao
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Credentials: true");

    print $json;
    die;
}

//Função que vai cropar a imagem e retornar a url
function imageCropCapa() {

    $arrCrop = $_POST;

    //Declarando quem vai ter acesso a requisicao
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Credentials: true");
    $urlImg = api_imageCrop($arrCrop);
    print json_encode($urlImg);
    die;
}

//Função que vai cropar a imagem e retornar a url
function novaImagem() {

    //Declarando quem vai ter acesso a requisicao
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Credentials: true");

    $urlImg = api_novaImagem($_FILES['SelectedFile']);
    print $urlImg;
    die;
}

//Função que vai cropar a imagem e retornar a url
function destroiImagem() {
    $fileUrl = $_POST['fileUrl'];
    //Declarando quem vai ter acesso a requisicao
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Credentials: true");

    $retorno = api_destroiImagem($fileUrl);

    print json_encode($retorno);
    die;
}

//Função que vai Salvar o historico de capa e o json no banco
function salvarCapa() {

    //Declarando quem vai ter acesso a requisicao
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Credentials: true");

    $output = api_salvarCapa($_POST);

    print json_encode($output);
    die;
}

//Função que vai atualizar a capa
function atualizarCapa() {

    //Declarando quem vai ter acesso a requisicao
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Credentials: true");

    $output = api_atualizarCapa($_POST);

    print json_encode($output);
    die;
}

//Função que vai deletar a capa
function deletarCapa() {

    $output = api_deletarCapa($_POST);

    print json_encode($output);
    die;
}

//Função que vai listar as capas
function listarCapa() {

    $output = api_listarCapa();

    print json_encode($output);
    die;
}

function capaBase() {
    include_once drupal_get_path('theme', 'leiaja2') . "/templates/template_admin_capa.tpl.php";
    die;
}

//Função do preview da capa
function previewCapa() {

    //Declarando quem vai ter acesso a requisicao
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Credentials: true");

    $output = api_previewCapa($_POST['html']);
    print json_encode($output);
}

//Função que vai retornar a matriz da capa ativa
function getMatriz($cid) {

    //Declarando quem vai ter acesso a requisicao
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Credentials: true");

    $output = api_getMatriz($cid);

    return json_encode($output);
    die;
}

//Função que vai retornar o tipo do caderno
function getCaderno($caderno) {

    $output = api_getCaderno($caderno);

    return $output;
}

//Função que vai duplicar a capa
function duplicarCapa() {

    //Declarando quem vai ter acesso a requisicao
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Credentials: true");

    $output = api_duplicarCapa($_POST);
    print $output;
    die;
}
