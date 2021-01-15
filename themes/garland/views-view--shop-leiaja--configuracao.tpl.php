<?php

/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */

//Variavel que armazena se a exucução foi realizada com sucesso
$boolRetorno = false;
//Menssagem de sucesso ou erro
$strMensagem = "O conteúdo foi salvo com sucesso.";

//Verificando se a variavel existe
if(variable_get("bloco_shop") == NULL || variable_get("bloco_shop") == ""){
    //Caso ela n exista, atribui o valor padrao falso
    variable_set("bloco_shop", "Shop LeiaJá");
}

//Verifica se algo foi postado
if($_POST){
    try{
        //verifica se o campo de texto está vazio
        if(!empty($_POST["strTexto"])){
            //Atribui o valor do campo texo a variavel
            variable_set("bloco_shop", $_POST["strTexto"]);
        }else{
            //Caso ela n exista, atribui o valor padrao falso
            variable_set("bloco_shop", "Shop LeiaJá");
        }
        
        
        $boolRetorno = true;
    }catch (Exception $exc){
        //Recupera a mensagem de erro caso alguma coisa saia errado
        $strMensagem = $exc->getMessage();
    }
    
    if($boolRetorno){
        print '<div class="messages status">
                <h2 class="element-invisible">Mensagem de status</h2>
                ' . $strMensagem . '</div>';
    }else{
         print '<div class="messages error">
                <h2 class="element-invisible">Mensagem de status</h2>
                ' . $strMensagem . '</div>';
    }
    
}

?>
<form action="" method="POST">
    <label for="texto">
        Digite o Texto para a label do shop
        <input type="text" id="texto" name="strTexto" value="<?= (variable_get("bloco_shop")) ? variable_get("bloco_shop") : "" ?>" maxlength="21" size="30"/>
    </label>
    
    <input type="submit" id="enviar" name="enviar" value="Confirmar" />
</form>
