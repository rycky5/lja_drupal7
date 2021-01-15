<?php
// $Id: search-result.tpl.php,v 1.9 2010/11/21 20:36:36 dries Exp $

/**
 * @file
 * Default theme implementation for displaying a single search result.
 *
 * This template renders a single search result and is collected into
 * search-results.tpl.php. This and the parent template are
 * dependent to one another sharing the markup for definition lists.
 *
 * Available variables:
 * - $url: URL of the result.
 * - $title: Title of the result.
 * - $snippet: A small preview of the result. Does not apply to user searches.
 * - $info: String of all the meta information ready for print. Does not apply
 *   to user searches.
 * - $info_split: Contains same data as $info, split into a keyed array.
 * - $module: The machine-readable name of the module (tab) being searched, such
 *   as "node" or "user".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Default keys within $info_split:
 * - $info_split['type']: Node type (or item type string supplied by module).
 * - $info_split['user']: Author of the node linked to users profile. Depends
 *   on permission.
 * - $info_split['date']: Last update of the node. Short formatted.
 * - $info_split['comment']: Number of comments output as "% comments", %
 *   being the count. Depends on comment.module.
 * - $info_split['upload']: Number of attachments output as "% attachments", %
 *   being the count. Depends on upload.module.
 *
 * Other variables:
 * - $classes_array: Array of HTML class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $title_attributes_array: Array of HTML attributes for the title. It is
 *   flattened into a string within the variable $title_attributes.
 * - $content_attributes_array: Array of HTML attributes for the content. It is
 *   flattened into a string within the variable $content_attributes.
 *
 * Since $info_split is keyed, a direct print of the item is possible.
 * This array does not apply to user searches so it is recommended to check
 * for its existence before printing. The default keys of 'type', 'user' and
 * 'date' always exist for node searches. Modules may provide other data.
 * @code
 *   <?php if (isset($info_split['comment'])) : ?>
 *     <span class="info-comment">
 *       <?php print $info_split['comment']; ?>
 *     </span>
 *   <?php endif; ?>
 * @endcode
 *
 * To check for all available data within $info_split, use the code below.
 * @code
 *   <?php print '<pre>'. check_plain(print_r($info_split, 1)) .'</pre>'; ?>
 * @endcode
 *
 * @see template_preprocess()
 * @see template_preprocess_search_result()
 * @see template_process()
 */

 $vThumbGrd = "";
 if(!empty($result['node']->field_capa)){ 
   $vThumbGrd = image_style_url('home_cadernos', $result['node']->field_capa["und"][0]["uri"]);
 }else if(!empty($result['node']->field_image)){
   $vThumbGrd = image_style_url('home_cadernos', $result['node']->field_image["und"][0]["uri"]);
 }else if(!empty($result['node']->field_imagem)){
   $vThumbGrd = image_style_url('home_cadernos', $result['node']->field_imagem["und"][0]["uri"]);
 }
 
 // Retirando as hash de marcação
$result['node']->body["und"][0]["value"] = str_replace("[@#podcast#@]", "", $result['node']->body["und"][0]["value"]);
$result['node']->body["und"][0]["value"] = str_replace("[@#video#@]",   "",  $result['node']->body["und"][0]["value"]);
$result['node']->body["und"][0]["value"] = str_replace("[@#galeria#@]", "",  $result['node']->body["und"][0]["value"]);
// echo "<pre>";
//var_dump($result['node']->body["und"][0]["summary"]);
//var_dump(strip_tags($result['node']->body["und"][0]["value"]));
//die;
?>

<li>
    <?php if(!empty ($vThumbGrd)){ ?>
        <div>
<!--            <a href="<?php print $url; ?>">-->
                <a  href="<?php print $url; ?>"><img src="<?= $vThumbGrd ?>" width="185" height="139"  /></a>
<!--            </a>-->
        </div>
    <?php } ?>
    <a href="<?php print $url; ?>">
        <?= $result['node']->title ?> 
    </a>
    <p>
        <a href="<?php print $url; ?>">
           <?= substr(!empty ($result['node']->body["und"][0]["summary"]) ? $result['node']->body["und"][0]["summary"] : strip_tags($result['node']->body["und"][0]["value"]), 0, 155) ?>
        </a>
    </p>
     <div class="legenda">
         <?php if(!empty($result['node']->field_image)){ ?>
             <span>
                 <img src="/<?= drupal_get_path('theme', 'agenda_recife') ?>/images/iconGaleria.png" />
             </span>
         <?php } ?>
         <?php if(!empty($result['node']->field_videost)){ ?>
             <span>
                 <img src="/<?= drupal_get_path('theme', 'agenda_recife') ?>/images/iconVideo.png" />
             </span>
         <?php } ?>
         <?php if(!empty($result['node']->field_audiost)){ ?>
             <span>
                 <img src="/<?= drupal_get_path('theme', 'agenda_recife') ?>/images/iconAudio.png" />
             </span>
         <?php } ?>
     </div>  
    
<!--    <div class="tagsExibir">
      <h5>Tags:</h5>
      <ul class="tags">
      <? foreach($result['node']->field_tags["und"] AS $key => $value){?>
        <li>
          <a href="<?=url(drupal_lookup_path('alias',"taxonomy/term/".$value['tid']));?>" title="<?=$value["taxonomy_term"]->name;?>">
            <?= $value["taxonomy_term"]->name;?>
          </a>
        </li>
      <? }?>
      </ul>
    </div>-->
</li>