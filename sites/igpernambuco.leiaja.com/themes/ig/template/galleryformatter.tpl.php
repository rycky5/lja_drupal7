<?php
// $Id: galleryformatter.tpl.php,v 1.4.2.2 2011/01/30 16:32:09 manuelgarcia Exp $
/**
 * @file
 * Template file for the galleryformatter default formatter
 */

/**
 * Only edit this file for switching order of the slides info, adding classes or other minor changes within the overall html structure.
 * KEEP the original html structure or you'll run into problems with the JS.
 * IDs on the slides and the hash for the thumb links MUST be there for the gallery to function.
 * width and height must be set inline for gallery-slides container, the gallery-thumbs, and the li's inside it.
 *
 * Available variables:
 *
 * $dimensions - Array containing both slides and thumbs dimensions
 * $gallery_slides - Array containing all slide images, a link to the original and its sanatized title & description ready to print
 * $thumbs - Array containing all thumbnail images ready to print
 * $link_to_full -  BOOLEAN wether or not we are linking slides to original images
 */


?>
<link type="text/css" media="all" href="<?= base_path(true) ?>/sites/all/themes/leiaja/css/spacegallery.css">
<div class="galleryformatter galleryview galleryformatter-<?php print $settings['style'] ?>">
  <div class="gallery-slides" style="width:625px; height:540px;">
    <div class="gallery-frame">
          
      <ul>    
      <?php foreach ($slides as $id => $data): ?>
        <li class="gallery-slide" id="<?php print $data['hash_id']; ?>">
          <?php print $data['image']; ?>
          <?php if (!empty($data['title'])): ?>
            <div class="panel-overlay">
              <div class="overlay-inner">
                <?php if ($data['title']): ?><h3><?php print $data['title']; ?></h3><?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
            <div class="creditoFoto">
            <span><?php if(!empty($data['alt'])) : ?>Foto: <?= $data['alt']; endif;?></span>
          </div>
        </li>
      <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <?php if(!empty($thumbs)): ?>
  <div class="gallery-thumbs" style="width:width:625px;height:70px;">
    <div class="wrapper">
      <ul>
        <?php foreach ($thumbs as $id => $data): ?>
          <li class="slide-<?php print $id; ?>" style="width:78px;"><a href="#<?php print $data['hash_id']; ?>"><?php print $data['image']; ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <?php endif; ?>
</div>
<script type="text/javascript">
(function ($) {
  $(document).ready(function () {
		$('.gallery-thumbs .active a').focus().click();
  });
})(jQuery);
</script>
