<?php
// $Id: maintenance-page.tpl.php,v 1.4 2010/11/30 17:55:13 dries Exp $

/**
 * @file
 * Implementation to display a single Drupal page while offline.
 *
 * All the available variables are mirrored in page.tpl.php.
 *
 * @see template_preprocess()
 * @see template_preprocess_maintenance_page()
 * @see bartik_process_maintenance_page()
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
  <title><?php print $head_title; ?></title>
  <style type="text/css">
      body {
	margin:50px 0px; padding:0px;
	text-align:center;
      }

      #messages{
	width:500px;
	margin:0px auto;
	text-align:left;
	padding:15px;
	border:1px dashed #333;
	background-color:#eee;

        font-family: arial;
        font-size: 18px;
        color: red;
      }
  </style>
</head>
<body>
    <div>
        <img src="http://www.leiaja.com/aovivo/images/logo.png" />
          <div id="messages">
            <?php if ($content): ?>
              <p><?php print $content; ?></p>
            <?php endif; ?>
          </div>
    </div>
</body>
</html>