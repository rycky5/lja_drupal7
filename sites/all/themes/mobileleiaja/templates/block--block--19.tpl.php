<?php
//PODCAST

// $Id: block.tpl.php,v 1.10 2010/04/26 14:10:40 dries Exp $

/**
 * @file
 * Default theme implementation to display a block.
 *
 * Available variables:
 * - $block->subject: Block title.
 * - $content: Block content.
 * - $block->module: Module that generated the block.
 * - $block->delta: An ID for the block, unique within each module.
 * - $block->region: The block region embedding the current block.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - block: The current template type, i.e., "theming hook".
 *   - block-[module]: The module generating the block. For example, the user module
 *     is responsible for handling the default user navigation block. In that case
 *     the class would be "block-user".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $block_id: Counter dependent on each block region.
 * - $id: Same output as $block_id but independent of any block region.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $block_html_id: A valid HTML ID and guaranteed unique.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 */
?>
  <div class='view podcast' id='multimidia'>
        	<h1 class='cabecalho2'><span>Multimídia</span></h1>
            <div class='principal'>
                <p class='titulo'><?=$destaque[0]->title;?></p>
            	<p class='foto'><img alt='<?=$destaque[0]->title;?>' src='<?= base_path().drupal_get_path('theme', 'mobileleiaja').'/'?>images/podcast.jpg'></p>
                <p class='fonte'><b>Agência Estado</b> | ter, 12/07/2011 - 16:10</p>
                <p class='chamada'><em>Para Alex Zornig, diretor financeiro da Oi - que aceitou oferta de equipamentos de rede da Huawei -, chineses estão ocupando espaço dos norte-americanos e europeus</em></p>
            </div>
        	<h1 class='cabecalho2'><span>Podcasts relacionados</span></h1>
            <ul class='ul'>
              <?foreach($lista AS $key => $value){?>
            	<li class='odd'><a href='#'>Prazeres da Mesa: O maior evento gastronômico de Recife - Cobertura ao vivo </a></li>
              <?}?>
                <!--
            	<li class='even'><a href='#'>Thiago Galvão faz ensaio sensual com bombeiros no Paparazzo.</a></li>
            	<li class='odd'><a href='#'>Prazeres da Mesa: O maior evento gastronômico de Recife - Cobertura ao vivo </a></li>
            	<li class='even'><a href='#'>Thiago Galvão faz ensaio sensual com bombeiros no Paparazzo.</a></li>
                -->
            </ul>
        </div>