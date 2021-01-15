<?php
/*
 * @file
 * Theme file to handle HTML5 output.
 *
 * Variables passed.
 * $video is the video object.
 * $node is the node object.
 *
 * @TODO : Fallback to flash should be done nicely
 *
 */

$vWidth  = (!empty($_GET['width']) && is_numeric($_GET['width'])) ? $_GET['width'] : 625;
$vHeight = (!empty($_GET['width']) && is_numeric($_GET['height'])) ? $_GET['height'] : 352;
?>
<video width="<?= $vWidth ?>" autobuffer="<?php print $video->autobuffering; ?>" height="<?= $vHeight ?>" controls="controls" preload="auto" poster="<?php echo $video->thumbnail->url; ?>">
  <?php //dd($items); ?>
  <?php static $videojs_sources; ?>
  <?php $codecs = array('video/mp4' => 'avc1.42E01E, mp4a.40.2', 'video/webm' => 'vp8, vorbis', 'video/ogg' => 'theora, vorbis', 'application/ogg' => 'theora, vorbis', 'video/ogv' => 'theora, vorbis', 'video/quicktime' => 'avc1.42E01E, mp4a.40.2'); ?>
  <?php foreach ($video->files as $filetype => $file): ?>
  <?php $filepath = $file->url; ?>
  <?php $mimetype = file_get_mimetype($file->filepath); ?>
  <?php if (array_key_exists($mimetype, $codecs)): ?>
  <?php $mimetype = ($mimetype == 'video/quicktime') ? 'video/mp4' : $mimetype; ?>
  <?php if ($mimetype == 'video/mp4' || $mimetype == 'video/flv')
        $flash = $filepath; ?>
  <?php $videojs_sources .= "<source src=\"$filepath\" type='$mimetype; codecs=\"" . $codecs[$mimetype] . "\"' />"; ?>
  <?php endif; ?>
  <?php endforeach; ?>
  <?php print $videojs_sources; ?>
      <!-- Flash Fallback. Use any flash video player here. Make sure to keep the vjs-flash-fallback class. -->
  <?php $video->player = 'flv'; ?>
  <?php $video->files->flv->url = $flash; ?>
  <?php echo theme('video_flv', array('video' => $video)); ?>
</video>